<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Turno extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'descripcion',
        'estado',
        'deleted_at',
    ];

    public function kardex()
    {
        return $this->hasMany('App\Kardex');
    }

    public function notas()
    {
        return $this->hasMany('App\Nota');
    }

    public function notaspropuestas()
    {
        return $this->hasMany('App\NotasPropuesta');
    }
    
    public function inscripcion()
    {
        return $this->hasMany('App\Inscripcion');
    }

    public function carreraspersona()
    {
        return $this->hasMany('App\CarrerasPersona');
    }
}
