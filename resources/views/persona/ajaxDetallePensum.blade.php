<h1 class="text-center text-dark-info"><strong>Pensum</strong></h1>
@foreach($carreras as $carrera)
    @php
        $informacionCarrera = App\Carrera::find($carrera->carrera_id);
        $asignaturas = App\Asignatura::where('carrera_id', $informacionCarrera->id)
                                        ->get();
        $key=1;
    @endphp
    <h3><strong class="text-danger">{{ strtoupper($informacionCarrera->nombre) }}</strong></h3>
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
                    <th># LIBRO</th>
                    <th># FOLIO</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaturas as $asignatura)
                    @if($asignatura->carrera_id == $informacionCarrera->id)
                        @php
                            $detalle = App\Inscripcione::where('carrera_id', $informacionCarrera->id)
                                                        ->where('asignatura_id', $asignatura->id)
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
                                @if($detalle)
                                    @php
                                        $resultado = App\Nota::where('inscripcion_id', $detalle->id)
                                                            ->first();
                                    @endphp
                                    {{ $resultado->segundo_turno ? round($resultado->segundo_turno) : '-' }}
                                @endif
                            </td>
                            <td>
                                @if($detalle)
                                    @if($detalle->aprobo == 'Si')
                                        APROBADO
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($detalle)
                                    -
                                @endif
                            </td>
                            <td>
                                @if($detalle)
                                    -
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