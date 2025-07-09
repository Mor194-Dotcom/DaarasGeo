<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daara extends Model
{
    protected $fillable = ['nom', 'adresse', 'latitude', 'longitude', 'responsable_id'];

    public function responsable()
    {
        return $this->belongsTo(ResponsableDaara::class, 'responsable_id');
    }

    public function talibes()
    {
        return $this->hasMany(Talibe::class);
    }
    public function zone()
    {
        return $this->hasOne(ZoneDelimitee::class, 'daara_id');
    }
}
