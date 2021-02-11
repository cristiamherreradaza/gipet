<div class="row">
    <div class="col-md-3">
        <h4>
            <span class="text-info">APELLIDO PATERNO: </span>
            {{ $datosPersona->apellido_paterno }}
        </h4>
    </div>

    <div class="col-md-3">
        <h4>
            <span class="text-info">APELLIDO MATERNO: </span>
            {{ $datosPersona->apellido_materno }}
        </h4>
    </div>

    <div class="col-md-3">
        <h4>
            <span class="text-info">NOMBRES: </span>
            {{ $datosPersona->nombres }}
        </h4>
    </div>

    <div class="col-md-3">
        <h4>
            <span class="text-info">FECHA NACIMIENTO: </span>
            {{ $datosPersona->fecha_nacimiento }}
        </h4>
    </div>

</div>

<div class="row">
    <div class="col-md-3">
        <h4>
            <span class="text-info">CARNET: </span>
            {{ $datosPersona->cedula }}
        </h4>
    </div>

    <div class="col-md-3">
        <h4>
            <span class="text-info">EXPEDIDO: </span>
            {{ $datosPersona->expedido }}
        </h4>
    </div>

    <div class="col-md-3">
        <h4>
            <span class="text-info">CELULAR: </span>
            {{ $datosPersona->celular }}
        </h4>
    </div>

    <div class="col-md-3">
        <h4>
            <span class="text-info">EMAIL: </span>
            {{ $datosPersona->email }}
        </h4>
    </div>

</div>

@if ($descuentos->count() > 0)
    
<div class="row">
    <div class="col-md-12">
        
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Carrera</th>
                    <th>Tipo</th>
                    <th>Cuotas Pagadas</th>
                    <th>Total Cuotas</th>
                    <th>Cuotas Pendientes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($descuentos as $d)
                @php
                    $cantidadCuotas = App\Pago::where('persona_id', $d->persona_id)
                        ->where('carrera_id', $d->carrera_id)
                        ->where('anio_vigente', $d->anio_vigente)
                        ->count();

                    $cuotasPagadas = App\Pago::where('persona_id', $d->persona_id)
                        ->where('carrera_id', $d->carrera_id)
                        ->where('anio_vigente', $d->anio_vigente)
                        ->where('estado', 'Pagado')
                        ->count();

                    $cuotasSinPagar = $cantidadCuotas - $cuotasPagadas;
                
                @endphp
                <tr>
                    <td style="text-align: left;">{{ $d->carrera->nombre }}</td>
                    <td>{{ $d->servicio->nombre }}</td>
                    <td><h2 class="text-primary">{{ $cuotasPagadas }}</h2></td>
                    <td><h2 class="text-success">{{ $cantidadCuotas }}</h2></td>
                    <td><h2 class="text-danger">{{ $cuotasSinPagar }}</h2></td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

@endif

<div class="row">
    <div class="col-3">
        <div class="form-group">
            <label>Servicio
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <input type="hidden" value="{{ $siguienteCuota->id }}" name="pago_id">
            <select name="servicio_id" id="servicio_id" class="form-control" onchange="cambiaServicio()" required>
                <option value="">SELECCIONE</option>
                @foreach ($servicios as $s)
                <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row" id="formularioMensualidad" style="display: none;">

    <div class="col-2">
        <div class="form-group">
            <label>Carrera
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <select name="carrera_id" id="carrera_id" class="form-control" required>
                @foreach ($inscripciones as $i)
                <option value="{{ $i->carrera->id }}">{{ $i->carrera->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>CUOTA
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <input type="text" class="form-control" name="numeroCuota" id="numeroCuota" value="{{ $siguienteCuota->mensualidad }}&#176; Mensualidad" required>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label>MONTO
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <input type="text" class="form-control" name="cuotaParaPagar" id="cuotaParaPagar" value="{{ $siguienteCuota->a_pagar }}" required>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label>DESCUENTO</label>
            @php
                if($siguienteCuota->descuento_persona_id == null){
                    $nombreDescuento = 'NINGUNO';
                }else{
                    $nombreDescuento = $siguienteCuota->descuento_persona->descuento->nombre;
                }
            @endphp
            <input type="text" class="form-control" name="descuentoMensualidad" id="descuentoMensualidad" value="0" required>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>TIPO DESCUENTO
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <input type="text" class="form-control" name="tipoDescuento" id="tipoDescuento" value="{{ $nombreDescuento }}" required>
        </div>
    </div>

    <div class="col-md-1">
        <div class="form-group">
            <label>PAGO
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <input type="text" class="form-control" name="tipoDescuento" id="tipoDescuento" value="" required>
        </div>
    </div>

    <div class="col-1">
        <div class="form-group">
            <label>
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <select name="carrera_id" id="carrera_id" class="form-control" required>
                <option value="total">Total</option>
                <option value="parcial">Parcial</option>
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-block btn-info" onclick="adicionaItem()">Adicionar</button>
        </div>
    </div>

</div>

<div class="row" id="formularioParcial" style="display: none;">

    <div class="col-3">
        <div class="form-group">
            <label>Carrera
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <select name="carrera_id" id="carrera_id" class="form-control" required>
                @foreach ($inscripciones as $i)
                <option value="{{ $i->carrera->id }}">{{ $i->carrera->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>IMPORTE
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <input type="text" class="form-control" name="cantidadMensualidadesParaPagar" id="cantidadMensualidadesParaPagar" value="" required>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>DESCRIPCION DEL SERVICIO
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <input type="text" class="form-control" name="descripcionMensualidad" id="descripcionMensualidad" value="Parcial" required>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-block btn-info" onclick="adicionaItem()">Adicionar</button>
        </div>
    </div>

</div>

    

</div>

<script>

    function cambiaServicio()
    {
        let servicio = $('#servicio_id').val();
        if(servicio == 2){
            $('#formularioMensualidad').show('slow');
            // $('#formularioParcial').toggle('slow');
        }else if(servicio == 8){
            $('#formularioMensualidad').hide('slow');
            $('#formularioParcial').show('slow');
        }
    }

    function adicionaItem()
    {
        let persona_id = {{ $datosPersona->id }}
        let carrera_id = $("#carrera_id").val();
        let mensualidades_a_pagar = $("#cantidadMensualidadesParaPagar").val();

        $.ajax({
            url: "{{ url('Factura/ajaxMuestraCuotasPagar') }}",
            data: {
                persona_id: persona_id,
                carrera_id: carrera_id,
                mensualidades_a_pagar: mensualidades_a_pagar
                },
            type: 'POST',
            success: function(data) {
                objetoPagos = JSON.parse(data.paraPagar);
                // console.log(objetoPagos);

                for (let [key, value] of Object.entries(objetoPagos)) {
                    console.log(value.id);
                    t.row.add([
                        value.carrera+`<input type="hidden" name="carrera_id[]" value="`+value.carrera_id+`">
                        <input type="hidden" name="pago_id[]" value="`+value.id+`">
                        <input type="hidden" name="cuota[]" value="`+value.cuota+`">`,
                        value.cuota+'&#186; Mensualidad',
                        value.descuento,
                        value.pagar,
                        '<button type="button" class="btnElimina btn btn-danger" title="Elimina Producto"><i class="fas fa-trash-alt"></i></button>'
                    ]).draw(false);                }

                
            
            }
        });

    }
</script>