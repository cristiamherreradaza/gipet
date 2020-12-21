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
                <h4 class="mb-0 text-white">BUSCAR ASIGNATURA</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">Docentes</label>
                            <select name="usuario" id="usuario" class="form-control">
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}"> {{ $usuario->nombres }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">Malla Curricular</label>
                            <select name="malla" id="malla" class="form-control">
                                @foreach($mallas as $malla)
                                    <option value="{{ $malla->anio_vigente }}"> {{ $malla->anio_vigente }} </option>
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
                    </div>
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
<script>
    // Funcion para el uso de ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
        gestion = $('#gestion').val();
        usuario = $('#usuario').val();
        malla   = $('#malla').val();
        $.ajax({
            url: "{{ url('User/ajaxVerMaterias') }}",
            data: {
                gestion : gestion,
                malla : malla,
                usuario : usuario
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