<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $fillable = [
        'servicio_id',
        'nombre',
        'porcentaje',
        'monto',
        'a_pagar',
        'estado',
        'borrado',
    ];

    public function servicio()
    {
        return $this->belongsTo('App/Servicio');
    }
}
