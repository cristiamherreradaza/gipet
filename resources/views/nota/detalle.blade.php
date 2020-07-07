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

<div class="card">
    <div class="card-body">
        <h3 class="card-title text-primary"><strong>{{ $asignatura->asignatura->codigo_asignatura }} {{ $asignatura->asignatura->nombre_asignatura }}</strong></h3>
        <h6 class="card-subtitle text-dark">DOCENTE: {{ auth()->user()->nombres }} {{ auth()->user()->apellido_paterno }} {{ auth()->user()->apellido_materno }}</h6>
        <h6 class="card-subtitle text-dark">TURNO: {{ $asignatura->turno->descripcion }}</h6>
        <h6 class="card-subtitle text-dark">PARALELO: {{ $asignatura->paralelo }}</h6>
        <h6 class="card-subtitle">Año {{ date('Y') }}</h6>
        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped text-center">
                <thead class="text-primary">
                    <tr>
                        <th>Estudiante</th>
                        <th>CI</th>
                        <th>1er Bim</th>
                        <th>2do Bim</th>
                        <th>3er Bim</th>
                        <th>4to Bim</th>
                        <th>Promedio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscritos as $inscrito)
                        <tr>
                            <td>{{ $inscrito->persona->nombres }} {{ $inscrito->persona->apellido_paterno }} {{ $inscrito->persona->apellido_materno }}</td>
                            <td>{{ $inscrito->persona->carnet }}</td>
                            @php
                                $suma=0;
                                $cantidad=1;
                            @endphp
                            @foreach($notas as $key => $nota)
                                @if($nota->persona_id == $inscrito->persona_id)
                                    <td>{{ $nota->nota_total }}</td>
                                    @php
                                        $suma=$suma+$nota->nota_total;
                                        $cantidad=$key+1;
                                    @endphp
                                @endif
                            @endforeach
                            <td>{{ ($suma/$cantidad) }}</td>
                            <td><button onclick="registra_notas('{{ $inscrito->id }}', '{{ $inscrito->asignatura_id }}', '{{ $inscrito->turno_id }}', '{{ $inscrito->persona_id }}', '{{ $inscrito->paralelo }}', '{{ $inscrito->anio_vigente }}')" class="btn btn-info" title="Registrar notas"><i class="fas fa-plus"></i></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Inicio modal notas estudiante -->
<div id="modal_notas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="muestraNotaAjax">
        
    </div>
</div>
<!-- Fin modal notas estudiante -->


<div class="col-lg-12">
    <form method="post" id="upload_form" enctype="multipart/form-data" class="upload_form mt-4">
        @csrf
        <div class="input-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="select_file" id="select_file">
                <label class="custom-file-label" for="inputGroupFile04">Elegir archivo</label>
            </div>
            <div class="input-group-append">
                <input type="submit" name="upload" id="upload" class="btn btn-success" value="Importar" style="width: 200px;">
                <a class="btn btn-block btn-success" href="{{ url('nota/exportarexcel/'.$asignatura->id) }}" style="width: 200px;">Exportar</a>
            </div>
        </div>
    </form>
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

    function registra_notas(inscripcion_id, asignatura_id, turno_id, persona_id, paralelo, anio_vigente)
    {           
        $.ajax({
            url: "{{ url('Nota/ajaxMuestraNota') }}",
            data: {
                asignatura_id: asignatura_id,
                turno_id: turno_id,
                persona_id: persona_id,
                paralelo: paralelo,
                anio_vigente: anio_vigente
                },
            type: 'get',
            success: function(data) {
                $("#muestraNotaAjax").html(data);
                $("#modal_notas").modal('show');
            }
        }); 
        
    }

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
