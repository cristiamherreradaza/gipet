<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarreraPersona extends Model
{
	protected $table = 'carreras_personas';
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

    // public function prerequisitos()
    // {
    //     return $this->hasMany('App\Prerequisito');
    // }
}
