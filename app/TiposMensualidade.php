<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TiposMensualidade extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'servicio_id',
        'nombre',
        'numero_maximo',
        'anio_vigente',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function servicio()
    {
        return $this->belongsTo('App\Servicio', 'servicio_id');
    }

    public function descuentos_persona()
    {
        return $this->hasMany('App\DescuentosPersona');
    }


}
