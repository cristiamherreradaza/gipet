<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequisitosCertificado extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'certificado_id',
        'asignatura_id',
        'anio_vigente',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function certificado()
    {
        return $this->belongsTo('App\Certificado', 'certificado_id');
    }

    public function asignatura()
    {
        return $this->belongsTo('App\Asignatura', 'asignatura_id');
    }
}
