<form action="#" method="POST" id="formularioInicioFinGestion">
    @csrf
    
<div class="table-responsive m-t-40">
    <table class="table table-bordered table-striped text-center">
        <thead>
            <tr>
                <th>Inicio Gestion</th>
                <th>Fin Gestion</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="hidden" name="carrera_id" value="{{ $carrera }}">
                    <input type="hidden" name="anio_vigente" value="{{ $anio_vigente }}">
                    <input type="date" name="inicio" value="{{ ($inicioGestion != null)?$inicioGestion->inicio:'' }}" class="form-control" required>
                </td>
                <td>
                    <input type="date" name="fin" value="{{ ($inicioGestion != null)?$inicioGestion->fin:'' }}" class="form-control" required>
                </td>
                <td>
                    <button type="button" class="btn waves-effect waves-light btn-block btn-success" onclick="ajaxGuardaInicioFinGestiones()">GUARDAR</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</form>

<script type="text/javascript">

    function ajaxGuardaInicioFinGestiones()
    {
        if($("#formularioInicioFinGestion")[0].checkValidity()){

            let formularioInicioFinGestion = $("#formularioInicioFinGestion").serializeArray();

            $.ajax({
                url: "{{ url('Carrera/ajaxGuardaInicioFinGestiones') }}",
                method: "POST",
                data: formularioInicioFinGestion,
                success: function(data)
                {
                    Swal.fire(
                        'Excelente!',
                        'Las fechas fueron guardadas',
                        'success'
                    )
                }
            })
        }else{
            $("#formularioInicioFinGestion")[0].reportValidity();
        }
    }

</script>
