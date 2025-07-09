<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    protected $fillable = ['statut', 'zone_id'];

    public function zone()
    {
        return $this->belongsTo(ZoneDelimitee::class, 'zone_id');
    }

    public function utilisateurs()
    {
        return $this->belongsToMany(Utilisateur::class, 'notifications')
            ->withPivot(['lu', 'date_envoi', 'est_critique'])
            ->withTimestamps();
    }
    public function zoneDelimitee()
    {
        return $this->belongsTo(ZoneDelimitee::class, 'zone_delimitee_id');
    }
}
