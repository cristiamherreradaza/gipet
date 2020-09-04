<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prerequisito extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'asignatura_id',
        'prerequisito_id',
        'estado',
        'deleted_at',
    ];

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura', 'asignatura_id');
    }

    public function materia()
    {
        return $this->belongsTo('App\Asignatura', 'prerequisito_id');
    }

}
