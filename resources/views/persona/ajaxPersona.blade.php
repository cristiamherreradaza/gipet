@if ($persona != null)
    <div class="table-responsive">
        <input type="hidden" >
        <table class="table no-wrap">
            <thead>
                <tr>
                    <th>Carnet</th>
                    <th>Ap Peterno</th>
                    <th>Ap Meterno</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $persona->cedula }}</td>
                    <td>{{ $persona->apellido_paterno }}</td>
                    <td>{{ $persona->apellido_materno }}</td>
                    <td>{{ $persona->nombres }}</td>
                    <td><button type="submit" class="btn btn-block btn-success">INSCRIBIR</button></td>
                </tr>
            </tbody>
        </table>
    </div>
@else
    <p>&nbsp;</p>
    <h3 class="text-danger">No se encontro a la persona</h3>
@endif