@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('content')
<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<!-- ============================================================== -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12" id="carga_ajax_lista_asignaturas">
                <div class="card card-outline-info">                                
                    <div class="card-header">
                        <h4 class="mb-0 text-white">ALUMNOS INSCRITOS - (TODAS LAS GESTIONES)</h4>
                    </div>
                    <?php $n=1; //vdebug($trabajos, true, false, true)  ?>
                    <div class="table-responsive m-t-40">
                        <table id="tabla-ajax_asignaturas" class="table table-bordered table-striped">
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
                                       <button type="button" class="btn btn-success"><i class="fas fa-star"></i></button>
                                       <a type="button" href="{{ url('Inscripcion/re_inscripcion/'.$per->id) }}" class="btn btn-primary"><i class="fas fa-address-card"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



@stop
@section('js')
<script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>
<script>
    $(function () {
        $('#tabla-ajax_asignaturas').DataTable();
    });        
</script>
</script>
@endsection
