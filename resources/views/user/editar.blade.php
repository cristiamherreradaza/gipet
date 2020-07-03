@extends('layouts.app')

@section('content')
<form action="{{ url('User/actualizar') }}"  method="POST" >
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">EDICION DE USUARIO</h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="id" id="id" value="{{ $user->id }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Nombres</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="text" name="nombres" id="nombres" class="form-control" value="{{ $user->nombres }}" required>
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Apellido Paterno</label>                            
                                <input type="text" name="apellido_paterno" id="apellido_paterno" value="{{ $user->apellido_paterno }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Apellido Materno</label>                            
                                <input type="text" name="apellido_materno" id="apellido_materno" value="{{ $user->apellido_materno }}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Cedula de Identidad</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="text" name="ci" id="ci" class="form-control" value="{{ $user->cedula }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Expedido</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="expedido" id="expedido" class="form-control" required>
                                    @if($user->expedido == 'Beni')
                                        <option value="Beni" selected> Beni </option>
                                    @else
                                        <option value="Beni"> Beni </option>
                                    @endif
                                    @if($user->expedido == 'Chuquisaca')
                                        <option value="Chuquisaca" selected> Chuquisaca </option>
                                    @else
                                        <option value="Chuquisaca"> Chuquisaca </option>
                                    @endif
                                    @if($user->expedido == 'Cochabamba')
                                        <option value="Cochabamba" selected> Cochabamba </option>
                                    @else
                                        <option value="Cochabamba"> Cochabamba </option>
                                    @endif
                                    @if($user->expedido == 'La Paz')
                                        <option value="La Paz" selected> La Paz </option>
                                    @else
                                        <option value="La Paz"> La Paz </option>
                                    @endif
                                    @if($user->expedido == 'Oruro')
                                        <option value="Oruro" selected> Oruro </option>
                                    @else
                                        <option value="Oruro"> Oruro </option>
                                    @endif
                                    @if($user->expedido == 'Pando')
                                        <option value="Pando" selected> Pando </option>
                                    @else
                                        <option value="Pando"> Pando </option>
                                    @endif
                                    @if($user->expedido == 'Potosi')
                                        <option value="Potosi" selected> Potosi </option>
                                    @else
                                        <option value="Potosi"> Potosi </option>
                                    @endif
                                    @if($user->expedido == 'Santa Cruz')
                                        <option value="Santa Cruz" selected> Santa Cruz </option>
                                    @else
                                        <option value="Santa Cruz"> Santa Cruz </option>
                                    @endif
                                    @if($user->expedido == 'Tarija')
                                        <option value="Tarija" selected> Tarija </option>
                                    @else
                                        <option value="Tarija"> Tarija </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Nomina</label>
                                <select name="nomina" id="nomina" class="form-control"> 
                                    <option value=""></option>
                                    @if($user->nomina == 'Lic.')
                                        <option value="Lic." selected> Licenciado(a) </option>
                                    @else
                                        <option value="Lic."> Licenciado(a) </option>
                                    @endif
                                    @if($user->nomina == 'Ing.')
                                        <option value="Ing." selected> Ingeniero(a) </option>
                                    @else
                                        <option value="Ing."> Ingeniero(a) </option>
                                    @endif
                                    @if($user->nomina == 'Per.')
                                        <option value="Per." selected> Personal </option>
                                    @else
                                        <option value="Per."> Personal </option>
                                    @endif                                
                                    <!-- <option value="Sr(a)"> Señor(a) </option> -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Nombre de usuario</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="text" name="username" id="username" class="form-control" value="{{ $user->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Tipo</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="tipo" id="tipo" class="form-control" required>
                                    @if($user->tipo_usuario == 'Academico')
                                        <option value="Academico" selected> Academico </option>
                                    @else
                                        <option value="Academico"> Academico </option>
                                    @endif
                                    @if($user->tipo_usuario == 'Director')
                                        <option value="Director" selected> Director </option>
                                    @else
                                        <option value="Director"> Director </option>
                                    @endif
                                    @if($user->tipo_usuario == 'Docente')
                                        <option value="Docente" selected> Docente </option>
                                    @else
                                        <option value="Docente"> Docente </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Fecha de Nacimiento</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ $user->fecha_nacimiento }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Lugar de Nacimiento</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="lugar_nacimiento" id="lugar_nacimiento" class="form-control" required>
                                    <option value=""></option>
                                    @if($user->lugar_nacimiento == 'BENI')
                                        <option value="BENI" selected> Beni </option>
                                    @else
                                        <option value="BENI"> Beni </option>
                                    @endif
                                    @if($user->lugar_nacimiento == 'CHUQUISACA')
                                        <option value="CHUQUISACA" selected> Chuquisaca </option>
                                    @else
                                        <option value="CHUQUISACA"> Chuquisaca </option>
                                    @endif
                                    @if($user->lugar_nacimiento == 'COCHABAMBA')
                                        <option value="COCHABAMBA" selected> Cochabamba </option>
                                    @else
                                        <option value="COCHABAMBA"> Cochabamba </option>
                                    @endif
                                    @if($user->lugar_nacimiento == 'LA PAZ')
                                        <option value="LA PAZ" selected> La Paz </option>
                                    @else
                                        <option value="LA PAZ"> La Paz </option>
                                    @endif
                                    @if($user->lugar_nacimiento == 'ORURO')
                                        <option value="ORURO" selected> Oruro </option>
                                    @else
                                        <option value="ORURO"> Oruro </option>
                                    @endif
                                    @if($user->lugar_nacimiento == 'PANDO')
                                        <option value="PANDO" selected> Pando </option>
                                    @else
                                        <option value="PANDO"> Pando </option>
                                    @endif
                                    @if($user->lugar_nacimiento == 'POTOSI')
                                        <option value="POTOSI" selected> Potosi </option>
                                    @else
                                        <option value="POTOSI"> Potosi </option>
                                    @endif
                                    @if($user->lugar_nacimiento == 'SANTA CRUZ')
                                        <option value="SANTA CRUZ" selected> Santa Cruz </option>
                                    @else
                                        <option value="SANTA CRUZ"> Santa Cruz </option>
                                    @endif
                                    @if($user->lugar_nacimiento == 'TARIJA')
                                        <option value="TARIJA" selected> Tarija </option>
                                    @else
                                        <option value="TARIJA"> Tarija </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Sexo</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="sexo" id="sexo" class="form-control" required> 
                                    @if($user->sexo == 'Femenino')
                                        <option value="Femenino" selected> Femenino </option>
                                    @else
                                        <option value="Femenino"> Femenino </option>
                                    @endif
                                    @if($user->sexo == 'Masculino')
                                        <option value="Masculino" selected> Masculino </option>
                                    @else
                                        <option value="Masculino"> Masculino </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Estado Civil</label>
                                <select name="estado_civil" id="estado_civil" class="form-control">
                                    <option value="" selected></option>
                                    @if($user->estado_civil == 'Soltero(a)')
                                        <option value="Soltero(a)" selected> Soltero(a) </option>
                                    @else
                                        <option value="Soltero(a)"> Soltero(a) </option>
                                    @endif
                                    @if($user->estado_civil == 'Casado(a)')
                                        <option value="Casado(a)" selected> Casado(a) </option>
                                    @else
                                        <option value="Casado(a)"> Casado(a) </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Correo Electrónico</label>
                                <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}">
                            </div>                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Zona</label>
                                <input type="text" name="zona" id="zona" class="form-control" value="{{ $user->zona }}">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Dirección</label>                            
                                <input type="text" name="direccion" id="direccion" class="form-control" value="{{ $user->direccion }}">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Teléfono</label>                            
                                <input type="text" name="numero_fijo" id="numero_fijo" class="form-control" value="{{ $user->numero_fijo }}">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Celular</label>                            
                                <input type="text" name="celular" id="celular" class="form-control" value="{{ $user->numero_celular }}">
                            </div>                            
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Nombre Conyugue</label>
                                <input type="text" name="nombre_conyugue" id="nombre_conyugue" class="form-control" value="{{ $user->nombre_conyugue }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Nombre Hijo(a)</label>                            
                                <input type="text" name="nombre_hijo" id="nombre_hijo" class="form-control" value="{{ $user->nombre_hijo }}">
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Persona Referencia</label>                            
                                <input type="text" name="persona_referencia" id="persona_referencia" class="form-control" value="{{ $user->persona_referencia }}">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Numero Referencia</label>
                                <input type="text" name="numero_referencia" id="numero_referencia" class="form-control" value="{{ $user->numero_referencia }}">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Rol</label>
                                <select name="rol" id="rol" class="form-control">
                                    <option value="" selected></option>
                                    @if($user->rol == 'D')
                                        <option value="D" selected> D </option>
                                    @else
                                        <option value="D"> D </option>
                                    @endif
                                    <!-- <option value="">  </option> -->
                                </select>
                            </div>
                        </div>                                         
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar()">GUARDAR USUARIO</button>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</form>
@stop

