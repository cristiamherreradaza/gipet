<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $fillable = [
        'servicio_id',
        'persona_id',
        'kardex_id',
        'fecha',
        'monto',
        'saldo',
        'pendiente',
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

    public function kardex()
    {
        return $this->belongsTo('App/Kardex');
    }
}
