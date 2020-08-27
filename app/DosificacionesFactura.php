<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DosificacionesFactura extends Model
{
    
	use SoftDeletes;
	protected $table = 'dosificacion_facturas';
    protected $fillable = [
        'inicio',
		'final',
		'fecha_inicio',
		'fecha_final',
		'fecha_registro',
		'tiempo',
		'llave_dosificacion',
		'nit_empresa',
		'autorizacion_empresa',
		'estado',
		'deleted_at',
    ];

    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }
}
