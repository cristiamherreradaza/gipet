<!-- Signup modal content -->
<div id="modal_nueva_carrera" class="modal fade" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <h4 class="modal-title" id="myModalLabel">CARRERA NUEVA</h4>
                </div>

                <form class="pl-3 pr-3" action="#">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Carrera
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="new_carrera" name="new_carrera" required>
                                    <option value="0">Seleccionar</option>
                                    @foreach($carreras as $carre)
                                    <option value="{{ $carre->id }}">{{ $carre->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Turno
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="new_turno" name="new_turno" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($turnos as $tur)
                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Paralelo
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="new_paralelo" name="new_paralelo" required>
                                    <option value="">Seleccionar</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="control-label">Gesti&oacute;n</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>

                                <input type="text" class="form-control" id="new_gestion" name="new_gestion" required value="{{ date('Y') }}">
                            </div>
                        </div>
                    </div>
                    <input type="text" class="form-control" hidden id="new_persona_id" name="new_persona_id">
                    <input type="text" class="form-control" hidden id="new_persona_sexo" name="new_persona_sexo">

                    <div class="form-group text-center">
                        <button class="btn btn-primary" type="button" onclick="guardar_nueva_carrera()">Guardar</button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<table class="table no-wrap">
    <thead>
        <tr>
            <th>CARRERA</th>
            <th>NIVEL</th>
            {{-- <th>GESTION</th> --}}
            <th>

            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($carrerasPersona as $cp)
            <tr>
                <td>{{ $cp->carrera->nombre }}</td>
                <td>{{ $cp->carrera->nivel }}</td>
                {{-- <td>{{ $cp->anio_vigente }}</td> --}}
                <td>

                    <button type="button" class="btn btn-info" title="M&aacute;s Opciones" onclick="datos_de_carreras('{{ $cp->carrera_id}}', '{{ $datosPersonales->id}}')"><i class="fas fa-eye"></i></button>
                    <button type="button" class="btn btn-success" title="Reinscripcion" onclick="reinscripcion('{{ $cp->carrera_id}}', '{{ $datosPersonales->id}}', '{{ $datosPersonales->sexo}}')"><i class="fas fa-address-card"></i></button>
                </td>
            </tr>
            
        @endforeach

    </tbody>
</table>
<div class="card-body text-right">
    <button class="btn btn-success" onclick="nueva_carrera('{{ $datosPersonales->id}}', '{{ $datosPersonales->sexo}}')">Nueva Carrera</button>
</div>
<script>
    function nueva_carrera(id, sexo){
        $("#new_persona_id").val(id);
        $("#new_persona_sexo").val(sexo);
        $("#modal_nueva_carrera").modal('show');
    }

    function guardar_nueva_carrera(){
        var new_carrera_id = $('#new_carrera').val();
        var new_turno_id = $('#new_turno').val();
        var new_paralelo = $('#new_paralelo').val();
        var new_gestion = $('#new_gestion').val();
        var new_persona_id = $('#new_persona_id').val();
        var new_persona_sexo = $('#new_persona_sexo').val();
        $("#modal_nueva_carrera").modal('hide');
        $.ajax({
            url: "{{ url('Kardex/guardar_datosCarreras') }}",
            method: "POST",
            data: {
                tipo_carrera_id : new_carrera_id, tipo_turno_id : new_turno_id, tipo_paralelo : new_paralelo, tipo_gestion : new_gestion, tipo_persona_id : new_persona_id, tipo_persona_sexo : new_persona_sexo
            },
            success:function(data){
                // $("#grafico_alcance").show('slow');
                
                if (data.mensaje == 'si') {
                    Swal.fire(
                        'Error!',
                        'Ya esta inscrito en la carrera',
                        'error'
                    );
                } else {
                    $("#datos_carreras").html(data);
                    Swal.fire(
                            'Correcto!',
                            'Se actualizo correctamente',
                            'success'
                        );
                }
                

            }
        })
    }

    function datos_de_carreras(carrera_id, persona_id) {
        $.ajax({
            type:'GET',
            url:"{{ url('Kardex/ajax_datos_notas_carreras') }}",
            data: {
                tipo_carrera_id : carrera_id, tipo_persona_id : persona_id
            },
            success:function(data){
                $('#datos_reinscripcion').hide('slow');
                $('#datos_carrera').show('slow');
                $("#datos_carrera").html(data);
            }
        });
    }

    function reinscripcion(carrera_id, id, sexo){
        $.ajax({
            type:'GET',
            url:"{{ url('Kardex/ajax_datos_reinscripcion') }}",
            data: {
                tipo_carrera_id : carrera_id, tipo_persona_id : id, tipo_sexo : sexo
            },
            success:function(data){
                $('#datos_carrera').hide('slow');
                $('#datos_reinscripcion').show('slow');
                $("#datos_reinscripcion").html(data);
            }
        });
    }
</script>
