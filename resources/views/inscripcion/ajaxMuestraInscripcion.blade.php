<div class="modal-content">
    <div class="modal-header bg-info">
        <h4 class="modal-title text-white" id="myModalLabel">
            <strong>Carrera: {{ $registro->carrera->nombre }}</strong>
        </h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        <h6>
            <strong class="text-danger">Estudiante: </strong>
            {{ $registro->persona->nombres }} {{ $registro->persona->apellido_paterno }} {{ $registro->persona->apellido_materno }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <strong class="text-danger">Cedula de Identidad: </strong>
            {{ $registro->persona->cedula }}
        </h6>
        
        <!-- <form action="{{ url('Inscripcion/actualizarEstadoInscripcionGlobal') }}"  method="POST" > -->
        <form action="#"  method="POST" >
            @csrf
            <input type="hidden" name="persona_id" id="persona_id" value="{{ $registro->persona_id }}">
            <input type="hidden" name="registro_inscripcion" id="registro_inscripcion" value="{{ $registro->id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Turno</label>
                        <select name="turno_inscripcion" id="turno_inscripcion" class="form-control custom-select">
                            @foreach($turnos as $turno)
                                <option value="{{ $turno->id }}" {{ (( $turno->id == $registro->turno_id) ? 'selected' : '') }}>{{ $turno->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Paralelo</label>
                        <select name="paralelo_inscripcion" id="paralelo_inscripcion" class="form-control custom-select">
                            @foreach($paralelos as $paralelo)
                                <option value="{{ $paralelo->paralelo }}" {{ (( $paralelo->paralelo == $registro->paralelo) ? 'selected' : '') }}>{{ $paralelo->paralelo }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Estado General</label>
                        <select name="estado_inscripcion" id="estado_inscripcion" class="form-control custom-select">
                            <option value=""></option>
                            <option value="APROBO" {{ (($registro->estado && $registro->estado == 'APROBO') ? 'selected' : '') }}>APROBO</option>
                            <option value="REPROBO" {{ (($registro->estado && $registro->estado == 'REPROBO') ? 'selected' : '') }}>REPROBO</option>
                            <option value="CONGELADO" {{ (($registro->estado && $registro->estado == 'CONGELADO') ? 'selected' : '') }}>CONGELADO</option>
                            <option value="ABANDONO" {{ (($registro->estado && $registro->estado == 'ABANDONO') ? 'selected' : '') }}>ABANDONO</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">&nbsp;</label>
                        <button type="button" class="btn waves-effect waves-light btn-block btn-info" onclick="ajaxEditaInscripcion()">ACTUALIZAR</button>
                    </div>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead class="align-middle text-danger">
                    <tr>
                        <th class="text-nowrap">Fecha</th>
                        <th class="text-nowrap">Sigla</th>
                        <th class="text-nowrap">Asignatura</th>
                        <th class="text-nowrap">Turno</th>
                        <th class="text-nowrap">Paralelo</th>
                        <th class="text-nowrap">A&ntilde;o Vigente</th>
                        <th class="text-nowrap">Estado</th>
                        <th class="text-nowrap"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscripciones as $key => $inscripcion)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td class="text-nowrap">{{ $inscripcion->asignatura->sigla }}</td>
                            <td class="text-left">{{ $inscripcion->asignatura->nombre }}</td>
                            <td>{{ $inscripcion->turno->descripcion }}</td>
                            <td>{{ $inscripcion->paralelo }}</td>
                            <td>{{ $inscripcion->anio_vigente }}</td>
                            <td>
                                @if($inscripcion->congelado == 'Si')
                                    Congelado
                                @else
                                    {{ $inscripcion->estado }}
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <!-- <button type="button" class="btn btn-info" title="Congelar Asignatura" onclick="congelar('{{ $inscripcion->id }}', '{{ $inscripcion->asignatura->nombre }}', '{{ $inscripcion->congelado }}')"><i class="fas fa-snowflake"></i></button> -->
                                <button type="button" class="btn btn-danger" title="Eliminar Asignatura" onclick="eliminar('{{ $inscripcion->id }}', '{{ $inscripcion->asignatura->nombre }}')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
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
                    'La asignatura fue eliminada',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Inscripcion/eliminaAsignatura') }}/"+id;
                });
            }
        })
    }

    function ajaxEditaInscripcion()
    {
        var persona_id      = $("#persona_id").val();
        var inscripcion_id  = $("#registro_inscripcion").val();
        var turno_id        = $("#turno_inscripcion").val();
        var paralelo        = $("#paralelo_inscripcion").val();
        var estado          = $("#estado_inscripcion").val();
        Swal.fire({
            title: 'Actualizar información?',
            text: "",
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
                    url:    "{{ url('Inscripcion/ajaxEditaInscripcion') }}",
                    data:   {
                        persona_id: persona_id,
                        turno_id: turno_id,
                        paralelo: paralelo,
                        estado: estado,
                        inscripcion_id: inscripcion_id
                    },
                    cache:  false,
                    type:   'post',
                    // Posteriormente, si no hubo ningun conflicto con la ejecucion del proceso, se recargara utilizando otro ajax
                    success: function(data) {
                        $("#detalle_modal").modal('hide');
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
                        });
                        Swal.fire(
                            'Excelente!',
                            'La gestión fue actualizada',
                            'success'
                        )
                    }
                });
            }
        })
    }

    // function congelar(id, nombre, congelado)
    // {
    //     var estado;
    //     var estadoModificado;
    //     if(congelado == 'Si'){
    //         estado = 'descongelar';
    //         estadoModificado = 'descongelada';
    //     }
    //     else{
    //         estado = 'congelar';
    //         estadoModificado = 'congelada';
    //     }
    //     Swal.fire({
    //         title: 'Quieres '+ estado + ' ' + nombre + '?',
    //         text: "",
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Si, estoy seguro!',
    //         cancelButtonText: "Cancelar",
    //     }).then((result) => {
    //         if (result.value) {
    //             Swal.fire(
    //                 'Excelente!',
    //                 'La asignatura fue ' + estadoModificado,
    //                 'success'
    //             ).then(function() {
    //                 window.location.href = "{{ url('Inscripcion/congelaAsignatura') }}/"+id;
    //             });
    //         }
    //     })
    // }
</script>