@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            CARRERAS &nbsp;&nbsp;
        </h4>
    </div>
        <div class="card-body">
        <form action="#" method="POST" id="formulario_gestion">
            @csrf
            <div class="row">
                
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">Gestion </label>
                        <input type="number" name="gestion" id="gestion" class="form-control"
                            value="{{ date('Y') }}" min="2011" max="{{ date('Y') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <br>
                    <button type="button" class="btn btn-info" title="Ir gestion" onclick="cambiaGestion()">Cambia Gestion</button>
                </div>
            </div>
        </form>

            <div class="row">
                <div class="col-md-12" id="ajax_carreras">
                    <div class="table-responsive">
                        <table id="carreras" class="table table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>CARRERA</th>
                                    <th>MATERIA</th>
                                    <th class="text-center">PARALELO</th>
                                    <th>TURNO</th>
                                    <th>A&Nacute;O</th>
                                    <th class="text-center">1 BIM</th>
                                    <th class="text-center">2 BIM</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carrerasNotasPropuestas as $c)
                                    @php
                                        $primerBimestre = App\Nota::where('carrera_id', $c->carrera_id)
                                                                ->where('asignatura_id', $c->asignatura_id)
                                                                ->where('paralelo', $c->paralelo)
                                                                ->where('turno_id', $c->turno_id)
                                                                ->where('gestion', $c->gestion)
                                                                ->where('anio_vigente', $c->anio_vigente)
                                                                ->where('trimestre', 1)
                                                                ->where('finalizado', 'Si')
                                                                ->first();

                                        $segundoBimestre = App\Nota::where('carrera_id', $c->carrera_id)
                                                                ->where('asignatura_id', $c->asignatura_id)
                                                                ->where('paralelo', $c->paralelo)
                                                                ->where('turno_id', $c->turno_id)
                                                                ->where('gestion', $c->gestion)
                                                                ->where('anio_vigente', $c->anio_vigente)
                                                                ->where('trimestre', 2)
                                                                ->where('finalizado', 'Si')
                                                                ->first();

                                        // dd($segundoBimestre);

                                    @endphp
                                    <tr>
                                        <td>{{ $c->carrera['nombre'] }}</td>
                                        <td>{{ $c->asignatura['nombre'] }}</td>
                                        <td class="text-center">{{ $c->paralelo }}</td>
                                        <td>{{ $c->turno->descripcion }}</td>
                                        <td>{{ $c->gestion }}&deg; a&ntilde;o</td>
                                        <td class="text-center">
                                            @if ($primerBimestre)
                                                <a href="{{ url("Carrera/actualizaCierraNotas/$c->carrera_id/$c->paralelo/$c->turno_id/$c->gestion/$c->anio_vigente/abierto/1/$c->asignatura_id") }}" type="button" class="btn waves-effect waves-light btn-danger">CERRADO</a>
                                            @else
                                                <a href="{{ url("Carrera/actualizaCierraNotas/$c->carrera_id/$c->paralelo/$c->turno_id/$c->gestion/$c->anio_vigente/cerrado/1/$c->asignatura_id") }}" type="button" class="btn waves-effect waves-light btn-success">ABIERTO</a>

                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($segundoBimestre)
                                                <a href="{{ url("Carrera/actualizaCierraNotas/$c->carrera_id/$c->paralelo/$c->turno_id/$c->gestion/$c->anio_vigente/abierto/2/$c->asignatura_id") }}" type="button" class="btn waves-effect waves-light btn-danger">CERRADO</a>
                                            @else
                                                <a href="{{ url("Carrera/actualizaCierraNotas/$c->carrera_id/$c->paralelo/$c->turno_id/$c->gestion/$c->anio_vigente/cerrado/2/$c->asignatura_id") }}" type="button" class="btn waves-effect waves-light btn-success">ABIERTO</a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- inicio modal prerequisitos -->

<!-- fin modal prerequisitos -->

@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script>
    $.ajaxSetup({
        // definimos cabecera donde estara el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('#carreras').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });

        $('#ajax-materias').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });


    });

    function cambiaGestion()
    {
        let datos_formulario = $("#formulario_gestion").serializeArray();  

        $.ajax({
            url: "{{ url('Carrera/ajaxCambiaGestion') }}",
            method: "POST",
            data: datos_formulario,
            success: function (data) {
                $("#ajax_carreras").html(data);
            }
        })

    }

</script>
@endsection