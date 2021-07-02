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

<hr />

<div class="row">
    
    <div class="col-md-2">
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

    <div class="col-md-10">
        <div class="row" id="ajaxNumeroCuota"></div>

    </div>

</div>

<script>

    function cambiaServicio()
    {
        let servicio = $('#servicio_id').val();

        if(servicio == 2){

            let persona_id = {{ $datosPersona->id }};

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