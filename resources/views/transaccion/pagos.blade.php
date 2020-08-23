@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')

<form action="{{ url('Venta/guardaVenta') }}" id="formularioVenta" method="POST">
    @csrf

    <div class="row">
        <div class="col-md-12">
        
            <div class="card border-dark">
                <div class="card-header bg-dark">
                    <h4 class="mb-0 text-white">DATOS DEL CLIENTE</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Carnet Identidad</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="carnet" name="carnet">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="ti-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Nombre Cliente</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" readonly id="nombre" name="nombre">
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">NIT</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="nit" name="nit">
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Razon Social</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="razon_social_cliente" name="razon_social_cliente">
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="card border-info">
                        <div class="card-header bg-info">
                            <h4 class="mb-0 text-white">CONCEPTO</h4>
                        </div>
                        <div class="card-body" id="concepto">
                            
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card border-danger">
                        <div class="card-header bg-danger">
                            <h4 class="mb-0 text-white">DESCRIPCION</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive m-t-40">
                                <table id="tablaDetalle" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cantidad</th>
                                            <th>Codigo</th>
                                            <th>Descripcion</th>
                                            <th>Concepto</th>
                                            <th>Carrera</th>
                                            <th>Asignatura</th>
                                            <th class="w-10 text-center">Total Bs.</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="datos_tabla">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-header bg-primary">
                    <h4 class="mb-0 text-white">DETALLE</h4>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td>TOTAL</td>
                                    <td><input type="text" class="form-control text-right" name="totalCompra"
                                            id="resultadoSubTotales" style="width: 120px;" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td>EFECTIVO</td>
                                    <td><input type="number" name="efectivo" id="efectivo"
                                            class="form-control text-right text-right" step="any" value="0"
                                            style="width: 120px;"></td>
                                </tr>
                                <tr>
                                    <td>CAMBIO</td>
                                    <td><input type="number" name="cambioVenta" id="cambioVenta"
                                            class="form-control text-right text-right" step="any" value="0"
                                            style="width: 120px;" readonly></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h6 class="text-info" id="montoLiteral"></h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <a class="btn waves-effect waves-light btn-block btn-success text-white" onclick="validaItems()">REGISTRAR PAGO</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>

@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/NumeroALetras.js') }}"></script>
<script src="{{ asset('dist/js/feather.min.js') }}"></script>
<script>
    $('#carnet').on('change', function(e){
        var carnet = e.target.value;
     // $(document).on('keyup', '#carnet', function(e) {
     //    carnet = $('#carnet').val();
            $.ajax({
                url: "{{ url('Transaccion/verifica_ci') }}",
                data: {ci: carnet},
                type: 'GET',
                success: function(data) {
                    // $("#concepto").html(data);
                    // console.log(data.consulta.length);
                var nombre_completo = data.nombres.concat(' ', data.apellido_paterno, ' ', data.apellido_materno);
                    $("#nombre").val(nombre_completo);
                    $("#nit").val(data.nit);
                    $("#razon_social_cliente").val(data.razon_social_cliente);

                    $.ajax({
                        url: "{{ url('Transaccion/consulta') }}",
                        data: {termino: data.consulta},
                        type: 'GET',
                        success: function(data) {
                            // $("#listadoProductosAjax").show('slow');
                            // $("#listadoProductosAjax").html(data);
                            $("#concepto").html(data);
                        }
                    });


                    // // var num = data.consulta.length;
                    // // var ser = '<option value="">Seleccionar</option>\
                    // //            <option value="">Caja</option>';
                    // $.each(data.servicios, function(index, value) {
                    //     var serv = '<option value="">Seleccionar</option>\
                    //                 <option value="">' + data.servicios[index].servicio_id + '\
                    //             ';
                    // });
                    // $("#servicio_id").html(serv);
                    //     // $("#servicio_id").html(ser);
                }
            });

    });
</script>

