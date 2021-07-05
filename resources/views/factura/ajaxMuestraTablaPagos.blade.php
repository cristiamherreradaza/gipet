<table class="tablesaw table-striped table-hover table-bordered table no-wrap">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Descripcion</th>
            <th>Descuento</th>
            <th>Importe</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @php
            $montoTotal = 0;                    
        @endphp
        @foreach ($cuotasParaPagar as $cpp)
        @php
            $montoTotal += $cpp->importe;
        @endphp
            <tr>
                <td>1</td>
                <td>
                    @if ($cpp->servicio_id == 2)
                        {{ $cpp->mensualidad }}&#176; Mensualidad
                    @else
                        {{ $cpp->servicio->nombre }}
                    @endif
                </td>
                <td>
                    @if (!$cpp->descuento_persona_id == null)
                        @php
                            $descuentoPersona = App\DescuentosPersona::find($cpp->descuento_persona_id);
                            echo $descuentoPersona->descuento->nombre;
                        @endphp    
                    @else
                        NINGUNO
                    @endif
                </td>
                <td>
                    {{ $cpp->importe }}
                    @if ($cpp->faltante > 0)
                        <span class="text-danger">({{ $cpp->faltante }})</span>
                    @endif
                </td>
                <td>
                    @if ($cpp->servicio_id == 2)
                        <button type="button" class="btn btn-danger" title="Elimina Item" onclick="eliminaItemPago('{{ $cpp->id }}')"><i class="fas fa-trash-alt"></i></button>
                    @else
                        <button type="button" class="btn btn-danger" title="Elimina Item" onclick="eliminaItemPagoServicio('{{ $cpp->id }}')"><i class="fas fa-trash-alt"></i></button>
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
        <a href='{{ url("Factura/generaRecibo")."/".$persona_id }}/recibo' class="btn btn-block btn-success">RECIBO</a>
    </div>

    <div class="col-md-3">
        {{-- <a href='{{ url("Factura/ajaxFacturar")."/".$persona_id }}/factura' class="btn btn-block btn-dark" onclick="muestraNit()">FACTURA</a> --}}
        <button class="btn btn-block btn-dark" onclick="muestraNit()">FACTURA</button>
    </div>
</div>

<div class="row" id="bloqueNit" style="display: none;">
    <form action="{{ url('Factura/guardaNitCliente') }}" method="POST" id="formularioNitFacturar">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">NIT</label>
                <input type="hidden" name="persona_id" value="{{ $persona->id }}">
                <input type="text" name="nit_factura" id="nit_factura" class="form-control" value="{{ $persona->nit }}" required>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">RAZON SOCIAL</label>
                <input type="text" name="razon_factura" id="razon_factura" class="form-control"
                    value="{{ $persona->razon_social_cliente }}" required>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">&nbsp;</label>
                <input type="submit" class="btn btn-block btn-success" value="ACEPTAR">
            </div>
        </div>

    </form>
</div>


<script type="text/javascript">

    function muestraNit()
    {
        $("#bloqueNit").show('slow');
    }

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

    function eliminaItemPagoServicio(pago_id)
    {
        $.ajax({
            url: "{{ url('Factura/ajaxEliminaItemPagoServicio') }}",
            data: {
                pago_id: pago_id
            },
            type: 'GET',
            success: function(data) {
                ajaxMuestraTablaPagos();
            }
        });
    }
</script>