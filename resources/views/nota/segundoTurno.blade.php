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
                            <th>Nota Acumulada</th>
                            <th>Habilitado</th>
                            <th>Nota Segundo Turno</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($segundoTurno as $nota)                                
                            <tr>
                                <td>
                                    {{ $nota->persona->nombres }} {{ $nota->persona->apellido_paterno }} {{ $nota->persona->apellido_materno }}
                                </td>
                                <td>{{ $nota->nota_asistencia + $nota->nota_practicas + $nota->nota_puntos_ganados + $nota->nota_primer_parcial + $nota->nota_examen_final }}</td>
                                <td>Si</td>
                                <td><input size="10" min="0" max="100" pattern="^[0-9]+" onchange="calcula( {{ $nota->id }} )" data-turno="{{ $nota->segundo_turno }}" type="number" id="turno-{{ $nota->id }}" name="turno-{{ $nota->id }}" value="{{ $nota->segundo_turno }}" step="any"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a class="btn btn-rounded btn-info float-lg-right" href="{{ url('nota/detalle/'.$asignatura->id) }}">Volver</a> 
</div>

@endsection


@section('js')
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
        var identificador = id;
        var segundo_turno = $("#turno-"+id).val();

        segundo_turno = checkCampos(segundo_turno);

        $.ajax({
            type:'get',
            url:"{{ url('nota/segundoTurnoActualizar') }}",
            data: {
                id : identificador,
                segundo_turno : segundo_turno
            }
        });
    }
</script>

@endsection
