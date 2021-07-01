<div class="row">
    <div class="col">
        <h4>
            <span class="text-info">CARNET: </span>
            {{ $datosPersona->cedula }}
        </h4>
    </div>
    <div class="col">
        <input type="hidden" name="persona_id" value="{{ $datosPersona->id }}">
        <h4>
            <span class="text-info">APELLIDO PATERNO: </span>
            {{ $datosPersona->apellido_paterno }}
        </h4>
    </div>

    <div class="col">
        <h4>
            <span class="text-info">APELLIDO MATERNO: </span>
            {{ $datosPersona->apellido_materno }}
        </h4>
    </div>

    <div class="col">
        <h4>
            <span class="text-info">NOMBRES: </span>
            {{ $datosPersona->nombres }}
        </h4>
    </div>

    <div class="col">
        <h4>
            <span class="text-info">FECHA NACIMIENTO: </span>
            {{ $datosPersona->fecha_nacimiento }}
        </h4>
    </div>

</div>


{{-- <div class="row">
    <div class="col-md-12">
        <button type="submit" class="btn btn-block btn-primary">RESUMEN PAGOS</button>
    </div>
</div> --}}

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

@if ($descuentos->count() > 0)
    
<div class="row" style="display: none;">
    <div class="col-md-12">
        
        <table class="table table-sm mb-0">
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
<br>
<div class="card border-primary">
    <div class="card-header bg-primary">
        <h4 class="mb-0 text-white">REGISTRAR PENSIONES</h4></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Carrera
                        <span class="text-danger">
                            <i class="mr-2 mdi mdi-alert-circle"></i>
                        </span>
                    </label>
                    <select name="carrera_id" id="carrera_id" class="form-control" onchange="cambiaCarreraPension();">
                        <option value="">Seleccione</option>
                        @foreach ($inscripciones as $i)
                        <option value="{{ $i->carrera->id }}">{{ $i->carrera->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row" id="ajaxNumeroCuota"></div>
            </div>
        </div>

    </div>
</div>

<div class="card border-secondary">
    <div class="card-header bg-secondary">
        <h4 class="mb-0 text-white">ITEMS A FACTURAR</h4></div>
        <div class="card-body" id="ajaxMuestraItemsAPagar">
            

        </div>
</div>

<hr>
<div class="row">
    <div class="col-md-12">
        <h3>Registrar Pensiones</h3>
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

    function cambiaCarreraPension()
    {
        let carrera = $("#carrera_id").val();
        let persona_id = {{ $datosPersona->id }};

        $.ajax({
            url: "{{ url('Factura/ajaxMuestraCuotaAPagar') }}",
            data: {
                carrera_id: carrera,
                persona_id: persona_id
            },
            type: 'GET',
            success: function(data) {
                $("#ajaxNumeroCuota").html(data);
            }
        });

        
    }
</script>