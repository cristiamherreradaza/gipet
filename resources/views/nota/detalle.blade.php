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
        <h3 class="card-title text-primary"><strong>{{ $asignatura->asignatura->sigla }} {{ $asignatura->asignatura->nombre }}</strong></h3>
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
                        <th>
                            1er Bim
                        </th>
                        <th>
                            2do Bim
                        </th>
                        <th>
                            3er Bim
                        </th>
                        <th>
                            4to Bim
                        </th>
                        <th>Promedio</th>
                        <th>Segundo Turno</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscritos as $inscrito)
                        <tr>
                            <td>{{ $inscrito->persona->nombres }} {{ $inscrito->persona->apellido_paterno }} {{ $inscrito->persona->apellido_materno }}</td>
                            <td>{{ $inscrito->persona->cedula }}</td>
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
                            <td>{{ round($inscrito->segundo_turno) }}</td>
                            <td>
                                @if($bimestre != 0)
                                    <button onclick="registra_notas('{{ $inscrito->id }}', '{{ $bimestre }}', '{{ $inscrito->asignatura_id }}', '{{ $inscrito->turno_id }}', '{{ $inscrito->persona_id }}', '{{ $inscrito->paralelo }}', '{{ $inscrito->anio_vigente }}')" class="btn btn-info" title="Registrar notas"><i class="fas fa-plus"></i></button>
                                @endif
                                @if($inscrito->nota < $inscrito->nota_aprobacion && $inscrito->nota >= 40 && $contador_registros == 4)
                                    <button onclick="segundo_turno('{{ $inscrito->id }}', '{{ $inscrito->segundo_turno }}')" class="btn btn-danger" title="Segundo turno"><i class="fas fa-chart-line"></i></button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <form method="post" id="upload_form" enctype="multipart/form-data" class="upload_form mt-4">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group row">
                        <label for="bimestre" class="col-sm-4 text-right control-label col-form-label">Bimestre Actual</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="bimestre" id="bimestre" value="{{ $bimestre != '0' ? $bimestre : 'Finalizado' }}" readonly>
                        </div>
                    </div>
                </div>
                @if($bimestre != 0)
                    <div class="col-md-8">
                        <input type="hidden" name="nota_propuesta" id="nota_propuesta" value="{{ $asignatura->id }}">
                        <input type="hidden" name="asignatura_id" id="asignatura_id" value="{{ $asignatura->asignatura_id }}">
                        <input type="hidden" name="turno_id" id="turno_id" value="{{ $asignatura->turno_id }}">
                        <input type="hidden" name="paralelo" id="paralelo" value="{{ $asignatura->paralelo }}">
                        <input type="hidden" name="anio_vigente" id="anio_vigente" value="{{ $asignatura->anio_vigente }}">
                        <div class="input-group">
                            <a class="btn btn-block btn-success" href="{{ url('nota/exportarexcel/'.$asignatura->id.'/'.$bimestre) }}" style="width: 200px;">Exportar Formato</a>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="select_file" id="select_file">
                                <label class="custom-file-label" for="inputGroupFile04">Elegir archivo</label>
                            </div>
                            <div class="input-group-append">
                                <input type="submit" name="upload" id="upload" class="btn btn-success" value="Importar" style="width: 200px;">
                                <button type="button" class="btn btn-block btn-danger" onclick="finalizarBimestre()" style="width: 200px;">Finalizar Bimestre</button>
                                <!-- <a class="btn btn-block btn-danger" href="{{ url('nota/finalizarBimestre/'.$asignatura->id.'/'.$bimestre) }}" style="width: 200px;"></a> -->
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </form>        
    </div>
</div>

<!-- Inicio modal registro de notas de estudiante -->
<div id="modal_notas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" id="muestraNotaAjax">
        
    </div>
</div>
<!-- Fin modal registro de notas de estudiante -->

<!-- inicio modal segundo turno -->
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
                                <input name="nota_segundo_turno" type="number" id="nota_segundo_turno" pattern="^[0-9]+" min="0" max="100" class="form-control" value="0" required>
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
<!-- fin modal segundo turno -->
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

    function segundo_turno(inscripcion_id, segundo_turno)
    {
        //$("#nota_segundo_turno").val(0);
        $("#inscripcion_id").val(inscripcion_id);
        $("#nota_segundo_turno").val(segundo_turno);
        $("#segundo_turno").modal('show');
    }

    function registra_notas(inscripcion_id, bimestre, asignatura_id, turno_id, persona_id, paralelo, anio_vigente)
    {           
        $.ajax({
            url: "{{ url('Nota/ajaxMuestraNota') }}",
            data: {
                bimestre: bimestre,
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

        var resultado = parseFloat(asistencia) + parseFloat(practicas) + parseFloat(parcial) + parseFloat(final);
        var necesario = 100 - resultado;
        if(necesario >= 10)
        {
            resultado = resultado + parseFloat(puntos);
        }
        else
        {
            if(necesario <= parseFloat(puntos))
            {
                resultado = resultado + necesario;
            }
            else
            {
                resultado = resultado + parseFloat(puntos);
            }
        }
        //var resultado = parseFloat(asistencia)+parseFloat(practicas)+parseFloat(puntos)+parseFloat(parcial)+parseFloat(final);
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

    function finalizarBimestre()
    {
        var bimestre = $("#bimestre").val();
        var nota_propuesta = $("#nota_propuesta").val();
        Swal.fire({
            title: 'Deseas finalizar las evaluaciones del bimestre ' + bimestre + '?',
            text: "No podras modificar mas las notas de este bimestre!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, estoy seguro!',
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    'Excelente!',
                    'Calificaciones finalizadas',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Nota/finalizarBimestre') }}/"+nota_propuesta+'/'+bimestre;
                });
            }
        })
    }
</script>

@endsection
