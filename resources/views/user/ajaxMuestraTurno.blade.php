<select class="select3" name="materia_id" id="materia_id" style="width: 100%; height:36px;" onchange="ajaxBuscaTurno()">
	<option value="">Seleccione</option>
    @foreach ($materias as $turno)
        <option value="{{ $turno->turno_id }}">{{ $turno->turno->descripcion }}</option>
    @endforeach
</select>

<script type="text/javascript">
	$(function () {
	    $(".select3").select2();
	});

 	function ajaxBuscaTurno(){
 		// alert("entro");
 		// let docente = $("#docente_id").val();
		// let docente = $('#docentes option[value="' + $('#docente_id').val() + '"]').data('valor');
 		let gestion = $("#gestion").val();
 		let materia = $("#materia_id").val();

 		$.ajax({
 		    url: "{{ url('User/ajaxBuscaParalelos') }}",
 		    data: {
 		        docente: docente,
 		        gestion: gestion,
 		        materia: materia,
 		        },
 		    type: 'get',
 		    success: function(data) {
 		        $("#ajaxMuestraTurno").html(data);
 		    }
 		});
 	}
</script>