@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            SERVICIOS &nbsp;&nbsp;
            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nuevo_servicio()"><i class="fas fa-plus"></i> &nbsp; NUEVO SERVICIO</button>
        </h4>
    </div>
    <div class="card-body" id="lista">
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sigla</th>
                        <th>Nombre</th>
                        <th>Costo</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $key => $servicio)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $servicio->sigla }}</td>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ $servicio->precio }}</td>
                            <td>
                                <button type="button" class="btn btn-info" title="Editar servicio"  onclick="editar('{{ $servicio->id }}', '{{ $servicio->nombre }}', '{{ $servicio->sigla }}', '{{ $servicio->precio }}')"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar servicio"  onclick="eliminar('{{ $servicio->id }}', '{{ $servicio->nombre }}')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- inicio modal nuevo servicio -->
<div id="nuevo_servicio" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">NUEVO SERVICIO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Servicio/guardar') }}"  method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre_servicio" type="text" id="nombre_servicio" maxlength="30" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Sigla</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="sigla_servicio" type="text" id="sigla_servicio" maxlength="30" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Costo</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="precio_servicio" type="number" id="precio_servicio" pattern="^[0-9]+" min="0" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_servicio()">GUARDAR SERVICIO</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal nuevo servicio -->

<!-- inicio modal editar servicio -->
<div id="editar_servicios" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">EDITAR SERVICIO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Servicio/actualizar') }}"  method="POST" >
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
                                <input name="nombre" type="text" id="nombre" maxlength="30" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Sigla</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="sigla" type="text" id="sigla" maxlength="30" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Costo</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="precio" type="number" id="precio" pattern="^[0-9]+" min="0" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_turno()">ACTUALIZAR SERVICIO</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal editar servicio -->

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
    function nuevo_servicio()
    {
        $("#nuevo_servicio").modal('show');
    }

    function guardar_servicio()
    {
        var nombre_servicio = $("#nombre_servicio").val();
        var sigla_servicio = $("#sigla_servicio").val();
        var precio_servicio = $("#precio_servicio").val();
        if(nombre_servicio.length>0 && sigla_servicio.length>0 && precio_servicio.length>0){
            Swal.fire(
                'Excelente!',
                'Un nuevo servicio fue registrado.',
                'success'
            )
        }
    }

    function editar(id, nombre, sigla, precio)
    {
        $("#id").val(id);
        $("#nombre").val(nombre);
        $("#sigla").val(sigla);
        $("#precio").val(precio);
        $("#editar_servicios").modal('show');
    }

    function actualizar_turno()
    {
        var id = $("#id").val();
        var nombre = $("#nombre").val();
        var sigla = $("#sigla").val();
        var precio = $("#precio").val();
        if(nombre.length>0 && sigla.length>0 && precio.length>0){
            Swal.fire(
                'Excelente!',
                'Servicio actualizado correctamente.',
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
                    'El servicio fue eliminado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Servicio/eliminar') }}/"+id;
                });
            }
        })
    }
</script>
@endsection