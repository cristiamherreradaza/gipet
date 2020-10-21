<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'codigo_anterior',
        'user_id',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'cedula',
        'expedido',
        'fecha_nacimiento',
        'sexo',
        'direccion',
        'numero_fijo',
        'numero_celular',
        'email',
        'trabaja',
        'empresa',
        'direccion_empresa',
        'numero_empresa',
        'fax',
        'email_empresa',
        'nombre_padre',
        'celular_padre',
        'nombre_madre',
        'celular_madre',
        'nombre_tutor',
        'celular_tutor',
        'nombre_pareja',
        'celular_pareja',
        'anio_vigente',
        'estado',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
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

    public function segundosturnos()
    {
        return $this->hasMany('App\SegundosTurno');
    }
}
