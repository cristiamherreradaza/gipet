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
        @php
            $montoTotal = 0;                    
        @endphp
        @foreach ($cuotasParaPagar as $cpp)
        @php
            $montoTotal += $cpp->a_pagar;
        @endphp
            <tr>
                <td>1</td>
                <td>{{ $cpp->mensualidad }}&#176; Mensualidad</td>
                <td>{{ $cpp->carrera->nombre }}</td>
                <td>{{ $cpp->a_pagar }}</td>
                <td>
                    @if ($ultimaCuota->id == $cpp->id)
                        <button type="button" class="btnElimina btn btn-danger" title="Elimina Item" onclick="eliminaItemPago('{{ $cpp->id }}')"><i class="fas fa-trash-alt"></i></button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th>{{ $montoTotal }}</th>
            <th></th>
        </tr>
    </thead>
</table>

<div class="row">
    <div class="col-md-9">
        <a href='{{ url("Factura/ajaxFacturar/")."/".$siguienteCuota->persona_id }}' class="btn btn-block btn-success" onclick="ajaxFacturar()">RECIBO</a>
    </div>

    <div class="col-md-3">
        <a href='{{ url("Factura/ajaxFacturar/")."/".$siguienteCuota->persona_id }}' class="btn btn-block btn-dark" onclick="ajaxFacturar()">FACTURA</a>
    </div>
</div>

<script type="text/javascript">
    function eliminaItemPago(pago_id)
    {
        $.ajax({
            url: "{{ url('Factura/ajaxEliminaItemPago') }}",
            data: {
                pago_id: pago_id
            },
            type: 'GET',
            success: function(data) {
                cambiaCarreraPension();
                ajaxMuestraTablaPagos();
            }
        });
    }
</script>