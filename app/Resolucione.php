<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resolucione extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'resolucion',
        'nota_aprobacion',
        'anio_vigente',
        'semestre',
        'estado',
        'deleted_at',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
