<div class="card border-info">
    @if($datos_carrera)
        <div class="card-header bg-info">
            <h4 class="mb-0 text-white">ASIGNATURAS - ({{ $datos_carrera->nombre }}) &nbsp;&nbsp;
                <button type="button" class="btn waves-effect waves-light btn-sm btn-primary" onclick="nuevo_modal('{{ $datos_carrera->id }}', '{{ $datos_carrera->anio_vigente }}')">
                    <i class="fas fa-plus"></i> &nbsp; NUEVA ASIGNATURA
                </button>
            </h4>
        </div>
    @else
        <div class="card-header bg-info">
            <h4 class="mb-0 text-white">NO EXISTEN ASIGNATURAS EN ESTA GESTION</h4>
        </div>
    @endif                                
    <div class="card-body">
        <div class="table-responsive m-t-40">
            <table id="tabla-ajax_asignaturas" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Sigla</th>
                        <th>Nombre</th>
                        <th>A&ntilde;o</th>
                        <th>Semestre</th>
                        <th>Hrs Acad</th>
                        <th>Hrs Virtu</th>
                        <th>Resol</th>
                        <th>O/Imp.</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignaturas as $asignatura)
                        <tr>
                            <td>{{ $asignatura->sigla }}</td>
                            <td>{{ $asignatura->nombre }}</td>
                            @php
                            $anio = '';
                            switch ($asignatura->gestion) {
                                case 1:
                                    $anio = 'Primer Año';
                                    break;
                                case 2:
                                    $anio = 'Segundo Año';
                                    break;
                                case 3:
                                    $anio = 'Tercer Año';
                                    break;
                                case 4:
                                    $anio = 'Cuarto Año';
                                    break;
                                case 5:
                                    $anio = 'Quinto Año';
                                    break;
                                default:
                                    $anio = 'No definido';
                            }
                            @endphp
                            <td>{{ $anio }}</td>
                            <td class="text-center">{{ $asignatura->semestre }}</td>
                            <td class="text-center">{{ $asignatura->carga_horaria }}</td>
                            <td class="text-center">{{ $asignatura->carga_horaria_virtual }}</td>
                            <td class="text-center">{{ $asignatura->resolucion->resolucion }}</td>
                            <td class="text-center">{{ $asignatura->orden_impresion }}</td>
                            <td>
                                <button type="button" class="btn btn-light" onclick="prerequisitos('{{ $asignatura->id }}', '{{ $asignatura->nombre }}', '{{ $asignatura->carrera_id }}', '{{ $asignatura->anio_vigente }}')" title="Ver Prerequisitos"><i class="fas fa-code-branch"></i></button>
                                <button type="button" class="btn btn-warning" onclick="muestra_modal({{ $asignatura->id }})" title="Editar Asignatura"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" onclick="elimina_asignatura('{{ $asignatura->id }}', '{{ $asignatura->nombre }}')" title="Eliminar Asignatura"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>

<script>
    var asignaturas = @json($asignaturas); 
    $(function () {
        $('#tabla-ajax_asignaturas').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
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
                $("#codigo_asignatura").val(element['sigla']);
                $("#nombre_asignatura").val(element['nombre']);
                $("#orden_impresion").val(element['orden_impresion']);
                $("#semestre").val(element['semestre']);
                $("#nivel").val(element['nivel']);
                $("#carrera_id").val(element['carrera_id']);
                $("#gestion").val(element['gestion']);
                $("#carga_horaria").val(element['carga_horaria']);
                $("#carga_virtual").val(element['carga_horaria_virtual']);
                $("#teorico").val(element['teorico']);
                $("#practico").val(element['practico']);
                $("#anio_vigente").val(element['anio_vigente']);
                $("#ciclo").val(element['ciclo']);
                if(element['estado'] == null){
                    $('#muestra_curricula').val('Si');
                }else{
                    $('#muestra_curricula').val('No');
                }
            }
        });
    }

    function prerequisitos(asignatura_id, nombre, carrera_id, anio_vigente)
    {
        $("#modal_prerequisitos").modal('show');
        $("#asignatura_nombre_prerequisito").val(nombre);
        $("#ca_prerequisitos").load('{{ url('Asignatura/ajax_muestra_prerequisitos') }}/'+asignatura_id);
        $("#select_ajax_materias").load('{{ url('Carrera/ajax_combo_materias') }}/'+carrera_id+'/'+anio_vigente);
        $("#fp_asignatura_id").val(asignatura_id);
    }

</script>