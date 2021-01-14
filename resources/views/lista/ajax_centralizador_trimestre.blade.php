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

		/*let docente = $('#docentes option[value="' + $('#docente_id').val() + '"]').data('valor');
		let gestion = $("#gestion").val();
		let materia = $("#materia_id").val();
		let turno = $("#turno_id").val();
		let paralelo = $("#paralelo").val();
		let semestre = $("#semestre").val();
		let trimestre = $("#trimestre").val();

		$.ajax({
			url: "{{ url('Lista/ajax_genera_centralizador') }}",
			data: {
				docente: docente,
				gestion: gestion,
				materia: materia,
				turno: turno,
				paralelo: paralelo,
				semestre: semestre,
				trimestre: trimestre,
				},
			type: 'get',
			success: function(data) {
				// $("#ajaxMuestraTrimestre").html(data);
			}
		});*/
	}
</script>