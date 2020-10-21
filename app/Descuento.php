<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Descuento extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'servicio_id',
        'nombre',
        'descripcion',
        'porcentaje',
        'monto',
        'a_pagar',
        'anio_vigente',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App/User', 'user_id');
    }

    public function servicio()
    {
        return $this->belongsTo('App/Servicio', 'servicio_id');
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
