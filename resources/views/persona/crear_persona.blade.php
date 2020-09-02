@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<link href="{{ asset('assets/extra-libs/jquery-steps/jquery.steps.css') }}" rel="stylesheet">
<link href="{{ asset('assets/extra-libs/jquery-steps/steps.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
 <!-- ============================================================== -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                    <h4 class="card-title text-white"><i class="fas fa-user-plus"></i> Cliente Nuevo</h4>
                </div>
            <div class="card-body wizard-content">
                {{-- <form action="#" class="tab-wizard wizard-circle"> --}}
                <form action="{{ url('Persona/guardar_nuevos') }}" method="POST" class="validation-wizard wizard-circle mt-5">
                    @csrf
                    <!-- Step 1 -->
                    <h6>DATOS PERSONALES</h6>
                    <section>
                        {{-- datos personales --}}
                        <div class="form-body">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Apellido Paterno </label>
                                        <input type="text" class="form-control"
                                            name="apellido_materno" id="apellido_materno">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label>Apellido Materno </label>
                                        <input type="text" class="form-control"
                                            name="apellido_paterno" id="apellido_paterno">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label>Nombres
                                            <span class="text-danger">
                                                <i class="mr-2 mdi mdi-alert-circle"></i>
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" name="nombres" id="nombres" required>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label>Fecha Nacimiento </label>
                                        <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento">
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label>Carnet
                                            <span class="text-danger">
                                                <i class="mr-2 mdi mdi-alert-circle"></i>
                                            </span>
                                        </label>
                                        <input type="text" class="form-control" name="carnet" id="carnet" required>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="form-group">
                                        <label>Expedido
                                            <span class="text-danger">
                                                <i class="mr-2 mdi mdi-alert-circle"></i>
                                            </span>
                                        </label>
                                        <select name="expedido" id="expedido" class="form-control" required>
                                            <option value="">Seleccionar</option>
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
                                            name="email" id="email">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Direccion </label>
                                        <input type="text" class="form-control"
                                            name="direccion" id="direccion">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Celular
                                            <span class="text-danger">
                                                <i class="mr-2 mdi mdi-alert-circle"></i>
                                            </span>
                                        </label>
                                        <input type="text" class="form-control"
                                            name="telefono_celular" id="telefono_celular" required>
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
                                            <option value="">Seleccionar</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>

                        </div>
                        {{-- fin datos personales --}}
                    </section>
                    <!-- Step 2 -->
                    <h6>DATOS PROFESIONALES</h6>
                    <section>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group has-success">
                                        <label>Trabaja</label>
                                        <select name="trabaja" id="trabaja" class="form-control" required>
                                            <option value="No">Seleccionar</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <!--/row-->

                            <!-- row -->
                            <div class="row pt-3" id="mostrar_ocultar" style="display:none;">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Nombre de la Empresa</label>
                                        <input type="text" id="empresa" class="form-control" name="empresa">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Direcci&oacute;n de la Empresa</label>
                                        <input type="text" id="direccion_empresa" class="form-control" name="direccion_empresa">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Telefono de la Empresa</label>
                                        <input type="text" id="telefono_empresa" class="form-control" name="telefono_empresa">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Fax</label>
                                        <input type="text" id="fax" class="form-control" name="fax">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Email Empresa</label>
                                        <input type="email" id="email_empresa" class="form-control" name="email_empresa">
                                    </div>
                                </div>
                            </div>  
                            <!-- row -->
                            
                        </div>
                    </section>
                    <!-- Step 3 -->
                    <h6>REFERENCIAS PERSONALES</h6>
                    <section>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Nombre Padre </label>
                                        <input type="text" class="form-control" name="nombre_padre" id="nombre_padre">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Celular Padre </label>
                                        <input type="text" class="form-control" name="celular_padre" id="celular_padre">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Nombre Madre </label>
                                        <input type="text" class="form-control" name="nombre_madre" id="nombre_madre">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Celular Madre </label>
                                        <input type="text" class="form-control" name="celular_madre" id="celular_madre">
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Nombre Tutor(a) </label>
                                        <input type="text" class="form-control" name="nombre_tutor" id="nombre_tutor">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Celular Tutor(a) </label>
                                        <input type="text" class="form-control" name="telefono_tutor" id="telefono_tutor">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Nombre Esposo(a)</label>
                                        <input type="text" class="form-control" name="nombre_esposo" id="nombre_esposo">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Celular Esposo(a)</label>
                                        <input type="text" class="form-control" name="telefono_esposo" id="telefono_esposo">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 4 -->
                </form>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
</div>
    <!-- ============================================================== -->
@stop
@section('js')
<script src="{{ asset('assets/libs/jquery-steps/build/jquery.steps.min.js' ) }}"></script>
<script src="{{ asset('assets/libs/jquery-validation/dist/jquery.validate.min.js' ) }}"></script>
  <script>
    var form = $(".validation-wizard").show();

    $(".validation-wizard").steps({
        headerTag: "h6",
        bodyTag: "section",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: "Submit"
        },
        onStepChanging: function(event, currentIndex, newIndex) {
            return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
        },
        onFinishing: function(event, currentIndex) {
            return form.validate().settings.ignore = ":disabled", form.valid()
        },
        onFinished: function(event, currentIndex) {
            var datos_formulario = $(this).serializeArray();
            $.ajax({
                url: "{{ url('Persona/guardar_nuevos') }}",
                method: "POST",
                data: datos_formulario,
                cache: false,
                success: function (data) {
                    if (data.mensaje == 'si') {
                            Swal.fire(
                            'Excelente!',
                            'Los datos fueron guadados correctamente',
                            'success'
                        ).then(function() {
                            window.location.href = "{{ url('Persona/listado') }}";
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'La Persona ya existe',
                            'error'
                        )
                    }
                }
            })
        }
    }), $(".validation-wizard").validate({
        ignore: "input[type=hidden]",
        errorClass: "text-danger",
        successClass: "text-success",
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass)
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass)
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element)
        },
        rules: {
            email: {
                email: !0
            }
        }
    })

