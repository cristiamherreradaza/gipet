@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">

<!-- <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet"> -->

@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-info">
            <div class="card-header bg-info">
                <h4 class="mb-0 text-white">CENTRALIZADOR DE NOTAS</h4>
            </div>
            <form action="{{ url('Lista/excelCentralizadorNotas') }}" method="POST" id="formularioCentralizador">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Carrera</label>
                                <select name="carrera_id" id="carrera_id" class="form-control">
                                    @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}"> {{ $carrera->nombre }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Curso</label>
                                <select name="gestion" id="gestion" class="form-control">
                                    @foreach($cursos as $curso)
                                    <option value="{{ $curso->gestion }}"> {{ $curso->gestion }}° A&ntilde;o </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Turno</label>
                                <select name="turno_id" id="turno_id" class="form-control">
                                    @foreach($turnos as $turno)
                                    <option value="{{ $turno->id }}"> {{ $turno->descripcion }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Paralelo</label>
                                <select name="paralelo" id="paralelo" class="form-control">
                                    @foreach($paralelos as $paralelo)
                                    <option value="{{ $paralelo->paralelo }}"> {{ $paralelo->paralelo }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Bimestre</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <option value="primero"> Primero </option>
                                    <option value="segundo"> Segundo </option>
                                    <option value="anual"> Anual </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Imp. Nombre</label>
                                <select name="imprime_nombre" id="imprime_nombre" class="form-control">
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Gestion</label>
                                <input type="number" name="anio_vigente" id="anio_vigente" class="form-control" value="{{ date('Y') }}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">&nbsp;</label>
                                <button type="button" onclick="generaCentralizador()" class="btn btn-block btn-primary">GENERAR</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="ajaxCentralizador"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12" id="mostrar" style="display:none;">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">RESULTADO DE BUSQUEDA</h4>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-light" onclick="reportePdfAlumnos()">
                            <i class="fas fa-file-pdf">&nbsp; PDF</i>
                        </button>

                        <button class="btn btn-light" onclick="reporteExcelAlumnos()">
                            <i class="fas fa-file-pdf">&nbsp; EXCEL</i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="tabla-tienda" class="table table-bordered table-striped no-wrap">
                        <thead class="text-center">
                            <tr>
                                <th>N° Carnet</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Nombres</th>
                                <th>Celular</th>
                                <!-- <th>Fecha Retiro</th> -->
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js') }}"></script>
<script type="text/javascript">

    function generaCentralizador()
    {
        let datosFormulario = $('#formularioCentralizador').serializeArray();
        $('#formularioCentralizador').submit();

        /*$.ajax({
            url: "{{ url('Lista/excelCentralizadorNotas') }}",
            data: datosFormulario,
            type: 'POST',
            success: function(data) {
                $("#mostrar").show('slow');
                $("#mostrar").html(data);
            }
        });*/
    }
</script>
@endsection