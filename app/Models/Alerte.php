<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    protected $fillable = [
        'statut',           // 'active', 'en_attente', 'resolue'
        'zone_id',
        'utilisateur_id',   // Talibé concerné
        'latitude',
        'longitude',
        'distance',
        'date'
    ];

    public function utilisateur() // Talibé ou source de l'alerte
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function zone()
    {
        return $this->belongsTo(ZoneDelimitee::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class); // vers destinataires
    }
}
