<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CobrosTemporada extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'carrera_id',
        'asignatura_id',
        'servicio_id',
        'persona_id',
        'nombre',
        'mensualidad',
        'gestion',
        'fecha_generado',
        'nombre_combo',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App/User', 'user_id');
    }

    public function carrera()
    {
        return $this->belongsTo('App/Carrera', 'carrera_id');
    }

    public function asignatura()
    {
        return $this->belongsTo('App/Asignatura', 'asignatura_id');
    }

    public function servicio()
    {
        return $this->belongsTo('App/Servicio', 'servicio_id');
    }

    public function persona()
    {
        return $this->belongsTo('App/Persona', 'persona_id');
    }

    public function transacciones()
    {
        return $this->hasMany('App/Transaccion');
    }
}
