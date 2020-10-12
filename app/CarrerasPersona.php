<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarrerasPersona extends Model
{
    use SoftDeletes;
	protected $fillable = [
        'user_id',
        'carrera_id',
        'persona_id',
        'turno_id',
        'paralelo',
        'anio_vigente',
        'sexo',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function carrera()
    {
        return $this->belongsTo('App\Carrera', 'carrera_id');
    }

    public function persona()
    {
        return $this->belongsTo('App\Persona', 'persona_id');
    }

    public function turno()
    {
        return $this->belongsTo('App\Turno', 'turno_id');
    }

}
