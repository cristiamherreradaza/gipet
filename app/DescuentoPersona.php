<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescuentoPersona extends Model
{
    protected $fillable = [
        'servicio_id',
        'descuento_id',
        'persona_id',
        'kardex_id',
        'numero_mensualidad',
        'a_pagar',
        'estado',
        'borrado',
    ];

    public function servicio()
    {
        return $this->belongsTo('App/Servicio');
    }

    public function descuento()
    {
        return $this->belongsTo('App/Descuento');
    }

    public function persona()
    {
        return $this->belongsTo('App/Persona');
    }

    public function kardex()
    {
        return $this->belongsTo('App/Kardex');
    }
}
