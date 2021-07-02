@if ($siguienteCuota)
<div class="col-md-2">
    <div class="form-group">
        <label>CUOTA
            <span class="text-danger">
                <i class="mr-2 mdi mdi-alert-circle"></i>
            </span>
        </label>
        <input type="hidden" name="pago_id" id="pago_id" value="{{ $siguienteCuota->id }}">
        <input type="text" class="form-control" name="numero_cuota_pago" id="numero_cuota_pago" value="{{ $siguienteCuota->mensualidad }}&deg; Mensualidad" readonly />
    </div>
</div>

<div class="col-md-3">
    <div class="form-group">
        @php
            if($siguienteCuota->descuento_persona_id == null){
                $nombreDescuento = 'NINGUNO';
            }else{
                $nombreDescuento = $siguienteCuota->descuento_persona->descuento->nombre;
            }
        @endphp
        <label>TIPO DESCUENTO
            <span class="text-danger">
                <i class="mr-2 mdi mdi-alert-circle"></i>
            </span>
        </label>
        <input type="text" class="form-control" name="descuento_pago" id="descuento_pago" value="{{ $nombreDescuento }}" readonly>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <label>IMPORTE
            <span class="text-danger">
                <i class="mr-2 mdi mdi-alert-circle"></i>
            </span>
        </label>
        @php
            if($siguienteCuota->faltante > 0 ){
                $importe = $siguienteCuota->faltante;
            }else{
                $importe = $siguienteCuota->a_pagar;
            }
        @endphp
        <input type="text" class="form-control" name="importe_pago" id="importe_pago" value="{{ $importe }}" required>
    </div>
</div>

<div class="col-2">
    <div class="form-group">
        <label>
            <span class="text-danger">
                <i class="mr-2 mdi mdi-alert-circle"></i>
            </span>
        </label>
        <select name="pago_parcial" id="pago_parcial" class="form-control" required>
            <option value="total">Total</option>
            <option value="parcial">Parcial</option>
        </select>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <label>&nbsp;</label>
        <button type="button" class="btn btn-block btn-success" onclick="adicionaItem()">Adicionar</button>
    </div>
</div>
@else
    <div class="col-md-6">
        <div class="form-group">
            <label>&nbsp;</label>
            <h2 class="text-success">NO TIENE CUOTAS PENDIENTES</h2>
        </div>
    </div>
@endif

<script>
    function adicionaItem()
    {
        let pago_id = $("#pago_id").val();
        let importe_pago = $("#importe_pago").val();
        let pago_parcial = $("#pago_parcial").val();

        $.ajax({
            url: "{{ url('Factura/ajaxAdicionaItem') }}",
            data: {
                pago_id: pago_id,
                importe_pago: importe_pago,
                pago_parcial: pago_parcial,
                },
            type: 'GET',
            success: function(data) {
                cambiaCarreraPension();
                ajaxMuestraTablaPagos();
                $("#tituloPagos").show();
                $("#ajaxMuestraItemsAPagar").html(data);
            }
        });

    }

</script>
