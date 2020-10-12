<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prerequisito extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'asignatura_id',
        'prerequisito_id',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura', 'asignatura_id');
    }

    public function prerequisito()
    {
        return $this->belongsTo('App\Asignatura', 'prerequisito_id');
    }

    // analizar en sistema, encontrar y cambiar a PREREQUISITO
    // public function materia()
    // {
    //     return $this->belongsTo('App\Asignatura', 'prerequisito_id');
    // }

}
