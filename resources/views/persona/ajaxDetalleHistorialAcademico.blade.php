<h1 class="text-center text-dark-info"><strong>Historial Academico</strong></h1>
@foreach($carreras as $carrera)
    @php
        $informacionCarrera = App\Carrera::find($carrera->id);
        $asignaturas = App\Inscripcione::where('persona_id', $persona->id)
                                        ->where('carrera_id', $informacionCarrera->id)
                                        ->get();
        $key=1;
    @endphp
    <h3>
        <strong class="text-danger">{{ strtoupper($informacionCarrera->nombre) }}</strong> &nbsp;
        <button class="btn btn-light" onclick="reportePdfHistorialAcademico('{{ $persona->id }}', '{{ $informacionCarrera->id }}')">
            <i class="fas fa-file-pdf"></i>
        </button>
    </h3>
    <div class="table-responsive">
        <table class="table table-striped no-wrap text-center" id="tablaProductosEncontrados">
            <thead>
                <tr>
                    <th>#</th>
                    <th>FECHA INSCRIPCION</th>
                    <th>GESTION ACADEMICA</th>
                    <th>SEMESTRE/A&Ntilde;O</th>
                    <th>SIGLA</th>
                    <th>ASIGNATURA</th>
                    <th>REQUISITOS</th>
                    <th>NOTA</th>
                    <th>RECUPERATORIO</th>
                    <th>OBSERVACIONES</th>
                    <th>CONVALIDADO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscripciones as $materia)
                    @if($materia->carrera_id == $informacionCarrera->id && $materia->estado == 'Finalizado')
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $materia->fecha_registro }}</td>
                            <td>{{ $materia->anio_vigente }}</td>
                            <td>
                                @switch($materia->gestion)
                                    @case(1)
                                        PRIMERO
                                        @break
                                    @case(2)
                                        SEGUNDO
                                        @break
                                    @case(3)
                                        TERCERO
                                        @break
                                    @case(4)
                                        CUARTO
                                        @break
                                    @case(5)
                                        QUINTO
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $materia->asignatura->sigla }}</td>
                            <td class="text-left">{{ $materia->asignatura->nombre }}</td>
                            <td>
                                @php
                                    $prerequisito = App\Prerequisito::where('asignatura_id', $materia->asignatura_id)
                                                                    ->first();
                                @endphp
                                @if($prerequisito->prerequisito_id)
                                    {{ $prerequisito->prerequisito->sigla }}
                                @else
                                    NINGUNO
                                @endif
                            </td>
                            <td>
                                @if($materia->convalidado == 'Si')
                                    {{ $materia->nota ? round($materia->nota) : '0' }} ({{ $materia->nota_aprobacion }})
                                @else
                                    {{ $materia->nota ? round($materia->nota) : '0' }}
                                @endif
                            </td>
                            <td>
                                @php
                                    $resultado = App\Nota::where('inscripcion_id', $materia->id)
                                                            ->first();
                                @endphp
                                {{ $resultado ? round($resultado->segundo_turno) : '-' }}
                            </td>
                            @if($materia->aprobo == 'Si')
                                <td class="text-success">APROBADO</td>
                            @else
                                <td class="text-danger">REPROBADO</td>
                            @endif
                            <td>
                                @if($materia->convalidado == 'Si')
                                    {{ $materia->convalidado }}
                                @else
                                    No
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-info" title="Ver detalle" onclick="ajaxMuestraNotaInscripcion('{{ $materia->id }}')"><i class="fas fa-eye"></i></button>
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

    function reportePdfHistorialAcademico(persona_id, carrera_id)
    {
        window.open("{{ url('Inscripcion/reportePdfHistorialAcademico') }}/"+persona_id+"/"+carrera_id);
        //window.location.href = "{{ url('Inscripcion/reportePdfHistorialAcademico') }}/"+persona_id+"/"+carrera_id;
    }
</script>