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
        @foreach ($facturas as $f)
        <tr>
            <td>{{ $f->id }}</td>
            <td>{{ $f->numero }}</td>
            <td>{{ $f->persona->cedula }}</td>
            <td>{{ $f->persona->nombres }}</td>
            <td>{{ $f->razon_social }}</td>
            <td>{{ $f->nit }}</td>
            <td>{{ $f->fecha }}</td>
            <td>{{ $f->total }}</td>
            <td>{{ $f->user->nombres }}</td>
            <td>
                @if ($f->facturado=='Si')
                <a href="{{ url("Factura/muestraFactura/$f->id") }}" class="btn btn-info text-white"
                    title="Muestra Factura"><i class="fas fa-eye"></i></a>
                @else
                <a href="{{ url("Factura/muestraRecibo/$f->id") }}" class="btn btn-primary text-white"
                    title="Muestra Recibo"><i class="fas fa-eye"></i></a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>