

<table id="tabla-alumnos-bimestral" class="table table-striped table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>No.</th>
            <th>AP PATERNO</th>
            <th>AP MATERNO</th>
            <th>NOMBRES</th>
            <th>ASISTENCIA</th>
            <th>TRABAJOS PRACTICOS</th>
            <th>EXAMEN PARCIAL</th>
            <th>EXAMEN FINAL</th>
            <th>PUNTOS GANADOS</th>
            <th>FINAL</th>
            <th>ESTADO</th>
            <th>CONVALIDADO</th>
        </tr>
    </thead>
    <tbody>
    {{--  @dd($alumnos)  --}}
    @foreach ($alumnos as $key => $a)
    <tr>
        <td>{{ ++$key }}</td>
        <td style="text-align: left;">{{ $a->apellido_paterno }}</td>
        <td style="text-align: left;">{{ $a->apellido_materno }}</td>
        <td style="text-align: left; width: 120px;">{{ $a->nombres }}</td>
        <td>{{ intval($a->nota_asistencia) }}</td>
        <td>{{ intval($a->nota_practicas) }}</td>
        <td>{{ intval($a->nota_primer_parcial) }}</td>
        <td>{{ intval($a->nota_examen_final) }}</td>
        <td>{{ intval($a->nota_puntos_ganados) }}</td>
        <td>{{ intval($a->nota_total) }}</td>
        @php
            $carrerasPersona = App\CarrerasPersona::where('persona_id', $a->persona_id)
                                                ->where('anio_vigente',$gestion)
                                                ->first();
        @endphp
        <td>{{ $carrerasPersona->estado }}</td>
        @php
            $materiasInscripcion = App\Inscripcione::where('persona_id', $a->persona_id)
                                                ->where('anio_vigente',$gestion)
                                                ->where('asignatura_id',$a->asignatura_id)
                                                ->first();
        @endphp
        <td>
            @if ($materiasInscripcion->convalidado == null)
                <h4>
                    No
                    {{--  {{ round($materiasInscripcion->nota, 0) }}
                    @if ($materiasInscripcion->segundo_turno != null)
                        <span class="text-muted">({{ round($materiasInscripcion->segundo_turno, 0) }})</span>
                    @endif  --}}
                </h4>
            @else
                <h4 class="text-primary">
                    Si
                    {{--  {{ round($materiasInscripcion->nota, 0) }}*  --}}
                </h4>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>



<script>
    $(function () {
        $('#tabla-alumnos-bimestral').DataTable({
            paging: true,
            dom: 'Bfrtip',
            buttons: [
            {
                extend: 'excel',
                text: 'EXCEL',
                title: 'NOTAS BIMESTRALES',
                filename: 'Notas'
            },
            ],
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });

    });
</script>
