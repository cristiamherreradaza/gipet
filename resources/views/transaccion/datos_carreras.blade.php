
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
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label">Cantidad</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="cantidad" name="cantidad">
                <div class="input-group-append">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label">Precio Real</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="precio_servicio" name="precio_servicio">
                <div class="input-group-append">
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Descuento 
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <select name="descuento_id" id="descuento_id" class="form-control">
                <option value=""></option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label">Total</label>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="total" name="total">
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
            $('#total').val('');

            console.log(servicio_id);
            console.log(carnet);

            $.ajax({
                type:'GET',
                url:"{{ url('Transaccion/carreras') }}",
                data: {
                    tipo1 : servicio_id,
                    tipo2 : carnet
                },
                success:function(data){
                        $('#carrera_id').empty();
                        $('#carrera_id').append('<option ="0" disable="true" selected="true">Seleccionar</option>');
                            
                        $.each(data.carreras, function(index, value){
                            $('#carrera_id').append('<option value="'+ data.carreras[index].id +'">'+ data.carreras[index].nombre +'</option>');
                                
                            });

                        $('#cantidad').val(1);
                        $('#precio_servicio').val(data.servicio.precio);


                        $('#descuento_id').empty();
                        // $('#descuento_id').append('<option ="0" disable="true" selected="true">Seleccionar</option>');
                        // alert(data.descuento.length);
                        var num = data.descuento.length;
                            if ( num != 0) {
                                $('#descuento_id').append('<option value="'+ data.descuento[0].id +'">'+ data.descuento[0].nombre +' - '+ data.descuento[0].porcentaje +'%</option>');

                                var cant = $('#cantidad').val();
                                var prec_ser = $('#precio_servicio').val();
                                var desc = data.descuento[0].porcentaje;
                                var desc_per = 0+"."+desc;

                                var total = (cant * prec_ser) - ((cant * prec_ser) * desc_per);

                                $('#total').val(total);
                            } else {
                                $('#descuento_id').append('<option value="'+ 1 +'"> Normal - 0% </option>');

                                var cant = $('#cantidad').val();
                                var prec_ser = $('#precio_servicio').val();

                                var total = (cant * prec_ser);

                                $('#total').val(total);
                                    
                            }
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
                        $('#asignatura_id').append('<option ="0" disable="true" selected="true">Seleccionar</option>');
                            
                        $.each(data, function(index, value){
                            $('#asignatura_id').append('<option value="'+ data[index].id +'">'+ data[index].nombre_asignatura +'</option>');
                                
                            });
                        
                }
            });



            // // console.log(grupo_id);
            // $.get('/json-carreras?servicio_id='+ servicio_id, function(data) {

            // // console.log(data);
            //     $('#carrera_id').empty();
            //     $('#carrera_id').append('<option ="0" disable="true" selected="true">----Elija una opcion----</option>');
                    
            //     $.each(data, function(index, carrerasObj){
            //         $('#carrera_id').append('<option value="'+ carrerasObj.carrera_id +'">'+ carrerasObj.carrera_id +'</option>');
                        
            //         });
            //     });
    });
</script>
