<h1 class="text-center text-dark-info"><strong>Historial Inscripciones</strong></h1>
<div class="table-responsive">
    <table class="table table-striped no-wrap text-center" id="tablaProductosEncontrados">
        <thead>
            <tr>
                <th>#</th>
                <th>Carrera</th>
                <th>Fecha</th>
                <th>Curso</th>
                <th>Turno</th>
                <th>Paralelo</th>
                <th>Gestion</th>
                <th>Estado</th>
                <th class="text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscripciones as $key => $inscripcion)
                @php
                    $registro = App\Inscripcione::where('persona_id', $persona->id)
                                                ->where('carrera_id', $inscripcion->carrera_id)
                                                // ->where('turno_id', $inscripcion->turno_id)
                                                ->where('anio_vigente', $inscripcion->anio_vigente)
                                                // ->where('fecha_registro', $inscripcion->fecha_inscripcion)
                                                ->first();
                @endphp
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>{{ $inscripcion->carrera->nombre }}</td>
                    <td>{{ $inscripcion->fecha_inscripcion }}</td>
                    <td>
                        @if($registro)
                            {{ $registro->gestion }} A&ntilde;o
                        @endif
                    </td>
                    <td>{{ $inscripcion->turno->descripcion }}</td>
                    <td>{{ $inscripcion->paralelo }}</td>
                    <td>{{ $inscripcion->anio_vigente }}</td>
                    <td>{{ $inscripcion->estado }}</td>
                    <td>
                        <button type="button" class="btn btn-info" title="Ver detalle" onclick="ajaxMuestraInscripcion('{{ $inscripcion->id }}')"><i class="fas fa-eye"></i></button>
                        <!-- <button type="button" class="btn btn-warning" title="Editar Inscripcion" onclick="ajaxEditaInscripcion('{{ $inscripcion->id }}')"><i class="fas fa-book"></i></button> -->
                        <a class="btn btn-light" title="Descargar Boletin" href="{{ url('Inscripcion/boletin/'.$inscripcion->id) }}" target="_blank"><i class="fas fa-file-pdf"></i></a>
                        <button type="button" class="btn btn-danger" title="Eliminar Inscripcion" onclick="ajaxEliminaInscripcion('{{ $inscripcion->id }}', '{{ $inscripcion->anio_vigente }}', '{{ $inscripcion->persona_id }}')"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- inicio modal detalle inscripcion -->
<div id="detalle_modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="contenido_modal">
        
    </div>
</div>
<!-- fin modal detalle inscripcion -->

<script>
    // Funcion que muestra los datos referentes a los una inscripcion del historial academico
    function ajaxMuestraInscripcion(inscripcion_id)
    {
        $.ajax({
            url: "{{ url('Inscripcion/ajaxMuestraInscripcion') }}",
            data: {
                inscripcion_id: inscripcion_id
                },
            type: 'get',
            success: function(data) {
                $("#contenido_modal").html(data);
                $("#detalle_modal").modal('show');
            }
        });
    }

    function ajaxEliminaInscripcion(inscripcion_id, anio_vigente, persona_id)
    {
        Swal.fire({
            title: 'Desea eliminar la gestion ' + anio_vigente + '?',
            text: "Luego no podras recuperarlo!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    // Se ejecutara la modificacion de la nota
                    url:    "{{ url('Inscripcion/ajaxEliminaInscripcion') }}",
                    data:   {
                        persona_id: persona_id,
                        inscripcion_id: inscripcion_id
                    },
                    cache:  false,
                    type:   'post',
                    // Posteriormente, si no hubo ningun conflicto con la ejecucion del proceso, se recargara utilizando otro ajax
                    success: function(data) {
                        $.ajax({
                            url:    "{{ url('Persona/ajaxDetalleHistorialInscripciones') }}",
                            data:   {
                                persona_id : persona_id
                            },
                            cache:  false,
                            type:   'get',
                            success: function (data) {
                                $("#detalleAcademicoAjax").show('slow');
                                $("#detalleAcademicoAjax").html(data);
                            }
                        });
                        Swal.fire(
                            'Excelente!',
                            'La gestión fue eliminada',
                            'success'
                        )
                    }
                });
            }
        })
    }
</script>