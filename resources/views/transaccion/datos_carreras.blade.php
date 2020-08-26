
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Servicio 
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <select name="servicio_id" id="servicio_id" class="form-control">
                <option value="">Seleccionar</option>
                @php
                    foreach ($servicios_persona as $ser_per) {
                @endphp
                    @php
                        foreach ($servicios as $servi) {
                            if ($ser_per['servicio_id'] == $servi->id) {
                    @endphp
                        <option value="{{ $servi->id }}">{{ $servi->nombre }}</option>
                    @php
                            }
                        }
                    @endphp
                @php
                    }
                @endphp
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Carrera 
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <select name="carrera_id" id="carrera_id" class="form-control">
                <option value=""></option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Asignatura 
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <select name="asignatura_id" id="asignatura_id" class="form-control">
                <option value=""></option>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label">Cantidad</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="cantidad" name="cantidad">
                <div class="input-group-append">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label">Precio Real Bs.</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" readonly id="precio_servicio" name="precio_servicio">
                <div class="input-group-append">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Descuento 
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <select name="descuento_id" id="descuento_id" class="form-control">
                {{-- <option value=""></option> --}}
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label">Descuento Bs.</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" readonly id="descuento_bs" name="descuento_bs">
                <div class="input-group-append">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label">Total a Pagar Bs.</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" readonly id="total" name="total">
                <div class="input-group-append">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label">Pagado Bs.</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="total_pagado" name="total_pagado">
                <div class="input-group-append">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <a class="btn waves-effect waves-light btn-success text-white" onclick="guarda_tabla()">Agregar</a>
</div>


