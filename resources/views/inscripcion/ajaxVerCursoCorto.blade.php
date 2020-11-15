<div class="modal-content">
    <form action="{{ url('Inscripcion/actualizaCursoCorto') }}" method="post">
        @csrf
        <input type="hidden" name="inscripcion_id" id="inscripcion_id" value="{{ $inscripcion->id }}">
        <div class="modal-header bg-info">
            <h4 class="modal-title text-white" id="myModalLabel">
                <strong>Curso: {{ $inscripcion->asignatura->nombre }}</strong>
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
                            <th class="text-nowrap">Asistencia<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_asistencia) }}</h6></th>
                            <th class="text-nowrap">Practicas<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_practicas) }}</h6></th>
                            <th class="text-nowrap">Primer Parcial<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_primer_parcial) }}</h6></th>
                            <th class="text-nowrap">Examen Final<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_examen_final) }}</h6></th>
                            <th class="text-nowrap">Total<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_asistencia + $predefinida->nota_practicas + $predefinida->nota_primer_parcial + $predefinida->nota_examen_final) }}</h6></th>
                            <th class="text-nowrap">Extras<h6 class="card-subtitle text-primary">MAX: {{ round($predefinida->nota_puntos_ganados) }}</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input size="10" min="0" max="{{ $predefinida->nota_asistencia }}" pattern="^[0-9]+" onchange="calcula( {{ $curso->id }} )" data-asistencia="{{ $curso->nota_asistencia }}" type="number" id="asistencia" name="asistencia" value="{{ round($curso->nota_asistencia) }}" step="any" style="text-align: center; width: 100px;"></td>
                            <td><input size="10" min="0" max="{{ $predefinida->nota_practicas }}" pattern="^[0-9]+" onchange="calcula( {{ $curso->id }} )" data-practicas="{{ $curso->nota_practicas }}" type="number" id="practicas" name="practicas" value="{{ round($curso->nota_practicas) }}" step="any" style="text-align: center; width: 100px;"></td>
                            <td><input size="10" min="0" max="{{ $predefinida->nota_primer_parcial }}" pattern="^[0-9]+" onchange="calcula( {{ $curso->id }} )" data-parcial="{{ $curso->nota_primer_parcial }}" type="number" id="parcial" name="parcial" value="{{ round($curso->nota_primer_parcial) }}" step="any" style="text-align: center; width: 100px;"></td>
                            <td><input size="10" min="0" max="{{ $predefinida->nota_examen_final }}" pattern="^[0-9]+" onchange="calcula( {{ $curso->id }} )" data-final="{{ $curso->nota_examen_final }}" type="number" id="final" name="final" value="{{ round($curso->nota_examen_final) }}" step="any" style="text-align: center; width: 100px;"></td>
                            <td id="totalsuma"><input value="{{ round($curso->nota_total) }}" style="text-align: center; width: 100px;" readonly></td>
                            <td><input size="10" min="0" max="{{ $predefinida->nota_puntos_ganados }}" pattern="^[0-9]+" onchange="calcula( {{ $curso->id }} )" data-puntos="{{ $curso->nota_puntos_ganados }}" type="number" id="puntos" name="puntos" value="{{ round($curso->nota_puntos_ganados) }}" step="any" style="text-align: center; width: 100px;"></td>
                        </tr>
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
        var asistencia = $("#asistencia").val();
        var practicas = $("#practicas").val();
        var puntos = $("#puntos").val();
        var parcial = $("#parcial").val();
        var final = $("#final").val();

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
        $('#totalsuma').empty();
        $('#totalsuma').append(total);
    }
</script>