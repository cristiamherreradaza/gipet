@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            CERTIFICADOS &nbsp;&nbsp;
            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nuevo_certificado()"><i class="fas fa-plus"></i> &nbsp; NUEVO CERTIFICADO</button>
        </h4>
    </div>
    <div class="card-body" id="lista">
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>A&ntilde;o Vigente</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certificados as $key => $certificado)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $certificado->nombre }}</td>
                            <td>{{ $certificado->anio_vigente }}</td>
                            <td>
                                <button type="button" class="btn btn-light" title="Editar requisitos"  onclick="permisos('{{ $certificado->id }}')"><i class="fas fa-list"></i></button>
                                <button type="button" class="btn btn-info" title="Editar certificado"  onclick="editar('{{ $certificado->id }}', '{{ $certificado->nombre }}', '{{ $certificado->anio_vigente }}')"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar certificado"  onclick="eliminar('{{ $certificado->id }}', '{{ $certificado->nombre }}')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- inicio modal nuevo certificado -->
<div id="nuevo_certificado" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">NUEVO CERTIFICADO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Certificado/guardar') }}"  method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre_certificado" type="text" id="nombre_certificado" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">A&ntilde;o Vigente</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="anio_vigente_certificado" type="number" id="anio_vigente_certificado" class="form-control" value="{{ date('Y') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_certificado()">GUARDAR CERTIFICADO</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal nuevo certificado -->

<!-- inicio modal editar certificado -->
<div id="editar_certificado" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">EDITAR CERTIFICADO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Certificado/actualizar') }}"  method="POST" >
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">A&ntilde;o Vigente</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="anio_vigente" type="number" id="anio_vigente" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_certificado()">ACTUALIZAR CERTIFICADO</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal editar certificado -->

<!-- inicio modal editar requisitos -->
<div id="editar_requisitos" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">ASIGNAR REQUISITOS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Certificado/requisitos') }}"  method="POST" >
                @csrf
                <div class="modal-body">        
                    <input type="hidden" name="certificado_id" id="certificado_id">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Carrera</label>
                                <select name="requisito_carrera" id="requisito_carrera" class="form-control">
                                    @foreach($carreras as $carrera)
                                        <option value="{{ $carrera->id }}"> {{ $carrera->nombre }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="editaRequisitosAjax">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_perfil()">CONFIRMAR</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal editar requisitos -->
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
    function nuevo_certificado()
    {
        $("#nuevo_certificado").modal('show');
    }

    function guardar_certificado()
    {
        var nombre_certificado = $("#nombre_certificado").val();
        var anio_vigente_certificado = $("#anio_vigente_certificado").val();
        if(nombre_certificado.length>0 && anio_vigente_certificado.length>0){
            Swal.fire(
                'Excelente!',
                'Un nuevo certificado fue registrado.',
                'success'
            )
        }
    }

    function editar(id, nombre, anio_vigente)
    {
        $("#id").val(id);
        $("#nombre").val(nombre);
        $("#anio_vigente").val(anio_vigente);
        $("#editar_certificado").modal('show');
    }

    function actualizar_certificado()
    {
        var id = $("#id").val();
        var nombre = $("#nombre").val();
        var anio_vigente = $("#anio_vigente").val();
        if(nombre.length>0 && anio_vigente.length>0){
            Swal.fire(
                'Excelente!',
                'Certificado actualizado correctamente.',
                'success'
            )
        }
    }

    function permisos(certificado_id)
    {
        $("#certificado_id").val(certificado_id);
        var requisito_carrera = $("#requisito_carrera").val();
        $.ajax({
            url: "{{ url('Certificado/ajaxEditaRequisitos') }}",
            data: {
                certificado_id: certificado_id,
                requisito_carrera : requisito_carrera
                },
            type: 'get',
            success: function(data) {
                $("#editaRequisitosAjax").html(data);
                $("#editar_requisitos").modal('show');
            }
        });
    }

    //Funcion para cambiar datos de asignaturas
    $( function() {
        $("#requisito_carrera").change( function() {
            var certificado_id = $("#certificado_id").val();
            var requisito_carrera = $("#requisito_carrera").val();
            $.ajax({
                url: "{{ url('Certificado/ajaxEditaRequisitos') }}",
                data: {
                    certificado_id: certificado_id,
                    requisito_carrera : requisito_carrera
                    },
                type: 'get',
                success: function(data) {
                    $("#editaRequisitosAjax").html(data);
                    $("#editar_requisitos").modal('show');
                }
            });
        });
    });

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
                    'El certificado fue eliminado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Certificado/eliminar') }}/"+id;
                });
            }
        })
    }
</script>
@endsection