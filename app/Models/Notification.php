<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'contenu',
        'vue',
        'est_critique',
        'date_envoi',
        'utilisateur_id', // destinataire
        'alerte_id'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function alerte()
    {
        return $this->belongsTo(Alerte::class);
    }
}
