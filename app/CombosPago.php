<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CombosPago extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'carrera_id',
        'servicio_id',
        'nombre',
        'anio_vigente',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function carrera()
    {
        return $this->belongsTo('App\Carrera', 'carrera_id');
    }

    public function servicio()
    {
        return $this->belongsTo('App\Servicio', 'servicio_id');
    }
}
