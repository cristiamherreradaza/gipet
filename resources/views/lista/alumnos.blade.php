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
                <h4 class="mb-0 text-white">LISTA DE ALUMNOS</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Carrera</label>
                            <select name="carrera" id="carrera" class="form-control">
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}"> {{ $carrera->nombre }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
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
                            <select name="turno" id="turno" class="form-control">
                                @foreach($turnos as $turno)
                                    <option value="{{ $turno->id }}"> {{ $turno->descripcion }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Paralelo</label>
                            <select name="paralelo" id="paralelo" class="form-control">
                                @foreach($paralelos as $paralelo)
                                    <option value="{{ $paralelo->paralelo }}"> {{ $paralelo->paralelo }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="control-label">Gestion</label>
                            <input type="number" name="anio_vigente" id="anio_vigente" value="{{ date('Y') }}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="estado" id="estado" class="form-control custom-select">
                                <option value="todos">TODOS</option>
                                <option value="VIGENTES">VIGENTES</option>
                                <option value="APROBO">APROBO</option>
                                <option value="REPROBO">REPROBO</option>
                                <option value="CONGELADO">CONGELADO</option>
                                <option value="ABANDONO">ABANDONO</option>
                                <option value="ABANDONO TEMPORAL">ABANDONO TEMPORAL</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-6">
                                {{-- <div class="form-group">
                                    <label class="control-label">&nbsp;</label>
                                    <button type="button" onclick="buscar()" class="btn btn-block btn-primary">Buscar</button>
                                </div> --}}
                            </div>
                            <div class="col-md-6">
                                {{-- <div class="form-group">
                                    <label class="control-label">&nbsp;</label>
                                    <button type="button" onclick="reportePdfAlumnos()" class="btn btn-block btn-danger"> <i class="fas fa-file-pdf"></i> PDF</button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <button type="button" onclick="buscar()" class="btn btn-block btn-primary">Buscar</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <button type="button" onclick="reportePdfAlumnos()" class="btn btn-block btn-danger"> <i class="fas fa-file-pdf"></i> PDF</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <button type="button" onclick="listaAlumnos()" class="btn btn-block btn-success"> <i class="fas fa-file-pdf"></i> Lista de Asistencia</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="listadoProductosAjax"></div>
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
                <br />

                {{-- <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success btn-block" onclick="reporteExcelAlumnos()">
                            <i class="fas fa-file-excel">&nbsp; </i> GENERAR EXCEL
                        </button>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@stop
@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>

<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js') }}"></script>

<script>

    // soluciona el error de exportacion ajax de todos los datos

    var oldExportAction = function (self, e, dt, button, config) {
        if (button[0].className.indexOf('buttons-excel') >= 0) {
            if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
            } else {
                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            }
        } else if (button[0].className.indexOf('buttons-print') >= 0) {
            $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
        }
    };

    var newExportAction = function (e, dt, button, config) {
        var self = this;
        var oldStart = dt.settings()[0]._iDisplayStart;

        dt.one('preXhr', function (e, s, data) {
            // Just this once, load all data from the server...
            data.start = 0;
            data.length = 2147483647;

            dt.one('preDraw', function (e, settings) {
                // Call the original action function 
                oldExportAction(self, e, dt, button, config);

                dt.one('preXhr', function (e, s, data) {
                    // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                    // Set the property to what it was before exporting.
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                });

                // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                setTimeout(dt.ajax.reload, 0);

                // Prevent rendering of the full data to the DOM
                return false;
            });
        });

        // Requery the server with the new one-time export settings
        dt.ajax.reload();
    };

    function buscar()
    {
        $("#mostrar").show('slow');
        table.destroy();
        var carrera = $("#carrera").val();
        var gestion = $("#gestion").val();
        var turno = $("#turno").val();
        var paralelo = $("#paralelo").val();
        var anio_vigente = $("#anio_vigente").val();
        var estado = $("#estado").val();

        // $("#tabla-tienda thead th").each(function() {
        //     var title = $(this).text();
        //     $(this).html('<input type="text" placeholder=" ' + title + '" />');
        // });

        // DataTable
        table = $('#tabla-tienda').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: 'EXCEL',
                    title: 'LISTADO ALUMNOS',
                    filename: 'Alumnos',
                    action: newExportAction
                },
            ],
            // iDisplayLength: 10,
            processing: true,
            serverSide: true,
            ajax: { 
                url : "{{ url('Lista/ajaxBusquedaAlumnos') }}",
                type: "GET",
                data: {
                    carrera : carrera,
                    gestion : gestion,
                    turno : turno,
                    paralelo : paralelo,
                    anio_vigente : anio_vigente,
                    estado : estado
                    } 
                },
            columns: [
                {data: 'cedula', name: 'personas.cedula'},
                {data: 'apellido_paterno', name: 'personas.apellido_paterno'},
                {data: 'apellido_materno', name: 'personas.apellido_materno'},
                {data: 'nombres', name: 'personas.nombres'},
                {data: 'numero_celular', name: 'personas.numero_celular'},
                {data: 'estado', name: 'carreras_personas.vigencia'},
                // {data: 'saldo', name: 'ventas.saldo'},
            ],
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        } );

    }

    function reportePdfAlumnos()
    {
        var carrera     = $("#carrera").val();
        var gestion       = $("#gestion").val();
        var turno       = $("#turno").val();
        var paralelo    = $("#paralelo").val();
        var anio_vigente     = $("#anio_vigente").val();
        var estado      = $("#estado").val();
        // Aplicar validaciones, para cuando los campos sean vacios
        window.open("{{ url('Lista/reportePdfAlumnos') }}/"+carrera+'/'+gestion+'/'+turno+'/'+paralelo+'/'+anio_vigente+'/'+estado);
        //window.location.href = "{{ url('Lista/reportePdfAlumnos') }}/"+carrera+'/'+curso+'/'+turno+'/'+paralelo+'/'+gestion+'/'+estado;
    }

    function reporteExcelAlumnos()
    {
        var carrera      = $("#carrera").val();
        var gestion      = $("#gestion").val();
        var turno        = $("#turno").val();
        var paralelo     = $("#paralelo").val();
        var anio_vigente = $("#anio_vigente").val();
        var estado       = $("#estado").val();
        // Aplicar validaciones, para cuando los campos sean vacios
        //window.open("{{ url('Lista/reporteExcelAlumnos') }}/"+carrera+'/'+curso+'/'+turno+'/'+paralelo+'/'+gestion+'/'+estado);
        window.location.href = "{{ url('Lista/reporteExcelAlumnos') }}/"+carrera+'/'+gestion+'/'+turno+'/'+paralelo+'/'+anio_vigente+'/'+estado;
    }

    function listaAlumnos()
    {
        var carrera      = $("#carrera").val();
        var gestion      = $("#gestion").val();
        var turno        = $("#turno").val();
        var paralelo     = $("#paralelo").val();
        var anio_vigente = $("#anio_vigente").val();
        var estado       = $("#estado").val();
            
        alert('en desarrollo :v');
    }

</script>

@endsection