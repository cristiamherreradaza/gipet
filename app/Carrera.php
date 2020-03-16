<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $fillable = [
        'nombre',
        'nivel',
        'semes',
        'gestion',
        'borrado',
    ];

    public function asignaturas()
    {
        return $this->hasMany('App\Asignatura');
    }

    public function kardex()
    {
        return $this->hasMany('App\Kardex');
    }
}
