<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talibe extends Model
{
    protected $fillable = [
        'utilisateur_id',
        'date_naissance',
        'photo',
        'latitude',
        'longitude',
        'daara_id',
        'tuteur_id',
        'zone_id'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }
    public function daara()
    {
        return $this->belongsTo(Daara::class);
    }
    public function tuteur()
    {
        return $this->belongsTo(Tuteur::class);
    }
    public function zone()
    {
        return $this->belongsTo(ZoneDelimitee::class, 'zone_id');
    }
    public function historiques()
    {
        return $this->hasMany(Historique::class);
    }
}
