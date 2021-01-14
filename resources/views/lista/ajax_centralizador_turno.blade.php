<select name="turno_id" id="turno_id" class="form-control" onchange="ajaxBuscaParalelo()">
	<option value="">Seleccione</option>
    @foreach ($turnos as $t)
        <option value="{{ $t->turno_id }}">{{ $t->turno->descripcion }}</option>
    @endforeach
</select>

<script type="text/javascript">

	function ajaxBuscaParalelo(){

		let docente = $('#docentes option[value="' + $('#docente_id').val() + '"]').data('valor');
		let gestion = $("#gestion").val();
		let materia = $("#materia_id").val();
		let turno = $("#turno_id").val();

		$.ajax({
			url: "{{ url('Lista/ajax_centralizador_paralelo') }}",
			data: {
				docente: docente,
				gestion: gestion,
				materia: materia,
				turno: turno,
				},
			type: 'get',
			success: function(data) {
				$("#ajaxMuestraParalelo").html(data);
			}
		});
	}
</script>