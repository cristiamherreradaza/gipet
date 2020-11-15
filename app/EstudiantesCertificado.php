<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstudiantesCertificado extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'certificado_id',
        'persona_id',
        'fecha',
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

    public function estudiante()
    {
        return $this->belongsTo('App\Persona', 'persona_id');
    }
}
