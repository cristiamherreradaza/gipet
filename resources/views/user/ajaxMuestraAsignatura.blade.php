<input list="docentes" name="docente_id" id="docente_id" class="form-control">
<input type="hidden" name="cod_docente" id="cod_docente">
<datalist id="docentes">
  	@foreach ($docentes as $asignatura)
  	    <option data-valor="{{ $asignatura->sigla }}" value="{{ $asignatura->sigla }} {{ $asignatura->nombre }}">
  	@endforeach

</datalist>

<script type="text/javascript">

	$("#docente_id").change(function() 
	{
	  let docente = $('#docentes option[value="' + $('#docente_id').val() + '"]').data('valor');
	  $("#cod_docente").val(docente);
	  let gestion = $("#gestion").val();

	  $.ajax({
	      url: "{{ url('User/ajaxBuscaTurnos') }}",
	      data: {
	          docente: docente,
	          gestion: gestion,
	          },
	      type: 'get',
	      success: function(data) {
	      	$("#ajaxMuestraTurno").html(data);
	      }
	  });
	}).change();

</script>