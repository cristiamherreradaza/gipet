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
                        <div class="col-md-5">
                            <div class="card border-primary">
                                <div class="card-header bg-primary">
                                    <h4 class="mb-0 text-white">DATOS PERSONALES</h4></div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
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

                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <label>Nombre
                                                    <span class="text-danger">
                                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                                    </span>
                                                </label>
                                                <input type="text" class="form-control" name="nombres" id="nombres" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
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
                                        <a href="javascript:void(0)" class="btn btn-inverse" onclick="buscar_recuperatorio()">Buscar</a>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="card border-danger">
                                <div class="card-header bg-danger">
                                    <h4 class="mb-0 text-white">ASIGNATURAS - RECUPERATORIO</h4></div>
                                <div class="card-body">
                                    <div class="table-responsive m-t-40">
                                        <table id="myTable" class="table table-bordered table-striped text-center">
                                            <thead>
                                                <tr>
                                                    <th>Carrera</th>
                                                    <th>Asignatura</th>
                                                    <th>Turno</th>
                                                    <th>Paralelo</th>
                                                    <th>Gestion</th>
                                                    <th>Nota</th>
                                                    <th>Accion</th>
                                            </thead>
                                            <tbody id="datos_recuperatorio">
                                                    
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

    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('#myTable').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });

    });

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
                    }
                }
            });
           
    });

    function buscar_recuperatorio() {
        persona_id = $('#persona_id').val();
        gestion = $('#gestion').val();

        $.ajax({
            type:'GET',
            url:"{{ url('Inscripcion/buscar_recuperatorio') }}",
            data: {
                tipo_persona_id : persona_id,
                tipo_gestion : gestion
            },
            success:function(data){
                if (data.mensaje == 'si') {

                    $('#datos_recuperatorio').empty();
                        $.each(data.asignaturas, function(index, value){
                            $('#datos_recuperatorio').append('<tr>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].nombre +'\
                                                                </td>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].nombre_asignatura +'\
                                                                </td>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].descripcion +'\
                                                                </td>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].paralelo +'\
                                                                </td>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].anio_vigente +'\
                                                                </td>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].nota +'\
                                                                </td>\
                                                                <td><button type="button" class="btn btn-success" title="Agregar Asignatura"  onclick="guardar_recuperatorio('+ data.asignaturas[index].persona_id +', '+ data.asignaturas[index].carrera_id +', '+ data.asignaturas[index].asignatura_id +', '+ data.asignaturas[index].anio_vigente +')">Inscribir</button></td>\
                                                            </tr>');
                                                            });
                }
            }
        });
    }

    function guardar_recuperatorio(persona_id, carrera_id, asignatura_id, anio_vigente){

        $.ajax({
                type:'POST',
                url:"{{ url('Transaccion/pago_recuperatorio') }}",
                data: {
                    persona_id : persona_id,
                    carrera_id : carrera_id,
                    asignatura_id : asignatura_id,
                    anio_vigente : anio_vigente
                },
                success:function(data){
                    Swal.fire(
                            'Excelente!',
                            'Se Inscribio Correctamente para el Recuperatorio.',
                            'success'
                        )
                    if (data.mensaje == 'si') {
                        Swal.fire(
                            'Excelente!',
                            'Se guardo Correctamente.',
                            'success'
                        )
                    }
                }
            });
    }

</script>

@endsection