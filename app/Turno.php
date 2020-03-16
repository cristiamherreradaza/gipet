<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    protected $fillable = [
        'descripcion',
        'borrado',
    ];

    public function kardex()
    {
        return $this->hasMany('App\Kardex');
    }

    public function notas()
    {
        return $this->hasMany('App\Nota');
    }
}
