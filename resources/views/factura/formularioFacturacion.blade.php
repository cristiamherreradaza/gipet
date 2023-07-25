@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card border-info" id="mostrar" style="display:block;">
        <div class="card-header bg-info">
            <h4 class="mb-0 text-white">
                BUSQUEDA DE ALUMNOS
            </h4>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>CARNET</label>
                        <input type="number" class="form-control termino" name="cedula" id="cedula">
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label>PATERNO</label>
                        <input type="text" class="form-control termino" name="apellido_paterno" id="apellido_paterno">
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label>MATERNO</label>
                        <input type="text" class="form-control termino" name="apellido_materno" id="apellido_materno">
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label>NOMBRES</label>
                        <input type="text" class="form-control termino" name="nombres" id="nombres">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12" id="ajaxPersonas">
                    <table class="table-striped table-hover table-bordered table no-wrap" id="tabla-alumnos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CEDULA</th>
                                <th>APELLIDO PATERNO</th>
                                <th>APELLIDO MATERNO</th>
                                <th>NOMBRES</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($personas as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->cedula }}</td>
                                <td>{{ $p->apellido_paterno }}</td>
                                <td>{{ $p->apellido_materno }}</td>
                                <td>{{ $p->nombres }}</td>
                                <td>
                                    <button type="button" class="btn btn-success" title="PAGOS" onclick="selecciona({{ $p->id }})">
                                        <i class="fas fa-donate"></i>
                                    </button>
                                    <button onclick="ver_persona('{{ $p->id }}')" type="button" class="btn btn-info" title="ACADEMICO"><i
                                            class="fas fa-list"></i></button>
                                    <button onclick="eliminar_persona('{{ $p->id }}', '{{ $p->cedula }}')" type="button"
                                        class="btn btn-danger" title="ELIMINAR"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12" id="ajaxDatosPersona">

                </div>
            </div>

        </div>


    </div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<!-- This Page JS -->
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/forms/select2/select2.init.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js"></script>

