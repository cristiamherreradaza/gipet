<select class="select3" name="materia_id" id="materia_id" style="width: 100%; height:36px;" onchange="ajaxBuscaTurno()">
	<option value="">Seleccione</option>
    @foreach ($materias as $m)
        <option value="{{ $m->asignatura_id }}" data-turno="{{ $m->turno_id }}">{{ $m->asignatura->nombre }} ({{ $m->asignatura->carrera->nombre }}) - {{ $m->turno->descripcion }}  - {{ $m->paralelo }}
        </option>
    @endforeach
</select>

<input type="hidden" name="turno_id" id="turno_id">

<script type="text/javascript">
	$(function () {
	    $(".select3").select2();
	});

 	function ajaxBuscaTurno(){
 		let turno_id = $("#materia_id").find(':selected').data('turno')
 		$("#turno_id").val(turno_id);
 		// alert("entro");
 		// let docente = $("#docente_id").val();
		let docente = $('#docentes option[value="' + $('#docente_id').val() + '"]').data('valor');
 		let gestion = $("#gestion").val();
 		let materia = $("#materia_id").val();

 		$.ajax({
 		    url: "{{ url('Lista/ajax_centralizador_paralelo') }}",
 		    data: {
 		        docente: docente,
 		        gestion: gestion,
 		        materia: materia,
 		        },
 		    type: 'get',
 		    success: function(data) {
 		        $("#ajaxMuestraParalelo").html(data);
 		    }
 		});
 	}
</script>
