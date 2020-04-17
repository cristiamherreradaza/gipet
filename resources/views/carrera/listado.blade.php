@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')

<!-- inicio modal content -->
<div id="modal_asignaturas" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">FORMULARIO DE ASIGNATURAS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <input type="hidden" name="asignatura_id" id="asignatura_id" value="">
                </div>
                <div class="modal-body">
                    <form action="#" method="GET" id="formulario_modal_asignatura">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Codigo</label>
                                    <input name="codigo_asignatura" type="text" id="codigo_asignatura" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Nombre</label>
                                    <input name="nombre_asignatura" type="text" id="nombre_asignatura" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">Orden</label>
                                    <input name="orden_impresion" type="number" id="orden_impresion" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">Semestre</label>
                                    <input name="semestre" type="number" id="semestre" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">Nivel</label>
                                    <input name="nivel" type="number" id="nivel" class="form-control" >
                                </div>
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-md-5">

                                <div class="form-group">
                                    <label class="control-label">Carrera</label>
                                    <select name="carrera_id" id="carrera_id" class="form-control custom-select" required>
                                        <option value="">Seleccione</option>
                                        @foreach ($carreras as $c)
                                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                        @endforeach
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

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Carga Horaria</label>
                                    <input name="carga_horaria" type="number" id="carga_horaria" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">Teorico</label>
                                    <input name="teorico" type="number" id="teorico" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">Practico</label>
                                    <input name="practico" type="number" id="practico" class="form-control" >
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success">GUARDA ASIGNATURA</button>
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
            <div class="col-md-4">
                <div class="card card-outline-primary">                                
                    <div class="card-header">
                        <h4 class="mb-0 text-white">CARRERAS</h4>
                    </div>
                    <br />  
                    <form action="#" method="GET" id="formulario_carreras">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Carreras </label>
                                    
                                    <select name="carrera_id" id="carrera_id" class="form-control custom-select" required>
                                        <option value="">Seleccione</option>
                                        @foreach ($carreras as $c)
                                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Gestion </label>
                                    <input type="number" name="gestion" id="gestion" class="form-control" value="{{ $gestion }}" min="2011" max="{{ $gestion }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn waves-effect waves-light btn-block btn-success">VER ASIGNATURAS</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8" id="carga_ajax_lista_asignaturas">
                
            </div>
        </div>

    </div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>

<script>
    $.ajaxSetup({
    // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('#myTable').DataTable();
    });

    $('#formulario_carreras').on('submit', function(event) {
        event.preventDefault();
        var datos_formulario = $(this).serializeArray();
        var carrera_id = $("#carrera_id").val();

        $.ajax({
            url: "{{ url('Carrera/ajax_lista_asignaturas') }}",
            method: "GET",
            data: datos_formulario,
            // dataType: 'JSON',
            // contentType: false,
            cache: false,
            // processData: false,
            success: function(data)
            {
                $("#carga_ajax_lista_asignaturas").html(data);
            }
        })
    });

    $('#formulario_modal_asignatura').on('submit', function(event) {
        event.preventDefault();
        var datos_formulario = $(this).serializeArray();
        var carrera_id = $("#carrera_id").val();

        $.ajax({
            url: "{{ url('Carrera/ajax_lista_asignaturas') }}",
            method: "GET",
            data: datos_formulario,
            // dataType: 'JSON',
            // contentType: false,
            cache: false,
            // processData: false,
            success: function(data)
            {
                $("#carga_ajax_lista_asignaturas").html(data);
            }
        })
    });

</script>
@endsection
