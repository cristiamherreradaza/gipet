<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Servicio extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'sigla',
        'nombre',
        'precio',
        'gestion',
        'anio_vigente',
        'estado',
        'deleted_at',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function descuentos()
    {
        return $this->hasMany('App\Descuento');
    }

    public function transacciones()
    {
        return $this->hasMany('App\Transaccion');
    }

    public function descuentopersonas()
    {
        return $this->hasMany('App\DescuentoPersona');
    }

    public function cobrostemporadas()
    {
        return $this->hasMany('App\CobrosTemporada');
    }
}
