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
                        <td>{{ $asignatura->sigla }}</td>
                        <td>{{ $asignatura->nombre }}</td>
                        <td>{{ $registro ? 'Si' : 'No' }}</td>
                        <td>{{ $registro ? $registro->fecha_registro : '' }}</td>
                        <td>{{ $registro ? $registro->nota : '' }}</td>
                        <td>
                            @if($registro)
                                @if($registro->aprobo == 'Si')
                                    <td class="text-success">APROBADO</td>
                                @else
                                    <td class="text-danger">REPROBADO</td>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if(!$registro)
                                <button type="button" class="btn btn-success" title="Inscribir"  onclick="inscribir_curso_corto('{{ $persona->id }}', '{{ $asignatura->id }}')"><i class="fas fa-certificate"></i></button>
                                <button type="button" class="btn btn-info" title="Ver detalle" disabled><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar Inscripcion" disabled><i class="fas fa-trash-alt"></i></button>
                            @else
                                <button type="button" class="btn btn-success" title="Inscribir" disabled><i class="fas fa-certificate"></i></button>
                                <button type="button" class="btn btn-info" title="Ver detalle"  onclick="ver_curso_corto('{{ $registro->id }}')"><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn btn-danger" title="Eliminar Inscripcion"  onclick="eliminar_curso_corto('{{ $registro->id }}')"><i class="fas fa-trash-alt"></i></button>
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