{{-- {{ dd($datos_carrera->id) }} --}}
<div class="card card-outline-info">
    @if ($datos_carrera)
        <div class="card-header">
            <h4 class="mb-0 text-white">ASIGNATURAS - ({{ $datos_carrera->nombre }}) &nbsp;&nbsp;<button type="button" class="btn waves-effect waves-light btn-sm btn-warning" onclick="nuevo_modal('{{ $datos_carrera->id }}', '{{ $datos_carrera->anio_vigente }}')"><i class="fas fa-plus"></i> &nbsp; NUEVA MATERIA</button></h4>
        </div>
    @else
        <div class="card-header">
            <h4 class="mb-0 text-white">NO EXISTE LA CARRERA EN ESA GESTION &nbsp;&nbsp;</h4>
        </div>
    @endif                                

    <div class="table-responsive m-t-40">
        @if (!empty($asignaturas))
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
                                <button type="button" class="btn btn-warning" onclick="muestra_modal({{ $a->id }})"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-info" onclick="prerequisitos('{{ $a->id }}', '{{ $a->carrera_id }}', '{{ $a->anio_vigente }}')"><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn btn-danger" onclick="elimina_asignatura('{{ $a->id }}', '{{ $a->nombre_asignatura }}')"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        <p></p>
            <h3>La carrera no tiene asignaturas</h3>
        @endif
        
    </div>
</div>

<script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.responsive.min.js') }}"></script>

<script>
    var asignaturas = @json($asignaturas); 
    $(function () {
        $('#tabla-ajax_asignaturas').DataTable();
    });

    function nuevo_modal(carrera_id, anio_vigente)
    {
        $("#modal_asignaturas").modal('show');        
        $("#carrera_id").val(carrera_id);
        $("#anio_vigente").val(anio_vigente);
        $("#asignatura_id").val("");
        $("#codigo_asignatura").val("");
        $("#nombre_asignatura").val("");
        $("#orden_impresion").val("");
        $("#semestre").val("");
        $("#nivel").val("");
        // $("#carrera_id").val("");
        // $("#gestion").val("");
        $("#carga_horaria").val("");
        $("#teorico").val("");
        $("#practico").val("");
        // $("#anio_vigente").val("");
    }

    function muestra_modal(asignatura_id)
    {
        $("#modal_asignaturas").modal('show');
        $.each(asignaturas, function(key, element){
            if(element['id']==asignatura_id)
            {
                $("#asignatura_id").val(element['id']);
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
                $("#anio_vigente").val(element['anio_vigente']);
                // console.log(element['nombre_asignatura']);
            }
        });
        // console.log(asignaturas);
    }

    function prerequisitos(asignatura_id, carrera_id, anio_vigente)
    {
        $("#modal_prerequisitos").modal('show');
        $("#ca_prerequisitos").load('{{ url('Asignatura/ajax_muestra_prerequisitos') }}/'+asignatura_id);
        $("#select_ajax_materias").load('{{ url('Carrera/ajax_combo_materias') }}/'+carrera_id+'/'+anio_vigente);
        $("#fp_asignatura_id").val(asignatura_id);
    }

</script>