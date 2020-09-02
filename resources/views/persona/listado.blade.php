@extends('layouts.app')

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('assets/libs/dropzone/dist/min/dropzone.min.css') }}" rel="stylesheet">
@endsection


@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('content')



<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<div class="row">
    <!-- Column -->
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">LISTADO DE ALUMNOS </h4>
                {{-- <div class="table-responsive m-t-40"> --}}
                    <table id="tabla-personas" class="table table-bordered table-striped no-wrap">
                        <thead>
                            <tr>
                                <th>Ap Paterno</th>
                                <th>Ap Materno</th>
                                <th>Nombres</th>
                                <th>N° Carnet</th>
                                <th>N° Celular</th>
                                <th>Razon Social</th>
                                <th>Nit</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                {{-- </div> --}}
            </div>
        </div>
    </div>
    <!-- Column -->
</div>


<!-- inicio modal editar perfil -->
<div id="editar_perfiles" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger">
                <h4 class="modal-title" id="myModalLabel">ASIGNATURAS - RECUPERATORIO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <th>Carrera</th>
                            <th>Asignatura</th>
                            <th>Turno</th>
                            <th>Paralelo</th>
                            <th>Gestion</th>
                            <th>Nota</th>
                            <th>Accion</th>
                    </thead>
                    <tbody id="datos_recuperatorio">
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- fin modal editar perfil -->
@stop
@section('js')
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>

<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/forms/select2/select2.init.js') }}"></script>
<script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>

<script src="{{ asset('js/jquery.zoom.js') }}"></script>
<script src="{{ asset('assets/libs/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/jquery.repeater/repeater-init.js') }}"></script>

<script>
    $.ajaxSetup({
        // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

$(document).ready(function() {

    // DataTable
    var table = $('#tabla-personas').DataTable( {
        "iDisplayLength": 10,
        "processing": true,
        // "scrollX": true,
        "serverSide": true,
        "ajax": "{{ url('Persona/ajax_listado') }}",
        "columns": [
            {data: 'apellido_paterno'},
            {data: 'apellido_materno'},
            {data: 'nombres'},
            {data: 'carnet'},
            {data: 'telefono_celular'},
            {data: 'razon_social_cliente'},
            {data: 'nit'},
            {data: 'action'},
        ],
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
    } );

} );

function ver_persona(persona_id)
{
    // console.log(user_id);
    window.location.href = "{{ url('Kardex/detalle_estudiante') }}/" + persona_id;
}

function recuperatorio(persona_id)
{
    var persona_id1 = persona_id;

    $.ajax({
            type:'GET',
            url:"{{ url('Inscripcion/buscar_recuperatorio') }}",
            data: {
                tipo_persona_id : persona_id1
            },
            success:function(data){
                if (data.mensaje == 'si') {

                    $('#datos_recuperatorio').empty();
                        $.each(data.asignaturas, function(index, value){
                            $('#datos_recuperatorio').append('<tr>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].nombre +'\
                                                                </td>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].nombre_asignatura +'\
                                                                </td>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].descripcion +'\
                                                                </td>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].paralelo +'\
                                                                </td>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].anio_vigente +'\
                                                                </td>\
                                                                <td>\
                                                                    '+ data.asignaturas[index].nota +'\
                                                                </td>\
                                                                <td><button type="button" class="btn btn-success" title="Agregar Asignatura"  onclick="guardar_recuperatorio('+ data.asignaturas[index].id +', '+ data.asignaturas[index].persona_id +', '+ data.asignaturas[index].carrera_id +', '+ data.asignaturas[index].asignatura_id +', '+ data.asignaturas[index].anio_vigente +', '+ data.asignaturas.length +')">Inscribir</button></td>\
                                                            </tr>');
                                                            });
                    $("#editar_perfiles").modal('show');

                } else {
                    Swal.fire(
                            'No tiene Asignaturas!',
                            'Usted no tiene Asignaturas para Recuperar.',
                            'warning'
                        )
                }
            }
        });

    
    // console.log(user_id);
}

function guardar_recuperatorio(inscripcion_id, persona_id, carrera_id, asignatura_id, anio_vigente, numero)
{

        $.ajax({
                type:'POST',
                url:"{{ url('Transaccion/pago_recuperatorio') }}",
                data: {
                    inscripcion_id : inscripcion_id,
                    persona_id : persona_id,
                    carrera_id : carrera_id,
                    asignatura_id : asignatura_id,
                    anio_vigente : anio_vigente
                },
                success:function(data){
                    if (data.mensaje == 'si' && numero != 1) {

                        // $("#editar_perfiles").modal('hide');
                            recuperatorio(data.persona_id);

                            Swal.fire(
                                'Excelente!',
                                'Se guardo Correctamente.',
                                'success'
                            )
                    } else {
                        $("#editar_perfiles").modal('hide');

                            Swal.fire(
                                'Excelente!',
                                'Se guardo Correctamente.',
                                'success'
                            )
                    }
                    
                }
            });
    }

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
