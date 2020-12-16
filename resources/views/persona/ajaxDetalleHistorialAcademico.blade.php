<h1 class="text-center text-dark-info"><strong>Historial Academico</strong></h1>
@foreach($carreras as $carrera)
    @php
        $informacionCarrera = App\Carrera::find($carrera->id);
        $asignaturas = App\Inscripcione::where('persona_id', $persona->id)
                                        ->where('carrera_id', $informacionCarrera->id)
                                        ->get();
        $key=1;
    @endphp
    <h3>
        <strong class="text-danger">{{ strtoupper($informacionCarrera->nombre) }}</strong> &nbsp;
        <button class="btn btn-light" onclick="reportePdfHistorialAcademico('{{ $persona->id }}', '{{ $informacionCarrera->id }}')">
            <i class="fas fa-file-pdf"></i>
        </button>
    </h3>
    <div class="table-responsive">
        <table class="table table-striped no-wrap text-center" id="tablaProductosEncontrados">
            <thead>
                <tr>
                    <th>#</th>
                    <!-- <th>FECHA INSCRIPCION</th> -->
                    <th>GESTION ACADEMICA</th>
                    <th>SEMESTRE/A&Ntilde;O</th>
                    <th>SIGLA</th>
                    <th>ASIGNATURA</th>
                    <!-- <th>REQUISITOS</th> -->
                    <th>NOTA</th>
                    <th>RECUPERATORIO</th>
                    <th>OBSERVACIONES</th>
                    <!-- <th>CONVALIDADO</th> -->
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscripciones as $materia)
                    @if($materia->carrera_id == $informacionCarrera->id && $materia->estado == 'Finalizado')
                        <tr>
                            <td>{{ $key }}</td>
                            <!-- <td>{{ $materia->fecha_registro }}</td> -->
                            <td>{{ $materia->anio_vigente }}</td>
                            <td>
                                @switch($materia->gestion)
                                    @case(1)
                                        PRIMERO
                                        @break
                                    @case(2)
                                        SEGUNDO
                                        @break
                                    @case(3)
                                        TERCERO
                                        @break
                                    @case(4)
                                        CUARTO
                                        @break
                                    @case(5)
                                        QUINTO
                                        @break
                                @endswitch
                            </td>
                            <td>{{ $materia->asignatura->sigla }}</td>
                            <td class="text-left">{{ $materia->asignatura->nombre }}</td>
                            <!-- <td>
                                @php
                                    $prerequisito = App\Prerequisito::where('asignatura_id', $materia->asignatura_id)
                                                                    ->first();
                                @endphp
                                @if($prerequisito->prerequisito_id)
                                    {{ $prerequisito->prerequisito->sigla }}
                                @else
                                    NINGUNO
                                @endif
                            </td> -->
                            <td>
                                @if($materia->convalidado == 'Si')
                                    {{ $materia->nota ? round($materia->nota) : '0' }} ({{ $materia->nota_aprobacion }})
                                @elseif($materia->nota_reprobacion)
                                    {{ $materia->nota ? round($materia->nota) : '0' }} ({{ $materia->nota_reprobacion }})
                                @else
                                    {{ $materia->nota ? round($materia->nota) : '0' }}
                                @endif
                            </td>
                            <td>
                                {{ round($materia->segundo_turno) }}
                            </td>
                            @if($materia->aprobo == 'Si')
                                <td class="text-success">APROBADO</td>
                            @else
                                <td class="text-danger">REPROBADO</td>
                            @endif
                            <!-- <td>
                                @if($materia->convalidado == 'Si')
                                    {{ $materia->convalidado }}
                                @else
                                    No
                                @endif
                            </td> -->
                            @php
                                $inscribir  = 'No';
                                if($materia->nota_reprobacion)
                                {
                                    $inscripcion_posterior  = App\Inscripcione::where('carrera_id', $materia->carrera_id)
                                                                            ->where('asignatura_id', $materia->asignatura_id)
                                                                            ->where('persona_id', $materia->persona_id)
                                                                            ->where('estado', 'Cursando')
                                                                            ->where('oyente', 'Si')
                                                                            ->first();
                                    $inscripcion_aprobada   = App\Inscripcione::where('carrera_id', $materia->carrera_id)
                                                                            ->where('asignatura_id', $materia->asignatura_id)
                                                                            ->where('persona_id', $materia->persona_id)
                                                                            ->where('aprobo', 'Si')
                                                                            ->where('oyente', 'Si')
                                                                            ->first();
                                    if($inscripcion_posterior || $inscripcion_aprobada)
                                    {
                                        $inscribir  = 'No';
                                    }
                                    else
                                    {
                                        $inscribir  = 'Si';
                                    }
                                }
                            @endphp
                            <td>
                                <button type="button" class="btn btn-info" title="Ver detalle" onclick="ajaxMuestraNotaInscripcion('{{ $materia->id }}')"><i class="fas fa-eye"></i></button>
                                @if($materia->aprobo != 'Si')
                                    <button type="button" class="btn btn-warning" title="Forzar aprobacion" onclick="apruebaInscripcion('{{ $materia->id }}')"><i class="fas fa-clipboard-check"></i></button>
                                @endif
                                @if($inscribir == 'Si')
                                    <button type="button" class="btn btn-dark" title="Inscripcion pendiente" onclick="modalInscribeOyente('{{ $materia->id }}')"><i class="fas fa-copy"></i></button>
                                @endif
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

