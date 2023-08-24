@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            USUARIOS &nbsp;&nbsp;
            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nuevo_usuario()"><i class="fas fa-plus"></i> &nbsp; NUEVO USUARIO</button>
            <button type="button" class="btn waves-effect waves-light btn-sm btn-success" onclick="verMaterias()"><i class="fas fa-book"></i> &nbsp; ASIGNATURAS DOCENTES</button>
        </h4>
    </div>
    <div class="card-body" id="lista">
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre de usuario</th>
                        <th>Perfil</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>CI</th>
                        <th>Celular</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $key => $usuario)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->perfil->nombre }}</td>
                            <td>{{ $usuario->nombres }}</td>
                            <td>{{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</td>
                            <td>{{ $usuario->cedula }}</td>
                            <td>{{ $usuario->celulares }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" title="Editar usuario"  onclick="editar('{{ $usuario->id }}', '{{ $usuario->nombres }}', '{{ $usuario->apellido_paterno }}', '{{ $usuario->apellido_materno }}', '{{ $usuario->cedula }}', '{{ $usuario->expedido }}', '{{ $usuario->estado_civil }}', '{{ $usuario->sexo }}', '{{ $usuario->fecha_nacimiento }}', '{{ $usuario->lugar_nacimiento }}', '{{ $usuario->name }}', '{{ $usuario->email }}', '{{ $usuario->perfil_id }}', '{{ $usuario->zona }}', '{{ $usuario->direccion }}', '{{ $usuario->numero_fijo }}', '{{ $usuario->numero_celular }}', '{{ $usuario->nombre_conyugue }}', '{{ $usuario->nombre_hijo }}', '{{ $usuario->persona_referencia }}', '{{ $usuario->numero_referencia }}', '{{ $usuario->codigo_punto_venta }}')"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-primary" title="Asignar materias"  onclick="asignar('{{ $usuario->id }}')"><i class="fas fa-plus-circle"></i></button>
                                <button type="button" class="btn btn-secondary" title="Editar permisos"  onclick="permisos('{{ $usuario->id }}', '{{ $usuario->perfil_id }}')"><i class="fas fa-list"></i></button>
                                <button type="button" class="btn btn-info" title="Cambiar contraseña"  onclick="contrasena({{ $usuario->id }})"><i class="fas fa-key"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar usuario"  onclick="eliminar('{{ $usuario->id }}', '{{ $usuario->name }}')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- inicio modal nuevo usuario -->
<div id="modal_usuarios" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">NUEVO USUARIO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('User/guarda') }}"  method="POST" >
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Nombres</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="text" name="nombres" id="nombres" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Apellido Paterno</label>
                                <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Apellido Materno</label>
                                <input type="text" name="apellido_materno" id="apellido_materno" class="form-control">
                            </div>
                        </div>


                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Nomina</label>
                                <select name="nomina" id="nomina" class="form-control">
                                    <option value="" selected></option>
                                    <option value="Lic."> Licenciado(a) </option>
                                    <option value="Ing."> Ingeniero(a) </option>
                                    <option value="Per."> Personal </option>
                                </select>
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Cedula de Identidad</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="text" name="ci" id="ci" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                    <div class="row">
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Fecha de Nacimiento</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Nombre Usuario</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="text" name="username" id="username" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Correo Electrónico</label>
                                <input type="text" name="email" id="email" class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Perfil</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="perfil" id="perfil" class="form-control" required>
                                    @foreach($perfiles as $perfil)
                                        <option value="{{ $perfil->id }}">{{ $perfil->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Zona</label>
                                <input type="text" name="zona" id="zona" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Teléfono</label>
                                <input type="text" name="numero_fijo" id="numero_fijo" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Persona Referencia</label>
                                <input type="text" name="persona_referencia" id="persona_referencia" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Numero Referencia</label>
                                <input type="text" name="numero_referencia" id="numero_referencia" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Punto de venta</label>
                            <select name="codigo_punto_venta" id="codigo_punto_venta" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach ( $puntos as $p)
                                    @if(is_array($p))
                                        <option value="{{ $p['codigoPuntoVenta'] }}">{{ $p['nombrePuntoVenta'] }}</option>
                                    @else
                                        <option value="{{ $puntos['codigoPuntoVenta'] }}">{{ $puntos['nombrePuntoVenta'] }}</option>
                                        @break
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar()">GUARDAR USUARIO</button> -->
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar()">GUARDAR USUARIO</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal nuevo usuario -->

<!-- inicio modal editar usuario -->
<div id="editar_usuarios" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">EDITAR USUARIO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('User/actualizar') }}"  method="POST" >
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_edicion" id="id_edicion" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Nombres</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="text" name="nombres_edicion" id="nombres_edicion" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Apellido Paterno</label>
                                <input type="text" name="apellido_paterno_edicion" id="apellido_paterno_edicion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Apellido Materno</label>
                                <input type="text" name="apellido_materno_edicion" id="apellido_materno_edicion" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Cedula de Identidad</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="text" name="ci_edicion" id="ci_edicion" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Expedido</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="expedido_edicion" id="expedido_edicion" class="form-control" required>
                                    <option value="Beni"> Beni </option>
                                    <option value="Chuquisaca"> Chuquisaca </option>
                                    <option value="Cochabamba"> Cochabamba </option>
                                    <option value="La Paz"> La Paz </option>
                                    <option value="Oruro"> Oruro </option>
                                    <option value="Pando"> Pando </option>
                                    <option value="Potosi"> Potosi </option>
                                    <option value="Santa Cruz"> Santa Cruz </option>
                                    <option value="Tarija"> Tarija </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Estado Civil</label>
                                <select name="estado_civil_edicion" id="estado_civil_edicion" class="form-control">
                                    <option value=""></option>
                                    <option value="Soltero(a)"> Soltero(a) </option>
                                    <option value="Casado(a)"> Casado(a) </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Sexo</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="sexo_edicion" id="sexo_edicion" class="form-control" required>
                                    <option value="Femenino"> Femenino </option>
                                    <option value="Masculino"> Masculino </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento_edicion" id="fecha_nacimiento_edicion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Lugar de Nacimiento</label>
                                <select name="lugar_nacimiento_edicion" id="lugar_nacimiento_edicion" class="form-control">
                                    <option value=""></option>
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
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Nombre de usuario</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="text" name="username_edicion" id="username_edicion" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Correo Electrónico</label>
                                <input type="text" name="email_edicion" id="email_edicion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Perfil</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="perfil_edicion" id="perfil_edicion" class="form-control" required>
                                    @foreach($perfiles as $perfil)
                                        <option value="{{ $perfil->id }}">{{ $perfil->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Zona</label>
                                <input type="text" name="zona_edicion" id="zona_edicion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Dirección</label>
                                <input type="text" name="direccion_edicion" id="direccion_edicion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Teléfono</label>
                                <input type="text" name="numero_fijo_edicion" id="numero_fijo_edicion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Celular</label>
                                <input type="text" name="celular_edicion" id="celular_edicion" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Nombre Conyugue</label>
                                <input type="text" name="nombre_conyugue_edicion" id="nombre_conyugue_edicion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Nombre Hijo(a)</label>
                                <input type="text" name="nombre_hijo_edicion" id="nombre_hijo_edicion" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Persona Referencia</label>
                                <input type="text" name="persona_referencia_edicion" id="persona_referencia_edicion" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Numero Referencia</label>
                                <input type="text" name="numero_referencia_edicion" id="numero_referencia_edicion" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Punto de venta</label>
                            <select name="codigo_punto_venta_edicion" id="codigo_punto_venta_edicion" class="form-control">
                                <option value="">Seleccione</option>
                                @foreach ( $puntos as $p)
                                    @if(is_array($p))
                                        <option value="{{ $p['codigoPuntoVenta'] }}">{{ $p['nombrePuntoVenta'] }}</option>
                                    @else
                                        <option value="{{ $puntos['codigoPuntoVenta'] }}">{{ $puntos['nombrePuntoVenta'] }}</option>
                                        @break
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- <div class="modal-body">
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre" type="text" id="nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Cedula de Identidad</label>
                                <input name="ci" type="text" id="ci" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Correo Electrónico</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="email" type="email" id="email" onchange="validaEmailEdicion()" class="form-control" required>
                                <small id="msgValidaEmailEdicion" class="badge badge-default badge-danger form-text text-white float-left" style="display: none;">El correo ya existe, introduzca otro.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Celular(es)</label>
                                <input name="celular" type="text" id="celular" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nit</label>
                                <input name="nit" type="text" id="nit" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Razón Social</label>
                                <input name="razon_social" type="text" id="razon_social" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Perfil</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="perfil" id="perfil" class="form-control" required>
                                    <option value="" selected> Seleccione </option>
                                    @foreach($perfiles as $perfil)
                                        <option value="{{ $perfil->id }}">{{ $perfil->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Almacen</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="almacen" id="almacen" class="form-control" required>
                                    <option value="" selected>Seleccione</option>

                                </select>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="modal-footer">
                    <!-- <button type="submit" class="btn waves-effect waves-light btn-block btn-success" id="botonGuardaEdicionUsuario" onclick="actualizar_usuario()">ACTUALIZAR USUARIO</button> -->
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_edicion()">GUARDAR USUARIO</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal editar usuario -->

<!-- inicio modal asignar materias -->
<div id="asigna_materias" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="asignaMateriasAjax">

    </div>
</div>
<!-- fin modal asignar materias -->

<!-- inicio modal editar perfil -->
<div id="editar_perfiles" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="editaPerfilAjax">

    </div>
</div>
<!-- fin modal editar perfil -->

<!-- inicio modal cambiar contrasena -->
<div id="password_usuarios" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">CAMBIAR CONTRASE&Ntilde;A</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('User/password') }}" class="needs-validation" method="POST" novalidate>
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_password" id="id_password" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Contraseña</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="password" type="password" id="password" class="form-control" minlength="8" placeholder="Debe tener al menos 8 digitos" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_password()">ACTUALIZAR</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal cambiar contrasena -->
@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script>
    // Funcion que habilita el uso de Ajax
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Funcion que establece la configuracion para el datatable
    $(function () {
        // $("#botonGuardaNuevoUsuario").prop("disabled", false);
        // $("#botonGuardaEdicionUsuario").prop("disabled", false);
        $('#myTable').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });

    // Funcion para mostrar modal de nuevo usuario
    function nuevo_usuario()
    {
        $("#modal_usuarios").modal('show');
    }

    // Funcion que comprueba que existen ciertos valores en el formulario y si estan muestra una alerta de exito
    function guardar()
    {
        var apellido_paterno = $("#apellido_paterno").val();
        var apellido_materno = $("#apellido_materno").val();
        var nombres = $("#nombres").val();
        //nomina
        //pass
        var ci = $("#ci").val();
        var expedido = $("#expedido").val();
        //var tipo = $("#tipo").val();
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
                text: 'Completa las casillas que estan marcadas en rojo.'
            })
        }
    }

    // Funcion que despliega el modal de edicion de usuario, mandando todos sus datos al mismo
    function editar(id, nombres, apellido_paterno, apellido_materno, cedula, expedido, estado_civil, sexo, fecha_nacimiento, lugar_nacimiento, name, email, perfil_id, zona, direccion, numero_fijo, numero_celular, nombre_conyugue, nombre_hijo, persona_referencia, numero_referencia, codigo_punto_venta)
    {
        $("#id_edicion").val(id);
        $("#nombres_edicion").val(nombres);
        $("#apellido_paterno_edicion").val(apellido_paterno);
        $("#apellido_materno_edicion").val(apellido_materno);
        $("#ci_edicion").val(cedula);
        $("#expedido_edicion").val(expedido);
        $("#estado_civil_edicion").val(estado_civil);
        $("#sexo_edicion").val(sexo);
        $("#fecha_nacimiento_edicion").val(fecha_nacimiento);
        $("#lugar_nacimiento_edicion").val(lugar_nacimiento);
        $("#username_edicion").val(name);
        $("#email_edicion").val(email);
        $("#perfil_edicion").val(perfil_id);
        $("#zona_edicion").val(zona);
        $("#direccion_edicion").val(direccion);
        $("#numero_fijo_edicion").val(numero_fijo);
        $("#celular_edicion").val(numero_celular);
        $("#nombre_conyugue_edicion").val(nombre_conyugue);
        $("#nombre_hijo_edicion").val(nombre_hijo);
        $("#persona_referencia_edicion").val(persona_referencia);
        $("#numero_referencia_edicion").val(numero_referencia);
        $("#codigo_punto_venta_edicion").val(codigo_punto_venta)
        $("#editar_usuarios").modal('show');
    }

    // Funcion que despliega un modal que indica que materias se le puede agregar y que materias tiene
    function asignar(usuario_id)
    {
        window.location.href = "{{ url('User/asigna_materias') }}/"+usuario_id;
    }

    // Funcion que redirige a las materias que el docente tiene asignado
    function verMaterias(usuario_id)
    {
        window.location.href = "{{ url('User/verMaterias') }}";
    }

    //Funcion para ocultar/mostrar y validar datos dependiendo del Tipo de perfil seleccionado
    $( function() {
        $("#ventana_almacen_existente").hide();
        $(".ventana_almacen_nuevo").hide();
        $("#perfil_usuario").val("");
        $("#perfil_usuario").change( function() {
            if($(this).val() == "") {                               // Si el select de Tipo de Perfil esta vacio (Seleccione), todo se oculta y sus valores se limpian
                $("#almacen_usuario").val("");
                $("#nombre_nuevo_almacen").val("");
                $("#telefonos_nuevo_almacen").val("");
                $("#direccion_nuevo_almacen").val("");

                $("#almacen_usuario").prop('required',false);
                $("#nombre_nuevo_almacen").prop('required',false);
                $("#direccion_nuevo_almacen").prop('required',false);

                $("#ventana_almacen_existente").hide();
                $(".ventana_almacen_nuevo").hide();
            }
            if ($(this).val() != "" && $(this).val() != "4") {      // Si el select de Tipo de Perfil es diferente de "" y de 4, mostrara select de un almacen existente
                $("#almacen_usuario").prop('required',true);
                $("#nombre_nuevo_almacen").prop('required',false);
                $("#direccion_nuevo_almacen").prop('required',false);
                $(".ventana_almacen_nuevo").hide();
                $("#ventana_almacen_existente").show();
                //$("#guarda_cupon").prop("disabled", false);
            }
            if ($(this).val() == "4") {                             // Si el select de Tipo de Perfil esta con 4 (Mayorista), mostrara los detalles para nuevo almacen
                $("#nombre_nuevo_almacen").prop('required',true);
                $("#direccion_nuevo_almacen").prop('required',true);
                $("#almacen_usuario").prop('required',false);
                $("#ventana_almacen_existente").hide();
                $(".ventana_almacen_nuevo").show();
            }
        });
    });

    // Funcion que comprueba que existen ciertos valores en el formulario y si estan muestra una alerta de exito
    function guardar_edicion()
    {
        var apellido_paterno = $("#apellido_paterno_edicion").val();
        var apellido_materno = $("#apellido_materno_edicion").val();
        var nombres = $("#nombres_edicion").val();
        //nomina
        //pass
        var ci = $("#ci_edicion").val();
        var expedido = $("#expedido_edicion").val();
        //var tipo = $("#tipo_edicion").val();
        var username = $("#username_edicion").val();
        //fechaincorporacion
        //vigente
        //rol
        var fecha_nacimiento = $("#fecha_nacimiento_edicion").val();
        var lugar_nacimiento = $("#lugar_nacimiento_edicion").val();
        var sexo = $("#sexo_edicion").val();
        //estadocivil
        var nombre_conyugue = $("#nombre_conyugue_edicion").val();
        var nombre_hijo = $("#nombre_hijo_edicion").val();
        var direccion = $("#direccion_edicion").val();
        var zona = $("#zona_edicion").val();
        var celular = $("#celular_edicion").val();
        var numero_fijo = $("#numero_fijo_edicion").val();
        var email = $("#email_edicion").val();
        //foto
        var persona_referencia = $("#persona_referencia_edicion").val();
        var numero_referencia = $("#numero_referencia_edicion").val();
        if( nombres.length>0 &&
            ci.length>0 &&
            expedido.length>0 &&
            username.length>0 &&
            //fecha_nacimiento.length>0 &&
            //lugar_nacimiento.length>0 &&
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
                text: 'Completa las casillas que estan marcadas en rojo.'
            })
        }
    }




    // Funcion para validar el email en Nuevo usuario
    function validaEmail()
    {
        let correo_cliente = $("#email_usuario").val();
        $.ajax({
            url: "{{ url('Cliente/ajaxVerificaCorreo') }}",
            data: { correo: correo_cliente },
            type: 'POST',
            success: function(data) {
                if (data.valida == 1) {
                    $("#msgValidaEmail").show();
                    $("#botonGuardaNuevoUsuario").prop("disabled", true);
                }else{
                    $("#botonGuardaNuevoUsuario").prop("disabled", false);
                    $("#msgValidaEmail").hide();
                }
            }
        });
    }

    // Funcion para validar el email en Edicion de usuario
    function validaEmailEdicion()
    {
        let correo_cliente = $("#email").val();
        $.ajax({
            url: "{{ url('Cliente/ajaxVerificaCorreo') }}",
            data: { correo: correo_cliente },
            type: 'POST',
            success: function(data) {
                if (data.valida == 1) {
                    $("#msgValidaEmailEdicion").show();
                    $("#botonGuardaEdicionUsuario").prop("disabled", true);
                }else{
                    $("#botonGuardaEdicionUsuario").prop("disabled", false);
                    $("#msgValidaEmailEdicion").hide();
                }
            }
        });
    }

    // Funcion que muestra los datos referentes a los permisos de un usuario
    function permisos(usuario_id, perfil_id)
    {
        $.ajax({
            url: "{{ url('User/ajaxEditaPerfil') }}",
            data: {
                usuario_id: usuario_id,
                perfil_id: perfil_id
                },
            type: 'get',
            success: function(data) {
                //$("#muestraCuponAjax").show('slow');
                $("#editaPerfilAjax").html(data);
                $("#editar_perfiles").modal('show');
            }
        });
    }



    // Funcion que emite una alerta de exito en caso de encontrarse ciertos valores
    function actualizar_usuario()
    {
        var id = $("#id").val();
        var nombre = $("#nombre").val();
        var perfil = $("#perfil").val();
        var email = $("#email").val();
        var almacen = $("#almacen").val();
        if(nombre.length>0 && perfil.length>0 && email.length>0 && almacen.length>0){
            Swal.fire(
                'Excelente!',
                'Usuario actualizado correctamente.',
                'success'
            )
        }
    }

    // Al presionar el boton de actualizar perfil emite una alerta de exito
    function actualizar_perfil()
    {
        Swal.fire(
            'Excelente!',
            'Permisos de perfil actualizados correctamente.',
            'success'
        )
    }

    // Funcion que muestra un modal para cambio de contrasena
    function contrasena(id)
    {
        $("#id_password").val(id);
        $("#password_usuarios").modal('show');
    }

    // Funcion que emite una alerta de exito al presionar el boton de actualizar el password
    function actualizar_password()
    {
        var password = $("#password").val();
        if(password.length>7){
            Swal.fire(
                'Excelente!',
                'Contraseña cambiada.',
                'success'
            )
        }
    }

    // Funcion que elimina un usuario
    function eliminar(id, nombre)
    {
        Swal.fire({
            title: 'Quieres borrar a ' + nombre + '?',
            text: "Luego no podras recuperarlo!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Excelente!',
                    'El usuario fue eliminado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('User/eliminar') }}/"+id;
                });
            }
        })
    }
</script>
@endsection
