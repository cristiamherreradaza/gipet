@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card border-info" id="mostrar" style="display:block;">
        <div class="card-header bg-info">
            <h4 class="mb-0 text-white">
                BUSQUEDA DE ALUMNOS
            </h4>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>CARNET</label>
                        <input type="number" class="form-control termino" name="cedula" id="cedula">
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label>PATERNO</label>
                        <input type="text" class="form-control termino" name="apellido_paterno" id="apellido_paterno">
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label>MATERNO</label>
                        <input type="text" class="form-control termino" name="apellido_materno" id="apellido_materno">
                    </div>
                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label>NOMBRES</label>
                        <input type="text" class="form-control termino" name="nombres" id="nombres">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12" id="ajaxPersonas">
                    <table class="table-striped table-hover table-bordered table no-wrap" id="tabla-alumnos">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CEDULA</th>
                                <th>APELLIDO PATERNO</th>
                                <th>APELLIDO MATERNO</th>
                                <th>NOMBRES</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                    
                        <tbody>
                            @foreach ($personas as $p)
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->cedula }}</td>
                                <td>{{ $p->apellido_paterno }}</td>
                                <td>{{ $p->apellido_materno }}</td>
                                <td>{{ $p->nombres }}</td>
                                <td>
                                    <button type="button" class="btn btn-success" title="PAGOS" onclick="selecciona({{ $p->id }})">
                                        <i class="fas fa-donate"></i>
                                    </button>
                                    <button onclick="ver_persona('{{ $p->id }}')" type="button" class="btn btn-info" title="ACADEMICO"><i
                                            class="fas fa-list"></i></button>
                                    <button onclick="eliminar_persona('{{ $p->id }}', '{{ $p->cedula }}')" type="button"
                                        class="btn btn-danger" title="ELIMINAR"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12" id="ajaxDatosPersona">

                </div>
            </div>

        </div>

        
    </div>
</div>

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

    $(function () {
        $('#tabla-alumnos').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
            searching: false,
            lengthChange: false,
            order: [[ 0, "desc" ]]
        });
    });


    $(document).on('keyup', '.termino', function(e) {

        let cedula = $('#cedula').val();
        let apellido_paterno = $('#apellido_paterno').val();
        let apellido_materno = $('#apellido_materno').val();
        let nombres = $('#nombres').val();

        // console.log(cedula);

        if (cedula.length > 3 || apellido_paterno.length > 3 || apellido_materno.length > 3 || nombres.length > 3) {
            // alert('si paso');
            $.ajax({
                url: "{{ url('Factura/ajaxBuscaPersona') }}",
                data: {
                    cedula: cedula,
                    apellido_paterno: apellido_paterno,
                    apellido_materno: apellido_materno,
                    nombres: nombres,
                },
                type: 'POST',
                success: function(data) {
                    $("#ajaxPersonas").show('slow');
                    $("#ajaxPersonas").html(data);
                }
            });
        }

    });

    var t = $('#pensiones').DataTable({
        paging: false,
        searching: false,
        ordering:  false,
        info: false,
        language: {
            url: '{{ asset('datatableEs.json') }}'
        },
    });

    function ver_persona(persona_id){
        window.location.href = "{{ url('Persona/informacion') }}/" + persona_id;
    }

    function eliminar_persona(persona_id, cedula){
        Swal.fire({
            title: 'Desea eliminar al estudiante con cedula ' + cedula + '?',
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
                    url: "{{ url('Persona/eliminar_persona') }}",
                    data: {
                        persona_id: persona_id
                        },
                    cache: false,
                    type: 'post',
                    success: function(data) {
                        Swal.fire(
                            'Excelente!',
                            'El estudiante fue eliminado',
                            'success'
                        )
                        // window.location.href = "{{ url('Factura/formularioFacturacion') }}/";
                    }
                });
            }
        })
    }

    function selecciona(personaId)
    {
        $.ajax({
            url: "{{ url('Factura/ajaxPersona') }}",
            data: {personaId: personaId},
            type: 'POST',
            success: function(data) {
                $("#ajaxPersonas").hide('slow');
                $("#ajaxDatosPersona").html(data);
            }
        });
    }

</script>
@endsection
