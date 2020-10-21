@extends('layouts.app')

@section('metadatos')
@endsection

@section('css')
<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/responsive.dataTables.min.css') }}"> -->
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <h3 class="card-title text-primary"><strong>LISTADO DE ASIGNATURAS</strong></h3>
        <h6 class="card-subtitle text-dark">DOCENTE: {{ auth()->user()->nombres }} {{ auth()->user()->apellido_paterno }} {{ auth()->user()->apellido_materno }}</h6>
        <h6 class="card-subtitle">Año {{ date('Y') }}</h6>
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped text-center">
                <thead class="text-primary">
                    <tr>
                        <th>Carrera</th>
                        <th>Sigla</th>
                        <th>Asignatura</th>
                        <th>Gestion</th>
                        <th>Semestre</th>
                        <th>Turno</th>
                        <th>Paralelo</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignaturas as $asignatura)
                        <tr>
                            <td>{{ $asignatura->asignatura->carrera->nombre }}</td>
                            <td>{{ $asignatura->asignatura->sigla }}</td>
                            <td>{{ $asignatura->asignatura->nombre }}</td>
                            <td>{{ $asignatura->asignatura->gestion }}</td>
                            <td>{{ $asignatura->asignatura->semestre }}</td>
                            <td>{{ $asignatura->turno->descripcion }}</td>
                            <td>{{ $asignatura->paralelo }}</td>
                            <td><a href="{{ url('nota/detalle/'.$asignatura->id) }}" class="btn btn-info btn-rounded btn-sm"><i class="mdi mdi-note-text"></i> Notas</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('js')
<!-- <script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script> -->
<script>
    $(function () {
        $('#myTable').DataTable();
    });
</script>
@endsection
