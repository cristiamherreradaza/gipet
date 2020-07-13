@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')
<div class="card border-dark" id="mostrar" style="display:none;">
    <div class="card-header bg-dark">
        <h4 class="mb-0 text-white">
            Nueva Asignatura Equivalente &nbsp;&nbsp;
        </h4>
    </div>
    <div class="card-body" id="lista">
        <form action="{{ url('Asignatura/guardar') }}"  method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Asignatura 1</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select class="select2 form-control custom-select" id="asignatura_1" style="width: 100%; height:36px;" required>
                                    <option>Buscar Asignatura</option>
                                    @foreach ($carrera as $carre1)
                                    <optgroup label="{{ $carre1->nombre }}">
                                        @php
                                            foreach ($asignatura as $asig1) {
                                                if ($carre1->id == $asig1->carrera_id) {
                                        @endphp
                                            <option value="{{ $asig1->id }}">{{ $asig1->codigo_asignatura }}   {{ $asig1->nombre_asignatura }}</option>
                                        @php
                                                }
                                            }
                                        @endphp
                                    </optgroup>
                                    @endforeach
                                </select>
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Asignatura 2</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select class="select2 form-control custom-select" id="asignatura_2" style="width: 100%; height:36px;" required>
                                    <option>Buscar Equivalencia</option>
                                    @foreach ($carrera as $carre2)
                                    <optgroup label="{{ $carre2->nombre }}">
                                        @php
                                            foreach ($asignatura as $asig2) {
                                                if ($carre2->id == $asig2->carrera_id) {
                                        @endphp
                                            <option value="{{ $asig2->id }}">{{ $asig2->codigo_asignatura }}   {{ $asig2->nombre_asignatura }}</option>
                                        @php
                                                }
                                            }
                                        @endphp
                                    </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Gestion</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="anio_vigente" type="text" id="anio_vigente" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_asig_equi()">Guardar</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn waves-effect waves-light btn-block btn-inverse" onclick="cerrar_datos_carrera()">Cerrar</button>
                    </div>
                </div>
            </form>
    </div>
</div>



<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            ASIGNATURAS EQUIVALENTES &nbsp;&nbsp;
            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nueva_carrera()"><i class="fas fa-plus"></i> &nbsp; NUEVO</button>
        </h4>
    </div>
    <div class="card-body" id="lista_equivalencias">
        
    </div>
</div>


<!-- inicio modal nueva carrera -->
<div id="nueva_carrera" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Nueva Asignatura Equivalente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Carrera/guardar') }}"  method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <h4 class="card-title">Basic Select2</h4>
                                <h6 class="card-subtitle">To use add <code>select2</code> class in select tag.</h6>
                                <select class="select2 form-control custom-select" style="width: 100%; height:36px;">
                                    <option>Select</option>
                                    <optgroup label="Alaskan/Hawaiian Time Zone">
                                        <option value="AK">Alaska</option>
                                        <option value="HI">Hawaii</option>
                                    </optgroup>
                                    <optgroup label="Pacific Time Zone">
                                        <option value="CA">California</option>
                                        <option value="NV">Nevada</option>
                                        <option value="OR">Oregon</option>
                                        <option value="WA">Washington</option>
                                    </optgroup>
                                    <optgroup label="Mountain Time Zone">
                                        <option value="AZ">Arizona</option>
                                        <option value="CO">Colorado</option>
                                        <option value="ID">Idaho</option>
                                        <option value="MT">Montana</option>
                                        <option value="NE">Nebraska</option>
                                        <option value="NM">New Mexico</option>
                                        <option value="ND">North Dakota</option>
                                        <option value="UT">Utah</option>
                                        <option value="WY">Wyoming</option>
                                    </optgroup>
                                    <optgroup label="Central Time Zone">
                                        <option value="AL">Alabama</option>
                                        <option value="AR">Arkansas</option>
                                        <option value="IL">Illinois</option>
                                        <option value="IA">Iowa</option>
                                        <option value="KS">Kansas</option>
                                        <option value="KY">Kentucky</option>
                                        <option value="LA">Louisiana</option>
                                        <option value="MN">Minnesota</option>
                                        <option value="MS">Mississippi</option>
                                        <option value="MO">Missouri</option>
                                        <option value="OK">Oklahoma</option>
                                        <option value="SD">South Dakota</option>
                                        <option value="TX">Texas</option>
                                        <option value="TN">Tennessee</option>
                                        <option value="WI">Wisconsin</option>
                                    </optgroup>
                                    <optgroup label="Eastern Time Zone">
                                        <option value="CT">Connecticut</option>
                                        <option value="DE">Delaware</option>
                                        <option value="FL">Florida</option>
                                        <option value="GA">Georgia</option>
                                        <option value="IN">Indiana</option>
                                        <option value="ME">Maine</option>
                                        <option value="MD">Maryland</option>
                                        <option value="MA">Massachusetts</option>
                                        <option value="MI">Michigan</option>
                                        <option value="NH">New Hampshire</option>
                                        <option value="NJ">New Jersey</option>
                                        <option value="NY">New York</option>
                                        <option value="NC">North Carolina</option>
                                        <option value="OH">Ohio</option>
                                        <option value="PA">Pennsylvania</option>
                                        <option value="RI">Rhode Island</option>
                                        <option value="SC">South Carolina</option>
                                        <option value="VT">Vermont</option>
                                        <option value="VA">Virginia</option>
                                        <option value="WV">West Virginia</option>
                                    </optgroup>
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Nivel</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nivel_carrera" type="text" id="nivel_carrera" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">A&ntilde;o vigente</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="anio_vigente_carrera" type="text" id="anio_vigente_carrera" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_carrera()">GUARDAR CARRERA</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal nueva carrera -->

