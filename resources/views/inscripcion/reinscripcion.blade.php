@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/extra-libs/taskboard/css/lobilist.css') }}">
<link rel="stylesheet" href="{{ asset('assets/extra-libs/taskboard/css/jquery-ui.min.css') }}">
@endsection

@section('content')
<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">ADICIONA ASIGNATURA</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label">Buscar Asignatura</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="termino" name="termino">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="ti-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Turno
                        <span class="text-danger">
                            <i class="mr-2 mdi mdi-alert-circle"></i>
                        </span>
                    </label>
                    <select class="form-control custom-select" tabindex="1" id="turno_reinscripcion" name="turno_reinscripcion">
                        @foreach($turnos as $turno)
                            <option value="{{ $turno->id }}">{{ $turno->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label>Paralelo
                        <span class="text-danger">
                            <i class="mr-2 mdi mdi-alert-circle"></i>
                        </span>
                    </label>
                    <select class="form-control custom-select" tabindex="1" id="paralelo_reinscripcion" name="paralelo_reinscripcion">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="control-label">Gesti&oacute;n</label>
                    <input type="number" class="form-control" id="gestion_reinscripcion" name="gestion_reinscripcion" value="{{ date('Y') }}">
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label class="control-label">Fecha de Inscripcion</label>
                    <span class="text-danger">
                        <i class="mr-2 mdi mdi-alert-circle"></i>
                    </span>
                    <input type="date" name="fecha_inscripcion" id="fecha_reinscripcion" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div> 
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="listadoAsignaturasAjax">
        
            </div>
        </div>
    </div>
</div>

<div class="card border-primary">
    <form action="{{ url('Inscripcion/guarda_reinscripcion') }}" method="POST">
        @csrf
        <input type="hidden" name="persona_id" id="persona_id" value="{{ $estudiante->id }}">
        <input type="hidden" name="turno" id="turno">
        <input type="hidden" name="paralelo" id="paralelo">
        <input type="hidden" name="gestion" id="gestion">
        <input type="hidden" name="fecha_inscripcion" id="fecha_inscripcion">
        <input type="hidden" name="anioIngreso" id="anioIngreso" value="{{ $anioIngreso }}">
        <div class="card-header bg-primary">
            <h4 class="mb-0 text-white">DETALLE DE REINSCRIPCI&Oacute;N - (Pendientes Gestion Actual)</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h4><span class="text-info">Estudiante:</span>
                        {{ $estudiante->nombres }} {{ $estudiante->apellido_paterno }} {{ $estudiante->apellido_materno }}
                    </h4>
                </div>
                <div class="col-md-4">
                    <h4><span class="text-info">CI:</span>
                        {{ $estudiante->cedula }}
                    </h4>
                </div>
                <div class="col-md-4">
                    <h4><span class="text-info">Fecha:</span>
                        {{ date('d-m-Y') }}
                    </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tablaPedido">
                            <thead class="bg-inverse text-white">
                                <tr>
                                    <th></th>
                                    <th>Sigla</th>
                                    <th>Nombre</th>
                                    <th>Carrera</th>
                                    <th>Semestre</th>
                                    <th>Gestion</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendientes as $key => $asignatura)
                                    <tr>
                                        <td><input type="hidden" name="asignatura[{{ $asignatura->id }}]" value="{{ $asignatura->id }}"></td>
                                        <td>{{ $asignatura->sigla }}</td>
                                        <td>{{ $asignatura->nombre }}</td>
                                        <td>{{ $asignatura->carrera->nombre }}</td>
                                        <td>{{ $asignatura->semestre }}</td>
                                        <td>{{ $asignatura->gestion }}</td>
                                        <td><button type="button" class="btn btn-danger btnElimina" title="Eliminar asignatura"><i class="fas fa-trash-alt"></i></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <!-- <button class="btn btn-info btn-block" type="submit" onclick="validaItems()"><span><i class="fa fa-print"></i> CONFIRMAR REINSCRIPCION </span></button> -->
                    <button type="submit" id="botonSubmit" class="btn waves-effect waves-light btn-block btn-inverse" onclick="validaItems()">CONFIRMAR REINSCRIPCION</button>
                </div>
                <div class="col-md-6">
                    <a href="{{ url('Persona/ver_detalle/'.$estudiante->id) }}" type="button" class="btn waves-effect waves-light btn-block btn-inverse">VOLVER</a>
                </div>
            </div>
        </div>
    </form>
</div>
@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>

<script src="{{ asset('assets/extra-libs/taskboard/js/jquery.ui.touch-punch-improved.js') }}"></script>
<script src="{{ asset('assets/extra-libs/taskboard/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
<script src="{{ asset('dist/js/pages/samplepages/jquery.PrintArea.js') }}"></script>
<script src="{{ asset('dist/js/pages/invoice/invoice.js') }}"></script>
<script>
    // Funcion para el uso de ajax
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

    var itemsPedidoArray = [];

    // Funcion que valida que exista al menos un item en la lista para continuar
    function validaItems()
    {
        if(itemsPedidoArray.length > 0){
            //alert('ok');
            //$("#botonSubmit").hide();
        }else{
            event.preventDefault();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Tienes que adicionar al menos un producto.'
            })
        }        
    }

    // Funcion que habilita el datatable
    $(function () {
        // $('#config-table').DataTable({
        //     responsive: true,
        //     "order": [
        //         [0, 'asc']
        //     ],
        //     language: {
        //         url: '{{ asset('datatableEs.json') }}'
        //     },
        // });

        // elimina productos de la tabla por unidad
        $('#tablaPedido tbody').on('click', '.btnElimina', function () {
            t.row($(this).parents('tr'))     
                .remove()
                .draw();
            // utilizado este codigo por si se elimina el registro y se desea volverlo a agregar
            let itemBorrar = $(this).closest("tr").find("td:eq(0)").text();     //captura el primer elemento de la tabla(id)
            let pos = itemsPedidoArray.lastIndexOf(itemBorrar);
            itemsPedidoArray.splice(pos, 1);
            // sumaSubTotales();
        });
    });

    // Funcion para busqueda de producto en pedido input (BUSCAR PRODUCTO)
    $(document).on('keyup', '#termino', function(e) {
        termino_busqueda = $('#termino').val();
        //almacen_id = $('#almacen_a_pedir').val();
        if (termino_busqueda.length > 2) {
            $.ajax({
                url: "{{ url('Inscripcion/ajaxBuscaAsignatura') }}",
                data: {
                    termino: termino_busqueda,
                    //almacen : almacen_id
                    },
                type: 'POST',
                success: function(data) {
                    $("#listadoAsignaturasAjax").show('slow');
                    $("#listadoAsignaturasAjax").html(data);
                }
            });
        }
    });

    //Funcion de para turno
    $( function() {
        $("#turno").val($('#turno_reinscripcion').val());
        $("#turno_reinscripcion").change( function() {
            $("#turno").val($('#turno_reinscripcion').val());
        });
    });

    //Funcion de para paralelo
    $( function() {
        $("#paralelo").val($('#paralelo_reinscripcion').val());
        $("#paralelo_reinscripcion").change( function() {
            $("#paralelo").val($('#paralelo_reinscripcion').val());
        });
    });

    //Funcion de para gestion
    $( function() {
        $("#gestion").val($('#gestion_reinscripcion').val());
        $("#gestion_reinscripcion").change( function() {
            $("#gestion").val($('#gestion_reinscripcion').val());
        });
    });

    //Funcion de para fecha_inscripcion
    $( function() {
        $("#fecha_inscripcion").val($('#fecha_reinscripcion').val());
        $("#fecha_reinscripcion").change( function() {
            $("#fecha_inscripcion").val($('#fecha_reinscripcion').val());
        });
    });

    function adicionaPedido(item)
    {
        /*var item = $("#item_"+item).closest("tr").find('td').each(function(){
            console.log(this.text);
        });*/
        var item = $("#item_"+item).closest("tr").find('td').text();
        console.log(item);
    }

    function adicionarTabla()
    {

    }

    // Funcion que elimina un producto de la lista de producto enviados
    function eliminar(id, nombre)
    {
        Swal.fire({
            title: 'Quieres borrar ' + nombre + '?',
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
                    'El producto fue eliminado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Pedido/eliminaProducto') }}/"+id;
                });
            }
        })
    }

    // Funcion que elimina todo el envio de productos
    function elimina_envio()
    {
        let numero_pedido = $('#numero_pedido').val();
        let pedido_id = $('#pedido_id').val();
        Swal.fire({
            title: 'Quieres borrar el envio # ' + numero_pedido + '?',
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
                    'El envio fue eliminado',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Pedido/eliminaPedido') }}/"+pedido_id;
                });
            }
        })
    }

    // Funcion que pone en vacio las variables del formulario ADICIONA UN PRODUCTO
    $( function() {
        $("#producto_id").val("");
        $("#producto_nombre").val("");
        $("#producto_stock").val("");
        $("#producto_cantidad").val("");
    });

    // Funcion que valida que no se adicione un item si no esta lleno los valores (BOTON ADICIONAR)
    function validaItems()
    {
        let producto_id = $('#producto_id').val();
        let producto_cantidad = $('#producto_cantidad').val();
        if(producto_id.length > 0 && producto_cantidad > 0){
            //alert('ok');
        }else{
            event.preventDefault();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Tienes que adicionar un producto y que la cantidad a solicitar sea al menos de 1.'
            })
        }        
    }
</script>
@endsection
