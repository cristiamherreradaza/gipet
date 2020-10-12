<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo_anterior',
        'perfil_id',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'nomina',
        'password',
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
        'name',
        'estado',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function perfil()
    {
        return $this->belongsTo('App\Perfile', 'perfil_id');
    }

    public function notas()
    {
        return $this->hasMany('App\Nota');
    }

    public function notaspropuestas()
    {
        return $this->hasMany('App\NotasPropuesta');
    }

    public function menususers()
    {
        return $this->hasMany('App\MenusUser');
    }

    
}
