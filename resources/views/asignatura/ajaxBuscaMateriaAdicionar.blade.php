<div class="table-responsive">
    <table class="table table-striped table-hover no-wrap">
        <thead class="bg-primary text-white">
            <tr>
                <th>Carrera</th>
                <th>Nombre</th>
                <th>Sigla</th>
                <th>Curso</th>
                <th class="text-center">Gestion</th>
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
                <td>
                    <button type="button" class="btn btn-primary" title="Edita Notas" onclick="ajaxEscogerMateriaAdicionar('{{ $a->id }}', '{{ $a->nombre }}')">
                        <i class="fas fa-check"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    function ajaxEscogerMateriaAdicionar(asignatura_id, nombre)
    {
        $("#buscaMateriaAdicionar").val(nombre);
        $("#adiciona_asignatura_id").val(asignatura_id);
        $("#ajaxCargaMateriasAdicionar").toggle('slow');
    }
</script>