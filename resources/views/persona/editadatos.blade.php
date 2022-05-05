<h3 class="text-success">FORMULARIO EDICION DE DATOS PERSONALES - ESTUDIANTES </h3>
<form action="" id="formulario-edita-persona">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <label for="">APELLIDO PATERNO<b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" value="{{$persona->apellido_paterno}}" required placeholder="Apellido Parterno">
            <small class="text-danger" id="_apellido_paterno"></small>
        </div>
        <div class="col-md-4">
            <label for="">APELLIDO MATERNO<b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="apellido_materno" name="apellido_materno"  value="{{$persona->apellido_materno}}" required placeholder="Apellido Materno">
            <small class="text-danger" id="_apellido_materno"></small>
        </div>
        <div class="col-md-4">
            <label for="">NOMBRES<b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="nombres" name="nombres" value="{{$persona->nombres}}" required placeholder="Nombres Completos">
            <small class="text-danger" id="_nombres"></small>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <label for="">FECHA DE NACIMIENTO<b class="text-danger">*</b></label>
            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{$persona->fecha_nacimiento}}" required>
            <small class="text-danger" id="_fecha_nacimiento"></small>
        </div>
        <div class="col-md-4">
            <label for="">GENERO<b class="text-danger">*</b></label>
            <select class="form-control"  id="genero" name="genero" required>
                <option value="Masculino" {{($persona->sexo == 'Masculino')? 'selected': ''}}>Masculino</option>
                <option value="Femenino" {{($persona->sexo == 'Femenino')? 'selected': ''}}>Femenino</option>
            </select>
            <small class="text-danger" id="_genero"></small>
        </div>
        <div class="col-md-4">
            <label for="">CEDULA DE IDENTIDAD<b class="text-danger">*</b></label>
            <input type="text" class="form-control" id="cedula" name="cedula"  value="{{$persona->cedula}}" required placeholder="Cedula de Identidad">
            <small class="text-danger" id="_cedula"></small>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <label for="">EXPEDIDO CEDULA<b class="text-danger">*</b></label>
            <select name="expedido" id="expedido" class="form-control" required>
                <option {{ ($persona->expedido == "La Paz")? 'selected': '' }} value="La Paz">La Paz</option>
                <option {{ ($persona->expedido == "Oruro")? 'selected': '' }} value="Oruro">Oruro</option>
                <option {{ ($persona->expedido == "Potosi")? 'selected': '' }} value="Potosi">Potosi</option>
                <option {{ ($persona->expedido == "Cochabamba")? 'selected': '' }} value="Cochabamba">Cochabamba</option>
                <option {{ ($persona->expedido == "Chuquisaca")? 'selected': '' }} value="Chuquisaca">Chuquisaca</option>
                <option {{ ($persona->expedido == "Tarija")? 'selected': '' }} value="Tarija">Tarija</option>
                <option {{ ($persona->expedido == "Pando")? 'selected': '' }} value="Pando">Pando</option>
                <option {{ ($persona->expedido == "Beni")? 'selected': '' }} value="Beni">Beni</option>
                <option {{ ($persona->expedido == "Santa Cruz")? 'selected': '' }} value="Santa Cruz">Santa Cruz</option>
            </select>
            <small class="text-danger" id="_expedido"></small>
        </div>
        <div class="col-md-4">
            <label for="">NUMERO DE CELULAR<b class="text-danger">*</b></label>
            <input type="text" class="form-control" name="numero_celular" id="numero_celular" value="{{$persona->numero_celular}}" required placeholder="Numero de celular">
            <small class="text-danger" id="_numero_celular"></small>
        </div>
        <div class="col-md-4">
            <label for="">CORREO ELECTRONICO</label>
            <input type="text" class="form-control" name="correo_electronico" id="correo_electronico" value="{{$persona->email}}" placeholder="Correo Electronico">
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-8">
            <label for="">REFERENCIA FAMILIAR</label>
            <input type="text" class="form-control"  name="referencia_familiar" id="referencia_familiar" value="{{$persona->nombre_padre}}" placeholder="Nombres Referencia">
        </div>
        <div class="col-md-4">
            <label for="">NUMERO DE CELULAR</label>
            <input type="text" class="form-control"  name="referencia_familiar_celular" id="referencia_familiar_celular" value="{{$persona->celular_padre}}" placeholder="Numero de la Referencia personal">
            <small>Numero de la referencia personal</small>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <label for="">Direccion de Domicilio</label>
            <textarea class="form-control" name="direccion_domicilio" id="direccion_domicilio" cols="30" rows="2" placeholder="Direccion de domicilio">{{$persona->direccion}}</textarea>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-success btn-block" onclick="guardardatos()">GUARDAR MIS DATOS</button>
        </div>
    </div>
    <br>
