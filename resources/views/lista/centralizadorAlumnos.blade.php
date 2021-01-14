@extends('layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-info">
            <div class="card-header bg-info">
                <h4 class="mb-0 text-white">LISTA DE ALUMNOS</h4>
            </div>
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
                            <label class="control-label">Semestre</label>
                            <div id="ajaxMuestraSemestre"></div>
                        </div>
                    </div>

                </div>
                
            </div>
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
                        <button class="btn btn-danger" onclick="reportePdfAlumnos()">
                            <i class="fas fa-file-pdf">&nbsp; PDF</i>
                        </button>

                        <button class="btn btn-success" onclick="reporteExcelAlumnos()">
                            <i class="fas fa-file-excel">&nbsp; EXCEL</i>
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

    </script>

@endsection