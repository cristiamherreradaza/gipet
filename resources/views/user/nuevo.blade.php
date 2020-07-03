@extends('layouts.app')

@section('content')
<form action="{{ url('User/guarda') }}"  method="POST" >
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">NUEVO USUARIO</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Nombres</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="text" name="nombres" id="nombres" class="form-control" required>
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Apellido Paterno</label>                            
                                <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Apellido Materno</label>                            
                                <input type="text" name="apellido_materno" id="apellido_materno" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Cedula de Identidad</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="text" name="ci" id="ci" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Expedido</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="expedido" id="expedido" class="form-control" required>                               
                                    <option value="Beni"> Beni </option>
                                    <option value="Chuquisaca"> Chuquisaca </option>
                                    <option value="Cochabamba"> Cochabamba </option>
                                    <option value="La Paz" selected> La Paz </option>
                                    <option value="Oruro"> Oruro </option>
                                    <option value="Pando"> Pando </option>
                                    <option value="Potosi"> Potosi </option>
                                    <option value="Santa Cruz"> Santa Cruz </option>
                                    <option value="Tarija"> Tarija </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Nomina</label>
                                <select name="nomina" id="nomina" class="form-control"> 
                                    <option value="" selected></option>                              
                                    <option value="Lic."> Licenciado(a) </option>
                                    <option value="Ing."> Ingeniero(a) </option>
                                    <option value="Per."> Personal </option>
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
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Tipo</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="tipo" id="tipo" class="form-control" required>
                                    <option value="Academico" selected> Academico </option>                               
                                    <option value="Director"> Director </option>
                                    <option value="Docente"> Docente </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Fecha de Nacimiento</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Lugar de Nacimiento</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="lugar_nacimiento" id="lugar_nacimiento" class="form-control" required>
                                    <option value="" selected></option>
                                    <option value="BENI"> Beni </option>
                                    <option value="CHUQUISACA"> Chuquisaca </option>
                                    <option value="COCHABAMBA"> Cochabamba </option>
                                    <option value="LA PAZ"> La Paz </option>
                                    <option value="ORURO"> Oruro </option>
                                    <option value="PANDO"> Pando </option>
                                    <option value="POTOSI"> Potosi </option>
                                    <option value="SANTA CRUZ"> Santa Cruz </option>
                                    <option value="TARIJA"> Tarija </option>
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
                                    <option value="Femenino"> Femenino </option>
                                    <option value="Masculino" selected> Masculino </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Estado Civil</label>
                                <select name="estado_civil" id="estado_civil" class="form-control">
                                    <option value="" selected></option>
                                    <option value="Soltero(a)"> Soltero(a) </option>
                                    <option value="Casado(a)"> Casado(a) </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Correo Electrónico</label>
                                <input type="text" name="email" id="email" class="form-control" >
                            </div>                            
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Zona</label>
                                <input type="text" name="zona" id="zona" class="form-control">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Dirección</label>                            
                                <input type="text" name="direccion" id="direccion" class="form-control">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Teléfono</label>                            
                                <input type="text" name="numero_fijo" id="numero_fijo" class="form-control">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Celular</label>                            
                                <input type="text" name="celular" id="celular" class="form-control">
                            </div>                            
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Nombre Conyugue</label>
                                <input type="text" name="nombre_conyugue" id="nombre_conyugue" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Nombre Hijo(a)</label>                            
                                <input type="text" name="nombre_hijo" id="nombre_hijo" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Persona Referencia</label>                            
                                <input type="text" name="persona_referencia" id="persona_referencia" class="form-control">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Numero Referencia</label>
                                <input type="text" name="numero_referencia" id="numero_referencia" class="form-control">
                            </div>                            
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Rol</label>
                                <select name="rol" id="rol" class="form-control">
                                    <option value="" selected></option>
                                    <option value="D"> Docente </option>
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
                    'Un nuevo usuario fue registrado.',
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