</form>


{{-- @extends('layouts.app')

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
                @php
                    // dd(session('user'));
                    var_dump(session('user'));
                @endphp
                <div class="row">
                    <input type="hidden" name="carrera_id" id="carrera_id" value="{{ $datosCarrera->id }}">
                    <input type="hidden" name="gestion" id="gestion" value="{{ $curso }}">
                    <input type="hidden" name="turno_id" id="turno_id" value="{{ $datosTurno->id }}">
                    <input type="hidden" name="paralelo" id="paralelo" value="{{ $paralelo }}">
                    <input type="hidden" name="anio_vigente" id="anio_vigente" value="{{ $gestion }}">

                    <div class="col"><h3><span class="text-info">Carrera: </span> {{ $datosCarrera->nombre }}</h3></div>
                    <div class="col"><h3><span class="text-info">Curso: </span> {{ $curso }}° A&ntilde;o</h3></div>
                    <div class="col"><h3><span class="text-info">Turno: </span> {{ $datosTurno->descripcion }}</h3></div>
                </div>
                <div class="row">
                    <div class="col"><h3><span class="text-info">Paralelo: </span> {{ $paralelo }}</h3></div>
                    <div class="col"><h3><span class="text-info">Gestion: </span> {{ $gestion }}</h3></div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label">Carnet</label>
                            <input type="number" name="buscaCarnet" id="buscaCarnet" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <label class="control-label">&nbsp;</label>
                        <button type="submit" class="btn btn-block btn-primary" onclick="buscaAlumno();">BUSCAR</button>
                    </div>
                    <div class="col-md-8" id="ajaxAlumno">

                    </div>
                </div>
                <br>
                <div class="table-responsive m-t-40" id="ajaxAlumnosRegularizacion">
                    <table id="tablaAlumnos" class="table table-bordered table-striped table-hover">
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
                            @if ($ne->persona)
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
                                        <option value="ABANDONO TEMPORAL" {{ ($estado->estado=='ABANDONO TEMPORAL')?'selected':'' }}>ABANDONO TEMPORAL</option>
                                    </select>
                                    <small id="select_{{ $ne->persona_id }}" class="form-control-feedback text-success" style="display: none;">Guardado</small>
                                </td>
                                <td>
                                    <button onclick="elimina('{{ $ne->persona_id }}', '{{ $ne->persona->cedula }}')" type="button" class="btn btn-danger" title="Eliminar Estudiante"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            @endif
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
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('#tablaAlumnos').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });

    // function enviaDatos(numero) {
    //     let formulario = $("#formulario_"+numero).serializeArray();

    //     $.ajax({
    //         type: "POST",
    //         url: "{{ url('Persona/ajaxGuardaNota') }}",
    //         data: formulario,
    //         success: function (data) {
    //             // console.log(data.sw);
    //             if(data.sw == 1){
    //                 $("#msg_"+numero).show();
    //             }
    //         }
    //     });
    // }

    // function buscaAlumno()
    // {
    //     let carnet = $("#buscaCarnet").val();

    //     $.ajax({
    //         type: "POST",
    //         url: "{{ url('Persona/ajaxBusca') }}",
    //         data: {carnet: carnet},
    //         success: function (data) {
    //             $("#ajaxAlumno").html(data);
    //         }
    //     });
    // }

    // function inscribeAlumno()
    // {
    //     let persona_id   = $("#persona_id").val();
    //     let sexo         = $("#sexo").val();
    //     let carrera_id   = $("#carrera_id").val();
    //     let gestion      = $("#gestion").val();
    //     let turno_id     = $("#turno_id").val();
    //     let paralelo     = $("#paralelo").val();
    //     let anio_vigente = $("#anio_vigente").val();

    //     Swal.fire(
    //         'Excelente!',
    //         'La persona fue inscrita',
    //         'success'
    //     );

    //     $.ajax({
    //         type: "POST",
    //         url: "{{ url('Persona/ajaxInscribe') }}",
    //         data: {
    //                 persona_id: persona_id,
    //                 sexo: sexo,
    //                 carrera_id: carrera_id,
    //                 gestion: gestion,
    //                 turno_id: turno_id,
    //                 paralelo: paralelo,
    //                 anio_vigente: anio_vigente,
    //             },
    //         success: function (data) {
    //             $("#ajaxAlumnosRegularizacion").html(data);
    //         }
    //     });
    // }

    // function elimina(id, carnet)
    // {
    //     let persona_id   = id;
    //     let sexo         = $("#sexo").val();
    //     let carrera_id   = $("#carrera_id").val();
    //     let gestion      = $("#gestion").val();
    //     let turno_id     = $("#turno_id").val();
    //     let paralelo     = $("#paralelo").val();
    //     let anio_vigente = $("#anio_vigente").val();

    //     Swal.fire({
    //         title: 'Estas seguro de eliminar al alumno con carnet '+carnet+' ?',
    //         text: "Luego no podras recuperarlo!",
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Si, estoy seguro!',
    //         cancelButtonText: "Cancelar",
    //     }).then((result) => {
    //         if (result.value) {
    //             Swal.fire(
    //                 'Excelente!',
    //                 'El alumno fue eliminado',
    //                 'success'
    //             );

    //             $.ajax({
    //                 type: "POST",
    //                 url: "{{ url('Persona/ajaxEliminaInscripcion') }}",
    //                 data: {
    //                         persona_id: persona_id,
    //                         sexo: sexo,
    //                         carrera_id: carrera_id,
    //                         gestion: gestion,
    //                         turno_id: turno_id,
    //                         paralelo: paralelo,
    //                         anio_vigente: anio_vigente,
    //                     },
    //                 success: function (data) {
    //                     $("#ajaxAlumnosRegularizacion").html(data);
    //                 }
    //             });

    //         }
    //     })

    // }

    // function cambiaEstado(alumno_id)
    // {
    //     let estado       = $("#estado_inscripcion_"+alumno_id).val();
    //     let persona_id   = alumno_id;
    //     let carrera_id   = $("#carrera_id").val();
    //     let gestion      = $("#gestion").val();
    //     let turno_id     = $("#turno_id").val();
    //     let paralelo     = $("#paralelo").val();
    //     let anio_vigente = $("#anio_vigente").val();

    //     $.ajax({
    //         type: "POST",
    //         url: "{{ url('Persona/ajaxCambiaEstado') }}",
    //         data: {
    //                 estado: estado,
    //                 persona_id: persona_id,
    //                 carrera_id: carrera_id,
    //                 gestion: gestion,
    //                 turno_id: turno_id,
    //                 paralelo: paralelo,
    //                 anio_vigente: anio_vigente,
    //             },
    //         success: function (data) {
    //             $("#select_"+alumno_id).show();
    //             // $("#ajaxAlumnosRegularizacion").html(data);
    //         }
    //     });

    // }

</script>
@endsection --}}