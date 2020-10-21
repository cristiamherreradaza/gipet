<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaccione extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'servicio_id',
        'descuento_id',
        'persona_id',
        'cobros_temporadas_id',
        'fecha_pago',
        'estimado',
        'a_pagar',
        'pagado',
        'saldo',
        'observacion',
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

    public function descuento()
    {
        return $this->belongsTo('App/Descuento', 'descuento_id');
    }

    public function persona()
    {
        return $this->belongsTo('App/Persona', 'persona_id');
    }

    public function cobrotemporada()
    {
        return $this->belongsTo('App/CobrosTemporada', 'cobros_temporadas_id');
    }
}
