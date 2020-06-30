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
<!--alerts CSS -->
<!-- <link href="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet"> -->
@endsection

@section('content')

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            {{ $asignatura->asignatura->codigo_asignatura }}
            {{ $asignatura->asignatura->nombre_asignatura }}
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
                            <th>Segundo Turno</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notas as $nota)                                
                            <tr>
                                <td>
                                    {{ $nota->persona->nombres }} {{ $nota->persona->apellido_paterno }} {{ $nota->persona->apellido_materno }}
                                </td>
                                <td><input size="10" min="0" max="{{ $asignatura->nota_asistencia }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-asistencia="{{ $nota->nota_asistencia }}" type="number" id="asistencia-{{ $nota->id }}" name="asistencia-{{ $nota->id }}" value="{{ $nota->nota_asistencia }}" step="any"></td>
                                <td><input size="10" min="0" max="{{ $asignatura->nota_practicas }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-practicas="{{ $nota->nota_practicas }}" type="number" id="practicas-{{ $nota->id }}" name="practicas-{{ $nota->id }}" value="{{ $nota->nota_practicas }}" step="any"></td>
                                <td><input size="10" min="0" max="{{ $asignatura->nota_puntos_ganados }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-puntos="{{ $nota->nota_puntos_ganados }}" type="number" id="puntos-{{ $nota->id }}" name="puntos-{{ $nota->id }}" value="{{ $nota->nota_puntos_ganados }}" step="any"></td>
                                <td><input size="10" min="0" max="{{ $asignatura->nota_primer_parcial }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-parcial="{{ $nota->nota_primer_parcial }}" type="number" id="parcial-{{ $nota->id }}" name="parcial-{{ $nota->id }}" value="{{ $nota->nota_primer_parcial }}" step="any"></td>
                                <td><input size="10" min="0" max="{{ $asignatura->nota_examen_final }}" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-final="{{ $nota->nota_examen_final }}" type="number" id="final-{{ $nota->id }}" name="final-{{ $nota->id }}" value="{{ $nota->nota_examen_final }}" step="any"></td>
                                <td id="totalsuma{{ $nota->id }}">{{ $nota->nota_total }}</td>
                                <td>
                                    @if($nota->segundo_turno)
                                        {{ $nota->segundo_turno }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
            
    <form method="post" id="upload_form" enctype="multipart/form-data" class="upload_form float-left">
        @csrf
        <input type="file" name="select_file" id="select_file">
        <input type="submit" name="upload" id="upload" class="btn btn-rounded btn-success float-lg-right" value="Importar">
    </form>
    <a class="btn btn-rounded btn-success float-lg-left" href="{{ url('nota/exportarexcel/'.$asignatura->id) }}">Exportar</a> 
    <a class="btn btn-rounded btn-info float-lg-right" href="{{ url('nota/listado') }}">Volver</a> 
    <a class="btn btn-rounded btn-danger float-lg-right" href="{{ url('nota/segundoTurno/'.$asignatura->id) }}">Segundo Turno</a> 
    
</div>

@endsection


@section('js')
<!-- Sweet-Alert  -->
<!-- <script src="{{ asset('assets/plugins/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweet-alert.init.js') }}"></script> -->
<script>
// Script de importacion de excel
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
            type:'POST',
            url:"{{ url('nota/actualizar') }}",
            data: {
                id : identificador,
                asistencia : asistencia,
                practicas : practicas,
                puntos : puntos,
                parcial : parcial,
                final : final,
                resultado : resultado
            },
            success: function(data)
            {
                if(data.sw == 0){
                    Swal.fire(
                    'Oops...',
                    data.message,
                    'error'
                    )
                }
            }
        });
    }
</script>

@endsection
