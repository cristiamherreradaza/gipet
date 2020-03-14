<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $fillable = [
        'nom_carrera', 'desc_niv', 'semes',
    ];
}
