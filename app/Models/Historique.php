<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historique extends Model
{
    protected $fillable = ['talibe_id', 'date', 'latitude', 'longitude'];

    public function talibe()
    {
        return $this->belongsTo(Talibe::class);
    }
}
