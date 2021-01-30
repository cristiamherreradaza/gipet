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
                </tr>
            </thead>
            <tbody>

                @foreach ($descuentos as $d)
                <tr>
                    <td>{{ $d->carrera->nombre }}</td>
                    <td>{{ $d->servicio->nombre }}</td>
                    <td>{{ $d->descuento->nombre }}</td>
                    <td>{{ $d->a_pagar }}</td>
                    <td>{{ $d->cantidad_cuotas }}</td>
                    <td>3</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>

@endif