<div class="modal-content">
    <form action="{{ url('Inscripcion/actualizaNotaInscripcion') }}" method="post">
        @csrf
        <input type="hidden" name="inscripcion_id" id="inscripcion_id" value="{{ $inscripcion->id }}">
        <div class="modal-header bg-warning">
            <h4 class="modal-title text-white" id="myModalLabel">
                <strong>Asignatura: {{ $inscripcion->asignatura->nombre }}</strong>
            </h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <h6>
                <strong class="text-danger">Estudiante: </strong>
                {{ $inscripcion->persona->nombres }} {{ $inscripcion->persona->apellido_paterno }} {{ $inscripcion->persona->apellido_materno }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <strong class="text-danger">Cedula de Identidad: </strong>
                {{ $inscripcion->persona->cedula }}
            </h6>
            
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
                            <th class="text-nowrap">Asistencia<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_asistencia) }}</h6></th>
                            <th class="text-nowrap">Practicas<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_practicas) }}</h6></th>
                            <th class="text-nowrap">Primer Parcial<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_primer_parcial) }}</h6></th>
                            <th class="text-nowrap">Examen Final<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_examen_final) }}</h6></th>
                            <th class="text-nowrap">Total<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_asistencia + $predefinida->nota_practicas + $predefinida->nota_primer_parcial + $predefinida->nota_examen_final) }}</h6></th>
                            <th class="text-nowrap">Extras<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_puntos_ganados) }}</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notas as $nota)
                            @if($nota->asignatura->ciclo == 'Semestral')
                                @if($nota->trimestre == 1 || $nota->trimestre == 2)
                                    <tr>
                                        <td>{{ $nota->trimestre }}</td>
                                        <td><input size="10" min="0" onchange="calcula( {{ $nota->id }} )" data-asistencia="{{ $nota->nota_asistencia }}" type="number" id="asistencia-{{ $nota->id }}" name="asistencia-{{ $nota->id }}" value="{{ round($nota->nota_asistencia) }}" step="any" style="text-align: center; width: 100px;" class="form-control"></td>
                                        <td><input size="10" min="0" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-practicas="{{ $nota->nota_practicas }}" type="number" id="practicas-{{ $nota->id }}" name="practicas-{{ $nota->id }}" value="{{ round($nota->nota_practicas) }}" step="any" style="text-align: center; width: 100px;" class="form-control"></td>
                                        <td><input size="10" min="0" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-parcial="{{ $nota->nota_primer_parcial }}" type="number" id="parcial-{{ $nota->id }}" name="parcial-{{ $nota->id }}" value="{{ round($nota->nota_primer_parcial) }}" step="any" style="text-align: center; width: 100px;" class="form-control"></td>
                                        <td><input size="10" min="0" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-final="{{ $nota->nota_examen_final }}" type="number" id="final-{{ $nota->id }}" name="final-{{ $nota->id }}" value="{{ round($nota->nota_examen_final) }}" step="any" style="text-align: center; width: 100px;" class="form-control"></td>
                                        <td id="totalsuma{{ $nota->id }}"><input value="{{ round($nota->nota_total) }}" style="text-align: center; width: 100px;" class="form-control" readonly></td>
                                        <td><input size="10" min="0" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-puntos="{{ $nota->nota_puntos_ganados }}" type="number" id="puntos-{{ $nota->id }}" name="puntos-{{ $nota->id }}" value="{{ round($nota->nota_puntos_ganados) }}" step="any" style="text-align: center; width: 100px;" class="form-control"></td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td>{{ $nota->trimestre }}</td>
                                    <td><input size="10" min="0" max="{{ $predefinida->nota_asistencia }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-asistencia="{{ $nota->nota_asistencia }}" type="number" id="asistencia-{{ $nota->id }}" name="asistencia-{{ $nota->id }}" value="{{ round($nota->nota_asistencia) }}" step="any" style="text-align: center; width: 100px;"></td>
                                    <td><input size="10" min="0" max="{{ $predefinida->nota_practicas }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-practicas="{{ $nota->nota_practicas }}" type="number" id="practicas-{{ $nota->id }}" name="practicas-{{ $nota->id }}" value="{{ round($nota->nota_practicas) }}" step="any" style="text-align: center; width: 100px;"></td>
                                    <td><input size="10" min="0" max="{{ $predefinida->nota_primer_parcial }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-parcial="{{ $nota->nota_primer_parcial }}" type="number" id="parcial-{{ $nota->id }}" name="parcial-{{ $nota->id }}" value="{{ round($nota->nota_primer_parcial) }}" step="any" style="text-align: center; width: 100px;"></td>
                                    <td><input size="10" min="0" max="{{ $predefinida->nota_examen_final }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-final="{{ $nota->nota_examen_final }}" type="number" id="final-{{ $nota->id }}" name="final-{{ $nota->id }}" value="{{ round($nota->nota_examen_final) }}" step="any" style="text-align: center; width: 100px;"></td>
                                    <td id="totalsuma{{ $nota->id }}"><input value="{{ round($nota->nota_total) }}" style="text-align: center; width: 100px;" readonly></td>
                                    <td><input size="10" min="0" max="{{ $predefinida->nota_puntos_ganados }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-puntos="{{ $nota->nota_puntos_ganados }}" type="number" id="puntos-{{ $nota->id }}" name="puntos-{{ $nota->id }}" value="{{ round($nota->nota_puntos_ganados) }}" step="any" style="text-align: center; width: 100px;"></td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn waves-effect waves-light btn-block btn-info">ACTUALIZAR</button>
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

        var total = parseFloat(asistencia)+parseFloat(practicas)+parseFloat(parcial)+parseFloat(final);
        var necesario = 100 - total;
        if(necesario >= 10){
            total = total + parseFloat(puntos);
        }else{
            if(necesario <= puntos){
                total = total + necesario;
            }else{
                total = total + parseFloat(puntos);
            }
        }
        $('#totalsuma'+id).empty();
        $('#totalsuma'+id).append(total);
    }
</script>