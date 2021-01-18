<div class="table-responsive m-t-40">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Carrera</th>
                <th>Materia</th>
                <th>Gestion</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaturasDocente as $asignatura)
                <tr>
                    <td>{{ $asignatura->carrera->nombre }}</td>
                    <td>{{ $asignatura->asignatura->nombre }}</td>
                    <td>{{ $asignatura->anio_vigente }}</td>
                    <td><a href="{{ url('nota/detalle/'.$asignatura->id) }}" class="btn btn-info btn-rounded btn-sm"><i class="mdi mdi-note-text"></i> Notas</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Funcion que establece la configuracion para el datatable
    $(function () {
        // $("#botonGuardaNuevoUsuario").prop("disabled", false);
        // $("#botonGuardaEdicionUsuario").prop("disabled", false);
        $('#myTable').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });
</script>