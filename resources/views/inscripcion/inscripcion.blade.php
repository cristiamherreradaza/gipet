@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection


@section('css')
@endsection

@section('content')
<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<div class="row">
    <!-- Column -->
    <div class="col-md-12">
        <!-- Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-info">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">NUEVO ALUMNO</h4>
                </div>
                    <form action="/Inscripcion/store" method="POST">
                        @csrf
                    <div class="card-body">

                        {{-- datos personales --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border-warning">
                                    <div class="card-header bg-warning">
                                        <h4 class="mb-0 text-white">DATOS PERSONALES</h4>
                                    </div>
                                    <div class="card-body" style="background-color: #fff6d4;">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Carnet </label>
                                                            <input type="text" class="form-control"
                                                                name="carnet" id="carnet">
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" hidden name="persona_id" id="persona_id">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Expedido </label>
                                                            <select name="expedido" id="expedido" class="form-control">
                                                                <option value="La Paz">La Paz</option>
                                                                <option value="Cochabamba">Cochabamba</option>
                                                                <option value="Santa Cruz">Santa Cruz</option>
                                                                <option value="Oruro">Oruro</option>
                                                                <option value="Potosi">Potosi</option>
                                                                <option value="Tarija">Tarija</option>
                                                                <option value="Sucre">Sucre</option>
                                                                <option value="Beni">Beni</option>
                                                                <option value="Pando">Pando</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Apellido Paterno </label>
                                                            <input type="text" class="form-control"
                                                                name="apellido_paterno" id="apellido_paterno">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Apellido Materno </label>
                                                            <input type="text" class="form-control"
                                                                name="apellido_materno" id="apellido_materno">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Nombres </label>
                                                            <input type="text" class="form-control"
                                                                name="nombres" id="nombres">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Fecha Nacimiento </label>
                                                            <input type="date" class="form-control"
                                                                name="fecha_nacimiento" id="fecha_nacimiento">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Email </label>
                                                            <input type="text" class="form-control"
                                                                name="email" id="email">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Direccion </label>
                                                            <input type="text" class="form-control"
                                                                name="direccion" id="direccion">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular </label>
                                                            <input type="text" class="form-control"
                                                                name="telefono_celular" id="telefono_celular">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Genero </label>
                                                            <select name="sexo" id="sexo" class="form-control">
                                                                <option value="Masculino">Masculino</option>
                                                                <option value="Femenina">Femenina</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- fin datos personales --}}

                        {{-- datos profesionales --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border-inverse">
                                    <div class="card-header bg-inverse">
                                        <h4 class="mb-0 text-white">DATOS PROFESIONALES</h4>
                                    </div>
                                    <div class="card-body" style="background-color: #ededed;">

                                            <div class="form-body">
                                                <!--/row-->
                                                <!-- NOMBRE DEL ATRIBUTO ENCIMA -->
                                                <div class="row pt-3">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Trabaja</label>
                                                            <select class="form-control" id="trabaja" name="trabaja">
                                                                <option value="">Seleccionar</option>
                                                                <option value="Si">Si</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- row -->
                                                <div class="row pt-3" id="mostrar_ocultar" style="display:none;">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Nombre de la Empresa</label>
                                                            <input type="text" id="empresa" class="form-control" name="empresa">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Direcci&oacute;n de la Empresa</label>
                                                            <input type="text" id="direccion_empresa" class="form-control" name="direccion_empresa">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Telefono de la Empresa</label>
                                                            <input type="text" id="telefono_empresa" class="form-control" name="telefono_empresa">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Fax</label>
                                                            <input type="text" id="fax" class="form-control" name="fax">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">Email Empresa</label>
                                                            <input type="email" id="email_empresa" class="form-control" name="email_empresa">
                                                        </div>
                                                    </div>
                                                </div>  
                                                <!-- row -->
                                                
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- fin datos profesionales --}}

                        {{-- referencias personales --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border-success">
                                    <div class="card-header bg-success">
                                        <h4 class="mb-0 text-white">REFERENCIAS PERSONALES</h4>
                                    </div>
                                    <div class="card-body" style="background-color: #e3ffe3;">

                                            <div class="form-body">

                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Padre </label>
                                                            <input type="text" class="form-control" name="nombre_padre" id="nombre_padre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular Padre </label>
                                                            <input type="text" class="form-control" name="celular_padre" id="celular_padre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Madre </label>
                                                            <input type="text" class="form-control" name="nombre_madre" id="nombre_madre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular Madre </label>
                                                            <input type="text" class="form-control" name="celular_madre" id="celular_madre">
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Tutor </label>
                                                            <input type="text" class="form-control" name="nombre_tutor" id="nombre_tutor">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular Tutor </label>
                                                            <input type="text" class="form-control" name="telefono_tutor" id="telefono_tutor">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Esposo </label>
                                                            <input type="text" class="form-control" name="nombre_esposo" id="nombre_esposo">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular Esposo </label>
                                                            <input type="text" class="form-control" name="telefono_esposo" id="telefono_esposo">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- fin referencias personales --}}

                        {{-- Carrera --}}
                        <!-- Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border-info">
                                    <div class="card-header bg-info">
                                        <h4 class="mb-0 text-white">Datos de la Carrera</h4>
                                    </div>
                                    <div class="card-body">
                                            <div class="form-body">
                                                <!--/row-->
                                                <!-- <h3 class="box-title">Address</h3> -->
                                                <!--/row-->
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Carrera</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="carrera_id_1" name="carrera_id_1">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($carreras as $carre)
                                                                    <option value="{{ $carre->id }}">{{ $carre->nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_id_1" name="turno_id_1">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_1" name="paralelo_1">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="gestion_1" name="gestion_1" value="{{ $year }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                                <!--/row-->
                                                <div class="row" id="secre" style="display:none;">
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Carrera</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" id="carrera_id_2" name="carrera_id_2" readonly value="Secretariado Administrativo">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_id_2" name="turno_id_2">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_2" name="paralelo_2">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="gestion_2" name="gestion_2" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12">
                                                        <button type="button" class="btn btn-danger" onclick="cerrar_secre();">X</button>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                                <!--/row-->
                                                <div class="row" id="auxiliar" style="display:none;">
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Carrera</label>
                                                            <div class="col-md-9">
                                                                <input type="text" class="form-control" id="carrera_id_3" name="carrera_id_3" readonly value="Auxiliar Administrativo Financiero">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_id_3" name="turno_id_3">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_3" name="paralelo_3">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="gestion_3" name="gestion_3" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12">
                                                        <button type="button" class="btn btn-danger" onclick="cerrar_auxi();">X</button>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                                <!--row CARRERA_4-->
                                                <div class="row" id="carrera_4" style="display:none;">
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Carrera</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="carrera_id_4" name="carrera_id_4">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($carreras as $carre)
                                                                    <option value="{{ $carre->id }}">{{ $carre->nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_id_4" name="turno_id_4">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_4" name="paralelo_4">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="gestion_4" name="gestion_4" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12">
                                                        <button type="button" class="btn btn-danger" onclick="cerrar_carrera_4();">X</button>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                                <!--row CARRERA_5-->
                                                <div class="row" id="carrera_5" style="display:none;">
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Carrera</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="carrera_id_5" name="carrera_id_5">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($carreras as $carre)
                                                                    <option value="{{ $carre->id }}">{{ $carre->nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_id_5" name="turno_id_5">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_5" name="paralelo_5">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="gestion_5" name="gestion_5" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12">
                                                        <button type="button" class="btn btn-danger" onclick="cerrar_carrera_5();">X</button>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                                <!--row CARRERA_6-->
                                                <div class="row" id="carrera_6" style="display:none;">
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Carrera</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="carrera_id_6" name="carrera_id_6">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($carreras as $carre)
                                                                    <option value="{{ $carre->id }}">{{ $carre->nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_id_6" name="turno_id_6">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_6" name="paralelo_6">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="gestion_6" name="gestion_6" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12">
                                                        <button type="button" class="btn btn-danger" onclick="cerrar_carrera_6();">X</button>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                                <!--row CARRERA_7-->
                                                <div class="row" id="carrera_7" style="display:none;">
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Carrera</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="carrera_id_7" name="carrera_id_7">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($carreras as $carre)
                                                                    <option value="{{ $carre->id }}">{{ $carre->nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_id_7" name="turno_id_7">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_7" name="paralelo_7">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="gestion_7" name="gestion_7" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12">
                                                        <button type="button" class="btn btn-danger" onclick="cerrar_carrera_7();">X</button>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="button" class="btn btn-info" id="b_carrera_4" onclick="abre_carrera_4();">Adicionar Otra Carrera </button>
                                                                <button type="button" class="btn btn-info" id="b_carrera_5" style="display: none;" onclick="abre_carrera_5();">Adicionar Otra Carrera </button>
                                                                <button type="button" class="btn btn-info" id="b_carrera_6" style="display: none;" onclick="abre_carrera_6();">Adicionar Otra Carrera </button>
                                                                <button type="button" class="btn btn-info" id="b_carrera_7" style="display: none;" onclick="abre_carrera_7();">Adicionar Otra Carrera </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row -->
                        {{-- fin Carrera --}}

                         {{-- OTRAS ASIGNATURAS --}}
                        <!-- Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary">
                                        <h4 class="mb-0 text-white">Asignaturas Adicionales</h4>
                                    </div>
                                    <div class="card-body">
                                            <div class="form-body">
                                                <!--/row-->
                                                <!-- <h3 class="box-title">Address</h3> -->
                                                <!--/row-->
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Asignaturas</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_id_1" name="asignatura_id_1">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($asignaturas as $asig)
                                                                    <option value="{{ $asig->id }}">{{ $asig->nombre_asignatura }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_turno_id_1" name="asignatura_turno_id_1">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_paralelo_1" name="asignatura_paralelo_1">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="asignatura_gestion_1" name="asignatura_gestion_1" value="{{ $year }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <!--row ASIGNATURA_2-->
                                                <div class="row" id="asignatura_2" style="display:none;">
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Carrera</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_id_2" name="asignatura_id_2">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($asignaturas as $asig)
                                                                    <option value="{{ $asig->id }}">{{ $asig->nombre_asignatura }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_turno_id_2" name="asignatura_turno_id_2">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_paralelo_2" name="asignatura_paralelo_2">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="asignatura_gestion_2" name="asignatura_gestion_2" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12">
                                                        <button type="button" class="btn btn-danger" onclick="cerrar_asignatura_2();">X</button>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                                 <!--row ASIGNATURA_3-->
                                                <div class="row" id="asignatura_3" style="display:none;">
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Carrera</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_id_3" name="asignatura_id_3">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($asignaturas as $asig)
                                                                    <option value="{{ $asig->id }}">{{ $asig->nombre_asignatura }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_turno_id_3" name="asignatura_turno_id_3">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_paralelo_3" name="asignatura_paralelo_3">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="asignatura_gestion_3" name="asignatura_gestion_3" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12">
                                                        <button type="button" class="btn btn-danger" onclick="cerrar_asignatura_3();">X</button>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                                 <!--row ASIGNATURA_4-->
                                                <div class="row" id="asignatura_4" style="display:none;">
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Carrera</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_id_4" name="asignatura_id_4">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($asignaturas as $asig)
                                                                    <option value="{{ $asig->id }}">{{ $asig->nombre_asignatura }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_turno_id_4" name="asignatura_turno_id_4">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_paralelo_4" name="asignatura_paralelo_4">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="asignatura_gestion_4" name="asignatura_gestion_4" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12">
                                                        <button type="button" class="btn btn-danger" onclick="cerrar_asignatura_4();">X</button>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                                 <!--row ASIGNATURA_5-->
                                                <div class="row" id="asignatura_5" style="display:none;">
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Carrera</label>
                                                            <div class="col-md-9">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_id_5" name="asignatura_id_5">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($asignaturas as $asig)
                                                                    <option value="{{ $asig->id }}">{{ $asig->nombre_asignatura }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Turno</label>
                                                            <div class="col-md-7">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_turno_id_5" name="asignatura_turno_id_5">
                                                                    <option value="">Seleccionar</option>
                                                                    @foreach($turnos as $tur)
                                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                                            <div class="col-md-6">
                                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_paralelo_5" name="asignatura_paralelo_5">
                                                                    <option value="">Seleccionar</option>
                                                                <option value="A">A</option>
                                                                <option value="B">B</option>
                                                                <option value="C">C</option>
                                                                <option value="D">D</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2 col-md-12">
                                                        <div class="form-group row">
                                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                                            <div class="col-md-7">
                                                                <input type="text" class="form-control" id="asignatura_gestion_5" name="asignatura_gestion_5" value="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-1 col-md-12">
                                                        <button type="button" class="btn btn-danger" onclick="cerrar_asignatura_5();">X</button>
                                                    </div>
                                                </div>
                                                <!--/row-->
                                            </div>
                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="button" class="btn btn-info" id="b_asignatura_2" onclick="abre_asignatura_2();">Adicionar Otra Asignatura </button>
                                                                <button type="button" class="btn btn-info" id="b_asignatura_3" style="display: none;" onclick="abre_asignatura_3();">Adicionar Otra Asignatura </button>
                                                                <button type="button" class="btn btn-info" id="b_asignatura_4" style="display: none;" onclick="abre_asignatura_4();">Adicionar Otra Asignatura </button>
                                                                <button type="button" class="btn btn-info" id="b_asignatura_5" style="display: none;" onclick="abre_asignatura_5();">Adicionar Otra Asignatura </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Row -->
                        {{-- fin OTRAS ASIGNATURAS --}}
                        
                        <div class="row">
                            <div class="col-md-6">
                            <button type="submit" id="boton" onclick="guarda();" class="btn waves-effect waves-light btn-block btn-success">Guardar</button>
                            </div>
                            <div class="col-md-6">
                            <button type="button" class="btn waves-effect waves-light btn-block btn-inverse">Cancelar</button>
                            </div>
                        </div>

                    </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>
    <!-- Column -->
</div>
@stop
@section('js')
<script>
    $('#carnet').on('change', function(e){
            var carnet = e.target.value;
            $.ajax({
            type:'GET',
            url:"{{ url('Inscripcion/busca_ci') }}",
            data: {
                ci : carnet
            },
            success:function(data){
                $('#persona_id').val(data.id);
                $('#expedido').val(data.expedido);
                $('#apellido_paterno').val(data.apellido_paterno);
                $('#apellido_materno').val(data.apellido_materno);
                $('#nombres').val(data.nombres);
                $('#fecha_nacimiento').val(data.fecha_nacimiento);
                $('#email').val(data.email);
                $('#direccion').val(data.direccion);
                $('#telefono_celular').val(data.telefono_celular);
                $('#sexo').val(data.sexo);
                $('#trabaja').val(data.trabaja);
                $('#empresa').val(data.empresa);
                $('#direccion_empresa').val(data.direccion_empresa);
                $('#telefono_empresa').val(data.telefono_empresa);
                $('#fax').val(data.fax);
                $('#email_empresa').val(data.email_empresa);
                $('#nombre_padre').val(data.nombre_padre);
                $('#celular_padre').val(data.celular_padre);
                $('#nombre_madre').val(data.nombre_madre);
                $('#celular_madre').val(data.celular_madre);
                $('#nombre_tutor').val(data.nombre_tutor);
                $('#telefono_tutor').val(data.telefono_tutor);
                $('#nombre_esposo').val(data.nombre_esposo);
                $('#telefono_esposo').val(data.telefono_esposo);
            }
        });
           
    });
</script>
<script>
    $('#trabaja').on('change', function(e){
            var trabaja = e.target.value;
            if (trabaja == 'Si') {
                $('#mostrar_ocultar').show('slow');
            }else{
                $('#mostrar_ocultar').hide('slow');
            }
    });
</script>

<script>
    $('#carrera_id_1').on('change', function(e){
            var carrera = e.target.value;
            verifica_carrera(carrera);
            if (carrera == '1') {
                $('#secre').show('slow');//para visualizar las asignaturas
                $('#auxiliar').show('slow');//para visualizar las asignaturas
            }
            else{
                 $('#secre').hide('slow');//para visualizar las asignaturas
                $('#auxiliar').hide('slow');//para visualizar las asignaturas
            }
    });

    function verifica_carrera(carrera){
        var carrera_id = carrera;
        // alert(carrera_id);
    }

    function cerrar_secre(){
        $('#secre').hide('slow');//para visualizar las asignaturas
        $("#gestion_2").val('');
    }

    function cerrar_auxi(){
        $('#auxiliar').hide('slow');//para visualizar las asignaturas
        $("#gestion_3").val('');
    }
</script>

<script>
    function abre_carrera_4(){
        $('#carrera_4').show('slow');//para visualizar las asignaturas
        $('#b_carrera_4').hide('slow');//para visualizar las asignaturas
        $('#b_carrera_5').show('slow');//para visualizar las asignaturas
    }

    function cerrar_carrera_4(){
        $('#carrera_4').hide('slow');//para visualizar las asignaturas
        $("#carrera_id_4").val('');
    }

    function abre_carrera_5(){
        $('#carrera_5').show('slow');//para visualizar las asignaturas
        $('#b_carrera_5').hide('slow');//para visualizar las asignaturas
        $('#b_carrera_6').show('slow');//para visualizar las asignaturas
    }

    function cerrar_carrera_5(){
        $('#carrera_5').hide('slow');//para visualizar las asignaturas
        $("#carrera_id_5").val('');
    }

    function abre_carrera_6(){
        $('#carrera_6').show('slow');//para visualizar las asignaturas
        $('#b_carrera_6').hide('slow');//para visualizar las asignaturas
        $('#b_carrera_7').show('slow');//para visualizar las asignaturas
    }

    function cerrar_carrera_6(){
        $('#carrera_6').hide('slow');//para visualizar las asignaturas
        $("#carrera_id_6").val('');
    }

    function abre_carrera_7(){
        $('#carrera_7').show('slow');//para visualizar las asignaturas
        $('#b_carrera_7').hide('slow');//para visualizar las asignaturas
        // $('#b_carrera_4').show('slow');//para visualizar las asignaturas
    }

    function cerrar_carrera_7(){
        $('#carrera_7').hide('slow');//para visualizar las asignaturas
        $("#carrera_id_7").val('');
    }
</script>

<script>
    function abre_asignatura_2(){
        $('#asignatura_2').show('slow');//para visualizar las asignaturas
        $('#b_asignatura_2').hide('slow');//para visualizar las asignaturas
        $('#b_asignatura_3').show('slow');//para visualizar las asignaturas
    }

    function cerrar_asignatura_2(){
        $('#asignatura_2').hide('slow');//para visualizar las asignaturas
        $("#asignatura_id_2").val('');
    }

    function abre_asignatura_3(){
        $('#asignatura_3').show('slow');//para visualizar las asignaturas
        $('#b_asignatura_3').hide('slow');//para visualizar las asignaturas
        $('#b_asignatura_4').show('slow');//para visualizar las asignaturas
    }

    function cerrar_asignatura_3(){
        $('#asignatura_3').hide('slow');//para visualizar las asignaturas
        $("#asignatura_id_3").val('');
    }

    function abre_asignatura_4(){
        $('#asignatura_4').show('slow');//para visualizar las asignaturas
        $('#b_asignatura_4').hide('slow');//para visualizar las asignaturas
        $('#b_asignatura_5').show('slow');//para visualizar las asignaturas
    }

    function cerrar_asignatura_4(){
        $('#asignatura_4').hide('slow');//para visualizar las asignaturas
        $("#asignatura_id_4").val('');
    }

    function abre_asignatura_5(){
        $('#asignatura_5').show('slow');//para visualizar las asignaturas
        $('#b_asignatura_5').hide('slow');//para visualizar las asignaturas
        // $('#b_carrera_4').show('slow');//para visualizar las asignaturas
    }

    function cerrar_asignatura_5(){
        $('#asignatura_5').hide('slow');//para visualizar las asignaturas
        $("#asignatura_id_5").val('');
    }


</script>
<script>
    function guarda(){
        setInterval(Swal.fire(
                    'Excelente!',
                    'Los datos fueron guadados',
                    'success'
                ), 3000);
    }
</script>

<script>
    // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
</script>
@endsection
