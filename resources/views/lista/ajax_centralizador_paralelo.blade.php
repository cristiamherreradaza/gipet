<select name="paralelo" id="paralelo" class="form-control" onchange="ajaxBuscaSemestre()">
	<option value="">Selec</option>
    @foreach ($paralelos as $p)
        <option value="{{ $p->paralelo }}">{{ $p->paralelo }}</option>
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
			url: "{{ url('Lista/ajax_centralizador_trimestre') }}",
			data: {
				docente: docente,
				gestion: gestion,
				materia: materia,
				turno: turno,
				paralelo: paralelo,
				},
			type: 'get',
			success: function(data) {
				$("#ajaxMuestraTrimestre").html(data);
			}
		});
	}

</script>