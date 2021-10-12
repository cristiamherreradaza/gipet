<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 1cm 1cm 2cm;
            font-size: 6pt;
            font-family: Arial, Helvetica, sans-serif;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0cm;
            background-color: #ff0000;
            color: black;
            text-align: center;
            line-height: 5px;
        }

        /*body {
            margin: 3cm 2cm 2cm;
        }*/

        footer {
            position: fixed;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 1cm;
            background-color: #fff;
            color: black;
            text-align: center;
            line-height: 35px;
        }

        table.notas {
            /* width: 100%; */
            background-color: #fff;
            /* border: 1px solid; */
            border-collapse: collapse;
        }

        .notas th,
        .notas td {
            border: 1px solid #000000;
            padding: 2px;
            text-align: left;
        }
    </style>
</head>

<body>
    <header>

    </header>
    <main>
        {{-- <img src="{{ asset('assets/imagenes/cabecera_centralizador.png') }}" width="100%"> --}}
        <table width="100%">
            <tr>
                <td width="25%"><img src="{{ asset('assets/imagenes/portal_uno_R.png') }}" height="80"></td>
                <td width="50%" style="text-align: center;"><span style="font-size: 18pt;">CETRALIZADOR DE
                        CALIFICACIONES</span>
                </td>
                <td width="25%" style="text-align: right;"><span style="font-size: 8pt;"> FECHA:
                        {{ date('d/m/Y') }}</span></td>
            </tr>

            <tr>
                <td><span style="font-size: 7pt;"><b>CARRERA: </b> {{ $datosCarrera->nombre }}</span></td>
                <td style="text-align: center;">
                    <span style="font-size: 7pt;">
                        <b>CURSO: </b>{{ $curso }}&deg; A&ntilde;o
                        <b>TURNO: </b>{{ $datosTurno->descripcion }}
                        <b>PARALELO: </b>"{{ $paralelo }}" -
                        @if ($tipo == 'primero')
                        1&deg; Bim
                        @elseif ($tipo == 'segundo')
                        2&deg; Bim
                        @else
                        Anual
                        @endif
                    </span>
                </td>
                <td><span style="font-size: 7pt;"><b>GESTION: </b> {{ $gestion }}</span></td>
            </tr>
        </table>
        {{-- <table width="100%">
            <tr>
                <td width="25%"><img src="{{ asset('assets/imagenes/portal_uno_R.png') }}" height="80"></td>
        <td width="50%" style="text-align: center;"><span style="font-size: 18pt;">CETRALIZADOR DE CALIFICACIONES</span>
        </td>
        <td width="25%" style="text-align: right;"><span style="font-size: 8pt;"> FECHA: {{ date('d/m/Y') }}</span></td>
        </tr>

        <tr>
            <td><span style="font-size: 7pt;"><b>INSTITUCION: </b> INSTITUTO TECNICO "EF GIPET" SRL</span></td>
            <td style="text-align: center;"><span style="font-size: 7pt;"><b>RM: </b> 252/75 - 081/02 - 889/12 -
                    210/14</span></td>
            <td><span style="font-size: 7pt;"><b>CARACTER: </b> PRIVADO</span></td>
        </tr>
        </table> --}}

        <table class="notas">

            <tr>
                @if ($imp_nombre == 'Si')
                <td style="width: 180px;">
                    <b>NOMINA ESTUDIANTES</b>
                </td>
                @endif
                <td style="width: 20px;">CARNET</td>
                @foreach ($materiasCarrera as $mc)
                <td style="width: 62px; text-transform: uppercase;vertical-align: top;">
                    {{ $mc->sigla }}
                    <hr>
                    {{ $mc->nombre }}
                </td>
                @endforeach
                {{-- <td><b>OBSERVACIONES</b></td> --}}
            </tr>
            @foreach ($nominaEstudiantes as $k => $ne)
            <tr>
                @if ($imp_nombre == 'Si')
                <td style="width: 190px;">{{ $ne->persona->apellido_paterno }} {{ $ne->persona->apellido_materno }}
                    {{ $ne->persona->nombres }}</td>
                @endif
                <td>{{ $ne->persona->cedula }}</td>
                @foreach ($materiasCarrera as $mc)
                    @php
                        if($tipo == 'primero'){
                            $nota = App\Nota::where('persona_id', $ne->persona_id)
                            ->where('carrera_id', $carrera)
                            ->where('anio_vigente', $gestion)
                            ->where('paralelo', $paralelo)
                            ->where('asignatura_id', $mc->id)
                            ->where('trimestre', 1)
                            ->first();
                        }elseif ($tipo == 'segundo') {
                            $nota = App\Nota::where('persona_id', $ne->persona_id)
                            ->where('carrera_id', $carrera)
                            ->where('anio_vigente', $gestion)
                            ->where('paralelo', $paralelo)
                            ->where('asignatura_id', $mc->id)
                            ->where('trimestre', 2)
                            ->first();
                        }else{
                            $nota = App\Inscripcione::where('persona_id', $ne->persona_id)
                            ->where('carrera_id', $carrera)
                            ->where('anio_vigente', $gestion)
                            ->where('asignatura_id', $mc->id)
                            ->first();
                        }
                        $estado = App\CarrerasPersona::where('persona_id', $ne->persona_id)
                        ->where('carrera_id', $carrera)
                        ->where('anio_vigente', $gestion)
                        ->first();
                    @endphp
                    <td>
                        @if ($nota)
                            @if ($tipo == 'primero' || $tipo == 'segundo')
                                {{ intval($nota->nota_total) }}
                            @else
                                {{ intval($nota->nota) }}
                            @endif
                        @else
                        0
                        @endif
                    </td>
                @endforeach
                {{-- <td>{{ $estado->estado }}</td> --}}
            </tr>
            @endforeach
        </table>
    </main>
</body>

</html>