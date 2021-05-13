<div class="modal-content">
    <form action="{{ url('Inscripcion/actualizaNotaInscripcion') }}" method="post" id="formularioNotas">
        @csrf
        <input type="hidden" name="inscripcion_id" id="inscripcion_id" value="{{ $inscripcion->id }}">
        <div class="modal-header bg-info">
            <h4 class="modal-title text-white" id="myModalLabel">
                <strong>ASIGNATURA: <span style="text-transform: uppercase;">{{ $inscripcion->asignatura->nombre }}</span></strong>
            </h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <h4>
                        <span class="text-info">ESTUDIANTE: </span>
                        {{ $inscripcion->persona->apellido_materno }}
                        {{ $inscripcion->persona->apellido_paterno }}
                        {{ $inscripcion->persona->nombres }}
                    </h4>
                </div>
                
                <div class="col-md-2">
                    <h4>
                        <span class="text-info">CURSO: </span>
                        {{ $inscripcion->gestion }}&deg; A&ntilde;o
                    </h4>
                </div>

                <div class="col-md-3">
                    <h4>
                        <span class="text-info">TURNO: </span>
                        {{ $inscripcion->turno->descripcion }}
                    </h4>
                </div>

                <div class="col-md-3">
                    <h4>
                        <span class="text-info">PARALELO: </span>
                        {{ $inscripcion->paralelo }}
                    </h4>
                </div>
            </div>
            
            
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="align-middle text-danger">
                        @php
                            $predefinida = App\Predefinida::where('activo', 'Si')->first();
                            if(!$predefinida){
                                $predefinida = App\NotasPropuesta::where('asignatura_id', $inscripcion->asignatura_id)
                                                                ->where('turno_id', $inscripcion->turno_id)
                                                                ->where('paralelo', $inscripcion->paralelo)
                                                                ->where('anio_vigente', $inscripcion->anio_vigente)
                                                                ->first();
                            }
                        @endphp
                        <tr>
                            <th class="text-nowrap">Bimestre<h6 class="card-subtitle text-primary">#</h6></th>
                            <th class="text-nowrap">Asistencia<h6 class="card-subtitle text-info">MAX: {{ round($predefinida->nota_asistencia) }}</h6></th>
                            <th class="text-nowrap">Practicas<h6 class="card-subtitle text-info">MAX: {{ round($predefinida->nota_practicas) }}</h6></th>
                            <th class="text-nowrap">Primer Parcial<h6 class="card-subtitle text-info">MAX: {{ round($predefinida->nota_primer_parcial) }}</h6></th>
                            <th class="text-nowrap">Examen Final<h6 class="card-subtitle text-info">MAX: {{ round($predefinida->nota_examen_final) }}</h6></th>
                            <th class="text-nowrap">Extras<h6 class="card-subtitle text-info">MAX: {{ round($predefinida->nota_puntos_ganados) }}</h6></th>
                            <th class="text-nowrap">Total<h6 class="card-subtitle text-info">MAX: {{ round($predefinida->nota_asistencia + $predefinida->nota_practicas + $predefinida->nota_primer_parcial + $predefinida->nota_examen_final) }}</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notas as $nota)
                                    <tr>
                                        <td>{{ $nota->trimestre }}</td>
                                        <td>
                                            @if ($nota->trimestre == 1)
                                                <input type="hidden" name="notaIdP" value="{{ $nota->id }}">
                                            @else
                                                <input type="hidden" name="notaIdS" value="{{ $nota->id }}">
                                            @endif
                                            <input 
                                                min="0" 
                                                onchange="calcula( {{ $nota->id }} )"
                                                type="number"
                                                id="asistencia-{{ $nota->id }}" 
                                                name="asistencia-{{ $nota->id }}"
                                                value="{{ round($nota->nota_asistencia) }}" 
                                                step="any"
                                                style="text-align: center; width: 100px;" 
                                                class="form-control">
                                        </td>
                                        <td><input 
                                                min="0"
                                                onchange="calcula( {{ $nota->id }} )"
                                                type="number"
                                                id="practicas-{{ $nota->id }}" 
                                                name="practicas-{{ $nota->id }}"
                                                value="{{ round($nota->nota_practicas) }}" 
                                                step="any"
                                                style="text-align: center; width: 100px;" 
                                                class="form-control"></td>
                                        <td><input 
                                                min="0"
                                                onchange="calcula( {{ $nota->id }} )"
                                                type="number"
                                                id="parcial-{{ $nota->id }}" 
                                                name="parcial-{{ $nota->id }}"
                                                value="{{ round($nota->nota_primer_parcial) }}" 
                                                step="any"
                                                style="text-align: center; width: 100px;" 
                                                class="form-control"></td>
                                        <td>
                                            <input 
                                                min="0"
                                                onchange="calcula( {{ $nota->id }} )"
                                                type="number"
                                                id="final-{{ $nota->id }}" 
                                                name="final-{{ $nota->id }}"
                                                value="{{ round($nota->nota_examen_final) }}" 
                                                step="any"
                                                style="text-align: center; width: 100px;" 
                                                class="form-control"></td>
                                        <td>
                                            <input 
                                                min="0" 
                                                onchange="calcula( {{ $nota->id }} )"
                                                data-puntos="{{ $nota->nota_puntos_ganados }}" 
                                                type="number" 
                                                id="puntos-{{ $nota->id }}"
                                                name="puntos-{{ $nota->id }}" 
                                                value="{{ round($nota->nota_puntos_ganados) }}" 
                                                step="any"
                                                style="text-align: center; width: 100px;" 
                                                class="form-control"></td>
                                        <td>
                                            <input 
                                                type="number" 
                                                step="any"
                                                max="100"
                                                value="{{ round($nota->nota_total) }}" 
                                                id="totalsuma-{{ $nota->id }}" 
                                                name="total-{{ $nota->id }}" 
                                                style="text-align: center; width: 100px;" 
                                                class="form-control" />
                                        </td>
                                    </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn waves-effect waves-light btn-block btn-success" onclick="enviaFormulario()">ACTUALIZAR</button>
        </div>
    </form>
</div>

<script>
    function checkCampos(numero) {
        if(numero.length <= 0){
            return 0;
        }else{
            return numero;
        }
    }

    function calcula(id)
    {
        //tenemos que enviar el id de la nota que se esta modificando y los valores insertados, ó que se encuentran en ese momento en los campos
        var identificador = id;
        var asistencia = $("#asistencia-"+id).val();
        var practicas = $("#practicas-"+id).val();
        var puntos = $("#puntos-"+id).val();
        var parcial = $("#parcial-"+id).val();
        var final = $("#final-"+id).val();

        //validemos cuando sea uno de los valores null, por defecto tiene que sumar 0
        asistencia = checkCampos(asistencia);
        practicas = checkCampos(practicas);
        parcial = checkCampos(parcial);
        final = checkCampos(final);
        puntos = checkCampos(puntos);

        var total = parseFloat(asistencia)+parseFloat(practicas)+parseFloat(parcial)+parseFloat(final)+parseFloat(puntos);

        $('#totalsuma-'+id).val(total);
    }

    function enviaFormulario()
    {
        if ($("#formularioNotas")[0].checkValidity()) {

            $("#formularioNotas").submit();

            Swal.fire(
                'Excelente!',
                'Notas actualizadas',
                'success'
            );

        }else{
            $("#formularioNotas")[0].reportValidity();
        }

    }
</script>