<div class="card card-outline-info">                                
    <div class="card-header">
        <h4 class="mb-0 text-white">ASIGNATURAS - ({{ $nombre_carrera }})</h4>
    </div>
    <div class="table-responsive m-t-40">
        @if ($asignaturas)
            <table id="tabla-ajax_asignaturas" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sigla</th>
                        <th>Nombre</th>
                        <th>Curso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignaturas as $a)
                        <tr>
                            <td>{{ $a->codigo_asignatura }}</td>
                            <td>{{ $a->nombre_asignatura }}</td>
                            <td>{{ $a->semestre }}</td>
                            <td>
                                <button type="button" class="btn btn-info" onclick="muestra_modal({{ $a->id }})"><i class="fas fa-eye"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        <p></p>
            <h2>La carrera no tiene asignaturas</h2>
        @endif
        
    </div>
</div>

<script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>

<script>
    var asignaturas = @json($asignaturas); 
    // var obj_asignaturas = JSON.parse(asignaturas);
    $(function () {
        $('#tabla-ajax_asignaturas').DataTable();
    });

    function muestra_modal(asignatura_id)
    {
        $("#modal_asignaturas").modal('show');
        $.each(asignaturas, function(key, element){
            if(element['id']==asignatura_id)
            {
                $("#codigo_asignatura").val(element['codigo_asignatura']);
                $("#nombre_asignatura").val(element['nombre_asignatura']);
                $("#orden_impresion").val(element['orden_impresion']);
                $("#semestre").val(element['semestre']);
                $("#nivel").val(element['nivel']);
                $("#carrera_id").val(element['carrera_id']);
                $("#gestion").val(element['gestion']);
                $("#carga_horaria").val(element['carga_horaria']);
                $("#teorico").val(element['teorico']);
                $("#practico").val(element['practico']);
                // console.log(element['nombre_asignatura']);
            }
        });
        // console.log(asignaturas);
    }
</script>