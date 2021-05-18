<div class="table-responsive">
    <table class="table table-striped table-hover no-wrap">
        <thead class="bg-inverse text-white">
            <tr>
                <th>Carrera</th>
                <th>Nombre</th>
                <th>Sigla</th>
                <th>Curso</th>
                <th class="text-center">Gestion</th>
                <th class="text-center">Nota</th>
                <th class="text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaturas as $key => $a)
            <tr>
                <td>{{ $a->carrera->nombre }}</td>
                <td>{{ $a->nombre }}</td>
                <td>{{ $a->sigla }}</td>
                <td>{{ $a->gestion }}&deg; A&ntilde;o</td>
                <td class="text-center">{{ $a->anio_vigente }}</td>
                <td class="text-center"><h4>{{ round($a->nota, 0) }}</h4></td>
                <td>
                    <button type="button" class="btn btn-info" title="Edita Notas" onclick="ajaxEscoger('{{ $a->id }}', '{{ $a->nombre }}')">
                        <i class="fas fa-check"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    function ajaxEscoger(inscripcion_id, nota, nombre)
    {
        $("#materia_convalidar").val(nombre);
        $("#nota_convalidar").val(nota);
        $("#id_materia_convalidar").val(inscripcion_id);
        $("#ajaxMuestraMateriasCursadas").toggle('slow');
    }
</script>