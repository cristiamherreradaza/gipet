<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaccion extends Model
{
    use SoftDeletes;
    protected $table = 'transacciones';
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

    public function cobrotemporada()
    {
        return $this->belongsTo('App/CobrosTemporada');
    }
}
