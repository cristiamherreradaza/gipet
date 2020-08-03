<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SegundosTurno extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'inscripcion_id',
        'carrera_id',
        'asignatura_id',
        'persona_id',
        'turno_id',
        'fecha_examen',
        'carnet',
        'nota_examen',
        'validado',
        'estado',
        'deleted_at',
    ];

    public function inscripcion()
    {
        return $this->belongsTo('App\Inscripcion', 'inscripcion_id');
    }

    public function carrera()
    {
        return $this->belongsTo('App\Carrera', 'carrera_id');
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura', 'asignatura_id');
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
