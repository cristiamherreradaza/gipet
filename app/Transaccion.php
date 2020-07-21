<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $fillable = [
        'servicio_id',
        'descuento_id',
        'persona_id',
        'cobros_temporada_id',
        'fecha_pago',
        'estimado',
        'a_pagar',
        'pagado',
        'saldo',
        'observacion',
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

    public function cobrotemporada()
    {
        return $this->belongsTo('App/CobrosTemporada');
    }
}
