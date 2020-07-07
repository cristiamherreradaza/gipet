<div class="form-body">
    <!--/row-->
    <!-- NOMBRE DEL ATRIBUTO ENCIMA -->
    <div class="row pt-3">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Trabaja 
                    <span class="text-danger">
                        <i class="mr-2 mdi mdi-alert-circle"></i>
                    </span>
                </label>
                <select class="form-control" id="trabaja" name="trabaja" value="{{ $datosPersonales->trabaja }}" required>
                    <option value="{{ $datosPersonales->trabaja }}">{{ $datosPersonales->trabaja }}</option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                </select>
            </div>
        </div>
    </div>
    <!-- row -->
    <div class="row pt-3">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Nombre de la Empresa</label>
                <input type="text" id="empresa" class="form-control" name="empresa" value="{{ $datosPersonales->empresa }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label">Direcci&oacute;n de la Empresa</label>
                <input type="text" id="direccion_empresa" class="form-control" name="direccion_empresa" value="{{ $datosPersonales->direccion_empresa }}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Telefono de la Empresa</label>
                <input type="text" id="telefono_empresa" class="form-control" name="telefono_empresa" value="{{ $datosPersonales->telefono_empresa }}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Fax</label>
                <input type="text" id="fax" class="form-control" name="fax" value="{{ $datosPersonales->fax }}">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label">Email Empresa</label>
                <input type="email" id="email_empresa" class="form-control" name="email_empresa" value="{{ $datosPersonales->email_empresa }}">
            </div>
        </div>
    </div>  
    <!-- row -->
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label>Nombre Padre </label>
                <input type="text" class="form-control" name="nombre_padre" id="nombre_padre" value="{{ $datosPersonales->nombre_padre }}">
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label>Celular Padre </label>
                <input type="text" class="form-control" name="celular_padre" id="celular_padre" value="{{ $datosPersonales->celular_padre }}">
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label>Nombre Madre </label>
                <input type="text" class="form-control" name="nombre_madre" id="nombre_madre" value="{{ $datosPersonales->nombre_madre }}">
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label>Celular Madre </label>
                <input type="text" class="form-control" name="celular_madre" id="celular_madre" value="{{ $datosPersonales->celular_madre }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label>Nombre Tutor </label>
                <input type="text" class="form-control" name="nombre_tutor" id="nombre_tutor" value="{{ $datosPersonales->nombre_tutor }}">
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label>Celular Tutor </label>
                <input type="text" class="form-control" name="telefono_tutor" id="telefono_tutor" value="{{ $datosPersonales->telefono_tutor }}">
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label>Nombre Esposo(a) </label>
                <input type="text" class="form-control" name="nombre_esposo" id="nombre_esposo" value="{{ $datosPersonales->nombre_esposo }}">
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label>Celular Esposo(a) </label>
                <input type="text" class="form-control" name="telefono_esposo" id="telefono_esposo" value="{{ $datosPersonales->telefono_esposo }}">
            </div>
        </div>
    </div>
    <div class="col-md-12 align-self-center d-none d-md-block">
        <button class="btn float-right btn-danger" onclick="cerrar()"> Cerrar</button>
        <div class="dropdown float-right mr-2 hidden-sm-down">
           <button class="btn float-right btn-success" onclick="guardar_datosAdicionales()"> Actualizar</button>
        </div>
    </div>
</div>
<script>
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function guardar_datosAdicionales() {
        var trabaja = $('#trabaja').val();
        var persona_id = $('#persona_id').val();
        var empresa = $('#empresa').val();
        var direccion_empresa = $('#direccion_empresa').val();
        var telefono_empresa = $('#telefono_empresa').val();
        var fax = $('#fax').val();
        var email_empresa = $('#email_empresa').val();
        var nombre_padre = $('#nombre_padre').val();
        var celular_padre = $('#celular_padre').val();
        var nombre_madre = $('#nombre_madre').val();
        var celular_madre = $('#celular_madre').val();
        var nombre_tutor = $('#nombre_tutor').val();
        var telefono_tutor = $('#telefono_tutor').val();
        var nombre_esposo = $('#nombre_esposo').val();
        var telefono_esposo = $('#telefono_esposo').val();
        $.ajax({
            url: "{{ url('Kardex/guardar_datosAdicionales') }}",
            method: "POST",
            data: {
                tipo_trabaja : trabaja, tipo_persona_id : persona_id, tipo_empresa : empresa, tipo_direccion_empresa : direccion_empresa, tipo_telefono_empresa : telefono_empresa, tipo_fax : fax, tipo_email_empresa : email_empresa, tipo_nombre_padre : nombre_padre, tipo_celular_padre : celular_padre, tipo_nombre_madre : nombre_madre, tipo_celular_madre : celular_madre, tipo_nombre_tutor : nombre_tutor, tipo_telefono_tutor : telefono_tutor, tipo_nombre_esposo : nombre_esposo, tipo_telefono_esposo : telefono_esposo
            },
            success:function(data){
                // $("#grafico_alcance").show('slow');
                $("#datos_adicionales").html(data);
                Swal.fire(
                        'Correcto!',
                        'Se actualizo correctamente',
                        'success'
                    );

            }
        })
    }

    function cerrar()
    {
        $('#mostrar').hide('slow');
    }
    
</script>
