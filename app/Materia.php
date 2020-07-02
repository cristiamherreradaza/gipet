<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $fillable = [
        'asignatura_id',
        'codigo_asignatura',
        'nombre_asignatura',
        'estado',
        'borrado',
    ];
}
