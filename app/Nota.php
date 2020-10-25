<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'resolucion_id',
        'inscripcion_id',
        'docente_id',
        'persona_id',
        'asignatura_id',
        'turno_id',       
        'paralelo',
        'anio_vigente',
        'semestre',
        'trimestre',
        'fecha_registro',
        'convalidado',
        'nota_asistencia',
        'nota_practicas',
        'nota_puntos_ganados',
        'nota_primer_parcial',
        'nota_examen_final',
        'nota_total',
        'segundo_turno',
        'nota_aprobacion',
        'validado',
        'registrado',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function inscripcion()
    {
        return $this->belongsTo('App\Inscripcione', 'inscripcion_id');
    }

    public function docente()
    {
        return $this->belongsTo('App\User', 'docente_id');
    }

    public function persona()
    {
        return $this->belongsTo('App\Persona', 'persona_id');
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura', 'asignatura_id');
    }

    public function turno()
    {
        return $this->belongsTo('App\Turno', 'turno_id');
    }
}
