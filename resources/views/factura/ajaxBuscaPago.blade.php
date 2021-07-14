@if ($cobros->count() > 0)
<table id="tabla-pagos" class="table table-bordered table-striped text-center">
    <thead>
        <tr>
            <th>ID</th>
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
            <td>{{ $c->numero }}</td>
            <td>{{ $c->persona->cedula }}</td>
            <td>{{ $c->persona->nombres }}</td>
            <td>{{ $c->razon_social }}</td>
            <td>{{ $c->nit }}</td>
            <td>{{ $c->fecha }}</td>
            <td>{{ $c->total }}</td>
            <td>{{ $c->user->nombres }}</td>
            <td>
                @if ($c->facturado=='Si')
                <a href="{{ url("Factura/muestraFactura/$c->id") }}" class="btn btn-info text-white"
                    title="Muestra Factura"><i class="fas fa-eye"></i></a>
                @else
                <a href="{{ url("Factura/muestraRecibo/$c->id") }}" class="btn btn-primary text-white"
                    title="Muestra Recibo"><i class="fas fa-eye"></i></a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <h2 class="text-center text-danger">NO EXISTEN PAGOS</h2>
@endif