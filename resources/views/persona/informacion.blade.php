@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
<style>

    /* these styles are for the demo, but are not required for the plugin */
    .zoom {
        display: inline-block;
        position: relative;
        cursor: zoom-in;
    }

    /* magnifying glass icon */
    .zoom:after {
        content: '';
        display: block;
        width: 33px;
        height: 33px;
        position: absolute;
        top: 0;
        right: 0;
        background: url(icon.png);
    }

    .zoom img {
        display: block;
    }

    .zoom img::selection {
        background-color: transparent;
    }

</style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header bg-info">
                <h4 class="mb-0 text-white">INFORMACION DEL ESTUDIANTE</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3"><h3><span class="text-info"> Ap. Paterno:</span> {{ $estudiante->apellido_paterno }}</h3></div>
                    <div class="col-md-3"><h3><span class="text-info"> Ap. Materno:</span> {{ $estudiante->apellido_materno }}</h3></div>
                    <div class="col-md-3"><h3><span class="text-info"> Nombres:</span> {{ $estudiante->nombres }}</h3></div>
                    <div class="col-md-3"><h3><span class="text-info"> Carnet:</span> {{ $estudiante->cedula }}</h3></div>
                </div>
                <div class="row">
                    <col-md-6></col-md-6>
                    <col-md-6></col-md-6>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if ($inscripciones->count()>0)
                        <p>&nbsp;</p>

                        <h2 class="text-center text-dark-inverse"><strong>INSCRIPCIONES</strong></h2>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover no-wrap text-center" id="tablaProductosEncontrados">
                                <thead class="bg-inverse text-white">
                                    <tr>
                                        <th>#</th>
                                        <th>Carrera</th>
                                        <th>Fecha</th>
                                        <th>Curso</th>
                                        <th>Turno</th>
                                        <th>Paralelo</th>
                                        <th>Gestion</th>
                                        <th>Estado</th>
                                        <th class="text-nowrap"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inscripciones as $key => $inscripcion)
                                        <tr>
                                            <td>{{ ($key+1) }}</td>
                                            <td class="text-left">{{ $inscripcion->carrera->nombre }}</td>
                                            <td>{{ $inscripcion->fecha_inscripcion }}</td>
                                            <td>{{ $inscripcion->gestion }}&ordm; A&ntilde;o</td>
                                            <td>{{ $inscripcion->turno->descripcion }}</td>
                                            <td>{{ $inscripcion->paralelo }}</td>
                                            <td>{{ $inscripcion->anio_vigente }}</td>
                                            <td>{{ $inscripcion->estado }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info" title="Ver detalle" onclick="ajaxMuestraInscripcion('{{ $inscripcion->id }}')"><i class="fas fa-eye"></i></button>
                                                <!-- <button type="button" class="btn btn-warning" title="Editar Inscripcion" onclick="ajaxEditaInscripcion('{{ $inscripcion->id }}')"><i class="fas fa-book"></i></button> -->
                                                <a class="btn btn-light" title="Descargar Boletin" href="{{ url('Inscripcion/boletin/'.$inscripcion->id) }}" target="_blank"><i class="fas fa-file-pdf"></i></a>
                                                <button type="button" class="btn btn-danger" title="Eliminar Inscripcion" onclick="ajaxEliminaInscripcion('{{ $inscripcion->persona_id }}', '{{ $inscripcion->carrera_id }}', '{{ $inscripcion->turno_id }}', '{{ $inscripcion->paralelo }}', '{{ $inscripcion->gestion }}', '{{ $inscripcion->anio_vigente }}', '{{ $inscripcion->carrera->nombre }}')"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <p>&nbsp;</p>
                            <h2 class="text-center text-info">NO TIENE INSCRIPCIONES</h2>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn waves-effect waves-light btn-block btn-primary" onclick="muestraFormularioInscripcion()">NUEVA INSCRIPCION</button>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ url('Persona/listado') }}" type="button" class="btn waves-effect waves-light btn-block btn-inverse">VOLVER</a>
                    </div>
                </div>
                <form action="#" method="POST" id="formularioInscripcion">
                    <div class="row" id="bloqueInscripcion" style="display: none;">
                        
                        <p>&nbsp;</p>

                        <div class="col-md-12"><h3 class="text-info">Formulario de Inscripcion</h3></div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Carrera
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <input type="hidden" name="persona_id" value="{{ $estudiante->id }}">
                                <select class="form-control custom-select" id="carrera_id" name="carrera_id" onchange="cambiaCarrera()" required>
                                    @foreach($carreras as $carrera)
                                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Curso
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" id="gestion" name="gestion" required>
                                    <option value="1">1&ordm; A&ntilde;o</option>
                                    <option value="2">2&ordm; A&ntilde;o</option>
                                    <option value="3">3&ordm; A&ntilde;o</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Turno
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" id="turno_id" name="turno_id" required>
                                    @foreach($turnos as $turno)
                                        <option value="{{ $turno->id }}">{{ $turno->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Paralelo
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" id="paralelo" name="paralelo" required>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="control-label">Gesti&oacute;n</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="number" class="form-control" id="anio_vigente" name="anio_vigente" value="{{ date('Y') }}"
                                    required>
                            </div>
                        </div>                        
                        <div class="col-md-2">
                            <label class="control-label">&nbsp;</label>
                            <button type="button" class="btn waves-effect waves-light btn-block btn-success" onclick="ajaxInscribeAlumno()">INSCRIBIR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/forms/select2/select2.init.js') }}"></script>
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/jquery.zoom.js') }}"></script>
<script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/jquery.repeater/repeater-init.js') }}"></script>
<script>
    // Funcion donde definimos cabecera donde estara el token y poder hacer nuestras operaciones de put,post...
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function muestraFormularioInscripcion()
    {
        $("#bloqueInscripcion").toggle('slow');
    }

    function ajaxInscribeAlumno()
    {
        Swal.fire(
            'Excelente!',
            'El alumno fue inscrito',
            'success'
        );

        let formulario = $("#formularioInscripcion").serializeArray();

        $.ajax({
            type: "POST",
            url: "{{ url('Persona/ajaxInscribeAlumno') }}",
            data: formulario,
            success: function (data) {
                location.reload()
            }
        });
    }

    function ajaxEliminaInscripcion(alumno_id, carrera, turno, paral, ges, anio, carrera_nombre)
    {
        let persona_id   = alumno_id;
        let carrera_id   = carrera;
        let gestion      = ges;
        let turno_id     = turno;
        let paralelo     = paral;
        let anio_vigente = anio;

        Swal.fire({
            title: 'Estas seguro de eliminar '+carrera_nombre+' '+gestion+'&ordm; A&ntilde;o del '+anio_vigente+' ?',
            text: "Luego no podras recuperarlo!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Excelente!',
                    'La inscripcion fue eliminada',
                    'success'
                );

                $.ajax({
                    type: "POST",
                    url: "{{ url('Persona/ajaxEliminaInscripcionAlumno') }}",
                    data: {
                            persona_id: persona_id,
                            carrera_id: carrera_id,
                            gestion: gestion,
                            turno_id: turno_id,
                            paralelo: paralelo,
                            anio_vigente: anio_vigente,
                        },
                    success: function (data) {
                        location.reload();
                    }
                });

            }
        })

    }
    
</script>
@endsection