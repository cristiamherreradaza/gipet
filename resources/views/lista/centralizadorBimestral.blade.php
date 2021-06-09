<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">

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

<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script>
    $(function () {
        $('#tabla-alumnos-bimestral').DataTable({
            iDisplayLength: 10,
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });

    });
</script>