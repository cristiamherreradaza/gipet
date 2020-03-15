<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
    protected $fillable = [
        'persona_id',
        'asignatura_id',
        'carrera_id',
        'turno_id',
        'paralelo',
        'gestion',
        'aprobado',
    ];

    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura');
    }

    public function carrera()
    {
        return $this->belongsTo('App\Carrera');
    }

    public function turno()
    {
        return $this->belongsTo('App\Turno');
    }
}
