@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">

<!-- <link href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css" rel="stylesheet"> -->

@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<form action="{{ url('Importacion/exportarAlumnos') }}" method="get">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card border-info">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">DETALLE PARA EXPORTACION</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Buscar Estudiante</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="termino" name="termino">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="ti-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col">
                            <div class="form-group">
                                <label class="control-label">&nbsp;</label>
                                <button type="button" onclick="exportar()" class="btn btn-block btn-success">Exportar</button>
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="listadoAlumnosAjax">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-dark">
                <div class="card-header bg-dark">
                    <h4 class="mb-0 text-white">ESTUDIANTES A EXPORTAR</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive m-t-40">
                        <table id="tablaPedido" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%">ID</th>
                                    <th>Cedula</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Nombres</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="validaItems()">Exportar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="post" id="upload_form" enctype="multipart/form-data" class="upload_form mt-4">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="select_file" id="select_file">
                    <label class="custom-file-label" for="inputGroupFile04">Elegir archivo</label>
                </div>
                <div class="input-group-append">
                    <input type="submit" name="upload" id="upload" class="btn btn-success" value="Importar" style="width: 200px;">
                </div>
            </div>
        </div>
    </div>
</form>
@stop
@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<script src="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/datatable-advanced.init.js') }}"></script>
<script>
    // Funcion para el uso de ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Funcion que habilita el datatable
    var t = $('#tablaPedido').DataTable({
        paging: false,
        searching: false,
        ordering: false,
        info:false,
        language: {
            url: '{{ asset('datatableEs.json') }}'
        }
    });

    // Funcion Ajax que busca el alumno y devuelve coincidencias
    $(document).on('keyup', '#termino', function(e) {
        termino_busqueda = $('#termino').val();
        if (termino_busqueda.length > 2) {
            $.ajax({
                url: "{{ url('Importacion/ajaxBuscaAlumno') }}",
                data: {
                    termino: termino_busqueda
                    },
                type: 'POST',
                success: function(data) {
                    $("#listadoAlumnosAjax").show('slow');
                    $("#listadoAlumnosAjax").html(data);
                }
            });
        }
    });

    // Variable necesaria para funcionamiento de datatable
    var itemsPedidoArray = [];
    
    // Funcion que valida que exista al menos un item en la lista para continuar
    function validaItems()
    {
        if(itemsPedidoArray.length > 0){
            //alert('ok');
        }else{
            event.preventDefault();
            Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Tienes que adicionar al menos un estudiante.'
            })
        }        
    }

    // Funcion que agrega un item de la lista de alumnos buscados
    function adicionaPedido(item)
    {
        var item = $("#item_"+item).closest("tr").find('td').text();
        console.log(item);
    }

    // Funcion que elimina un alumno en la lista de alumnos ingresados
    $(document).ready(function () {
        $('#tablaPedido tbody').on('click', '.btnElimina', function () {
            t.row($(this).parents('tr'))
                .remove()
                .draw();
            let itemBorrar = $(this).closest("tr").find("td:eq(0)").text();
            let pos = itemsPedidoArray.lastIndexOf(itemBorrar);
            itemsPedidoArray.splice(pos, 1);
        });
    });

    // Script de importacion de excel
    $(document).ready(function() {
        $('.upload_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ url('Importacion/importar_3') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data)
                {
                    if(data.sw == 1){
                        Swal.fire(
                        'Hecho',
                        data.message,
                        'success'
                        ).then(function() {
                            location.reload();          //Aqui editar
                            $('#select_file').val('');
                        });
                    }else{
                        Swal.fire(
                        'Oops...',
                        data.message,
                        'error'
                        )
                    }
                }
            })
        });
    });
</script>

@endsection