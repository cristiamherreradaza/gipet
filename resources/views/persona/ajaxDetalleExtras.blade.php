<h1 class="text-center text-dark-info"><strong>Extras</strong></h1>
@foreach($carreras as $carrera)
    @php
        $asignaturas = App\Asignatura::where('carrera_id', $carrera->id)
                                        ->get();
        $key=1;
    @endphp
    <h3><strong class="text-danger">{{ strtoupper($carrera->nombre) }}</strong></h3>
    <div class="table-responsive">
        <table class="table table-striped no-wrap text-center" id="tablaProductosEncontrados">
            <thead>
                <tr>
                    <th>#</th>
                    <th>SIGLA</th>
                    <th>ASIGNATURA</th>
                    <th>TOMO CURSO</th>
                    <th>FECHA INSCRIPCION</th>
                    <th>PUNTAJE</th>
                    <th>OBSERVACIONES</th>
                    <th class="text-nowrap"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($asignaturas as $asignatura)
                    @php
                        $registro = App\Inscripcione::where('persona_id', $persona->id)
                                                    ->where('carrera_id', $carrera->id)
                                                    ->where('asignatura_id', $asignatura->id)
                                                    ->first();
                    @endphp
                    <tr>
                        <td>{{ ($key) }}</td>
                        <td>{{ $asignatura->sigla ? $asignatura->sigla : '' }}</td>
                        <td>{{ $asignatura->nombre }}</td>
                        <td>{{ $registro ? 'Si' : 'No' }}</td>
                        <td>{{ $registro ? $registro->fecha_registro : '' }}</td>
                        <td>{{ $registro ? round($registro->nota) : '' }}</td>
                            @if($registro)
                                @if($registro->aprobo == 'Si')
                                    <td class="text-success">APROBADO</td>
                                @else
                                    @if($registro->estado == 'Cursando')
                                        <td class="text-info">CURSANDO</td>
                                    @else
                                        <td class="text-danger">REPROBADO</td>
                                    @endif
                                @endif
                            @else
                            <td></td>
                            @endif
                        <td>
                            @if(!$registro)
                                <button type="button" class="btn btn-success" title="Inscribir"  onclick="inscribirCursoCorto('{{ $persona->id }}', '{{ $asignatura->id }}')"><i class="fas fa-certificate"></i></button>
                                <button type="button" class="btn btn-info" title="Ver detalle" disabled><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar Inscripcion" disabled><i class="fas fa-trash-alt"></i></button>
                            @else
                                <button type="button" class="btn btn-success" title="Inscribir" disabled><i class="fas fa-certificate"></i></button>
                                <button type="button" class="btn btn-info" title="Ver detalle"  onclick="ajaxVerCursoCorto('{{ $registro->id }}')"><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar Inscripcion"  onclick="eliminarCursoCorto('{{ $registro->id }}', '{{ $asignatura->nombre }}')"><i class="fas fa-trash-alt"></i></button>
                            @endif
                        </td>
                    </tr>
                    @php
                        $key++
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
    <br>
@endforeach

<!-- inicio modal editar perfil -->
<div id="detalle_modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="contenido_modal">
        
    </div>
</div>
<!-- fin modal editar perfil -->

<script>
    // Funcion que se ejecuta al hacer clic en inscribir curso corto
    function inscribirCursoCorto(persona_id, asignatura_id){
        window.location.href = "{{ url('Inscripcion/inscribirCursoCorto') }}/"+persona_id+"/"+asignatura_id;
    }

    // Funcion que muestra los datos referentes a los una inscripcion del historial academico
    function ajaxVerCursoCorto(inscripcion_id)
    {
        $.ajax({
            url: "{{ url('Inscripcion/ajaxVerCursoCorto') }}",
            data: {
                inscripcion_id: inscripcion_id
                },
            type: 'get',
            success: function(data) {
                $("#contenido_modal").html(data);
                $("#detalle_modal").modal('show');
            }
        });
    }

    // Funcion que se ejecuta al hacer clic en ver curso corto
    function ver_curso_corto(registro_id){
        window.location.href = "{{ url('Inscripcion/ver_curso_corto') }}/"+registro_id;
    }

    // Funcion que se ejecuta al hacer clic en eliminar curso corto
    function eliminarCursoCorto(registro_id, nombre){
        Swal.fire({
            title: 'Quieres eliminar el curso '+nombre+' ?',
            text: "",
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
                    'El curso fue eliminado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Inscripcion/eliminarCursoCorto') }}/"+registro_id;
                });
            }
        })
    }
</script>