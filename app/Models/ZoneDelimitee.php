<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoneDelimitee extends Model
{
    protected $table = 'zones_delimitees';
    protected $fillable = ['latitude', 'longitude', 'rayon', 'daara_id'];

    public function talibes()
    {
        return $this->hasMany(Talibe::class, 'zone_id');
    }

    public function alertes()
    {
        return $this->hasMany(Alerte::class, 'zone_id');
    }
    public function daara()
    {
        return $this->belongsTo(Daara::class, 'daara_id');
    }
}
