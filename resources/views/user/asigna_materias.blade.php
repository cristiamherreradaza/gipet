@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.min.css') }}">
@endsection

@section('content')

<!-- inicio modal content -->
<div id="modal_asigna" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">ASIGNACION DE MATERIA</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            Materia: <span></span>
                        </div>
                    </div>
                    <form action="#" method="POST" id="formulario_modal_asignatura">
                        @csrf
                        <input type="hidden" name="asignatura_id" id="asignatura_id" value="">
                        <input type="hidden" name="anio_vigente" id="anio_vigente" value="">
                        <div class="row">

                            <div class="col-md-5">

                                <div class="form-group">
                                    <label class="control-label">Carrera</label>
                                    <select name="carrera_id" id="carrera_id" class="form-control custom-select" required>
                                        <option value="">Seleccione</option>
                                        {{-- @foreach ($carreras as $c) --}}
                                            {{-- <option value="{{ $c->id }}">{{ $c->nombre }}</option> --}}
                                        {{-- @endforeach --}}
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Curso</label>
                                    <select name="gestion" id="gestion" class="form-control custom-select" >
                                        <option value="1">Primero</option>
                                        <option value="2">Segundo</option>
                                        <option value="3">Tercero</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guarda_asignatura()">GUARDA ASIGNATURA</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- fin modal -->

<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-md-6">
                <h3>
                    Nombre: 
                    <span class="text-info">
                        {{ $datos_persona->apellido_paterno }}
                        {{ $datos_persona->apellido_materno }}
                        {{ $datos_persona->nombres }}
                    </span>
                </h3>
            </div>
        </div>

        <div class="row">
            
            <div class="col-md-6">
                
                <div class="card card-outline-primary">                                
                    <div class="card-header">
                        <h4 class="mb-0 text-white">ASIGNATURAS</h4>
                    </div>

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
                                @foreach($asignaturas as $a)
                                    <tr>
                                        <td>{{ $a->codigo_asignatura }}</td>
                                        <td>{{ $a->carrera->nombre }}</td>
                                        <td>{{ $a->nombre_asignatura }}</td>
                                        <td class="text-center">{{ $a->gestion }}</td>
                                        <td>
                                            <button type="button" class="btn btn-success" onclick="asigna_materia('{{ $a->id }}', '{{ $a->nombre_asignatura }}', '{{ $a->codigo_asignatura }}')"><i
                                                    class="fas fa-arrow-right"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="mb-0 text-white">ASIGNATURAS DEL DOCENTE</h4>
                    </div>
                
                    <div class="table-responsive m-t-40">
                        <table id="tabla-asignaturas-docente" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sigla</th>
                                    <th>Carrera</th>
                                    <th>Nombre</th>
                                    <th>Curso</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($asignaturas_docente as $ad)
                                <tr>
                                    <td>{{ $ad->asignatura->codigo_asignatura }}</td>
                                    <td>{{ $ad->asignatura->carrera->nombre }}</td>
                                    <td>{{ $ad->asignatura->nombre_asignatura }}</td>
                                    <td>{{ $ad->gestion }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger"
                                            onclick="elimina_asignatura('{{ $ad->id }}', '{{ $ad->nombre_asignatura }}')"><i
                                                class="fas fa-trash"></i></button>
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

@stop

@section('js')
<script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
<!-- Sweet-Alert  -->
<script src="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweet-alert.init.js') }}"></script>

<script>

    var tabla_asignaturas;

    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        tabla_asignaturas = $('#tabla-asignaturas').DataTable();
    });

    $(function () {
        $('#tabla-asignaturas-docente').DataTable();
    });

    function asigna_materia(asignatura_id, nombre_asignatura, codigo_asignatura)
    {
        console.log(nombre_asignatura);
    }








    $('#formulario_carreras').on('submit', function (event) {
        event.preventDefault();
        var datos_formulario = $(this).serializeArray();
        var carrera_id = $("#carrera_id").val();

        $.ajax({
            url: "{{ url('Carrera/ajax_lista_asignaturas') }}",
            method: "GET",
            data: datos_formulario,
            cache: false,
            success: function (data) {
                $("#carga_ajax_lista_asignaturas").html(data);
            }
        })
    });

    function guarda_asignatura() {
        formulario_asignatura = $("#formulario_modal_asignatura").serializeArray();
        carrera_id            = $("#carrera_id").val();
        gestion               = $("#anio_vigente").val();
        console.log(gestion);
        $.ajax({
            url: "{{ url('Asignatura/guarda') }}",
            method: "POST",
            data: formulario_asignatura,
            cache: false,
            success: function(data)
            {
                if (data.sw == 1) 
                {
                    $.ajax({
                        url: "{{ url('Carrera/ajax_lista_asignaturas') }}",
                        method: "GET",
                        data: {c_carrera_id: carrera_id, c_gestion: gestion},
                        cache: false,
                        success: function (data) {
                            $("#carga_ajax_lista_asignaturas").html(data);
                        }
                    });

                    Swal.fire(
                        'Excelente!',
                        'Los datos fueron guadados',
                        'success'
                    ).then(function() {
                        $("#modal_asignaturas").modal('hide');
                    });
                } else {

                }
                // respuesta = JSON.parse(data);
                // console.log(data.sw);

                // $("#carga_ajax_lista_asignaturas").html(data);
            }
        })
        // console.log(formulario_asignatura);
        // alert('entro');
    }

    function elimina_asignatura(asignatura_id, nombre)
    {
        Swal.fire({
            title: 'Quieres borrar ' + nombre + '?',
            text: "Luego no podras recuperarlo!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {

                $.ajax({
                    url: "{{ url('Asignatura/eliminar') }}/"+asignatura_id,
                    method: "GET",
                    cache: false,
                    success: function (data) {

                        $.ajax({
                            url: "{{ url('Carrera/ajax_lista_asignaturas') }}",
                            method: "GET",
                            data: {c_carrera_id: data.carrera_id, c_gestion: data.anio_vigente},
                            cache: false,
                            success: function (data) {
                                $("#carga_ajax_lista_asignaturas").html(data);
                            }
                        });

                        Swal.fire(
                            'Excelente!',
                            'La materia fue eliminada',
                            'success'
                        );
                    }
                });

            }
        })

    }
</script>
@endsection