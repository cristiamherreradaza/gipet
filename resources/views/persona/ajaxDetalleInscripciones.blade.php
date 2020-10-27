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
            @foreach($inscripciones as $key => $inscripcion)
                @php
                    $detalle = App\Carrera::find($inscripcion->carrera_id);
                @endphp
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>{{ $detalle->nombre }}</td>
                    <td>{{ $inscripcion->gestion }}</td>
                    <td>{{ $inscripcion->semestre }}</td>
                    <td>{{ $inscripcion->anio_vigente }}</td>
                    <td>{{ $inscripcion->estado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>