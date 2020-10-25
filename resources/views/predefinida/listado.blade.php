@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            NOTAS PREDEFINIDAS &nbsp;&nbsp;
            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nueva_predefinida()"><i class="fas fa-plus"></i> &nbsp; NUEVA NOTA PREDEFINIDA</button>
        </h4>
    </div>
    <div class="card-body" id="lista">
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Asistencia</th>
                        <th>Practicas</th>
                        <th>Primer Parcial</th>
                        <th>Examen Final</th>
                        <th>Puntos Extras</th>
                        <th>A&ntilde;o vigente</th>
                        <th>Activo</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($predefinidas as $key => $predefinida)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{ round($predefinida->nota_asistencia) }}</td>
                            <td>{{ round($predefinida->nota_practicas) }}</td>
                            <td>{{ round($predefinida->nota_primer_parcial) }}</td>
                            <td>{{ round($predefinida->nota_examen_final) }}</td>
                            <td>{{ round($predefinida->nota_puntos_ganados) }}</td>
                            <td>{{ $predefinida->anio_vigente }}</td>
                            <td>
                                @if($predefinida->activo == 'Si')
                                    <strong class="text-success">{{ $predefinida->activo }}</strong>
                                @else
                                    <strong class="text-danger">{{ $predefinida->activo }}</strong>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-light" title="Habilitar/Deshabilitar Nota Predefinida"  onclick="cambiar('{{ $predefinida->id }}')"><i class="fas fa-arrows-alt-v"></i></button>
                                <button type="button" class="btn btn-info" title="Editar Nota Predefinida"  onclick="editar('{{ $predefinida->id }}', '{{ $predefinida->nota_asistencia }}', '{{ $predefinida->nota_practicas }}', '{{ $predefinida->nota_puntos_ganados }}', '{{ $predefinida->nota_primer_parcial }}', '{{ $predefinida->nota_examen_final }}', '{{ $predefinida->anio_vigente }}')"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar Nota Predefinida"  onclick="eliminar('{{ $predefinida->id }}')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- inicio modal nueva nota predefinida -->
<div id="nueva_predefinida" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">NUEVA NOTA PREDEFINIDA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Predefinida/guardar') }}"  method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Asistencia</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_asistencia" type="number" id="nota_asistencia" value="0" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Practicas</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_practicas" type="number" id="nota_practicas" value="0" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Primer Parcial</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_primer_parcial" type="number" id="nota_primer_parcial" value="0" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Examen Final</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_examen_final" type="number" id="nota_examen_final" value="0" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Puntos Ganados</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_puntos_ganados" type="number" id="nota_puntos_ganados" value="0" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">A&ntilde;o Vigente</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="anio_vigente" type="number" id="anio_vigente" value="{{ date('Y') }}" class="form-control" required>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_predefinida()">GUARDAR NOTA PREDEFINIDA</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal nueva nota predefinida -->

<!-- inicio modal editar nota predefinida -->
<div id="editar_predefinidas" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">EDITAR TURNO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Predefinida/actualizar') }}"  method="POST" >
                @csrf
                <div class="modal-body">        
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Asistencia</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_asistencia_edicion" type="text" id="nota_asistencia_edicion" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Practicas</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_practicas_edicion" type="number" id="nota_practicas_edicion"class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Primer Parcial</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_primer_parcial_edicion" type="number" id="nota_primer_parcial_edicion" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Examen Final</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_examen_final_edicion" type="number" id="nota_examen_final_edicion" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Puntos Ganados</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_puntos_ganados_edicion" type="number" id="nota_puntos_ganados_edicion" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">A&ntilde;o Vigente</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="anio_vigente_edicion" type="number" id="anio_vigente_edicion" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_predefinida()">ACTUALIZAR NOTA PREDEFINIDA</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal editar nota predefinida -->

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
    function nueva_predefinida()
    {
        $("#nueva_predefinida").modal('show');
    }

    function guardar_predefinida()
    {
        var nota_asistencia = $("#nota_asistencia").val();
        var nota_practicas = $("#nota_practicas").val();
        var nota_puntos_ganados = $("#nota_puntos_ganados").val();
        var nota_primer_parcial = $("#nota_primer_parcial").val();
        var nota_examen_final = $("#nota_examen_final").val();
        var anio_vigente = $("#anio_vigente").val();
        if(nota_asistencia.length>0 && nota_practicas.length>0 && nota_puntos_ganados.length>0 && nota_primer_parcial.length>0 && nota_examen_final.length>0 && anio_vigente.length>0){
            Swal.fire(
                'Excelente!',
                'Un nuevo Registro fue registrado.',
                'success'
            )
        }
    }

    function editar(id, nota_asistencia_edicion, nota_practicas_edicion, nota_puntos_ganados_edicion, nota_primer_parcial_edicion, nota_examen_final_edicion, anio_vigente_edicion)
    {
        $("#id").val(id);
        $("#nota_asistencia_edicion").val(nota_asistencia_edicion);
        $("#nota_practicas_edicion").val(nota_practicas_edicion);
        $("#nota_puntos_ganados_edicion").val(nota_puntos_ganados_edicion);
        $("#nota_primer_parcial_edicion").val(nota_asistencia_edicion);
        $("#nota_examen_final_edicion").val(nota_examen_final_edicion);
        $("#anio_vigente_edicion").val(anio_vigente_edicion);
        $("#editar_predefinidas").modal('show');
    }

    function actualizar_predefinida()
    {
        var id = $("#id").val();
        var nota_asistencia_edicion = $("#nota_asistencia_edicion").val();
        var nota_practicas_edicion = $("#nota_practicas_edicion").val();
        var nota_puntos_ganados_edicion = $("#nota_puntos_ganados_edicion").val();
        var nota_primer_parcial_edicion = $("#nota_primer_parcial_edicion").val();
        var nota_examen_final_edicion = $("#nota_examen_final_edicion").val();
        var anio_vigente_edicion = $("#anio_vigente_edicion").val();
        if(nota_asistencia_edicion.length>0 && nota_practicas_edicion.length>0 && nota_puntos_ganados_edicion.length>0 && nota_primer_parcial_edicion.length>0 && nota_examen_final_edicion.length>0 && anio_vigente_edicion.length>0){
            Swal.fire(
                'Excelente!',
                'Registro actualizado correctamente.',
                'success'
            )
        }
    }

    function eliminar(id)
    {
        Swal.fire({
            title: 'Quieres borrar esta nota predefinida?',
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
                    'El registro fue eliminado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Predefinida/eliminar') }}/"+id;
                });
            }
        })
    }

    function cambiar(id)
    {
        Swal.fire({
            title: 'Quieres cambiar el estado de esta nota predefinida?',
            text: "",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Excelente!',
                    'El registro fue modificado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Predefinida/cambiar') }}/"+id;
                });
            }
        })
    }
</script>
@endsection