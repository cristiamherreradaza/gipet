@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            RESOLUCIONES &nbsp;&nbsp;
            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nueva_resolucion()"><i class="fas fa-plus"></i> &nbsp; NUEVA RESOLUCION</button>
        </h4>
    </div>
    <div class="card-body" id="lista">
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Resolucion Ministerial</th>
                        <th>Nota Aprobacion</th>
                        <th>Año Vigente</th>
                        <th>Semestre</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resoluciones as $key => $resolucion)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ $resolucion->resolucion }}</td>
                            <td>{{ $resolucion->nota_aprobacion }}</td>
                            <td>{{ $resolucion->anio_vigente }}</td>
                            <td>{{ $resolucion->semestre }}</td>
                            <td>
                                <button type="button" class="btn btn-info" title="Editar resolucion" onclick="editar('{{ $resolucion->id }}', '{{ $resolucion->resolucion }}', '{{ $resolucion->nota_aprobacion }}', '{{ $resolucion->anio_vigente }}', '{{ $resolucion->semestre }}')"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar resolucion" onclick="eliminar('{{ $resolucion->id }}', '{{ $resolucion->resolucion }}')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- inicio modal nueva resolucion -->
<div id="nueva_resolucion" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">NUEVA RESOLUCION</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Resolucion/guardar') }}"  method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Resolucion Ministerial</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre_resolucion" type="text" id="nombre_resolucion" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nota Aprobacion</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_aprobacion_resolucion" type="number" id="nota_aprobacion_resolucion" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Año Vigente</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="anio_vigente_resolucion" type="number" id="anio_vigente_resolucion" value="{{ date('Y') }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Semestre</label>
                                <input name="semestre_resolucion" type="number" id="semestre_resolucion" value="1" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_resolucion()">GUARDAR RESOLUCION</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal nueva resolucion -->

<!-- inicio modal editar resolucion -->
<div id="editar_resoluciones" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">EDITAR RESOLUCION</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Resolucion/actualizar') }}"  method="POST" >
                @csrf
                <div class="modal-body">        
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Resolucion Ministerial</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre" type="text" id="nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nota Aprobacion</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_aprobacion" type="number" id="nota_aprobacion" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Año Vigente</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="anio_vigente" type="number" id="anio_vigente" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Semestre</label>
                                <input name="semestre" type="number" id="semestre" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_turno()">ACTUALIZAR TURNO</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal editar resolucion -->

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

    function nueva_resolucion()
    {
        $("#nueva_resolucion").modal('show');
    }

    function guardar_resolucion()
    {
        var nombre_resolucion = $("#nombre_resolucion").val();
        var nota_aprobacion_resolucion = $("#nota_aprobacion_resolucion").val();
        var anio_vigente_resolucion = $("#anio_vigente_resolucion").val();
        if(nombre_resolucion.length>0 && nota_aprobacion_resolucion.length>0 && anio_vigente_resolucion.length>0){
            Swal.fire(
                'Excelente!',
                'Una nueva resolucion fue registrada.',
                'success'
            )
        }
    }

    function editar(id, nombre, nota_aprobacion, anio_vigente, semestre)
    {
        $("#id").val(id);
        $("#nombre").val(nombre);
        $("#nota_aprobacion").val(nota_aprobacion);
        $("#anio_vigente").val(anio_vigente);
        $("#semestre").val(semestre);
        $("#editar_resoluciones").modal('show');
    }

    function actualizar_turno()
    {
        var id = $("#id").val();
        var nombre = $("#nombre").val();
        var nota_aprobacion = $("#nota_aprobacion").val();
        var anio_vigente = $("#anio_vigente").val();
        if(nombre.length>0 && nota_aprobacion.length>0 && anio_vigente.length>0){
            Swal.fire(
                'Excelente!',
                'Resolucion actualizada correctamente.',
                'success'
            )
        }
    }

    function eliminar(id, nombre)
    {
        Swal.fire({
            title: 'Quieres borrar la resolucion ' + nombre + '?',
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
                    'La resolucion fue eliminada',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Resolucion/eliminar') }}/"+id;
                });
            }
        })
    }
</script>
@endsection