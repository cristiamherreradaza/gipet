@if ($docentes->count() > 0)
<input list="docentes" name="docente_id" id="docente_id" class="form-control">
<input type="hidden" name="cod_docente" id="cod_docente">
<datalist id="docentes">
  	@foreach ($docentes as $docente)
  	    <option data-valor="{{ $docente->docente_id }}" value="{{ $docente->docente['nombres'] }} {{ $docente->docente['apellido_paterno'] }} {{ $docente->docente['apellido_materno'] }}">
  	@endforeach

</datalist>

{{-- <select class="select2" name="docente_id" id="docente_id" style="width: 100%; height:36px;" onchange="ajaxBuscaMaterias()">
	<option value="">Seleccione</option>
</select> --}}

<script type="text/javascript">

	$("#docente_id").change(function() 
	{
	  let docente = $('#docentes option[value="' + $('#docente_id').val() + '"]').data('valor');
	  $("#cod_docente").val(docente);
	  let gestion = $("#gestion").val();

	  $.ajax({
	      url: "{{ url('Lista/ajax_centralizador_materia') }}",
	      data: {
	          docente: docente,
	          gestion: gestion,
	          },
	      type: 'get',
	      success: function(data) {
	      	$("#ajaxMuestraMateria").html(data);
	      }
	  });
	}).change();

</script>
@else
	No hay
@endif