<div class="table-responsive">
    <table class="table table-striped no-wrap" id="tablaAlumnosEncontrados">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cedula</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Nombres</th>
                <!-- <th>Modelo</th>
                <th>Colores</th>
                <th>Stock</th> -->
                <th class="text-nowrap">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $key => $alumno)
                <tr class="item_{{ $alumno->id }}">
                    <td>{{ $alumno->id }}</td>
                    <td>{{ $alumno->cedula }}</td>
                    <td>{{ $alumno->apellido_paterno }}</td>
                    <td>{{ $alumno->apellido_materno }}</td>
                    <td>{{ $alumno->nombres }}</td>
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
        $("#tablaAlumnosEncontrados").on('click', '.btnSelecciona', function () {

            $("#listadoAlumnosAjax").hide('slow');
            $("#termino").val("");
            $("#termino").focus();

            var currentRow = $(this).closest("tr");

            var id                  = currentRow.find("td:eq(0)").text();
            var cedula              = currentRow.find("td:eq(1)").text();
            var apellido_paterno    = currentRow.find("td:eq(2)").text();
            var apellido_materno    = currentRow.find("td:eq(3)").text();
            var nombres             = currentRow.find("td:eq(4)").text();
            
            let buscaItem = itemsPedidoArray.lastIndexOf(id);
            if(buscaItem < 0)
            {
                itemsPedidoArray.push(id);  
                t.row.add([
                    id,
                    cedula,
                    apellido_paterno,
                    apellido_materno,
                    nombres,
                    `<input type="hidden" value="`+id+`" name="item[` + id + `]">`,
                    '<button type="button" class="btnElimina btn btn-danger" title="Eliminar estudiante"><i class="fas fa-trash-alt"></i></button>'
                ]).draw(false);
            }
        });

    });
</script>