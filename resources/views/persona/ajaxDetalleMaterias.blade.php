<h1 class="text-center text-dark-info"><strong>Materias Actuales</strong></h1>
@foreach($carreras as $carrera)
    @php
        $informacionCarrera = App\Carrera::find($carrera->id);
        $asignaturas = App\Inscripcione::where('persona_id', $persona->id)
                                        ->where('carrera_id', $informacionCarrera->id)
                                        ->get();
        $key=1;
    @endphp
    <h3><strong class="text-danger">{{ strtoupper($informacionCarrera->nombre) }}</strong></h3>
    <div class="table-responsive">
        <table class="table table-striped no-wrap text-center" id="tablaProductosEncontrados">
            <thead>
                <tr>
                    <th>#</th>
                    <th>FECHA INSCRIPCION</th>
                    <th>SIGLA</th>
                    <th>ASIGNATURA</th>
                    <th>1ER BIMESTRE</th>
                    <th>2DO BIMESTRE</th>
                    <th>3ER BIMESTRE</th>
                    <th>4TO BIMESTRE</th>
                    <th>TOTAL</th>
                    <th>RECUPERATORIO</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscripciones as $materia)
                    @if($materia->carrera_id == $informacionCarrera->id && $materia->estado == 'Cursando')
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ $materia->fecha_registro }}</td>
                            <td>{{ $materia->asignatura->sigla }}</td>
                            <td class="text-left">{{ $materia->asignatura->nombre }}</td>
                            @php
                                $notas = App\Nota::where('inscripcion_id', $materia->id)
                                                ->get();
                            @endphp
                            @foreach($notas as $nota)
                                @if($nota->trimestre == 1)
                                    <td>{{ $nota->nota_total ? round($nota->nota_total) : 0 }}</td>
                                @endif
                                @if($nota->trimestre == 2)
                                    <td>{{ $nota->nota_total ? round($nota->nota_total) : 0 }}</td>
                                @endif
                                @if($nota->trimestre == 3)
                                    <td>{{ $nota->nota_total ? round($nota->nota_total) : 0 }}</td>
                                @endif
                                @if($nota->trimestre == 4)
                                    <td>{{ $nota->nota_total ? round($nota->nota_total) : 0 }}</td>
                                @endif
                            @endforeach
                            <td>
                                @if($materia->nota)
                                    @if($materia->nota >= $materia->nota_aprobacion)
                                        <strong class="text-success">{{ round($materia->nota) }}</strong>
                                    @else
                                        <strong class="text-danger">{{ round($materia->nota) }}</strong>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @php
                                    $resultado = App\Nota::where('inscripcion_id', $materia->id)
                                                            ->first();
                                @endphp
                                {{ $resultado->segundo_turno ? $resultado->segundo_turno : '-' }}
                            </td>
                            <td>
                                <button type="button" class="btn btn-info" title="Ver detalle" onclick="ajaxMuestraNotaInscripcion('{{ $materia->id }}')"><i class="fas fa-eye"></i></button>
                            </td>
                        </tr>
                        @php
                            $key++
                        @endphp
                    @endif
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
    // Funcion que muestra los datos referentes a los una inscripcion del historial academico
    function ajaxMuestraNotaInscripcion(inscripcion_id)
    {
        $.ajax({
            url: "{{ url('Inscripcion/ajaxMuestraNotaInscripcion') }}",
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
</script>