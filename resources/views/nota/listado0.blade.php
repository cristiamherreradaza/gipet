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

<div id="divmsg" style="display:none" class="alert alert-primary" role="alert"></div>
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('message'))
            <p>{{ Session::get('message') }}</p>
        @endif
        <div id="accordian-3">
            @foreach($asignaturas as $key => $x)
                <div class="card">
                    <div class="card-header bg-info">
                        <h4 class="my-0 text-white">
                            {{ $x->asignatura->codigo_asignatura }}
                            {{ $x->asignatura->nombre_asignatura }}
                            <a class="btn btn-rounded btn-success float-lg-right" href="{{ url('nota/exportarexcel/'.$x->id) }}">Exportar</a>
                            
                            <form method="post" id="upload_form" enctype="multipart/form-data" class="upload_form float-right">
                                @csrf
                                <!-- <input type="file" name="file"> -->
                                <!-- <button class="btn btn-rounded btn-success float-lg-right">Importar</button> -->
                                <input type="file" name="select_file" id="select_file">
                                <input type="submit" name="upload" id="upload" class="btn btn-rounded btn-success float-lg-right" value="Importar">
                            </form>
                        </h4>                        
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>Nomina Estudiantes</th>
                                        <th>Asistencia</th>
                                        <th>Practicas</th>
                                        <th>Puntos Ganados</th>
                                        <th>Primer Parcial</th>
                                        <th>Examen Final</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cursantes as $y)
                                        @if($x->asignatura_id == $y->asignatura_id  && $x->turno_id == $y->turno_id && $x->user_id == $y->user_id && $x->paralelo == $y->paralelo && $x->gestion == $y->gestion)
                                        <tr>
                                            <td>
                                                {{ $y->persona->nombres }} {{ $y->persona->apellido_paterno }} {{ $y->persona->apellido_materno }}
                                            </td>
                                            <td><input size="10" min="0" max="{{ $x->nota_asistencia }}" pattern="^[0-9]+" onchange="calcula( {{ $y->id }} )" data-asistencia="{{ $y->nota_asistencia }}" type="number" id="asistencia-{{ $y->id }}" name="asistencia-{{ $y->id }}" value="{{ $y->nota_asistencia }}" step="any"></td>
                                            <td><input size="10" min="0" max="{{ $x->nota_practicas }}" pattern="^[0-9]+" onchange="calcula( {{ $y->id }} )" data-practicas="{{ $y->nota_practicas }}" type="number" id="practicas-{{ $y->id }}" name="practicas-{{ $y->id }}" value="{{ $y->nota_practicas }}" step="any"></td>
                                            <td><input size="10" min="0" max="{{ $x->nota_puntos_ganados }}" pattern="^[0-9]+" onchange="calcula( {{ $y->id }} )" data-puntos="{{ $y->nota_puntos_ganados }}" type="number" id="puntos-{{ $y->id }}" name="puntos-{{ $y->id }}" value="{{ $y->nota_puntos_ganados }}" step="any"></td>
                                            <td><input size="10" min="0" max="{{ $x->nota_primer_parcial }}" pattern="^[0-9]+" onchange="calcula( {{ $y->id }} )" data-parcial="{{ $y->nota_primer_parcial }}" type="number" id="parcial-{{ $y->id }}" name="parcial-{{ $y->id }}" value="{{ $y->nota_primer_parcial }}" step="any"></td>
                                            <td><input size="10" min="0" max="{{ $x->nota_examen_final }}" pattern="^[0-9]+" onchange="calcula( {{ $y->id }} )" data-final="{{ $y->nota_examen_final }}" type="number" id="final-{{ $y->id }}" name="final-{{ $y->id }}" value="{{ $y->nota_examen_final }}" step="any"></td>
                                            <td id="totalsuma{{ $y->id }}">{{ $y->nota_total }}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="alert" id="message" style="display: none"></div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@stop
@section('js')

<script>
$(document).ready(function() {
    $('.upload_form').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: "{{ url('nota/ajax_importar') }}",
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

<script type="text/javascript">
    // definimos cabecera donde estarra el token y poder hacer nuestras operaciones de put,post...
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function checkCampos(numero) {
        if(numero.length <= 0){
            return 0;
        }else{
            return numero;
        }
    }

    function calcula(id)
    {
        //e.preventDefault();     // Evita que la página se recargue
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
        //alert(resultado);
        //var nombre = $("#asistencia-"+id).data("asistencia");
        // var asistencia = $("#asistencia-"+id).val();
        // var nombre = $("#asistencia-"+id).data("nombre");
        // alert(nombre);
        //alert(asistencia +" - "+ practicas +" - "+ puntos +" - "+ parcial +" - "+ final +" id: "+ id);
        $.ajax({
            type:'get',
            url:"{{ url('nota/actualizar') }}",
            data: {
                id : identificador,
                asistencia : asistencia,
                practicas : practicas,
                puntos : puntos,
                parcial : parcial,
                final : final,
                resultado : resultado
            }
        });
    }
</script>

@endsection
