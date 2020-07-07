<div class="form-body">
    <div class="row">
        <div class="col-2">
            <div class="form-group">
                <label>Carnet 
                    <span class="text-danger">
                        <i class="mr-2 mdi mdi-alert-circle"></i>
                    </span>
                 </label>
                <input type="text" class="form-control" name="carnet" id="carnet" value="{{ $datosPersonales->carnet }}" required>
            </div>
        </div>
        <input type="text" class="form-control" hidden name="persona_id" id="persona_id" value="{{ $datosPersonales->id }}">
        <div class="col-2">
            <div class="form-group">
                <label>Expedido 
                    <span class="text-danger">
                        <i class="mr-2 mdi mdi-alert-circle"></i>
                    </span>
                </label>
                <select name="expedido" id="expedido" class="form-control" value="{{ $datosPersonales->expedido }}">
                    <option value="{{ $datosPersonales->expedido }}">{{ $datosPersonales->expedido }}</option>
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
        <div class="col-2">
            <div class="form-group">
                <label>Ape. Paterno </label>
                <input type="text" class="form-control"
                    name="apellido_paterno" id="apellido_paterno" value="{{ $datosPersonales->apellido_paterno }}">
            </div>
        </div>

        <div class="col-2">
            <div class="form-group">
                <label>Ape. Materno </label>
                <input type="text" class="form-control"
                    name="apellido_materno" id="apellido_materno" value="{{ $datosPersonales->apellido_materno }}">
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                <label>Nombres
                    <span class="text-danger">
                        <i class="mr-2 mdi mdi-alert-circle"></i>
                    </span>
                </label>
                <input type="text" class="form-control" name="nombres" id="nombres" value="{{ $datosPersonales->nombres }}" required>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <label>Fecha Nacimiento
                    <span class="text-danger">
                        <i class="mr-2 mdi mdi-alert-circle"></i>
                    </span>
                </label>
                <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ $datosPersonales->fecha_nacimiento }}" required>
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label>Email </label>
                <input type="text" class="form-control" name="email" id="email" value="{{ $datosPersonales->email }}">
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <label>Direccion </label>
                <input type="text" class="form-control" name="direccion" id="direccion" value="{{ $datosPersonales->direccion }}">
            </div>
        </div>

        <div class="col-2">
            <div class="form-group">
                <label>Celular 
                    <span class="text-danger">
                        <i class="mr-2 mdi mdi-alert-circle"></i>
                    </span>
                </label>
                <input type="text" class="form-control" name="telefono_celular" id="telefono_celular" value="{{ $datosPersonales->telefono_celular }}" required>
            </div>
        </div>

        <div class="col-2">
            <div class="form-group">
                <label>Genero 
                    <span class="text-danger">
                        <i class="mr-2 mdi mdi-alert-circle"></i>
                    </span>
                </label>
                <select name="sexo" id="sexo" class="form-control" value="{{ $datosPersonales->sexo }}" required>
                    <option value="{{ $datosPersonales->sexo }}">{{ $datosPersonales->sexo }}</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenina">Femenina</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-12 align-self-center d-none d-md-block">
        <button class="btn float-right btn-warning" onclick="mas_datos()"> Mas Datos</button>
        <div class="dropdown float-right mr-2 hidden-sm-down">
           <button class="btn float-right btn-success" onclick="guardar()"> Actualizar</button>
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

    function guardar() {
        var carnet = $('#carnet').val();
        var persona_id = $('#persona_id').val();
        var expedido = $('#expedido').val();
        var apellido_paterno = $('#apellido_paterno').val();
        var apellido_materno = $('#apellido_materno').val();
        var nombres = $('#nombres').val();
        var fecha_nacimiento = $('#fecha_nacimiento').val();
        var email = $('#email').val();
        var direccion = $('#direccion').val();
        var telefono_celular = $('#telefono_celular').val();
        var sexo = $('#sexo').val();
        $.ajax({
            url: "{{ url('Kardex/guardar_datosPrincipales') }}",
            method: "POST",
            data: {
                tipo_carnet : carnet, tipo_persona_id : persona_id, tipo_expedido : expedido, tipo_apellido_paterno : apellido_paterno, tipo_apellido_materno : apellido_materno, tipo_nombres : nombres, tipo_fecha_nacimiento : fecha_nacimiento, tipo_email : email, tipo_direccion : direccion, tipo_telefono_celular : telefono_celular, tipo_sexo : sexo
            },
            success:function(data){
                // $("#grafico_alcance").show('slow');
                $("#datos_principales").html(data);
                Swal.fire(
                        'Correcto!',
                        'Se actualizo correctamente',
                        'success'
                    );

            }
        })
    }

    function mas_datos()
    {
        $('#mostrar').show('slow');
    }
    
</script>