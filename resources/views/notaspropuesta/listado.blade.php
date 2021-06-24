@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<style>
    input { 
        text-align: center; 
        width: 100px;
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h3 class="card-title text-primary"><strong>LISTADO DE PONDERACI&Oacute;N DE ASIGNATURAS</strong></h3>
        <h6 class="card-subtitle text-dark">DOCENTE: {{ auth()->user()->nombres }} {{ auth()->user()->apellido_paterno }} {{ auth()->user()->apellido_materno }}</h6>
        <h6 class="card-subtitle">Año {{ date('Y') }}</h6>
        <div class="table-responsive m-t-40">
            <table class="table table-bordered table-striped text-center">
                <thead class="text-primary">
                    <tr>
                        <!-- <th style="width: 10%">Codigo</th> -->
                        <th>Codigo</th>
                        <th>Asignatura</th>
                        <th>Turno</th>
                        <th>Paralelo</th>
                        <th>Asistencia</th>
                        <th>Practicas</th>
                        <th>Primer Parcial</th>
                        <th>Examen Final</th>
                        <th>Total</th>
                        <th>Extras</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $predefinida = App\Predefinida::where('activo', 'Si')
                                                        ->first();
                        if($predefinida)
                        {
                            $estado = 'readonly';
                        }
                        else
                        {
                            $estado = '';
                        }
                    @endphp
                    @foreach($asignaturas as $asignatura)
                        <tr>
                            <td class="text-nowrap">{{ $asignatura->asignatura->sigla }}</td>
                            <td class="text-nowrap text-left">{{ $asignatura->asignatura->nombre }}</td>
                            <td class="text-nowrap">{{ $asignatura->turno->descripcion }}</td>
                            <td class="text-nowrap">{{ $asignatura->paralelo }}</td>
                            <td><input size="10" min="0" max="100" pattern="^[0-9]+" onchange="calcula( {{ $asignatura->id }} )" data-asistencia="{{ $asignatura->nota_asistencia }}" type="number" id="asistencia-{{ $asignatura->id }}" name="asistencia-{{ $asignatura->id }}" value="{{ round($asignatura->nota_asistencia) }}" step="any" {{ $estado }} class="form-control"></td>
                            <td><input size="10" min="0" max="100" pattern="^[0-9]+" onchange="calcula( {{ $asignatura->id }} )" data-practicas="{{ $asignatura->nota_practicas }}" type="number" id="practicas-{{ $asignatura->id }}" name="practicas-{{ $asignatura->id }}" value="{{ round($asignatura->nota_practicas) }}" step="any" {{ $estado }} class="form-control"></td>
                            <td><input size="10" min="0" max="100" pattern="^[0-9]+" onchange="calcula( {{ $asignatura->id }} )" data-parcial="{{ $asignatura->nota_primer_parcial }}" type="number" id="parcial-{{ $asignatura->id }}" name="parcial-{{ $asignatura->id }}" value="{{ round($asignatura->nota_primer_parcial) }}" step="any" {{ $estado }} class="form-control"></td>
                            <td><input size="10" min="0" max="100" pattern="^[0-9]+" onchange="calcula( {{ $asignatura->id }} )" data-final="{{ $asignatura->nota_examen_final }}" type="number" id="final-{{ $asignatura->id }}" name="final-{{ $asignatura->id }}" value="{{ round($asignatura->nota_examen_final) }}" step="any" {{ $estado }} class="form-control"></td>
                            <td><input size="10" min="0" max="100" type="number" id="totalsuma-{{ $asignatura->id }}" name="totalsuma-{{ $asignatura->id }}" value="{{ ($asignatura->nota_asistencia+$asignatura->nota_practicas+$asignatura->nota_primer_parcial+$asignatura->nota_examen_final) }}" readonly class="form-control"></td>
                            <td><input size="10" min="0" max="100" pattern="^[0-9]+" onchange="calcula( {{ $asignatura->id }} )" data-puntos="{{ $asignatura->nota_puntos_ganados }}" type="number" id="puntos-{{ $asignatura->id }}" name="puntos-{{ $asignatura->id }}" value="{{ round($asignatura->nota_puntos_ganados) }}" step="any" {{ $estado }} class="form-control"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="col-lg-8">
            <form method="post" id="upload_form" enctype="multipart/form-data" class="upload_form mt-4">
                @csrf
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="select_file" id="select_file">
                        <label class="custom-file-label" for="inputGroupFile04">Elegir archivo</label>
                    </div>
                    <div class="input-group-append">
                        <input type="submit" name="upload" id="upload" class="btn btn-success" value="Importar" style="width: 200px;">
                        <a class="btn btn-block btn-success" href="{{ url('notaspropuesta/exportarexcel/'.$usuario->id) }}" style="width: 200px;">Exportar Formato</a>
                    </div>
                </div>
            </form>
        </div> --}}
    </div>
