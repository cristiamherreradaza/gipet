<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'sigla',
        'nombre',
        'precio',
        'gestion',
        'estado',
        'borrado',
    ];
    
    public function descuentos()
    {
        return $this->hasMany('App/Descuento');
    }

    public function transacciones()
    {
        return $this->hasMany('App/Transaccion');
    }

    public function descuentopersonas()
    {
        return $this->hasMany('App/DescuentoPersona');
    }
}
