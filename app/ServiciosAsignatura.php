<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiciosAsignatura extends Model
{
    protected $fillable = [
        'asignatura_id',
        'servicio_id',
        'deleted_at',
    ];

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura');
    }

    public function servicio()
    {
        return $this->belongsTo('App\Servicio');
    }
}
