<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallesFactura extends Model
{
    
	use SoftDeletes;
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
