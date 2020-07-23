@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            PERFILES &nbsp;&nbsp;
            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nuevo_perfil()"><i class="fas fa-plus"></i> &nbsp; NUEVO PERFIL</button>
        </h4>
    </div>
    <div class="card-body" id="lista">
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($perfiles as $key => $perfil)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $perfil->nombre }}</td>
                            <td>{{ $perfil->descripcion }}</td>
                            <td>
                                <button type="button" class="btn btn-info" title="Editar perfil"  onclick="editar('{{ $perfil->id }}', '{{ $perfil->nombre }}', '{{ $perfil->descripcion }}')"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar perfil"  onclick="eliminar('{{ $perfil->id }}', '{{ $perfil->nombre }}')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- inicio modal nuevo perfil -->
<div id="nuevo_perfil" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">NUEVO PERFIL</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Perfil/guardar') }}"  method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre_perfil" type="text" id="nombre_perfil" maxlength="30" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Descripcion</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="descripcion_perfil" type="text" id="descripcion_perfil" maxlength="100" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Menus</label>
                                @foreach($menus as $key => $menu)
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input cajas" value="{{ $menu->id }}" id="customCheck{{$key}}" name="menus[]">
                                        <label for="customCheck{{$key}}" class="custom-control-label">{{ $menu->nombre }}</label>
                                    </div>
                                @endforeach
                                <!-- <div class="form-check form-check-inline">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">1</label>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_perfil()">GUARDAR PERFIL</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal nuevo perfil -->

<!-- inicio modal editar perfil -->
<div id="editar_perfiles" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">EDITAR PERFIL</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Perfil/actualizar') }}"  method="POST" >
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Descripcion</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="descripcion" type="text" id="descripcion" maxlength="100" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" id="ajaxListadoMenu">
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_perfil()">ACTUALIZAR PERFIL</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal editar perfil -->

@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script>
    // Funcion para cambiar el lenguaje al datatable
    $(function () {
        $('#myTable').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });

    });

    // Funcion que muestra el modal de nuevo Perfil
    function nuevo_perfil()
    {
        $("#nuevo_perfil").modal('show');
    }

    // Validacion antes de guardar un perfil nuevo
    function guardar_perfil()
    {
        var nombre_perfil = $("#nombre_perfil").val();
        var descripcion_perfil = $("#descripcion_perfil").val();
        if(nombre_perfil.length>0 && descripcion_perfil.length>0){
            Swal.fire(
                'Excelente!',
                'Un nuevo perfil fue registrado.',
                'success'
            )
        }
    }

    // Funcion que muestra el modal de edicion de Perfil
    function editar(id, nombre, descripcion)
    {
        $("#id").val(id);
        $("#nombre").val(nombre);
        $("#descripcion").val(descripcion);
        // Ajax Menus
        $.ajax({
            url: "{{ url('Perfil/ajaxListadoMenu') }}",
            data: {
                id: id
                },
            type: 'GET',
            success: function(data) {
                $("#ajaxListadoMenu").show('slow');
                $("#ajaxListadoMenu").html(data);
            }
        });
        $("#editar_perfiles").modal('show');
    }

    // Validacion antes de actualizar un perfil existente
    function actualizar_perfil()
    {
        var id = $("#id").val();
        var nombre = $("#nombre").val();
        var descripcion = $("#descripcion").val();
        if(nombre.length>0 && descripcion.length>0){
            Swal.fire(
                'Excelente!',
                'Perfil actualizado correctamente.',
                'success'
            )
        }
    }

    // Funcion para eliminacion de perfil
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
                    'El perfil fue eliminado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Perfil/eliminar') }}/"+id;
                });
            }
        })
    }

    // Funcion para colocar todos los valores en ""
    $( function() {
        $("#nombre_perfil").val("");
        $("#descripcion_perfil").val("");
        $(".cajas").prop("checked", false);
    });
</script>
@endsection