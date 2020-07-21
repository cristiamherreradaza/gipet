<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarreraPersona extends Model
{
    use SoftDeletes;
	protected $table = 'carreras_personas';
    protected $fillable = [
        'carrera_id',
		'persona_id',
		'turno_id',
		'anio_vigente',
		'sexo',
        'estado',
        'deleted_at',

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
