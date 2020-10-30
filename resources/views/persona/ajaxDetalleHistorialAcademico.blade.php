@foreach($carreras as $carrera)
    @php
        $informacionCarrera = App\Carrera::find($carrera->carrera_id);
        $asignaturas = App\Inscripcione::where('persona_id', $persona->id)
                                        ->where('carrera_id', $informacionCarrera->id)
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
                @foreach($inscripciones as $materia)
                    @if($materia->carrera_id == $informacionCarrera->id)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $materia->anio_vigente }}</td>
                            <td>
                                @switch($materia->gestion)
                                    @case(1)
                                        Primero
                                        @break
                                    @case(2)
                                        Segundo
                                        @break
                                    @case(3)
                                        Tercero
                                        @break
                                    @case(4)
                                        Cuarto
                                        @break
                                    @case(5)
                                        Quinto
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $materia->asignatura->sigla }}</td>
                            <td>{{ $materia->asignatura->nombre }}</td>
                            <td>
                                @php
                                    $prerequisito = App\Prerequisito::where('asignatura_id', $materia->asignatura_id)
                                                                    ->first();
                                @endphp
                                @if($prerequisito->prerequisito_id)
                                    {{ $prerequisito->prerequisito->sigla }}
                                @endif
                            </td>
                            <td>{{ $materia->nota ? $materia->nota : '0' }}</td>
                            <td>
                                @php
                                    $resultado = App\Nota::where('inscripcion_id', $materia->id)
                                                            ->first();
                                @endphp
                                {{ $resultado->segundo_turno }}
                            </td>
                            <td>{{ $materia->aprobo == 'Si' ? 'APROBADO' : 'REPROBADO' }}</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                        @php
                            $key++
                        @endphp
                    @endif
                @endforeach
            </tbody>
        </table>
</div>
@endforeach