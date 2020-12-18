<div class="card">
    <div class="card-body">
        <h4 class="card-title">RESULTADO DE BUSQUEDA</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped no-wrap">
                <thead class="text-center">
                    <tr>
                        <th>ID</th>
                        <th>MALLA CURRICULAR</th>
                        <th>CARRERA</th>
                        <th>SIGLA</th>
                        <th>ASIGNATURA</th>
                        <th>GESTION</th>
                        <!-- <th>Turno</th>
                        <th>Paralelo</th> -->
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignaturas as $asignatura)
                        <tr>
                            <td class="text-center">{{ $asignatura->asignatura->id }}</td>
                            <td class="text-center">{{ $asignatura->asignatura->anio_vigente }}</td>
                            <td>{{ $asignatura->carrera->nombre }}</td>
                            <td class="text-center">{{ $asignatura->asignatura->sigla }}</td>
                            <td>{{ $asignatura->asignatura->nombre }}</td>
                            <td class="text-center">{{ $asignatura->anio_vigente }}</td>
                            <!-- <td>{{ $asignatura->turno->descripcion }}</td>
                            <td>{{ $asignatura->paralelo }}</td> -->
                            <td class="text-center">
                                <button class="btn btn-success" title="Exportar lista" onclick="reporteExcelAlumnos('{{ $docente->id }}', '{{ $asignatura->asignatura_id }}', '{{ $asignatura->anio_vigente }}')">
                                    <i class="fas fa-file-excel"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function reporteExcelAlumnos(docente_id, asignatura_id, anio_vigente)
{
    var docente_id      = docente_id
    var asignatura_id   = asignatura_id
    var anio_vigente    = anio_vigente
    window.location.href = "{{ url('User/formatoExcelAsignatura') }}/"+docente_id+'/'+asignatura_id+'/'+anio_vigente;
}
</script>