<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Notification extends Pivot
{
    protected $table = 'notifications';

    protected $fillable = ['utilisateur_id', 'alerte_id', 'lu', 'date_envoi', 'est_critique'];
}
