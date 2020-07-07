<div class="modal-content">
    <div class="modal-header bg-primary">
        <h4 class="modal-title text-white" id="myModalLabel"><strong>REGISTRO DE NOTAS</strong></h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <div class="modal-body">
        <h6><strong class="text-info">Estudiante: </strong class="text-info">{{ $notas[0]->persona->nombres }} {{ $notas[0]->persona->apellido_paterno }} {{ $notas[0]->persona->apellido_materno }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong class="text-info">Cedula de Identidad: </strong>{{ $notas[0]->persona->carnet }}</h6>    
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead class="align-middle text-primary">
                    <tr>
                        <th># Bimestre</th>
                        <th>Asistencia</th>
                        <th>Practicas</th>
                        <th>Puntos Ganados</th>
                        <th>Primer Parcial</th>
                        <th>Examen Final</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notas as $nota)                                
                        <tr>
                            <td>{{ $nota->trimestre }}</td>
                            <td><input size="10" min="0" max="{{ $asignatura->nota_asistencia }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-asistencia="{{ $nota->nota_asistencia }}" type="number" id="asistencia-{{ $nota->id }}" name="asistencia-{{ $nota->id }}" value="{{ $nota->nota_asistencia }}" step="any"></td>
                            <td><input size="10" min="0" max="{{ $asignatura->nota_practicas }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-practicas="{{ $nota->nota_practicas }}" type="number" id="practicas-{{ $nota->id }}" name="practicas-{{ $nota->id }}" value="{{ $nota->nota_practicas }}" step="any"></td>
                            <td><input size="10" min="0" max="{{ $asignatura->nota_puntos_ganados }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-puntos="{{ $nota->nota_puntos_ganados }}" type="number" id="puntos-{{ $nota->id }}" name="puntos-{{ $nota->id }}" value="{{ $nota->nota_puntos_ganados }}" step="any"></td>
                            <td><input size="10" min="0" max="{{ $asignatura->nota_primer_parcial }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-parcial="{{ $nota->nota_primer_parcial }}" type="number" id="parcial-{{ $nota->id }}" name="parcial-{{ $nota->id }}" value="{{ $nota->nota_primer_parcial }}" step="any"></td>
                            <td><input size="10" min="0" max="{{ $asignatura->nota_examen_final }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-final="{{ $nota->nota_examen_final }}" type="number" id="final-{{ $nota->id }}" name="final-{{ $nota->id }}" value="{{ $nota->nota_examen_final }}" step="any"></td>
                            <td id="totalsuma{{ $nota->id }}">{{ $nota->nota_total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <a href="{{ url('nota/detalle/'.$asignatura->id) }}" class="btn btn-block btn-primary">ACTUALIZAR</a>
    </div>
</div>