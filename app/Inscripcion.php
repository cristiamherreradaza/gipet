<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';

    protected $fillable = [
        'asignatura_id',
        'turno_id',
        'persona_id',
        'paralelo',
        'gestion',
        'fecha_inscripcion',
    ];



    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura');
    }

    public function turno()
    {
        return $this->belongsTo('App\Turno');
    }

    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }

    // public function persona()
    // {
    //     return $this->hasMany('App\Persona');
    // }
}
