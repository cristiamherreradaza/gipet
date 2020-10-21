<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleFactura extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'factura_id',
        'transaccion_id',
        'anio_vigente',
        'estado',
		'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function factura()
    {
        return $this->belongsTo('App\Factura', 'factura_id');
    }

    public function transaccion()
    {
        return $this->belongsTo('App\Transaccion', 'transaccion_id');
    }
}