<script>

    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('#tabla-alumnos').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
            searching: false,
            lengthChange: false,
            order: [[ 0, "desc" ]]
        });
    });


    $(document).on('keyup', '.termino', function(e) {

        let cedula = $('#cedula').val();
        let apellido_paterno = $('#apellido_paterno').val();
        let apellido_materno = $('#apellido_materno').val();
        let nombres = $('#nombres').val();

        // console.log(cedula);

        if (cedula.length > 3 || apellido_paterno.length > 3 || apellido_materno.length > 3 || nombres.length > 3) {
            // alert('si paso');
            $.ajax({
                url: "{{ url('Factura/ajaxBuscaPersona') }}",
                data: {
                    cedula: cedula,
                    apellido_paterno: apellido_paterno,
                    apellido_materno: apellido_materno,
                    nombres: nombres,
                },
                type: 'POST',
                success: function(data) {
                    $("#ajaxPersonas").show('slow');
                    $("#ajaxPersonas").html(data);
                }
            });
        }

    });

    var t = $('#pensiones').DataTable({
        paging: false,
        searching: false,
        ordering:  false,
        info: false,
        language: {
            url: '{{ asset('datatableEs.json') }}'
        },
    });

    function ver_persona(persona_id){
        window.location.href = "{{ url('Persona/informacion') }}/" + persona_id;
    }

    function eliminar_persona(persona_id, cedula){
        Swal.fire({
            title: 'Desea eliminar al estudiante con cedula ' + cedula + '?',
            text: "Luego no podras recuperarlo!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ url('Persona/eliminar_persona') }}",
                    data: {
                        persona_id: persona_id
                        },
                    cache: false,
                    type: 'post',
                    success: function(data) {
                        Swal.fire(
                            'Excelente!',
                            'El estudiante fue eliminado',
                            'success'
                        )
                        // window.location.href = "{{ url('Factura/formularioFacturacion') }}/";
                    }
                });
            }
        })
    }

    function selecciona(personaId)
    {
        $.ajax({
            url: "{{ url('Factura/ajaxPersona') }}",
            data: {personaId: personaId},
            type: 'POST',
            success: function(data) {
                $("#ajaxPersonas").hide('slow');
                $("#ajaxDatosPersona").html(data);
            }
        });
    }

    function generaFacturaLinea(){

        if($("#formularioGeneraFactura")[0].checkValidity()){
            //PONEMOS TODO AL MODELO DEL SIAT EL DETALLE
            detalle = [];
            arrayProductos.forEach(function (prod){
                detalle.push({
                    actividadEconomica:prod.codigoActividad,
                    codigoProductoSin:prod.codigoProducto,
                    codigoProducto:prod.servicio_id,
                    descripcion:prod.mensualidad+" "+prod.nombre,
                    cantidad:1,
                    unidadMedida:prod.unidadMedida,
                    precioUnitario:prod.importe,
                    montoDescuento:prod.descuento,
                    subTotal:((1*prod.importe)-prod.descuento)
                })
            })

            let numero_factura = $('#numero_factura').val();
            let cuf = "123456789";//cambiar
            let cufd = "{{ session('scufd') }}";  //solo despues de que aga
            let direccion = "{{ session('sdireccion') }}";//solo despues de que aga
            let fechaEmision;
            let cafc = null;

            if($('input[name="uso_cafc"]:checked').val() === "si"){
                //var tzoffset = ((new Date()).getTimezoneOffset()*60000);
                //let fechaEmision = ((new Date(Date.now()-tzoffset)).toISOString()).slice(0,-1);
                {{--  var fecha = new Date($('#fecha_uso_cafc').val());
                var tzoffset = ((new Date()).getTimezoneOffset()*60000);
                fechaEmision = ((new Date(fecha-tzoffset)).toISOString()).slice(0,-1);  --}}
                cafc = $('#codigo_cafc_contingencia').val();
            }else{
                {{--  var tzoffset = ((new Date()).getTimezoneOffset()*60000);
                fechaEmision = ((new Date(Date.now()-tzoffset)).toISOString()).slice(0,-1);  --}}
            }

            var tzoffset = ((new Date()).getTimezoneOffset()*60000);
            fechaEmision = ((new Date(Date.now()-tzoffset)).toISOString()).slice(0,-1);

            let nombreRazonSocial = $('#razon_factura').val();
            let codigoTipoDocumentoIdentidad = $('#tipo_documento').val()
            let numeroDocumento = $('#nit_factura').val();
            let complemento = $('#complementoPersonaFac').val();
            let montoTotal = $('#motoTotalFac').val();
            let descuentoAdicional = $('#descuento_adicional').val();
            let leyenda = "Ley N° 453: El proveedor deberá suministrar el servicio en las modalidades y términos ofertados o convenidos.";
            let usuario = "{{ Auth::user()->nombre_usuario }}";
            let nombreEstudiante = $('#nombreCompletoEstudiante').val();
            let periodoFacturado = detalle[(detalle.length)-1].descripcion+" / "+$('#anio_vigente_cuota_pago').val();

            var factura = [];
            factura.push({
                cabecera: {
                    nitEmisor:"178436029",
                    razonSocialEmisor:'INSTITUTO TECNICO "EF-GIPET" S.R.L.',
                    municipio:"La Paz",
                    telefono:"73717199",
                    numeroFactura:numero_factura,
                    cuf:cuf,
                    cufd:cufd,
                    codigoSucursal:0,
                    direccion:direccion ,
                    codigoPuntoVenta:0,
                    //codigoPuntoVenta:{{ Auth::user()->codigo_punto_venta }},
                    fechaEmision:fechaEmision,
                    nombreRazonSocial:nombreRazonSocial,
                    codigoTipoDocumentoIdentidad:codigoTipoDocumentoIdentidad,
                    numeroDocumento:numeroDocumento,
                    complemento:complemento,
                    codigoCliente:numeroDocumento,
                    nombreEstudiante:nombreEstudiante,
                    periodoFacturado:periodoFacturado,
                    codigoMetodoPago:1,
                    numeroTarjeta:null,
                    montoTotal:montoTotal,
                    montoTotalSujetoIva:montoTotal,
                    codigoMoneda:1,
                    tipoCambio:1,
                    montoTotalMoneda:montoTotal,
                    montoGiftCard:null,
                    descuentoAdicional:descuentoAdicional,//ver llenado
                    codigoExcepcion:0,
                    cafc:cafc,
                    leyenda:leyenda,
                    usuario:usuario,
                    codigoDocumentoSector:11
                }
            })

            detalle.forEach(function (prod1){
                factura.push({
                    detalle:prod1
                })
            })

            var datos = {factura};

            var datosPersona = {
                'persona_id':$('#persona_id').val(),
                'carnet':$('#cedulaPersona').val()
            };

            var datosRecepcion = {
                'uso_cafc'                  :$('input[name="uso_cafc"]:checked').val(),
                'codigo_cafc_contingencia'  :$('#codigo_cafc_contingencia').val()
            };

            $.ajax({
                url: "{{ url('Factura/emitirFactura') }}",
                data: {
                    datos           : datos,
                    datosPersona    :datosPersona,
                    datosRecepcion  :datosRecepcion,
                    modalidad       : $('#tipo_facturacion').val()
                },
                type: 'POST',
                dataType:'json',
                success: function(data) {

                    console.log(data);

                    if(data.estado === "VALIDADA"){
                        Swal.fire({
                            type: 'success',
                            title: 'Excelente!',
                            text: 'LA FACTURA FUE VALIDADA',
                            timer: 3000
                        })
                        window.location.href = "{{ url('Factura/listadoPagos')}}"
                    }else if(data.estado === "error_email"){
                        Swal.fire({
                            type: 'error',
                            title: 'Error!',
                            text: data.msg,
                        })
                    }else if(data.estado === "OFFLINE"){
                        Swal.fire({
                            type: 'warning',
                            title: 'Exito!',
                            text: 'LA FACTURA FUERA DE LINEA FUE REGISTRADA',
                        })
                        //window.location.href = "{{ url('Factura/listadoPagos')}}"
                        location.reload();
                    }else{
                        Swal.fire({
                            type: 'error',
                            title: 'Error!',
                            text: 'LA FACTURA FUE RECHAZADA',
                        })
                    }
                }
            });
        }else{
            $("#formularioGeneraFactura")[0].reportValidity();
        }
    }

    function funcionNueva(input, pago){
        console.log(input.value)
        let h = 350;
        if( (h-input.value) > 0  ){
            $.ajax({
                url: "{{ url('Factura/actualizaDescuento') }}",
                data: {
                    pago_id: pago,
                    valor: input.value,
                    },
                type: 'POST',
                dataType:'json',
                success: function(data) {
                    if(data.estado === 'success'){
                        $('#motoTotalFac').val((data.valor)-$('#descuento_adicional').val())
                    }
                }
            });
            $("#btn_concluir").prop("disabled", false);

        }else{
            Swal.fire({
                type: 'error',
                title: 'Error!',
                text: 'LE VALOR DEL DESCUENTO DEBE SER MAYOR A 0',
            })
            $("#btn_concluir").prop("disabled", true);

        }
    }

    function caluculaTotal(event){
        $.ajax({
            url: "{{ url('Factura/sumaTotalMonto') }}",
            data: {
                anio: $('#anio_vigente_cuota_pago').val(),
                persona: $('#persona_id').val(),
                },
            type: 'POST',
            dataType:'json',
            success: function(data) {
                $('#motoTotalFac').val((data.valor)-$('#descuento_adicional').val())
            }
        });
    }

    function preguntaUsoCafc(valor){
        console.log(valor.value)
        if(valor.value === "offline"){
            $("#bloque_uso_cafc").show('toggle');
        }else{
            $("#bloque_uso_cafc").hide('toggle');
        }
    }

    function usoCafcFactura(radio){

        console.log(radio)
        if(radio.value === "si"){
            $.ajax({
                url: "{{ url('Factura/sacaNumeroCafcUltimo') }}",
                method: "POST",
                dataType: 'json',
                success: function (data) {
                    if(data.estado === "success"){
                        {{--  $("#numero_factura_cafc").val(data.numero);  --}}
                        $("#numero_factura").val(data.numero);
                        $("#codigo_cafc_contingencia").val("111DE8BD3981C");
                    }else{
                        Swal.fire({
                            icon:   'error',
                            title:  'Error!',
                            text:   "Algo fallo"
                        })
                    }
                }
            })
        }else{
            $.ajax({
                url: "{{ url('Factura/sacaNumeroFactura') }}",
                method: "POST",
                dataType: 'json',
                success: function (data) {
                    if(data.estado === "success"){
                        $("#numero_factura").val(data.numero);
                        $("#codigo_cafc_contingencia").val("");
                    }else{
                        Swal.fire({
                            icon:   'error',
                            title:  'Error!',
                            text:   "Algo fallo"
                        })
                    }
                }
            })
        }
    }

</script>
@endsection
