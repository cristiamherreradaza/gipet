<div class="table-responsive">
    <table class="table table-striped no-wrap" id="tablaAsignaturasEncontradas">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sigla</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th class="text-center">Semestre</th>
                <th class="text-center">Gestion</th>
                <th class="text-nowrap">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($asignaturas as $key => $asignatura)
                <tr class="item_{{ $asignatura->id }}">
                    <td>{{ $asignatura->id }}</td>
                    <td>{{ $asignatura->sigla }}</td>
                    <td>{{ $asignatura->nombre }}</td>
                    <td>{{ $asignatura->carrera->nombre }}</td>
                    <td class="text-center">
                        @if($asignatura->semestre)
                            {{ $asignatura->semestre }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">{{ $asignatura->gestion }}</td>
                    <td>
                        <button type="button" class="btnSelecciona btn btn-info" title="Adiciona Item"><i class="fas fa-plus"></i></button>
                    </td>
                </tr>    
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
        $("#tablaAsignaturasEncontradas").on('click', '.btnSelecciona', function () {

            $("#listadoAsignaturasAjax").hide('slow');
            $("#termino").val("");
            $("#termino").focus();

            var currentRow = $(this).closest("tr");

            var id       = currentRow.find("td:eq(0)").text();
            var sigla   = currentRow.find("td:eq(1)").text();
            var nombre   = currentRow.find("td:eq(2)").text();
            var carrera  = currentRow.find("td:eq(3)").text();
            var semestre = currentRow.find("td:eq(4)").text();
            var gestion  = currentRow.find("td:eq(5)").text();

            let buscaItem = itemsPedidoArray.lastIndexOf(id);
            if(buscaItem < 0)
            {
                itemsPedidoArray.push(id);  
                t.row.add([
                    `<input type="hidden" name="asignatura[`+id+`]" value="`+id+`">`,
                    sigla,
                    nombre,
                    carrera,
                    semestre,
                    gestion,
                    //`<input type="number" class="form-control" value="1" min="1" name="item[` + id + `]" required>`,
                    '<button type="button" class="btn btn-danger btnElimina" title="Eliminar asignatura"><i class="fas fa-trash-alt"></i></button>'
                ]).draw(false);
            }
        });

    });
</script>