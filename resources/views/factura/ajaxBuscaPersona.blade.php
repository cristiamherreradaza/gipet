@if ($personas)
    <table class="tablesaw table-striped table-hover table-bordered table no-wrap">
        <thead>
            <tr>
                <th>APELLIDO PATERNO</th>
                <th>APELLIDO MATERNO</th>
                <th>NOMBRES</th>
                <th>CEDULA</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($personas as $p)
                <tr>
                    <td>{{ $p->apellido_paterno }}</td>
                    <td>{{ $p->apellido_materno }}</td>
                    <td>{{ $p->nombres }}</td>
                    <td>{{ $p->cedula }}</td>
                    <td><button type="button" class="btn btn-sm btn-success" data-venta="tienda" title="Seleccionar" onclick="selecciona({{ $p->id }})"><i class="fas fa-check"></i></button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else    
    <h3 class="text-info">No existe</h3>
@endif

<script>
    function selecciona(personaId)
    {
        $.ajax({
            url: "{{ url('Factura/ajaxPersona') }}",
            data: {personaId: personaId},
            type: 'POST',
            success: function(data) {
                // $("#ajaxPersonas").hide('slow');
                $("#ajaxDatosPersona").html(data);
            }
        });
    }
</script>