<script>    
    var room = 1;
    // var cantidad = 1;
    function guarda_tabla() {
        var cantidad = $("#cantidad").val();
        var servicio_id = $("#servicio_id").val();
        var carrera_id = $("#carrera_id").val();
        var asignatura_id = $("#asignatura_id").val();
        var total = $("#total").val();

        room++;
        // cantidad++;
        var objTo = document.getElementById('datos_tabla')
        var tdtest = document.createElement("tr");
        tdtest.setAttribute("class", "removeclass" + room);
        var rtd = 'removeclass' + room;
        tdtest.innerHTML = '<td>'+cantidad+'</td>\
                            <td>'+servicio_id+'</td>\
                            <td>'+servicio_id+'</td>\
                            <td>'+cantidad+'</td>\
                            <td>'+carrera_id+'</td>\
                            <td>'+asignatura_id+'</td>\
                            <td>'+total+'</td>\
                            <td class="col-sm-2">\
                                <div class="form-group">\
                                    <button class="btn btn-danger" type="button" onclick="remove_education_fields(' + room + ');"> <i class="fa fa-minus"></i>\
                                    </button>\
                                </div>\
                            </td>';

        objTo.appendChild(tdtest)
    }

    function remove_education_fields(rid) {
        $('.removeclass' + rid).remove();
        // cantidad--;
        // $('#cantidad').val(cantidad);
    }

</script>


