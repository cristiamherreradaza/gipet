<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrera extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'resolucion_id',
        'nombre',
        'nivel',
        'duracion_anios',
        'semestre',
        'gestion',
        'anio_vigente',
        'nota_aprobacion',
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

    public function asignaturas()
    {
        return $this->hasMany('App\Asignatura');
    }

    public function kardex()
    {
        return $this->hasMany('App\Kardex');
    }

    public function carreraspersona()
    {
        return $this->hasMany('App\CarrerasPersona');
    }

    public function inscripcion()
    {
        return $this->hasMany('App\Inscripcion');
    }
    
    public function segundosturnos()
    {
        return $this->hasMany('App\SegundosTurno');
    }
}
