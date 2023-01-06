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
    <div class="col-md-12">
        <form action="{{ url('Inscripcion/guardar') }}" method="POST" >
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card border-info">
                        <div class="card-header bg-info">
                            <h4 class="mb-0 text-white">NUEVA INSCRIPCION</h4>
                        </div>
                        <div class="card-body">
                            <div class="row" id="tabsProductos">
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
                                                            <input type="text" class="form-control" name="carnet" id="carnet" required>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control" hidden name="persona_id" id="persona_id">
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
                                                                <option value="">QR</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Apellido Paterno </label>
                                                            <input type="text" class="form-control" name="apellido_paterno" id="apellido_paterno">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Apellido Materno </label>
                                                            <input type="text" class="form-control" name="apellido_materno" id="apellido_materno">
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
                                                                <option value="Femenino">Femenino</option>
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
                                                <!--/row-->
                                                <!-- NOMBRE DEL ATRIBUTO ENCIMA -->
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">Trabaja</label>
                                                            <select class="form-control" id="trabaja" name="trabaja">
                                                                <option value="Si">Si</option>
                                                                <option value="No" selected>No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- row -->
                                                <div class="row">
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
                                    <div class="card border-info">
                                        <div class="card-body">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Nombre </label>
                                                            <input type="text" class="form-control" name="nombre_padre" id="nombre_padre">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Celular</label>
                                                            <input type="text" class="form-control" name="celular_padre" id="celular_padre">
                                                        </div>
                                                    </div>

                                                    {{-- <div class="col-3">
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
                                                    </div> --}}

                                                </div>

                                                {{-- <div class="row">
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
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success">GUARDAR</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ url('Persona/listado') }}">
                                        <button type="button" class="btn waves-effect waves-light btn-block btn-inverse">CANCELAR</button>
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
    // Funcion donde definimos cabecera donde estara el token y poder hacer nuestras operaciones de put,post...
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Funcion que al insertar un numero en el Campo Carnet, busca y devuevle 1 coincidencia
    $('#carnet').on('change', function(e){
        var carnet = e.target.value;
        //alert(carnet);
        $.ajax({
            type:'GET',
            url:"{{ url('Inscripcion/busca_ci') }}",
            data: {
                ci : carnet
            },
            success:function(data){
                if (data.mensaje == 'si') {
                    $('#persona_id').val(data.persona.id);
                    $('#apellido_paterno').val(data.persona.apellido_paterno);
                    $('#apellido_materno').val(data.persona.apellido_materno);
                    $('#nombres').val(data.persona.nombres);
                    //cedula
                    $('#expedido').val(data.persona.expedido);
                    $('#fecha_nacimiento').val(data.persona.fecha_nacimiento);
                    $('#sexo').val(data.persona.sexo);
                    $('#direccion').val(data.persona.direccion);
                    // numero_fijo
                    $('#telefono_celular').val(data.persona.numero_celular);
                    $('#email').val(data.persona.email);
                    $('#trabaja').val(data.persona.trabaja);
                    $('#empresa').val(data.persona.empresa);
                    $('#direccion_empresa').val(data.persona.direccion_empresa);
                    $('#telefono_empresa').val(data.persona.numero_empresa);
                    $('#fax').val(data.persona.fax);
                    $('#email_empresa').val(data.persona.email_empresa);
                    $('#nombre_padre').val(data.persona.nombre_padre);
                    $('#celular_padre').val(data.persona.celular_padre);
                    $('#nombre_madre').val(data.persona.nombre_madre);
                    $('#celular_madre').val(data.persona.celular_madre);
                    $('#nombre_tutor').val(data.persona.nombre_tutor);
                    $('#telefono_tutor').val(data.persona.celular_tutor);
                    $('#nombre_esposo').val(data.persona.nombre_pareja);
                    $('#telefono_esposo').val(data.persona.celular_pareja);
                    // nit
                    // razon_social_cliente

                }
            }
        });
    });



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
                                        @foreach($carreras as $carrera)\
                                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>\
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
                                        @foreach($turnos as $turno)\
                                        <option value="{{ $turno->id }}">{{ $turno->descripcion }}</option>\
                                        @endforeach\
                                    </select>\
                                </div>\
                            </div>\
                            <div class="col">\
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
                            <div class="col">\
                                <div class="form-group">\
                                    <label class="control-label">Gesti&oacute;n</label>\
                                    <input type="number" class="form-control" id="gestion_' + room + '" name="gestion_' + room + '" value="{{ $anio_actual }}">\
                                </div>\
                            </div>\
                            <input type="text" hidden name="numero[]" id="numero" value="' + room + '">\
                            <div class="col-1">\
                                <div class="form-group">\
                                    <label class="control-label"></label><br>\
                                    <button class="btn btn-danger" type="button" title="Retirar carrera" onclick="remove_education_fields(' + room + ');"> <i class="fa fa-minus"></i>\
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
@endsection
