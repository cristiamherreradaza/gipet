<div class="col-lg-12">
    <div class="card border-info">
        <div class="card-header bg-info">
            <h4 class="mb-0 text-white">RE-INSCRIPCION</h4>
        </div>
        <!-- Row -->
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Datos de Re-Inscripcion</h4>
                    </div>
                    <!-- ============================================================== -->
                    <!-- Comment widgets -->
                    <!-- ============================================================== -->
                    <div class="comment-widgets scrollable position-relative mb-2">
                        <form class="pl-3 pr-3" action="#">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Turno
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="re_turno" name="re_turno" required>
                                    <option value="">Seleccionar</option>
                                    @foreach($turnos as $tur)
                                    <option value="{{ $tur->id }}">{{ $tur->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Paralelo
                                    <span class="text-danger">
                                        <i class="mr-2 mdi mdi-alert-circle"></i>
                                    </span>
                                </label>
                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" id="re_paralelo" name="re_paralelo" required>
                                    <option value="">Seleccionar</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="control-label">Gesti&oacute;n</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>

                                <input type="text" class="form-control" id="re_gestion" name="re_gestion" required value="{{ date('Y') }}">
                            </div>
                        </div>
                    </div>
                    <input type="text" class="form-control" hidden id="re_carrera_id" name="re_carrera_id" value="{{ $carrera_id }}">
                    <input type="text" class="form-control" hidden id="re_persona_id" name="re_persona_id" value="{{ $persona_id }}">
                    <input type="text" class="form-control" hidden id="re_persona_sexo" name="re_persona_sexo" value="{{ $sexo }}">

                    <div class="form-group text-center">
                        <button class="btn btn-primary" type="button" onclick="consultar_asignaturas()">Consultar</button>
                    </div>

                </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-8" id="datos_asig_tomar" style="display:none;">
                
            </div>
        </div>
        <!-- Row -->
    </div>
</div>

<script>
    function consultar_asignaturas(){
        var re_turno = $('#re_turno').val();
        var re_paralelo = $('#re_paralelo').val();
        var re_gestion = $('#re_gestion').val();
        var re_carrera_id = $('#re_carrera_id').val();
        var re_persona_id = $('#re_persona_id').val();
        $.ajax({
            type:'GET',
            url:"{{ url('Kardex/ajax_datos_asig_tomar') }}",
            data: {
                tipo_turno_id : re_turno, tipo_paralelo : re_paralelo, tipo_gestion : re_gestion, tipo_carrera_id : re_carrera_id, tipo_persona_id : re_persona_id
            },
            success:function(data){
                // $('#datos_carrera').hide('slow');
                $('#datos_asig_tomar').show('slow');
                $("#datos_asig_tomar").html(data);
            }
        });
    }
</script>
