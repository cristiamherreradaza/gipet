<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CobrosTemporada extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'servicio_id',
        'persona_id',
        'carrera_id',
        'asignatura_id',
        'nombre',
        'mensualidad',
        'gestion',
        'fecha_generado',
        'nombre_combo',
        'estado',
        'deleted_at',
    ];

    public function servicio()
    {
        return $this->belongsTo('App/Servicio');
    }

    public function persona()
    {
        return $this->belongsTo('App/Persona');
    }

    public function transacciones()
    {
        return $this->hasMany('App/Transaccion');
    }
}
