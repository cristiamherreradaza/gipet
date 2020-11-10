<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inscripcione extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'resolucion_id',
        'carrera_id',
        'asignatura_id',
        'turno_id',
        'persona_id',
        'paralelo',
        'semestre',
        'gestion',
        'anio_vigente',
        'fecha_registro',
        'nota',
        'segundo_turno',
        'nota_aprobacion',
        'troncal',
        'aprobo',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function resolucion()
    {
        return $this->belongsTo('App\Resolucione', 'resolucion_id');
    }

    public function carrera()
    {
        return $this->belongsTo('App\Carrera', 'carrera_id');
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura', 'asignatura_id');
    }

    public function turno()
    {
        return $this->belongsTo('App\Turno', 'turno_id');
    }

    public function persona()
    {
        return $this->belongsTo('App\Persona', 'persona_id');
    }

    public function segundosturnos()
    {
        return $this->hasMany('App\SegundosTurno');
    }
}
