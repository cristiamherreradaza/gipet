@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
        </h4>
    </div>
    <form action="#" method="GET" id="formulario_carreras">
        <div class="card-body">
            <div class="row">
                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">Gestion </label>
                        <input type="number" name="c_gestion" id="c_gestion" class="form-control"
                            value="{{ date('Y') }}" min="2011" max="{{ date('Y') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <br>
                    <button type="submit" class="btn btn-info" title="Ver Asignaturas de Carrera"><i class="fas fa-eye"></i></button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped no-wrap">
                            <thead>
                                <tr>
                                    <th>CARRERA</th>
                                    <th>A&Nacute;O</th>
                                    <th>1 BIM</th>
                                    <th>2 BIM</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carrerasNotasPropuestas as $c)
                                    @php
                                        $primerBimestre = App\Nota::where('carrera_id', $c->carrera_id)
                                                                ->where('anio_vigente', $c->anio_vigente)
                                                                ->where('gestion', $c->gestion)
                                                                ->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $c->carrera->nombre }}</td>
                                        <td>{{ $c->gestion }}&deg; a&ntilde;o</td>
                                        <td>
                                            @if ($primerBimestre->finalizado != null)
                                                <a href="{{ url("Carrera/actualizaCierraNotas/$c->carrera_id/$c->anio_vigente/$c->gestion/abierto/1") }}" type="button" class="btn waves-effect waves-light btn-danger">CERRADO</a>
                                            @else
                                                <a href="{{ url("Carrera/actualizaCierraNotas/$c->carrera_id/$c->anio_vigente/$c->gestion/cerrado/1") }}" type="button" class="btn waves-effect waves-light btn-success">ABIERTO</a>

                                            @endif
                                        </td>
                                        <td>
                                            @if ($primerBimestre->finalizado == null)
                                                -
                                            @else
                                                -
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-md-12" id="carga_ajax_lista_asignaturas">

    </div>
</div>

<!-- inicio modal prerequisitos -->

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

    // Funcion que guarda una asignatura nueva/existente 
    // y recarga los datos creados
    function guarda_asignatura() {
        // Capturamos todas las variables que se encuentran 
        // en el formulario de asignatura y las que necesitemos
        carrera_id            = $("#c_carrera_id").val();
        asignatura_id         = $("#asignatura_id").val();
        codigo_asignatura     = $("#codigo_asignatura").val();
        nombre_asignatura     = $("#nombre_asignatura").val();
        orden_impresion       = $("#orden_impresion").val();
        anio_vigente          = $("#anio_vigente").val();
        gestion               = $("#gestion").val();
        ciclo                 = $("#ciclo").val();
        carga_horaria         = $("#carga_horaria").val();
        carga_virtual         = $("#carga_virtual").val();
        teorico               = $("#teorico").val();
        practico              = $("#practico").val();
        semestre              = $("#semestre").val();
        troncal               = $("#troncal").val();
        resolucion_asignatura = $("#resolucion_asignatura").val();
        muestra_curricula     = $("#muestra_curricula").val();
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
                troncal: troncal,
                resolucion_asignatura: resolucion_asignatura,
                muestra_curricula: muestra_curricula
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
        var gestion = $("#c_gestion").val();
        if(carrera_id.length >0){
            window.open("{{ url('Carrera/vista_impresion') }}/"+carrera_id+"/"+gestion, '_blank');
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

    //Funcion para ocultar/mostrar datos de semestre en base al ciclo
    $( function() {
        $("#detalle_semestre").hide();
        $("#ciclo").change( function() {
            if ($(this).val() == "Anual") {
                $("#detalle_semestre").hide();
            }
            if ($(this).val() == "Semestral") {
                $("#detalle_semestre").show();
            }
        });
    });
</script>
@endsection