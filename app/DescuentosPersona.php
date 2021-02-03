<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DescuentosPersona extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'persona_id',
        'servicio_id',
        'descuento_id',
        'numero_mensualidad',
        'a_pagar',
        'anio_vigente',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function persona()
    {
        return $this->belongsTo('App\Persona', 'persona_id');
    }

    public function servicio()
    {
        return $this->belongsTo('App\Servicio', 'servicio_id');
    }

    public function descuento()
    {
        return $this->belongsTo('App\Descuento', 'descuento_id');
    }

    public function carrera()
    {
        return $this->belongsTo('App\Carrera', 'carrera_id');
    }

    public function tipo_mensualidad()
    {
        return $this->belongsTo('App\TiposMensualidade', 'tipos_mensualidades_id');
    }


}
