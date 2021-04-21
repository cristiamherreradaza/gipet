@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('content')
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            Estudiantes
        </h4>
    </div>
    <div class="card-body" id="lista">
        <div class="table-responsive m-t-40">
            <table id="tabla-usuarios" class="table table-striped table-bordered no-wrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>CI</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Nombres</th>
                        <th>Numero Contacto</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script>
    // Funcion para usar ajax
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Funcion de configuracion de datatable y llamado de listado de personas ajax
    $(document).ready(function() {
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
    }

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
