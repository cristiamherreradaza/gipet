@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-info">
            <div class="card-header bg-info">
                <h4 class="mb-0 text-white">ASIGNACION DE MATERIAS</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="docente_id" id="docente_id" value="{{ $docente->id }}">
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">Docente</label>
                            <h1 class="form-control">{{ $docente->nombres }} {{ $docente->apellido_paterno }} {{ $docente->apellido_materno }}</h1>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">Malla Curricular</label>
                            <select name="gestion" id="gestion" class="form-control">
                                @foreach($mallasCurriculares as $mallaCurricular)
                                    <option value="{{ $mallaCurricular->anio_vigente }}"> {{ $mallaCurricular->anio_vigente }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <button type="button" onclick="buscar()" class="btn btn-block btn-primary">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" id="detalleAsignaciones" style="display:none;">
    
</div>

@stop
@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js') }}"></script>
<script>
    // Funcion que se ejecuta al hacer clic en buscar
    function buscar(){
        gestion     = $('#gestion').val();
        docente_id  = $('#docente_id').val();
        $.ajax({
            url: "{{ url('User/ajaxBusquedaAsignaciones') }}",
            data: {
                gestion : gestion,
                docente_id : docente_id
                },
            type: 'get',
            success: function(data) {
                $("#detalleAsignaciones").show('slow');
                $("#detalleAsignaciones").html(data);
            }
        });
    }
</script>
@endsection