<p>aqui ira formulario para inscribir carreras o retirar</p>
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
                    $detalle = App\Carrera::find($carrera->carrera_id);
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
                @endphp
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>{{ $detalle->nombre }}</td>
                    <td>{{ $gestion }}</td>
                    <td>{{ $semestre }}</td>
                    <td>{{ $anio }}</td>
                    <td>{{ $resultado->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>