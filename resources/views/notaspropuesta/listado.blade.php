@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<style>
    input { 
        text-align: center; 
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Lista de ponderaciones de asignaturas</h4>
        <h6 class="card-subtitle">Gestión {{ date('Y') }}</h6>
        <div class="table-responsive m-t-40">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 10%">Codigo</th>
                        <th>Asignatura</th>
                        <th>Asistencia</th>
                        <th>Practicas</th>
                        <th>Puntos Ganados</th>
                        <th>Primer Parcial</th>
                        <th>Examen Final</th>
                        <th>Total</th>
                        <th>Validado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asignaturas as $asignatura)
                        @if($asignatura->gestion == date('Y'))
                            <tr>
                                <td>
                                    {{ $asignatura->asignatura->codigo_asignatura }}
                                </td>
                                <td>
                                    {{ $asignatura->asignatura->nombre_asignatura }}
                                </td>
                                <td><input size="10" min="0" max="100" pattern="^[0-9]+" onchange="calcula( {{ $asignatura->id }} )" data-asistencia="{{ $asignatura->nota_asistencia }}" type="number" id="asistencia-{{ $asignatura->id }}" name="asistencia-{{ $asignatura->id }}" value="{{ $asignatura->nota_asistencia }}" step="any"></td>
                                <td><input size="10" min="0" max="100" pattern="^[0-9]+" onchange="calcula( {{ $asignatura->id }} )" data-practicas="{{ $asignatura->nota_practicas }}" type="number" id="practicas-{{ $asignatura->id }}" name="practicas-{{ $asignatura->id }}" value="{{ $asignatura->nota_practicas }}" step="any"></td>
                                <td><input size="10" min="0" max="100" pattern="^[0-9]+" onchange="calcula( {{ $asignatura->id }} )" data-puntos="{{ $asignatura->nota_puntos_ganados }}" type="number" id="puntos-{{ $asignatura->id }}" name="puntos-{{ $asignatura->id }}" value="{{ $asignatura->nota_puntos_ganados }}" step="any"></td>
                                <td><input size="10" min="0" max="100" pattern="^[0-9]+" onchange="calcula( {{ $asignatura->id }} )" data-parcial="{{ $asignatura->nota_primer_parcial }}" type="number" id="parcial-{{ $asignatura->id }}" name="parcial-{{ $asignatura->id }}" value="{{ $asignatura->nota_primer_parcial }}" step="any"></td>
                                <td><input size="10" min="0" max="100" pattern="^[0-9]+" onchange="calcula( {{ $asignatura->id }} )" data-final="{{ $asignatura->nota_examen_final }}" type="number" id="final-{{ $asignatura->id }}" name="final-{{ $asignatura->id }}" value="{{ $asignatura->nota_examen_final }}" step="any"></td>
                                <td id="totalsuma{{ $asignatura->id }}"></td>
                                <td>{{ $asignatura->validado }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="alert" id="message" style="display: none"></div>
        <form method="post" id="upload_form" enctype="multipart/form-data" class="upload_form float-left">
            @csrf
            <input type="file" name="select_file" id="select_file">
            <input type="submit" name="upload" id="upload" class="btn btn-rounded btn-success float-lg-right" value="Importar">
        </form>
        <a class="btn btn-rounded btn-success float-lg-left" href="{{ url('notaspropuesta/exportarexcel/'.$usuario->id) }}">Exportar</a> 
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

        var resultado = parseFloat(asistencia)+parseFloat(practicas)+parseFloat(puntos)+parseFloat(parcial)+parseFloat(final);
        $('#totalsuma'+id).empty();
        $('#totalsuma'+id).append(resultado);
        $.ajax({
            type:'get',
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
                    //if(pregunto si es 1 o 0) 1->swwetalert
                    console.log(data.sw);
                    $('#message').css('display', 'block');
                    $('#message').html(data.message);
                    $('#message').addClass(data.class_name);
                }
            })
        });
    });
</script>
@endsection
