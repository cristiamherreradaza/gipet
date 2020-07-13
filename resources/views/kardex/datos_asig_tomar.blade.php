<div class="card">
    <div class="card-body">
        <form action="{{ url('Kardex/guarda_reinscripcion') }}"  method="POST" >
        @csrf
        <div class="d-flex align-items-center">
            <h4 class="card-title mb-0">Asignaturas por Tomar</h4>
            <div class="ml-auto flo">
                <button class="btn btn-sm btn-rounded btn-success" type="submit" data-toggle="modal" data-target="#myModal" >Guardar</button>
            </div>
        </div>
        <div class="to-do-widget mt-3 scrollable">
            <ul class="list-task todo-list list-group mb-0" data-role="tasklist">
                    <div class="card border-dark">
                        <div class="card-header bg-dark">
                            <h4 class="mb-0 text-white">CARRERAS</h4>
                            {{-- <button type="button" class="float-right btn btn-success" onclick="nueva_carrera({{ $datosPersonales->id }})">Nueva Carrera</button> --}}
                            <input type="text" hidden name="carrera_id" value="{{ $carrera_id }}">
                            <input type="text" hidden name="persona_id" value="{{ $persona_id }}">
                            <input type="text" hidden name="turno_id" value="{{ $turno_id }}">
                            <input type="text" hidden name="paralelo" value="{{ $paralelo }}">
                            <input type="text" hidden name="anio_vigente" value="{{ $anio_vigente }}">
                            {{-- <input type="text" name="sexo" checked value="{{ $asig->asignatura_id }}"> --}}
                        </div>
                            <table class="table no-wrap">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Asignatura</th>
                                        <th>Codigo</th>
                                        <th>Turno</th>
                                        <th>Paralelo</th>
                                </thead>
                                <tbody>
                                    @foreach ($asig_tomar as $asig)
                                        <tr>
                                            <td><input type="checkbox" class="todo" name="asignatura_id[]" checked value="{{ $asig->asignatura_id }}"></td>
                                            <td>
                                                {{ $asig->nombre_asignatura }}
                                            </td>
                                            <td>
                                                {{ $asig->codigo_asignatura }}
                                            </td>
                                            <td>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" id="re_asig_turno" name="re_asig_turno[]" required>
                                                    {{-- <option value="">Seleccionar</option> --}}
                                                    @foreach($turnos as $tur)
                                                    @php
                                                        if ($turno_id == $tur->id) {
                                                    @endphp
                                                        <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                    @php
                                                        } else {
                                                    @endphp
                                                        <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                    @php
                                                        }
                                                    @endphp
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" id="re_asig_paralelo" name="re_asig_paralelo[]" required>
                                                    <option value="{{ $paralelo }}">{{ $paralelo }}</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
            </ul>
        </div>
        </form>
    </div>
</div>
<script>
    // function guardar_asig_tomar()
    // {
    //     alert();
    // }



</script>