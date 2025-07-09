<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsableDaara extends Model
{
    protected $fillable = ['utilisateur_id', 'email', 'mot_de_passe', 'telephone'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function daaras()
    {
        return $this->hasMany(Daara::class, 'responsable_id');
    }
}
