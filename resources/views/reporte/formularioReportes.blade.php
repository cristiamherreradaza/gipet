@extends('layouts.reporte')

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
            PENSIONES POR PERIODOS
        </h4>
    </div>
    <div class="card-body">

        <form action="{{ url('Reporte/pencionesPorPeriodo') }}" method="POST">
            @csrf
            <div class="row">

                <div class="col-md-1">
                    <div class="form-group">
                        <label class="control-label">Curso</label>
                        <select name="gestion" id="gestion" class="form-control">
                            <option value="1"> 1° A&ntilde;o </option>
                            <option value="2"> 2° A&ntilde;o </option>
                            <option value="3"> 3° A&ntilde;o </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Turno</label>
                        <select name="turno_id" id="turno_id" class="form-control">
                            @foreach($turnos as $turno)
                            <option value="{{ $turno->id }}"> {{ $turno->descripcion }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Fecha Inicio </label>
                        <input type="number" name="anio_vigente" id="anio_vigente" class="form-control" min="2021" max="2050">
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Fecha Inicio </label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
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
                    <button type="submit" formtarget="_blank" class="btn btn-success btn-block" title="Buscar">GENERAR</button>
                </div>
            </div>
        </form>

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
            searching: false,
            lengthChange: false,
            order: [[ 0, "desc" ]]
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