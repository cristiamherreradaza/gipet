@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h3>
                    Docente: 
                    <span class="text-info">
                        {{ $docente->apellido_paterno }}
                        {{ $docente->apellido_materno }}
                        {{ $docente->nombres }}
                    </span>
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card border-primary">
                    <div class="card-header bg-primary">
                        <h4 class="mb-0 text-white">ASIGNATURAS</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive m-t-40">
                            <table id="tabla-asignaturas" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sigla</th>
                                        <th>Carrera</th>
                                        <th>Nombre</th>
                                        <th>A&ntilde;o</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($asignaturas as $asignatura)
                                        <tr>
                                            <td>{{ $asignatura->sigla }}</td>
                                            <td>{{ $asignatura->carrera->nombre }}</td>
                                            <td>{{ $asignatura->nombre }}</td>
                                            <td class="text-center">{{ $asignatura->gestion }}</td>
                                            <td>
                                                <button type="button" class="btn btn-success" onclick="asigna_materia('{{ $asignatura->id }}', '{{ $asignatura->nombre }}', '{{ $asignatura->sigla }}', '{{ $asignatura->carrera->nombre }}')">
                                                    <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-info">
                    <div class="card-header bg-info">
                        <h4 class="mb-0 text-white">ASIGNATURAS DEL DOCENTE</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive m-t-40">
                            <table id="tabla-asignaturas-docente" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sigla</th>
                                        <th>Carrera</th>
                                        <th>Nombre</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($asignaturas_docente as $asignatura)
                                    <tr>
                                        <td>{{ $asignatura->asignatura->sigla }}</td>
                                        <td>{{ $asignatura->asignatura->carrera->nombre }}</td>
                                        <td>{{ $asignatura->asignatura->nombre }}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger" onclick="elimina_asignacion('{{ $asignatura->id }}', '{{ $asignatura->asignatura->nombre }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- inicio modal asigna materia -->
<div id="modal_asigna" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-coloured bg-success">
                <h4 class="modal-title text-white" id="myModalLabel">ASIGNACI&Oacute;N DE MATERIA</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5><b class="text-danger">CARRERA: </b><span id="modal_carrera_materia"></span></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5><b class="text-danger">SIGLA: </b><span id="modal_sigla_materia"></span></h5>
                    </div>
                    <div class="col-md-8">
                        <h5><b class="text-danger">NOMBRE: </b><span id="modal_nombre_materia"></span></h5>
                    </div>
                </div>
                <hr>
                <form action="#" method="POST" id="formulario_modal_asignacion">
                    @csrf
                    <input type="hidden" name="asignatura_id" id="fm_asignatura_id" value="">
                    <input type="hidden" name="user_id" id="fm_user_id" value="{{ $docente->id }}">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Turno</label>
                                <select name="turno_id" id="turno_id" class="form-control custom-select" required>
                                    @foreach ($turnos as $turno)
                                        <option value="{{ $turno->id }}">{{ $turno->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Paralelo</label>
                                <select name="paralelo" id="paralelo" class="form-control custom-select" >
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">A&ntilde;o</label>
                                <input type="number" name="anio_vigente" id="anio_vigente" class="form-control" value="{{ date('Y') }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn waves-effect waves-light btn-block btn-success" onclick="guarda_asignacion()">ASIGNAR</button>
            </div>
        </div>
    </div>
</div>
<!-- fin modal asigna materia -->
@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>

<script>

    var tabla_asignaturas;

    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        tabla_asignaturas = $('#tabla-asignaturas').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });

    $(function () {
        $('#tabla-asignaturas-docente').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });

    function asigna_materia(asignatura_id, nombre_asignatura, codigo_asignatura, nombre_carrera)
    {
        $("#modal_sigla_materia").html(codigo_asignatura);
        $("#modal_nombre_materia").html(nombre_asignatura);
        $("#modal_carrera_materia").html(nombre_carrera);
        $("#fm_asignatura_id").val(asignatura_id);
        $("#modal_asigna").modal('show');
        // console.log(nombre_asignatura);
    }

    // Funcion ajax que al presionar el boton "ASIGNAR" que captura los valores del formulario del modal
    // los envia para el procesamiento en el controlador
    function guarda_asignacion() {
        formulario_asignacion = $("#formulario_modal_asignacion").serializeArray();
        $.ajax({
            url: "{{ url('User/guarda_asignacion') }}",
            data: formulario_asignacion,
            type: 'post',
            cache: false,
            success: function(data)
            {
                if (data.duplicado == 'Si') 
                {
                    Swal.fire(
                        'Error!',
                        'La materia ya esta asignada al docente.',
                        'warning'
                    ).then(function() {
                        $("#modal_asigna").modal('hide');
                    });
                } else {
                    Swal.fire(
                        'Bien!',
                        'La materia esta asignada al docente',
                        'success'
                    );
                    window.location.href = "{{ url('User/asigna_materias') }}/" + {{ $docente->id }};
                }
            }
        })
    }

    // Funcion para la eliminacion de una materia a un docente
    function elimina_asignacion(np_id, nombre)
    {
        Swal.fire({
            title: 'Quieres retirar ' + nombre + '?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    url: "{{ url('User/eliminaAsignacion') }}/"+np_id,
                    type: 'get',
                    cache: false,
                    success: function (data) {
                        Swal.fire(
                            'Excelente!',
                            'El docente fue retirado de la materia.',
                            'success'
                        );
                        window.location.href = "{{ url('User/asigna_materias') }}/" + data.usuario;
                    }
                });

            }
        })
    }
</script>
@endsection