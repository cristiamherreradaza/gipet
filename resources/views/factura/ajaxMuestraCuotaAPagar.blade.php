<div class="col-md-2">
    <div class="form-group">
        <label>CUOTA
            <span class="text-danger">
                <i class="mr-2 mdi mdi-alert-circle"></i>
            </span>
        </label>
        <input type="hidden" name="pago_id" id="pago_id" value="{{ $siguienteCuota->id }}">
        <input type="hidden" name="persona_id" id="persona_id" value="{{ $siguienteCuota->persona_id }}">
        <input type="hidden" name="carrera_id" id="carrera_id" value="{{ $siguienteCuota->carrera_id }}">
        <input type="text" class="form-control" name="numeroCuota" id="numeroCuota" value="{{ $siguienteCuota->mensualidad }}; Mensualidad" readonly />
    </div>
</div>

<div class="col-md-2">
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
        <input type="text" class="form-control" name="tipoDescuento" id="tipoDescuento" value="{{ $nombreDescuento }}" readonly>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <label>MONTO
            <span class="text-danger">
                <i class="mr-2 mdi mdi-alert-circle"></i>
            </span>
        </label>
        <input type="text" class="form-control" name="cuotaParaPagar" id="cuotaParaPagar" value="{{ $siguienteCuota->a_pagar }}" required>
    </div>
</div>

<div class="col-2">
    <div class="form-group">
        <label>
            <span class="text-danger">
                <i class="mr-2 mdi mdi-alert-circle"></i>
            </span>
        </label>
        <select name="carrera_id" id="carrera_id" class="form-control" required>
            <option value="total">Total</option>
            <option value="parcial">Parcial</option>
        </select>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <label>&nbsp;</label>
        <button type="button" class="btn btn-block btn-info" onclick="adicionaItem()">Adicionar</button>
    </div>
</div>

<script>
    function adicionaItem()
    {
        let pago_id = $("#pago_id").val();
        let persona_id = $("#persona_id").val();
        let carrera_id = $("#carrera_id").val();
        let cuotaAPagar = $("#cuotaParaPagar").val(); 

        $.ajax({
            url: "{{ url('Factura/ajaxAdicionaItem') }}",
            data: {
                pago_id: pago_id,
                persona_id: persona_id,
                carrera_id: carrera_id,
                cuotaAPagar: cuotaAPagar
                },
            type: 'GET',
            success: function(data) {
                cambiaCarreraPension();
                $("#ajaxMuestraItemsAPagar").html(data);
            }
        });

    }
</script>
