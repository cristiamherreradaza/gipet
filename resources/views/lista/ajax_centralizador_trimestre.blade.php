<select name="trimestre" id="trimestre" class="form-control" onchange="muestraBtn()">
	<option value="">Selec</option>
	@foreach ($trimestre as $s)
		<option value="{{ $s->trimestre }}">{{ $s->trimestre }}</option>
    @endforeach
</select>
<script>
	function muestraBtn()
	{
		$("#btnGenera").show();
	}
</script>