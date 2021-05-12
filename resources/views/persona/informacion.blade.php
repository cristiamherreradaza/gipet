@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
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

            {{-- tab alumno --}}
            <form action="{{ url('Persona/actualizar') }}" method="POST" id="formularioAlumno">
                @csrf
                <ul class="nav nav-tabs nav-justified nav-bordered mb-3 customtab">
                    <li class="nav-item">
                        <a href="#home-b2" data-toggle="tab" aria-expanded="false" class="nav-link active">
                            <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">DATOS PERSONALES</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#profile-b2" data-toggle="tab" aria-expanded="true" class="nav-link">
                            <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">DATOS PROFESIONALES</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#settings-b2" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                            <span class="d-none d-lg-block">REFERENCIAS PERSONALES</span>
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="home-b2">
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
                    <div class="tab-pane" id="profile-b2">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Email </label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        value="{{ $estudiante->email }}">
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
                                    <input type="text" class="form-control" name="telefono_celular"
                                        id="telefono_celular" value="{{ $estudiante->numero_celular }}" required>
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
                                        <option value="Masculino"
                                            {{ $estudiante->sexo=='Masculino' ? 'selected' : '' }}>
                                            Masculino</option>
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
                    <div class="tab-pane" id="settings-b2">
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

                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn waves-effect waves-light btn-block btn-success"
                            onclick="actualizaPerfilEstudiante();">ACTUALIZAR PERFIL</button>
                    </div>
                    {{-- <div class="col-md-6">
                                        <a href="{{ url('Persona/listado') }}" type="button"
                    class="btn waves-effect waves-light btn-block btn-inverse">Volver</a>
                </div> --}}
                </div>
            </form>
            {{-- fin tab alumno --}}

            <br />

            {{-- tabs datos alumno --}}
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                <li class="nav-item">
                    <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                        <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                        <span class="d-none d-lg-block">INSCRIPCIONES</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#profile1" data-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                        <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                        <span class="d-none d-lg-block">MATERIAS</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#settings1" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                        <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                        <span class="d-none d-lg-block">Settings</span>
                    </a>
                </li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane show active" id="home1">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($carrerasPersona->count()>0)

                            <div class="table-responsive">
                                <table class="table table-striped table-hover no-wrap text-center">
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
                                        @foreach($carrerasPersona as $key => $cp)
                                        <tr>
                                            <td>{{ ($key+1) }}</td>
                                            <td class="text-left">{{ $cp->carrera->nombre }}</td>
                                            <td>{{ $cp->fecha_inscripcion }}</td>
                                            <td>{{ $cp->gestion }}&ordm; A&ntilde;o</td>
                                            <td>{{ $cp->turno->descripcion }}</td>
                                            <td>{{ $cp->paralelo }}</td>
                                            <td>{{ $cp->anio_vigente }}</td>
                                            <td>{{ $cp->estado }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info" title="Ver materias"
                                                    onclick="ajaxVerMaterias('{{ $cp->persona_id }}', '{{ $cp->carrera_id }}', '{{ $cp->turno_id }}', '{{ $cp->paralelo }}', '{{ $cp->gestion }}', '{{ $cp->anio_vigente }}')"><i
                                                        class="fas fa-clipboard-list"></i></button>

                                                <a class="btn btn-light" title="Descargar Boletin"
                                                    href="{{ url('Inscripcion/boletin/'.$cp->id) }}" target="_blank"><i
                                                        class="fas fa-file-pdf"></i></a>
                                                <button type="button" class="btn btn-danger"
                                                    title="Eliminar Inscripcion"
                                                    onclick="ajaxEliminaInscripcion('{{ $cp->persona_id }}', '{{ $cp->carrera_id }}', '{{ $cp->turno_id }}', '{{ $cp->paralelo }}', '{{ $cp->gestion }}', '{{ $cp->anio_vigente }}', '{{ $cp->carrera->nombre }}')"><i
                                                        class="fas fa-trash-alt"></i></button>
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
                </div>
                <div class="tab-pane" id="profile1">
                    <div class="table-responsive m-t-40">
                        <table class="table table-striped table-bordered no-wrap table-hover text-inputs-searching">
                            <thead>
                                <tr>
                                    <th>Carrera</th>
                                    <th>Materia</th>
                                    <th class="text-center">Sigla</th>
                                    <th class="text-center">Curso</th>
                                    <th class="text-center">Turno</th>
                                    <th class="text-center">Paralelo</th>
                                    <th class="text-center">Gestion</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materiasInscripcion as $m)
                                <tr>
                                    <td>{{ $m->carrera->nombre }}</td>
                                    <td>{{ $m->asignatura->nombre }}</td>
                                    <td class="text-center">{{ $m->asignatura->sigla }}</td>
                                    <td class="text-center">{{ $m->gestion }}</td>
                                    <td class="text-center">{{ $m->turno->descripcion }}</td>
                                    <td class="text-center">{{ $m->paralelo }}</td>
                                    <td class="text-center">{{ $m->anio_vigente }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" title="Editar carrera" onclick="edita_carrera()"><i class="fas fa-edit"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Carrera</th>
                                    <th>Materia</th>
                                    <th>Sigla</th>
                                    <th>Curso</th>
                                    <th>Turno</th>
                                    <th>Paralelo</th>
                                    <th>Gestion</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="tab-pane" id="settings1">
                    <p>Food truck quinoa dolor sit amet, consectetuer adipiscing elit. Aenean
                        commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et
                        magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis,
                        ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa
                        quis enim.</p>
                    <p class="mb-0">Donec pede justo, fringilla vel, aliquet nec, vulputate eget,
                        arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam
                        dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus
                        elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula,
                        porttitor eu, consequat vitae, eleifend ac, enim.</p>
                </div>
            </div>

            {{-- fin tabs datos alumno --}}

                
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
{{-- modal acciones --}}
<div id="modal-notas" class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Extra Large modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body" id="ajaxContenidoMaterias">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{-- fin modal acciones --}}
@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/datatable-api.init.js') }}"></script>
<script>
    // Funcion donde definimos cabecera donde estara el token y poder hacer nuestras operaciones de put,post...
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Funcion que establece la configuracion para el datatable
    $(function () {
        // Setup - add a text input to each footer cell
        /*$('#tabla-materias thead th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" class="form-control" placeholder="Buscar '+title+'" />' );
        } );
    
        // DataTable
        var table = $('#tabla-materias').DataTable({
            initComplete: function () {
                // Apply the search
                this.api().columns().every( function () {
                    var that = this;
    
                    $( 'input', this.footer() ).on( 'keyup change clear', function () {
                        if ( that.search() !== this.value ) {
                            that
                                .search( this.value )
                                .draw();
                        }
                    } );
                } );
            }
        });*/

        /*$('#tabla-materias').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });*/
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

    function ajaxVerMaterias(alumno_id, carrera, turno, paral, ges, anio)
    {
        let persona_id   = alumno_id;
        let carrera_id   = carrera;
        let gestion      = ges;
        let turno_id     = turno;
        let paralelo     = paral;
        let anio_vigente = anio;

        $("#modal-notas").modal("show");
        // console.log(inscripcionId);
        $.ajax({
            type: "POST",
            url: "{{ url('Persona/ajaxEditaInscripcion') }}",
            data: {
                persona_id: persona_id,
                carrera_id: carrera_id,
                gestion: gestion,
                turno_id: turno_id,
                paralelo: paralelo,
                anio_vigente: anio_vigente,
            },
            success: function (data) {
                $("#ajaxContenidoMaterias").html(data);
            }
        });
        
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