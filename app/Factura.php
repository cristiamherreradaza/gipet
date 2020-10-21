<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
	use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'empresa_id',
		'dosificacion_id',
		'persona_id',
		'razon_social',
		'nit',
		'fecha',
		'total',
		'gestion',
		'validado',
        'codigo_control',
        'anio_vigente',
		'estado',
		'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'empresa_id');
    }

    public function dosificacion()
    {
        return $this->belongsTo('App\Dosificacion', 'dosificacion_id');
    }

    public function persona()
    {
        return $this->belongsTo('App\Persona', 'persona_id');
    }

    public function detallesfacturas()
    {
        return $this->hasMany('App\DetallesFactura');
    }

}
