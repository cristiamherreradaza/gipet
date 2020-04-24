@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<link href="{{ asset('assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/bootstrap-table/dist/bootstrap-table.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/plugins/icheck/skins/all.css') }}" rel="stylesheet">
@endsection



@section('content')
<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<div class="row">
    <!-- Column -->
    <div class="col-md-12">
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">CARRERAS Y ASIGNATURAS DEL ALUMNO</h4>
                        
                        <form class="floating-labels mt-5">
                            <div class="row">
                                <div class="form-group has-success col-2 mb-5">
                                    <input type="text" class="form-control" id="input11" value="{{ $persona->apellido_paterno}}" required>
                                    <label for="input11">Apellido Paterno</label>
                                </div>
                                <div class="form-group has-success col-2 mb-5">
                                    <input type="text" class="form-control" id="input11" value="{{ $persona->apellido_materno}}" required>
                                    <label for="input11">Apellido Materno</label>
                                </div>
                                <div class="form-group has-success col-2 mb-5">
                                    <input type="text" class="form-control" id="input11" value="{{ $persona->nombres}}" required>
                                    <label for="input11">Nombre</label>
                                </div>
                                <div class="form-group has-success col-2 mb-5">
                                    <input type="date" class="form-control" id="input11" value="{{ $persona->fecha_nacimiento}}" required>
                                    <label for="input11">Fecha Nacimiento</label>
                                </div>
                                <div class="form-group has-success col-2 mb-5">
                                    <input type="text" class="form-control" id="input11" value="{{ $persona->carnet}}" required>
                                    <label for="input11">Carnet Identidad</label>
                                </div>
                                <div class="form-group has-success col-1 mb-5">
                                    <input type="text" class="form-control" id="input11" value="{{ $persona->expedido}}" required>
                                    <label for="input11">Expedido</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group has-success col-3 mb-5">
                                    <input type="text" class="form-control" id="input11" value="{{ $persona->email}}" required>
                                    <label for="input11">Correo Electronico</label>
                                </div>
                                <div class="form-group has-success col-3 mb-5">
                                    <input type="text" class="form-control" id="input11" value="{{ $persona->direccion}}" required>
                                    <label for="input11">Direccion</label>
                                </div>
                                <div class="form-group has-success col-3 mb-5">
                                    <input type="text" class="form-control" id="input11" value="{{ $persona->telefono_celular}}" required>
                                    <label for="input11">Celular</label>
                                </div>
                                <div class="form-group has-success col-3 mb-5">
                                    <input type="text" class="form-control" id="input11" value="{{ $persona->sexo}}" required>
                                    <label for="input11">Genero</label>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
         {{-- asignaturas por tomar --}}
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-md-6" id="mostrar_asig1">
                <div class="card card-inverse card-dark">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mr-3 align-self-center">
                                <h1 class="text-white"><i class="icon-graduation"></i></h1></div>
                            <div>
                                <h3 class="card-title" id="nom_asig1"> </h3>
                                <h6 class="card-subtitle" id="gest1"> </h6> </div>
                        </div>
                        <div class="row">
                            <!-- column -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table no-wrap" id="valor1_1">
                                                <thead>
                                                    <tr>
                                                        <th data-field="state" data-checkbox="true"></th>
                                                        <th data-field="name">Sigla</th>
                                                        <th data-field="price">Asignatura</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="val_tabla">
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="check" id="flat-checkbox" checked data-checkbox="icheckbox_flat-blue">
                                                        </td>
                                                        <td>Hola</td> 
                                                        <td>Bien</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-4 col-md-6" id="mostrar_asig2">
                <div class="card card-inverse card-dark">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mr-3 align-self-center">
                                <h1 class="text-white"><i class="icon-notebook"></i></h1></div>
                            <div>
                                <h3 class="card-title" id="nom_asig2">Secretariado Administrativo</h3>
                                <h6 class="card-subtitle" id="gest2"></h6> </div>
                        </div>
                        <div class="row">
                            <!-- column -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table no-wrap" id="valor2_2">
                                                <thead>
                                                    <tr>
                                                        <th data-field="state" data-checkbox="true"></th>
                                                        <th data-field="name">Sigla</th>
                                                        <th data-field="price">Asignatura</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="val_tabla">
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="check" id="flat-checkbox" checked data-checkbox="icheckbox_flat-blue">
                                                        </td>
                                                        <td>Hola</td> 
                                                        <td>Bien</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-4 col-md-6" id="mostrar_asig3">
                <div class="card card-inverse card-dark">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mr-3 align-self-center">
                                <h1 class="text-white"><i class="icon-layers"></i></h1></div>
                            <div>
                                <h3 class="card-title" id="nom_asig3">Auxiliar Administrativo Financiero</h3>
                                <h6 class="card-subtitle" id="gest3"> </h6> </div>
                        </div>
                        <div class="row">
                            <!-- column -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table no-wrap" id="valor3_3">
                                                <thead>
                                                    <tr>
                                                        <th data-field="state" data-checkbox="true"></th>
                                                        <th data-field="name">Sigla</th>
                                                        <th data-field="price">Asignatura</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="val_tabla">
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="check" id="flat-checkbox" checked data-checkbox="icheckbox_flat-blue">
                                                        </td>
                                                        <td>Hola</td> 
                                                        <td>Bien</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->
