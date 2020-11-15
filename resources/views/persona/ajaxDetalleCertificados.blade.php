<h1 class="text-center text-dark-info"><strong>Certificados</strong></h1>
<div class="table-responsive">
    <table class="table table-striped no-wrap text-center" id="tablaProductosEncontrados">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre Certificado</th>
                <th>Requisitos Cumplidos</th>
                <th>Emitido</th>
                <th>Fecha</th>
                <th class="text-nowrap"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($certificados as $key => $certificado)
                @php
                    $cumplio = 'Si';
                    $requisitos = App\RequisitosCertificado::where('certificado_id', $certificado->id)
                                                            ->get();
                    if(count($requisitos) == 0){
                        $cumplio = 'No';
                    }else{
                        foreach($requisitos as $requisito){
                            $comprueba = App\Inscripcione::where('asignatura_id', $requisito->asignatura_id)
                                                        ->where('persona_id', $persona->id)
                                                        ->where('aprobo', 'Si')
                                                        ->where('estado', 'Finalizado')
                                                        ->first();
                            if(!$comprueba){
                                $cumplio = 'No';
                                break;
                            }
                        }
                    }
                    $detalle = App\EstudiantesCertificado::where('certificado_id', $certificado->id)
                                                        ->where('persona_id', $persona->id)
                                                        ->first();
                @endphp
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>{{ $certificado->nombre }}</td>
                    <td>
                        @if($cumplio == 'Si')
                            <i class="fas fa-check text-success"></i>
                        @else
                            <i class="fas fa-times text-danger"></i>
                        @endif
                    </td>
                    <td>
                        @if($detalle)
                            Si
                        @else
                            No
                        @endif
                    </td>
                    <td>
                        @if($detalle)
                            {{ $detalle->fecha }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($cumplio == 'Si')
                            <button type="button" class="btn btn-success" title="Certificar"  onclick="emitir_certificado('{{ $persona->id }}', '{{ $certificado->id }}')"><i class="fas fa-certificate"></i></button>
                        @else
                            <button type="button" class="btn btn-success" title="Certificar" disabled><i class="fas fa-certificate"></i></button>
                        @endif
                        @if($detalle)
                            <button type="button" class="btn btn-danger" title="Eliminar Certificacion"  onclick="eliminar_certificado('{{ $persona->id }}', '{{ $detalle->id }}')"><i class="fas fa-trash-alt"></i></button>
                        @else
                            <button type="button" class="btn btn-danger" title="Eliminar Certificacion" disabled><i class="fas fa-trash-alt"></i></button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Funcion que se ejecuta al hacer clic en certificar del modulo Certificados
    function emitir_certificado(persona_id, certificado_id){
        window.location.href = "{{ url('Certificado/emitir_certificado') }}/"+persona_id+"/"+certificado_id;
        // persona_id = $('#persona_id').val();
        // $.ajax({
        //     url: "{{ url('Persona/ajaxDetalleExtras') }}",
        //     data: {
        //         persona_id : persona_id
        //         },
        //     type: 'get',
        //     success: function(data) {
        //         $("#detalleAcademicoAjax").show('slow');
        //         $("#detalleAcademicoAjax").html(data);
        //     }
        // });
    }

    // Funcion que se ejecuta al hacer clic en certificar del modulo Certificados
    function eliminar_certificado(persona_id, certificacion_id){
        Swal.fire({
            title: 'Quieres eliminar la certificación a este estudiante?',
            text: "",
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
                    'La certificacion fue eliminada',
                    'success'
                ).then(function() {
                    window.location.href = "{{ url('Certificado/eliminar_certificado') }}/"+persona_id+"/"+certificacion_id;
                });
            }
        })
        // persona_id = $('#persona_id').val();
        // $.ajax({
        //     url: "{{ url('Persona/ajaxDetalleExtras') }}",
        //     data: {
        //         persona_id : persona_id
        //         },
        //     type: 'get',
        //     success: function(data) {
        //         $("#detalleAcademicoAjax").show('slow');
        //         $("#detalleAcademicoAjax").html(data);
        //     }
        // });
    }
</script>