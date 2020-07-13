<div class="table-responsive m-t-40">
    <table id="myTable" class="table table-bordered table-striped text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Carrera 1</th>
                <th>Asignatura 1</th>
                <th>Carrera 2</th>
                <th>Asignatura 2</th>
                <th>Gestion</th>
                {{-- <th>Opciones</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($asignaturas as $key => $asig)
                <tr>
                    <td>{{ ($key+1) }}</td>
                    @php
                        $carrera_1 = DB::select("SELECT *
                                                FROM carreras
                                                WHERE id = '$asig->carrera_id_1'");
                    @endphp
                    <td>{{ $carrera_1[0]->nombre }}</td>
                    @php
                        $asignatura_1 = DB::select("SELECT *
                                                FROM asignaturas
                                                WHERE id = '$asig->asignatura_id_1'");
                    @endphp
                    <td>{{ $asignatura_1[0]->nombre_asignatura }} ({{ $asignatura_1[0]->codigo_asignatura }})</td>
                    @php
                        $carrera_2 = DB::select("SELECT *
                                                FROM carreras
                                                WHERE id = '$asig->carrera_id_2'");
                    @endphp
                    <td>{{ $carrera_2[0]->nombre }}</td>
                    @php
                        $asignatura_2 = DB::select("SELECT *
                                                FROM asignaturas
                                                WHERE id = '$asig->asignatura_id_2'");
                    @endphp
                    <td>{{ $asignatura_2[0]->nombre_asignatura }} ({{ $asignatura_2[0]->codigo_asignatura }})</td>
                    <td>{{ $asig->anio_vigente }}</td>
                    {{-- <td>
                        <button type="button" class="btn btn-info" title="Editar carrera"  onclick="editar('{{ $asig->id }}', '{{ $asignatura_1[0]->id }}')"><i class="fas fa-edit"></i></button>
                        <button type="button" class="btn btn-danger" title="Eliminar carrera"  onclick="eliminar('{{ $asig->id }}')"><i class="fas fa-trash-alt"></i></button>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(function () {
        $('#myTable').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });

    });
</script>