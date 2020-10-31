<h1 class="text-center text-dark-info"><strong>Materias Actuales</strong></h1>
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
                    <th>FECHA INSCRIPCION</th>
                    <th>SIGLA</th>
                    <th>ASIGNATURA</th>
                    <th>1ER BIMESTRE</th>
                    <th>2DO BIMESTRE</th>
                    <th>3ER BIMESTRE</th>
                    <th>4TO BIMESTRE</th>
                    <th>TOTAL</th>
                    <th>RECUPERATORIO</th>
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
                                    <td>{{ $nota->total ? $nota->total : 0 }}</td>
                                @endif
                                @if($nota->trimestre == 2)
                                    <td>{{ $nota->total ? $nota->total : 0 }}</td>
                                @endif
                                @if($nota->trimestre == 3)
                                    <td>{{ $nota->total ? $nota->total : 0 }}</td>
                                @endif
                                @if($nota->trimestre == 4)
                                    <td>{{ $nota->total ? $nota->total : 0 }}</td>
                                @endif
                            @endforeach
                            <td>{{ $materia->nota ? $materia->nota : '0' }}</td>
                            <td>
                                @php
                                    $resultado = App\Nota::where('inscripcion_id', $materia->id)
                                                            ->first();
                                @endphp
                                {{ $resultado->segundo_turno ? $resultado->segundo_turno : '-' }}
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
@endforeach