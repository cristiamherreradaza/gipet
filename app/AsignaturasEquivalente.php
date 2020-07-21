<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsignaturasEquivalente extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'carrera_id_1',
        'asignatura_id_1',
        'carrera_id_2',
        'asignatura_id_2',
        'anio_vigente',
        'estado',
        'deleted_at',
    ];

    public function carrera()
    {
        return $this->belongsTo('App\Carrera');
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura');
    }

}
