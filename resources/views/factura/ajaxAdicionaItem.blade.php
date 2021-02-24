<table class="tablesaw table-striped table-hover table-bordered table no-wrap">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Descripcion</th>
            <th>Carrera</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cuotasParaPagar as $cpp)
            <tr>
                <td>1</td>
                <td>{{ $cpp->mensualidad }}&#176; Mensualidad</td>
                <td>{{ $cpp->carrera->nombre }}</td>
                <td>{{ $cpp->a_pagar }}</td>
                <td>
                    @if ($ultimaCuota->id == $cpp->id)
                        <button type="button" class="btnElimina btn btn-danger" title="Elimina Producto"><i class="fas fa-trash-alt"></i></button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="row">
    <div class="col-md-12">
        <button type="submit" class="btn btn-block btn-success" onclick="ajaxFacturar()">FACTURAR</button>
    </div>
</div>

<script type="text/javascript">

    function ajaxFacturar(){

        let persona_id = $("#persona_id").val();

        window.location.href = "{{ url("Factura/ajaxFacturar") }}/"+persona_id;



        /*$.ajax({
            url: "{{ url('Factura/ajaxFacturar') }}",
            data: {
                persona_id: persona_id,
                },
            type: 'GET',
            success: function(data) {
                cambiaCarreraPension();
                $("#ajaxMuestraItemsAPagar").html(data);
                // $("#ajaxPersonas").show('slow');
                // $("#ajaxPersonas").html(data);
            }
        });    */
    }
</script>