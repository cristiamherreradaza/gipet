<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaPropuesta extends Model
{
    protected $fillable = [
        'asignatura_id',
        'turno_id',
        'user_id',
        'paralelo',
        'gestion',
        'fecha',
        'nota_asistencia',
        'nota_practicas',
        'nota_puntos_ganados',
        'nota_primer_parcial',
        'nota_examen_final',
        'validado',
        'registrado',
        'estado',
        'borrado',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