@section('js')

<script>
    function guardar()
    {        
        
        var apellido_paterno = $("#apellido_paterno").val();
        var apellido_materno = $("#apellido_materno").val();
        var nombres = $("#nombres").val();
        //nomina
        //pass
        var ci = $("#ci").val();
        var expedido = $("#expedido").val();
        var tipo = $("#tipo").val();
        var username = $("#username").val();
        //fechaincorporacion
        //vigente
        //rol
        var fecha_nacimiento = $("#fecha_nacimiento").val();
        var lugar_nacimiento = $("#lugar_nacimiento").val();
        var sexo = $("#sexo").val();
        //estadocivil
        var nombre_conyugue = $("#nombre_conyugue").val();
        var nombre_hijo = $("#nombre_hijo").val();
        var direccion = $("#direccion").val();
        var zona = $("#zona").val();
        var celular = $("#celular").val();
        var numero_fijo = $("#numero_fijo").val();
        var email = $("#email").val();
        //foto
        var persona_referencia = $("#persona_referencia").val();
        var numero_referencia = $("#numero_referencia").val();
        if( nombres.length>0 && 
            ci.length>0 &&
            expedido.length>0 &&
            username.length>0 &&
            tipo.length>0 &&
            fecha_nacimiento.length>0 &&
            lugar_nacimiento.length>0 &&
            sexo.length>0){
                Swal.fire(
                    'Excelente!',
                    'Usuario actualizado.',
                    'success'
                )
        }else{
            //alert('hola');
            event.preventDefault();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Completa los puntos que estan marcados en rojo.'
            })
        }
    }
</script>
@endsection
