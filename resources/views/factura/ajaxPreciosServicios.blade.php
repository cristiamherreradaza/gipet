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

<div class="col-2">
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
</div>

<div class="col-md-2">
    <div class="form-group">
        <label>&nbsp;</label>
        <button type="button" class="btn btn-block btn-success" onclick="adicionaItem()">Adicionar</button>
    </div>
</div>