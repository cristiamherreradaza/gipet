<select name="semestre" id="semestre" class="form-control" onchange="ajaxBuscaTrimestre()">
	<option value="">Selec</option>
	@foreach ($semestre as $s)
		@if ($s != null)
			<option value="{{ $s->semestre }}">{{ $s->semestre }}</option>
		@endif
    @endforeach
</select>

<script type="text/javascript">

	function ajaxBuscaTrimestre(){

		let docente = $('#docentes option[value="' + $('#docente_id').val() + '"]').data('valor');
		let gestion = $("#gestion").val();
		let materia = $("#materia_id").val();
		let turno = $("#turno_id").val();
		let paralelo = $("#paralelo").val();
		let semestre = $("#semestre").val();

		$.ajax({
			url: "{{ url('Lista/ajax_centralizador_trimestre') }}",
			data: {
				docente: docente,
				gestion: gestion,
				materia: materia,
				turno: turno,
				paralelo: paralelo,
				semestre: semestre,
				},
			type: 'get',
			success: function(data) {
				$("#ajaxMuestraTrimestre").html(data);
			}
		});
	}
</script>