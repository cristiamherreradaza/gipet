<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DescuentoPersona extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'servicio_id',
        'descuento_id',
        'persona_id',
        'kardex_id',
        'numero_mensualidad',
        'a_pagar',
        'estado',
        'deleted_at',
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
