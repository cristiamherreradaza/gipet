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
        
        table.celdas {
            width: 100%;
            background-color: #fff;
            /* border: 1px solid; */
            border-collapse: collapse;
        }

        .celdas th {
            height: 10px;
            background-color: #E0E0E0;
            /* color: #fff; */
        }

        .celdas td {
            height: 12px;
        }
        
        .celdas th, .celdas td {
            border: 1px solid black;
            padding: 2px;
            text-align: center;
        }

        .celdabg {
            /* background-color: #E1ECF4; */
            background-color: #ffffff;
        }

    </style>
    <!-- <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet"> -->
</head>
<body>
    <header>
        <table style="width:100%">
            <tr>
                <td style="text-align:center; font-family: 'Times New Roman', Times, serif; font-size:20px; line-height:100%">
                    <strong>INSTITUTO TECNICO "EF - GIPET" S.R.L.</strong>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    <strong>LISTA ALUMNOS (CARRERA - CURSO - TURNO - PARALELO)</strong>
                </td>
            </tr>
            <tr>
                <td style="text-align:center; font-family: 'Times New Roman', Times, serif; font-size:15px; line-height:100%">
                    <strong>{{ $listado[0]->anio_vigente }}</strong>
                </td>
            </tr>
        </table> 
        <hr>
        <table style="width:100%">
            <tr>
                <td style="text-align:left; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    <strong>Carrera:</strong>
                </td>
                <td style="text-align:left; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    {{ $listado[0]->carrera->nombre }}
                </td>
                <td style="text-align:left; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    <strong>Paralelo:</strong>
                </td>
                <td style="text-align:left; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    PARALELO ({{ $listado[0]->paralelo }})
                </td>
            </tr>
        </table>
        <hr>
        <table style="width:100%">
            <tr>
                <td style="text-align:left; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    <strong>Curso:</strong>
                </td>
                <td style="text-align:left; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    {{ $listado[0]->gestion }}° A&ntilde;o
                </td>
                <td style="text-align:left; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    <strong>Turno:</strong>
                </td>
                <td style="text-align:left; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    {{ $listado[0]->turno->descripcion }}
                </td>
                <td style="text-align:left; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    <strong>Fecha:</strong>
                </td>
                <td style="text-align:left; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    {{ date('Y-m-d') }}
                </td>
            </tr>
        </table>
        <hr>
    </header>
    <main>
        <table cellpadding="1" class="celdas" style="font-family: 'Times New Roman', Times, serif; font-size:10px; text-align:center">
            <tr>
                <th>N°</th>
                <th>CARNET</th>
                <th>APELLIDO PATERNO</th>
                <th>APELLIDO MATERNO</th>
                <th>NOMBRES</th>
                <th>CELULAR</th>
                <th>ESTADO</th>
            </tr>
            @foreach($listado as $key => $registro)
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>{{ strtoupper($registro->persona->cedula) }}</td>
                    <td style="text-align:left;">{{ strtoupper($registro->persona->apellido_paterno) }}</td>
                    <td style="text-align:left;">{{ strtoupper($registro->persona->apellido_materno) }}</td>
                    <td style="text-align:left;">{{ strtoupper($registro->persona->nombres) }}</td>
                    <td>{{ strtoupper($registro->persona->numero_celular) }}</td>
                    <td>{{ strtoupper($registro->vigencia) }}</td>
                </tr>
            @endforeach
        </table>


        <!-- <p style="font: normal 12px/150% Times New Roman, Times, serif; text-align:left;">
            <strong>Lugar y fecha: </strong> La Paz - {{ date('Y-m-d') }}.
        </p>
        <br><br><br><br><br><br>
        <table style="width:100%;">
            <tr>
                <td style="text-align:center; font-family: 'Times New Roman', Times, serif; font-size:14px;">
                    <strong>Firma Autoridad Academica</strong>
                </td>
            </tr>
        </table>
        <br>
        <table style="width:100%;">
            <tr>
                <td style="width:30%;">
                    <table cellpadding="1" border="1px" style="width:100%; text-align:center; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                        <tr>
                            <td colspan="2">ESCALA DE VALORACION</td>
                        </tr>
                        <tr>
                            <td style="width:50%;">61 - 100</td>
                            <td style="width:50%;">APROBADO</td>
                        </tr>
                        <tr>
                            <td>0 - 60</td>
                            <td>REPROBADO</td>
                        </tr>
                        <tr>
                            <td>61</td>
                            <td>NOTA MINIMA</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align:center; font-family: 'Times New Roman', Times, serif; font-size:14px;">
                    Sello del Instituto
                </td>
                <td style="width:30%;">
                    <table cellpadding="1" border="1px" style="width:100%; text-align:center; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                        <tr>
                            <td style="width:50%;">Carga Horaria</td>
                            <td style="width:50%;">3620</td>
                        </tr>
                        <tr>
                            <td>Asignaturas Aprobadas</td>
                            <td>17 / 17</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Promedio de Calificaciones</td>
                            <td rowspan="2">75</td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid; border-collapse: collapse; width:100%; text-align:center; font-family: 'Times New Roman', Times, serif; font-size:12px; line-height:100%">
                    Cualquier raspadura o enmienda invalida el presente documento
                </td>
            </tr>
        </table> -->
    </main>
</body>
</html>