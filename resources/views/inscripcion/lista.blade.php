@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('content')
<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<div class="row">
    <!-- Column -->
    <div class="col-md-12">
        <!-- Row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="mb-0 text-white">LISTA DE ALUMNOS DIFERENTES GESTIONES </h4>
                    </div>

                    <div class="card-body">

                                <h4 class="card-title">Alumnos </h4>
                                <div class="table-responsive m-t-40">
                                    <table id="tabla-personas" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>No. Carnet</th>
                                                <th>Apellido Paterno</th>
                                                <th>Apellido Materno</th>
                                                <th>Nombres</th>
                                                <th>Numero de Celular</th>
                                                <th>Razon Social</th>
                                                <th>Nit</th>
                                                <th>Fecha de Ingreso</th>
                                                <th>Sueldo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        
                                    </table>
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
<script src="{{ asset('/assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js')}}"></script>

<script>

$(document).ready(function() {
    //  console.log('testOne');     para debug, ayuda a ver hasta donde se ejecuta la funcion
    // Setup - add a text input to each footer cell
    // $('#example tfoot th').each( function () {
    //     var title = $(this).text();
    //     $(this).html( '<input type="text" placeholder="Buscar '+title+'" />' );
    // } );

    // DataTable
    var table = $('#tabla-personas').DataTable( {
        "iDisplayLength": 10,
        "processing": true,
        "scrollX": true,
        "serverSide": true,
        "ajax": "{{ url('Inscripcion/ajax_datos') }}",
        "columns": [
            {data: 'persona_id'},
            {data: 'asignatura_id'},
            {data: 'carrera_id'},
            {data: 'turno_id'},
            {data: 'paralelo'},
            {data: 'gestion'},
            {data: 'persona_id'},
            {data: 'asignatura_id'},
            {data: 'carrera_id'},
            {data: 'carrera_id'},
        ]
    } );

    // Apply the search
    // table.columns().every( function () {
    //     var that = this;

    //     $( 'input', this.footer() ).on( 'keyup change clear', function () {
    //         if ( that.search() !== this.value ) {
    //             that
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     } );
    // } );

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
</script>
@endsection
