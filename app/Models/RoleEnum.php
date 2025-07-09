<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleEnum extends Model
{
    public $timestamps = false;

    protected $fillable = ['libelle'];

    public function utilisateurs()
    {
        return $this->hasMany(Utilisateur::class);
    }
}
