<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Parametro extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'numero_autorizacion',
        'llave_dosificacion',
        'numero_factura',
		'fecha_limite',
		'estado',
    ];

}