<script>
    $('#servicio_id').on('change', function(e){
            var servicio_id = e.target.value;
            var carnet = $('#carnet').val();

            $('#cantidad').val('');
            $('#precio_servicio').val('');
            $('#descuento_id').html('');
            $('#descuento_bs').val('');
            $('#total').val('');
            $('#total_pagado').val('');


            // console.log(servicio_id);
            // console.log(carnet);

            $.ajax({
                type:'GET',
                url:"{{ url('Transaccion/carreras') }}",
                data: {
                    tipo1 : servicio_id,
                    tipo2 : carnet
                },
                success:function(data){
                        $('#carrera_id').empty();
                        $('#carrera_id').append('<option value="0">Seleccionar</option>');
                            
                        $.each(data.carreras, function(index, value){
                            $('#carrera_id').append('<option value="'+ data.carreras[index].id +'">'+ data.carreras[index].nombre +'</option>');
                        });
                        
                    }
            });

            $.ajax({
                type:'GET',
                url:"{{ url('Transaccion/asignaturas') }}",
                data: {
                    tipo1 : servicio_id,
                    tipo2 : carnet
                },
                success:function(data){
                        $('#asignatura_id').empty();
                        $('#asignatura_id').append('<option value="0">Seleccionar</option>');
                            
                        $.each(data, function(index, value){
                            $('#asignatura_id').append('<option value="'+ data[index].id +'">'+ data[index].nombre_asignatura +'</option>');
                        });
                        
                }
            });

    });


    $('#carrera_id').on('change', function(e){
        var carrera_id = e.target.value;
        var servicio_id = $('#servicio_id').val();
        var persona_id = $('#persona_id').val();
        $('#descuento_id').html('');


            $.ajax({
                type:'GET',
                url:"{{ url('Transaccion/verifica_cobros_temporada_carrera') }}",
                data: {
                    tipo_carrera_id : carrera_id,
                    tipo_servicio_id : servicio_id,
                    tipo_persona_id : persona_id
                },
                success:function(data){
                    if (data.verifica == 'si') {

                        $('#cantidad').val(data.cantidad);
                        $('#precio_servicio').val(data.precio_servicio);
                        $('#descuento_id').append('<option value="'+ data.descuento_id.id +'">'+ data.descuento_id.nombre +' - '+ data.descuento_id.porcentaje +'%</option>');
                        $('#descuento_bs').val(data.descuento_bs);
                        $('#total').val(data.total);
                        $('#total_pagado').val(data.total_pagado);

                    } else {

                        $('#cantidad').val(data.cantidad);
                        $('#precio_servicio').val(data.precio_servicio);

                        $.each(data.descuento_id, function(index, value){
                                    $('#descuento_id').append('<option value="'+ data.descuento_id[index].id +'">'+ data.descuento_id[index].nombre +' - '+ data.descuento_id[index].porcentaje +'%</option>');
                        });
                        $('#descuento_bs').val(data.descuento_bs);
                        $('#total').val(data.total);
                        $('#total_pagado').val(data.total_pagado);

                    }
                    
                        // $('#asignatura_id').empty();
                        // $('#asignatura_id').append('<option value="0">Seleccionar</option>');
                            
                        // $.each(data, function(index, value){
                        //     $('#asignatura_id').append('<option value="'+ data[index].id +'">'+ data[index].nombre_asignatura +'</option>');
                        // });
                        
                }
            });
    });

    $('#asignatura_id').on('change', function(e){
        var asignatura_id = e.target.value;
        var servicio_id = $('#servicio_id').val();
        var persona_id = $('#persona_id').val();
        $('#descuento_id').html('');


            $.ajax({
                type:'GET',
                url:"{{ url('Transaccion/verifica_cobros_temporada_asignatura') }}",
                data: {
                    tipo_asignatura_id : asignatura_id,
                    tipo_servicio_id : servicio_id,
                    tipo_persona_id : persona_id
                },
                success:function(data){
                    if (data.verifica == 'si') {

                        $('#cantidad').val(data.cantidad);
                        $('#precio_servicio').val(data.precio_servicio);
                        $('#descuento_id').append('<option value="'+ data.descuento_id.id +'">'+ data.descuento_id.nombre +' - '+ data.descuento_id.porcentaje +'%</option>');
                        $('#descuento_bs').val(data.descuento_bs);
                        $('#total').val(data.total);
                        $('#total_pagado').val(data.total_pagado);

                    } else {

                        $('#cantidad').val(data.cantidad);
                        $('#precio_servicio').val(data.precio_servicio);

                        $.each(data.descuento_id, function(index, value){
                                    $('#descuento_id').append('<option value="'+ data.descuento_id[index].id +'">'+ data.descuento_id[index].nombre +' - '+ data.descuento_id[index].porcentaje +'%</option>');
                        });
                        $('#descuento_bs').val(data.descuento_bs);
                        $('#total').val(data.total);
                        $('#total_pagado').val(data.total_pagado);

                    }
                    
                        // $('#asignatura_id').empty();
                        // $('#asignatura_id').append('<option value="0">Seleccionar</option>');
                            
                        // $.each(data, function(index, value){
                        //     $('#asignatura_id').append('<option value="'+ data[index].id +'">'+ data[index].nombre_asignatura +'</option>');
                        // });
                        
                }
            });
    });


    $('#cantidad').on('change', function(e){
        var cantidad = e.target.value;
        var descuento_id = $('#descuento_id').val();
        $.ajax({
                type:'GET',
                url:"{{ url('Transaccion/verifica_descuento') }}",
                data: {
                    tipo : descuento_id
                },
                success:function(data){
                        var precio_real = $('#precio_servicio').val();
                        var precio_des = 0+"."+data.descuento.porcentaje;
                        var precio_rebaja = precio_real - (precio_real * precio_des);
                        var total_des = cantidad * precio_rebaja;

                        $('#descuento_bs').val(cantidad * precio_real * precio_des);

                        $('#total').val(total_des);
                        $('#total_pagado').val(total_des);
                }
            });

    });

    $('#descuento_id').on('change', function(e){
        var descuento_id = e.target.value;

        $.ajax({
                type:'GET',
                url:"{{ url('Transaccion/verifica_descuento') }}",
                data: {
                    tipo : descuento_id
                },
                success:function(data){
                        var cantidad = $('#cantidad').val();
                        var precio_real = $('#precio_servicio').val();
                        var precio_des = 0+"."+data.descuento.porcentaje;
                        var precio_rebaja = precio_real - (precio_real * precio_des);
                        var total_des = cantidad * precio_rebaja;

                        $('#descuento_bs').val(cantidad * precio_real * precio_des);

                        $('#total').val(total_des);
                        $('#total_pagado').val(total_des);
                }
            });
       

    });
</script>
