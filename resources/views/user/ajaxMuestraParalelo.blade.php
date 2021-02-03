<select name="paralelo" id="paralelo" class="form-control" onchange="ajaxBuscaSemestre()">
	<option value="">Selec</option>
    @foreach ($paralelos as $paralelo)
        <option value="{{ $paralelo->paralelo }}">{{ $paralelo->paralelo }}</option>
    @endforeach
</select>

<script type="text/javascript">

	function ajaxBuscaSemestre(){

		let docente = $('#docentes option[value="' + $('#docente_id').val() + '"]').data('valor');
		let gestion = $("#gestion").val();
		let materia = $("#materia_id").val();
		let turno = $("#turno_id").val();
		let paralelo = $("#paralelo").val();

		$.ajax({
			url: "{{ url('Lista/ajax_centralizador_semestre') }}",
			data: {
				docente: docente,
				gestion: gestion,
				materia: materia,
				turno: turno,
				paralelo: paralelo,
				},
			type: 'get',
			success: function(data) {
				$("#ajaxMuestraSemestre").html(data);
			}
		});
	}

</script>