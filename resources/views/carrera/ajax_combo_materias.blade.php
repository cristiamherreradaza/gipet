<link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}">

<select class="select2" name="fp_materia" style="width: 100%">
    @foreach ($asignaturas as $a)
        <option value="{{ $a->id }}">{{ $a->nombre_asignatura }} ({{ $a->codigo_asignatura }})</option>
    @endforeach
</select>

<script src="{{ asset('assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        $(".select2").select2({
            dropdownParent: $('#modal_prerequisitos')
        });
    });
</script>