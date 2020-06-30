<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotasPropuesta extends Model
{
    protected $fillable = [
        'asignatura_id',
        'turno_id',
        'user_id',
        'paralelo',
        'anio_vigente',
        'fecha',
        'nota_asistencia',
        'nota_practicas',
        'nota_puntos_ganados',
        'nota_primer_parcial',
        'nota_examen_final',
        'validado',
        'vigente',
        'estado',
        'borrado',
    ];

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura' );
    }

    public function turno()
    {
        return $this->belongsTo('App\Turno');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}