<script>
    // tabla de pedidos por unidad
    var t = $('#tablaPedido').DataTable({
        paging: false,
        searching: false,
        ordering:  false,
        info: false,
        language: {
            url: '{{ asset('datatableEs.json') }}'
        },
    });

    // tabla de pedidos al por mayor
    var tm = $('#tablaPedidoMayor').DataTable({
        paging: false,
        searching: false,
        ordering:  false,
        info: false,
        language: {
            url: '{{ asset('datatableEs.json') }}'
        },
    });

    // array para controlar la cantidad de items en pedido unitario
    var itemsPedidoArray = [];
    var itemsPedidoArrayMayor = [];

    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        $(".select2").select2();

        // elimina productos de la tabla por unidad
        $('#tablaPedido tbody').on('click', '.btnElimina', function () {
            t.row($(this).parents('tr'))
                .remove()
                .draw();
            let itemBorrar = $(this).closest("tr").find("td:eq(0)").text();
            let pos = itemsPedidoArray.lastIndexOf(itemBorrar);
            itemsPedidoArray.splice(pos, 1);
            sumaSubTotales();
        });

        // elimina productos de la tabla por mayor
        $('#tablaPedidoMayor tbody').on('click', '.btnEliminaMayor', function () {
            tm.row($(this).parents('tr'))
                .remove()
                .draw();
            let itemBorrarMayor = $(this).closest("tr").find("td:eq(0)").text();
            let posMayor = itemsPedidoArrayMayor.lastIndexOf(itemBorrarMayor);
            itemsPedidoArrayMayor.splice(posMayor, 1);
            sumaSubTotales();
        });


        $(document).on('keyup change', '#efectivo', function () {
            // alert("cambio");
            let totalVenta = Number($("#resultadoSubTotales").val());
            // console.log(totalVenta);
            let efectivo = Number($("#efectivo").val());
            let cambio = efectivo - totalVenta; 
            if (cambio > 0) {
                $("#cambioVenta").val(cambio);
            }else{
                $("#cambioVenta").val(0);
            }
        });

    });

    // calcula el precio en funcion al cambio de precios tabla unidades
    $(document).on('keyup change', '.precio', function(e){
        let precio = Number($(this).val());
        let id = $(this).data("id");
        let cantidad = Number($("#cantidad_"+id).val());
        let subtotal = precio*cantidad;
        $("#subtotal_"+id).val(subtotal);
        sumaSubTotales();
    });

    // calcula el precio en funcion a la cantidad tabla unidades
    $(document).on('keyup change', '.cantidad', function(e){
        // alert("cambio");
        let cantidad = Number($(this).val());
        let id = $(this).data("id");
        let precio = Number($("#precio_"+id).val());
        let subtotal = precio*cantidad;
        console.log(precio);
        $("#subtotal_"+id).val(subtotal);
        sumaSubTotales();
    });

    // calcula el precio en funcion al cambio de precios tabla mayores
    $(document).on('keyup change', '.precioMayor', function(e){
        let precioMayor = Number($(this).val());
        let idm = $(this).data("idm");
        let cantidadMayor = Number($("#cantidad_m_"+idm).val());
        let subtotalMayor = precioMayor*cantidadMayor;
        $("#subtotal_m_"+idm).val(subtotalMayor);
        sumaSubTotales();
    });

    // calcula el precio en funcion al cambio de cantidad tabla mayores
    $(document).on('keyup change', '.cantidadMayor', function(e){
        let cantidadMayor = Number($(this).val());
        let idm = $(this).data("idm");
        let precioMayor = Number($("#precio_m_"+idm).val());
        let subtotalMayor = precioMayor*cantidadMayor;
        $("#subtotal_m_"+idm).val(subtotalMayor);
        sumaSubTotales();
    });

    function sumaSubTotales()
    {
        let sum = 0;

        $('.subtotal, .subtotalMayor').each(function(){
            sum += parseFloat(this.value);
        });
        // sumaVisible = sum.toLocaleString('en', {useGrouping:true});
        
        $("#resultadoSubTotales").val(sum);
        valorLiteral = numeroALetras(sum, {
            plural: 'Bolivianos',
            singular: 'Bolivianos',
            centPlural: 'Centavos',
            centSingular: 'Centavo'
        });
        $("#montoLiteral").html(valorLiteral);
        // console.log(valor);
    }

    $(document).on('keyup', '#termino', function(e) {
        termino_busqueda = $('#termino').val();
        if (termino_busqueda.length > 3) {
            $.ajax({
                url: "{{ url('Venta/ajaxBuscaProductoTienda') }}",
                data: {termino: termino_busqueda},
                type: 'POST',
                success: function(data) {
                    $("#listadoProductosAjax").show('slow');
                    $("#listadoProductosAjax").html(data);
                }
            });
        }

    });

    function adicionaPedido(item)
    {
        /*var item = $("#item_"+item).closest("tr").find('td').each(function(){
    console.log(this.text);
            });*/
        var item = $("#item_" + item).closest("tr").find('td').text();
        console.log(item);
    }

    function eliminar_pedido()
    {
        var id = $("#id_pedido").val();
        Swal.fire({
            title: 'Estas seguro de eliminar este pedido?',
            text: "Luego no podras recuperarlo!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Excelente!',
                    'El Pedido fue eliminado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Pedido/eliminar') }}/"+id;
                });
            }
        })
    }

    function muestraPromo(promoId)
    {
        // console.log(promoId);
        $.ajax({
            url: "{{ url('Combo/ajaxMuestraPromo') }}",
            data: {combo_id: promoId},
            type: 'POST',
            success: function(data) {
                // $("#listadoProductosAjax").show('slow');
                $("#muestraAjaxPromo").html(data);
            }
        });

        $("#danger-header-modal").modal("show");
    // alert(promoId);
    }

    function muestraExistencias(productoId)
    {
        $.ajax({
            url: "{{ url('Movimiento/ajaxMuestraTotalesAlmacen') }}",
            data: {producto_id: productoId},
            type: 'POST',
            success: function(data) {
                $("#ajaxMuestraTotalesAlmacenes").html(data);
            }
        });

        // $("#danger-header-modal").modal("show");

        $("#warning-header-modal").modal("show");
        //ajaxMuestraTotalesAlmacenes
    }

    function validaItems()
    {
        // verificamos que la venta tengan productos
        if (itemsPedidoArray.length > 0 || itemsPedidoArrayMayor.length > 0) {
            // verificamos que las cantidades sean las correctas
            if ($("#formularioVenta")[0].checkValidity()) {
                Swal.fire({
                    type: 'success',
                    title: 'Excelente',
                    text: 'Se realizo la venta'
                });
                $("#formularioVenta").submit();
            }else{
                $("#formularioVenta")[0].reportValidity();
            }
        } else {
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Tienes que adicionar un producto a la venta!!!'
            })
            // alert("llena carajo");
        }
    }

    function seleccionaCliente()
    {
        let nombreCliente = $("#cliente_id").find(':selected').text();
        $("#tagCliente").html('EDITA -'+nombreCliente);
        $("#tag_edita_cliente").show();
    }

    function nuevoCliente()
    {
        $("#nombre_usuario").focus();
        $("#nombre_usuario").val('');
        $("#email_usuario").val('');
        $("#password_usuario").val('');
        $("#celular_usuario").val('');
        $("#razon_social_usuario").val('');
        $("#nit_usuario").val('');
        $("#success-header-modal").modal("show");
    }

    function guardaAjaxCLiente()
    {
        let datosFormularioAjaxCliente = $("#formularioAjaxNuevoCliente").serializeArray();
        if ($("#formularioAjaxNuevoCliente")[0].checkValidity()) {
            $.ajax({
                url: "{{ url('Cliente/ajaxGuardaCliente') }}",
                data: datosFormularioAjaxCliente,
                type: 'POST',
                success: function (data) {
                    if (data.validaEmail == 1) {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'El email ya existe!!!'
                        })
                    } else {

                        $("#ajaxComboClienteNuevo").load('{{ url("Cliente/ajaxComboClienteNuevo") }}/'+data.clienteId);
                        $("#success-header-modal").modal("hide");

                        Swal.fire({
                            type: 'success',
                            title: 'Excelente!',
                            text: 'Cliente registrado'
                        })
                        // console.log(data.clienteId);
                        // $("#cliente_id").val(data.clienteId);

                    }
                    // $("#ajaxMuestraTotalesAlmacenes").html(data);
                }
            });
        }else{
            $("#formularioAjaxNuevoCliente")[0].reportValidity();
        }
    }

    function validaEmail()
    {
        let correo_cliente = $("#email_usuario").val();
        $.ajax({
            url: "{{ url('Cliente/ajaxVerificaCorreo') }}",
            data: { correo: correo_cliente },
            type: 'POST',
            success: function(data) {
                if (data.valida == 1) {
                    $("#msgValidaEmail").show();
                    // $("#btnGuardaCliente").hide();
                }else{
                    $("#msgValidaEmail").hide();
                    $("#btnGuardaCliente").show();
                }
            }
        });
        // console.log($("#email_usuario").val());
    }

    function editaCliente()
    {
        let clienteId = $("#cliente_id").find(':selected').val();
        $.ajax({
            url: "{{ url('Cliente/ajaxEditaCliente') }}",
            data: { clienteId: clienteId },
            type: 'POST',
            success: function(data) {
                $("#ajaxFormEditaCliente").html(data);
            }
        });

        $("#modalEditaCliete").modal("show");

    }

    function guardaAjaxCLienteEdicion()
    {
        // console.log("entro");
        let datosFormularioAjaxEditaCliente = $("#formularioAjaxEditaCliente").serializeArray();
        console.log(datosFormularioAjaxEditaCliente);
        if ($("#formularioAjaxEditaCliente")[0].checkValidity()) {
            $.ajax({
                url: "{{ url('Cliente/guardaAjaxClienteEdicion') }}",
                data: datosFormularioAjaxEditaCliente,
                type: 'POST',
                success: function (data) {
                    if (data.msg != 1) {
                        Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'No se puedo realizar la edicion'
                        })
                    } else {

                        $("#ajaxComboClienteNuevo").load('{{ url("Cliente/ajaxComboClienteNuevo") }}/'+data.clienteId);
                        // $("#success-header-modal").modal("hide");

                        Swal.fire({
                            type: 'success',
                            title: 'Excelente!',
                            text: 'Cliente registrado'
                        })
                        // console.log(data.clienteId);
                        // $("#cliente_id").val(data.clienteId);

                    }
                    $("#modalEditaCliete").modal("hide");
                    // $("#ajaxMuestraTotalesAlmacenes").html(data);
                }
            });
        }else{
            $("#formularioAjaxNuevoCliente")[0].reportValidity();
        }
    }

</script>
@endsection