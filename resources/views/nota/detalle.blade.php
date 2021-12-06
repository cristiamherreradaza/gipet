@extends('layouts.app')

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}"/>
@endsection

@section('css')
<link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
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
        <div class="row">
            <div class="col-md-6">
                <h3 class="card-title font-weight-bold">
                    MATERIA:
                    <span class="text-info" style="text-transform: uppercase;">{{ $asignatura->asignatura->nombre }}</span>
                    ({{ $asignatura->asignatura->sigla }})
                </h3>
            </div>
            <div class="col-md-6">
                <h3 class="card-title font-weight-bold">
                    BIMESTRE:
                    @if ($bimestreActual == 1)
                        <span class="text-info">PRIMERO</span>
                    @else
                        <span class="text-info">SEGUNDO</span>
                    @endif
                </h3>
            </div>
        </div>
        

        <div class="row">
            <div class="col-md-3"><h4 class="text-bold">TURNO: <span class="text-info">{{ $asignatura->turno->descripcion }}</span></h4></div>
            <div class="col-md-3"><h4 class="text-bold">PARALELO: <span class="text-info">{{ $asignatura->paralelo }}</span></h4></div>
            <div class="col-md-3"><h4 class="text-bold">CURSO: <span class="text-info">{{ $datosMateria->gestion }} &deg; A&ntilde;o</span></h4></div>
            <div class="col-md-3"><h4 class="text-bold">GESTION: <span class="text-info">{{ $asignatura->anio_vigente }}</span></h4></div>
        </div>
        <form action="{{ url('nota/cambiaTurnoParalelo') }}" method="POST" id="frmNotas">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="hidden" name="asignatura_id" value="{{ $asignatura->asignatura->id }}">
                        <input type="hidden" name="anio" value="{{ $asignatura->anio_vigente }}">
                        <input type="hidden" name="bimestre" value="{{ $bimestreActual }}">
                        <select name="turno_id" id="turno_id" class="form-control" onchange="ajaxBuscaParalelo()" required>
                            <option value="">Seleccione Turno</option>
                            @foreach($comboTurnos as $ct)
                            <option value="{{ $ct->turno_id }}" 
                                    data-asignatura="{{ $ct->asignatura_id }}"
                                    data-docente="{{ $ct->user_id }}"
                                    data-anio="{{ $ct->anio_vigente }}"
                                    >{{ $ct->turno->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4" id="ajaxMuestraComboParalelo">
                    <select name="paralelo" id="paralelo" class="form-control" required>
                        <option value="">Seleccione Paralelo</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-block btn-info" onclick="enviaDatosCambiaCurso()">Cambia Curso</button>
                </div>
                
            </div>
        </form>
            
        {{-- <h6 class="card-subtitle text-dark">DOCENTE: {{ auth()->user()->nombres }} {{ auth()->user()->apellido_paterno }} {{ auth()->user()->apellido_materno }}</h6> --}}
        
        
        <div class="table-responsive m-t-40">
            <table id="tablaAlumnos" class="table table-bordered table-striped text-center">
                <thead class="text-info">
                    <tr>
                        <th>Apellido Paterno </th>
                        <th>Apellido Materno</th>
                        <th>Nombres</th>
                        <th>CI</th>
                        <th>Asistencia</th>
                        <th>Practicas</th>
                        <th>Parcial</th>
                        <th>Examen</th>
                        <th>Extras</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @dd($inscritos) --}}
                    @foreach($inscritos as $contador => $inscrito)
                        @if ($inscrito->persona)
                            @php
                                $nota = App\Nota::where('inscripcion_id', $inscrito->id)
                                                ->where('trimestre', $bimestreActual)
                                                ->first();

                                if($nota->finalizado != null){
                                    $estado = 'readonly';
                                }else{
                                    $estado = '';
                                }

                                $sw = true;
                                $estado_alumno = App\CarrerasPersona::where('carrera_id', $inscrito->carrera_id)
                                        ->where('persona_id', $inscrito->persona_id)
                                        ->where('anio_vigente', $inscrito->anio_vigente)
                                        ->first();
                                if( $estado_alumno->estado == 'ABANDONO' || $estado_alumno->estado == 'ABANDONO TEMPORAL' || $estado_alumno->estado == 'CONGELADO'){
                                    $sw = false;
                                }
                                // dd($estado_alumno);
                            @endphp 
                            @if ($sw)
                                <tr>
                                    <td class="text-left">{{ $inscrito->persona->apellido_paterno }}</td>
                                    <td class="text-left">{{ $inscrito->persona->apellido_materno }}</td>
                                    <td class="text-left">{{ $inscrito->persona->nombres }}</td>
                                    <td class="text-left">{{ $inscrito->persona->cedula }}</td>

                                    <td>
                                        <input type="number" name="asistencia_{{ $inscrito->id }}" id="asistencia_{{ $inscrito->id }}" class="form-control" style="width: 100px;" value="{{ round($nota->nota_asistencia, 0) }}" onchange="ajaxRegistraNotaAsistencia('{{ $inscrito->id }}', '{{ $bimestreActual }}', 'asistencia')" {{ $estado }} />
                                        <small id="msgAsistencia_{{ $inscrito->id }}" class="form-control-feedback text-success" style="display: none;">Guardado</small>
                                        <small class="form-control-feedback text-warning msgAlumno_{{ $inscrito->id }}" style="display: none;">Alerta</small>
                                    </td>
                                    <td>
                                        <input type="number" name="practicas_{{ $inscrito->id }}" id="practicas_{{ $inscrito->id }}" class="form-control" style="width: 100px;" value="{{ round($nota->nota_practicas, 0) }}" onchange="ajaxRegistraNotaPractica('{{ $inscrito->id }}', '{{ $bimestreActual }}', 'practica')" {{ $estado }} />
                                        <small id="msgPractica_{{ $inscrito->id }}" class="form-control-feedback text-success" style="display: none;">Guardado</small>
                                        <small class="form-control-feedback text-warning msgAlumno_{{ $inscrito->id }}" style="display: none;">Alerta</small>
                                    </td>
                                    <td>
                                        <input type="number" name="parcial_{{ $inscrito->id }}" id="parcial_{{ $inscrito->id }}" class="form-control" style="width: 100px;" value="{{ round($nota->nota_primer_parcial, 0) }}" onchange="ajaxRegistraNotaParcial('{{ $inscrito->id }}', '{{ $bimestreActual }}', 'parcial')" {{ $estado }} />
                                        <small id="msgParcial_{{ $inscrito->id }}" class="form-control-feedback text-success" style="display: none;">Guardado</small>
                                        <small class="form-control-feedback text-warning msgAlumno_{{ $inscrito->id }}" style="display: none;">Alerta</small>
                                    </td>
                                    <td>
                                        <input type="number" name="examen_{{ $inscrito->id }}" id="examen_{{ $inscrito->id }}" class="form-control" style="width: 100px;" value="{{ round($nota->nota_examen_final, 0) }}" onchange="ajaxRegistraNotaExamen('{{ $inscrito->id }}', '{{ $bimestreActual }}', 'examen')" {{ $estado }} />
                                        <small id="msgExamen_{{ $inscrito->id }}" class="form-control-feedback text-success" style="display: none;">Guardado</small>
                                        <small class="form-control-feedback text-warning msgAlumno_{{ $inscrito->id }}" style="display: none;">Alerta</small>
                                    </td>
                                    <td>
                                        <input type="number" name="extras_{{ $inscrito->id }}" id="extras_{{ $inscrito->id }}" class="form-control" style="width: 100px;" value="{{ round($nota->nota_puntos_ganados, 0) }}" onchange="ajaxRegistraNotaExtras('{{ $inscrito->id }}', '{{ $bimestreActual }}', 'extras')" {{ $estado }} />
                                        <small id="msgExtras_{{ $inscrito->id }}" class="form-control-feedback text-success" style="display: none;">Guardado</small>
                                        <small class="form-control-feedback text-warning msgAlumno_{{ $inscrito->id }}" style="display: none;">Alerta</small>
                                    </td>

                                    <td>
                                        <input type="text" id="total_{{ $inscrito->id }}" class="form-control" style="width: 80px;" value="{{ round($nota->nota_total, 0) }}" onfocus="ajaxRegistraTotal('{{ $inscrito->id }}', '1', 'total')" readonly>
                                    </td>
                                </tr>
                            @endif
                        @endif
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
                            <input type="text" class="form-control" name="bimestre" id="bimestre" value="{{ $bimestreActual }}" readonly>
                        </div>
                    </div>
                </div>
                @php
                    $nota = App\Nota::where('inscripcion_id', $inscritos[0]->id)
                                    ->where('trimestre', $bimestreActual)
                                    ->first();
                @endphp 
                <div class="col-md-8">
                    <input type="hidden" name="nota_propuesta" id="nota_propuesta" value="{{ $asignatura->id }}">
                    <input type="hidden" name="asignatura_id" id="asignatura_id" value="{{ $asignatura->asignatura_id }}">
                    <input type="hidden" name="turno_id" id="turno_id" value="{{ $asignatura->turno_id }}">
                    <input type="hidden" name="paralelo" id="paralelo" value="{{ $asignatura->paralelo }}">
                    <input type="hidden" name="anio_vigente" id="anio_vigente" value="{{ $asignatura->anio_vigente }}">
                    <input type="hidden" name="docente_id" id="docente_id" value="{{ auth()->user()->id }}">
                    <div class="input-group">
                        <a class="btn btn-block btn-success" href="{{ url('nota/exportarexcel/'.$asignatura->id.'/'.$bimestreActual) }}" style="width: 200px;">Exportar Formato</a>
                        @if ($nota->finalizado == null)
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="select_file" id="select_file" required>
                                <label class="custom-file-label" for="inputGroupFile04">Elegir archivo para subir notas</label>
                            </div>
                            <div class="input-group-append">
                                <input type="button" name="upload" id="upload" class="btn btn-success" value="Importar" style="width: 200px;" onclick="enviaExcel();">

                                <button class="btn btn-primary" type="button" disabled="" id="cargando" style="display: none;">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Trabajando...
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

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
<script src="{{ asset('assets/libs/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/datatable/custom-datatable.js') }}"></script>
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

    $(document).ready(function() {
        $('#tablaAlumnos').DataTable( {
            "order": [[ 0, "asc" ]],
            language: {
                url: '{{ asset('datatableEs.json') }}'
            },
        });
    });

    function enviaExcel()
    {
        if($("#upload_form")[0].checkValidity()){
            $("#upload_form").submit();
            $("#upload").hide();
            $("#cargando").show();
        }else{
            $("#upload_form")[0].reportValidity()
        }
    }

    function enviaDatosCambiaCurso()
    {
        if($("#frmNotas")[0].checkValidity()){
            $("#frmNotas").submit();
        }else{
            $("#frmNotas")[0].reportValidity();
        }

    }

    function ajaxRegistraNotaExtras(id, numero, tipo)
    {
        let nota = $("#extras_"+id).val();

        sumaNotas(id, numero, 'total');

        $.ajax({
            url: "{{ url('Nota/ajaxRegistraNota') }}",
            data: {
                nota: nota,
                id: id,
                numero: numero,
                tipo: tipo,
            },
            type: 'POST',
            success: function(data) {
                $("#msgExtras_"+id).show();
            }
        }); 
    }

    function ajaxRegistraNotaExamen(id, numero, tipo)
    {
        let nota = $("#examen_"+id).val();
        sumaNotas(id, numero, 'total');

        $.ajax({
            url: "{{ url('Nota/ajaxRegistraNota') }}",
            data: {
                nota: nota,
                id: id,
                numero: numero,
                tipo: tipo,
            },
            type: 'POST',
            success: function(data) {
                $("#msgExamen_"+id).show();
            }
        }); 
    }

    function ajaxRegistraNotaParcial(id, numero, tipo)
    {
        let nota = $("#parcial_"+id).val();
        sumaNotas(id, numero, 'total');

        $.ajax({
            url: "{{ url('Nota/ajaxRegistraNota') }}",
            data: {
                nota: nota,
                id: id,
                numero: numero,
                tipo: tipo,
            },
            type: 'POST',
            success: function(data) {
                $("#msgParcial_"+id).show();
            }
        }); 
    }

    function ajaxRegistraNotaAsistencia(id, numero, tipo, contador)
    {
        let nota = $("#asistencia_"+id).val();
        sumaNotas(id, numero, 'total');

        $.ajax({
            url: "{{ url('Nota/ajaxRegistraNota') }}",
            data: {
                nota: nota,
                id: id,
                numero: numero,
                tipo: tipo,
            },
            type: 'POST',
            success: function(data) {
                $("#msgAsistencia_"+id).show();
            }
        }); 
    }

    function ajaxRegistraNotaPractica(id, numero, tipo)
    {
        let nota = $("#practicas_"+id).val();
        sumaNotas(id, numero, 'total');

        $.ajax({
            url: "{{ url('Nota/ajaxRegistraNota') }}",
            data: {
                nota: nota,
                id: id,
                numero: numero,
                tipo: tipo,
            },
            type: 'POST',
            success: function(data) {
                $("#msgPractica_"+id).show();
            }
        }); 
    }

    function sumaNotas(id, numero, tipo)
    {
        let asistencia = $("#asistencia_"+id).val();
        let practicas  = $("#practicas_"+id).val();
        let parcial    = $("#parcial_"+id).val();
        let examen     = $("#examen_"+id).val();
        let extras     = $("#extras_"+id).val();

        suma = Number(asistencia) + Number(practicas) + Number(parcial) + Number(examen) + Number(extras);

        if(suma > 100)
        {
            alert('El promedio total sobrepasa los 100 puntos');
            $(".msgAlumno_"+id).show();
        }else{

            $(".msgAlumno_"+id).hide();

            $("#total_"+id).val(suma);

            $.ajax({
                url: "{{ url('Nota/ajaxRegistraNota') }}",
                data: {
                    nota: suma,
                    id: id,
                    numero: numero,
                    tipo: tipo,
                },
                type: 'POST',
                success: function(data) {
                }
            }); 

        }

    }

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

    function ajaxBuscaParalelo()
    {
        let turno = $("#turno_id").val();
        let asignatura = $("#turno_id").find(':selected').data("asignatura");
        let docente = $("#turno_id").find(':selected').data("docente");
        let anio = $("#turno_id").find(':selected').data("anio");

        $.ajax({
            url: "{{ url('nota/ajaxBuscaParalelo') }}",
            data: {
                turno: turno,
                asignatura: asignatura,
                docente: docente,
                anio: anio,
                },
            type: 'post',
            success: function(data) {
                $("#ajaxMuestraComboParalelo").html(data);
            }
        });
        // alert(anio);   
    }

    function generaCentralizadorAsistencia()
    {
        let turno      = $("#turno_id").val();
        let paralelo   = $("#paralelo").val();
        let asignatura = $("#asignatura_id").val();
        let anio       = $("#anio_vigente").val();
        let docente    = $("#docente_id").val();

        $.ajax({
            url: "{{ url('Lista/genera_centralizador_asistencia') }}",
            data: {
                turno: turno,
                paralelo: paralelo,
                asignatura: asignatura,
                anio: anio,
                docente: docente,
                },
            type: 'post',
            success: function(data) {
                // $("#msgAsistencia_"+).show();
            }
        });

    }
</script>

@endsection
