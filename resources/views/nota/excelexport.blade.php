<table>
    <thead>
        <th></th>
        <th>Nombres y Apellidos</th>
        <th>Asistencia</th>
        <th>Practicas</th>
        <th>Puntos Ganados</th>
        <th>Primer Parcial</th>
        <th>Examen Final</th>
        <th>Total</th>
    </thead>
    <tbody>
        @foreach($notas as $nota)
            <tr>
                <td width="5">{{ $nota->id }}</td>
                <td width="50">{{ $nota->persona->nombres }} {{ $nota->persona->apellido_paterno }} {{ $nota->persona->apellido_materno }}</td>
                <td width="10">{{ $nota->nota_asistencia }}</td>
                <td width="10">{{ $nota->nota_practicas }}</td>
                <td width="10">{{ $nota->nota_puntos_ganados }}</td>
                <td width="10">{{ $nota->nota_primer_parcial }}</td>
                <td width="10">{{ $nota->nota_examen_final }}</td>
                <td width="10">{{ $nota->nota_total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>