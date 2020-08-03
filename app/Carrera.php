<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carrera extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nombre',
        'nivel',
        'semes',
        'gestion',
        'estado',
        'deleted_at',
    ];

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
