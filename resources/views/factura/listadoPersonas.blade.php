@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('content')
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            Estudiantes
        </h4>
    </div>
    <div class="card-body" id="lista">
        <div class="table-responsive m-t-40">
            <table id="tabla-usuarios" class="table table-striped table-bordered no-wrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>CI</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Nombres</th>
                        <th>Numero Contacto</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script>
    // Funcion para usar ajax
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Funcion de configuracion de datatable y llamado de listado de personas ajax
    $(document).ready(function() {
        var table = $('#tabla-usuarios').DataTable( {
            iDisplayLength: 10,
            processing: true,
            serverSide: true,
            ajax: "{{ url('Factura/ajaxListadoPersonas') }}",
            columns: [
                {data: 'id'},
                {data: 'cedula'},
                {data: 'apellido_paterno'},
                {data: 'apellido_materno'},
                {data: 'nombres'},
                {data: 'numero_celular'},
                {data: 'action'},
            ],
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        } );
    } );

    function facturar(persona_id){
        window.location.href = "{{ url('Factura/formularioFacturacion') }}/" + persona_id;
    }

</script>
@endsection
