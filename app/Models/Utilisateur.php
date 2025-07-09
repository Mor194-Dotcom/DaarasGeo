<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

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


    public function notifications()
    {
        return $this->belongsToMany(Alerte::class, 'notifications')
            ->withPivot(['lu', 'date_envoi', 'est_critique'])
            ->withTimestamps();
    }
}
