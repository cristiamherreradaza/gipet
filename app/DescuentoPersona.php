<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescuentoPersona extends Model
{
    protected $fillable = [
        'servicio_id',
        'descuento_id',
        'persona_id',
        'kardex_id',
        'numero_mensualidad',
        'a_pagar',
        'estado',
        'borrado',
    ];

}
