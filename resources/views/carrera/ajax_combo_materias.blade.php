<select class="form-control" name="fp_materia" style="width: 100%">
    @foreach ($asignaturas as $asignatura)
        <option value="{{ $asignatura->id }}">{{ $asignatura->nombre }} ({{ $asignatura->sigla }})</option>
    @endforeach
</select>