@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('content')
<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<div class="row">
    <!-- Column -->
    <div class="col-md-12">
        <!-- Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="mb-0 text-white">NUEVO ALUMNO</h4>
                    </div>
                    <form action="/alumno/guarda" method="post">
                        @csrf
                    <div class="card-body">

                        {{-- datos personales --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-outline-warning">
                                    <div class="card-header">
                                        <h4 class="mb-0 text-white">DATOS PERSONALES</h4>
                                    </div>
                                    <div class="card-body" style="background-color: #fff6d4;">

                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Apellido Materno </label>
                                                            <input type="text" class="form-control"
                                                                name="apellido_paterno" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Apellido Paterno </label>
                                                            <input type="text" class="form-control"
                                                                name="apellido_materno" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Nombres </label>
                                                            <input type="text" class="form-control"
                                                                name="nombres" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Carnet </label>
                                                            <input type="text" class="form-control"
                                                                name="carnet" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Fecha Nacimiento </label>
                                                            <input type="date" class="form-control"
                                                                name="fecha_nacimiento" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Expedido </label>
                                                            <select name="expedido" class="form-control">
                                                                <option value="La Paz">La Paz</option>
                                                                <option value="Cochabamba">Cochabamba</option>
                                                                <option value="Santa Cruz">Santa Cruz</option>
                                                                <option value="Oruro">Oruro</option>
                                                                <option value="Potosi">Potosi</option>
                                                                <option value="Tarija">Tarija</option>
                                                                <option value="Sucre">Sucre</option>
                                                                <option value="Beni">Beni</option>
                                                                <option value="Pando">Pando</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Email </label>
                                                            <input type="text" class="form-control"
                                                                name="email" id="nivel">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Direccion </label>
                                                            <input type="text" class="form-control"
                                                                name="direccion" id="nivel">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular </label>
                                                            <input type="text" class="form-control"
                                                                name="telefono_celular" id="nivel">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Genero </label>
                                                            <select name="sexo" class="form-control">
                                                                <option value="Masculino">Masculino</option>
                                                                <option value="Femenino">Femenino</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- fin datos personales --}}

                        {{-- datos profesionales --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-outline-inverse">
                                    <div class="card-header">
                                        <h4 class="mb-0 text-white">DATOS PROFESIONALES</h4>
                                    </div>
                                    <div class="card-body" style="background-color: #ededed;">

                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Trabaja </label>
                                                            <select class="form-control" name="trabaja">
                                                                <option value="No">No</option>
                                                                <option value="Si">Si</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Empresa </label>
                                                            <input type="text" class="form-control" name="empresa" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Direccion </label>
                                                            <input type="text" class="form-control" name="direccion_empresa" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Telefono </label>
                                                            <input type="text" class="form-control" name="telefono_empresa" id="nombre">
                                                        </div>
                                                    </div>

                                                    
                                                </div>
                                                
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- fin datos profesionales --}}

                        {{-- referencias personales --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-outline-success">
                                    <div class="card-header">
                                        <h4 class="mb-0 text-white">REFERENCIAS PERSONALES</h4>
                                    </div>
                                    <div class="card-body" style="background-color: #e3ffe3;">

                                            <div class="form-body">

                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Padre </label>
                                                            <input type="text" class="form-control" name="nombre_padre" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular Padre </label>
                                                            <input type="text" class="form-control" name="celular_padre" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Madre </label>
                                                            <input type="text" class="form-control" name="nombre_madre" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular Madre </label>
                                                            <input type="text" class="form-control" name="celular_madre" id="nombre">
                                                        </div>
                                                    </div>
                                                    
                                                </div>

                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Tutor </label>
                                                            <input type="text" class="form-control" name="nombre_tutor" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular Tutor </label>
                                                            <input type="text" class="form-control" name="telefono_tutor" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Esposo </label>
                                                            <input type="text" class="form-control" name="nombre_esposo" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular Esposo </label>
                                                            <input type="text" class="form-control" name="telefono_esposo" id="nombre">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- fin referencias personales --}}

                        {{-- Carrera --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-outline-info">
                                    <div class="card-header">
                                        <h4 class="mb-0 text-white">CARRERA</h4>
                                    </div>
                                    <div class="card-body" style="background-color: #e6f4fa;">

                                            <div class="form-body">
                                                <div class="row">

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Carrera </label>
                                                            <select class="form-control" name="trabaja">
                                                                @foreach ($carreras as $c)
                                                                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Turno </label>
                                                            <select class="form-control" name="trabaja">
                                                                @foreach ($turnos as $t)
                                                                <option value="{{ $t->id }}">{{ $t->descripcion }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Madre </label>
                                                            <input type="text" class="form-control" name="data[Persona][nombres]" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular Madre </label>
                                                            <input type="text" class="form-control" name="data[Persona][nombres]" id="nombre">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- fin Carrera --}}

                        <div class="row">
                            <div class="col-md-6">
                            <button type="submit" class="btn waves-effect waves-light btn-block btn-success">Guardar Trabajo</button>
                            </div>
                            <div class="col-md-6">
                            <button type="button" class="btn waves-effect waves-light btn-block btn-inverse">Cancelar</button>
                            </div>
                        </div>

                    </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>
    <!-- Column -->
</div>
@stop
@section('js')
<script>
    $(function () {
        $('#config-table').DataTable({
            responsive: true,
            "order": [
                [0, 'asc']
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            }
        });

    });
</script>

<script type="text/javascript">

    function limpiarCampos(){
        $("#nombre").val('');
        $("#nivel").val('');
        $("#semestre").val('');
    }

    function mostrarMensaje(mensaje){
        $("#divmsg").empty();
        $("#divmsg").append("<p>"+mensaje+"</p>");
        $("#divmsg").show(500);
        $("#divmsg").hide(5000);
    }

    // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // al hacer clic en el boton GUARDAR, se procedera a la ejecucion de la funcion
    $(".btnenviar").click(function(e){
        e.preventDefault();     // Evita que la página se recargue
        var nombre = $('#nombre').val();    
        var nivel = $('#nivel').val();
        var semestre = $('#semestre').val();

        $.ajax({
            type:'POST',
            url:"{{ url('carrera/store') }}",
            data: {
                nom_carrera : nombre,
                desc_niv : nivel,
                semes : semestre
            },
            success:function(data){
                mostrarMensaje(data.mensaje);
                limpiarCampos();
            }
        });
    });
</script>
@endsection
