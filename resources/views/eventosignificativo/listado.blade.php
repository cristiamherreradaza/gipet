@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('content')

<!-- inicio modal cambiar contrasena -->
<div id="modaNewEventoSignificativo" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">FORMULARIO DE NUEVO EVENTO SIGNIFICATIVO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="needs-validation" id="formularioNewEvento">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="control-label">Tipo de Evento</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="codigoEvento" id="codigoEvento" class="form-control" required>
                                    @foreach ($eventosparametricas as $eve)
                                        <option value="{{ $eve['codigoClasificador'] }}">{{ $eve['descripcion'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label class="control-label">Descripcion</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="descripcion" type="text" id="descripcion" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Fecha Inicio Evento</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                {{-- <input  type="datetime-local" name="fechainicio" id="fechainicio" class="form-control" required> --}}
                                <input type="text" id="fechainicio" name="fechainicio" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Fecha Fin Evento</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                {{-- <input type="datetime-local" name="fechafin" id="fechafin" class="form-control" required> --}}
                                <input type="text" id="fechafin" name="fechafin" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn waves-effect waves-light btn-block btn-success" onclick="agregarEventoSignificativo()">AGREGAR</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal cambiar contrasena -->


<div class="card border-info">
    <div class="card-header bg-info">
        <div class="row">
            <div class="col-md-3">
                <h4 class="mb-0 text-white">
                    Eventos Significativos
                </h4>
            </div>
            <div class="col-md-3">
                <button class="btn btn-success text-white mt-4 btn-block" onclick="abraModalAddEventoSignificativo()" >Nuevo Evento Significativo</button>
            </div>
            <div class="col-md-3">
                <form id="formularioEventosConuslta">
                    <label for="" class="text-white">Fecha del Evento:</label>
                    <input type="date" class="form-control" id="fechaEvento" required>
                </form>
            </div>
            <div class="col-md-3">
                <button class="btn btn-success text-white mt-4 btn-block" onclick="consultar()" >Consultar</button>
            </div>
        </div>
    </div>
    <div class="card-body" id="lista">
        <div id="tabla_puntos">

        </div>
    </div>
</div>
@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-datetimepicker/build/jquery.datetimepicker.full.min.js"></script>
<script>
    // Funcion para usar ajax
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        $('#fechainicio, #fechafin').datetimepicker({
            format: 'Y-m-d H:i:s',
        });
    });

    // function ajaxListado(){
    //     $.ajax({
    //         url: "{{ url('EventoSignificativo/ajaxListado') }}",
    //         cache: false,
    //         type: 'GET',
    //         dateType: 'json',
    //         success: function(data) {
    //             $('#tabla_puntos').html(data.listado);
    //         }
    //     });
    // } 

    // function modalNewPuntoVenta(){
    //     $('#nombre').val('')
    //     $('#descripcion').val('')

    //     $('#modaNewPuntoVeta').modal('show');
    // } 

    // function guardarNew(){
    //     let nombre = $('#nombre').val()
    //     let descripcion = $('#descripcion').val()
    //     $.ajax({
    //         url: "{{ url('PuntoVenta/guarda') }}",
    //         data:{
    //             nombre:nombre,
    //             descripcion:descripcion
    //         },
    //         cache: false,
    //         type: 'POST',
    //         dateType: 'json',
    //         success: function(data) {
    //             if(data.estado){
    //                 Swal.fire(
    //                     'Excelente!',
    //                     'Se creo el punto de venta',
    //                     'success'
    //                 )
    //                 ajaxListado()
    //                 $('#modaNewPuntoVeta').modal('hide');
    //             }
    //         }
    //     });
    // } 

    // function eliminaPuntoVenta(puntoventa){
    //     Swal.fire({
    //         title: 'Esta seguro de eliminar el punto de venta?',
    //         text: "Luego no podras recuperarlo!",
    //         type: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Si, estoy seguro!',
    //         cancelButtonText: "Cancelar",
    //     }).then((result) => {
    //         if (result.value) {
    //             $.ajax({
    //                 url: "{{ url('PuntoVenta/eliminaPuntoVenta') }}",
    //                 data: {
    //                     cod: puntoventa
    //                     },
    //                 cache: false,
    //                 type: 'post',
    //                 success: function(data) {
    //                     if(data.estado === 'success'){
    //                         Swal.fire(
    //                             'Excelente!',
    //                             'El estudiante fue eliminado',
    //                             'success'
    //                         )
    //                         ajaxListado()
    //                     }
    //                 }
    //             });
    //         }
    //     })
    // }

    function consultar(){
        if($("#formularioEventosConuslta")[0].checkValidity()){
            $.ajax({
                url: "{{ url('EventoSignificativo/consultaEventos') }}",
                {{--  cache: false,  --}}
                data:{
                    fecha :$('#fechaEvento').val()
                },
                type: 'POST',
                dateType: 'json',
                success: function(data) {
                    if(data.estado === "success"){
                        $('#tabla_puntos').html(data.listado);
                    }else{
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'error'
                        )
                    }
                }
            });
        }else{
            $("#formularioEventosConuslta")[0].reportValidity();
        }
    }

    function abraModalAddEventoSignificativo(){
        $('#modaNewEventoSignificativo').modal('show')
    }

    function agregarEventoSignificativo(){
        if($("#formularioNewEvento")[0].checkValidity()){
            let dato = $("#formularioNewEvento").serializeArray();
            $.ajax({
                url: "{{ url('EventoSignificativo/registro') }}",
                data: dato,
                type: 'POST',
                dateType: 'json',
                success: function(data) {
                    if(data.estado === "success"){
                        Swal.fire(
                            'Exito!',
                            "Se registro con exito con el codigo "+data.msg,
                            'success'
                        )
                    }else{
                        Swal.fire(
                            'Error!',
                            data.msg,
                            'error'
                        )
                    }
                }
            });
        }else{
            $("#formularioNewEvento")[0].reportValidity();
        }
    }

    // Funcion de configuracion de datatable y llamado de listado de personas ajax
    {{--  $(document).ready(function() {
        var table = $('#tabla-usuarios').DataTable( {
            iDisplayLength: 10,
            processing: true,
            serverSide: true,
            ajax: "{{ url('Persona/ajax_listado') }}",
            columns: [
                {data: 'id'},
                {data: 'cedula'},
                {data: 'apellido_paterno'},
                {data: 'apellido_materno'},
                {data: 'nombres'},
                {data: 'numero_celular'},
                {data: 'action'},
            ],
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        } );
    } );

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
                        window.location.href = "{{ url('Persona/listado') }}/";
                    }
                });
            }
        })
    }

    function inscripcion(persona_id){
        alert('inscribir');
    }

    function reinscripcion(persona_id){
        window.location.href = "{{ url('Inscripcion/reinscripcion') }}/" + persona_id;
    }

    function varios(persona_id){
        alert('cursos adicionales');
    }

    function recuperatorio(persona_id){
        alert('recuperatorio');
    }

    function estado(persona_id){
        alert('estado');
    }

    function contrato(persona_id){
        window.open("{{ url('Persona/contrato') }}/" + persona_id, "_blank");
    }  --}}

    /*
    $( function() {
        $("#cliente").prop("disabled", true);
        $("#email").prop("disabled", true);
        $("#tipo_envio").val("");

        $("#tipo_envio").change( function() {
            if ($(this).val() == "1") {
                $("#cliente").prop("disabled", false);
                $("#email").prop("disabled", true);
            }
            if ($(this).val() == "2") {
                $("#cliente").prop("disabled", true);
                $("#email").prop("disabled", false);
            }
        });
    });

    function cobrar(id)
    {
        window.location.href = "{{ url('Cupon/cobra_cupon') }}/"+id;
    }


    function ver(cupon_id)
    {
        //"{{ url('Cupon/eliminar') }}/"+id;
        window.open('{{ url("Cupon/ver") }}/'+cupon_id, '_blank');
    }

    $(document).on('keyup change', '#cobro_efectivo', function () {
        let producto_id = $("#cobro_producto_id").val();
        let combo_id = $("#cobro_combo_id").val();

        let totalVenta = Number($("#cobro_total").val());
        let efectivo = Number($("#cobro_efectivo").val());
        let cambio = efectivo - totalVenta;
        if (cambio > 0) {
            $("#cobro_cambio").val(cambio);
        }else{
            $("#cobro_cambio").val(0);
        }

        if(producto_id != null){
            //alert ('existe producto');
            //Validar que el boton se habilite una vez se efectue la compra
            //siempre que el stock sea 1 o mayor y el efectivo sea igual o mayor al totalVenta
            let stock = Number($("#cobro_stock").val());
            if (efectivo >= totalVenta && stock >= 1) {
                $("#boton_compra").prop("disabled", false);
            }else{
                $("#boton_compra").prop("disabled", true);
            }
        }else{
            let cantidad_productos = Number($("#cantidad_productos_promo").val());
            let valida = 1;     // 1 todo en orden, 0 producto con stock insuficiente
            let cantidad = 0;
            let stock = 0;
            for(i = 1; i <= cantidad_productos; i++) {
                cantidad = Number($("#cantidad_promo_producto-"+i).val());
                stock = Number($("#stock_promo_producto-"+i).val());
                if(stock < cantidad){
                    valida = 0;
                }
            }
            if(efectivo >= totalVenta && valida == 1){
                $("#boton_compra").prop("disabled", false);
            }else{
                $("#boton_compra").prop("disabled", true);
            }
        }
    });

    function cobra_cupon()
    {
        let nombre = $("#cobro_nombre").val();
        let ci = $("#cobro_ci").val();

        if(nombre.length>0 && ci.length>0){
            Swal.fire(
                'Excelente!',
                'Cupón cobrado exitosamente.',
                'success'
            )
        }
    }

    // funcion no utilizada
    function guarda_cupon()
    {
        var producto_nombre = $("#producto_nombre").val();
        if(producto_nombre.length>0){
            Swal.fire(
                'Excelente!',
                'Una nuevo cupón fue registrado.',
                'success'
            )
        }
        //Abriendo el documento en otra pagina
        //window.open('{{ url("Cupon/prueba") }}', '_blank');
    }

    function eliminar(id)
    {
        Swal.fire({
            title: 'Quieres borrar este cupón?',
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
                    'El cupón fue eliminado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Cupon/eliminar') }}/"+id;
                });
            }
        })
    }

    $(document).on('keyup change', '#producto_descuento', function(e){
        let descuento = Number($(this).val())/100;
        //alert(descuento);
        // let id = $(this).data("id");
        let precio = Number($("#producto_precio").val());
        //alert(precio);

        let total = precio - (precio*descuento);
        total = Math.round(total);
        //alert(total);
        $("#producto_total").val(total);
        // sumaSubTotales();
    });
    */

</script>
@endsection
