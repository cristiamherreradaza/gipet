<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prerequisito extends Model
{
    protected $fillable = [
        'asignatura_id',
        'prerequisito_id',
        'borrado',
    ];

    // public function asignatura()
    // {
    //     return $this->belongsTo('App\Asignatura');
    // }


}
