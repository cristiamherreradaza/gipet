<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asignatura extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'carrera_id',
        'gestion',
        'codigo_asignatura',
        'nombre_asignatura',
        'carga_horaria',
        'teorico',
        'practico',
        'nivel',
        'semestre',
        'periodo',
        'anio_vigente',
        'orden_impresion',
        'ciclo',
        'estado',
        'deleted_at',
    ];

    public function carrera()
    {
        return $this->belongsTo('App\Carrera');
    }

    public function kardex()
    {
        return $this->hasMany('App\Kardex');
    }

    public function notas()
    {
        return $this->hasMany('App\Nota');
    }

    public function notaspropuestas()
    {
        return $this->hasMany('App\NotasPropuesta');
    }

    public function segundosturnos()
    {
        return $this->hasMany('App\SegundosTurno');
    }

    // public function prerequisitos()
    // {
    //     return $this->hasMany('App\Prerequisito');
    // }
}
