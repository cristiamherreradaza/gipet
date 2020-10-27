@foreach($carreras as $carrera)
    @php
        $informacionCarrera = App\Carrera::find($carrera->carrera_id);
        $asignaturas = App\Inscripcione::where('persona_id', $persona->id)
                                        ->where('carrera_id', $informacionCarrera->id)
                                        ->get();
    @endphp
    <h3>{{ $informacionCarrera->nombre }}</h3>
    <div class="table-responsive">
        <table class="table table-striped no-wrap" id="tablaProductosEncontrados">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Asignatura</th>
                    <th>Nota</th>
                    <th>Docente</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaturas as $key => $asignatura)
                    @php
                        $registro = App\NotasPropuesta::where('asignatura_id', $asignatura->asignatura_id)
                                                    ->where('turno_id', $asignatura->turno_id)
                                                    ->where('paralelo', $asignatura->paralelo)
                                                    ->where('anio_vigente', $asignatura->anio_vigente)
                                                    ->first();
                    @endphp
                    <tr>
                        <td>{{ ($key+1) }}</td>
                        <td>{{ $asignatura->asignatura->nombre }} {{ $asignatura->asignatura->sigla }}</td>
                        <td>
                            @if($asignatura->nota)
                                {{ $asignatura->nota }}
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            @if($registro)
                                {{ $registro->docente->nombres }} {{ $registro->docente->apellido_paterno }} {{ $registro->docente->apellido_materno }}
                            @else
                                Sin Docente
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
@endforeach