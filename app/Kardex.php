<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kardex extends Model
{
    use SoftDeletes;
    protected $table = 'kardex';

    protected $fillable = [
        'persona_id',
        'asignatura_id',
        'carrera_id',
        'turno_id',
        'paralelo',
        'gestion',
        'aprobado',
        'anio_aprobado',
        'curricular',
        'anio_registro',
        'estado',
        'deleted_at',
    ];

    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura');
    }

    public function carrera()
    {
        return $this->belongsTo('App\Carrera');
    }

    public function turno()
    {
        return $this->belongsTo('App\Turno');
    }

    public function transacciones()
    {
        return $this->hasMany('App/Transaccion');
    }
    
    public function descuentopersonas()
    {
        return $this->hasMany('App/DescuentoPersona');
    }
}
