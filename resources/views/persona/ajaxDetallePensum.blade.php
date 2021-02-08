<h1 class="text-center text-dark-info"><strong>Pensum</strong></h1>
<!-- Por cada carrera en la que este inscrito el estudiante -->
@foreach($carreras as $carrera)
    @php
        // En $informacionCarrera guardamos la informacion de la carrera actual
        $informacionCarrera = App\Carrera::find($carrera->id);
        // Buscamos la resolucion ministerial para el estudiante
        $anioIngreso    = App\Inscripcione::where('carrera_id', $informacionCarrera->id)
                                    ->where('persona_id', $persona->id)
                                    ->min('anio_vigente');
        $resolucionMinisterial  = App\Inscripcione::where('carrera_id', $informacionCarrera->id)
                                                    ->where('persona_id', $persona->id)
                                                    ->where('anio_vigente', $anioIngreso)
                                                    ->first();
        // En $asignaturas almacenaremos todas las asignaturas correspondientes a la resolucion ministerial en la que esta registrado el estudiante
        $asignaturas    = App\Asignatura::where('carrera_id', $informacionCarrera->id)
                                        ->where('anio_vigente', $anioIngreso)
                                        ->get();
        $key=1;
    @endphp
    <h3><strong class="text-danger">{{ strtoupper($informacionCarrera->nombre) }}</strong> &nbsp;&nbsp; <span class="badge badge-danger">RM: {{ $resolucionMinisterial->resolucion->resolucion }}</span></h3>
    <div class="table-responsive">
        <table class="table table-striped no-wrap text-center" id="tablaProductosEncontrados">
            <thead>
                <tr>
                    <th>#</th>
                    <th>GESTION ACADEMICA</th>
                    <th>SEMESTRE/A&Ntilde;O</th>
                    <th>SIGLA</th>
                    <th>ASIGNATURA</th>
                    <th>REQUISITOS</th>
                    <th>NOTA</th>
                    <th>RECUPERATORIO</th>
                    <th>OBSERVACIONES</th>
                    <!-- <th># LIBRO</th>
                    <th># FOLIO</th> -->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaturas as $asignatura)
                    @php
                        // Buscaremos las asignaturas con sigla, nombre y resolucion ministerial igual a la asignatura que se tiene
                        $posiblesAsignaturas    = App\Asignatura::where('sigla', $asignatura->sigla)
                                                                ->where('nombre', $asignatura->nombre)
                                                                ->where('resolucion_id', $resolucionMinisterial->resolucion_id)
                                                                ->get();
                        // Crearemos un array donde guardaremos los id de las asignaturas encontradas
                        $arrayAsignaturas   = array();
                        // Almacenaremos los id's de las asignaturas en el array
                        foreach($posiblesAsignaturas as $materia)
                        {
                            array_push($arrayAsignaturas, $materia->id);
                        }
                        // En $detalle buscaremos una coincidencia que contenga al menos un id de el array y que este aprobado
                        $detalle    = App\Inscripcione::whereIn('asignatura_id', $arrayAsignaturas)
                                                    ->where('persona_id', $persona->id)
                                                    ->where('aprobo', 'Si')
                                                    ->first();
                    @endphp
                    <tr>
                        <td>{{ $key }}</td>
                        <td>
                            @if($detalle)
                                {{ $detalle->anio_vigente }}                                    
                            @endif
                        </td>
                        <td>
                            @switch($asignatura->gestion)
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
                        <td>{{ $asignatura->sigla }}</td>
                        <td class="text-left">{{ $asignatura->nombre }}</td>
                        <td>
                            @php
                                $prerequisito = App\Prerequisito::where('asignatura_id', $asignatura->id)
                                                                ->first();
                            @endphp
                            @if($prerequisito->prerequisito_id)
                                {{ $prerequisito->prerequisito->sigla }}
                            @else
                                NINGUNO
                            @endif
                        </td>
                        <td>
                            @if($detalle)
                                {{ $detalle->nota ? round($detalle->nota) : 0 }}
                            @endif
                        </td>
                        <td>
                            {{ $detalle ? round($detalle->segundo_turno) : '' }}
                        </td>
                        <td>
                            @if($detalle)
                                @if($detalle->aprobo == 'Si')
                                    APROBADO
                                @endif
                            @endif
                        </td>
                        <!-- <td>
                            @if($detalle)
                                -
                            @endif
                        </td>
                        <td>
                            @if($detalle)
                                -
                            @endif
                        </td> -->
                        <td>
                            @if($detalle)
                                <button type="button" class="btn btn-info" title="Ver detalle" onclick="ajaxMuestraNotaInscripcion('{{ $detalle->id }}')"><i class="fas fa-eye"></i></button>
                            @endif
                        </td>
                    </tr>
                    @php
                        $key++
                    @endphp
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
</script>