</script>

<script>
    $('#trabaja').on('change', function(e){
            var trabaja = e.target.value;
            if (trabaja == 'Si') {
                $('#mostrar_ocultar').show('slow');
            }else{
                $('#mostrar_ocultar').hide('slow');
            }
    });
</script>

<script type="text/javascript">
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
<script>
    // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function limpiarCampos1(){
        $("#mostrar_asig1").val('');
        $("#mostrar_asig2").val('');
    }
 
    // al elegir una Carrera, se ira a consultar por las Asignaturas que tiene que tomar en ese "SEMESTRE O AÑO".
    // en caso que sea "Contaduría General", se retorna las asignaturas de "Secretariado Administrativo" y de "Auxiliar Administrativo Financiero"
    function ver(){

        var asig = $('#carrera_id').val();
        $("#mostrar_asig1").val();
    	$("#mostrar_asig2").val();
    	$("#mostrar_asig3").val();  

        if (asig == '1') {
            $('#mostrar_asig1').show('slow');//para visualizar las asignaturas
            $('#mostrar_asig2').show('slow');//para visualizar las asignaturas
            $('#mostrar_asig3').show('slow');//para visualizar las asignaturas
            $.ajax({
                type:'GET',
                url:"{{ url('Inscripcion/contabilidad') }}",
                data: {
                    asignatura : asig
                },
                success:function(data){
                    $.each(data, function(index, value) {
                        $("#valor1").append('<tr>' +
                                    '<td>' + data[index].orden_impresion +'</td>' +
                                    '<td>' + data[index].codigo_asignatura + '</td>' +
                                    '<td>' + data[index].nombre_asignatura +'</td>' +
                                    '</tr>');
                    });
                    $("#nom_asig1").html('Contaduría General');
                    $("#gest1").html('Gestion ' + data[0].anio_vigente);

                }
            });

            $.ajax({
                type:'GET',
                url:"{{ url('Inscripcion/secretariado') }}",
                data: {
                    asignatura : asig
                },
                success:function(data){
                    $.each(data, function(index, value) {
                        $("#valor2").append('<tr>' +
                                    '<td>' + data[index].orden_impresion +'</td>' +
                                    '<td>' + data[index].codigo_asignatura + '</td>' +
                                    '<td>' + data[index].nombre_asignatura +'</td>' +
                                    '</tr>');
                    });
                    $("#nom_asig2").html('Secretariado Administrativo');
                    $("#gest2").html('Gestion ' + data[0].anio_vigente);
                }
            });

            $.ajax({
                type:'GET',
                url:"{{ url('Inscripcion/auxiliar') }}",
                data: {
                    asignatura : asig
                },
                success:function(data){
                   if(data == ''){
                    var mensaje = 'No tiene Asignaturas por Tomar'
                    $("#valor3").html(mensaje);
                   }else{
                    $.each(data, function(index, value) {
                        $("#valor3").append('<tr>' +
                                    '<td>' + data[index].orden_impresion +'</td>' +
                                    '<td>' + data[index].codigo_asignatura + '</td>' +
                                    '<td>' + data[index].nombre_asignatura +'</td>' +
                                    '</tr>');
                    	});
                    $("#nom_asig3").html('Auxiliar Administrativo Financiero');
                    $("#gest3").html('Gestion ' + data[0].anio_vigente);
                    }
                   
                }
            });
        }else{
            $('#mostrar_asig1').show('slow');//para visualizar las asignaturas
            $('#mostrar_asig2').hide('slow');//para no mostrar las asignaturas
            $('#mostrar_asig3').hide('slow');//para no mostrar las asignaturas
            $.ajax({
                type:'GET',
                url:"{{ url('Inscripcion/busca_asignatura') }}",
                data: {
                    asignatura : asig
                },
                success:function(data){
                	$.ajax({
			                type:'GET',
			                url:"{{ url('Inscripcion/busca_carrera') }}",
			                data: {
			                    id : asig
			                },
			                success:function(data){
			                        $("#nom_asig1").html(data[0].nombre);
                    				$("#gest1").html('Gestion ' + data[0].gestion);
			                }
			            });

                    $.each(data, function(index, value) {
                        $("#valor1").append('<tr>' +
                                    '<td>' + data[index].orden_impresion +'</td>' +
                                    '<td>' + data[index].codigo_asignatura + '</td>' +
                                    '<td>' + data[index].nombre_asignatura +'</td>' +
                                    '</tr>');
                    });
                }
            });
        }

        limpiarCampos1();
        // $('#valor1').replaceAll();//para limpiar los datos cada vez que se precione el boton asignaturas 
        // $('#valor2').replaceAll();//para limpiar los datos cada vez que se precione el boton asignaturas 
        // $('#valor3').replaceAll();//para limpiar los datos cada vez que se precione el boton asignaturas 

       
    } 
    
</script>
@endsection
