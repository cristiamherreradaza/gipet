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
                <th class="text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscripciones as $key => $inscripcion)
                @php
                    $registro = App\Inscripcione::where('persona_id', $persona->id)
                                                ->where('carrera_id', $inscripcion->carrera_id)
                                                ->where('turno_id', $inscripcion->turno_id)
                                                ->where('paralelo', $inscripcion->paralelo)
                                                ->where('fecha_registro', $inscripcion->fecha_inscripcion)
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
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>