@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<!-- inicio modal asignaturas -->
<div id="modal_asignaturas" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">FORMULARIO DE CURSOS Y OTROS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" id="formulario_modal_asignatura">
                        @csrf
                        <input type="hidden" name="servicio_id" id="servicio_id">
                        <input type="hidden" name="asignatura_id" id="asignatura_id">

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Codigo</label>
                                    <input name="codigo_asignatura" type="text" id="codigo_asignatura" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Nombre</label>
                                    <input name="nombre_asignatura" type="text" id="nombre_asignatura" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">Orden</label>
                                    <input name="orden_impresion" type="number" id="orden_impresion" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">Semestre</label>
                                    <input name="semestre" type="number" id="semestre" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">Nivel</label>
                                    <input name="nivel" type="number" id="nivel" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Gestion</label>
                                    <input name="anio_vigente" type="number" id="anio_vigente" class="form-control">
                                </div>
                            </div>

                        </div>

                        {{-- TABLA --}}
                        <div class="row" id="mostrar_ocultar" style="display:none;">
                            <div class="card-body">
                                <div class="table-responsive m-t-40">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th>Codigo</th>
                                                <th>Nombre</th>
                                                <th>Carrera</th>
                                                <th>Opcion</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabla_asig">
                                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- HASTA AQUI --}}
                        <div class="row">

                            <div class="col-md-4">

                                <div class="form-group">
                                    <label class="control-label">Carrera</label>
                                    <select name="carrera_id" id="carrera_id" class="form-control custom-select" required>
                                        <option value="">Seleccione</option>
                                        @foreach ($carreras as $carre)
                                            <option value="{{ $carre->id }}">{{ $carre->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Curso</label>
                                    <select name="gestion" id="gestion" class="form-control custom-select" >
                                        <option value="1">Primero</option>
                                        <option value="2">Segundo</option>
                                        <option value="3">Tercero</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Carga Horaria</label>
                                    <input name="carga_horaria" type="number" id="carga_horaria" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Teorico</label>
                                    <input name="teorico" type="number" id="teorico" class="form-control" >
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Practico</label>
                                    <input name="practico" type="number" id="practico" class="form-control" >
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn waves-effect waves-light btn-block btn-success" onclick="guarda_cursos()">GUARDA</button>
                </div>
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- fin modal asignaturas -->

<!-- inicio modal prerequisitos -->
<div id="modal_prerequisitos" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">REGISTRO PREREQUISITOS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" id="formulario_modal_prerequisito">
                        @csrf
                        <input type="hidden" name="fp_asignatura_id" id="fp_asignatura_id" value="">
                        <div class="row">
                            
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Nombre</label>
                                    <div id="select_ajax_materias">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">&nbsp;</label>
                                    <button type="button" class="btn waves-effect waves-light btn-block btn-success" onclick="guarda_prerequisito()">GUARDAR</button>
                                </div>
                            </div>

                        </div>

                    </form>
                    <div id="ca_prerequisitos">
                        
                    </div>

                </div>
                
            </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- fin modal -->

<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-md-4">
                <div class="card border-info">
                <div class="card-header bg-info">
                    <h4 class="mb-0 text-white">SERVICIOS</h4>
                </div>
                    <br />  
                    <form action="#" method="GET" id="formulario_servicios">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="control-label">Servicios </label>
                                        
                                        <select name="c_servicio_id" id="c_servicio_id" class="form-control" required>
                                            <option value="">Seleccione</option>
                                            @foreach ($servicios as $c)
                                                <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Gestion </label>
                                        <input type="number" name="c_gestion" id="c_gestion" class="form-control" value="{{ $gestion }}" min="2011" max="{{ $gestion }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn waves-effect waves-light btn-block btn-success">VER ASIGNATURAS</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8" id="carga_ajax_lista_cursos">
                
            </div>
        </div>

    </div>
</div>

@stop

@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>

<script>
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('#myTable').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });

    $('#formulario_servicios').on('submit', function (event) {
        event.preventDefault();
        var datos_formulario = $(this).serializeArray();
        var servicio_id = $("#servicio_id").val();

        $.ajax({
            url: "{{ url('Servicio/ajax_lista_cursos') }}",
            method: "GET",
            data: datos_formulario,
            cache: false,
            success: function (data) {
                $("#carga_ajax_lista_cursos").html(data);
            }
        })
    });

    function guarda_cursos() {
        formulario_asignatura = $("#formulario_modal_asignatura").serializeArray();
        var servicio_id = $("#servicio_id").val();
        gestion               = $("#anio_vigente").val();
        console.log(gestion);
        $.ajax({
            url: "{{ url('Asignatura/guarda') }}",
            method: "POST",
            data: formulario_asignatura,
            cache: false,
            success: function(data)
            {
                if (data.sw == 1) 
                {
                    $.ajax({
                        url: "{{ url('Servicio/ajax_guardar_servicio_asignatura') }}",
                        method: "POST",
                        data: formulario_asignatura,
                        cache: false,
                        success: function (data) {
                            $("#carga_ajax_lista_cursos").html(data);
                            $("#asignatura_id").val('');
                        }
                    });

                    Swal.fire(
                        'Excelente!',
                        'Los datos fueron guadados',
                        'success'
                    ).then(function() {
                        $("#modal_asignaturas").modal('hide');
                    });
                } else {

                }
            }
        })
    }

    function elimina_asignatura(asignatura_id, nombre)
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

                $.ajax({
                    url: "{{ url('Asignatura/eliminar') }}/"+asignatura_id,
                    method: "GET",
                    cache: false,
                    success: function (data) {

                        $.ajax({
                            url: "{{ url('Carrera/ajax_lista_asignaturas') }}",
                            method: "GET",
                            data: {c_carrera_id: data.carrera_id, c_gestion: data.anio_vigente},
                            cache: false,
                            success: function (data) {
                                $("#carga_ajax_lista_asignaturas").html(data);
                            }
                        });

                        Swal.fire(
                            'Excelente!',
                            'La materia fue eliminada',
                            'success'
                        );
                    }
                });

            }
        })

    }

    function guarda_prerequisito() 
    {
        formulario_prerequisito = $("#formulario_modal_prerequisito").serializeArray();
        gestion                 = $("#anio_vigente").val();
        // console.log(gestion);
        $.ajax({
            url: "{{ url('Asignatura/guarda_prerequisito') }}",
            method: "POST",
            data: formulario_prerequisito,
            cache: false,
            success: function(data)
            {
                $("#ca_prerequisitos").load('{{ url('Asignatura/ajax_muestra_prerequisitos') }}/'+data.asignatura_id);
                Swal.fire(
                    'Excelente!',
                    'El prerequisito fue adicionado',
                    'success'
                ).then(function() {
                    // $("#modal_asignaturas").modal('hide');
                });
            }
        })
    }

    function elimina_prerequisito(prerequisito_id, asignatura_id, nombre)
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
                $.ajax({
                    url: "{{ url('Asignatura/elimina_prerequisito') }}/"+prerequisito_id,
                    method: "GET",
                    // data: formulario_prerequisito,
                    cache: false,
                    success: function(data)
                    {
                        $("#ca_prerequisitos").load('{{ url('Asignatura/ajax_muestra_prerequisitos') }}/'+asignatura_id);
                        Swal.fire(
                            'Excelente!',
                            'El prerequisito fue eliminado',
                            'success'
                        ).then(function() {
                            // $("#modal_asignaturas").modal('hide');
                        });
                    }
                })
            }
        })
    }


