<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
	use SoftDeletes;
    protected $fillable = [
        'empresa_id',
		'dosificacion_id',
		'persona_id',
		'user_id',
		'razon_social',
		'nit',
		'fecha',
		'total',
		'gestion',
		'validado',
		'codigo_control',
		'estado',
		'deleted_at',
    ];
    
    public function empresa()
    {
        return $this->belongsTo('App\Empresa');
    }

    public function dosificacion()
    {
        return $this->belongsTo('App\Dosificacion');
    }

    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function detallesfacturas()
    {
        return $this->hasMany('App\DetallesFactura');
    }

}
