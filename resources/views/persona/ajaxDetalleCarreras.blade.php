<h1 class="text-center text-dark-info"><strong>Carreras</strong></h1>
<div class="row">
    <div class="col-md-12">
        <form action="{{ url('Inscripcion/inscribirCarrera') }}" method="POST" class="form-horizontal">
            @csrf
            <input type="text" name="persona_id" id="persona_id" value="{{ $persona->id }}" hidden>
            <div class="form-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Carrera</label>
                                <div class="col-md-9">
                                    <select name="nueva_carrera" id="nueva_carrera" class="form-control custom-select">
                                        @if(count($disponibles) > 0)
                                            @foreach($disponibles as $carrera)
                                                <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                            @endforeach
                                        @else
                                            <option value="">No Disponible</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Turno</label>
                                <div class="col-md-9">
                                    <select name="nuevo_turno" id="nuevo_turno" class="form-control custom-select">
                                        @if(count($disponibles) > 0)
                                            @foreach($turnos as $turno)
                                                <option value="{{ $turno->id }}">{{ $turno->descripcion }}</option>
                                            @endforeach
                                        @else
                                            <option value="">No Disponible</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group row">
                                <label class="control-label text-right col-md-3">Paralelo</label>
                                <div class="col-md-9">
                                    <select name="nuevo_paralelo" id="nuevo_paralelo" class="form-control custom-select">
                                        @if(count($disponibles) > 0)
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        @else
                                            <option value="">No Disponible</option>
                                        @endif
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group row">
                                <button type="submit" class="btn btn-block btn-info">Inscribir</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped no-wrap" id="tablaProductosEncontrados">
        <thead>
            <tr>
                <th>#</th>
                <th>Carrera</th>
                <th>Gestion</th>
                <th>Semestre</th>
                <th>A&ntilde;o</th>
                <th>Estado</th>
                <th class="text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($carreras as $key => $carrera)
                @php
                    $detalle = App\Carrera::find($carrera->id);
                    $gestion = App\Inscripcione::where('carrera_id', $detalle->id)
                                                ->where('persona_id', $persona->id)
                                                ->max('gestion');
                    $semestre = App\Inscripcione::where('carrera_id', $detalle->id)
                                                ->where('persona_id', $persona->id)
                                                ->where('gestion', $gestion)
                                                ->max('semestre');
                    $anio = App\Inscripcione::where('carrera_id', $detalle->id)
                                            ->where('persona_id', $persona->id)
                                            ->where('gestion', $gestion)
                                            ->max('anio_vigente');
                    $estado = App\Inscripcione::where('carrera_id', $detalle->id)
                                                ->where('persona_id', $persona->id)
                                                ->where('gestion', $gestion);
                    if($semestre){
                        $estado = $estado->where('semestre', $semestre);
                    }
                    $resultado = $estado->first();
                    $parametro = App\Asignatura::where('carrera_id', $detalle->id)
                                                ->where('anio_vigente', $detalle->anio_vigente)
                                                ->count();
                    $comparacion = App\Inscripcione::where('carrera_id', $detalle->id)
                                                    ->where('aprobo', 'Si')
                                                    ->count();
                @endphp
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>{{ $detalle->nombre }}</td>
                    <td>{{ $gestion }}</td>
                    <td>{{ $semestre }}</td>
                    <td>{{ $anio }}</td>
                    <td>{{ $resultado->estado }}</td>
                    <td>
                        <a href="{{ url('Inscripcion/reinscripcion/'.$persona->id.'/'.$detalle->id) }}" class="btn btn-inverse" title="Reinscribir"><i class="fas fa-plus"></i></a>
                        @if($parametro == $comparacion)
                        <a href="{{ url('Inscripcion/convalidar/'.$persona->id.'/'.$detalle->id) }}" class="btn btn-warning" title="Convalidar"><i class="fas fa-arrows-alt-h"></i></a>
                        @else
                        <button class="btn btn-warning" title="Convalidar" disabled><i class="fas fa-arrows-alt-h"></i></button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>