</script>
<script>

    $(document).on('keyup', '#codigo_asignatura', function(e) {
        var codigo_asignatura = $('#codigo_asignatura').val();
        var gestion = $('#c_gestion').val();
        if (codigo_asignatura.length > 2) {

                var table = document.getElementById('tabla_asig');
                table.innerHTML = '';

            $.ajax({
                url: "{{ url('Servicio/ajax_verifica_codigo_asignatura') }}",
                method: "GET",
                data: {codigo_asignatura: codigo_asignatura, gestion: gestion},
                cache: false,
                success: function (data) {

                    if (data.mensaje == 'Si') {
                        // appendElem.remove();
                        
                        var num = 1;
                        $('#mostrar_ocultar').show('slow');//para visualizar las asignaturas
                        $.each(data.asignatura, function(index, value) {
                            $("#tabla_asig").append('<tr>'+
                                                    '<td>' + 
                                                        num +
                                                    '</td>' + 
                                                    '<td>' + data.asignatura[index].codigo_asignatura + '</td>' +
                                                    '<td>' + data.asignatura[index].nombre_asignatura + '</td>' +
                                                    '<td>' + data.asignatura[index].carrera_id + '</td>' +
                                                    '<td>' +
                                                        '<button type="button" class="btn btn-success" onclick="muestra_modal(' + data.asignatura[index].id +')"><i class="fas fa-address-card"></i></button>' +
                                                    '</td>' +
                                                '</tr>');
                            num ++;
                        });


                        // $("#asignatura_id").val(data.asignatura.id);
                        // $("#nombre_asignatura").val(data.asignatura.nombre_asignatura);
                        // $("#orden_impresion").val(data.asignatura.orden_impresion);
                        // $("#semestre").val(data.asignatura.semestre);
                        // $("#nivel").val(data.asignatura.nivel);
                        // $("#anio_vigente").val(data.asignatura.anio_vigente);
                        // $("#carrera_id").val(data.asignatura.carrera_id);
                        // $("#gestion").val(data.asignatura.gestion);
                        // $("#carga_horaria").val(data.asignatura.carga_horaria);
                        // $("#teorico").val(data.asignatura.teorico);
                        // $("#practico").val(data.asignatura.practico);  
                    } else {
                        $('#mostrar_ocultar').hide('slow');//para visualizar las asignaturas
                    }
                    // $("#carga_ajax_lista_cursos").html(data);
                }
            });
        }

    });


    $('#nombre_asignatura').on('change', function(e){
         var nombre_asignatura = e.target.value;

         $.ajax({
                url: "{{ url('Servicio/ajax_verifica_nombre_asignatura') }}",
                method: "GET",
                data: {nombre_asignatura: nombre_asignatura},
                cache: false,
                success: function (data) {
                    $("#carga_ajax_lista_cursos").html(data);
                    $("#codigo_asignatura").val("");
                }
            });
    });

</script>
@endsection