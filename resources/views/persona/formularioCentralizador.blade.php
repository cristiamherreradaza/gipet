@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-info">
            <div class="card-header bg-info">
                <h4 class="mb-0 text-white">REGULARIZA CENTRALIZADOR DE NOTAS</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col"><h3><span class="text-info">Carrera: </span> {{ $datosCarrera->nombre }}</h3></div>
                    <div class="col"><h3><span class="text-info">Curso: </span> {{ $curso }}° A&ntilde;o</h3></div>
                    <div class="col"><h3><span class="text-info">Turno: </span> {{ $datosTurno->descripcion }}</h3></div>
                </div>
                <div class="row">
                    <div class="col"><h3><span class="text-info">Paralelo: </span> {{ $paralelo }}</h3></div>
                    <div class="col"><h3><span class="text-info">Gestion: </span> {{ $gestion }}</h3></div>
                </div>
                <br>
                <div class="table-responsive m-t-40">
                    <table id="tablaAlumnos" class="table table-bordered table-striped table-hover" border="1">
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
                                        <input type="hidden" name="persona_id" id="persona_id" value="{{ $ne->persona->id }}">
                                        <input type="hidden" name="turno_id" id="turno_id" value="{{ $ne->turno_id }}">
                                        <input type="hidden" name="paralelo" id="paralelo" value="{{ $ne->paralelo }}">
                                        <input type="hidden" name="asignatura_id" id="asignatura_id" value="{{ $nota['asignatura_id'] }}">
                                        <input type="hidden" name="anio_vigente" id="anio_vigente" value="{{ $nota['anio_vigente'] }}">
                                    @if ($nota)
                                        <input type="number" style="width: 80px;" class="form-control" name="nota" id="nota" value="{{ intval($nota->nota) }}" onchange="enviaDatos({{ $contador }})">
                                    @else
                                        <input type="number" style="width: 80px;" class="form-control" name="nota" id="nota" value="0">
                                    @endif
                                    </form>
                                </td>
                                @php
                                    $contador++;
                                @endphp
                            @endforeach
                            <td>{{ $estado->estado }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js') }}"></script>

<script>
    $(function () {
        $('#tablaAlumnos').DataTable();
    });

function enviaDatos(numero) {
    let formulario = $("#formulario_"+numero).serializeArray();

    $.ajax({
        type: "POST",
        url: "{{ url('Persona/ajaxGuardaNota') }}",
        data: formulario, // serializes the form's elements.
        success: function (data) {
            // alert(data); // show response from the php script.
        }
    });
}
</script>
@endsection