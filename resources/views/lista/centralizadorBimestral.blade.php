

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
            <th>BIM</th>
        </tr>
    </thead>
    <tbody>
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