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
                    <div class="card-body">
                        {{-- datos personales --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-outline-warning">
                                    <div class="card-header">
                                        <h4 class="mb-0 text-white">DATOS PERSONALES</h4>
                                    </div>
                                    <div class="card-body">

                                        <form>
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Apellido Materno </label>
                                                            <input type="text" class="form-control"
                                                                name="data[Persona][apellido_paterno]" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Apellido Paterno </label>
                                                            <input type="text" class="form-control"
                                                                name="data[Persona][apellido_materno]" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Nombres </label>
                                                            <input type="text" class="form-control"
                                                                name="data[Persona][nombres]" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Carnet </label>
                                                            <input type="text" class="form-control"
                                                                name="data[Persona][carnet]" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Expedido </label>
                                                            <input type="text" class="form-control"
                                                                name="data[Persona][expedido]" id="nivel">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Genero </label>
                                                            <input type="text" class="form-control"
                                                                name="data[Persona][sexo]" id="nivel">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Email </label>
                                                            <input type="text" class="form-control"
                                                                name="data[Persona][email]" id="nivel">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Direccion </label>
                                                            <input type="text" class="form-control"
                                                                name="data[Persona][sexo]" id="nivel">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label>Genero </label>
                                                            <input type="text" class="form-control"
                                                                name="data[Persona][sexo]" id="nivel">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>
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
                                    <div class="card-body">

                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label>Trabaja </label>
                                                            <select class="form-control">
                                                                <option value="No">No</option>
                                                                <option value="Si">Si</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Empresa </label>
                                                            <input type="text" class="form-control" name="data[Alumno][empresa]" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Direccion </label>
                                                            <input type="text" class="form-control" name="data[Alumno][empresa]" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Telefono </label>
                                                            <input type="text" class="form-control" name="data[Persona][nombres]" id="nombre">
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
                                    <div class="card-body">

                                            <div class="form-body">
                                                <div class="row">

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Padre </label>
                                                            <input type="text" class="form-control" name="data[Alumno][empresa]" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular Padre </label>
                                                            <input type="text" class="form-control" name="data[Alumno][empresa]" id="nombre">
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
                        {{-- fin referencias personales --}}

                        {{-- Carrera --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-outline-info">
                                    <div class="card-header">
                                        <h4 class="mb-0 text-white">REFERENCIAS PERSONALES</h4>
                                    </div>
                                    <div class="card-body">

                                            <div class="form-body">
                                                <div class="row">

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Nombre Padre </label>
                                                            <input type="text" class="form-control" name="data[Alumno][empresa]" id="nombre">
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Celular Padre </label>
                                                            <input type="text" class="form-control" name="data[Alumno][empresa]" id="nombre">
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


                    </div>
                    
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
