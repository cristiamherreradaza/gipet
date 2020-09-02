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
        <form action="{{ url('Inscripcion/guardar') }}" method="POST" >
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card border-dark">
                                <div class="card-header bg-dark">
                                    <h4 class="mb-0 text-white">DATOS PERSONALES</h4></div>
                                <div class="card-body">
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
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card border-info">
                                <div class="card-header bg-info">
                                    <h4 class="mb-0 text-white">CURSOS - VARIOS</h4></div>
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
                                                    <option value="0">Seleccionar</option>
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
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success">Guardar</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ url('Persona/listado') }}">
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
                if (data.mensaje == 'si') {
                    $('#persona_id').val(data.persona.id);
                    $('#expedido').val(data.persona.expedido);
                    $('#apellido_paterno').val(data.persona.apellido_paterno);
                    $('#apellido_materno').val(data.persona.apellido_materno);
                    $('#nombres').val(data.persona.nombres);
                    $('#fecha_nacimiento').val(data.persona.fecha_nacimiento);
                    $('#email').val(data.persona.email);
                    $('#direccion').val(data.persona.direccion);
                    $('#telefono_celular').val(data.persona.telefono_celular);
                    $('#sexo').val(data.persona.sexo);
                }
                
            }
        });
           
    });
</script>


@endsection