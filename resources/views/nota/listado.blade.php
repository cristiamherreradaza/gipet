@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<link href="{{ asset('assets/plugins/horizontal-timeline/css/horizontal-timeline.css') }}" rel="stylesheet">
@endsection

@section('content')
<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<div class="row">
    <!-- Column -->
    <div class="col-md-12">
        <!-- Row -->





        




        <div class="col-lg-12">
            <div id="accordian-3">
                <div class="card">
                    <a class="card-header bg-primary" id="heading11">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                            <h5 class="mb-0 text-white">CALCULO I - MAT-115</h5>
                        </button>
                    </a>
                    <div id="collapse1" class="collapse show" aria-labelledby="heading11" data-parent="#accordian-3" style="">
                        <div class="card-body">
                            

                            <div class="card">
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <div id="editable-datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="editable-datatable_length"><label>Show <select name="editable-datatable_length" aria-controls="editable-datatable" class="form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="editable-datatable_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="editable-datatable"></label></div></div></div><div class="row"><div class="col-sm-12"><table class="table no-wrap table-striped table-bordered mt-5 dataTable" id="editable-datatable" style="cursor: pointer;" role="grid" aria-describedby="editable-datatable_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 148.533px;" aria-sort="ascending" aria-label="Estudiante: activate to sort column descending">
                                                    Estudiante
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 194.6px;" aria-label="Asistencia: activate to sort column ascending">
                                                    Asistencia
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 180.45px;" aria-label="Practica: activate to sort column ascending">
                                                    Practica
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 125.017px;" aria-label="Puntos ganados: activate to sort column ascending">
                                                    Puntos ganados
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 88.4px;" aria-label="Examen Parcial: activate to sort column ascending">
                                                    Examen Parcial
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 88.4px;" aria-label="Examen Final: activate to sort column ascending">
                                                    Examen Final
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 88.4px;" aria-label="Total: activate to sort column ascending">
                                                    Total
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr id="7" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">steve</td>
                                                    <td tabindex="1">10</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">7</td>
                                                    <td class="center" tabindex="1">5</td>
                                                    <td class="center" tabindex="1">3</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="8" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">jobs</td>
                                                    <td tabindex="1">9</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="9" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ali</td>
                                                    <td tabindex="1">8</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="10" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">7</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.9</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="11" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">6</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="12" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">5</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="13" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">5</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.7</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="14" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">3</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.7</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="15" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">3</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="16" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">2</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th rowspan="1" colspan="1">
                                                        Estudiante
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Asistencia
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Practica
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Puntos ganados
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Examen Parcial
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Examen Final
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Total
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="editable-datatable_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="editable-datatable_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="editable-datatable_previous"><a href="#" aria-controls="editable-datatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="editable-datatable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="editable-datatable_next"><a href="#" aria-controls="editable-datatable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                                    <input style="position: absolute; top: 247px; left: 700.583px; text-align: left; width: 168.017px; height: 50px; padding: 12px; font-size: 16px; font-family: &quot;Rubik&quot;, sans-serif; font-weight: 300; display: none;"></div>
                                </div>
                            </div>
