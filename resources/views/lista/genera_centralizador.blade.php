@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/select2/dist/css/select2.min.css') }}">
@endsection

@section('metadatos')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>INSTITUTO TECNICO "EF - GIPET" S.R.L.</h1>
        <h2>CENTRALIZADOR DE CALIFICACIONES (1º - BIMESTRE)
        CONTADURÍA GENERAL</h2>

        <table>
            <tr>
                <td>No.</td>
                <td>NOMBRES</td>
                <td>ASISTENCIA</td>
                <td>TRABAJOS PRACTICOS</td>
                <td>EXAMEN PARCIAL</td>
                <td>EXAMEN FINAL</td>
                <td>PUNTOS GANADOS</td>
                <td>BIM</td>
            </tr>
            @foreach ($alumnos as $a)
                <tr>
                    <td>No.</td>
                    <td>{{ $a->persona->apellido_paterno }} {{ $a->persona->apellido_materno }} {{ $a->persona->nombres }}</td>
                    <td>{{ $a->nota_asistencia }}</td>
                    <td>{{ $a->nota_practicas }}</td>
                    <td>{{ $a->nota_primer_parcial }}</td>
                    <td>{{ $a->nota_examen_final }}</td>
                    <td>{{ $a->nota_puntos_ganados }}</td>
                    <td>{{ $a->nota_total }}</td>
                </tr>    
            @endforeach

        </table>
    </div>
</div>



@stop
@section('js')


@endsection