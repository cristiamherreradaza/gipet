<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'asignatura_id',
        'turno_id',
        'user_id',        
        'persona_id',      
        'convalidado',
        'paralelo',
        'anio_vigente',
        'semestre',
        'trimestre',
        'fecha_registro',
        'nota_asistencia',
        'nota_practicas',
        'nota_puntos_ganados',
        'nota_primer_parcial',
        'nota_examen_final',
        'nota_total',
        'segundo_turno',
        'validado',
        'registrado',
        'estado',
        'deleted_at',
    ];

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura');
    }

    public function turno()
    {
        return $this->belongsTo('App\Turno');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }
}
