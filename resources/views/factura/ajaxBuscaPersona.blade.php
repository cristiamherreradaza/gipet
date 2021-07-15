@if ($personas->count()>0)
    <table class="tablesaw table-striped table-hover table-bordered table no-wrap">
        <thead>
            <tr>
                <th>CEDULA</th>
                <th>APELLIDO PATERNO</th>
                <th>APELLIDO MATERNO</th>
                <th>NOMBRES</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($personas as $p)
            <tr>
                    <td>{{ $p->cedula }}</td>
                    <td>{{ $p->apellido_paterno }}</td>
                    <td>{{ $p->apellido_materno }}</td>
                    <td>{{ $p->nombres }}</td>
                    <td>
                        <button type="button" class="btn btn-success" title="PAGOS" onclick="selecciona({{ $p->id }})">
                            <i class="fas fa-donate"></i>
                        </button>
                        <button onclick="ver_persona('{{ $p->id }}')" type="button" class="btn btn-info" title="ACADEMICO"><i class="fas fa-list"></i></button>
                        <button onclick="eliminar_persona('.$estudiantes->id.', '.$estudiantes->cedula.')" type="button" class="btn btn-danger" title="ELIMINAR"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else    
    <h2 class="text-danger text-center">NO EXISTE LA PERSONA</h2>
@endif

<script>
   

</script>