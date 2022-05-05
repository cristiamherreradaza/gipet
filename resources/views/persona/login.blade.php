<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>GIPET</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/monsteradmin/" />
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ====================
            ========================================== -->
            <div class="auth-wrapper"
                style="background:url({{ asset('assets/imagenes/fl.jpg') }}); background-size: cover; background-position: center center;">
                <br>
                <div class="container">
                    <div class="row">
                        <div class="col-md-2"></div>
                            <div class="col-md-8 bg-white">
                                    <center>
                                        <div style="width: 40%;">
                                            <img class="card-img-top img-responsive" src="{{ asset('assets/imagenes/logo.png') }}" alt="Card image cap">
                                        </div>
                                        {{-- <div class="auth-box p-4 bg-white rounded"> --}}
                                            {{-- <img class="card-img-top img-responsive" src="{{ asset('assets/imagenes/logo.png') }}" alt="Card image cap"> --}}
                                            <div id="formulario-edita">
                                                <form class="form-horizontal form-material" method="POST" action="{{ url('Persona/ingresa') }}" id="formulario-persona">
                                                    @csrf
                                                    <br>
                                                    <div class="form-group ">
                                                        <div class="col-xs-12">
                                                            <input id="name" type="text" class="form-control  @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre de Usuario" />
                            
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                            
                                                        </div>
                                                    </div>
                            
                                                    <div class="form-group">
                                                        <div class="col-xs-12">
                                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                            
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group text-center mt-3">
                                                        <div class="col-xs-12">
                                                            <button type="button" onclick="persona()" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light">
                                                                {{ __('INGRESAR') }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        {{-- </div> --}}
                                    </center>
                            </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>

        
    </div>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });

        function persona(){
            if ($("#formulario-persona")[0].checkValidity()) {
                var datos = $('#formulario-persona').serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('Persona/ingresa') }}",
                    data: datos,
                    success: function (data) {

                        $("#formulario-edita").html(data);
                    }
                });
            }else{
                $("#formulario-persona")[0].reportValidity();
            }
        }

        function guardardatos(){
            if ($("#formulario-edita-persona")[0].checkValidity()) {
                var datos = $('#formulario-edita-persona').serialize();
                $.ajax({
                    type: "POST",
                    url: "{{ url('Persona/guardaDatos') }}",
                    data: datos,
                    success: function (data) {

                        let campania = JSON.parse(data);
                        $('#_fecha_inicio, #_nombre_campania, #_fecha_fin, #_descripcion_campania').text('');
                        if(campania.success === false){

                            $.each(campania.errors, function(index, value){
                                $('#_'+index).text(value);
                            });    
                            
                        }else{

                            // Swal.fire({
                            //     title: 'Exito!',
                            //     text: 'Se guardo los datos con exito',
                            //     icon: 'success',
                            //     confirmButtonText: 'Ok'
                            // });
                            // setTimeout(function(){
                            //     $('#modal-nuevo').modal('hide');
                            // }, 3000);
                            // ajaxListado();
                        }

                        // $("#formulario-edita").html(data);
                    }
                });
            }else{
                $("#formulario-edita-persona")[0].reportValidity();
            }
        }
    </script>
</body>

</html>