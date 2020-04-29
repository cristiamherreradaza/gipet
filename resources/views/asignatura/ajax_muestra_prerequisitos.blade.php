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
                    <tr>
                        <td>{{ $p->materia->codigo_asignatura }}</td>
                        <td>{{ $p->materia->nombre_asignatura }}</td>
                        <td class="text-nowrap">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    NO TIENE PREREQUISITOS
@endif