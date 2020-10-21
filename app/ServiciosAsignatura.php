<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiciosAsignatura extends Model
{
    protected $fillable = [
        'user_id',
        'asignatura_id',
        'servicio_id',
        'anio_vigente',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura');
    }

    public function servicio()
    {
        return $this->belongsTo('App\Servicio');
    }
}
