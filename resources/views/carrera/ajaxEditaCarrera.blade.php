<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">EDITAR CARRERA</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    </div>
    <form action="{{ url('Carrera/actualizar') }}"  method="POST" >
        @csrf
        <div class="modal-body">        
            <input type="hidden" name="id_carrera_edicion" id="id_carrera_edicion" value="{{ $carrera->id }}">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label">Nombre</label>
                        <span class="text-danger">
                            <i class="mr-2 mdi mdi-alert-circle"></i>
                        </span>
                        <input name="nombre_carrera_edicion" type="text" id="nombre_carrera_edicion" value="{{ $carrera->nombre }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Duracion</label>
                        <span class="text-danger">
                            <i class="mr-2 mdi mdi-alert-circle"></i>
                        </span>
                        <input name="duracion_carrera_edicion" type="number" id="duracion_carrera_edicion" class="form-control" value="{{ $carrera->duracion_anios }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label">Nivel</label>
                        <span class="text-danger">
                            <i class="mr-2 mdi mdi-alert-circle"></i>
                        </span>
                        <input name="nivel_carrera_edicion" type="text" id="nivel_carrera_edicion" value="{{ $carrera->nivel }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">A&ntilde;o vigente</label>
                        <span class="text-danger">
                            <i class="mr-2 mdi mdi-alert-circle"></i>
                        </span>
                        <input name="anio_vigente_carrera_edicion" type="number" id="anio_vigente_carrera_edicion" class="form-control" value="{{ $carrera->anio_vigente }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label">Resolucion Ministerial</label>
                        <span class="text-danger">
                            <i class="mr-2 mdi mdi-alert-circle"></i>
                        </span>
                        <select name="resolucion_carrera_edicion" id="resolucion_carrera_edicion" class="form-control" required>
                            @foreach($resoluciones as $resolucion)
                                @if($resolucion->id == $carrera->resolucion_id)
                                    <option value="{{ $resolucion->id }}" selected>{{ $resolucion->resolucion }}</option>
                                @else
                                    <option value="{{ $resolucion->id }}">{{ $resolucion->resolucion }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="actualizar_carrera()">ACTUALIZAR CARRERA</button>
        </div>
    </form>
</div>