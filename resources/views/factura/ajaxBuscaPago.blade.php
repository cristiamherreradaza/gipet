@if ($cobros->count() > 0)
<table id="tabla-ajax-pagos" class="table table-bordered table-striped text-center">
    <thead>
        <tr>
            <th>ID</th>
            <th>TIPO</th>
            <th>NUMERO</th>
            <th>CARNET</th>
            <th>ESTUDIANTE</th>
            <th>RAZON</th>
            <th>NIT</th>
            <th>FECHA</th>
            <th>MONTO</th>
            <th>ESTADO</th>
            <th>ESTADO SIAT</th>
            <th>EMISION</th>
            <th>USUARIO</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cobros as $c)
        <tr>
            <td>{{ $c->id }}</td>
            <td>
                @if ($c->facturado == 'Si')
                    <span class="text-info">FACTURA</span>
                @else
                    <span class="text-primary">RECIBO</span>
                @endif
            </td>
            <td>
                @if ($c->facturado == 'Si')
                    <span class="text-info">{{ $c->numero }}</span>
                @else
                    <span class="text-primary">{{ $c->numero_recibo }}</span>

                @endif
            </td>
            <td>{{ $c->persona->cedula }}</td>
            <td>{{ $c->persona->nombres }}</td>
            <td>{{ $c->razon_social }}</td>
            <td>{{ $c->nit }}</td>
            <td>{{ $c->fecha }}</td>
            <td>{{ $c->total }}</td>
            <td>
                @if ($c->estado === "Anulado")
                    <span class="badge badge-danger">ANULADO</span>
                @else
                    <span class="badge badge-success">VIGENTE</span>
                @endif
            </td>
            <td>
                @php
                    if($c->codigo_descripcion == "VALIDADA"){
                        $text = "badge badge-success";
                    }elseif($c->codigo_descripcion == "PENDIENTE"){
                        $text = "badge badge-warning";
                    }else{
                        $text = "badge badge-danger";
                    }
                @endphp
                <span class="{{ $text }}" >{{ $c->codigo_descripcion }}</span>
            </td>
            <td>
                @if ($c->tipo_factura === "online")
                    <span class="badge badge-success" >Linea</span>
                @elseif($c->tipo_factura === "offline")
                    <span class="badge badge-warning text-white" >Fuera de Linea</span>
                @endif
            </td>
            <td>{{ $c->user->nombres }}</td>
            <td>
                @if ($c->productos_xml != null)
                    <a class="btn btn-info" href="{{ url('Factura/generaPdfFacturaNew', [$c->id]) }}" target="_blank"><i class="fa fa-file-pdf"></i></a>
                @endif

                @if($f->facturado === "Si")
                    @if ($c->uso_cafc === "si")
                        <a href="https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=178436029&cuf={{ $c->cuf }}&numero={{ $c->numero_cafc }}&t=2" target="_blank" class="btn btn-dark btn-icon btn-sm"><i class="fa fa-file"></i></a>
                    @else
                        <a href="https://pilotosiat.impuestos.gob.bo/consulta/QR?nit=178436029&cuf={{ $c->cuf }}&numero={{ $c->numero }}&t=2" target="_blank" class="btn btn-dark btn-icon btn-sm"><i class="fa fa-file"></i></a>
                    @endif
                @endif

                @if ($c->estado != 'Anulado')
                    @if($c->tipo_factura === "online")
                        @if ($c->productos_xml != null)
                            <button class="btn btn-danger btn-icon" onclick="modalAnularFactura('{{ $c->id }}')"><i class="fa fa-trash"></i></button>
                        @endif
                    @else
                        @if($f->facturado === "Si")
                            @if($c->codigo_descripcion != 'VALIDADA' && $c->codigo_descripcion != 'PENDIENTE')
                                <button class="btn btn-dark btn-icon" onclick="modalRecepcionFacuraContingenciaFueraLinea('{{ $c->id }}')"><i class="fa fa-upload" aria-hidden="true"></i></button>
                            @else
                                <button class="btn btn-danger btn-icon" onclick="modalAnularFactura('{{ $c->id }}')"><i class="fa fa-trash"></i></button>
                            @endif
                        @endif
                    @endif
                @endif

                @if ($c->productos_xml == null)
                    @if ($c->facturado=='Si')

                        @if ($c->estado != 'Anulado')
                            <a href="{{ url("Factura/muestraFactura/$c->id") }}" class="btn btn-info text-white" title="Muestra Factura"><i class="fas fa-eye"></i></a>
                        @else
                            {{--  <a href="#" class="btn btn-danger text-white" title="Factura Anulada"><i class="fas fa-eye"></i></a>  --}}
                        @endif

                    @else
                        @if ($c->estado != 'Anulado')
                            <a href="{{ url("Factura/muestraRecibo/$c->id") }}" class="btn btn-primary text-white" title="Muestra Recibo"><i class="fas fa-eye"></i></a>
                        @else
                            {{--  <a href="#" class="btn btn-danger text-white" title="Factura Anulada"><i class="fas fa-eye"></i></a>  --}}
                        @endif

                    @endif
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <h2 class="text-center text-danger">NO EXISTEN PAGOS</h2>
@endif
<script type="text/javascript">
    $(function () {
        $('#tabla-ajax-pagos').DataTable({
            order: [[ 0, "desc" ]],
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
            searching: false,
            lengthChange: false,
            order: [[ 0, "desc" ]]

        });
    });

</script>
