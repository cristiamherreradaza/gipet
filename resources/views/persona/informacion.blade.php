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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre </label>
                                    <input type="text" class="form-control" name="nombre_padre" id="nombre_padre"
                                        value="{{ $estudiante->nombre_padre }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Celular </label>
                                    <input type="text" class="form-control" name="celular_padre" id="celular_padre"
                                        value="{{ $estudiante->celular_padre }}">
                                </div>
                            </div>
                            {{-- <div class="col-3">
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
                            </div> --}}
                        </div>
                        {{-- <div class="row">
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
                        </div> --}}
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
                        <span class="d-none d-lg-block">MENSUALIDADES</span>
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
                                                <button type="button" class="btn btn-warning" title="Edita Inscripcion"
                                                    onclick="ajaxEditaInscripcion('{{ $cp->persona_id }}', '{{ $cp->carrera_id }}', '{{ $cp->turno_id }}', '{{ $cp->paralelo }}', '{{ $cp->gestion }}', '{{ $cp->anio_vigente }}')"><i
                                                        class="fas fa-edit"></i></button>

                                                <a href="{{ url('Persona/contrato') }}/{{ $cp->persona_id }}/{{ $cp->carrera_id }}/{{ $cp->gestion }}/{{ $cp->turno_id }}/{{ $cp->anio_vigente }}" class="btn btn-dark" title="Contrato" target="blank"><i class="fas fa-file-alt"></i></a>

                                                <a class="btn btn-light" title="Descargar Boletin"
                                                    href="{{ url('Inscripcion/boletin/'.$cp->id) }}" target="_blank"><i
                                                        class="fas fa-file-pdf"></i></a>

                                                <a class="btn btn-success" title="Descargar Certificado Calificaciones" href="{{ url('Persona/generaExcelCertificado/'.$cp->id) }}"><i class="fas fa-file-excel"></i>
                                                                                                </a>

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

                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn waves-effect waves-light btn-block btn-primary" onclick="muestraBloqueAdicionaMaterias();">ADICIONAR MATERIAS</button>
                        </div>
                    </div>
                    <br />
                    <form action="{{ url('Inscripcion/inscribeMateriaAlumno') }}" method="POST">
                        @csrf
                        
                        <div class="row" id="bloqueAdicionaMateria" style="display: none;">

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="text-primary">GESTION
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <input type="number" class="form-control" name="gestionMateriaBuscar" id="gestionMateriaBuscar" value="{{ date('Y') }}" required>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="text-primary">NOMBRE MATERIA
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <input type="text" class="form-control" name="buscaMateriaAdicionar" id="buscaMateriaAdicionar" autocomplete="off" required>
                                    <input type="hidden" name="adiciona_asignatura_id" id="adiciona_asignatura_id" >
                                    <input type="hidden" name="adiciona_persona_id" id="adiciona_persona_id" value="{{ $estudiante->id }}">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Carrera
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <input type="hidden" name="persona_id" value="{{ $estudiante->id }}">
                                    <select class="form-control custom-select" id="adiciona_carrera_id" name="adiciona_carrera_id" onchange="cambiaCarrera()" required>
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
                                    <select class="form-control custom-select" id="adiciona_gestion" name="adiciona_gestion" required>
                                        <option value="1">1&ordm; A&ntilde;o</option>
                                        <option value="2">2&ordm; A&ntilde;o</option>
                                        <option value="3">3&ordm; A&ntilde;o</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>Turno
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <select class="form-control custom-select" id="adiciona_turno_id" name="adiciona_turno_id" required>
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
                                    <select class="form-control custom-select" id="adiciona_paralelo" name="adiciona_paralelo" required>
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
                                    <input type="number" class="form-control" id="adiciona_anio_vigente" name="adiciona_anio_vigente" value="{{ date('Y') }}" required>
                                </div>
                            </div>                        

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>Regular.
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <select class="form-control custom-select" id="adiciona_regularizacion" name="adiciona_regularizacion" required>
                                            <option value="No">No</option>
                                            <option value="Si">Si</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label>Oyente
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <select class="form-control custom-select" id="adiciona_oyente" name="adiciona_oyente" required>
                                        <option value="No">No</option>
                                        <option value="Si">Si</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn waves-effect waves-light btn-block btn-success">ADICIONA</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12" id="ajaxCargaMateriasAdicionar">
                                
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div class="table-responsive m-t-40">
                        <table id="tabla-materias" class="table table-striped table-bordered no-wrap table-hover">
                            <thead>
                                <tr>
                                    <th>Carrera</th>
                                    <th>Materia</th>
                                    <th class="text-center">Sigla</th>
                                    <th class="text-center">Curso</th>
                                    <th class="text-center">Turno</th>
                                    <th class="text-center">Paralelo</th>
                                    <th class="text-center">Gestion</th>
                                    <th class="text-center">Nota</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materiasInscripcion as $m)
                                <tr>
                                    <td>{{ $m->carrera->nombre }}</td>
                                    <td>
                                        @if ($m->estado != 'Regularizado')
                                            <h4>{{ $m->asignatura->nombre }}</h4>
                                        @else
                                            <h4 class="text-info">{{ $m->asignatura->nombre }}*</h4>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($m->oyente != 'Si')
                                            <h4>{{ $m->asignatura->sigla }}</h4>
                                        @else
                                            <h4 class="text-warning">{{ $m->asignatura->sigla }}*</h4>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $m->gestion }}&deg; A&ntilde;o</td>
                                    <td class="text-center">{{ $m->turno->descripcion }}</td>
                                    <td class="text-center">{{ $m->paralelo }}</td>
                                    <td class="text-center">{{ $m->anio_vigente }}</td>
                                    <td class="text-center">
                                        @if ($m->convalidado == null)
                                            <h4>{{ round($m->nota, 0) }}</h4>
                                        @else
                                            <h4 class="text-primary">{{ round($m->nota, 0) }}*</h4>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning" title="Edita Notas" onclick="ajaxEditaNotas('{{ $m->id }}')"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger" title="Elimina Materia" onclick="eliminaMateria('{{ $m->id }}', '{{ $m->asignatura->nombre }}')"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                        <span class="font-weight-bold">Informacion colores:</span>
                        <span class="text-info font-weight-bold">Materia para regularizacion</span>,
                        <span class="text-warning font-weight-bold">Solo oyente</span>,
                        <span class="text-primary font-weight-bold">Materia convalidada</span>
                    </div>
                </div>

                {{-- tab pagos --}}
                <div class="tab-pane" id="settings1">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered no-wrap table-hover" id="tabla-pagos">
                            <thead>
                                <tr>
                                    <th class="text-center">Gestion</th>
                                    <th class="text-center">Descripcion</th>
                                    <th class="text-center">Monto</th>
                                    <th>Fecha Pago</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pagos as $key => $p)
                                <tr>
                                    <td class="text-center">{{ $p->anio_vigente }}</td>
                                    <td class="text-center">
                                        @if ($p->servicio_id == 2)
                                            {{ $p->mensualidad }}&#176; Mensualidad
                                        @else
                                            {{ $p->servicio->nombre }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($p->a_pagar == null || $p->faltante > 0)
                                            {{ $p->importe }}
                                            @if ($p->faltante > 0)
                                                <span class="text-danger">({{ $p->a_pagar - $p->importe }})</span>
                                            @endif
                                        @else
                                            {{ $p->a_pagar }}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            if($p->fecha != null){
                                                $utilidades = new App\librerias\Utilidades();
                                                $fechaEs = $utilidades->fechaCastellano($p->fecha);
                                                echo $fechaEs;
                                            }
                                        @endphp
                                    </td>
                                    <td class="text-center">
                                        @if ($p->estado == 'Pagado')
                                            <span class="badge py-1 badge-table badge-success" id="tag_pagado">PAGADO</span>
                                        @else
                                            <span class="badge py-1 badge-table badge-danger" id="tag_debe">DEBE</span>
                                        @endif
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <br />
                    </div>
                </div>
            </div>

            {{-- fin tabs datos alumno --}}
                
                <div class="row">
                    <div class="col-md-4">
                        <button type="button" class="btn waves-effect waves-light btn-block btn-primary" onclick="muestraFormularioInscripcion()">NUEVA INSCRIPCION</button>
                    </div>

                    <div class="col-md-4">
                        <button type="button" class="btn waves-effect waves-light btn-block btn-light"
                            onclick="muestraFormularioReportes()">HISTORIAL ACADEMICO</button>
                    </div>

                    <div class="col-md-4">
                        <a href="{{ url('Persona/listado') }}" type="button" class="btn waves-effect waves-light btn-block btn-inverse">VOLVER</a>
                    </div>
                </div>
                {{-- bloque de nueva inscripcion --}}
                <form action="#" method="POST" id="formularioInscripcion">
                    <div class="form-body">
                        <div class="row" id="bloqueInscripcion" style="display: none;">

                            <div class="col-md-12">
                                <p>&nbsp;</p>
                                <h3 class="text-info text-center">FORMULARIO DE INSCRIPCION</h3>
                                <br />
                            </div>

                            {{-- primera fila --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Carrera
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <input type="hidden" name="persona_id" value="{{ $estudiante->id }}">
                                    <select class="form-control custom-select" id="carrera_id" name="carrera_id"
                                        onchange="cambiaCarreraCuotas()" required>
                                        @foreach($carreras as $carrera)
                                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
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
                            <div class="col-md-2">
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
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Gesti&oacute;n</label>
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                    <input type="number" class="form-control" id="anio_vigente" name="anio_vigente"
                                        value="{{ date('Y') }}" required>
                                </div>
                            </div>
                            {{-- fin primera fila --}}

                            {{-- segunda fila --}}
                            <div class="col-md-2 generacion-cuotas">
                                <div class="form-group">
                                    <label>Generacion Cuotas
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <select class="form-control custom-select" id="generacion_cuotas" name="generacion_cuotas" required>
                                        <option value="Si">Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 generacion-cuotas">
                                <div class="form-group">
                                    <label>Descuento
                                        <span class="text-danger">
                                            <i class="mr-2 mdi mdi-alert-circle"></i>
                                        </span>
                                    </label>
                                    <input type="hidden" name="persona_id" value="{{ $estudiante->id }}">
                                    <select class="form-control custom-select" id="descuento_id" name="descuento_id"
                                        onchange="cambiaDescuento()" required>
                                        <option value="" data-monto="{{ $mensualidad->precio }}">Ninguno</option>
                                        @foreach ($descuentos as $d)
                                        <option value="{{ $d->id }}" data-monto="{{ $d->a_pagar }}">{{ $d->nombre }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2 generacion-cuotas">
                                <div class="form-group">
                                    <label class="control-label">Cuotas a Pagar</label>
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                    <input type="hidden" name="cantidad_cuotas_pagar" id="cantidad_cuotas_pagar">
                                    <select class="form-control custom-select" id="tipo_mensualidad_id" name="tipo_mensualidad_id" onclick="cambiaTipoMensualidad();" required>
                                        @foreach ($tiposMensualidades as $tm)
                                        <option value="{{ $tm->id }}">{{ $tm->numero_maximo }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-2 generacion-cuotas">
                                <div class="form-group">
                                    <label class="control-label">Monto A Pagar</label>
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                    <input type="hidden" name="mensualidad" id="mensualidad" value="{{ $mensualidad->precio }}">
                                    <input type="number" class="form-control" id="monto_pagar" name="monto_pagar"
                                        value="{{ $mensualidad->precio }}" required>
                                </div>
                            </div>

                            <div class="col-md-2 generacion-cuotas">
                                <div class="form-group">
                                    <label class="control-label">Cuotas Promo</label>
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                    <input type="number" class="form-control" id="cuotas_promo" name="cuotas_promo"
                                        value="5" required>
                                </div>
                            </div>

                            <div class="col-md-2 generacion-cuotas">
                                <div class="form-group">
                                    <label class="control-label">Aplica Promo</label>
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                    <select class="form-control custom-select" id="aplica_promo" name="aplica_promo"
                                        required>
                                        <option value="inicio">Inicio</option>
                                        <option value="final">Final</option>
                                    </select>
                                </div>
                            </div>

                            {{-- fin segunda fila --}}

                            {{-- <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Mes</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select class="form-control custom-select" id="mes" name="mes" required>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div> --}}

                            <div class="col-md-12">
                                <label class="control-label">&nbsp;</label>
                                <button type="button" class="btn waves-effect waves-light btn-block btn-success"
                                    onclick="ajaxInscribeAlumno()">INSCRIBIR</button>
                            </div>

                        </div>
                    </div>
                </form>
                {{-- bloque de nueva inscripcion --}}
                <div class="row" id="bloqueReportes" style="display: none;">
                    <div class="col-lg-12">
                
                        <div id="accordion" class="custom-accordion mb-4">
                
                            <div class="card mb-0">
                                <div class="card-header" id="headingOne">
                                    <h5 class="m-0">
                                        <a class="custom-accordion-title d-block pt-2 pb-2" data-toggle="collapse" href="#collapseOne"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            PENSUM DEL ALUMNO <span class="float-right"><i
                                                    class="mdi mdi-chevron-down accordion-arrow"></i></span>
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover no-wrap text-center">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Carrera</th>
                                                        <th class="text-nowrap"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($carrerasPensum as $key => $cp)
                                                    <tr>
                                                        <td>{{ ($key+1) }}</td>
                                                        <td class="text-left">{{ $cp->carrera->nombre }}</td>
                                                        <td>
                                                            <a href="{{ url('Inscripcion/reportePdfHistorialAcademico') }}/{{ $cp->persona_id }}/{{ $cp->carrera_id }}"
                                                                class="btn btn-dark" title="Historial Academico PDF" target="blank"><i class="fas fa-file-pdf"></i></a>

                                                            <a href="{{ url('Inscripcion/excelHistorialAcademico') }}/{{ $cp->persona_id }}/{{ $cp->carrera_id }}"
                                                                class="btn btn-success" title="Historial Academico Excel"><i class="fas fa-file-excel"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card-->
                
{{--                             <div class="card mb-0">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="m-0">
                                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-toggle="collapse"
                                            href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Collapsible Group Item #2 <span class="float-right"><i
                                                    class="mdi mdi-chevron-down accordion-arrow"></i></span>
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                        Aqui
                                    </div>
                                </div>
                            </div> 
                
                            <div class="card mb-0">
                                <div class="card-header" id="headingThree">
                                    <h5 class="m-0">
                                        <a class="custom-accordion-title collapsed d-block pt-2 pb-2" data-toggle="collapse"
                                            href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            Collapsible Group Item #3 <span class="float-right"><i
                                                    class="mdi mdi-chevron-down accordion-arrow"></i></span>
                                        </a>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        Aqui
                                    </div>
                                </div>
                            </div> 
 --}}
                        </div> <!-- end custom accordions-->
                    </div> <!-- end col -->
                
                    <!-- end col -->
                
                </div>
            </div>
        </div>
    </div>
</div>
{{-- modal acciones --}}
<div id="modal-notas" class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl" id="ajaxContenidoMaterias">
        
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

        var d = new Date();
        var n = d.getMonth();

        let mes = n+1;

        $("#mes").val(mes);

        if (mes <= 3) {
            $("#tipo_mensualidad_id").val(1);
            $("#cantidad_cuotas_pagar").val($("#tipo_mensualidad_id option:selected").text());
        }else{
            $("#tipo_mensualidad_id").val(2);
            $("#cantidad_cuotas_pagar").val($("#tipo_mensualidad_id option:selected").text());
        }


        // DataTable
        var tableSearching = $('#tabla-materias').DataTable({
            "order": [[ 6, 'desc' ]],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
                },
                "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
                }
            }

        });

        var tableSearching2 = $('#tabla-pagos').DataTable({
            "order": [[ 0, 'desc' ]],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
                },
                "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                },
                "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
                }
            }

        });

        // Apply the search
        /*tableSearching.columns().every(function() {
            var that = this;

            $('input', this.footer()).on('keyup change', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
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

    function ajaxEditaInscripcion(alumno_id, carrera, turno, paral, ges, anio)
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
            url: "{{ url('Inscripcion/ajaxEditaInscripcionAlumno') }}",
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
                location.reload();
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

    function ajaxEditaNotas(inscripcionId)
    {
        $("#modal-notas").modal("show");

        $.ajax({
            type: "GET",
            url: "{{ url('Inscripcion/ajaxMuestraNotaInscripcion') }}",
            data: {
                inscripcion_id: inscripcionId,
            },
            success: function (data) {
                $("#ajaxContenidoMaterias").html(data);
            }
        });

    }

    function eliminaMateria(inscripcionId, nombre)
    {
        /*let persona_id   = alumno_id;
        let carrera_id   = carrera;
        let gestion      = ges;
        let turno_id     = turno;
        let paralelo     = paral;
        let anio_vigente = anio;*/

        Swal.fire({
            title: 'Estas seguro de eliminar la materia '+nombre+' ?',
            text: "Luego no podras recuperarlo!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {

            if (result.value) {

                window.location.href = "{{ url('Asignatura/eliminaMateriaAlumno') }}/"+inscripcionId;

                Swal.fire(
                    'Excelente!',
                    'La inscripcion fue eliminada',
                    'success'
                );
            }
        })
    }

    function muestraBloqueAdicionaMaterias()
    {
        $("#bloqueAdicionaMateria").toggle('slow');
    }

    function muestraFormularioReportes()
    {
        $("#bloqueReportes").toggle('slow');
    }

    $(document).on('keyup', '#buscaMateriaAdicionar', function(e) {

        nombre_materia_buscar = $('#buscaMateriaAdicionar').val();
        gestion_materia_buscar  = $('#gestionMateriaBuscar').val();

        if (nombre_materia_buscar.length > 3) {

            $.ajax({
                url: "{{ url('Asignatura/ajaxBuscaMateriaAdicionar') }}/" + nombre_materia_buscar+"/"+gestion_materia_buscar,
                type: 'GET',
                success: function(data) {
                    // $("#ajaxMuestraMateriasCursadas").show('slow');
                    $("#ajaxCargaMateriasAdicionar").html(data);
                }
            });
        }

    });

    function cambiaDescuento()
    {
        let montoPagar = $("#descuento_id").find(':selected').data('monto');
        $("#monto_pagar").val(montoPagar);
    }

    function cambiaCarreraCuotas()
    {
        let e = document.getElementById('carrera_id');
        let valor  = e.options[e.selectedIndex].value;
        console.log(valor);
        if(valor != 1){
            $(".generacion-cuotas").hide('slow');
        }else{
            $(".generacion-cuotas").show('slow');
        }
    }

    function cambiaTipoMensualidad()
    {
        $("#cantidad_cuotas_pagar").val($("#tipo_mensualidad_id option:selected").text());
        // console.log($("#tipo_mensualidad_id option:selected").text());
    }

</script>
@endsection
