<table class="table">
    <tr>
        <td>No.</td>
        <td colspan="3">APELLIDOS Y NOMBRES</td>
        <td>ASISTENCIA</td>
        <td>TRABAJOS PRACTICOS</td>
        <td>EXAMEN PARCIAL</td>
        <td>EXAMEN FINAL</td>
        <td>PUNTOS GANADOS</td>
        <td>BIM</td>
    </tr>
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
    </tr>
    @endforeach

</table>