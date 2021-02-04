<select name="asignatura" id="asignatura" style="width: 100%; height:36px;" class="form-control">
	<option value=""> Seleccione </option>
	@foreach($asignaturas as $asignatura)
		<option value="{{ $asignatura->id }}"> {{ $asignatura->sigla }} {{ $asignatura->nombre }}</option>
	@endforeach
</select>

<script>
	//Funcion para ocultar/mostrar datos de semestre en base al ciclo
    $( function() {
        // $("#detalle_semestre").hide();
        $("#asignatura").change( function() {
			let gestion = $("#gestion").val();
			let asignatura = $("#asignatura").val();
			$.ajax({
				url: "{{ url('User/ajaxBuscaTurnos') }}",
				data: {
					gestion		: gestion,
					asignatura	: asignatura
					},
				type: 'get',
				success: function(data) {
					$("#ajaxMuestraTurno").show();
					$("#ajaxMuestraTurno").html(data);
				}
			});

        });
    });
</script>