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
            margin: 5cm 1cm 2cm;
            font-size: 6pt;
            font-family: Arial, Helvetica, sans-serif;
        }

        header {
            position: fixed;
            top: 1cm;
            left: 1cm;
            right: 1cm;
            height: 4cm;
            background-color: #ffffff;
            color: black;
            text-align: center;
            line-height: 30px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 2cm;
            background-color: #fff;
            color: black;
            text-align: center;
            line-height: 35px;
        }

        .bordes {
            /* border: #24486C 1px solid; */
            border: 1px solid;
            border-collapse: collapse;
        }

        table {
            /* width: 100%; */
            background-color: #fff;
            /* border: 1px solid; */
            border-collapse: collapse;
        }

        table.iz td{
            text-align: left;
            border: 1px solid black;
            padding: 2px;
            /* text-align: center; */
            /* border-collapse: collapse; */
        }

        .celdas th {
            height: 10px;
            background-color: #E0E0E0;
            /* color: #fff; */
        }

        .celdas td {
            /* height: 12px; */
        }

        .celdas th,
        .celdas td {
            border: 1px solid black;
            padding: 2px;
            text-align: center;
        }

        .celdabg {
            /* background-color: #E1ECF4; */
            background-color: #ffffff;
        }
    </style>
</head>

<body>
    <header>
        holas
    </header>
    <main>
        <table>
            <tr>
                <td>
                    <table border="1">
                        <tr><td>GESTION: 2018</td></tr>
                        <tr><td>NIVEL: TECNICO SUPERIOR</td></tr>
                        <tr><td>CARRERA: CONTADURIA GENERAL</td></tr>
                        <tr><td>REGIMEN: ANUALIZADO</td></tr>
                        <tr><td>CURSO: PRIMER ANO MANANA "A"</td></tr>
                    </table>
                </td>
                <td>
                    <table border="1">
                        <tr>
                            <td>CEDULA</td>
                            <td>
                                <table border="1">
                                    <tr>
                                        @foreach ($materiasCarrera as $mc)
                                        <td>{{ $mc->sigla }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        @foreach ($materiasCarrera as $mc)
                                        <td>{{ $mc->nombre }}</td>
                                        @endforeach
                                    </tr>
                                
                                </table>
                            </td>
                            <td>OBSERVACIONES</td>
                        </tr>
                    </table>
                    
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1">
                        
                    </table>
                </td>
                <td>
                    <table border="1">
                        <tr>
                            <td></td>
                            @foreach ($materiasCarrera as $mc)
                                <td>{{ $mc->nombre }}</td>
                            @endforeach
                        </tr>
                        @foreach ($nominaEstudiantes as $k => $ne)
                        <tr>
                            <td>{{ $k++ }} - {{ $ne->id }} - {{ $ne->persona->apellido_paterno }}-{{ $ne->persona->apellido_materno }}-{{ $ne->persona->nombres }}</td>
                            @foreach ($materiasCarrera as $mc)
                                @php
                                    $nota = App\Inscripcione::where('persona_id', $ne->persona_id)
                                                        ->where('carrera_id', $carrera)
                                                        ->where('anio_vigente', $gestion)
                                                        ->where('asignatura_id', $mc->id)
                                                        ->first();
                                    // dd($nota);
                                @endphp
                                <td>
                                    @if ($nota)
                                        {{ $nota->nota }}
                                    @else
                                        0
                                    @endif
                                </td>
                            @endforeach

                        </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>

    </main>
</body>

</html>