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
<div class="row">
    <!-- Column -->
    <div class="col-md-12">
        <!-- Row -->
        {{-- <form action="{{ url('Producto/guarda') }}"  method="post" enctype="multipart/form-data" > --}}
        <form action="{{ url('Prueba/guardar') }}" method="GET" >
            @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-info">
                    <div class="card-header bg-info">
                        <h4 class="mb-0 text-white">NUEVO ALUMNO</h4>
                    </div>
                        <div class="card-body">
                            <div class="row" id="tabsProductos">
                                <div class="col-md-2">
                                    <button type="button" id="tab1" class="btn btn-block btn-inverse activo">DATOS PERSONALES</button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="tab2" class="btn btn-block btn-primary inactivo">DATOS PROFESIONALES</button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="tab3" class="btn btn-block btn-warning inactivo">REFERENCIA PERSONAL</button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="tab4" class="btn btn-block btn-info inactivo">DATOS DE LA CARRERA</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" id="tab5" class="btn btn-block btn-success inactivo">ASIGNATURAS ADICIONALES</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 tabContenido" id="tab1C">
                                    <div class="card border-inverse">
                                        <div class="card-body">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Carnet 
                                                                <span class="text-danger">
                                                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                                                </span>
                                                             </label>
                                                            <input type="text" class="form-control" name="carnet" id="carnet" required>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" hidden name="persona_id" id="persona_id" required>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Expedido 
                                                                <span class="text-danger">
                                                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                                                </span>
                                                            </label>
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
                                                            <label>Nombres
                                                                <span class="text-danger">
                                                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                                                </span>
                                                            </label>
                                                            <input type="text" class="form-control" name="nombres" id="nombres" required>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Fecha Nacimiento
                                                                <span class="text-danger">
                                                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                                                </span>
                                                            </label>
                                                            <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Email </label>
                                                            <input type="text" class="form-control" name="email" id="email">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Direccion </label>
                                                            <input type="text" class="form-control" name="direccion" id="direccion">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular 
                                                                <span class="text-danger">
                                                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                                                </span>
                                                            </label>
                                                            <input type="text" class="form-control" name="telefono_celular" id="telefono_celular" required>
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
                                <div class="col-md-12 tabContenido" id="tab2C" style="display: none;">
                                    <div class="card border-primary">
                                        <div class="card-body">
                                            <div class="form-body">
                                                <!--/row-->
                                                <!-- NOMBRE DEL ATRIBUTO ENCIMA -->
                                                <div class="row pt-3">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Trabaja 
                                                                <span class="text-danger">
                                                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                                                </span>
                                                            </label>
                                                            <select class="form-control" id="trabaja" name="trabaja" required>
                                                                <option value="">Seleccionar</option>
                                                                <option value="Si">Si</option>
                                                                <option value="No">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- row -->
                                                <div class="row pt-3">
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
                                <div class="col-md-12 tabContenido" id="tab3C" style="display: none;">
                                    <div class="card border-warning">
                                        <div class="card-body">
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
                                <div class="col-md-12 tabContenido" id="tab4C" style="display: none;">
                                    <div class="card border-info">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>Carrera
                                                            <span class="text-danger">
                                                                <i class="mr-2 mdi mdi-alert-circle"></i>
                                                            </span>
                                                        </label>
                                                        <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="carrera_1" name="carrera_1">
                                                            <option value="">Seleccionar</option>
                                                            @foreach($carreras as $carre)
                                                            <option value="{{ $carre->id }}">{{ $carre->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>Turno
                                                            <span class="text-danger">
                                                                <i class="mr-2 mdi mdi-alert-circle"></i>
                                                            </span>
                                                        </label>
                                                        <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_1" name="turno_1">
                                                            <option value="">Seleccionar</option>
                                                            @foreach($turnos as $tur)
                                                            <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>Paralelo
                                                            <span class="text-danger">
                                                                <i class="mr-2 mdi mdi-alert-circle"></i>
                                                            </span>
                                                        </label>
                                                        <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_1" name="paralelo_1">
                                                            <option value="">Seleccionar</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Gesti&oacute;n</label>
                                                        <input type="text" class="form-control" id="gestion_1" name="gestion_1" value="{{ $year }}">
                                                    </div>
                                                </div>
                                                <input type="text" hidden name="cantidad" id="cantidad" value="1">
                                                <input type="text" hidden name="numero[]" id="numero" value="1">    
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2 col-md-12">
                                                    <div class="form-group">
                                                        <button class="btn btn-success" type="button" onclick="education_fields();">ADICIONAR CARRERA</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="education_fields">
                                                {{-- content --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 tabContenido" id="tab5C" style="display: none;">
                                    <div class="card border-success">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>Asignatura
                                                            <span class="text-danger">
                                                                <i class="mr-2 mdi mdi-alert-circle"></i>
                                                            </span>
                                                        </label>
                                                        <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_1" name="asignatura_1">
                                                            <option value="">Seleccionar</option>
                                                            @foreach($asignaturas as $asig)
                                                            <option value="{{ $asig->id }}">{{ $asig->nombre_asignatura }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>Turno
                                                            <span class="text-danger">
                                                                <i class="mr-2 mdi mdi-alert-circle"></i>
                                                            </span>
                                                        </label>
                                                        <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_asig_1" name="turno_asig_1">
                                                            <option value="">Seleccionar</option>
                                                            @foreach($turnos as $tur)
                                                            <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>Paralelo
                                                            <span class="text-danger">
                                                                <i class="mr-2 mdi mdi-alert-circle"></i>
                                                            </span>
                                                        </label>
                                                        <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_asig_1" name="paralelo_asig_1">
                                                            <option value="">Seleccionar</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label class="control-label">Gesti&oacute;n</label>
                                                        <input type="text" class="form-control" id="gestion_asig_1" name="gestion_asig_1" value="{{ $year }}">
                                                    </div>
                                                </div>
                                                <input type="text" hidden name="cantidad_asig" id="cantidad_asig" value="1">
                                                <input type="text" hidden name="numero_asig[]" id="numero_asig" value="1">    
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-2 col-md-12">
                                                    <div class="form-group">
                                                        <button class="btn btn-info" type="button" onclick="education_fieldss();">ADICIONAR ASIGNATURAS</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="education_fieldss">
                                                {{-- content --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success">Guardar</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ url('Producto/listado') }}">
                                        <button type="button" class="btn waves-effect waves-light btn-block btn-inverse">Cancelar</button>
                                    </a>
                                </div>
                            </div>

                        </div>
                    

                </div>
            </div>
        </div>
        </form>

        <!-- Row -->
    </div>
    <!-- Column -->
</div>
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
    var room = 1;
    var cantidad = 1;
    function education_fields() {

        room++;
        cantidad++;
        var objTo = document.getElementById('education_fields')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "row removeclass" + room);
        var rdiv = 'removeclass' + room;
        divtest.innerHTML = '<div class="col-3">\
                                <div class="form-group">\
                                    <label>Carrera\
                                        <span class="text-danger">\
                                            <i class="mr-2 mdi mdi-alert-circle"></i>\
                                        </span>\
                                    </label>\
                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="carrera_' + room + '" name="carrera_' + room + '">\
                                        <option value="">Seleccionar</option>\
                                        @foreach($carreras as $carre)\
                                        <option value="{{ $carre->id }}">{{ $carre->nombre }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="col-3">\
                                <div class="form-group">\
                                    <label>Turno\
                                        <span class="text-danger">\
                                            <i class="mr-2 mdi mdi-alert-circle"></i>\
                                        </span>\
                                    </label>\
                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_' + room + '" name="turno_' + room + '">\
                                        <option value="">Seleccionar</option>\
                                        @foreach($turnos as $tur)\
                                        <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="col-2">\
                                <div class="form-group">\
                                    <label>Paralelo\
                                        <span class="text-danger">\
                                            <i class="mr-2 mdi mdi-alert-circle"></i>\
                                        </span>\
                                    </label>\
                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_' + room + '" name="paralelo_' + room + '">\
                                        <option value="">Seleccionar</option>\
                                        <option value="A">A</option>\
                                        <option value="B">B</option>\
                                        <option value="C">C</option>\
                                        <option value="D">D</option>\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="col-2">\
                                <div class="form-group">\
                                    <label class="control-label">Gesti&oacute;n</label>\
                                    <input type="text" class="form-control" id="gestion_' + room + '" name="gestion_' + room + '" value="{{ $year }}">\
                                </div>\
                            </div>\
                            <input type="text" hidden name="numero[]" id="numero" value="' + room + '">\
                            <div class="col-2">\
                                <div class="form-group">\
                                    <label class="control-label"></label>\
                                    <button class="btn btn-danger" type="button" onclick="remove_education_fields(' + room + ');"> <i class="fa fa-minus"></i>\
                                    </button>\
                                </div>\
                            </div>';

        objTo.appendChild(divtest)
        $('#cantidad').val(cantidad);
        // alert(room);
    }

    function remove_education_fields(rid) {
        $('.removeclass' + rid).remove();
        cantidad--;
        $('#cantidad').val(cantidad);
    }

</script>
<script>    
    var room_asig = 1;
    var cantidad_asig = 1;
    function education_fieldss() {

        room_asig++;
        cantidad_asig++;
        var objTo = document.getElementById('education_fieldss')
        var divtest = document.createElement("div");
        divtest.setAttribute("class", "row removeclass_asig" + room_asig);
        var rdiv = 'removeclass_asig' + room_asig;
        divtest.innerHTML = '<div class="col-3">\
                                <div class="form-group">\
                                    <label>Asignatura\
                                        <span class="text-danger">\
                                            <i class="mr-2 mdi mdi-alert-circle"></i>\
                                        </span>\
                                    </label>\
                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="asignatura_' + room_asig + '" name="asignatura_' + room_asig + '">\
                                        <option value="">Seleccionar</option>\
                                        @foreach($asignaturas as $asig)\
                                        <option value="{{ $asig->id }}">{{ $asig->nombre_asignatura }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="col-3">\
                                <div class="form-group">\
                                    <label>Turno\
                                        <span class="text-danger">\
                                            <i class="mr-2 mdi mdi-alert-circle"></i>\
                                        </span>\
                                    </label>\
                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_asig_' + room_asig + '" name="turno_asig_' + room_asig + '">\
                                        <option value="">Seleccionar</option>\
                                        @foreach($turnos as $tur)\
                                        <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="col-2">\
                                <div class="form-group">\
                                    <label>Paralelo\
                                        <span class="text-danger">\
                                            <i class="mr-2 mdi mdi-alert-circle"></i>\
                                        </span>\
                                    </label>\
                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_asig_' + room_asig + '" name="paralelo_asig_' + room_asig + '">\
                                        <option value="">Seleccionar</option>\
                                        <option value="A">A</option>\
                                        <option value="B">B</option>\
                                        <option value="C">C</option>\
                                        <option value="D">D</option>\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="col-2">\
                                <div class="form-group">\
                                    <label class="control-label">Gesti&oacute;n</label>\
                                    <input type="text" class="form-control" id="gestion_asig_' + room_asig + '" name="gestion_asig_' + room_asig + '" value="{{ $year }}">\
                                </div>\
                            </div>\
                            <input type="text" hidden name="numero_asig[]" id="numero_asig" value="' + room_asig + '">\
                            <div class="col-2">\
                                <div class="form-group">\
                                    <label class="control-label"></label>\
                                    <button class="btn btn-danger" type="button" onclick="remove_education_fieldss(' + room_asig + ');"> <i class="fa fa-minus"></i>\
                                    </button>\
                                </div>\
                            </div>';

        objTo.appendChild(divtest)
        $('#cantidad_asig').val(cantidad_asig);
        // alert(room);
    }

    function remove_education_fieldss(rid) {
        $('.removeclass_asig' + rid).remove();
        cantidad_asig--;
        $('#cantidad_asig').val(cantidad_asig);
    }

</script>
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
// generamos los tabs
$('#tabsProductos div .btn').click(function () {
    var t = $(this).attr('id');

    if ($(this).hasClass('inactivo')) { //preguntamos si tiene la clase inactivo 
        $('#tabsProductos div .btn').addClass('inactivo');
        $(this).removeClass('inactivo');

        $('.tabContenido').hide();
        $('#' + t + 'C').fadeIn('slow');
    }
});
</script>
{{-- <script>
// generamos los tabs
$('#carrera_1').on('change', function(e){
        var id = e.target.value;
        

    if ($(this).hasClass('inactivo')) { //preguntamos si tiene la clase inactivo 
        $('#tabsProductos div .btn').addClass('inactivo');
        $(this).removeClass('inactivo');

        $('.tabContenido').hide();
        $('#' + t + 'C').fadeIn('slow');
    }
});
</script> --}}

@endsection