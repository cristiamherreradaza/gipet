<div class="modal-content">
    <div class="modal-header bg-info">
        <h4 class="modal-title text-white" id="myModalLabel">
            <strong>Carrera: {{ $registro->carrera->nombre }}</strong>
        </h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        <h6>
            <strong class="text-danger">Estudiante: </strong>
            {{ $registro->persona->nombres }} {{ $registro->persona->apellido_paterno }} {{ $registro->persona->apellido_materno }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <strong class="text-danger">Cedula de Identidad: </strong>
            {{ $registro->persona->cedula }}
        </h6>
        
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead class="align-middle text-danger">
                    <tr>
                        <th class="text-nowrap">Fecha</th>
                        <th class="text-nowrap">Sigla</th>
                        <th class="text-nowrap">Asignatura</th>
                        <th class="text-nowrap">Turno</th>
                        <th class="text-nowrap">Paralelo</th>
                        <th class="text-nowrap">A&ntilde;o Vigente</th>
                        <th class="text-nowrap"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscripciones as $inscripcion)
                        <tr>
                            <td>{{ $inscripcion->fecha_registro }}</td>
                            <td>{{ $inscripcion->asignatura->sigla }}</td>
                            <td>{{ $inscripcion->asignatura->nombre }}</td>
                            <td>{{ $inscripcion->turno->descripcion }}</td>
                            <td>{{ $inscripcion->paralelo }}</td>
                            <td>{{ $inscripcion->anio_vigente }}</td>
                            <td>
                                <button type="button" class="btn btn-danger" title="Eliminar Inscripcion"  onclick="eliminar('{{ $inscripcion->id }}', '{{ $inscripcion->asignatura->nombre }}')"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function eliminar(id, nombre)
    {
        Swal.fire({
            title: 'Quieres borrar ' + nombre + '?',
            text: "Luego no podras recuperarlo!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Excelente!',
                    'La asignatura fue eliminada',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Inscripcion/eliminaAsignatura') }}/"+id;
                });
            }
        })
    }
</script>