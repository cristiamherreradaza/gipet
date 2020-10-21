@extends('layouts.app')

@section('css')
@endsection

@section('content')

<!--
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-md-12 align-self-center">
            <h1 class="page-title">Kardex de Estudiante</h1>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-2">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">INICIO</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('Persona/listado') }}">ESTUDIANTES</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ strtoupper($estudiante->nombres) }} {{ strtoupper($estudiante->apellido_paterno) }} {{ strtoupper($estudiante->apellido_materno) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
-->

<div class="container-fluid mt-3">
    <div class="row justify-content-md-center">
        <div class="card col-md-12">
            <div class="row">
                <div class="col-md-4 text-center">
                    @if($estudiante->foto)
                        <img class="img-fluid align-center" src="{{ asset('assets/images/users/'.$estudiante->foto) }}">
                    @else
                        <img src="{{ asset('assets/images/users/unnamed.png') }}" class="img-fluid" style="height:250px; width:250px;">
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="row px-4 py-3">
                        <h3 class="mt-3"><strong class="text-info"><u>INFORMACI&Oacute;N PERSONAL</u></strong></h3>                        
                    </div>
                    <div class="row px-2">
                        <div class="col-md-3 text-left">
                            <h5><strong><span class="text-danger">Nombres:</strong></h5>
                            <h5><strong><span class="text-danger">Apellido Paterno:</strong></h5>
                            <h5><strong><span class="text-danger">Apellido Materno:</strong></h5>
                            <h5><strong><span class="text-danger">Cedula Identidad:</strong></h5>
                            <h5><strong><span class="text-danger">Numero:</strong></h5>
                        </div>
                        <div class="col-md-9 text-left">
                            <h5><strong>{{ $estudiante->nombres }}</strong></h5>
                            <h5><strong>{{ $estudiante->apellido_paterno }}</strong></h5>
                            <h5><strong>{{ $estudiante->apellido_materno }}</strong></h5>
                            <h5><strong>{{ $estudiante->cedula }}</strong></h5>
                            <h5><strong>{{ $estudiante->numero_celular }}</strong></h5>
                        </div>
                    </div>
                </div>
            </div>            
        </div>        
    </div>
    <div class="row justify-content-md-center">
        <div class="card col-md-12">           
                <!-- Tabs -->
                <ul class="nav nav-pills custom-pills justify-content-md-center" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-primary" id="pills-setting-tab" data-toggle="pill" href="#stock" role="tab" aria-controls="pills-setting" aria-selected="true"><strong>MATERIAS APROBADAS</strong></a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link  text-primary" id="pills-timeline-tab" data-toggle="pill" href="#general" role="tab" aria-controls="pills-timeline" aria-selected="false"><strong>HISTORIAL POR GESTION</strong></a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link text-primary" id="pills-profile-tab" data-toggle="pill" href="#especificacion" role="tab" aria-controls="pills-profile" aria-selected="false"><strong>MAS INFORMACI&Oacute;N</strong></a>
                    </li>                    
                </ul>
                <!-- Tabs -->
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="stock" role="tabpanel" aria-labelledby="pills-setting-tab">
                        <div class="card-body">
                            <div class="table-responsive">
                                    <table class="table">
                                        @foreach($carreras as $id)
                                        @php
                                            $carrera = App\Carrera::find($id);
                                        @endphp
                                        <thead>
                                            <tr>
                                                <td colspan="7" class="text-info">
                                                    <strong>CARRERA: {{ strtoupper($carrera->nombre) }}</strong>
                                                </td>
                                            </tr>
                                        </thead>
                                        <thead class="bg-primary text-white text-center">
                                            <tr>
                                                <th>Gestion</th>
                                                <th>Sigla</th>
                                                <th>Materia</th>
                                                <th>1er Bimestre</th>
                                                <th>2do Bimestre</th>
                                                <th>3er Bimestre</th>
                                                <th>4to Bimestre</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @for($i = 1; $i <= $carrera->duracion_anios; $i++)
                                                @php
                                                    $inscripciones = App\Inscripcione::where('carrera_id', $carrera->id)
                                                                                    ->where('persona_id', $estudiante->id)
                                                                                    ->where('gestion', $i)
                                                                                    ->where('nota', '>=', 61)
                                                                                    ->get();
                                                @endphp
                                                @foreach($inscripciones as $inscripcion)
                                                    <tr>
                                                        <td>{{ $inscripcion->gestion }}</td>
                                                        <td>{{ $inscripcion->asignatura->sigla }}</td>
                                                        <td>{{ $inscripcion->asignatura->nombre }}</td>
                                                        @php
                                                            $notas = App\Nota::where('asignatura_id', $inscripcion->asignatura->id)
                                                                            ->where('persona_id', $estudiante->id)
                                                                            ->where('anio_vigente', $inscripcion->anio_vigente)
                                                                            ->get();
                                                        @endphp
                                                        @foreach($notas as $nota)
                                                            <td>{{ $nota->nota_total }}</td>    
                                                        @endforeach
                                                        <td>{{ $inscripcion->nota }}</td>
                                                    </tr>
                                                @endforeach
                                            @endfor
                                        </tbody>
                                        @endforeach
                                    </table>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="pills-timeline-tab">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">CODIGO</strong>
                                    <br>
                                    <p>persona_</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">NOMBRE</strong>
                                    <br>
                                    <p>persona_</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">NOMBRE DE VENTA</strong>
                                    <br>
                                    <p>persona_</p>
                                </div>
                                <div class="col-md-3 col-xs-6"><strong class="text-danger">MODELO</strong>
                                    <br>
                                    <p>persona_</p>
                                </div>
                            </div>
                            <hr>
                            <p class="mt-4">
                            persona_descriopcion
                            </p>  
                            <hr>
                            <h3><strong class="text-danger">Enlace Referencia :</strong></h3>
                                <a href="" target="_blank">persona_</a>
                            <hr>
                            <h3><strong class="text-danger">Enlace Video :</strong></h3>
                                <a href="" target="_blank">persona_</a>
                        </div>
                    </div> -->
                    <div class="tab-pane fade" id="especificacion" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">SEXO</strong>
                                    <br>
                                    <p>{{ $estudiante->sexo }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">FECHA NACIMIENTO</strong>
                                    <br>
                                    <p>{{ $estudiante->fecha_nacimiento }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">DIRECCION</strong>
                                    <br>
                                    <p>{{ $estudiante->direccion }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6"><strong class="text-danger">EMAIL</strong>
                                    <br>
                                    <p>{{ $estudiante->email }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">EMPRESA</strong>
                                    <br>
                                    <p>{{ $estudiante->empresa }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">DIRECCION EMPRESA</strong>
                                    <br>
                                    <p>{{ $estudiante->direccion_empresa }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">NUMERO EMPRESA</strong>
                                    <br>
                                    <p>{{ $estudiante->numero_empresa }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6"><strong class="text-danger">EMAIL EMPRESA</strong>
                                    <br>
                                    <p>{{ $estudiante->email_empresa }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">NOMBRE PADRE</strong>
                                    <br>
                                    <p>{{ $estudiante->nombre_padre }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">NUMERO PADRE</strong>
                                    <br>
                                    <p>{{ $estudiante->celular_padre }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">NOMBRE MADRE</strong>
                                    <br>
                                    <p>{{ $estudiante->nombre_madre }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6"><strong class="text-danger">NUMERO MADRE</strong>
                                    <br>
                                    <p>{{ $estudiante->celular_madre }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">NOMBRE TUTOR</strong>
                                    <br>
                                    <p>{{ $estudiante->nombre_tutor }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">NUMERO TUTOR</strong>
                                    <br>
                                    <p>{{ $estudiante->celular_tutor }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"><strong class="text-danger">NOMBRE PAREJA</strong>
                                    <br>
                                    <p>{{ $estudiante->nombre_pareja }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6"><strong class="text-danger">NUMERO PAREJA</strong>
                                    <br>
                                    <p>{{ $estudiante->celular_pareja }}</p>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
        </div>
    </div>
</div>

@stop
@section('js')

@endsection