<a class="btn btn-info" href="{{ route('personas.exportarexcel') }}">Exportar Excel</a>
                            <a class="btn btn-info" href="{{ route('personas.exportarexcel') }}">Importar Excel</a>


                        </div>
                    </div>
                </div>
                <div class="card">
                    <a class="card-header bg-primary" id="heading22">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                            <h5 class="mb-0 text-white">CONTABILIDAD I - CON-101</h5>
                        </button>
                    </a>
                    <div id="collapse2" class="collapse" aria-labelledby="heading22" data-parent="#accordian-3">
                        <div class="card-body">
                            
                            <div class="card">
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <div id="editable-datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="editable-datatable_length"><label>Show <select name="editable-datatable_length" aria-controls="editable-datatable" class="form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="editable-datatable_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="editable-datatable"></label></div></div></div><div class="row"><div class="col-sm-12"><table class="table no-wrap table-striped table-bordered mt-5 dataTable" id="editable-datatable" style="cursor: pointer;" role="grid" aria-describedby="editable-datatable_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 148.533px;" aria-sort="ascending" aria-label="Estudiante: activate to sort column descending">
                                                    Estudiante
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 194.6px;" aria-label="Asistencia: activate to sort column ascending">
                                                    Asistencia
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 180.45px;" aria-label="Practica: activate to sort column ascending">
                                                    Practica
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 125.017px;" aria-label="Puntos ganados: activate to sort column ascending">
                                                    Puntos ganados
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 88.4px;" aria-label="Examen Parcial: activate to sort column ascending">
                                                    Examen Parcial
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 88.4px;" aria-label="Examen Final: activate to sort column ascending">
                                                    Examen Final
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 88.4px;" aria-label="Total: activate to sort column ascending">
                                                    Total
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr id="7" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">steve</td>
                                                    <td tabindex="1">10</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">7</td>
                                                    <td class="center" tabindex="1">5</td>
                                                    <td class="center" tabindex="1">3</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="8" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">jobs</td>
                                                    <td tabindex="1">9</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="9" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ali</td>
                                                    <td tabindex="1">8</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="10" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">7</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.9</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="11" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">6</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="12" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">5</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="13" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">5</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.7</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="14" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">3</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.7</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="15" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">3</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="16" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">2</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th rowspan="1" colspan="1">
                                                        Estudiante
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Asistencia
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Practica
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Puntos ganados
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Examen Parcial
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Examen Final
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Total
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="editable-datatable_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="editable-datatable_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="editable-datatable_previous"><a href="#" aria-controls="editable-datatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="editable-datatable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="editable-datatable_next"><a href="#" aria-controls="editable-datatable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                                    <input style="position: absolute; top: 247px; left: 700.583px; text-align: left; width: 168.017px; height: 50px; padding: 12px; font-size: 16px; font-family: &quot;Rubik&quot;, sans-serif; font-weight: 300; display: none;"></div>
                                </div>
                            </div>
                            <a class="btn btn-info" href="{{ route('personas.exportarexcel') }}">Exportar Excel</a>
                            <a class="btn btn-info" href="{{ route('personas.exportarexcel') }}">Importar Excel</a>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <a class="card-header bg-primary" id="heading33">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                            <h5 class="mb-0 text-white">SECRETARIADO EJECUTIVO - SEC-101</h5>
                        </button>
                    </a>
                    <div id="collapse3" class="collapse" aria-labelledby="heading33" data-parent="#accordian-3">
                        <div class="card-body">
                            
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Calculo 1 - MAT-115</h4>

                                    <div class="table-responsive">
                                        <div id="editable-datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"><div class="dataTables_length" id="editable-datatable_length"><label>Show <select name="editable-datatable_length" aria-controls="editable-datatable" class="form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div><div class="col-sm-12 col-md-6"><div id="editable-datatable_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="editable-datatable"></label></div></div></div><div class="row"><div class="col-sm-12"><table class="table no-wrap table-striped table-bordered mt-5 dataTable" id="editable-datatable" style="cursor: pointer;" role="grid" aria-describedby="editable-datatable_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 148.533px;" aria-sort="ascending" aria-label="Estudiante: activate to sort column descending">
                                                    Estudiante
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 194.6px;" aria-label="Asistencia: activate to sort column ascending">
                                                    Asistencia
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 180.45px;" aria-label="Practica: activate to sort column ascending">
                                                    Practica
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 125.017px;" aria-label="Puntos ganados: activate to sort column ascending">
                                                    Puntos ganados
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 88.4px;" aria-label="Examen Parcial: activate to sort column ascending">
                                                    Examen Parcial
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 88.4px;" aria-label="Examen Final: activate to sort column ascending">
                                                    Examen Final
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="editable-datatable" rowspan="1" colspan="1" style="width: 88.4px;" aria-label="Total: activate to sort column ascending">
                                                    Total
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr id="7" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">steve</td>
                                                    <td tabindex="1">10</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">7</td>
                                                    <td class="center" tabindex="1">5</td>
                                                    <td class="center" tabindex="1">3</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="8" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">jobs</td>
                                                    <td tabindex="1">9</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="9" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ali</td>
                                                    <td tabindex="1">8</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="10" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">7</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.9</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="11" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">6</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="12" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">5</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="13" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">5</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.7</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="14" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">3</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.7</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="15" class="gradeA odd" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">3</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                                <tr id="16" class="gradeA even" role="row">
                                                    <td tabindex="1" class="sorting_1">ariel</td>
                                                    <td tabindex="1">2</td>
                                                    <td tabindex="1"></td>
                                                    <td class="center" tabindex="1">1</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1">1.8</td>
                                                    <td class="center" tabindex="1"></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th rowspan="1" colspan="1">
                                                        Estudiante
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Asistencia
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Practica
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Puntos ganados
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Examen Parcial
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Examen Final
                                                    </th>
                                                    <th rowspan="1" colspan="1">
                                                        Total
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table></div></div><div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="editable-datatable_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div></div><div class="col-sm-12 col-md-7"><div class="dataTables_paginate paging_simple_numbers" id="editable-datatable_paginate"><ul class="pagination"><li class="paginate_button page-item previous disabled" id="editable-datatable_previous"><a href="#" aria-controls="editable-datatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li><li class="paginate_button page-item active"><a href="#" aria-controls="editable-datatable" data-dt-idx="1" tabindex="0" class="page-link">1</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="3" tabindex="0" class="page-link">3</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="4" tabindex="0" class="page-link">4</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="5" tabindex="0" class="page-link">5</a></li><li class="paginate_button page-item "><a href="#" aria-controls="editable-datatable" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="editable-datatable_next"><a href="#" aria-controls="editable-datatable" data-dt-idx="7" tabindex="0" class="page-link">Next</a></li></ul></div></div></div></div>
                                    <input style="position: absolute; top: 247px; left: 700.583px; text-align: left; width: 168.017px; height: 50px; padding: 12px; font-size: 16px; font-family: &quot;Rubik&quot;, sans-serif; font-weight: 300; display: none;"></div>
                                </div>
                                
                            </div>
                            <a class="btn btn-info" href="{{ route('personas.exportarexcel') }}">Exportar Excel</a>
                            <a class="btn btn-info" href="{{ route('personas.exportarexcel') }}">Importar Excel</a>
                            
                            

                        </div>
                    </div>
                </div>
            </div>
        </div>





        
        <!-- Row -->
    </div>
    <!-- Column -->
</div>
@stop
@section('js')

<!-- <script>
    
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
</script> -->


<script src="{{ asset('/assets/plugins/jquery-datatables-editable/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/tiny-editable/mindmup-editabletable.js') }}"></script>
<script src="{{ asset('/assets/plugins/tiny-editable/numeric-input-example.js') }}"></script>

<script>
    $('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
    $('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
    $(document).ready(function() {
    $('#editable-datatable').DataTable();
    });
</script>

<script src="{{ asset('assets/plugins/horizontal-timeline/js/horizontal-timeline.js') }}"></script>

@endsection