<!-- inicio modal editar carrera -->
<div id="editar_carreras" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">EDITAR CARRERA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Carrera/actualizar') }}"  method="POST" >
                @csrf
                <div class="modal-body">        
                    <input type="hidden" name="id" id="id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre" type="text" id="nombre" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Nivel</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <input name="nivel" type="text" id="nivel" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">A&ntilde;o vigente</label>
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                            <input name="anio_vigente" type="text" id="anio_vigente" class="form-control" required>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_carrera()">ACTUALIZAR CARRERA</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal editar carrera -->

@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
<!-- This Page JS -->
<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/forms/select2/select2.init.js') }}"></script>

<script>
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){
        $.ajax({
            type:'GET',
            url:"{{ url('Asignatura/ajax_lista') }}",
            success:function(data){
                // $("#grafico_alcance").show('slow');
                $("#lista_equivalencias").html(data);
            }
        });
    });
</script>

<script>
    function guardar_asig_equi(){
        var asignatura_1 = $("#asignatura_1").val();
        var asignatura_2 = $("#asignatura_2").val();
        var anio_vigente = $("#anio_vigente").val();
        $.ajax({
            type:'POST',
            url:"{{ url('Asignatura/guarda_equivalentes') }}",
            data: {
                tipo_asig_1 : asignatura_1, tipo_asig_2 : asignatura_2, tipo_anio_vigente : anio_vigente
            },
            success:function(data){
                $("#asignatura_1").val(' ');
                $("#asignatura_2").val(' ');
                $("#anio_vigente").val(' ');
                Swal.fire(
                    'Excelente!',
                    'Se guardo Correctamente.',
                    'success'
                )
                $("#lista_equivalencias").html(data);
            }
        });
    }
</script>
<script>
    function nueva_carrera()
    {
        $('#mostrar').show('slow');
    }

    function cerrar_datos_carrera()
    {
        $('#mostrar').hide('slow');
    }

    function guardar_carrera()
    {
        var nombre_carrera = $("#nombre_carrera").val();
        var nivel_carrera = $("#nivel_carrera").val();
        var anio_vigente_carrera = $("#anio_vigente_carrera").val();
        if(nombre_carrera.length>0 && nivel_carrera.length>0 && anio_vigente_carrera.length>0){
            Swal.fire(
                'Excelente!',
                'Una nueva carrera fue registrada.',
                'success'
            )
        }
    }

    function editar(id, nombre, nivel, anio_vigente)
    {
        $("#id").val(id);
        $("#nombre").val(nombre);
        $("#nivel").val(nivel);
        $("#anio_vigente").val(anio_vigente);
        $("#editar_carreras").modal('show');
    }

    function actualizar_carrera()
    {
        var id = $("#id").val();
        var nombre = $("#nombre").val();
        var nivel = $("#nivel").val();
        var anio_vigente = $("#anio_vigente").val();
        if(nombre.length>0 && nivel.length>0 && anio_vigente.length>0){
            Swal.fire(
                'Excelente!',
                'Carrera actualizada correctamente.',
                'success'
            )
        }
    }

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
                    'La carrera fue eliminada',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Carrera/eliminar') }}/"+id;
                });
            }
        })
    }
</script>
@endsection
