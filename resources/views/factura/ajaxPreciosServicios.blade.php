<div class="col-md-2">
    <div class="form-group">
        <label>IMPORTE
            <span class="text-danger">
                <i class="mr-2 mdi mdi-alert-circle"></i>
            </span>
        </label>
        <input type="text" class="form-control" name="importe_pago" id="importe_pago" value="{{ $preciosServicios->precio }}" required>
    </div>
</div>

{{-- <div class="col-2">
    <div class="form-group">
        <label>PAGO
            <span class="text-danger">
                <i class="mr-2 mdi mdi-alert-circle"></i>
            </span>
        </label>
        <select name="pago_parcial" id="pago_parcial" class="form-control" required>
            <option value="total">TOTAL</option>
            <option value="parcial">PARCIAL</option>
        </select>
    </div>
</div> --}}

<div class="col-md-2">
    <div class="form-group">
        <label>&nbsp;</label>
        <button type="button" class="btn btn-block btn-success" onclick="adicionaPagoServicio()">Adicionar</button>
    </div>
</div>

<script type="text/javascript">
    function adicionaPagoServicio()
    {
        let servicio_id = {{ $preciosServicios->id }};
        let persona_id = {{ $persona->id }};
        let importe = $('#importe_pago').val();
        let pago_parcial = $('#pago_parcial').val();
        // console.log(persona_id);

       $.ajax({
            url: "{{ url('Factura/ajaxAdicionaItemServicio') }}",
            data: {
                servicio_id: servicio_id,
                persona_id: persona_id,
                importe: importe,
                pago_parcial: pago_parcial
                },
            type: 'GET',
            success: function(data) {
                // cambiaCarreraPension();
                ajaxMuestraTablaPagos();
                $("#tituloPagos").show();
                // $("#ajaxMuestraItemsAPagar").html(data);
            }
        });

    }
</script>