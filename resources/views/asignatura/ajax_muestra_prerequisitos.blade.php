@if (!$asignaturas->isEmpty())
    <div class="table-responsive">
        <table class="table table-striped no-wrap">
            <thead>
                <tr>
                    <th>Sigla</th>
                    <th>Materia</th>
                    <th>Año Vigente</th>
                    <th class="text-nowrap">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($asignaturas as $asignatura)
                    @if($asignatura->prerequisito_id)
                        <tr>
                            <td>{{ $asignatura->prerequisito->sigla }}</td>
                            <td>{{ $asignatura->prerequisito->nombre }}</td>
                            <td>{{ $asignatura->prerequisito->anio_vigente }}</td>
                            <td class="text-nowrap">
                                <button type="button" class="btn btn-danger" onclick="elimina_prerequisito('{{ $asignatura->id }}', '{{ $asignatura->asignatura_id }}', '{{ $asignatura->prerequisito->nombre }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@else
    NO TIENE PREREQUISITOS
@endif