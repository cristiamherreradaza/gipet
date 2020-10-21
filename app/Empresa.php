<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
	use SoftDeletes;
    protected $fillable = [
		'user_id',
        'nombre',
		'direccion',
		'nit',
		'telefonos',
		'razon_social',
		'numero_autorizacion',
		'anio',
		'anio_vigente',
		'estado',
		'deleted_at',
    ];

	public function user()
    {
        return $this->hasMany('App\User', 'user_id');
    }

    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }
}
