<select name="paralelo" id="paralelo" style="width: 100%; height:36px;" class="form-control">
	<option value=""> Seleccione </option>
	@foreach($paralelos as $paralelo)
		<option value="{{ $paralelo->paralelo }}"> {{ $paralelo->paralelo }} </option>
	@endforeach
</select>

<script>
	//Funcion para ocultar/mostrar datos de semestre en base al ciclo
    $( function() {
        $("#paralelo").change( function() {
			let gestion = $("#gestion").val();
			let asignatura = $("#asignatura").val();
			let turno = $("#turno").val();
			let paralelo = $("#paralelo").val();

			$.ajax({
				url: "{{ url('User/ajaxVerMaterias') }}",
				data: {
					gestion		: gestion,
					asignatura	: asignatura,
					turno 		: turno,
					paralelo 	: paralelo
					},
				type: 'get',
				success: function(data) {
					$("#detalleAcademicoAjax").show('slow');
					$("#detalleAcademicoAjax").html(data);
				}
			});
			// $.ajax({
			// 	url: "{{ url('User/ajaxBuscaTurnos') }}",
			// 	data: {
			// 		gestion		: gestion,
			// 		asignatura	: asignatura,
			// 		turno		: turno
			// 		},
			// 	type: 'get',
			// 	success: function(data) {
			// 		$("#ajaxMuestraParalelo").html(data);
			// 	}
			// });

        });
    });
</script>