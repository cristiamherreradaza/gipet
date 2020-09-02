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
                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-header bg-warning">
                                <h4 class="mb-0 text-white">REINCRIPCION</h4></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
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

                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Nombre
                                                <span class="text-danger">
                                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                                </span>
                                            </label>
                                            <input type="text" class="form-control" name="nombres" id="nombres" required>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Carrera 
                                                <span class="text-danger">
                                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                                </span>
                                            </label>
                                            <select name="carrera_id" id="carrera_id" class="form-control">
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Turno 
                                                <span class="text-danger">
                                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                                </span>
                                            </label>
                                            <select name="turno" id="turno" class="form-control">
                                                <option value="Mañana">Mañana</option>
                                                <option value="Tarde">Tarde</option>
                                                <option value="Noche">Noche</option>
                                                <option value="Especial">Especial</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Paralelo 
                                                <span class="text-danger">
                                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                                </span>
                                            </label>
                                            <select name="paralelo" id="paralelo" class="form-control">
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Gestion
                                                <span class="text-danger">
                                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                                </span>
                                            </label>
                                            <input type="text" class="form-control" name="gestion" id="gestion" value="{{ date('Y') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-right">
                                    <a href="javascript:void(0)" class="btn btn-inverse">Ver Asignaturas</a>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-success">
                                <h4 class="mb-0 text-white">ASIGNATURAS POR TOMAR</h4></div>
                            <div class="card-body">
                                <div class="table-responsive m-t-40">
                                    <table id="myTable" class="table table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>Asignatura</th>
                                                <th>Codigo</th>
                                                <th>Turno</th>
                                                <th>Paralelo</th>
                                                <th>Accion</th>
                                        </thead>
                                        <tbody>
                                                <tr>
                                                    <td>
                                                        Informatica 1
                                                    </td>
                                                    <td>
                                                        Inf - 111
                                                    </td>
                                                    <td>
                                                        <select class="form-control custom-select" data-placeholder="Choose a Category" id="re_asig_turno" name="re_asig_turno[]" required>
                                                            <option value="Mañana">Mañana</option>
                                                            <option value="Tarde">Tarde</option>
                                                            <option value="Noche">Noche</option>
                                                            <option value="Especial">Especial</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control custom-select" data-placeholder="Choose a Category" id="re_asig_paralelo" name="re_asig_paralelo[]" required>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="C">C</option>
                                                            <option value="D">D</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="checkbox" class="todo" name="asignatura_id[]" checked></td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
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
    $(function () {
        $('#myTable').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });

    });
</script>
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
                    $('#nombres').val(data.persona.nombres +' '+ data.persona.apellido_paterno +' '+ data.persona.apellido_materno);
                     $('#carrera_id').empty();
                        $.each(data.carreras, function(index, value){
                            $('#carrera_id').append('<option value="'+ data.carreras[index].id +'">'+ data.carreras[index].nombre +'</option>');
                        });
                }
                
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


@endsection