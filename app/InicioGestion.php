<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InicioGestion extends Model
{
    use SoftDeletes;
    protected $table = 'inicio_gestion';

    protected $fillable = [
        'user_id',
        'carrera_id',
        'inicio',
        'fin',
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


}
