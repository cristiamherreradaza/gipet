@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <h4>
                    <span class="text-info">APELLIDO PATERNO: </span>
                    {{ $datosPersona->apellido_paterno }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">APELLIDO MATERNO: </span>
                    {{ $datosPersona->apellido_materno }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">NOMBRES: </span>
                    {{ $datosPersona->nombres }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">FECHA NACIMIENTO: </span>
                    {{ $datosPersona->fecha_nacimiento }}
                </h4>
            </div>

        </div>

        <div class="row">
            <div class="col-md-3">
                <h4>
                    <span class="text-info">CARNET: </span>
                    {{ $datosPersona->cedula }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">EXPEDIDO: </span>
                    {{ $datosPersona->expedido }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">CELULAR: </span>
                    {{ $datosPersona->celular }}
                </h4>
            </div>

            <div class="col-md-3">
                <h4>
                    <span class="text-info">EMAIL: </span>
                    {{ $datosPersona->email }}
                </h4>
            </div>

        </div>

    </div>

    <div class="card border-info" id="mostrar" style="display:block;">
        <div class="card-header bg-info">
            <h4 class="mb-0 text-white">
                DATOS PARA LA FACTURA
            </h4>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-3">
                    <div class="form-group">
                        <label>Servicio 
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                        </label>
                        <select name="servicio_id" id="servicio_id" class="form-control" required>
                            @foreach ($servicios as $s)
                                <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>CANTIDAD 
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control" name="cantidad" id="cantidad" value="{{ $datosPersona->nit }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>NIT 
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control" name="nit" id="nit" value="{{ $datosPersona->nit }}" required>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>RAZON SOCIAL 
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                        </label>
                        <input type="text" class="form-control" name="razon_social" id="razon_social" value="{{ $datosPersona->razon_social_cliente }}" required>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<!-- This Page JS -->
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/forms/select2/select2.init.js') }}"></script>

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

    function guardar_asignatura_equivalente(){
        var asignatura_1 = $("#asignatura_1").val();
        var asignatura_2 = $("#asignatura_2").val();
        var anio_vigente = $("#anio_vigente").val();
        if(asignatura_1.length>0 && asignatura_2.length>0 && anio_vigente.length>0){
            Swal.fire(
                'Excelente!',
                'Se guardo Correctamente.',
                'success'
            )
        }
    }

    function eliminar(id, nombre)
    {
        Swal.fire({
            title: 'Quieres borrar la equivalencia?',
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
                    'La equivalencia fue eliminada',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Asignatura/elimina_equivalentes') }}/"+id;
                });
            }
        })
    }

    function nueva_carrera()
    {
        $('#mostrar').show('slow');
    }

    function cerrar_datos_carrera()
    {
        $('#mostrar').hide('slow');
    }

    function buscaCarrera1()
    {
        let gestion = $("#gestion_1").val();
        let carrera = $("#carrera_1").val();

        $.ajax({
            url: "{{ url('Asignatura/ajax_busca_asignatura') }}",
            data: {
                gestion: gestion,
                carrera: carrera,
            },
            type: 'get',
            success: function(data) {
                $("#ajaxMuestraAsignatura1").html(data);
            }
        });
    }

    function buscaCarrera2()
    {
        let gestion2 = $("#gestion_2").val();
        let carrera2 = $("#carrera_2").val();

        $.ajax({
            url: "{{ url('Asignatura/ajax_busca_asignaturas') }}",
            data: {
                gestion: gestion2,
                carrera: carrera2,
            },
            type: 'get',
            success: function(data) {
                $("#ajaxMuestraAsignatura2").html(data);
            }
        });
    }
</script>
@endsection
