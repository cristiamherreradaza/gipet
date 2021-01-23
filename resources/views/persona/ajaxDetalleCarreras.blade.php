<h1 class="text-center text-dark-info"><strong>Carreras</strong></h1>
<div class="row">
    <div class="col-md-12">
        <form action="{{ url('Inscripcion/inscribirCarrera') }}" method="POST">
            @csrf
            <input type="text" name="persona_id" id="persona_id" value="{{ $persona->id }}" hidden>
            <div class="form-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Carrera
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" id="nueva_carrera" name="nueva_carrera" required>
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Turno
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" id="nuevo_turno" name="nuevo_turno" required>
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
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Paralelo
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" id="nuevo_paralelo" name="nuevo_paralelo" required>
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Gesti&oacute;n</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="number" class="form-control" id="nueva_gestion" name="nueva_gestion" value="{{ date('Y') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Fecha de Inscripcion</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="date" name="nueva_fecha_inscripcion" id="nueva_fecha_inscripcion" class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">&nbsp;</label>
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

<script>
    function validaItems()
    {
        var nueva_carrera           = $("#nueva_carrera").val();
        var nuevo_turno             = $("#nuevo_turno").val();
        var nuevo_paralelo          = $("#nuevo_paralelo").val();
        var nueva_gestion           = $("#nueva_gestion").val();
        var nueva_fecha_inscripcion = $("#nueva_fecha_inscripcion").val();
        if(nueva_carrera.length > 0 && nuevo_turno.length > 0 && nuevo_paralelo.length > 0 && nueva_gestion.length > 0 && nueva_fecha_inscripcion.length > 0){
            //alert('ok');
        }else{
            event.preventDefault();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Tienes que adicionar al menos un producto.'
            })
        }
    }
</script>