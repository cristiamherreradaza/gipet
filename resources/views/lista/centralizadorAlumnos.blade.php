@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet">
@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-info">
            <div class="card-header bg-info">
                <h4 class="mb-0 text-white">CENTRALIZADOR DE CALIFICACIONES BIMESTRAL</h4>
            </div>
            <form action="{{ url('Lista/genera_centralizador') }}" method="POST" id="formularioCentralizador">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Gestion</label>
                                <select name="gestion" id="gestion" class="form-control" onchange="buscaDocentes();">
                                    <option value=""> Seleccione </option>
                                    @foreach($gestiones as $g)
                                        <option value="{{ $g->anio_vigente }}"> {{ $g->anio_vigente }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Docente</label>
                                <div id="ajaxMuestraDocente"></div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Asignaturas</label>
                                <div id="ajaxMuestraMateria"></div>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Turno</label>
                                <div id="ajaxMuestraTurno"></div>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Paralelo</label>
                                <div id="ajaxMuestraParalelo"></div>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Bimestre</label>
                                <div id="ajaxMuestraTrimestre"></div>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">&nbsp;</label>
                                <button type="button" class="btn waves-effect waves-light btn-block btn-success"
                                    id="btnGenera" style="display: none;" onclick="generaCentralizador()">Generar</button>
                            </div>
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
                {{-- <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-danger" onclick="reportePdfAlumnos()">
                            <i class="fas fa-file-pdf">&nbsp; PDF</i>
                        </button>

                        <button class="btn btn-success" onclick="reporteExcelAlumnos()">
                            <i class="fas fa-file-excel">&nbsp; EXCEL</i>
                        </button>
                    </div>
                </div> --}}

                <div id="cargaCalificacionesBimestral">

                </div>

            </div>
        </div>
    </div>
</div>

@stop
@section('js')

<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>

<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js') }}"></script>

    <script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('dist/js/pages/forms/select2/select2.init.js') }}" type="text/javascript"></script>
    <script>


        function buscaDocentes(){

            let gestion = $("#gestion").val();
            $.ajax({
                url: "{{ url('Lista/ajax_centralizador_docente') }}",
                data: {
                    gestion: gestion,
                    },
                type: 'get',
                success: function(data) {
                    $("#ajaxMuestraDocente").html(data);
                }
            });

        }

        function generaCentralizador()
        {
            let formularioCentralizador = $('#formularioCentralizador');
            let datosFormulario = formularioCentralizador.serializeArray();

            $.ajax({
                url: "{{ url('Lista/genera_centralizador') }}",
                data: datosFormulario,
                type: 'post',
                success: function(data) {
                    $("#cargaCalificacionesBimestral").html(data);
                    $("#mostrar").show();
                }
            });

        }

    </script>

@endsection
