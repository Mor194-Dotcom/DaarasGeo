<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tuteur extends Model
{
    protected $fillable = ['utilisateur_id', 'type_tuteur', 'email', 'mot_de_passe', 'telephone'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function talibes()
    {
        return $this->hasMany(Talibe::class);
    }
}
