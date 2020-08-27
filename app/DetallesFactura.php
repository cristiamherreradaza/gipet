<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetallesFactura extends Model
{
    
	use SoftDeletes;
    protected $table = 'detalle_facturas';
    protected $fillable = [
        'factura_id',
		'transaccion_id',
		'deleted_at',
    ];

    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }

    public function transaccion()
    {
        return $this->belongsTo('App\Transaccion');
    }
}
