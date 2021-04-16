<h1 class="text-center text-dark-info"><strong>Carreras</strong></h1>
<div class="row">
    <div class="col-md-12">
        <form action="{{ url('Inscripcion/inscribirCarrera') }}" method="POST">
            @csrf
            <input type="text" name="persona_id" id="persona_id" value="{{ $persona->id }}" hidden>
            <div class="form-body">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Carrera
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" id="nueva_carrera" name="nueva_carrera" onchange="cambiaCarrera()" required>
                                    @foreach($carreras as $carrera)
                                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Turno
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" id="nuevo_turno" name="nuevo_turno" required>
                                    @foreach($turnos as $turno)
                                        <option value="{{ $turno->id }}">{{ $turno->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Paralelo
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" id="nuevo_paralelo" name="nuevo_paralelo" required>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Gesti&oacute;n</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="number" class="form-control" id="nueva_gestion" name="nueva_gestion" value="{{ date('Y') }}"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">Fecha de Inscripcion</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input type="date" name="nueva_fecha_inscripcion" id="nueva_fecha_inscripcion" class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Cantidad Mensualidades
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>

                                <div id="ajaxTiposMensualidades">

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
                        
                                @if($descuentos->count() > 0)
                                    <select class="form-control custom-select" id="descuento" name="descuento" required onchange="ajaxMuestraMontos()">
                                        @foreach($descuentos as $d)
                                            <option value="{{ $d->id }}">{{ $d->nombre }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <option value="">No Disponible</option>
                                @endif
                            </div>

                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Descuento </label>
                                <input type="number" class="form-control" name="monto" id="monto" value="0" max="{{ $montoSinDescuento->a_pagar }}" min="0" onkeyup="calculaMensualidad()">
                            </div>
                        </div>
                        
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>A Pagar </label>
                                <input type="number" class="form-control" name="pagar" id="pagar" value="{{ $montoSinDescuento->a_pagar }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Cuot./Promo</label>
                                <input type="number" class="form-control" name="cantidadCuotasPromo" id="cantidadCuotasPromo" min="0" value="0">
                                <input type="hidden" name="cantidadMensualidades" id="cantidadMensualidades" value="10">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Inicio/Promo</label>
                                <input type="number" class="form-control" name="cuotaInicioPromo" id="cuotaInicioPromo" min="0" value="0">
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">&nbsp;</label>
                                <button type="submit" class="btn btn-block btn-info">Inscribir</button>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped no-wrap" id="tablaProductosEncontrados">
        <thead>
            <tr>
                <th>#</th>
                <th>Carrera</th>
                <th>Curso</th>
                <th>Turno</th>
                <th>Paralelo</th>
                <th>Gestion</th>
                <th>Estado</th>
                <th class="text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscripciones as $key => $c)
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>{{ $c->carrera->nombre }}</td>
                    <td>{{ $c->gestion }}&ordm; A&ntilde;o</td>
                    <td>{{ $c->turno->descripcion }}</td>
                    <td>{{ $c->paralelo }}</td>
                    <td>{{ $c->anio_vigente }}</td>
                    <td>{{ $c->estado }}</td>
                    <td>
                        <a href="{{ url('Inscripcion/reinscripcion/'.$persona->id.'/'.$c->carrera_id) }}" class="btn btn-success" title="Reinscribir"><i class="fas fa-plus"></i>&nbsp; REINSCRIBIR</a>
                        {{-- @if($c == $comparacion) --}}
                        {{-- <a href="{{ url('Inscripcion/convalidar/'.$persona->id.'/'.$detalle->id) }}" class="btn btn-warning" title="Convalidar"><i class="fas fa-arrows-alt-h"></i></a> --}}
                        {{-- @else --}}
                        {{-- <button class="btn btn-warning" title="Convalidar" disabled><i class="fas fa-arrows-alt-h"></i></button> --}}
                        {{-- @endif --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function validaItems()
    {
        var nueva_carrera           = $("#nueva_carrera").val();
        var nuevo_turno             = $("#nuevo_turno").val();
        var nuevo_paralelo          = $("#nuevo_paralelo").val();
        var nueva_gestion           = $("#nueva_gestion").val();
        var nueva_fecha_inscripcion = $("#nueva_fecha_inscripcion").val();
        if(nueva_carrera.length > 0 && nuevo_turno.length > 0 && nuevo_paralelo.length > 0 && nueva_gestion.length > 0 && nueva_fecha_inscripcion.length > 0){
            //alert('ok');
        }else{
            event.preventDefault();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Tienes que adicionar al menos un producto.'
            })
        }
    }

    function cambiaCarrera()
    {
        let carrera = $("#nueva_carrera").val();
        
        $.ajax({
            url: "{{ url('Persona/ajaxMuestraMensualidades') }}",
            data: {
                carrera : carrera
                },
            type: 'get',
            success: function(data) {
                // let objMontos = JSON.parse(data);
                $("#ajaxTiposMensualidades").html(data);
                // $("#pagar").val(objMontos.a_pagar);
                // $("#ajaxMuestraMontos").html(data);
                // console.log(objMontos.monto);
            }
        });
    }
</script>