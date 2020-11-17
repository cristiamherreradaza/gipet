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
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">Carrera</label>
                            <select name="carrera" id="carrera" class="form-control">
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}"> {{ $carrera->nombre }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="control-label">Curso</label>
                            <select name="curso" id="curso" class="form-control">
                                @foreach($cursos as $curso)
                                    <option value="{{ $curso->gestion }}"> {{ $curso->gestion }}° A&ntilde;o </option>
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
                            <label class="control-label">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="Vigente"> Vigente </option>
                                <option value="No Vigente"> No Vigente </option>
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
                <h4 class="card-title">RESULTADO DE BUSQUEDA</h4>
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

<!-- <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script> -->
<script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js') }}"></script>

<script>
    function buscar()
    {
        $("#mostrar").show('slow');
        table.destroy();
        var carrera = $("#carrera").val();
        var curso = $("#curso").val();
        var turno = $("#turno").val();
        var paralelo = $("#paralelo").val();
        var gestion = $("#gestion").val();
        var estado = $("#estado").val();

        // $("#tabla-tienda thead th").each(function() {
        //     var title = $(this).text();
        //     $(this).html('<input type="text" placeholder=" ' + title + '" />');
        // });

        // DataTable
        table = $('#tabla-tienda').DataTable( {
            // dom: 'Bfrtip',
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf', 'print'
            // ],
            iDisplayLength: 10,
            processing: true,
            serverSide: true,
            ajax: { 
                url : "{{ url('Lista/ajaxBusquedaAlumnos') }}",
                type: "GET",
                data: {
                    carrera : carrera,
                    curso : curso,
                    turno : turno,
                    paralelo : paralelo,
                    gestion : gestion,
                    estado : estado
                    } 
                },
            columns: [
                {data: 'cedula', name: 'personas.cedula'},
                {data: 'apellido_paterno', name: 'personas.apellido_paterno'},
                {data: 'apellido_materno', name: 'personas.apellido_materno'},
                {data: 'nombres', name: 'personas.nombres'},
                {data: 'numero_celular', name: 'personas.numero_celular'},
                {data: 'estado', name: 'personas.estado'},
                // {data: 'saldo', name: 'ventas.saldo'},
            ],
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        } );

        // table.columns().every(function(index) {
        //     var that = this;
        //     $("input", this.header()).on("keyup change clear", function() {
        //         if (that.search() !== this.value) {
        //             that.search(this.value).draw();
        //             table
        //             .rows()
        //             .$("tr", { filter: "applied" })
        //             .each(function() {
        //                 // console.log(table.row(this).data());
        //             });
        //         }
        //     });
        // });
    }
</script>

@endsection