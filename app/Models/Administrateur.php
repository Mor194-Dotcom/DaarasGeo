<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrateur extends Model
{
    protected $fillable = ['utilisateur_id', 'email', 'mot_de_passe', 'telephone'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }
}
