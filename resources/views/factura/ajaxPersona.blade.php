<div class="row">
    <div class="col">
        <h4>
            <span class="text-info">CARNET: </span>
            {{ $datosPersona->cedula }} {{ $datosPersona->complemento }}
            <input type="hidden" value="{{ $datosPersona->complemento }}" id="complementoPersonaFac"/>
            <input type="hidden" value="{{ $datosPersona->cedula }}" id="cedulaPersona"/>
        </h4>
    </div>
    <div class="col">
        <input type="hidden" name="persona_id" value="{{ $datosPersona->id }}" id="persona_id">
        <h4>
            <span class="text-info">APELLIDO PATERNO: </span>
            {{ $datosPersona->apellido_paterno }}
            <input type="hidden" value="{{ $datosPersona->apellido_paterno." ".$datosPersona->apellido_materno." ".$datosPersona->nombres }}" id="nombreCompletoEstudiante"/>
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

<hr />

<div class="row">
    <div class="col-md-12 text-center">
        @if ($verificacionSiat->estado === "success")
        <div class="row">
            <div class="col-md-6">
                <span class="badge bg-success text-white w-100">{{ $verificacionSiat->resultado->RespuestaComunicacion->mensajesList->descripcion }}</span>
            
            </div>
            <div class="col-md-3">
                CUIS: {{ (session()->has('scuis'))?  session('scuis') : '<span class="text-danger">NO existe la Cuis Vigente</span>'}}
            </div>
            <div class="col-md-3">
                CUFD: {{ session('scodigoControl')." ".str_replace("T", " ",substr(session('sfechaVigenciaCufd'), 0 , 16)) }}
            </div>
        </div>
        @else
            <span class="badge bg-danger text-white w-100">NO HAY CONECCION CON SIAT</span>
        @endif
    </div>
</div>

<div class="row">

    <div class="col-md-3">
        <div class="form-group">
            <label>Servicio
                <span class="text-danger">
                    <i class="mr-2 mdi mdi-alert-circle"></i>
                </span>
            </label>
            {{--  <select name="servicio_id" id="servicio_id" class="form-control" onchange="cambiaServicio()" required {{ ($verificacionSiat->estado === "success")? '' : 'disabled'  }}>  --}}
            <select name="servicio_id" id="servicio_id" class="form-control" onchange="cambiaServicio()" required>
                <option value="">SELECCIONE</option>
                @foreach ($servicios as $s)
                <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-9">
        <div class="row" id="ajaxNumeroCuota"></div>

    </div>

</div>

<div class="row" id="tituloPagos" style="display: none;">
    <div class="col-md-12">
        <h2 class="text-center text-info">DETALLE DE PAGOS</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-12" id="ajaxMuestraItemsAPagar">

    </div>
</div>

<script>

    {{--  var cedulaPersona  --}}

    function cambiaServicio()
    {
        let servicio = $('#servicio_id').val();
        let persona_id = {{ $datosPersona->id }};

        // en el caso que el servicio sea mensualidad
        // mostramos las cuotas a pagar
        if(servicio == 2){

            $.ajax({
                url: "{{ url('Factura/ajaxMuestraCuotaAPagar') }}",
                data: {
                    // carrera_id: carrera,
                    persona_id: persona_id
                },
                type: 'GET',
                success: function(data) {
                    $("#ajaxNumeroCuota").html(data);
                }
            });

        }else{

            $.ajax({
                url: "{{ url('Factura/ajaxPreciosServicios') }}",
                data: {
                    servicio_id: servicio,
                    persona_id: persona_id
                },
                type: 'GET',
                success: function(data) {
                    $("#ajaxNumeroCuota").html(data);
                }
            });

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

    function ajaxMuestraTablaPagos()
    {
        // alert('entro');
        // $("#ajaxMuestraItemsAPagar").load('{{ url("Factura/ajaxMuestraTablaPagos/$datosPersona->id") }}');

        let persona_id = {{ $datosPersona->id }};

        $.ajax({
            url: "{{ url('Factura/ajaxMuestraTablaPagos') }}",
            data: {
                persona_id: persona_id
            },
            type: 'GET',
            success: function(data) {
                // $("#ajaxNumeroCuota").html(data);
                $("#ajaxMuestraItemsAPagar").html(data);
            }
        });
    }
</script>
