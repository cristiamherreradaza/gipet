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
            <td>{{ $c->user->nombres }}</td>
            <td>
                @if ($c->facturado=='Si')

                    @if ($c->estado == 'Anulado')
                        <a href="#" class="btn btn-danger text-white" title="Factura Anulada"><i class="fas fa-eye"></i></a>
                    @else
                        <a href="{{ url("Factura/muestraFactura/$c->id") }}" class="btn btn-info text-white" title="Muestra Factura"><i class="fas fa-eye"></i></a>
                    @endif

                @else
                    @if ($c->estado == 'Anulado')
                        <a href="#" class="btn btn-danger text-white" title="Factura Anulada"><i class="fas fa-eye"></i></a>
                    @else
                        <a href="{{ url("Factura/muestraRecibo/$c->id") }}" class="btn btn-primary text-white" title="Muestra Recibo"><i class="fas fa-eye"></i></a>
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