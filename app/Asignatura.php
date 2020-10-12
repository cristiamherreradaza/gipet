<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asignatura extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'carrera_id',
        'gestion',
        'sigla',
        'nombre',
        'ciclo',
        'semestre',
        'carga_horaria_virtual',
        'carga_horaria',
        'teorico',
        'practico',
        'nivel',
        'periodo',
        'anio_vigente',
        'orden_impresion',
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
}
