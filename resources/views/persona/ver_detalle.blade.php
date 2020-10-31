@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
<style>

    /* these styles are for the demo, but are not required for the plugin */
    .zoom {
        display: inline-block;
        position: relative;
        cursor: zoom-in;
    }

    /* magnifying glass icon */
    .zoom:after {
        content: '';
        display: block;
        width: 33px;
        height: 33px;
        position: absolute;
        top: 0;
        right: 0;
        background: url(icon.png);
    }

    .zoom img {
        display: block;
    }

    .zoom img::selection {
        background-color: transparent;
    }

</style>
@endsection

@section('content')
<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<!-- Formulario Informacion Personal de Estudiante -->
<form action="{{ url('Persona/actualizar') }}" method="POST">
    @csrf
    <div class="row" id="tabsEstudiante">
        <div class="col-md-4">
            <button type="button" id="tab1" class="btn btn-block btn-info activo">DATOS PERSONALES</button>
        </div>
        <div class="col-md-4">
            <button type="button" id="tab2" class="btn btn-block btn-info inactivo">DATOS PROFESIONALES</button>
        </div>
        <div class="col-md-4">
            <button type="button" id="tab3" class="btn btn-block btn-info inactivo">REFERENCIA PERSONAL</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 tabContenido" id="tab1C">
            <div class="card border-info">
                <div class="card-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Cedula de Identidad 
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <input type="text" class="form-control" name="carnet" id="carnet" value="{{ $estudiante->cedula }}" required>
                                </div>
                            </div>
                            <input type="text" class="form-control" hidden name="persona_id" id="persona_id" value="{{ $estudiante->id }}">
                            <div class="col">
                                <div class="form-group">
                                    <label>Expedido 
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <select name="expedido" id="expedido" class="form-control">
                                        <option value="La Paz" {{ $estudiante->expedido=='La Paz' ? 'selected' : '' }}>La Paz</option>
                                        <option value="Cochabamba" {{ $estudiante->expedido=='Cochabamba' ? 'selected' : '' }}>Cochabamba</option>
                                        <option value="Santa Cruz" {{ $estudiante->expedido=='Santa Cruz' ? 'selected' : '' }}>Santa Cruz</option>
                                        <option value="Oruro" {{ $estudiante->expedido=='Oruro' ? 'selected' : '' }}>Oruro</option>
                                        <option value="Potosi" {{ $estudiante->expedido=='Potosi' ? 'selected' : '' }}>Potosi</option>
                                        <option value="Tarija" {{ $estudiante->expedido=='Tarija' ? 'selected' : '' }}>Tarija</option>
                                        <option value="Sucre" {{ $estudiante->expedido=='Sucre' ? 'selected' : '' }}>Sucre</option>
                                        <option value="Beni" {{ $estudiante->expedido=='Beni' ? 'selected' : '' }}>Beni</option>
                                        <option value="Pando" {{ $estudiante->expedido=='Pando' ? 'selected' : '' }}>Pando</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Apellido Paterno </label>
                                    <input type="text" class="form-control" name="apellido_paterno" id="apellido_paterno" value="{{ $estudiante->apellido_paterno }}">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Apellido Materno </label>
                                    <input type="text" class="form-control" name="apellido_materno" id="apellido_materno" value="{{ $estudiante->apellido_materno }}">
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-group">
                                    <label>Nombres
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <input type="text" class="form-control" name="nombres" id="nombres" value="{{ $estudiante->nombres }}" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label>Fecha Nacimiento
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ $estudiante->fecha_nacimiento }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Email </label>
                                    <input type="text" class="form-control" name="email" id="email" value="{{ $estudiante->email }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Direccion </label>
                                    <input type="text" class="form-control" name="direccion" id="direccion" value="{{ $estudiante->direccion }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Celular 
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <input type="text" class="form-control" name="telefono_celular" id="telefono_celular" value="{{ $estudiante->numero_celular }}" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Genero 
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <select name="sexo" id="sexo" class="form-control" required>
                                        <option value="Masculino" {{ $estudiante->sexo=='Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ $estudiante->sexo=='Femenino' ? 'selected' : '' }}>Femenino</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 tabContenido" id="tab2C" style="display: none;">
            <div class="card border-info">
                <div class="card-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Trabaja 
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <select class="form-control" id="trabaja" name="trabaja" required>
                                        <option value="Si" {{ $estudiante->trabaja=='Si' ? 'selected' : '' }}>Si</option>
                                        <option value="No" {{ $estudiante->trabaja=='No' ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Nombre de la Empresa</label>
                                    <input type="text" id="empresa" class="form-control" name="empresa" value="{{ $estudiante->empresa }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Direcci&oacute;n de la Empresa</label>
                                    <input type="text" id="direccion_empresa" class="form-control" name="direccion_empresa" value="{{ $estudiante->direccion_empresa }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Telefono de la Empresa</label>
                                    <input type="text" id="telefono_empresa" class="form-control" name="telefono_empresa" value="{{ $estudiante->numero_empresa }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Fax</label>
                                    <input type="text" id="fax" class="form-control" name="fax" value="{{ $estudiante->fax }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Email Empresa</label>
                                    <input type="email" id="email_empresa" class="form-control" name="email_empresa" value="{{ $estudiante->email_empresa }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 tabContenido" id="tab3C" style="display: none;">
            <div class="card border-info">
                <div class="card-body">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Nombre Padre </label>
                                    <input type="text" class="form-control" name="nombre_padre" id="nombre_padre" value="{{ $estudiante->nombre_padre }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Celular Padre </label>
                                    <input type="text" class="form-control" name="celular_padre" id="celular_padre" value="{{ $estudiante->celular_padre }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Nombre Madre </label>
                                    <input type="text" class="form-control" name="nombre_madre" id="nombre_madre" value="{{ $estudiante->nombre_madre }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Celular Madre </label>
                                    <input type="text" class="form-control" name="celular_madre" id="celular_madre" value="{{ $estudiante->celular_madre }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Nombre Tutor </label>
                                    <input type="text" class="form-control" name="nombre_tutor" id="nombre_tutor" value="{{ $estudiante->nombre_tutor }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Celular Tutor </label>
                                    <input type="text" class="form-control" name="telefono_tutor" id="telefono_tutor" value="{{ $estudiante->celular_tutor }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Nombre Esposo </label>
                                    <input type="text" class="form-control" name="nombre_esposo" id="nombre_esposo" value="{{ $estudiante->nombre_pareja }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Celular Esposo </label>
                                    <input type="text" class="form-control" name="telefono_esposo" id="telefono_esposo" value="{{ $estudiante->celular_pareja }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <button type="submit" class="btn waves-effect waves-light btn-block btn-inverse">Actualizar Perfil</button>
        </div>
        <div class="col-md-4">
            <a href="{{ url('Inscripcion/reinscripcion/'.$estudiante->id) }}" type="button" class="btn waves-effect waves-light btn-block btn-inverse">Reinscribir</a>
        </div>
        <div class="col-md-4">
            <a href="{{ url('Persona/listado') }}" type="button" class="btn waves-effect waves-light btn-block btn-inverse">Volver</a>
        </div>
    </div>
</form>
<br>
<!-- Botones de Informacion Academica de Estudiante -->
<div class="card border-info">
    <div class="card-header bg-info">
        <div class="row">
            <div class="col-md-2">
                <button type="button" onclick="historial_academico()" class="btn btn-block btn-light text-info">Historial Academico</button>
            </div>
            <div class="col-md-2">
                <button type="button" onclick="pensum()" class="btn btn-block btn-light text-info">Pensum</button>
            </div>
            <div class="col-md-2">
                <button type="button" onclick="materias()" class="btn btn-block btn-light text-info">Materias Actuales</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-block btn-light text-info">Mensualidades</button>
            </div>
            <div class="col-md-2">
                <button type="button" onclick="carreras()" class="btn btn-block btn-light text-info">Carreras</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-block btn-light text-info">Extras</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div id="detalleAcademicoAjax">
                    <!-- <p>Elegir algo</p> -->
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<!-- Pizarra que refleja la Informacion Academica de Estudiante -->
@stop

@section('js')
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/forms/select2/select2.init.js') }}"></script>
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/jquery.zoom.js') }}"></script>
<script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/jquery.repeater/repeater-init.js') }}"></script>
<script>
    // Funcion donde definimos cabecera donde estara el token y poder hacer nuestras operaciones de put,post...
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Tabs para Informacion Personal del Estudiante
    $('#tabsEstudiante div .btn').click(function () {
        var t = $(this).attr('id');
        if ($(this).hasClass('inactivo')) { //preguntamos si tiene la clase inactivo 
            $('#tabsEstudiante div .btn').addClass('inactivo');
            $(this).removeClass('inactivo');

            $('.tabContenido').hide();
            $('#' + t + 'C').fadeIn('slow');
        }
    });

    // Funcion para que cargue de inicio la funcion ajax historial_academico
    $(window).on("load", materias);

    // Funcion que se ejecuta al hacer clic en Historial Academico
    function historial_academico(){
        persona_id = $('#persona_id').val();
        $.ajax({
            url: "{{ url('Persona/ajaxDetalleHistorialAcademico') }}",
            data: {
                persona_id : persona_id
                },
            type: 'get',
            success: function(data) {
                $("#detalleAcademicoAjax").show('slow');
                $("#detalleAcademicoAjax").html(data);
            }
        });
    }

    // Funcion que se ejecuta al hacer clic en pensum
    function pensum(){
        persona_id = $('#persona_id').val();
        $.ajax({
            url: "{{ url('Persona/ajaxDetallePensum') }}",
            data: {
                persona_id : persona_id
                },
            type: 'get',
            success: function(data) {
                $("#detalleAcademicoAjax").show('slow');
                $("#detalleAcademicoAjax").html(data);
            }
        });
    }

    // Funcion que se ejecuta al hacer clic en materias
    function materias(){
        persona_id = $('#persona_id').val();
        $.ajax({
            url: "{{ url('Persona/ajaxDetalleMaterias') }}",
            data: {
                persona_id : persona_id
                },
            type: 'get',
            success: function(data) {
                $("#detalleAcademicoAjax").show('slow');
                $("#detalleAcademicoAjax").html(data);
            }
        });
    }

    // Funcion que se ejecuta al hacer clic en Carreras
    function carreras(){
        persona_id = $('#persona_id').val();
        $.ajax({
            url: "{{ url('Persona/ajaxDetalleCarreras') }}",
            data: {
                persona_id : persona_id
                },
            type: 'get',
            success: function(data) {
                $("#detalleAcademicoAjax").show('slow');
                $("#detalleAcademicoAjax").html(data);
            }
        });
    }
    
</script>
@endsection