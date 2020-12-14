@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')
<div class="card border-info" id="mostrar" style="display:block;">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            Nueva Equivalencia de Asignaturas
        </h4>
    </div>
    <div class="card-body" id="lista">
        <form action="{{ url('Asignatura/guarda_equivalentes') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Carrera</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <select class="select2 form-control custom-select" name="carrera_1" id="carrera_1"
                                style="width: 100%; height:36px;" onchange="buscaCarrera1()" >
                                @foreach ($carreras as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                    
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Gestion</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <select class="select2 form-control custom-select" name="gestion_1" id="gestion_1"
                                style="width: 100%; height:36px;" onchange="buscaCarrera1()" required>
                                @foreach ($gestiones as $g)
                                    <option value="{{ $g->anio_vigente }}" {{ ($g->anio_vigente == $anio_vigente)?'selected':'' }}>{{ $g->anio_vigente }}</option>
                                @endforeach
                            </select>
                    
                        </div>
                    </div>
                    
                    <div class="col-md-4" id="ajaxMuestraAsignatura1">
                        <div class="form-group">
                            <label class="control-label">Asignatura 1</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <select class="select2 form-control custom-select" name="asignatura_1" id="asignatura_1" style="width: 100%; height:36px;" required>
                                    @foreach($asignaturas as $asignatura_b)
                                        <option value="{{ $asignatura_b->id }}">{{ $asignatura_b->sigla }} {{ $asignatura_b->nombre }}</option>
                                    @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Carrera</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <select class="select2 form-control custom-select" name="carrera_2" id="carrera_2"
                                style="width: 100%; height:36px;" onchange="buscaCarrera2()" >
                                @foreach ($carreras as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                    
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Gestion</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <select class="select2 form-control custom-select" name="gestion_2" id="gestion_2"
                                style="width: 100%; height:36px;" onchange="buscaCarrera2()">
                                @foreach ($gestiones as $g)
                                <option value="{{ $g->anio_vigente }}" {{ ($g->anio_vigente == $anio_vigente)?'selected':'' }}>
                                    {{ $g->anio_vigente }}</option>
                                @endforeach
                            </select>
                
                        </div>
                    </div>
                    
                    <div class="col-md-4" id="ajaxMuestraAsignatura2">
                        <div class="form-group">
                            <label class="control-label">Asignatura 2</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <select class="select2 form-control custom-select" name="asignatura_2" id="asignatura_2"
                                style="width: 100%; height:36px;" required>
                                @foreach($asignaturas as $asignatura_b)
                                <option value="{{ $asignatura_b->id }}">{{ $asignatura_b->sigla }} {{ $asignatura_b->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_asignatura_equivalente()">Guardar</button>
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn waves-effect waves-light btn-block btn-inverse" onclick="cerrar_datos_carrera()">Cerrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            EQUIVALENCIAS &nbsp;&nbsp;
            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nueva_carrera()"><i class="fas fa-plus"></i> &nbsp; NUEVA EQUIVALENCIA</button>
        </h4>
    </div>
    <div class="card-body">
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Carrera 1</th>
                        <th>Asignatura 1</th>
                        <th>Carrera 2</th>
                        <th>Asignatura 2</th>
                        <th>Gestion</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equivalentes as $key => $equivalencia)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $equivalencia->carrera_a->nombre }}</td>
                            <td>{{ $equivalencia->asignatura_a->nombre }}</td>
                            <td>{{ $equivalencia->carrera_b->nombre }}</td>
                            <td>{{ $equivalencia->asignatura_b->nombre }}</td>
                            <td>{{ $equivalencia->anio_vigente }}</td>
                            <td>
                                <button type="button" class="btn btn-danger" title="Eliminar equivalencia"  onclick="eliminar('{{ $equivalencia->id }}')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
