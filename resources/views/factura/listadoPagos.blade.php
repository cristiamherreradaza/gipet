@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            LISTADO ULTIMOS PAGOS
        </h4>
    </div>
    <div class="card-body">

        <form action="#" method="POST" id="formulario_pagos">
            @csrf
            <div class="row">

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">No.(Fac/Rec) </label>
                        <input type="number" name="numero" id="numero" class="form-control">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">C.I. Estudiante </label>
                        <input type="number" name="ci" id="ci" class="form-control">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">NIT </label>
                        <input type="number" name="nit" id="nit" class="form-control">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Fecha Inicio </label>
                        <input type="date" name="feche_inicio" id="feche_inicio" class="form-control">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Fecha Fin </label>
                        <input type="date" name="fecha_final" id="fecha_final" class="form-control">
                    </div>
                </div>

                <div class="col-md-2">
                    <br />
                    <button type="button" class="btn btn-success btn-block" title="Buscar">BUSCAR</button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" id="ajax-bloque-pagos">
                    <table id="tabla-pagos" class="table table-bordered table-striped text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NUMERO</th>
                                <th>CARNET</th>
                                <th>ESTUDIANTE</th>
                                <th>RAZON</th>
                                <th>NIT</th>
                                <th>FECHA</th>
                                <th>MONTO</th>
                                <th>USUARIO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($facturas as $f)
                            <tr>
                                <td>{{ $f->id }}</td>
                                <td>{{ $f->numero }}</td>
                                <td>{{ $f->persona->cedula }}</td>
                                <td>{{ $f->persona->nombres }}</td>
                                <td>{{ $f->razon_social }}</td>
                                <td>{{ $f->nit }}</td>
                                <td>{{ $f->fecha }}</td>
                                <td>{{ $f->total }}</td>
                                <td>{{ $f->user->nombres }}</td>
                                <td>
                                    @if ($f->facturado=='Si')
                                        <a href="{{ url("Factura/muestraFactura/$f->id") }}" class="btn btn-info text-white" title="Muestra Factura"><i class="fas fa-eye"></i></a>
                                    @else
                                        <a href="{{ url("Factura/muestraRecibo/$f->id") }}" class="btn btn-primary text-white" title="Muestra Recibo"><i class="fas fa-eye"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- inicio modal prerequisitos -->

<!-- fin modal prerequisitos -->

@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script>
    $.ajaxSetup({
        // definimos cabecera donde estara el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('#tabla-pagos').DataTable({
            order: [[ 0, "desc" ]],
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });


    function buscaPago()
    {
        let datos_formulario = $("#formulario_pagos").serializeArray();  

        $.ajax({
            url: "{{ url('Factura/ajaxBuscaPago') }}",
            method: "POST",
            data: datos_formulario,
            success: function (data) {
                $("#ajax-bloque-pagos").html(data);
            }
        })

    }

</script>
@endsection