</div>
@stop

@section('js')
<script type="text/javascript">
    // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Si un campo esta vacio(NULL), devolvera el valor 0
    function checkCampos(numero) {
        if(numero.length <= 0){
            return 0;
        }else{
            return numero;
        }
    }

    function calcula(id)
    {

        //tenemos que enviar el id de la nota que se esta modificando y los valores insertados, ó que se encuentran en ese momento en los campos
        var identificador = id;
        var asistencia = $("#asistencia-"+id).val();
        var practicas = $("#practicas-"+id).val();
        var puntos = $("#puntos-"+id).val();
        var parcial = $("#parcial-"+id).val();
        var final = $("#final-"+id).val();

        //validemos cuando sea uno de los valores null, por defecto tiene que sumar 0
        asistencia = checkCampos(asistencia);
        practicas = checkCampos(practicas);
        puntos = checkCampos(puntos);
        parcial = checkCampos(parcial);
        final = checkCampos(final);

        // Sumamos las notas y guardamos en una variable
        //var resultado = parseFloat(asistencia)+parseFloat(practicas)+parseFloat(puntos)+parseFloat(parcial)+parseFloat(final);
        var resultado = parseFloat(asistencia)+parseFloat(practicas)+parseFloat(parcial)+parseFloat(final);
        // $('#totalsuma-'+id).empty();
        // $('#totalsuma-'+id).append(resultado);
        // Asignamos al input con id "'#totalsuma-'+id", el valor de "resultado"
        $('#totalsuma-'+id).val(resultado);
        // Comprobamos que si el resultado es mas de 100 no se guarde, en caso de que sea igual a 100 recien se guarda
        if(resultado != 100){
            //pregunta
            if(resultado > 100){
                //alerta que el resultado no puede ser menor a 100
                //alert('total mayor a 100 cambie!!!!');
                Swal.fire(
                    'Oops...',
                    'El resultado total no debe ser mayor a 100',
                    'error'
                    )
                $('#totalsuma-'+id).css("border-color", "#FA0808");
                //$('#totalsuma-'+id).css("background-color", "#F69DB2");
            }
            
        }else{
            $.ajax({
                type:'POST',
                url:"{{ url('notaspropuesta/actualizar') }}",
                data: {
                    id : identificador,
                    asistencia : asistencia,
                    practicas : practicas,
                    puntos : puntos,
                    parcial : parcial,
                    final : final
                }
            });
            Swal.fire(
                'Excelente!',
                'Asignación de nota registrada correctamente.',
                'success'
            )
            $('#totalsuma-'+id).css("border-color", "#39C449");
            //$('#totalsuma-'+id).css("background-color", "#8CFA84");
        }
    }
</script>

<script>
// Script de importacion de excel
$(document).ready(function() {
    $('.upload_form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: "{{ url('notaspropuesta/ajax_importar') }}",
            method: "POST",
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data)
            {
                if(data.sw == 1){
                    Swal.fire(
                    'Hecho',
                    data.message,
                    'success'
                    ).then(function() {
                        location.reload();
                        $('#select_file').val('');
                    });
                }else{
                    Swal.fire(
                    'Oops...',
                    data.message,
                    'error'
                    )
                }
            }
        })
    });
});
</script>
@endsection