<!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-md-6" id="mostrar_asig1">
                <div class="card card-inverse card-primary">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mr-3 align-self-center">
                                <h1 class="text-white"><i class="icon-graduation"></i></h1></div>
                            <div>
                                <h3 class="card-title" id="nom_asig1"> </h3>
                                <h6 class="card-subtitle" id="gest1"> </h6> </div>
                        </div>
                        <div class="row">
                            <!-- column -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table no-wrap" id="valor1_1">
                                                <thead>
                                                    <tr>
                                                        <th data-field="state" data-checkbox="true"></th>
                                                        <th data-field="name">Sigla</th>
                                                        <th data-field="price">Asignatura</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="val_tabla">
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="check" id="flat-checkbox" checked data-checkbox="icheckbox_flat-blue">
                                                        </td>
                                                        <td>Hola</td> 
                                                        <td>Bien</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-4 col-md-6" id="mostrar_asig2">
                <div class="card card-inverse card-primary">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mr-3 align-self-center">
                                <h1 class="text-white"><i class="icon-notebook"></i></h1></div>
                            <div>
                                <h3 class="card-title" id="nom_asig2">Secretariado Administrativo</h3>
                                <h6 class="card-subtitle" id="gest2"></h6> </div>
                        </div>
                        <div class="row">
                            <!-- column -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table no-wrap" id="valor2_2">
                                                <thead>
                                                    <tr>
                                                        <th data-field="state" data-checkbox="true"></th>
                                                        <th data-field="name">Sigla</th>
                                                        <th data-field="price">Asignatura</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="val_tabla">
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="check" id="flat-checkbox" checked data-checkbox="icheckbox_flat-blue">
                                                        </td>
                                                        <td>Hola</td> 
                                                        <td>Bien</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-4 col-md-6" id="mostrar_asig3">
                <div class="card card-inverse card-primary">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mr-3 align-self-center">
                                <h1 class="text-white"><i class="icon-layers"></i></h1></div>
                            <div>
                                <h3 class="card-title" id="nom_asig3">Auxiliar Administrativo Financiero</h3>
                                <h6 class="card-subtitle" id="gest3"> </h6> </div>
                        </div>
                        <div class="row">
                            <!-- column -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table no-wrap" id="valor3_3">
                                                <thead>
                                                    <tr>
                                                        <th data-field="state" data-checkbox="true"></th>
                                                        <th data-field="name">Sigla</th>
                                                        <th data-field="price">Asignatura</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="val_tabla">
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" class="check" id="flat-checkbox" checked data-checkbox="icheckbox_flat-blue">
                                                        </td>
                                                        <td>Hola</td> 
                                                        <td>Bien</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->

        {{-- fin de asignaturas --}}

        <div class="row">
            <div class="col-md-6">
            <button type="submit" class="btn waves-effect waves-light btn-block btn-success">Guardar</button>
            </div>
            <div class="col-md-6">
            <button type="button" class="btn waves-effect waves-light btn-block btn-inverse">Cerrar</button>
            </div>
        </div>

        {{-- fin de asignaturas --}}
    </div>
                


</div>
@stop
@section('js')
<script src="{{ asset('assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
 <!--Custom JavaScript -->
<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
<script src="{{ asset('assets/plugins/bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-table/dist/bootstrap-table-locale-all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-table.init.js') }}"></script>
<!-- ============================================================== -->
 <!-- icheck -->
<script src="{{ asset('assets/plugins/icheck/icheck.min.js') }}"></script>
<script src="{{ asset('assets/plugins/icheck/icheck.init.js') }}"></script>
<!-- ============================================================== -->
<script>
jQuery(document).ready(function() {
    // For multiselect
    $('#public-methods').multiSelect();
    $('#select-all').click(function() {
        $('#public-methods').multiSelect('select_all');
        return false;
    });
    $('#deselect-all').click(function() {
        $('#public-methods').multiSelect('deselect_all');
        return false;
    });
});
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function ver($id){
        $('#mostrar_asig1').show('slow');
        var id = $id;
        var id_carrera = $('#carrera_id').val();
        $.ajax({
            type:'GET',
            url:"{{ url('Inscripcion/asignaturas_a_tomar') }}",
            data: {
                id_persona : id,
                id_carre : id_carrera
            },
            success:function(data){

                // $('#public-methods').html('hola');
                $.each(data, function(index, value) {
                 console.log(data[index].asignatura_id);
                    $('#val_tabla').append('<tr>'+
                                                '<td>'+
                                                    '<input type="checkbox" class="check" id="flat-checkbox" checked data-checkbox="icheckbox_flat-blue">'+
                                                '</td>'+
                                                '<td>'+ data[index].codigo_asignatura + '</td>'+ 
                                                '<td>'+ data[index].nombre_asignatura + '</td>'+
                                            '</tr>');
                    });
            }
        });



        // var id1 = $('#carrera_id').val();
        //     if (id1 == '10') {
        //         $('#mostrar_asig1').show('slow');
        //     }else{
        //         $('#mostrar_asig1').hide('slow');
        //     }


    }
</script>
@endsection
