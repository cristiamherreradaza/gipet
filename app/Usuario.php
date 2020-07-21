<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'nomina',
        'codID',
        'cedula',
        'expedido',
        'tipo_usuario',
        'nombre_usuario',
        'fecha_incorporacion',
        'vigente',
        'rol',
        'fecha_nacimiento',
        'lugar_nacimiento',
        'sexo',
        'estado_civil',
        'nombre_conyugue',
        'nombre_hijo',
        'direccion',
        'zona',
        'numero_celular',
        'numero_fijo',
        'email',
        'foto',
        'persona_referencia',
        'numero_referencia',
        'estado',
        'deleted_at',
    ];

    public function notas()
    {
        return $this->hasMany('App\Nota');
    }
}
