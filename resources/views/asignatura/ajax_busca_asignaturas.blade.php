<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">

<div class="form-group">
    <label class="control-label">Asignatura 1</label>
    <span class="text-danger">
        <i class="mr-2 mdi mdi-alert-circle"></i>
    </span>
    <select class="select2 form-control custom-select" name="asignatura_2" id="asignatura_2"
        style="width: 100%; height:36px;" required>
        @foreach($asignaturas as $a)
        <option value="{{ $a->id }}">{{ $a->sigla }} {{ $a->nombre }}</option>
        @endforeach
    </select>
</div>

<script src="{{ asset('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/forms/select2/select2.init.js') }}"></script>