@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<style>
    input { 
        text-align: center;
        width: 130px;
    }
</style>
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
                        <th>Segundo Turno</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscritos as $inscrito)
                        <tr>
                            <td>{{ $inscrito->persona->nombres }} {{ $inscrito->persona->apellido_paterno }} {{ $inscrito->persona->apellido_materno }}</td>
                            <td>{{ $inscrito->persona->carnet }}</td>
                            @php
                                $suma = 0;
                                $cantidad = 0;
                                $contador_registros = 0;
                                $segundo = 0;
                                $nota_segundo = 0;
                            @endphp
                            @foreach($notas as $nota)
                                @if($nota->persona_id == $inscrito->persona_id)
                                    @php
                                        $suma = $suma + $nota->nota_total;
                                        $cantidad = $cantidad + 1;
                                    @endphp
                                    <td>{{ round($nota->nota_total) }}</td>
                                    @php
                                        if($nota->registrado == 'Si')
                                        {
                                            $contador_registros = $contador_registros + 1;
                                        }
                                    @endphp
                                @endif
                            @endforeach
                            @if($cantidad == 0)
                                $cantidad=1
                            @endif
                            <td>{{ round($suma/$cantidad) }}</td>
                            @foreach($notas as $nota)
                                @if($nota->persona_id == $inscrito->persona_id)
                                    @php
                                        $nota_segundo = $nota_segundo + $nota->segundo_turno;
                                    @endphp
                                @endif
                            @endforeach
                            <td>{{ $nota_segundo/4 }}</td>
                            <td>
                                <button onclick="registra_notas('{{ $inscrito->id }}', '{{ $inscrito->asignatura_id }}', '{{ $inscrito->turno_id }}', '{{ $inscrito->persona_id }}', '{{ $inscrito->paralelo }}', '{{ $inscrito->anio_vigente }}')" class="btn btn-info" title="Registrar notas"><i class="fas fa-plus"></i></button>
                                @php
                                    $pago_segundo_turno = App\CobrosTemporada::where('persona_id', $inscrito->persona_id)
                                                                ->where('carrera_id', $inscrito->carrera_id)
                                                                ->where('asignatura_id', $inscrito->asignatura_id)
                                                                ->where('servicio_id', 8)
                                                                ->first();
                                @endphp
                                @if($inscrito->nota < 61 && $contador_registros == 4)
                                    @if($pago_segundo_turno)
                                        <button onclick="segundo_turno('{{ $inscrito->id }}')" class="btn btn-danger" title="Segundo turno"><i class="fas fa-chart-line"></i></button>
                                    @else
                                        <button class="btn btn-danger" title="Segundo turno" disabled><i class="fas fa-chart-line"></i></button>
                                    @endif
                                    
                                @endif
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-lg-8">
            <form method="post" id="upload_form" enctype="multipart/form-data" class="upload_form mt-4">
                @csrf
                <input type="hidden" name="asignatura_id" id="asignatura_id" value="{{ $asignatura->asignatura_id }}">
                <input type="hidden" name="turno_id" id="turno_id" value="{{ $asignatura->turno_id }}">
                <input type="hidden" name="paralelo" id="paralelo" value="{{ $asignatura->paralelo }}">
                <input type="hidden" name="anio_vigente" id="anio_vigente" value="{{ $asignatura->anio_vigente }}">
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="select_file" id="select_file">
                        <label class="custom-file-label" for="inputGroupFile04">Elegir archivo</label>
                    </div>
                    <div class="input-group-append">
                        <input type="submit" name="upload" id="upload" class="btn btn-success" value="Importar" style="width: 200px;">
                        <a class="btn btn-block btn-success" href="{{ url('nota/exportarexcel/'.$asignatura->id) }}" style="width: 200px;">Exportar Formato</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Inicio modal notas estudiante -->
<div id="modal_notas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="muestraNotaAjax">
        
    </div>
</div>
<!-- Fin modal notas estudiante -->

<!-- inicio modal nuevo servicio -->
<div id="segundo_turno" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">SEGUNDO TURNO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{ url('Nota/segundoTurno') }}"  method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="inscripcion_id" id="inscripcion_id" value="">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Nota</label>
                                <span class="text-danger">
                                    <i class="mr-2 mdi mdi-alert-circle"></i>
                                </span>
                                <input name="nota_segundo_turno" type="number" id="nota_segundo_turno" pattern="^[0-9]+" min="0" class="form-control" value="0" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn waves-effect waves-light btn-block btn-success" onclick="enviar_nota()">REGISTRAR</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- fin modal nuevo servicio -->


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
                        location.reload();          //Aqui editar
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

    function segundo_turno(inscripcion_id)
    {
        //$("#nota_segundo_turno").val(0);
        $("#inscripcion_id").val(inscripcion_id);
        $("#segundo_turno").modal('show');
    }

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
