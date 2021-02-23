<select class="form-control custom-select" id="tipo_mensualidad_id" name="tipo_mensualidad_id" onchange="cambiaCantidadCuotas()">
    <option value="">Seleccione</option>
    @foreach($tiposMensualidades as $tm)
        <option value="{{ $tm->id }}" data-mensualidades="{{ $tm->numero_maximo }}">{{ $tm->nombre }} ({{ $tm->numero_maximo }})</option>
    @endforeach
</select>