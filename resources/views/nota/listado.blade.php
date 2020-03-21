@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('content')
<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<div class="row">
    <!-- Column -->
    <div class="col-md-12">
        <!-- Row -->
        <div class="row">
            <div class="col-lg-12">
                
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Editable with Datatable</h4>
                        <h6 class="card-subtitle">Just click on word which you want to change and enter</h6>
                        <div class="table-responsive">
                            <div id="editable-datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="editable-datatable_length"><label>Show <select name="editable-datatable_length" aria-controls="editable-datatable" class="form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="editable-datatable_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="editable-datatable"></label></div></div></div><div class="row"><div class="col-sm-12"><table class="table no-wrap table-striped table-bordered mt-5 dataTable" id="editable-datatable" style="cursor: pointer;" role="grid" aria-describedby="editable-datatable_info">
                                <thead>
                                    <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 148.533px;" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Rendering engine</th><th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 194.6px;" aria-label="Browser: activate to sort column ascending">Browser</th><th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 180.45px;" aria-label="Platform(s): activate to sort column ascending">Platform(s)</th><th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 125.017px;" aria-label="Engine version: activate to sort column ascending">Engine version</th><th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 88.4px;" aria-label="CSS grade: activate to sort column ascending">CSS grade</th></tr>
                                </thead>
                                <tbody>

                                    <tr id="7" class="gradeA odd" role="row">
                                        <td tabindex="1" class="sorting_1">Gecko</td>
                                        <td tabindex="1">Firefox 1.0</td>
                                        <td tabindex="1">Win 98+ / OSX.2+</td>
                                        <td class="center" tabindex="1">1.7</td>
                                        <td class="center" tabindex="1">A</td>
                                    </tr>
                                    <tr id="8" class="gradeA even" role="row">
                                        <td tabindex="1" class="sorting_1">Gecko</td>
                                        <td tabindex="1">Firefox 1.5</td>
                                        <td tabindex="1">Win 98+ / OSX.2+</td>
                                        <td class="center" tabindex="1">1.8</td>
                                        <td class="center" tabindex="1">A</td>
                                    </tr><tr id="9" class="gradeA odd" role="row">
                                        <td tabindex="1" class="sorting_1">Gecko</td>
                                        <td tabindex="1">Firefox 2.0</td>
                                        <td tabindex="1">Win 98+ / OSX.2+</td>
                                        <td class="center" tabindex="1">1.8</td>
                                        <td class="center" tabindex="1">A</td>
                                    </tr><tr id="10" class="gradeA even" role="row">
                                        <td tabindex="1" class="sorting_1">Gecko</td>
                                        <td tabindex="1">Firefox 3.0</td>
                                        <td tabindex="1">Win 2k+ / OSX.3+</td>
                                        <td class="center" tabindex="1">1.9</td>
                                        <td class="center" tabindex="1">A</td>
                                    </tr><tr id="11" class="gradeA odd" role="row">
                                        <td tabindex="1" class="sorting_1">Gecko</td>
                                        <td tabindex="1">Camino 1.0</td>
                                        <td tabindex="1">OSX.2+</td>
                                        <td class="center" tabindex="1">1.8</td>
                                        <td class="center" tabindex="1">A</td>
                                    </tr><tr id="12" class="gradeA even" role="row">
                                        <td tabindex="1" class="sorting_1">Gecko</td>
                                        <td tabindex="1">Camino 1.5</td>
                                        <td tabindex="1">OSX.3+</td>
                                        <td class="center" tabindex="1">1.8</td>
                                        <td class="center" tabindex="1">A</td>
                                    </tr><tr id="13" class="gradeA odd" role="row">
                                        <td tabindex="1" class="sorting_1">Gecko</td>
                                        <td tabindex="1">Netscape 7.2</td>
                                        <td tabindex="1">Win 95+ / Mac OS 8.6-9.2</td>
                                        <td class="center" tabindex="1">1.7</td>
                                        <td class="center" tabindex="1">A</td>
                                    </tr><tr id="14" class="gradeA even" role="row">
                                        <td tabindex="1" class="sorting_1">Gecko</td>
                                        <td tabindex="1">Netscape Browser 8</td>
                                        <td tabindex="1">Win 98SE+</td>
                                        <td class="center" tabindex="1">1.7</td>
                                        <td class="center" tabindex="1">A</td>
                                    </tr><tr id="15" class="gradeA odd" role="row">
                                        <td tabindex="1" class="sorting_1">Gecko</td>
                                        <td tabindex="1">Netscape Navigator 9</td>
                                        <td tabindex="1">Win 98+ / OSX.2+</td>
                                        <td class="center" tabindex="1">1.8</td>
                                        <td class="center" tabindex="1">A</td>
                                    </tr><tr id="16" class="gradeA even" role="row">
                                        <td tabindex="1" class="sorting_1">Gecko</td>
                                        <td tabindex="1">Mozilla 1.0</td>
                                        <td tabindex="1">Win 95+ / OSX.1+</td>
                                        <td class="center" tabindex="1">1</td>
                                        <td class="center" tabindex="1">A</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                <tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>
                                </tfoot>
                            </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="editable-datatable_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="editable-datatable_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="editable-datatable_previous"><a href="#" aria-controls="editable-datatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="editable-datatable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="editable-datatable_next"><a href="#" aria-controls="editable-datatable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                        <input style="position: absolute; top: 247px; left: 700.583px; text-align: left; width: 168.017px; height: 50px; padding: 12px; font-size: 16px; font-family: &quot;Rubik&quot;, sans-serif; font-weight: 300; display: none;"></div>
                    </div>
                </div>

            </div>
        </div>
        <h3>Clic <a href="{{ route('personas.exportarexcel') }}">aqui</a> para descargar personas en excel</h3>
        <!-- Row -->
    </div>
    <!-- Column -->
</div>
@stop
@section('js')
<script src="{{ asset('/assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>
<script>
    
$(document).ready(function() {
    // DataTable
    var table = $('#tabla-personas').DataTable( {
        "iDisplayLength": 10,
        "processing": true,
        "scrollX": true,
        "serverSide": true,
        "ajax": "{{ url('persona/ajax_datos') }}",
        "columns": [
            {data: 'apellido_paterno'},
            {data: 'apellido_materno'},
            {data: 'nombres'},
        ]
    } );
} );

</script>

<script>
    $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
    $('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
    $(document).ready(function() {
    $('#editable-datatable').DataTable();
    });
</script>

<script type="text/javascript">
    // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // al hacer clic en el boton GUARDAR, se procedera a la ejecucion de la funcion
    $(".btnenviar").click(function(e){
        e.preventDefault();     // Evita que la página se recargue
        var nombre = $('#nombre').val();    
        var nivel = $('#nivel').val();
        var semestre = $('#semestre').val();

        $.ajax({
            type:'POST',
            url:"{{ url('carrera/store') }}",
            data: {
                nom_carrera : nombre,
                desc_niv : nivel,
                semes : semestre
            },
            success:function(data){
                mostrarMensaje(data.mensaje);
                limpiarCampos();
            }
        });
    });
</script>
@endsection
