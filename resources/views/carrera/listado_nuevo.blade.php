@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            CARRERAS &nbsp;&nbsp;
            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nueva_carrera()"><i class="fas fa-plus"></i> &nbsp; NUEVA CARRERA</button>
        </h4>
    </div>
    <div class="card-body" id="lista">
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Nivel</th>
                        <th>A&ntilde;o vigente</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carreras as $key => $carrera)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $carrera->nombre }}</td>
                            <td>{{ $carrera->nivel }}</td>
                            <td>{{ $carrera->anio_vigente }}</td>
                            <td>
                                <button type="button" class="btn btn-info" title="Editar carrera"  onclick="editar('{{ $carrera->id }}', '{{ $carrera->nombre }}', '{{ $carrera->nivel }}', '{{ $carrera->anio_vigente }}')"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar carrera"  onclick="eliminar('{{ $carrera->id }}', '{{ $carrera->nombre }}')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- inicio modal nueva carrera -->
<div id="nueva_carrera" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">NUEVA CARRERA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Carrera/guardar') }}"  method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre_carrera" type="text" id="nombre_carrera" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nivel</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nivel_carrera" type="text" id="nivel_carrera" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">A&ntilde;o vigente</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="anio_vigente_carrera" type="text" id="anio_vigente_carrera" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_carrera()">GUARDAR CARRERA</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal nueva carrera -->

<!-- inicio modal editar carrera -->
<div id="editar_carreras" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">EDITAR CARRERA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Carrera/actualizar') }}"  method="POST" >
                @csrf
                <div class="modal-body">        
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre" type="text" id="nombre" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Nivel</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <input name="nivel" type="text" id="nivel" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">A&ntilde;o vigente</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <input name="anio_vigente" type="text" id="anio_vigente" class="form-control" required>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_carrera()">ACTUALIZAR CARRERA</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal editar carrera -->

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
<script>
    function nueva_carrera()
    {
        $("#nueva_carrera").modal('show');
    }

    function guardar_carrera()
    {
        var nombre_carrera = $("#nombre_carrera").val();
        var nivel_carrera = $("#nivel_carrera").val();
        var anio_vigente_carrera = $("#anio_vigente_carrera").val();
        if(nombre_carrera.length>0 && nivel_carrera.length>0 && anio_vigente_carrera.length>0){
            Swal.fire(
                'Excelente!',
                'Una nueva carrera fue registrada.',
                'success'
            )
        }
    }

    function editar(id, nombre, nivel, anio_vigente)
    {
        $("#id").val(id);
        $("#nombre").val(nombre);
        $("#nivel").val(nivel);
        $("#anio_vigente").val(anio_vigente);
        $("#editar_carreras").modal('show');
    }

    function actualizar_carrera()
    {
        var id = $("#id").val();
        var nombre = $("#nombre").val();
        var nivel = $("#nivel").val();
        var anio_vigente = $("#anio_vigente").val();
        if(nombre.length>0 && nivel.length>0 && anio_vigente.length>0){
            Swal.fire(
                'Excelente!',
                'Carrera actualizada correctamente.',
                'success'
            )
        }
    }

    function eliminar(id, nombre)
    {
        Swal.fire({
            title: 'Quieres borrar ' + nombre + '?',
            text: "Luego no podras recuperarlo!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Excelente!',
                    'La carrera fue eliminada',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Carrera/eliminar') }}/"+id;
                });
            }
        })
    }
</script>
@endsection
