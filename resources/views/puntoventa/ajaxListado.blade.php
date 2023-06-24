<div class="table-responsive m-t-40">
    <table id="tabla-usuarios" class="table table-striped table-bordered no-wrap table-hover">
        <thead>
            <tr>
                <th>CODIGO DE PUNTO DE VENTA</th>
                <th>NOMBRE DEL PUNTO DE VENTA</th>
                <th>TIPO PUNTO DE VENTA</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $puntos as $p)
                <tr>
                    <td>{{ $p['codigoPuntoVenta'] }}</td>
                    <td>{{ $p['nombrePuntoVenta'] }}</td>
                    <td>{{ $p['tipoPuntoVenta'] }}</td>
                    <td>
                        <button class="btn btn-danger btn-icon btn-sm" onclick="eliminaPuntoVenta('{{ $p['codigoPuntoVenta'] }}')"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>