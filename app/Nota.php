<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $fillable = [
        'asignatura_id',
        'turno_id',
        'user_id',        
        'persona_id',      
        'convalidado',
        'paralelo',
        'anio_vigente',
        'nota_asistencia',
        'nota_practicas',
        'nota_puntos_ganados',
        'nota_primer_parcial',
        'nota_examen_final',
        'nota_segundo_turno',
        'nota_total',
        'validado',
        'registrado',
        'estado',
        'borrado',
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
