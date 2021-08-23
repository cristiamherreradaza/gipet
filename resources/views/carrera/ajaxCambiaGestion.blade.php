<table class="table table-striped no-wrap" id="ajax-materias">
    <thead>
        <tr>
            <th>CARRERA</th>
            <th>MATERIA</th>
            <th class="text-center">PARALELO</th>
            <th>TURNO</th>
            <th>A&Nacute;O</th>
            <th class="text-center">1 BIM</th>
            <th class="text-center">2 BIM</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($carrerasNotasPropuestas as $c)
        @php

            $primerBimestre = App\Nota::where('carrera_id', $c->carrera_id)
                ->where('asignatura_id', $c->asignatura_id)
                ->where('paralelo', $c->paralelo)
                ->where('turno_id', $c->turno_id)
                ->where('gestion', $c->gestion)
                ->where('anio_vigente', $c->anio_vigente)
                ->where('trimestre', 1)
                ->where('finalizado', 'Si')
                ->first();

            $segundoBimestre = App\Nota::where('carrera_id', $c->carrera_id)
                ->where('asignatura_id', $c->asignatura_id)
                ->where('paralelo', $c->paralelo)
                ->where('turno_id', $c->turno_id)
                ->where('gestion', $c->gestion)
                ->where('anio_vigente', $c->anio_vigente)
                ->where('trimestre', 2)
                ->where('finalizado', 'Si')
                ->first();

        @endphp
        <tr>
            <td>{{ $c->carrera['nombre'] }}</td>
            <td>{{ $c->asignatura['nombre'] }}</td>
            <td class="text-center">{{ $c->paralelo }}</td>
            <td>{{ $c->turno->descripcion }}</td>
            <td>{{ $c->gestion }}&deg; a&ntilde;o</td>
            <td class="text-center">
                @if ($primerBimestre)
                <a href="{{ url("Carrera/actualizaCierraNotas/$c->carrera_id/$c->paralelo/$c->turno_id/$c->gestion/$c->anio_vigente/abierto/1/$c->asignatura_id") }}"
                    type="button" class="btn waves-effect waves-light btn-danger">CERRADO</a>
                @else
                <a href="{{ url("Carrera/actualizaCierraNotas/$c->carrera_id/$c->paralelo/$c->turno_id/$c->gestion/$c->anio_vigente/cerrado/1/$c->asignatura_id") }}"
                    type="button" class="btn waves-effect waves-light btn-success">ABIERTO</a>

                @endif
            </td>
            <td class="text-center">
                @if ($segundoBimestre)
                <a href="{{ url("Carrera/actualizaCierraNotas/$c->carrera_id/$c->paralelo/$c->turno_id/$c->gestion/$c->anio_vigente/abierto/2/$c->asignatura_id") }}"
                    type="button" class="btn waves-effect waves-light btn-danger">CERRADO</a>
                @else
                <a href="{{ url("Carrera/actualizaCierraNotas/$c->carrera_id/$c->paralelo/$c->turno_id/$c->gestion/$c->anio_vigente/cerrado/2/$c->asignatura_id") }}"
                    type="button" class="btn waves-effect waves-light btn-success">ABIERTO</a>
                @endif

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<script>
    $('#ajax-materias').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
</script>