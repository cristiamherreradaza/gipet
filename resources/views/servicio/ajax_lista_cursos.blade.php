{{-- {{ dd($datos_carrera->id) }} --}}
{{-- <div class="card card-outline-info"> --}}
<div class="card border-primary">
        <div class="card-header bg-primary">
            <h4 class="mb-0 text-white">Servicio - ({{ $servicios->nombre }}) &nbsp;&nbsp;<button type="button" class="btn waves-effect waves-light btn-sm btn-warning" onclick="nuevo_modal({{ $servicios->id }})"><i class="fas fa-plus"></i> &nbsp; NUEVO</button></h4>
        </div>
    <div class="card-body">
        <div class="table-responsive m-t-40">
            @if (!empty($servicios_asignaturas))
                <table id="tabla-ajax_asignaturas" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Gestion</th>
                            <th>Carrera</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($servicios_asignaturas as $a)
                        @php
                            $n = 1; 
                        @endphp
                            <tr>
                                <td>{{ $n++ }}</td>
                                <td>{{ $a->nombre_asignatura }}</td>
                                <td>{{ $a->anio_vigente }}</td>
                                @php
                                    // $notas = App\Nota::where('persona_id', $inscripcion->persona_id)
                                    //                                     ->where('asignatura_id', $inscripcion->asignatura_id)
                                    //                                     ->where('anio_vigente', date('Y'))
                                    //                                     ->whereNull('deleted_at')
                                    //                                     ->get();
                                    $asig = App\Asignatura::where('id', $a->asignatura_id)
                                                    ->first();
                                    if($asig->carrera_id != Null){
                                        $carre = App\Carrera::where('id', $asig->carrera_id)
                                                    ->first();
                                @endphp
                                <td>{{ $carre->nombre }}</td>
                                @php
                                    } else {
                                @endphp
                                <td> </td>
                                @php
                                    }
                                @endphp
                                <td>
                                    <button type="button" class="btn btn-warning" onclick="muestra_modal()"><i class="fas fa-edit"></i></button>
                                    {{-- <button type="button" class="btn btn-info" onclick="prerequisitos('{{ $a->id }}', '{{ $a->carrera_id }}', '{{ $a->anio_vigente }}')"><i class="fas fa-eye"></i></button>
                                    <button type="button" class="btn btn-danger" onclick="elimina_asignatura('{{ $a->id }}', '{{ $a->nombre_asignatura }}')"><i class="fas fa-trash"></i></button> --}}
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
</div>

<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>

<script>
 
    $(function () {
        $('#tabla-ajax_asignaturas').DataTable({
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });

    function nuevo_modal(servicio_id)
    {
        $("#modal_asignaturas").modal('show');
        $("#servicio_id").val(servicio_id);        
        $("#carrera_id").val("");
        $("#anio_vigente").val("");
        // $("#asignatura_id").val("");
        $("#codigo_asignatura").val("");
        $("#nombre_asignatura").val("");
        $("#orden_impresion").val("");
        $("#semestre").val("");
        $("#nivel").val("");
        // $("#carrera_id").val("");
        $("#gestion").val("");
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