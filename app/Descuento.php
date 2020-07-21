<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    protected $fillable = [
        'servicio_id',
        'nombre',
        'descripcion',
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

    public function descuentopersonas()
    {
        return $this->hasMany('App/DescuentoPersona');
    }

    public function transacciones()
    {
        return $this->hasMany('App/Transaccion');
    }
}
