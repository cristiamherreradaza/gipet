<div class="table-responsive">
    <table class="table table-striped table-hover no-wrap">
        <thead class="bg-inverse text-white">
            <tr>
                <th>Nombre</th>
                <th>Sigla</th>
                <th>Curso</th>
                <th class="text-center">Nota</th>
                <th class="text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($materiasInscripcion as $key => $mi)
            <tr>
                <td>{{ $mi->asignatura->nombre }}</td>
                <td>{{ $mi->asignatura->sigla }}</td>
                <td>{{ $mi->gestion }}</td>
                <td class="text-center"><h4>{{ round($mi->nota, 0) }}</h4></td>
                <td>
                    <button type="button" class="btn btn-success" title="Edita Notas" onclick="ajaxEscoger()">
                        <i class="fas fa-check"></i></button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>