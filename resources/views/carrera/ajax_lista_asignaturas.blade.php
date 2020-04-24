<div class="card card-outline-info">                                
    <div class="card-header">
        <h4 class="mb-0 text-white">ASIGNATURAS - ({{ $nombre_carrera }}) &nbsp;&nbsp;<button type="button" class="btn waves-effect waves-light btn-sm btn-warning" onclick="nuevo_modal('{{ $asignaturas[0]->carrera_id }}', '{{ $asignaturas[0]->anio_vigente }}')"><i class="fas fa-plus"></i> &nbsp; NUEVA MATERIA</button></h4>
    </div>
    <div class="table-responsive m-t-40">
        @if ($asignaturas)
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
                                <button type="button" class="btn btn-warning" onclick="muestra_modal({{ $a->id }})"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" onclick="elimina_asignatura('{{ $a->id }}', '{{ $a->nombre_asignatura }}')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        <p></p>
            <h2>La carrera no tiene asignaturas</h2>
        @endif
        
    </div>
</div>

<script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>