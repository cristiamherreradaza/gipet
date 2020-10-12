<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materia extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'asignatura_id',
        'codigo_asignatura',
        'nombre_asignatura',
        'estado',
        'deleted_at',
    ];
}
