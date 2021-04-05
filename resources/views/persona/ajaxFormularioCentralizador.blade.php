{{-- <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet"> --}}

<table id="tablaAlumnosAjax" class="table table-bordered table-striped table-hover" border="1">
    <thead>
    <tr>
        <th style="font-size: 10pt;">Paterno</th>
        <th style="font-size: 10pt;">Materno</th>
        <th style="font-size: 10pt;">Nombres</th>
        <th style="font-size: 10pt;">Carnet</th>
        @foreach ($materiasCarrera as $mc)
        <th style="font-size: 8pt;">
            {{ $mc->nombre }}<br /> {{ $mc->sigla }}
        </th>
        @endforeach
        <th>Estado</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @php
        $contador = 0;
    @endphp
    @foreach ($nominaEstudiantes as $k => $ne)
    <tr>
        <td>{{ $ne->persona->apellido_paterno }}</td>
        <td>{{ $ne->persona->apellido_materno }}</td>
        <td>{{ $ne->persona->nombres }}</td>
        <td>{{ $ne->persona->cedula }}</td>
        @foreach ($materiasCarrera as $mc)
            @php
                $nota = App\Inscripcione::where('persona_id', $ne->persona_id)
                ->where('carrera_id', $carrera)
                ->where('paralelo', $paralelo)
                ->where('anio_vigente', $gestion)
                ->where('asignatura_id', $mc->id)
                ->first();
        
                $estado = App\CarrerasPersona::where('persona_id', $ne->persona_id)
                ->where('carrera_id', $carrera)
                ->where('anio_vigente', $gestion)
                ->first();
            @endphp
            <td>
                <form action="{{ url('Persona/ajaxGuardaNota') }}" id="formulario_{{ $contador }}">
                    
                    @csrf
                    <input type="hidden" name="inscripcion_id" id="inscripcion_id" value="{{ $nota['id'] }}">
                @if ($nota != null)
                    <input type="number" style="width: 80px;" class="form-control" name="nota" id="nota" value="{{ intval($nota->nota) }}" onchange="enviaDatos({{ $contador }})">
                    <small id="msg_{{ $contador }}" class="form-control-feedback text-success" style="display: none;">Guardado</small>
                @else
                    <input type="number" style="width: 80px;" class="form-control" name="nota" id="nota" value="0" onchange="enviaDatos({{ $contador }})">
                @endif
                </form>
            </td>
            @php
                $contador++;
            @endphp
        @endforeach
        <td>
            <select name="estado_inscripcion_{{ $ne->persona_id }}" id="estado_inscripcion_{{ $ne->persona_id }}" class="form-control custom-select" onchange="cambiaEstado('{{ $ne->persona_id }}');">
                <option value=""></option>
                <option value="APROBO" {{ (($estado->estado == 'APROBO') ? 'selected' : '') }}>APROBO</option>
                <option value="REPROBO" {{ (($estado->estado == 'REPROBO') ? 'selected' : '') }}>REPROBO</option>
                <option value="CONGELADO" {{ (($estado->estado == 'CONGELADO') ? 'selected' : '') }}>CONGELADO</option>
                <option value="ABANDONO" {{ (($estado->estado == 'ABANDONO') ? 'selected' : '') }}>ABANDONO</option>
            </select>
            <small id="select_{{ $ne->persona_id }}" class="form-control-feedback text-success" style="display: none;">Guardado</small>
        </td>
        <td>
            <button onclick="elimina('{{ $ne->persona_id }}', '{{ $ne->persona->cedula }}')" type="button" class="btn btn-danger" title="Eliminar Estudiante"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>

{{-- <script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js') }}"></script> --}}

<script>
    $(function () {
        $('#tablaAlumnosAjax').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });
</script>
