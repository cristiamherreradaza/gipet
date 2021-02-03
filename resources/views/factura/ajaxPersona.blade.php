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
                    <th>Descuento</th>
                    <th>Pago</th>
                    <th>Cuotas Promo</th>
                    <th>Cuotas Pagadas</th>
                    <th>Total Cuotas</th>
                    <th>Cuotas Pendientes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($descuentos as $d)
                @php
                    $pagos = App\Pago::where('persona_id', $d->persona_id)
                        ->where('carrera_id', $d->carrera_id)
                        ->where('anio_vigente', $d->anio_vigente)
                        ->count();

                    $pagosPromo = App\Pago::where('persona_id', $d->persona_id)
                        ->where('carrera_id', $d->carrera_id)
                        ->where('anio_vigente', $d->anio_vigente)
                        ->whereNotNull('descuento_persona_id')
                        ->count();
                    
                    $siguienteCuota = App\Pago::where('persona_id', $d->persona_id)
                        ->where('carrera_id', $d->carrera_id)
                        ->where('anio_vigente', $d->anio_vigente)
                        ->where('faltante', '>', 0)
                        ->get();
                    
                    if($siguienteCuota->count() > 0){
                        $numeroCouta = $siguienteCouta->mensualidad;
                    }else{
                        $numeroCuota = 1;
                    }

                    $cuotasPagadasPromo = App\Pago::where('persona_id', $d->persona_id)
                        ->where('carrera_id', $d->carrera_id)
                        ->where('anio_vigente', $d->anio_vigente)
                        ->whereNotNull('descuento_persona_id')
                        ->get();

                    
                    // dd($pagos);
                    $cuotaSinDescuento = App\Servicio::find(2); 

                    $cuotasPendientes = $d->tipo_mensualidad->numero_maximo - $pagos

                @endphp
                <tr>
                    <td style="text-align: left;">
                        {{ $d->carrera->nombre }}
                        <input type="hidden" name="carrera_id_{{ $d->carrera->id }}" id="carrera_id_{{ $d->carrera->id }}" value="{{ $d->carrera->id }}">
                    </td>
                    <td>
                        {{ $d->servicio->nombre }}
                        <input type="hidden" name="servicio_id_{{ $d->carrera->id }}" id="servicio_id_{{ $d->carrera->id }}" value="{{ $d->servicio->id }}">
                    </td>
                    <td>
                        {{ $d->descuento->nombre }}
                        <input type="hidden" name="descuento_id_{{ $d->carrera->id }}" id="descuento_id_{{ $d->carrera->id }}" value="{{ $d->descuento->id }}">
                    </td>
                    <td>
                        {{ $d->a_pagar }}
                        <input type="hidden" name="pagar_{{ $d->carrera->id }}" id="pagar_{{ $d->carrera->id }}" value="{{ $d->a_pagar }}">
                    </td>
                    <td>
                        {{ $d->cantidad_cuotas }}
                        <input type="hidden" name="cuotas_descuento_{{ $d->carrera->id }}" id="cuotas_descuento_{{ $d->carrera->id }}" value="{{ $d->cantidad_cuotas }}">
                    </td>
                    <td>
                        {{ $pagos }}
                        <input type="hidden" name="pagados_{{ $d->carrera->id }}" id="pagados_{{ $d->carrera->id }}" value="{{ $pagos }}">
                    </td>
                    <td>
                        {{ $d->tipo_mensualidad->numero_maximo }}
                        <input type="hidden" name="total_cuotas_{{ $d->carrera->id }}" id="total_cuotas_{{ $d->carrera->id }}" value="{{ $d->tipo_mensualidad->numero_maximo }}">
                    </td>
                    <td>
                        {{ $cuotasPendientes }}
                        <input type="hidden" name="cuotas_pendientes_{{ $d->carrera->id }}" id="cuotas_pendientes_{{ $d->carrera->id }}" value="{{ $cuotasPendientes }}">
                    </td>
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
            <label>CANTIDAD CUOTAS
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <input type="text" class="form-control" name="cantidadMensualidades" id="cantidadMensualidades" value="" required>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label>DESCRIPCION DEL SERVICIO
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            <input type="text" class="form-control" name="descripcionMensualidad" id="descripcionMensualidad" value="Mensualidad" required>
        </div>
    </div>

</div>

    <div class="col-md-2">
        <div class="form-group">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-block btn-info" onclick="adicionaItem()">Adicionar</button>
        </div>
    </div>

</div>

<script>
    function cambiaServicio()
    {
        let servicio = $('#servicio_id').val();
        if(servicio == 2){
            $('#formularioMensualidad').show('slow');
        }
    }

    function adicionaItem()
    {
        let carrera               = Number($("#carrera_id").val());
        let numeroCouta           = {{ $numeroCuota }}
        let cuotasPagadasPromo    = {{ $cuotasPagadasPromo }};
        let cantidadMensualidades = Number($("#cantidadMensualidades").val());
        let cuotasPromo           = Number($("#cuotas_descuento_"+carrera).val());
        let cuotasParaPromo       = cuotasPromo - cuotasPagadasPromo;
        let precioCuotaPromo      = Number($("#pagar_"+carrera).val());
        let precioCuotaSinPromo   = {{ $cuotaSinDescuento->precio }}
        let cuotasSinPromo        = cantidadMensualidades - cuotasParaPromo;
        

        // console.log(cuotasSinPromo);

        // para llenar la tabla con las cuotas de promocion
        var c = numeroCouta;
        for (let i = 0; i < cuotasPromo; i++) {
            t.row.add([
                '1',
                c+'&#186; Mensualidad',
                precioCuotaPromo,
                '<button type="button" class="btnElimina btn btn-danger" title="Elimina Producto"><i class="fas fa-trash-alt"></i></button>'
            ]).draw(false);
            c++;
        }
        // fin para llenar la tabla con las cuotas de promocion
        // console.log(c);

        // para llenar la tabla con las cuotas de normales
        // let c = numeroCouta;
        for (let j = c; j <= cantidadMensualidades; j++) {
            t.row.add([
                '1',
                c+'&#186; Mensualidad',
                precioCuotaSinPromo,
                '<button type="button" class="btnElimina btn btn-danger" title="Elimina Producto"><i class="fas fa-trash-alt"></i></button>'
            ]).draw(false);
            c++;
        }

        // console.log(c);

        // fin para llenar la tabla con las cuotas de normales


    }
</script>