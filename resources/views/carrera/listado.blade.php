@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="card border-info">
    <div class="card-header bg-info">
        <h4 class="mb-0 text-white">
            CARRERAS &nbsp;&nbsp;
            <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nueva_carrera()"><i class="fas fa-plus"></i> &nbsp; NUEVA CARRERA</button>
        </h4>
    </div>
    <form action="#" method="GET" id="formulario_carreras">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Carreras </label>
                        
                        <select name="c_carrera_id" id="c_carrera_id" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach ($carreras as $c)
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
                <div class="col-md-3">
                    <br>
                    <button type="submit" class="btn btn-info" title="Ver Asignaturas de Carrera" ><i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-light" title="Vista Impresion Carrera"  onclick="vista_impresion()"><i class="fas fa-print"></i></button>
                    <button type="button" class="btn btn-warning" title="Editar carrera"  onclick="edita_carrera()"><i class="fas fa-edit"></i></button>
                    <button type="button" class="btn btn-danger" title="Eliminar carrera"  onclick="elimina_carrera()"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-md-12" id="carga_ajax_lista_asignaturas">
        
    </div>
</div>

<!-- inicio modal nueva carrera -->
<div id="nueva_carrera" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">NUEVA CARRERA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Carrera/guardar') }}"  method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label">Nombre</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nombre_carrera" type="text" id="nombre_carrera" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Duracion</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="duracion_carrera" type="number" id="duracion_carrera" class="form-control" value="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label">Nivel</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nivel_carrera" type="text" id="nivel_carrera" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">A&ntilde;o vigente</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="anio_vigente_carrera" type="number" id="anio_vigente_carrera" class="form-control" value="{{ date('Y') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Resolucion Ministerial</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <select name="resolucion_carrera" id="resolucion_carrera" class="form-control" required>
                                    @foreach($resoluciones as $resolucion)
                                        <option value="{{ $resolucion->id }}">{{ $resolucion->resolucion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="guardar_carrera()">GUARDA CARRERA</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal nueva carrera -->

<!-- inicio modal editar carrera -->
<div id="editar_carrera" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" id="editaCarreraAjax">
        
    </div>
</div>
<!-- fin modal editar carrera -->

<!-- inicio modal asignaturas -->
<div id="modal_asignaturas" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">ASIGNATURA</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" id="formulario_modal_asignatura">
                        @csrf
                        <input type="hidden" name="asignatura_id" id="asignatura_id" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Sigla</label>
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                    <input name="codigo_asignatura" type="text" id="codigo_asignatura" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label">Nombre</label>
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                    <input name="nombre_asignatura" type="text" id="nombre_asignatura" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Pertenece a</label>
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                    <select name="gestion" id="gestion" class="form-control custom-select" required>
                                        <option value="1" selected>Primer A&ntilde;o</option>
                                        <option value="2">Segundo A&ntilde;o</option>
                                        <option value="3">Tercer A&ntilde;o</option>
                                        <option value="4">Cuarto A&ntilde;o</option>
                                        <option value="5">Quinto A&ntilde;o</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">A&ntilde;o Vigente</label>
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                    <input name="anio_vigente" type="number" id="anio_vigente" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Orden Impresion</label>
                                    <input name="orden_impresion" type="number" id="orden_impresion" min="1" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Carga Horaria</label>
                                    <input name="carga_horaria" type="number" id="carga_horaria" min="0" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Teorico</label>
                                    <input name="teorico" type="number" id="teorico" min="0" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Practico</label>
                                    <input name="practico" type="number" id="practico" min="0" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Carga Virtual</label>
                                    <input name="carga_virtual" type="number" id="carga_virtual" min="0" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Ciclo</label>
                                    <select name="ciclo" id="ciclo" class="form-control custom-select">
                                        <option value="Semestral">Semestral</option>
                                        <option value="Anual">Anual</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Semestre</label>
                                    <select name="semestre" id="semestre" class="form-control">
                                        <option value="1" selected>1</option>
                                        <option value="2">2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Troncal</label>
                                    <select name="troncal" id="troncal" class="form-control">
                                        <option value="Si" selected>Si</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn waves-effect waves-light btn-block btn-success" onclick="guarda_asignatura()">GUARDA ASIGNATURA</button>
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
                    <h4 class="modal-title" id="myModalLabel">VER PREREQUISITOS</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" id="formulario_modal_prerequisito">
                        @csrf
                        <input type="hidden" name="fp_asignatura_id" id="fp_asignatura_id" value="">
                        <div class="form-group row">
                            <label class="col-sm-3 text-right control-label col-form-label">Asignatura</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="asignatura_nombre_prerequisito" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label class="control-label">Seleccione</label>
                                    <div id="select_ajax_materias">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">&nbsp;</label>
                                    <button type="button" class="btn waves-effect waves-light btn-block btn-success" onclick="guarda_prerequisito()">AGREGAR</button>
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
<!-- fin modal prerequisitos -->

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

    // Funcion que abre el modal para la creacion de una nueva carrera
    function nueva_carrera()
    {
        $("#nueva_carrera").modal('show');
    }

    // Funcion que activa el alert al crear una carrera
    function guardar_carrera()
    {
        var nombre_carrera = $("#nombre_carrera").val();
        var nivel_carrera = $("#nivel_carrera").val();
        var anio_vigente_carrera = $("#anio_vigente_carrera").val();
        var duracion_carrera = $("#duracion_carrera").val();
        if(nombre_carrera.length>0 && nivel_carrera.length>0 && duracion_carrera.length>0 && anio_vigente_carrera.length>0){
            Swal.fire(
                'Excelente!',
                'Una nueva carrera fue registrada.',
                'success'
            )
        }
    }

    $('#formulario_carreras').on('submit', function (event) {
        event.preventDefault();
        var datos_formulario = $(this).serializeArray();
        var carrera_id = $("#carrera_id").val();

        $.ajax({
            url: "{{ url('Carrera/ajax_lista_asignaturas') }}",
            method: "GET",
            data: datos_formulario,
            cache: false,
            success: function (data) {
                $("#carga_ajax_lista_asignaturas").html(data);
            }
        })
    });

    // Funcion que guarda una asignatura nueva/existente y recarga los datos creados
    function guarda_asignatura() {
        // Capturamos todas las variables que se encuentran en el formulario de asignatura y las que necesitemos
        carrera_id = $("#c_carrera_id").val();
        asignatura_id = $("#asignatura_id").val();
        codigo_asignatura = $("#codigo_asignatura").val();
        nombre_asignatura = $("#nombre_asignatura").val();
        orden_impresion = $("#orden_impresion").val();
        anio_vigente = $("#anio_vigente").val();
        gestion = $("#gestion").val();
        ciclo = $("#ciclo").val();
        carga_horaria = $("#carga_horaria").val();
        carga_virtual = $("#carga_virtual").val();
        teorico = $("#teorico").val();
        practico = $("#practico").val();
        semestre = $("#semestre").val();
        troncal = $("#troncal").val();
        // Utilizamos Ajax
        $.ajax({
            url: "{{ url('Asignatura/guarda') }}",
            data: {
                carrera_id: carrera_id,
                asignatura_id: asignatura_id,
                codigo_asignatura: codigo_asignatura,
                nombre_asignatura: nombre_asignatura,
                orden_impresion: orden_impresion,
                anio_vigente: anio_vigente,
                gestion: gestion,
                ciclo: ciclo,
                carga_horaria: carga_horaria,
                carga_virtual: carga_virtual,
                teorico: teorico,
                practico: practico,
                semestre: semestre,
                troncal: troncal
                },
            cache: false,
            type: 'post',
            success: function(data) {
                $.ajax({
                    url: "{{ url('Carrera/ajax_lista_asignaturas') }}",
                    data: {
                        c_carrera_id: carrera_id,
                        c_gestion: anio_vigente
                        },
                    cache: false,
                    type: 'get',
                    success: function (data) {
                        $("#carga_ajax_lista_asignaturas").html(data);
                    }
                });
                Swal.fire(
                    'Excelente!',
                    'Los datos fueron guardados',
                    'success'
                ).then(function() {
                    $("#modal_asignaturas").modal('hide');
                });
            }
        });

        // formulario_asignatura = $("#formulario_modal_asignatura").serializeArray();
        // alert(formulario_asignatura);
        // carrera_id            = $("#carrera_id").val();
        // gestion               = $("#anio_vigente").val();
        // console.log(gestion);
        // $.ajax({
        //     url: "{{ url('Asignatura/guarda') }}",
        //     method: "POST",
        //     data: formulario_asignatura,
        //     cache: false,
        //     success: function(data)
        //     {
        //         if (data.sw == 1) 
        //         {
        //             $.ajax({
        //                 url: "{{ url('Carrera/ajax_lista_asignaturas') }}",
        //                 method: "GET",
        //                 data: {c_carrera_id: carrera_id, c_gestion: gestion},
        //                 cache: false,
        //                 success: function (data) {
        //                     $("#carga_ajax_lista_asignaturas").html(data);
        //                 }
        //             });

        //             Swal.fire(
        //                 'Excelente!',
        //                 'Los datos fueron guardados',
        //                 'success'
        //             ).then(function() {
        //                 $("#modal_asignaturas").modal('hide');
        //             });
        //         }
        //     }
        // })
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
                            data: {
                                c_carrera_id: data.carrera_id,
                                c_gestion: data.anio_vigente
                                },
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

    function elimina_carrera()
    {
        var carrera_id = $("#c_carrera_id").val();
        if(carrera_id.length >0){
            Swal.fire({
                title: 'Seguro que deseas eliminar esta carrera?',
                text: "Luego no podras recuperarla ni sus asignaturas!",
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
                        window.location.href = "{{ url('Carrera/eliminar') }}/"+carrera_id;
                    });
                }
            })
        }else{
            Swal.fire(
                'Seleccione una carrera!',
                '',
                'info'
            )
        }
    }

    // Funcion que muestra los datos referentes a los permisos de un usuario
    function edita_carrera()
    {
        var carrera_id = $("#c_carrera_id").val();
        var anio_vigente = $("#c_gestion").val();
        if(carrera_id.length >0){
            $.ajax({
                url: "{{ url('Carrera/ajaxEditaCarrera') }}",
                data: {
                    carrera_id: carrera_id,
                    anio_vigente: anio_vigente
                    },
                type: 'get',
                success: function(data) {
                    $("#editaCarreraAjax").html(data);
                    $("#editar_carrera").modal('show');
                }
            });
        }else{
            Swal.fire(
                'Seleccione una carrera!',
                '',
                'info'
            )
        }
    }

    // Validacion antes de actualizar un perfil existente
    function actualizar_carrera()
    {
        var id = $("#id_carrera_edicion").val();
        var nombre = $("#nombre_carrera_edicion").val();
        var duracion = $("#duracion_carrera_edicion").val();
        var nivel = $("#nivel_carrera_edicion").val();
        var anio_vigente = $("#anio_vigente_carrera_edicion").val();
        if(nombre.length>0 && duracion.length>0 && nivel.length>0 && anio_vigente.length>0){
            Swal.fire(
                'Excelente!',
                'Carrera actualizada correctamente.',
                'success'
            )
        }
    }

    function vista_impresion()
    {
        var carrera_id = $("#c_carrera_id").val();
        if(carrera_id.length >0){
            window.open("{{ url('Carrera/vista_impresion') }}/"+carrera_id, '_blank');
        }else{
            Swal.fire(
                'Seleccione una carrera!',
                '',
                'info'
            )
        }
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
@endsection