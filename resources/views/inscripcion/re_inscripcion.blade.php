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
                        <h4 class="card-title">RE-INSCRIPCION DE ALUMNO</h4>
                        
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
        {{-- Carrera --}}
        <!-- Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="mb-0 text-white">Datos de la Carrera</h4>
                    </div>
                    <div class="card-body">
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                                <!--/row-->
                                <!-- <h3 class="box-title">Address</h3> -->
                                <!--/row-->
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Carrera</label>
                                            <div class="col-md-9">
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="carrera_id" name="carrera_id">
                                                    <option value="">Seleccionar</option>
                                                    @foreach($carreras as $carre)
                                                    <option value="{{ $carre->carrera_id }}">{{ $carre->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Turno</label>
                                            <div class="col-md-7">
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="turno_id" name="turno_id">
                                                    <option value="">Seleccionar</option>
                                                    @foreach($turnos as $tur)
                                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-12">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-3">Paralelo</label>
                                            <div class="col-md-6">
                                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="paralelo" name="paralelo">
                                                    <option value="">Seleccionar</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-12">
                                        <div class="form-group row">
                                            <label class="control-label text-right col-md-5">Gesti&oacute;n</label>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control" id="gestion" name="gestion" value="{{ $year }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--/row-->
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="button" class="btn btn-info" onclick="ver({{ $persona->id }});">Ver Asignaturas por Tomar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
        {{-- fin Carrera --}}
        {{-- asignaturas por tomar --}}
        <!-- Row -->
        <div class="row">
            <!-- Column -->
            <div class="col-lg-4 col-md-8" id="mostrar_asig1" style="display:none;">
                <div class="card card-inverse card-dark">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="mr-3 align-self-center">
                                <h1 class="text-white"><i class="icon-graduation"></i></h1></div>
                            <div>
                                <h3 class="card-title" id="nom_asig1"> </h3>
                                <h6 class="card-subtitle" id="gest1"> </h6>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Table with checkbox</h4>
                                    <h6 class="card-subtitle">data with checkbox</h6>
                                    <table class="table no-wrap" data-height="295">
                                        <thead>
                                            <tr>
                                                <th data-field="state" data-checkbox="true"></th>
                                                <th data-field="name">Sigla</th>
                                                <th data-field="price">Asignatura</th>
                                            </tr>
                                        </thead>
                                        <tbody id="val_tabla">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                
                            <!-- column -->
                            {{-- <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="col-lg-12 col-xlg-6">
                                                <h5 class="box-title">Public methods</h5>
                                                <select multiple id="public-methods" name="public-methods[]">
                                                    
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-box mt-3" align="center"> <a id="select-all" class="btn btn-info" href="#">Seleccionar Todo</a>  <a id="deselect-all" class="btn btn-danger" href="#">Quitar Todo</a> </div>
                                </div>
                            </div> --}}
                    </div>
                </div>
            </div>
            <!-- Column -->
        </div>
        <!-- Row -->

        <div class="row">
                            <div class="col-md-6">
                            <button type="submit" class="btn waves-effect waves-light btn-block btn-success">Guardar</button>
                            </div>
                            <!-- <div class="col-md-6">
                            <button type="button" class="btn waves-effect waves-light btn-block btn-inverse">Cancelar</button>
                            </div> -->
                        </div>

        {{-- fin de asignaturas --}}
    </div>
    <!-- Column -->


   {{-- <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Multiple Select</h4>
                <h6 class="card-subtitle"> Use a <code>select multiple</code> as your input element.</h6>
                <div class="row">
                    <div class="col-lg-12 col-xlg-4">
                        <h5 class="box-title">Public methods</h5>
                        <select multiple id="public-methods" name="public-methods[]">
                            @foreach($carreras as $carr)
                            <option value="{{ $carr->id }}">{{ $carr->nombre }}</option>
                            @endforeach
                        </select>
                        <div class="button-box mt-3"> <a id="select-all" class="btn btn-info" href="#">select all</a> <a id="deselect-all" class="btn btn-danger" href="#">deselect all</a> </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
                


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
