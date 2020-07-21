<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'sigla',
        'nombre',
        'precio',
        'gestion',
        'estado',
        'deleted_at',
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

    public function cobrostemporadas()
    {
        return $this->hasMany('App/CobrosTemporada');
    }
}
