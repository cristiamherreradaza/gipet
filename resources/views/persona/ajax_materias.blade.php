{{-- {{ dd($materiasCarrera[0]->carrera) }} --}}
<div class="card card-outline-info">                                
    <div class="card-header">
        <h4 class="mb-0 text-white">CARRERA - ({{ $materiasCarrera[0]->carrera->nombre }}) </h4>
    </div>
    <div class="table-responsive m-t-40">
        @if ($materiasCarrera)
            <table id="tabla-ajax_asignaturas" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sigla</th>
                        <th>Nombre</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materiasCarrera as $mc)
                        <tr>
                            <td>{{ $mc->asignatura->codigo_asignatura }}</td>
                            <td>{{ $mc->asignatura->nombre_asignatura }}</td>
                            <td>
                                <button type="button" class="btn btn-warning" onclick="muestra_modal({{ $mc->id }})"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" onclick="elimina_asignatura('{{ $mc->id }}', '{{ $mc->nombre_asignatura }}')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        <p></p>
            <h2>La carrera no tiene asignaturas</h2>
        @endif
        
    </div>
</div>