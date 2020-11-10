<div class="col-md-12">
    <div class="form-group">
        <label class="control-label">Asignaturas</label>
        @foreach($asignaturas as $key => $asignatura)
            @php
                $consulta = App\RequisitosCertificado::where('certificado_id', $certificado->id)
                                                    ->where('asignatura_id', $asignatura->id)
                                                    ->count();
                if($consulta > 0)
                {
                    $checkeado = 'checked';
                }
                else
                {
                    $checkeado = '';
                }
            @endphp
            <div class="col-md-12">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input cajas" value="{{ $asignatura->id }}" id="customCheck-{{$key}}" name="datosrequisitos[]" {{ $checkeado }}>
                    <label for="customCheck-{{$key}}" class="custom-control-label">{{ $asignatura->carrera->nombre }} - {{ $asignatura->nombre }}</label>
                </div>
            </div>
        @endforeach
    </div>
</div>