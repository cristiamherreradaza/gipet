<div class="card">
    <div class="card-body">
        <h4 class="card-title">RESULTADO DE BUSQUEDA</h4>
        <div class="row">
            <div class="col-md-12">
                <!-- <button class="btn btn-danger" onclick="reportePdfTotalAlumnos()">
                    <i class="fas fa-file-pdf">&nbsp; PDF</i>
                </button> -->
                
                <!-- <button class="btn btn-success" onclick="reporteExcelAlumnos()">
                    <i class="fas fa-file-excel">&nbsp; EXCEL</i>
                </button> -->
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped no-wrap">
                <thead class="text-center">
                    <tr>
                        <th>Gestion</th>
                        <th>Sigla</th>
                        <th>Asignatura</th>
                        <th>Turno</th>
                        <th>Paralelo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignaturas as $asignatura)
                        <tr>
                            <td>{{ $asignatura->anio_vigente }}</td>
                            <td>{{ $asignatura->asignatura->sigla }}</td>
                            <td>{{ $asignatura->asignatura->nombre }}</td>
                            <td>{{ $asignatura->turno->descripcion }}</td>
                            <td>{{ $asignatura->paralelo }}</td>
                            <td>
                                <button class="btn btn-success" onclick="reporteExcelAlumnos()">
                                    <i class="fas fa-file-excel">&nbsp; EXCEL</i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>