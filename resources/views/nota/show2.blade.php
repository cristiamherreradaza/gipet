@extends('layouts.app')

@section('metadatos')
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/datatables.net-bs4/css/responsive.dataTables.min.css') }}">
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Lista de asignaturas</h4>
        <h6 class="card-subtitle">Gestión {{ date('Y') }}</h6>
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Asignatura</th>
                        <th>Carrera</th>
                        <th>Turno</th>
                        <th>Paralelo</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignaturas as $asignatura)
                        @if($asignatura->gestion == date('Y'))
                            <tr>
                                <td>{{ $asignatura->asignatura->codigo_asignatura }}</td>
                                <td>{{ $asignatura->asignatura->nombre_asignatura }}</td>
                                <td>{{ $asignatura->asignatura->carrera->nombre }}</td>
                                <td>{{ $asignatura->turno->descripcion }}</td>
                                <td>{{ $asignatura->paralelo }}</td>
                                <td><button type="button" class="btn btn-success btn-view-contrato" value="{{ $asignatura->id }}" data-toggle="modal" data-target="#modal_contrato"><span class="fa fa-file-text-o"></span></button></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="modal bs-example-modal-lg" id="modal_contrato">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-body">

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
        $('#myTable').DataTable();
        // responsive table
        $('#config-table').DataTable({
            responsive: true
        });
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function (settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function (group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function () {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });

        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
    });

</script>

<script >
     $(document).on("click",".btn-view-contrato", function(){
        valor_IDcontrato = $(this).val();
        //alert(valor_IDcontrato);
        $.ajax({
            url:"{{ url('nota/detalle2') }}",
            type:"GET",
            dataType:"html",
            data:{id:valor_IDcontrato},
            success:function(data){
                $("#modal_contrato .modal-body").html(data);
            }
        });
    });
</script>

@endsection
