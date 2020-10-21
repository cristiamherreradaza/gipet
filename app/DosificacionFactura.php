<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DosificacionFactura extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'inicio',
		'final',
		'fecha_inicio',
		'fecha_final',
		'fecha_registro',
		'tiempo',
		'llave_dosificacion',
		'nit_empresa',
        'autorizacion_empresa',
        'anio_vigente',
		'estado',
		'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }
}
