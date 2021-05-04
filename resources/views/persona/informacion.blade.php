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

                <form action="{{ url('Persona/actualizar') }}" method="POST" id="formularioAlumno">
                    @csrf
                    <div class="row" id="tabsEstudiante">
                        <div class="col-md-4">
                            <button type="button" id="tab1" class="btn waves-effect waves-light btn-outline-info btn-block activo">DATOS
                                PERSONALES</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button" id="tab2" class="btn waves-effect waves-light btn-outline-info btn-block inactivo">DATOS
                                PROFESIONALES</button>
                        </div>
                        <div class="col-md-4">
                            <button type="button" id="tab3" class="btn waves-effect waves-light btn-outline-info btn-block inactivo">REFERENCIA
                                PERSONAL</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 tabContenido" id="tab1C">
                            <div class="card border-info">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Cedula de Identidad
                                                        <span class="text-danger">
                                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                                        </span>
                                                    </label>
                                                    <input type="text" class="form-control" name="carnet" id="carnet"
                                                        value="{{ $estudiante->cedula }}" required>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control" hidden name="persona_id" id="persona_id"
                                                value="{{ $estudiante->id }}">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Expedido
                                                        <span class="text-danger">
                                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                                        </span>
                                                    </label>
                                                    <select name="expedido" id="expedido" class="form-control">
                                                        <option value="La Paz" {{ $estudiante->expedido=='La Paz' ? 'selected' : '' }}>
                                                            La Paz</option>
                                                        <option value="Cochabamba"
                                                            {{ $estudiante->expedido=='Cochabamba' ? 'selected' : '' }}>Cochabamba
                                                        </option>
                                                        <option value="Santa Cruz"
                                                            {{ $estudiante->expedido=='Santa Cruz' ? 'selected' : '' }}>Santa Cruz
                                                        </option>
                                                        <option value="Oruro" {{ $estudiante->expedido=='Oruro' ? 'selected' : '' }}>
                                                            Oruro</option>
                                                        <option value="Potosi" {{ $estudiante->expedido=='Potosi' ? 'selected' : '' }}>
                                                            Potosi</option>
                                                        <option value="Tarija" {{ $estudiante->expedido=='Tarija' ? 'selected' : '' }}>
                                                            Tarija</option>
                                                        <option value="Sucre" {{ $estudiante->expedido=='Sucre' ? 'selected' : '' }}>
                                                            Sucre</option>
                                                        <option value="Beni" {{ $estudiante->expedido=='Beni' ? 'selected' : '' }}>Beni
                                                        </option>
                                                        <option value="Pando" {{ $estudiante->expedido=='Pando' ? 'selected' : '' }}>
                                                            Pando</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Apellido Paterno </label>
                                                    <input type="text" class="form-control" name="apellido_paterno"
                                                        id="apellido_paterno" value="{{ $estudiante->apellido_paterno }}">
                                                </div>
                                            </div>
                
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Apellido Materno </label>
                                                    <input type="text" class="form-control" name="apellido_materno"
                                                        id="apellido_materno" value="{{ $estudiante->apellido_materno }}">
                                                </div>
                                            </div>
                
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Nombres
                                                        <span class="text-danger">
                                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                                        </span>
                                                    </label>
                                                    <input type="text" class="form-control" name="nombres" id="nombres"
                                                        value="{{ $estudiante->nombres }}" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Fecha Nacimiento
                                                        <span class="text-danger">
                                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                                        </span>
                                                    </label>
                                                    <input type="date" class="form-control" name="fecha_nacimiento"
                                                        id="fecha_nacimiento" value="{{ $estudiante->fecha_nacimiento }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 tabContenido" id="tab2C" style="display: none;">
                            <div class="card border-info">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Email </label>
                                                    <input type="text" class="form-control" name="email" id="email" value="{{ $estudiante->email }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Direccion </label>
                                                    <input type="text" class="form-control" name="direccion" id="direccion"
                                                        value="{{ $estudiante->direccion }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Celular
                                                        <span class="text-danger">
                                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                                        </span>
                                                    </label>
                                                    <input type="text" class="form-control" name="telefono_celular" id="telefono_celular"
                                                        value="{{ $estudiante->numero_celular }}" required>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Genero
                                                        <span class="text-danger">
                                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                                        </span>
                                                    </label>
                                                    <select name="sexo" id="sexo" class="form-control" required>
                                                        <option value="Masculino" {{ $estudiante->sexo=='Masculino' ? 'selected' : '' }}>Masculino</option>
                                                        <option value="Femenino" {{ $estudiante->sexo=='Femenino' ? 'selected' : '' }}>
                                                            Femenino</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="control-label">Trabaja
                                                        <span class="text-danger">
                                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                                        </span>
                                                    </label>
                                                    <select class="form-control" id="trabaja" name="trabaja" required>
                                                        <option value="Si" {{ $estudiante->trabaja=='Si' ? 'selected' : '' }}>Si
                                                        </option>
                                                        <option value="No" {{ $estudiante->trabaja=='No' ? 'selected' : '' }}>No
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Nombre de la Empresa</label>
                                                    <input type="text" id="empresa" class="form-control" name="empresa"
                                                        value="{{ $estudiante->empresa }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Direcci&oacute;n</label>
                                                    <input type="text" id="direccion_empresa" class="form-control"
                                                        name="direccion_empresa" value="{{ $estudiante->direccion_empresa }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Telefono</label>
                                                    <input type="text" id="telefono_empresa" class="form-control"
                                                        name="telefono_empresa" value="{{ $estudiante->numero_empresa }}">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="form-group">
                                                    <label class="control-label">Fax</label>
                                                    <input type="text" id="fax" class="form-control" name="fax"
                                                        value="{{ $estudiante->fax }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label">Email Empresa</label>
                                                    <input type="email" id="email_empresa" class="form-control" name="email_empresa"
                                                        value="{{ $estudiante->email_empresa }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 tabContenido" id="tab3C" style="display: none;">
                            <div class="card border-info">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Nombre Padre </label>
                                                    <input type="text" class="form-control" name="nombre_padre" id="nombre_padre"
                                                        value="{{ $estudiante->nombre_padre }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Celular Padre </label>
                                                    <input type="text" class="form-control" name="celular_padre" id="celular_padre"
                                                        value="{{ $estudiante->celular_padre }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Nombre Madre </label>
                                                    <input type="text" class="form-control" name="nombre_madre" id="nombre_madre"
                                                        value="{{ $estudiante->nombre_madre }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Celular Madre </label>
                                                    <input type="text" class="form-control" name="celular_madre" id="celular_madre"
                                                        value="{{ $estudiante->celular_madre }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Nombre Tutor </label>
                                                    <input type="text" class="form-control" name="nombre_tutor" id="nombre_tutor"
                                                        value="{{ $estudiante->nombre_tutor }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Celular Tutor </label>
                                                    <input type="text" class="form-control" name="telefono_tutor" id="telefono_tutor"
                                                        value="{{ $estudiante->celular_tutor }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Nombre Esposo </label>
                                                    <input type="text" class="form-control" name="nombre_esposo" id="nombre_esposo"
                                                        value="{{ $estudiante->nombre_pareja }}">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Celular Esposo </label>
                                                    <input type="text" class="form-control" name="telefono_esposo" id="telefono_esposo"
                                                        value="{{ $estudiante->celular_pareja }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizaPerfilEstudiante();">ACTUALIZAR PERFIL</button>
                        </div>
                        {{-- <div class="col-md-6">
                            <a href="{{ url('Persona/listado') }}" type="button"
                                class="btn waves-effect waves-light btn-block btn-inverse">Volver</a>
                        </div> --}}
                    </div>
                </form>

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
                                                {{-- <button type="button" class="btn btn-info" title="Ver detalle" onclick="ajaxMuestraInscripcion('{{ $inscripcion->id }}')"><i class="fas fa-eye"></i></button> --}}
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

    // Tabs para Informacion Personal del Estudiante
    $('#tabsEstudiante div .btn').click(function () {
        var t = $(this).attr('id');
        if ($(this).hasClass('inactivo')) { //preguntamos si tiene la clase inactivo 
            $('#tabsEstudiante div .btn').addClass('inactivo');
            $(this).removeClass('inactivo');

            $('.tabContenido').hide();
            $('#' + t + 'C').fadeIn('slow');
        }
    });

    function actualizaPerfilEstudiante()
    {
        if ($("#formularioAlumno")[0].checkValidity()) {

            let datosAlumno = $("#formularioAlumno").serializeArray();
            console.log(datosAlumno);

            $.ajax({
                url: "{{ url('Persona/actualizar') }}",
                data: datosAlumno,
                type: 'POST',
                success: function(data) {
                    Swal.fire(
                        'Excelente!',
                        'Datos del alumno actualizados',
                        'success'
                    );
                }
            });

        }else{
            $("#formularioAlumno")[0].reportValidity();
        }
    }

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