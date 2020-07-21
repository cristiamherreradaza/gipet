@extends('layouts.app')

@section('metadatos')
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Listado de Carreras</h4>
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sigla</th>
                        <th>Nombre</th>
                        <th>Curso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignaturas as $a)
                        <tr>
                            <td>{{ $a->codigo_asignatura }}</td>
                            <td>{{ $a->nombre_asignatura }}</td>
                            <td>{{ $a->semestre }}</td>
                            <td>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
<script>
    $(function () {
        $('#myTable').DataTable();
    });
</script>
@endsection