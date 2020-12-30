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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materias as $asignatura)
                        <tr>
                            <td class="text-center">{{ $asignatura->asignatura->id }}</td>
                            <td class="text-center">{{ $asignatura->asignatura->anio_vigente }}</td>
                            <td>{{ $asignatura->carrera->nombre }}</td>
                            <td class="text-center">{{ $asignatura->asignatura->sigla }}</td>
                            <td>{{ $asignatura->asignatura->nombre }}</td>
                            <td class="text-center">{{ $asignatura->anio_vigente }}</td>
                            <td class="text-center">
                                <button class="btn btn-success" title="Exportar lista" onclick="reporteExcelAlumnos('{{ $asignatura->asignatura_id }}', '{{ $asignatura->turno_id }}', '{{ $asignatura->paralelo }}', '{{ $asignatura->anio_vigente }}')">
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
function reporteExcelAlumnos(asignatura_id, turno, paralelo, anio_vigente)
{
    var asignatura_id   = asignatura_id
    var turno           = turno
    var paralelo        = paralelo
    var anio_vigente    = anio_vigente
    window.location.href = "{{ url('User/formatoExcelAsignatura') }}/"+asignatura_id+'/'+turno+'/'+paralelo+'/'+anio_vigente;
}
</script>