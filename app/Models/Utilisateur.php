<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateurs';
    protected $fillable = [
        'nom',
        'prenom',
        'adresse',
        'email',
        'password',
        'role_enum_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function responsableDaara()
    {
        return $this->hasOne(\App\Models\ResponsableDaara::class, 'utilisateur_id');
    }

    public function administrateur()
    {
        return $this->hasOne(\App\Models\Administrateur::class, 'utilisateur_id');
    }
    public function tuteur()
    {
        return $this->hasOne(\App\Models\Tuteur::class, 'utilisateur_id');
    }


    public function role()
    {
        return $this->belongsTo(RoleEnum::class, 'role_enum_id');
    }
    public function isAdmin()
    {
        return $this->role_enum_id === 4;
    }

    public function isResponsable()
    {
        return $this->role_enum_id === 2;
    }

    public function isTuteur()
    {
        return $this->role_enum_id === 1;
    }
    public function getNumeroValide(): ?string
    {
        if ($this->telephone && preg_match('/^\+2217\d{7}$/', $this->telephone)) {
            return $this->telephone;
        }

        if ($this->isTuteur() && optional($this->tuteur)->telephone) {
            return $this->tuteur->telephone;
        }

        if ($this->isResponsable() && optional($this->responsableDaara)->telephone) {
            return $this->responsableDaara->telephone;
        }

        if ($this->isAdmin() && optional($this->administrateur)->telephone) {
            return $this->administrateur->telephone;
        }

        return null;
    }


    public function notifications()
    {
        return $this->belongsToMany(Alerte::class, 'notifications')
            ->withPivot(['lu', 'date_envoi', 'est_critique'])
            ->withTimestamps();
    }
}
