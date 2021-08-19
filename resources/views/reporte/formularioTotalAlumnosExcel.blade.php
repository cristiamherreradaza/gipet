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
                <h4 class="mb-0 text-white">GENERA EXCEL TOTAL DE ALUMNOS POR GESTION</h4>
            </div>
            <form action="{{ url('Reporte/generaTotalAlumnosExcel') }}" method="POST" id="formularioCentralizador">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Gestion</label>
                                <input type="number" name="anio_vigente" id="anio_vigente" class="form-control" value="{{ date('Y') }}" required >
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