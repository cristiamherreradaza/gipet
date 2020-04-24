@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/plugins/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
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
                        <h5><b>Sigla: </b><span id="modal_sigla_materia"></span> &nbsp;&nbsp;&nbsp;&nbsp;<b>Nombre:
                            </b><span id="modal_nombre_materia"></span></h5>
                        <h5><b>Carrera: </b><span id="modal_carrera_materia"></span></h5>
                    </div>
                </div>
                <form action="#" method="POST" id="formulario_modal_asignacion">
                    @csrf
                    <input type="hidden" name="asignatura_id" id="fm_asignatura_id" value="">
                    {{-- <input type="hidden" name="user_id" id="fm_user_id" value="{{ $datos_persona->id }}"> --}}

                    <div class="row">

                        <div class="col-md-4">

                            <div class="form-group">
                                <label class="control-label">Turno</label>
                                <select name="turno_id" id="turno_id" class="form-control custom-select" required>
                                    {{-- @foreach ($turnos as $t)
                                    <option value="{{ $t->id }}">{{ $t->descripcion }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Paralelo</label>
                                <select name="paralelo" id="paralelo" class="form-control custom-select">
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label class="control-label">A&ntilde;o</label>
                                <input type="number" name="anio_vigente" id="anio_vigente" class="form-control"
                                    value="{{ date('Y') }}">
                            </div>
                        </div>

                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button class="btn waves-effect waves-light btn-block btn-success"
                    onclick="guarda_asignacion()">ASIGNAR</button>
            </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- fin modal -->

<!-- inicio modal content -->
<div id="modal_asignatura" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        {{-- <div class="modal-content"> --}}
            <!-- Column -->
            <div class="col-lg-12 col-md-12" id="mostrar_asig1">
                <div class="card card-inverse card-dark">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mr-3 align-self-center">
                                <h1 class="text-white"><i class="icon-graduation"></i></h1></div>
                            <div>
                                <h3 class="card-title" id="nom_asig1"></h3>
                                <h6 class="card-subtitle" id="gest1"> </h6> </div>
                        </div>
                        <div class="row">
                            <!-- column -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table no-wrap" id="valor1_1">
                                                <thead>
                                                    <tr>
                                                        <th data-field="state" data-checkbox="true"></th>
                                                        <th data-field="name">Sigla</th>
                                                        <th data-field="price">Asignatura</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="valor1">
                                                    

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        {{-- </div> --}}
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- fin modal -->

<!-- inicio modal content -->
<div id="modal_reinscripcion" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Column -->
            <!-- Row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="mb-0 text-white">Datos de la Carrera</h4>
                        </div>
                        <div class="card-body">
                                <div class="form-body">
                                    <!--/row-->
                                    <!-- <h3 class="box-title">Address</h3> -->
                                    <!--/row-->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Turno</label>
                                                <div class="col-md-7">
                                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_id_1" name="turno_id_1">
                                                        <option value="">Seleccionar</option>
                                                        {{-- @foreach($turnos as $tur)
                                                        <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                        @endforeach --}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Paralelo</label>
                                                <div class="col-md-6">
                                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_1" name="paralelo_1">
                                                        <option value="">Seleccionar</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Gesti&oacute;n</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="gestion_1" name="gestion_1" value="{{ 2020 }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/row-->
                                    
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="button" class="btn btn-info" id="b_carrera_4" onclick="abre_carrera_4();">Guardar </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->
            <!-- Column -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- fin modal -->

<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <table class="table no-wrap">
                    <thead>
                        <tr>
                            <th>AP PATERNO</th>
                            <th>AP MATERNO</th>
                            <th>NOMBRES</th>
                            <th>CARNET</th>
                            <th>CELULAR</th>
                            <th>GENERO</th>
                            <th>

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $datosPersonales->apellido_paterno }}</td>
                            <td>{{ $datosPersonales->apellido_materno }}</td>
                            <td>{{ $datosPersonales->nombres }}</td>
                            <td>{{ $datosPersonales->carnet }}</td>
                            <td>{{ $datosPersonales->telefono_celular }}</td>
                            <td>{{ $datosPersonales->sexo }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" onclick="muestra_modal(445)"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="card card-outline-primary">
                    <div class="card-header">
                        <h4 class="mb-0 text-white">CARRERA</h4>
                    </div>
                    @if (!($carrerasPersona->isEmpty()))

                        <div class="table-responsive m-t-40">
                            <table class="table no-wrap">
                                <thead>
                                    <tr>
                                        <th>CARRERA</th>
                                        <th>TURNO</th>
                                        <th>GESTION</th>
                                        <th>

                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carrerasPersona as $cp)
                                        <tr>
                                            <td>{{ $cp->carrera->nombre }}</td>
                                            <td>{{ $cp->turno->descripcion }}</td>
                                            <td>{{ $cp->anio_vigente }}</td>
                                            <td>

                                                <button type="button" class="btn btn-warning" onclick="muestra_materias({{ $cp->carrera_id }}, {{ $cp->persona_id }}, {{ $cp->anio_vigente }})"><i class="fas fa-edit"></i></button>
                                                

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            
                        </div>

                    @else
                        <h3 class="text-center">No esta inscrito a ninguna carrera</h3>
                    @endif

                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="mb-0 text-white">MESUALIDADES</h4>
                    </div>

                    <div class="table-responsive m-t-40">
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-md-6" id="ajax_listado_materias">
                
            </div>

            <div class="col-md-6">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="mb-0 text-white">MESUALIDADES</h4>
                    </div>

                    <div class="table-responsive m-t-40">
                        
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

    function muestra_materias(carrera_id, persona_id, anio_vigente) {
        formulario_asignacion = $("#formulario_modal_asignacion").serializeArray();
        $.ajax({
            url: "{{ url('Persona/ajax_materias') }}/"+carrera_id+"/"+persona_id+"/"+anio_vigente,
            method: "GET",
            data: formulario_asignacion,
            cache: false,
            success: function(data)
            {
                $("#ajax_listado_materias").html(data);
            }
        })
    }







    $(function () {
        tabla_asignaturas = $('#tabla-asignaturas').DataTable();
    });

    $(function () {
        $('#tabla-asignaturas-docente').DataTable();
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

    function ver_asignaturas(id, nombre, anio)
    {
        var carrera_persona_id = id;
        var nombre_carrera = nombre;
        var anio_actual = anio;
        var table1 = document.getElementById('valor1');
        table1.innerHTML = '';
        $.ajax({
            type:'GET',
            url:"{{ url('Persona/verifica') }}",
            data: {
                id : carrera_persona_id
            },
            success:function(data){
                var num = 1;
                 $.each(data, function(index, value) {
                        $("#valor1").append('<tr>'+
                                                '<td>' + 
                                                    num +
                                                '</td>' + 
                                                '<td>' + data[index].codigo_asignatura + '</td>' +
                                                '<td>' + data[index].nombre_asignatura + '</td>' +
                                            '</tr>');
                        num ++;
                    });
                    $("#nom_asig1").html(nombre_carrera);
                    $("#gest1").html('Gestion ' + anio_actual);
                $('#modal_asignatura').modal('show');
            }
        });
        // $("#modal_sigla_materia").html(codigo_asignatura);
        // $("#modal_nombre_materia").html(nombre_asignatura);
        // $("#modal_carrera_materia").html(nombre_carrera);
        // $("#fm_asignatura_id").val(asignatura_id);
        // $('#modal_asignatura').modal('show');
        // console.log(nombre_asignatura);
    }

    function re_inscripcion(id, nombre, anio)
    {
        $('#modal_reinscripcion').modal('show');
    }

    function guarda_asignacion() {
        formulario_asignacion = $("#formulario_modal_asignacion").serializeArray();
        $.ajax({
            url: "{{ url('User/guarda_asignacion') }}",
            method: "POST",
            data: formulario_asignacion,
            cache: false,
            success: function(data)
            {
                if (data.error_duplicado == 1) 
                {
                    Swal.fire(
                        'Alerta!',
                        'La materia ya esta asignada al docente',
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
                    {{-- window.location.href = "{{ url('User/asigna_materias') }}/" + {{ $datos_persona->id }}; --}}
                }
            }
        })
    }

    function elimina_asignacion(np_id, nombre)
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
                    url: "{{ url('User/eliminaAsignacion') }}/"+np_id,
                    method: "GET",
                    cache: false,
                    success: function (data) {

                        Swal.fire(
                            'Excelente!',
                            'La materia fue eliminada',
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