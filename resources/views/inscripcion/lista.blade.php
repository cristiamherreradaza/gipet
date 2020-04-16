@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('content')
<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<!-- ============================================================== -->
        <div class="row">
            <div class="col-12">
                <!-- table responsive -->
                <div class="card">
                    <div class="card-body">
                        <?php $n=1; //vdebug($trabajos, true, false, true)  ?>
                        <h4 class="card-title">ALUMNOS INSCRITOS TODAS LAS GESTIONES</h4>
                        <div class="table-responsive m-t-40">
                            <table id="config-table" class="table display table-bordered table-striped no-wrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Carnet</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                        <th>Nombres</th>
                                        <th>Celular</th>
                                        <th>Razon Social</th>
                                        <th>NIT</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($personas as $per)
                                    <tr>
                                        <td>{{ $n++ }}</td>
                                        <td>{{ $per->carnet }}</td>
                                        <td>{{ $per->apellido_paterno }}</td>
                                        <td>{{ $per->apellido_materno }}</td>
                                        <td>{{ $per->nombres }}</td>
                                        <td>{{ $per->telefono_celular }}</td>
                                        <td>{{ $per->razon_social_cliente}}</td>
                                        <td>{{ $per->nit }}</td>
                                        <td>
                                           <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->


@stop
@section('js')
<script src="{{ asset('/assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>
<script>
  $(function () {
        $('#myTable').DataTable();
        // responsive table
        $('#config-table').DataTable({
            responsive: true,
            "order": [
                [0, 'desc']
            ],
            "language": {
                "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            }
        });
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
