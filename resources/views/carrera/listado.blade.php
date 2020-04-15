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
                        <th>Nombre</th>
                        <th>Nivel</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carreras as $c)
                        <tr>
                            <td>{{ $c->nombre }}</td>
                            <td>{{ $c->nivel }}</td>
                            <td>
                                <a href="{{ url('Asignatura/listado_malla/'.$c->id) }}">
                                    <button type="button" class="btn btn-info"><i class="fas fa-eye"></i></button>
                                </a>
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
