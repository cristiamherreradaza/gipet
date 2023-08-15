<table class="tablesaw table-striped table-hover table-bordered table no-wrap">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Descripcion</th>
            <th>Importe</th>
            <th>Descuento</th>
            <th style="width:200px;"></th>
        </tr>
    </thead>
    <tbody>
        @php
            $montoTotal = 0;
        @endphp
        @foreach ($cuotasParaPagar as $cpp)
        @php
            $montoTotal += $cpp->importe;
            $montoTotal = $montoTotal - $cpp->descuento;
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
                    {{ $cpp->importe }}
                    @if ($cpp->faltante > 0)
                        <span class="text-danger">({{ $cpp->faltante }})</span>
                    @endif
                </td>
                <td>
                    @php
                        if($cpp->descuento > 0)
                            $valoInput = $cpp->descuento;
                        else
                            $valoInput = 0;
                    @endphp
                    <input type="number" class="form-control" id="pago_listado_{{ $cpp->id }}" onchange="funcionNueva(this,{{ $cpp->id }})" value="{{ $valoInput }}" min="0.1">
                    {{--  @if ($cpp->descuento_persona_id == null || $cpp->descuento_persona->descuento_id == null)
                        NINGUNO
                    @else
                        @php
                            $descuentoPersona = App\DescuentosPersona::find($cpp->descuento_persona_id);
                            echo $descuentoPersona->descuento->nombre;
                        @endphp

                    @endif  --}}
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
            <th colspan="4">
                <label class="control-label">DESCUENTO ADICIONAL</label>
                <input type="text" id="descuento_adicional" class="form-control" value="0" onchange="caluculaTotal(event)" >
            </th>
            <th>
                <label class="control-label">MONTO TOTAL</label>
                <input type="text" class="form-control" readonly id="motoTotalFac" value="{{ $montoTotal }}">
            </th>
        </tr>
    </thead>
</table>

<div class="row">
     <div class="col-md-6">
        <a href='{{ url("Factura/generaRecibo")."/".$persona_id }}/recibo' class="btn btn-block btn-success">RECIBO</a>
    </div> 
    <div class="col-md-6">
    {{-- <div class="col-md-12"> --}}
        {{-- <a href='{{ url("Factura/ajaxFacturar")."/".$persona_id }}/factura' class="btn btn-block btn-dark" onclick="muestraNit()">FACTURA</a> --}}
        <button class="btn btn-block btn-dark" onclick="muestraNit()" id="btn_concluir">CONCLUIR</button>
    </div>
</div>
<br />
<div id="bloqueNit" style="display: none; width: 100%">
    {{--  <form action="{{ url('Factura/guardaNitCliente') }}" method="POST" id="formularioNitFacturar">  --}}
    <form method="POST" id="formularioGeneraFactura">
        @csrf
        <div class="row">
            <div class="col-md-1">
                <div class="form-group">
                    <label class="control-label">No DE FACTURA</label>
                    <input type="text" name="numero_factura" id="numero_factura" class="form-control"
                        {{--  value="{{ ($ultimaFactura->numero)+1 }}" required>  --}}
                        value="{{ ($ultimaFactura)+1 }}" required readonly>
                </div>
            </div>

            <div class="col-md-3">
                <label class="control-label">TIPO DE DOCUMENTO</label>
                <select name="tipo_documento" id="tipo_documento" class="form-control" required onchange="verificaNit()">
                    <option value="">SELECCIONE</option>
                    <option value="1">CEDULA DE IDENTIDAD</option>
                    <option value="2">CEDULA DE IDENTIDAD DE EXTRANJERO</option>
                    <option value="3">PASAPORTE</option>
                    <option value="4">OTRO DOCUMENTO DE IDENTIDAD</option>
                    <option value="5">NÚMERO DE IDENTIFICACIÓN TRIBUTARIA</option>
                </select>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">NIT/CEDULA</label>
                    {{--  <input type="text" name="persona_id" value="{{ $persona->id }}">  --}}
                    <input type="number" name="nit_factura" id="nit_factura" class="form-control" value="{{ $persona->nit }}" required onchange="verificaNit()">
                    <small style="display: none;" class="text-danger" id="nitnoexiste">NIT INVALIDO</small>
                    <small style="display: none;" class="text-success" id="nitsiexiste">NIT VALIDO</small>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">RAZON SOCIAL</label>
                    <input type="text" name="razon_factura" id="razon_factura" class="form-control"
                        value="{{ $persona->razon_social_cliente }}" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">TIPO DE FACTURACION</label>
                    <select name="tipo_facturacion" id="tipo_facturacion" class="form-control" required onchange="preguntaUsoCafc(this)">
                    <option value="online">EN LINEA</option>
                    <option value="offline">FUERA DE LINEA</option>
                </select>
                </div>
            </div>
            <div class="col-md-2" id="bloque_uso_cafc" style="display: none;">
                <label class="control-label">USO DEL CAFC?</label>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label ml-10" for="usocafc_no">No</label>
                            <input type="radio" name="uso_cafc" id="usocafc_no" checked value="no"  onclick="usoCafcFactura(this)">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="usocafc_si">Si</label>
                            <input type="radio" name="uso_cafc" id="usocafc_si"  value="si" onclick="usoCafcFactura(this)">
                            <input type="hidden" class="form-control" name="codigo_cafc_contingencia" id="codigo_cafc_contingencia">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="display: none" id="bloque_exepcion">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Enviar con execpcion?</label>
                    <input type="checkbox" name="execpcion" id="execpcion" class="form-control" required readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">&nbsp;</label>
                    <input type="button" class="btn btn-block btn-success" onclick="generaFacturaLinea()" value="ENVIAR FACTURA">
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">

    $(function () {
        $('#fecha_uso_cafc').datetimepicker({
            format: 'Y-m-d H:i:s',
        });
    });

    @php
        $jsonArray = json_encode($cuotasParaPagar);
    @endphp

    var arrayProductos = JSON.parse(@json($jsonArray))

    function validaCeros(ele){
        console.log(ele)
    }

    function muestraNit(){
        let persona_id = {{ $persona_id }};
          $.ajax({
            url: "{{ url('Factura/arrayCuotasPagar') }}",
            data: {
                persona: persona_id
            },
            dateType: 'json',
            type: 'POST',
            success: function(data) {
                if(data.estado === 'success'){
                    $("#bloqueNit").show('slow');
                    arrayProductos = JSON.parse(data.lista)

                    console.log(arrayProductos)
                }
            }
        });
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
