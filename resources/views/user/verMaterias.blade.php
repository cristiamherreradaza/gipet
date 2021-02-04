@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
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
                <h4 class="mb-0 text-white">BUSCAR ASIGNATURA</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Gestion</label>
                            <select name="gestion" id="gestion" class="form-control" onchange="buscaAsignaturas();">
                                <option value="" selected> Seleccione </option>
                                @foreach($gestiones as $gestion)
                                    <option value="{{ $gestion->anio_vigente }}"> {{ $gestion->anio_vigente }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Asignatura</label>
                            <div id="ajaxMuestraAsignatura"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Turno</label>
                            <div id="ajaxMuestraTurno"></div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Paralelo</label>
                            <div id="ajaxMuestraParalelo"></div>
                        </div>
                    </div>
                    <!-- <div class="col">
                        <div class="form-group">
                            <label class="control-label">Asignaturas</label>
                            <select name="asignatura" id="asignatura" class="select2 form-control custom-select select2-hidden-accessible" style="width: 100%; height:36px;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option>Seleccione</option>
                                @foreach($mallas as $malla)
                                    <optgroup label="Malla {{ $malla->anio_vigente }}">
                                        @php
                                            $registros  = App\Asignatura::where('anio_vigente', $malla->anio_vigente)
                                                                        ->get();
                                        @endphp
                                        @foreach($registros as $asignatura)
                                            <option value="{{ $asignatura->id }}" >{{ $asignatura->sigla }} {{ $asignatura->nombre }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">Turno</label>
                            <select name="turno" id="turno" class="form-control">
                                @foreach($turnos as $turno)
                                    <option value="{{ $turno->id }}"> {{ $turno->descripcion }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">Paralelo</label>
                            <select name="paralelo" id="paralelo" class="form-control">
                                @foreach($paralelos as $paralelo)
                                    <option value="{{ $paralelo->paralelo }}"> {{ $paralelo->paralelo }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">Gestion</label>
                            <select name="gestion" id="gestion" class="form-control">
                                @foreach($gestiones as $gestion)
                                    <option value="{{ $gestion->anio_vigente }}"> {{ $gestion->anio_vigente }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <button type="button" onclick="buscar()" class="btn btn-block btn-primary">Buscar</button>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" id="upload_form" enctype="multipart/form-data" class="upload_form mt-4">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="select_file" id="select_file">
                    <label class="custom-file-label" for="inputGroupFile04">Elegir archivo</label>
                </div>
                <div class="input-group-append">
                    <input type="submit" name="upload" id="upload" class="btn btn-success" value="Importar" style="width: 200px;">
                </div>
            </div>
        </div>
    </div>
</form>

<br>

<div class="row">
    <div class="col-md-12" id="detalleAcademicoAjax" style="display:none;">
        
    </div>
</div>

@stop
@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js') }}"></script>

<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('dist/js/pages/forms/select2/select2.init.js') }}" type="text/javascript"></script>
<script>
    // Funcion para el uso de ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function buscaAsignaturas(){
        let gestion = $("#gestion").val();
        $("#asignatura").val('');
        $("#ajaxMuestraTurno").hide();
        $("#turno").val('');
        $("#ajaxMuestraParalelo").hide();
        $("#paralelo").val('');
        $("#detalleAcademicoAjax").hide();
        $.ajax({
            url: "{{ url('User/ajaxBuscaAsignaturas') }}",
            data: {
                gestion: gestion,
            },
            type: 'get',
            success: function(data) {
                $("#ajaxMuestraAsignatura").html(data);
            }
        });
    }


    // Script de importacion de excel
    $(document).ready(function() {
        $('.upload_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ url('User/importarNotasAsignaturas') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data)
                {
                    if(data.sw == 1){
                        Swal.fire(
                        'Hecho',
                        data.message,
                        'success'
                        ).then(function() {
                            location.reload();          //Aqui editar
                            $('#select_file').val('');
                        });
                    }else{
                        Swal.fire(
                        'Oops...',
                        data.message,
                        'error'
                        )
                    }
                }
            })
        });
    });

    // Funcion que se ejecuta al hacer clic en pensum
    function buscar(){
        gestion     = $('#gestion').val();
        asignatura  = $('#asignatura').val();
        turno       = $('#turno').val();
        paralelo    = $('#paralelo').val();
        $.ajax({
            url: "{{ url('User/ajaxVerMaterias') }}",
            data: {
                asignatura : asignatura,
                turno : turno,
                paralelo : paralelo,
                gestion : gestion
                },
            type: 'get',
            success: function(data) {
                $("#detalleAcademicoAjax").show('slow');
                $("#detalleAcademicoAjax").html(data);
            }
        });
    }

    function reportePdfTotalAlumnos()
    {
        var carrera     = $("#carrera").val();
        if(carrera.length == 0){
            carrera = 0;
        }
        // Aplicar validaciones, para cuando los campos sean vacios
        window.open("{{ url('Lista/reportePdfTotalAlumnos') }}/"+carrera);
        //window.location.href = "{{ url('Lista/reportePdfTotalAlumnos') }}/"+carrera+'/'+curso+'/'+turno+'/'+paralelo+'/'+gestion+'/'+estado;
    }

    function reporteExcelAlumnos()
    {
        var carrera     = $("#carrera").val();
        var curso       = $("#curso").val();
        var turno       = $("#turno").val();
        var paralelo    = $("#paralelo").val();
        var gestion     = $("#gestion").val();
        var estado      = $("#estado").val();
        // Aplicar validaciones, para cuando los campos sean vacios
        //window.open("{{ url('Lista/reporteExcelAlumnos') }}/"+carrera+'/'+curso+'/'+turno+'/'+paralelo+'/'+gestion+'/'+estado);
        window.location.href = "{{ url('Lista/reporteExcelAlumnos') }}/"+carrera+'/'+curso+'/'+turno+'/'+paralelo+'/'+gestion+'/'+estado;
    }

</script>
@endsection