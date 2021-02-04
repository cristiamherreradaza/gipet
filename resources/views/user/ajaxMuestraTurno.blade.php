<select name="turno" id="turno" style="width: 100%; height:36px;" class="form-control">
	<option value=""> Seleccione </option>
	@foreach($turnos as $turno)
		<option value="{{ $turno->turno->id }}"> {{ $turno->turno->descripcion }} </option>
	@endforeach
</select>

<script>
	//Funcion para ocultar/mostrar datos de semestre en base al ciclo
    $( function() {
        $("#turno").change( function() {
			let gestion = $("#gestion").val();
			let asignatura = $("#asignatura").val();
			let turno = $("#turno").val();
			$.ajax({
				url: "{{ url('User/ajaxBuscaParalelos') }}",
				data: {
					gestion		: gestion,
					asignatura	: asignatura,
					turno		: turno
					},
				type: 'get',
				success: function(data) {
					$("#ajaxMuestraParalelo").show();
					$("#ajaxMuestraParalelo").html(data);
				}
			});
        });
    });
</script>