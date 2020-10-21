<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fecha extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
		'descripcion',
        'fecha_inicio',
        'fecha_fin',
		'periodo',
        'gestion',
        'anio_vigente',
		'estado',
		'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
