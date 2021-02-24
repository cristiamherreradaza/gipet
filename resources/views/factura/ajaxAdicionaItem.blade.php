<table class="tablesaw table-striped table-hover table-bordered table no-wrap">
    <thead>
        <tr>
            <th>Cantidad</th>
            <th>Descripcion</th>
            <th>Carrera</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cuotasParaPagar as $cpp)
            <tr>
                <td>1</td>
                <td>{{ $cpp->mensualidad }}</td>
                <td>{{ $cpp->carrera->nombre }}</td>
                <td>{{ $cpp->a_pagar }}</td>
            </tr>
        @endforeach
    </tbody>
</table>