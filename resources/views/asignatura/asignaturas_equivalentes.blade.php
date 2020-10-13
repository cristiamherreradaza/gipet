@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')
<div class="card border-info" id="mostrar" style="display:none;">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            Nueva Equivalencia de Asignaturas
        </h4>
    </div>
    <div class="card-body" id="lista">
        <form action="{{ url('Asignatura/guardar') }}"  method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Asignatura 1</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <select class="select2 form-control custom-select" id="asignatura_1" style="width: 100%; height:36px;" required>
                                <option value="">Buscar Asignatura</option>
                                @foreach ($carreras as $carrera_a)
                                <optgroup label="{{ $carrera_a->nombre }}">
                                    @foreach($asignaturas as $asignatura_a)
                                        @if($carrera_a->id == $asignatura_a->carrera_id)
                                            <option value="{{ $asignatura_a->id }}">{{ $asignatura_a->sigla }} {{ $asignatura_a->nombre }}</option>
                                        @endif
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                            
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Asignatura 2</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <select class="select2 form-control custom-select" id="asignatura_2" style="width: 100%; height:36px;" required>
                                <option>Buscar Equivalencia</option>
                                @foreach ($carreras as $carrera_b)
                                <optgroup label="{{ $carrera_b->nombre }}">
                                    @foreach($asignaturas as $asignatura_b)
                                        @if($carrera_b->id == $asignatura_b->carrera_id)
                                            <option value="{{ $asignatura_b->id }}">{{ $asignatura_b->sigla }} {{ $asignatura_b->nombre }}</option>
                                        @endif
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Gestion</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <input name="anio_vigente" type="number" id="anio_vigente" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_asignatura_equivalente()">Guardar</button>
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
                        <th>Opciones</th>
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
                                <button type="button" class="btn btn-info" title="Editar equivalencia"  onclick="editar('{{ $equivalencia->id }}', '{{ $equivalencia->nombre }}', '{{ $equivalencia->porcentaje }}')"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar equivalencia"  onclick="eliminar('{{ $equivalencia->id }}', '{{ $equivalencia->nombre }}')"><i class="fas fa-trash-alt"></i></button>
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

    // $(document).ready(function(){
    //     $.ajax({
    //         type:'GET',
    //         url:"{{ url('Asignatura/ajax_lista') }}",
    //         success:function(data){
    //             // $("#grafico_alcance").show('slow');
    //             $("#lista_equivalencias").html(data);
    //         }
    //     });
    // });

    function guardar_asignatura_equivalente(){
        // var asignatura_1 = $("#asignatura_1").val();
        // var asignatura_2 = $("#asignatura_2").val();
        // var anio_vigente = $("#anio_vigente").val();
        // $.ajax({
        //     type:'POST',
        //     url:"{{ url('Asignatura/guarda_equivalentes') }}",
        //     data: {
        //         asignatura_1 : asignatura_1,
        //         asignatura_2 : asignatura_2,
        //         anio_vigente : anio_vigente
        //     },
        //     success:function(data){
        //         $("#asignatura_1").val('');
        //         $("#asignatura_2").val('');
        //         $("#anio_vigente").val('');
                Swal.fire(
                    'Excelente!',
                    'Se guardo Correctamente.',
                    'success'
                )
        //         $("#lista_equivalencias").html(data);
        //     }
        // });
    }
    function nueva_carrera()
    {
        $('#mostrar').show('slow');
    }

    function cerrar_datos_carrera()
    {
        $('#mostrar').hide('slow');
    }
</script>
@endsection
