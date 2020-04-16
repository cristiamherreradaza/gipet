<div class="card card-outline-info">                                
    <div class="card-header">
        <h4 class="mb-0 text-white">ASIGNATURAS - ({{ $nombre_carrera }})</h4>
    </div>
    <div class="table-responsive m-t-40">
        <table id="tabla-ajax_asignaturas" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sigla</th>
                    <th>Nombre</th>
                    <th>Curso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaturas as $a)
                    <tr>
                        <td>{{ $a->codigo_asignatura }}</td>
                        <td>{{ $a->nombre_asignatura }}</td>
                        <td>{{ $a->semestre }}</td>
                        <td>
                            <a href="{{ url('Asignatura/listado_malla/'.$a->id) }}">
                                <button type="button" class="btn btn-info"><i class="fas fa-eye"></i></button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>

<script>
    $(function () {
        $('#tabla-ajax_asignaturas').DataTable();
    });
</script>