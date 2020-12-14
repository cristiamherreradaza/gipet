@extends('layouts.app')

@section('metadatos')
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <h3 class="card-title text-primary"><strong>LISTADO DE CARRERAS</strong></h3>
        <h6 class="card-subtitle text-dark">DOCENTE: {{ auth()->user()->nombres }} {{ auth()->user()->apellido_paterno }} {{ auth()->user()->apellido_materno }}</h6>
        <h6 class="card-subtitle">Año {{ date('Y') }}</h6>
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Carrera</th>
                        <th>Materia</th>
                        <th>Gestion</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carrerasDocente as $cd)
                        <tr>
                            <td>{{ $cd->carrera->nombre }}</td>
                            <td>{{ $cd->asignatura->nombre }}</td>
                            <td>{{ $cd->anio_vigente }}</td>
                            <td><a href="{{ url('nota/detalle/'.$cd->id) }}" class="btn btn-info btn-rounded btn-sm"><i class="mdi mdi-note-text"></i> Notas</a></td>
                        </tr>
                    @endforeach
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
    $(function () {
        $('#myTable').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });

</script>
@endsection
