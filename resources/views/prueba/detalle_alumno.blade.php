@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')

{{-- <div class="modal bs-example-modal-lg show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" style="display: block; padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Extra Large modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <h4>Overflowing text to show scroll behavior</h4>
                <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div> --}}

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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Column -->
            <!-- Row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="mb-0 text-white">Datos de la Carrera</h4>
                        </div>
                        <form action="/Inscripcion/re_inscripcion" method="POST">
                        @csrf
                            <div class="card-body">
                                <div class="form-body">
                                    <!--/row-->
                                    <!-- <h3 class="box-title">Address</h3> -->
                                    <!--/row-->
                                    <input type="text" name="re_carrera_id" id="re_carrera_id" hidden>
                                    <input type="text" name="re_persona_id" id="re_persona_id" hidden>
                                    <input type="text" name="re_sexo" id="re_sexo" hidden>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Turno</label>
                                                <div class="col-md-7">
                                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="re_turno_id" name="re_turno_id">
                                                        <option value="">Seleccionar</option>
                                                        @foreach($turnos as $tur)
                                                        <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Paralelo</label>
                                                <div class="col-md-6">
                                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="re_paralelo" name="re_paralelo">
                                                        <option value="">Seleccionar</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-12">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Gesti&oacute;n</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="re_anio_vigente" name="re_anio_vigente" value="{{ 2020 }}">
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
                                                <div class="col-md-offset-12 col-md-12">
                                                    <button type="submit" class="btn btn-info" id="b_carrera_4">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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

<!-- inicio modal NUEVA CARRERA -->
<div id="modal_nueva_carrera" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Column -->
            <!-- Row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="mb-0 text-white modal-title">Datos de la Carrera</h4>
                        </div>
                        <form action="/Inscripcion/re_inscripcion" method="POST">
                        @csrf
                            <div class="card-body">
                                <div class="form-body">
                                    <!--/row-->
                                    <input type="hidden" name="persona_id_nuevo" id="persona_id_nuevo">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Carrera</label>
                                                <div class="col-md-8">
                                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="carrera_id_nuevo" name="carrera_id_nuevo">
                                                        <option value="">Seleccionar</option>
                                                        @foreach($carreras as $carre)
                                                        <option value="{{ $carre->id }}">{{ $carre->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group row">
                                                <label class="control-label text-right col-md-3">Turno</label>
                                                <div class="col-md-6">
                                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_id_nuevo" name="turno_id_nuevo">
                                                        <option value="">Seleccionar</option>
                                                        @foreach($turnos as $tur)
                                                        <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                        @endforeach
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
                                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo_nuevo" name="paralelo_nuevo">
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
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="gestion_nuevo" name="gestion_nuevo" value="{{ $year }}">
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
                                                    <button type="button" class="btn btn-info" id="b_carrera_4">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h4 class="page-title">KARDEX</h4>
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Datos del Alumno</h4>
                </div>
            </div>
            <br>
            <div class="col-md-7 align-self-center d-none d-md-block">
                <button class="btn float-right btn-warning"> Mas Datos</button>
                <div class="dropdown float-right mr-2 hidden-sm-down">
                   <button class="btn float-right btn-success"> Actualizar</button>
                </div>
            </div>
        </div>
        <br>
        <div class="card border-inverse">
            <div class="card-body">
                <div class="form-body">
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label>Carnet 
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                 </label>
                                <input type="text" class="form-control" name="carnet" id="carnet" value="{{ $datosPersonales->carnet }}" required>
                            </div>
                        </div>
                        <input type="text" class="form-control" hidden name="persona_id" id="persona_id" required>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Expedido 
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select name="expedido" id="expedido" class="form-control" value="{{ $datosPersonales->expedido }}">
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
                        <div class="col-2">
                            <div class="form-group">
                                <label>Apellido Paterno </label>
                                <input type="text" class="form-control"
                                    name="apellido_paterno" id="apellido_paterno" value="{{ $datosPersonales->apellido_paterno }}">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label>Apellido Materno </label>
                                <input type="text" class="form-control"
                                    name="apellido_materno" id="apellido_materno" value="{{ $datosPersonales->apellido_materno }}">
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>Nombres
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <input type="text" class="form-control" name="nombres" id="nombres" value="{{ $datosPersonales->nombres }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Fecha Nacimiento
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ $datosPersonales->fecha_nacimiento }}" required>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label>Email </label>
                                <input type="text" class="form-control" name="email" id="email" value="{{ $datosPersonales->email }}">
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label>Direccion </label>
                                <input type="text" class="form-control" name="direccion" id="direccion" value="{{ $datosPersonales->direccion }}">
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label>Celular 
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <input type="text" class="form-control" name="telefono_celular" id="telefono_celular" value="{{ $datosPersonales->telefono_celular }}" required>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label>Genero 
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select name="sexo" id="sexo" class="form-control" value="{{ $datosPersonales->sexo }}" required>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenina">Femenina</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 align-self-center">
                <h4 class="page-title">Datos Adicionales</h4>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-md-6">

                <div class="card card-outline-primary">
                    <div class="card-header">
                        <h4 class="mb-0 float-left text-white">CARRERA</h4>
                        {{-- <button type="button" class="float-right btn btn-success" onclick="nueva_carrera({{ $datosPersonales->id }})">Nueva Carrera</button> --}}
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
                                                <button type="button" class="btn btn-success" onclick="re_inscripcion({{ $cp->carrera_id}}, '{{ $datosPersonales->id}}', '{{ $datosPersonales->sexo}}')"><i class="fas fa-address-card"></i></button>
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
                        <h4 class="mb-0 text-white float-left">Asignaturas Adicionales</h4>
                        {{-- <button type="button" class="float-right btn btn-success" onclick="nuevo_asignatura({{ $datosPersonales->id }})">Nueva Asignatura</button> --}}
                    </div>

                    <div class="table-responsive m-t-40" id="ajax_listado_asignaturas_adicionales">
                        
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
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script>
$(document).ready(function() {
    ver_asignaturas_adicionales();
});
 function ver_asignaturas_adicionales(){
    var persona_id = 3185;
    // formulario_asignacion = $("#formulario_modal_asignacion").serializeArray();
        $.ajax({
            url: "{{ url('Persona/ajax_asignaturas_adicionales') }}/"+persona_id,
            method: "GET",
            data: persona_id,
            cache: false,
            success: function(data)
            {
                $("#ajax_listado_asignaturas_adicionales").html(data);
            }
        })
 }
</script>

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

    function re_inscripcion(carrera_id, persona_id, sexo)
    {
        $('#re_carrera_id').val(carrera_id);
        $('#re_persona_id').val(persona_id);
        $('#re_sexo').val(sexo);
        $('#modal_reinscripcion').modal('show');
    }

    function nueva_carrera(persona_id)
    {
        $("#persona_id_nuevo").val(persona_id);
        
        $("#modal_nueva_carrera").modal('show');
        // alert(persona_id);
    }

    function nuevo_asignatura(persona_id)
    {
        // $("#persona_id_nuevo").val(persona_id);
        
        // $("#modal_nueva_carrera").modal('show');
        alert(persona_id);
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