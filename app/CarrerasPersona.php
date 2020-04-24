<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarrerasPersona extends Model
{
	protected $fillable = [
        'carrera_id',
        'persona_id',
        'turno_id',
        'anio_vigente',
        'sexo',
        'estado',
        'borrado',
    ];

    public function carrera()
    {
        return $this->belongsTo('App\Carrera');
    }

    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }

    public function turno()
    {
        return $this->belongsTo('App\Turno');
    }

}