<!-- inicio modal ver notas -->
<div id="detalle_modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="contenido_modal">
        
    </div>
</div>
<!-- fin modal ver notas -->

<!-- inicio modal inscripcion oyente -->
<div id="inscribe_oyente" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h4 class="modal-title text-white" id="myModalLabel">INSCRIPCION OYENTE</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Inscripcion/inscribeOyente') }}"  method="POST" >
                @csrf
                <div class="modal-body">        
                    <input type="hidden" name="inscripcion_id" id="inscripcion_id" value="">
                    <input type="hidden" name="persona_id" id="persona_id" value="{{ $persona->id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Turno</label>
                                <select name="turno" id="turno" class="form-control" required>
                                    @foreach($turnos as $turno)
                                        <option value="{{ $turno->id }}">{{ $turno->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Paralelo</label>
                                <select name="paralelo" id="paralelo" class="form-control" required>
                                    @foreach($paralelos as $paralelo)
                                        <option value="{{ $paralelo->paralelo }}">{{ $paralelo->paralelo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Gestion</label>
                                <input name="gestion" id="gestion" type="number" value="{{ date('Y') }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Fecha Inscripcion</label>
                                <input name="fecha_inscripcion" id="fecha_inscripcion" type="date" value="{{ date('Y-m-d') }}" class="form-control" required>
                            </div>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-dark">INSCRIBIR</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal inscripcion oyente -->
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


    function modalInscribeOyente(inscripcion_id)
    {
        $("#inscripcion_id").val(inscripcion_id);
        $("#inscribe_oyente").modal('show');
    }

    function apruebaInscripcion(inscripcion_id)
    {
        Swal.fire({
            title: 'Deseas forzar la aprobación de esta asignatura?',
            text: "Las notas actuales se reemplazaran!",
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
                    'Asignatura aprobada',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Inscripcion/apruebaInscripcion') }}/"+inscripcion_id;
                });
            }
        })
    }

    function reportePdfHistorialAcademico(persona_id, carrera_id)
    {
        window.open("{{ url('Inscripcion/reportePdfHistorialAcademico') }}/"+persona_id+"/"+carrera_id);
        //window.location.href = "{{ url('Inscripcion/reportePdfHistorialAcademico') }}/"+persona_id+"/"+carrera_id;
    }
</script>