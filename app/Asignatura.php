<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
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
        'estado',
        'borrado',
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

    // public function prerequisitos()
    // {
    //     return $this->hasMany('App\Prerequisito');
    // }
}
