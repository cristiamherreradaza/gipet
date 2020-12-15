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

        .notas th, .notas td {
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
        <img src="{{ asset('assets/imagenes/cabecera_centralizador.png') }}" width="100%">
         <table class="notas">
            
            <tr>
                <td style="width: 180px;">
                    GESTION: {{ $gestion }}
                    <hr>
                    NIVEL: TECNICO SUPERIOR
                    <hr>
                    CARRERA: {{ $carrera }}
                    <hr>
                    REGIMEN: ANUALIZADO
                    <hr>
                    CURSO: PRIMER ANO MANANA "A
                    <hr>
                    <b>NOMINA ESTUDIANTES</b>
                </td>
                <td style="width: 20px;">CEDULA DE IDENTIDAD</td>
                @foreach ($materiasCarrera as $mc)
                    <td style="width: 62px; text-transform: uppercase;vertical-align: top;">
                        {{ $mc->sigla }}
                        <hr>
                        {{ $mc->nombre }}
                    </td>
                @endforeach
                <td><b>OBSERVACIONES</b></td>
            </tr>
            @foreach ($nominaEstudiantes as $k => $ne)
            <tr>
                {{-- <td colspan="2" style="width: 10px;"></td> --}}
                <td style="width: 230px;">{{ ++$k }}.- {{ $ne->persona->apellido_paterno }} {{ $ne->persona->apellido_materno }} {{ $ne->persona->nombres }}</td>
                <td>{{ $ne->persona->cedula }}</td>
                @foreach ($materiasCarrera as $mc)
                    @php
                        $nota = App\Inscripcione::where('persona_id', $ne->persona_id)
                                            ->where('carrera_id', $carrera)
                                            ->where('anio_vigente', $gestion)
                                            ->where('asignatura_id', $mc->id)
                                            ->first();

                        $estado = App\CarrerasPersona::where('persona_id', $ne->persona_id)
                                            ->where('carrera_id', $carrera)
                                            ->where('anio_vigente', $gestion)
                                            ->first();

                    @endphp
                    <td>
                        @if ($nota)
                            {{ $nota->nota }}
                        @else
                            0
                        @endif
                    </td>
                    @endforeach
                    <td>{{ $estado->estado }}</td>
            </tr>
            @endforeach
        </table>
    </main>
</body>

</html>