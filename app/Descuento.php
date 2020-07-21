<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Descuento extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'servicio_id',
        'nombre',
        'descripcion',
        'porcentaje',
        'monto',
        'a_pagar',
        'estado',
        'deleted_at',
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
