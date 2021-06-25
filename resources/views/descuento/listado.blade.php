@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            DESCUENTOS &nbsp;&nbsp;
            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nuevo_descuento()"><i class="fas fa-plus"></i> &nbsp; NUEVO DESCUENTO</button>
        </h4>
    </div>
    <div class="card-body" id="lista">
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Monto</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($descuentos as $key => $descuento)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $descuento->nombre }}</td>
                            <td>{{ $descuento->a_pagar }}</td>
                            <td>
                                <button type="button" class="btn btn-info" title="Editar descuento"  onclick="editar('{{ $descuento->id }}', '{{ $descuento->nombre }}', '{{ $descuento->monto }}')"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar descuento"  onclick="eliminar('{{ $descuento->id }}', '{{ $descuento->nombre }}', '{{ $descuento->servicio_id }}')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- inicio modal nuevo descuento -->
<div id="nuevo_descuento" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">NUEVO DESCUENTO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Descuento/guardar') }}"  method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre_descuento" type="text" id="nombre_descuento" maxlength="30" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Monto</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="monto_descuento" type="number" id="monto_descuento" pattern="^[0-9]+" min="0" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_descuento()">GUARDAR DESCUENTO</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal nuevo descuento -->

<!-- inicio modal editar descuento -->
<div id="editar_descuentos" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">EDITAR DESCUENTO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Descuento/actualizar') }}"  method="POST" >
                @csrf
                <div class="modal-body">        
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre" type="text" id="nombre" maxlength="30" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Monto</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="monto" type="number" id="monto" pattern="^[0-9]+" min="0" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_descuento()">ACTUALIZAR DESCUENTO</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal editar descuento -->

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
    function nuevo_descuento()
    {
        $("#nuevo_descuento").modal('show');
    }

    function guardar_descuento()
    {
        var nombre_descuento = $("#nombre_descuento").val();
        var monto_descuento = $("#monto_descuento").val();
        if(monto_descuento>=0){
            if(nombre_descuento.length>0 && monto_descuento.length>0){
                Swal.fire(
                    'Excelente!',
                    'Un nuevo descuento fue registrado.',
                    'success'
                )
            }
        }
    }

    function editar(id, nombre, monto)
    {
        $("#id").val(id);
        $("#nombre").val(nombre);
        $("#monto").val(monto);
        $("#editar_descuentos").modal('show');
    }

    function actualizar_descuento()
    {
        var id = $("#id").val();
        var nombre = $("#nombre").val();
        var monto = $("#monto").val();
        if(monto>=0){
            if(nombre.length>0 && monto.length>0){
                Swal.fire(
                    'Excelente!',
                    'Descuento actualizado correctamente.',
                    'success'
                )
            }
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
                    'El descuento fue eliminado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Descuento/eliminar') }}/"+id;
                });
            }
        })
    }
</script>
@endsection