<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Predefinida extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'nota_asistencia',
        'nota_practicas',
        'nota_puntos_ganados',
        'nota_primer_parcial',
        'nota_examen_final',
        'fecha',
        'anio_vigente',
        'activo',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
