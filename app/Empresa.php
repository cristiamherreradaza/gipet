<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
	use SoftDeletes;
    protected $fillable = [
        'nombre',
		'direccion',
		'nit',
		'telefonos',
		'razon_social',
		'numero_autorizacion',
		'anio',
		'estado',
		'deleted_at',
    ];

    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }
    


}
