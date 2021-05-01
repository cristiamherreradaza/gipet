<select name="paralelo" id="paralelo" class="form-control" required>
    @foreach ($comboParalelos as $cp)
        <option value="{{ $cp->paralelo }}">{{ $cp->paralelo }}</option>
    @endforeach
</select>