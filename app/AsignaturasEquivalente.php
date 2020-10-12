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

    public function carrera_a()
    {
        return $this->belongsTo('App\Carrera', 'carrera_id_1');
    }

    public function asignatura_a()
    {
        return $this->belongsTo('App\Asignatura', 'asignatura_id_1');
    }

    public function carrera_b()
    {
        return $this->belongsTo('App\Carrera', 'carrera_id_2');
    }

    public function asignatura_b()
    {
        return $this->belongsTo('App\Asignatura', 'asignatura_id_2');
    }
}
