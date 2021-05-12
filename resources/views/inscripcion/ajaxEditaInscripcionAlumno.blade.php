<div class="modal-content">
    <form action="{{ url('Inscripcion/ajaxActualizaInscripcionAlumno') }}" method="post">
        @csrf
        <div class="modal-header bg-info">
            <h4 class="modal-title text-white" id="myModalLabel">
                <strong>EDITA INSCRIPCION</strong>
            </h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-hover no-wrap">
                        <thead>
                            <tr>
                                <th>Carrera</th>
                                <th>Curso</th>
                                <th>Turno</th>
                                <th>Paralelo</th>
                                <th>Gestion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $datosInscripcion->carrera['nombre'] }}</td>
                                <td>{{ $datosInscripcion->gestion }}&deg; A&ntilde;o</td>
                                <td>{{ $datosInscripcion->turno->descripcion }}</td>
                                <td>{{ $datosInscripcion->paralelo }}</td>
                                <td>{{ $datosInscripcion->anio_vigente }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="row">
                
                <div class="col-md-4">
                    <input type="hidden" name="persona_id" value="{{ $datosInscripcion->persona_id }}">
                    <input type="hidden" name="carrera_id" value="{{ $datosInscripcion->carrera_id }}">
                    <input type="hidden" name="gestion" value="{{ $datosInscripcion->gestion }}">
                    <input type="hidden" name="turno_id_ante" value="{{ $datosInscripcion->turno_id }}">
                    <input type="hidden" name="paralelo_ante" value="{{ $datosInscripcion->paralelo }}">
                    <input type="hidden" name="anio_vigente" value="{{ $datosInscripcion->anio_vigente }}">
                    <input type="hidden" name="estado_ante" value="{{ $datosCarrerasPersona->estado }}">
                    <div class="form-group">
                        <label>Turno
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                        </label>
                        <select class="form-control custom-select" id="turno_id" name="turno_id" required>
                            @foreach($turnos as $turno)
                                <option value="{{ $turno->id }}" {{ ($datosInscripcion->turno_id==$turno->id)?'selected':'' }}>{{ $turno->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Paralelo
                            <span class="text-danger">
                                <i class="mr-2 mdi mdi-alert-circle"></i>
                            </span>
                        </label>
                        <select class="form-control custom-select" id="paralelo" name="paralelo" required>
                                <option value="A" {{ ($datosInscripcion->paralelo=='A')?'selected':'' }}>A</option>
                                <option value="B" {{ ($datosInscripcion->paralelo=='B')?'selected':'' }}>B</option>
                                <option value="C" {{ ($datosInscripcion->paralelo=='C')?'selected':'' }}>C</option>
                                <option value="D" {{ ($datosInscripcion->paralelo=='D')?'selected':'' }}>D</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado_inscripcion" id="estado_inscripcion" class="form-control custom-select">
                            <option value="">Seleccione</option>
                            <option value="APROBO" {{ ($datosCarrerasPersona->estado=='APROBO')?'selected':'' }}>APROBO</option>
                            <option value="REPROBO" {{ ($datosCarrerasPersona->estado=='REPROBO')?'selected':'' }}>REPROBO</option>
                            <option value="CONGELADO" {{ ($datosCarrerasPersona->estado=='CONGELADO')?'selected':'' }}>CONGELADO</option>
                            <option value="ABANDONO" {{ ($datosCarrerasPersona->estado=='ABANDONO')?'selected':'' }}>ABANDONO</option>
                        </select>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn waves-effect waves-light btn-block btn-success">CAMBIAR</button>
        </div>
    </form>
</div>

<script>
    
</script>