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

        <div class="row">
            <div class="col-md-4">
                <div class="card card-outline-primary">                                
                    <div class="card-header">
                        <h4 class="mb-0 text-white">CARRERAS</h4>
                    </div>
                    <br />
                    <form action="/Carrera/listado" method="post" id="formulario_carreras">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Carreras </label>
                                    
                                    <select name="carrera_id" id="carrera_id" class="form-control custom-select">
                                        @foreach ($carreras as $c)
                                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Gestion </label>
                                    <input type="number" name="gestion" id="gestion" class="form-control" value="{{ $gestion }}" min="2011" max="{{ $gestion }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn waves-effect waves-light btn-block btn-success">VER ASIGNATURAS</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card card-outline-info">                                
                    <div class="card-header">
                        <h4 class="mb-0 text-white">ASIGNATURAS - ({{ $nombre_carrera }})</h4>
                    </div>
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
        </div>

    </div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>

<script>
    $.ajaxSetup({
    // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('#myTable').DataTable();
    });

    $('#formulario_carreras').on('submit', function(event) {
        var datos_formulario = $(this).serializeArray();
        // var otro = new FormData(this);
        // console.log(otro);
        event.preventDefault();

        $.ajax({
            url: "{{ url('Carrera/ajax_lista_asignaturas') }}",
            method: "POST",
            data: datos_formulario,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data)
            {
                //if(pregunto si es 1 o 0) 1->swwetalert
                console.log(data);
/*                $('#message').css('display', 'block');
                $('#message').html(data.message);
                $('#message').addClass(data.class_name);
*/            }
        })
    });
</script>
@endsection
