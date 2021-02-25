<h1 class="text-center text-dark-info"><strong>Materias Actuales</strong></h1>
@foreach($carreras as $carrera)
    @php
        $informacionCarrera = App\Carrera::find($carrera->id);
        $asignaturas = App\Inscripcione::where('persona_id', $persona->id)
                                        ->where('carrera_id', $informacionCarrera->id)
                                        ->get();
        $key=1;
        $existenciaInscripcion = App\Inscripcione::where('persona_id', $persona->id)
                                                ->where('carrera_id', $informacionCarrera->id)
                                                ->where('estado', 'Cursando')
                                                ->first();
        if($existenciaInscripcion)
        {
            $existenciaNota = App\Nota::where('persona_id', $persona->id)
                                ->where('inscripcion_id', $existenciaInscripcion->id)
                                ->whereNull('finalizado')
                                ->first();
            if($existenciaNota)
            {
                $mostrar = 'Si';
            }
        }
        else
        {
            $mostrar = 'No';
        }
    @endphp
    <h3>
        <strong class="text-danger">{{ strtoupper($informacionCarrera->nombre) }}</strong>
        @if($mostrar == 'Si')
            <button type="button" onclick="finalizarCalificaciones('{{ $persona->id }}', '{{ $informacionCarrera->id }}')" class="float-right btn btn-danger">Finalizar Calificaciones</button>
        @endif
    </h3>
    <div class="table-responsive">
        <table class="table table-striped no-wrap text-center" id="tablaProductosEncontrados">
            <thead>
                <tr>
                    <th>#</th>
                    <th>FECHA INSCRIPCION</th>
                    <th>SIGLA</th>
                    <th>ASIGNATURA</th>
                    <th>1ER BIMESTRE</th>
                    <th>2DO BIMESTRE</th>
                    <th>3ER BIMESTRE</th>
                    <th>4TO BIMESTRE</th>
                    <th>TOTAL</th>
                    <th>RECUPERATORIO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscripciones as $materia)
                    @if($materia->carrera_id == $informacionCarrera->id && $materia->estado == 'Cursando')
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $materia->fecha_registro }}</td>
                            <td>{{ $materia->asignatura->sigla }}</td>
                            <td class="text-left">{{ $materia->asignatura->nombre }}</td>
                            @php
                                $notas = App\Nota::where('inscripcion_id', $materia->id)
                                                ->get();
                            @endphp
                            @foreach($notas as $nota)
                                @if($nota->trimestre == 1)
                                    <td>{{ $nota->nota_total ? round($nota->nota_total) : 0 }}</td>
                                @endif
                                @if($nota->trimestre == 2)
                                    <td>{{ $nota->nota_total ? round($nota->nota_total) : 0 }}</td>
                                @endif
                                @if($nota->trimestre == 3)
                                    <td>{{ $nota->nota_total ? round($nota->nota_total) : 0 }}</td>
                                @endif
                                @if($nota->trimestre == 4)
                                    <td>{{ $nota->nota_total ? round($nota->nota_total) : 0 }}</td>
                                @endif
                            @endforeach
                            <td>
                                @if($materia->nota)
                                    @if($materia->nota >= $materia->nota_aprobacion)
                                        <strong class="text-success">{{ round($materia->nota) }}</strong>
                                    @else
                                        <strong class="text-danger">{{ round($materia->nota) }}</strong>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @php
                                    $resultado = App\Nota::where('inscripcion_id', $materia->id)
                                                            ->first();
                                @endphp
                                {{ $resultado->segundo_turno ? $resultado->segundo_turno : '-' }}
                            </td>
                            <td>
                                <button type="button" class="btn btn-info" title="Ver detalle" onclick="ajaxMuestraNotaInscripcion('{{ $materia->id }}')"><i class="fas fa-eye"></i></button>
                                @php
                                    $asignaturaAprobada = App\Inscripcione::where('carrera_id', $materia->carrera_id)
                                                                        ->where('asignatura_id', $materia->asignatura_id)
                                                                        ->where('persona_id', $materia->persona_id)
                                                                        ->where('estado', 'Finalizado')
                                                                        ->where('aprobo', 'Si')
                                                                        ->whereNull('nota_reprobacion')
                                                                        ->first();
                                @endphp
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-info dropdown-toggle" title="Convalidar Asignatura" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-magic"></i>
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <form action="#" method="POST" class="px-4 py-3">
                                            @csrf
                                            <input type="hidden" name="persona_id" id="persona_id" value="{{ $materia->persona_id }}">
                                            <input type="hidden" name="id" id="id_{{ $materia->id }}" value="{{ $materia->id }}">
                                            <div class="form-group">
                                                <label class="control-label">Puntaje Final</label>
                                                <input type="number" class="form-control" id="nota_{{ $materia->id }}" name="nota" min="1" max="100">
                                            </div>
                                            <button type="button" class="btn btn-block btn-info" onclick="convalida_asignatura('{{ $materia->id }}')">CONVALIDAR</button>
                                        </form>
                                    </div>
                                </div>
                                @if($asignaturaAprobada)
                                    <button type="button" class="btn btn-success" title="Convalidar Asignatura Aprobada" onclick="convalidarAsignaturaAprobada('{{ $materia->id }}')"><i class="fas fa-check-circle"></i></button>
                                @endif
                            </td>
                        </tr>
                        @php
                            $key++
                        @endphp
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
@endforeach

<!-- inicio modal editar perfil -->
<div id="detalle_modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="contenido_modal">
        
    </div>
</div>
<!-- fin modal editar perfil -->

<script>
    // Funcion ajax que convalida asignatura
    function convalida_asignatura(inscripcion_id)
    {
        // Capturamos todas las variables que se encuentran en el formulario de regularizacion
        asignatura_id   = $("#id_"+inscripcion_id).val();
        persona_id      = $("#persona_id").val();
        nota            = $("#nota_"+inscripcion_id).val();
        // Utilizamos Ajax
        $.ajax({
            // Se ejecutara la modificacion de la nota
            url:    "{{ url('Inscripcion/asignarPuntaje') }}",
            data:   {
                asignatura_id: asignatura_id,
                persona_id: persona_id,
                nota: nota
            },
            cache:  false,
            type:   'post',
            // Posteriormente, si no hubo ningun conflicto con la ejecucion del proceso, se recargara utilizando otro ajax
            success: function(data) {
                $.ajax({
                    url:    "{{ url('Persona/ajaxDetalleMaterias') }}",
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
                    'La asignatura fue convalidada',
                    'success'
                )
            }
        });
    }

    // Funcion que muestra los datos referentes a los una inscripcion del historial academico
    function ajaxMuestraNotaInscripcion(inscripcion_id)
    {
        $.ajax({
            url: "{{ url('Inscripcion/ajaxMuestraNotaInscripcion') }}",
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

    function finalizarCalificaciones(persona_id, carrera_id)
    {
        Swal.fire({
            title: 'Deseas finalizar el periodo de calificación?',
            text: "Los docentes asignados a estas asignaturas no podran modificar los registros!",
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
                    'Calificaciones finalizadas',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Inscripcion/finalizarCalificaciones') }}/"+persona_id+'/'+carrera_id;
                });
            }
        })
    }

    function convalidarAsignaturaAprobada(inscripcion_id)
    {
        Swal.fire({
            title: 'Deseas convalidar esta asignatura?',
            text: "Las notas se reemplazaran con las anteriores!",
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
                    'Asignatura convalidada',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Inscripcion/convalidarAsignaturaAprobada') }}/"+inscripcion_id;
                });
            }
        })
    }
</script>