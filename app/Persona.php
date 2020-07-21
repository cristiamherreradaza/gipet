<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'carnet',
        'expedido',
        'fecha_nacimiento',
        'sexo',
        'direccion',
        'telefono_fijo',
        'telefono_celular',
        'email',
        'trabaja',
        'empresa',
        'direccion_empresa',
        'telefono_empresa',
        'fax',
        'email_empresa',
        'nombre_padre',
        'celular_padre',
        'nombre_madre',
        'celular_madre',
        'nombre_tutor',
        'telefono_tutor',
        'nombre_esposo',
        'telefono_esposo',
        'estado',
        'borrado',
    ];

    public function kardex()
    {
        return $this->hasMany('App\Kardex');
    }

    public function notas()
    {
        return $this->hasMany('App\Nota');
    }

    public function transacciones()
    {
        return $this->hasMany('App/Transaccion');
    }
    
    public function descuentopersonas()
    {
        return $this->hasMany('App/DescuentoPersona');
    }

    public function carreraspersona()
    {
        return $this->hasMany('App\CarrerasPersona');
    }

    public function cobrostemporadas()
    {
        return $this->hasMany('App/CobrosTemporada');
    }
}
