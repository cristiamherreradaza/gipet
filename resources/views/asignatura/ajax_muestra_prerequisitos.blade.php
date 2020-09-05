@if (!$prerequisitos->isEmpty())
    <div class="table-responsive">
        <table class="table table-striped no-wrap">
            <thead>
                <tr>
                    <th>Sigla</th>
                    <th>Materia</th>
                    <th class="text-nowrap">Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prerequisitos as $p)
                    @if($p->prerequisito_id)
                        <tr>
                            <td>{{ $p->materia->codigo_asignatura }}</td>
                            <td>{{ $p->materia->nombre_asignatura }}</td>
                            <td class="text-nowrap">
                                <button type="button" class="btn btn-danger" onclick="elimina_prerequisito('{{ $p->id }}', '{{ $p->asignatura_id }}', '{{ $p->materia->nombre_asignatura }}')"><i
                                        class="fas fa-trash"></i></button>
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