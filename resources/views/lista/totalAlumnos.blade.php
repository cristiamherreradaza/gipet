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
                <h4 class="mb-0 text-white">CANTIDAD TOTAL DE ALUMNOS</h4>
            </div>
            <form action="#" id="formularioTotalAlumnos" method="GET">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Carrera</label>
                                <select name="carrera" id="carrera" class="form-control">
                                    <option value="">Todos</option>
                                    @foreach($carreras as $carrera)
                                        <option value="{{ $carrera->id }}"> {{ $carrera->nombre }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Gestion</label>
                                <input type="number" class="form-control" name="anio_vigente" id="anio_vigente" value="{{ date('Y') }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">&nbsp;</label>
                                <button type="button" onclick="buscar()" class="btn btn-block btn-primary">Buscar</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="listadoProductosAjax"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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
<script src="{{ asset('js/utilidades.js') }}"></script>
<script>
    // Funcion que se ejecuta al hacer clic en pensum
    function buscar(){

        // carrera = $('#carrera').val();
        let formulario = document.getElementById('formularioTotalAlumnos');

        $.ajax({
            url: "{{ url('Lista/ajaxTotalAlumnos') }}",
            data: {
                carrera : carrera
                },
            type: 'get',
            success: function(data) {
                $("#detalleAcademicoAjax").show('slow');
                $("#detalleAcademicoAjax").html(data);
            }
        });
    }

    /*
        function buscar()
        {
            $("#mostrar").show('slow');
            table.destroy();
            var carrera = $("#carrera").val();
            //var gestion = $("#gestion").val();

            // DataTable
            table = $('#tabla-tienda').DataTable( {
                iDisplayLength: 10,
                processing: true,
                serverSide: true,
                ajax: { 
                    url : "{{ url('Lista/ajaxTotalAlumnos') }}",
                    type: "GET",
                    data: {
                        //gestion : gestion,
                        carrera : carrera
                        } 
                    },
                columns: [
                    // {data: 'cedula', name: 'personas.cedula'},
                    // {data: 'apellido_paterno', name: 'personas.apellido_paterno'},
                    // {data: 'apellido_materno', name: 'personas.apellido_materno'},
                    // {data: 'nombres', name: 'personas.nombres'},
                    // {data: 'numero_celular', name: 'personas.numero_celular'},
                    // {data: 'estado', name: 'carreras_personas.vigencia'},
                    // {data: 'saldo', name: 'ventas.saldo'},
                ],
                language: {
                    url: '{{ asset('datatableEs.json') }}'
                },
            } );
        }
    */

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