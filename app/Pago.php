<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pago extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'persona_id',
        'servicio_id',
        'tipo_mensualidad_id',
        'descuento_persona_id',
        'a_pagar',
        'importe',
        'faltante',
        'total',
        'mensualidad',
        'fecha',
        'anio_vigente',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App/User', 'user_id');
    }

    public function persona()
    {
        return $this->belongsTo('App/Persona', 'persona_id');
    }

    public function servicio()
    {
        return $this->belongsTo('App/Servicio', 'servicio_id');
    }

    public function tipo()
    {
        return $this->belongsTo('App/TiposMensualidades', 'tipo_mensualidad_id');
    }

    public function descuento()
    {
        return $this->belongsTo('App/DescuentosPersona', 'descuento_persona_id');
    }


}
