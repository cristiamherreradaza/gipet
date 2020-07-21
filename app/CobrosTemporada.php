<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CobrosTemporada extends Model
{
    protected $fillable = [
        'servicio_id',
        'persona_id',
        'nombre',
        'mensualidad',
        'gestion',
        'fecha_generado',
        'estado',
        'borrado',
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
