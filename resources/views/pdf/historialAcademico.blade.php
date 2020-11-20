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
            margin: 2cm 1cm 5cm;
        }
 
        header {
            position: fixed;
            top: 1cm;
            left: 2cm;
            right: 2cm;
            height: 1cm;
            background-color: #ffffff;
            color: black;
            text-align: center;
            line-height: 30px;
        }
 
        footer {
            position: fixed;
            bottom: 1cm;
            left: 1cm;
            right: 1cm;
            height: 5cm;
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
                <td style="width:65%; text-align:center;">
                    <p style="font-family: 'Times New Roman', Times, serif; font-size:20px; line-height:1%">
                        <strong>HISTORIAL ACAD&Eacute;MICO</strong>
                    </p>
                </td>
            </tr>
        </table> 
    </header>
    <main>
        <table style="width:100%; font-family: 'Times New Roman', Times, serif; font-size:12px;">
            <tr>
                <td><strong>INSTITUTO:</strong></td>
                <td>INSTITUTO TÉCNICO EF-GIPET S.R.L.</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td><strong>CARRERA:</strong></td>
                <td>{{ strtoupper($carrera->nombre) }}</td>
                <td><strong>FECHA DE ADMISION:</strong></td>
                <td>20/02/2017</td>
            </tr>
            <tr>
                <td><strong>NIVEL DE FORMACION:</strong></td>
                <td>{{ strtoupper($carrera->nivel) }}</td>
                <td><strong>FECHA DE CONCLUSION:</strong></td>
                <td>{{ date('Y') }}/{{ date('m') }}/{{ date('d') }}</td>
            </tr>
            <tr>
                <td><strong>REGIMEN:</strong></td>
                <td>ANUAL</td>
                <td><strong>MATRICULA</strong></td>
                <td></td>
            </tr>
            <tr>
                <td><strong>ESTUDIANTE:</strong></td>
                <td>{{ strtoupper($persona->apellido_paterno) }} {{ strtoupper($persona->apellido_materno) }} {{ strtoupper($persona->nombres) }}</td>
                <td><strong>CEDULA DE IDENTIDAD:</strong></td>
                <td>{{ strtoupper($persona->cedula) }}</td>
            </tr>
        </table>
        <br>
        <hr>
        <table cellpadding="1" class="celdas" style="font-family: 'Times New Roman', Times, serif; font-size:10px; text-align:center">
            <tr>
                <th>N°</th>
                <th>GESTION ACADEMICA</th>
                <th>SEMESTRE / A&Ntilde;O</th>
                <th>CODIGO</th>
                <th>ASIGNATURA</th>
                <th>REQUISITOS</th>
                <th>NOTA</th>
                <th>PRUEBA RECUP</th>
                <th>OBSERVACIONES</th>
                <!-- <th>N° DE LIBRO</th>
                <th>N° DE FOLIO</th> -->
            </tr>
            @foreach($inscripciones as $key => $inscripcion)
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>{{ $inscripcion->anio_vigente }}</td>
                    <td>
                        @switch($inscripcion->gestion)
                            @case(1)
                                PRIMERO
                                @break
                            @case(2)
                                SEGUNDO
                                @break
                            @case(3)
                                TERCERO
                                @break
                            @case(4)
                                CUARTO
                                @break
                            @case(5)
                                QUINTO
                                @break
                        @endswitch
                    </td>
                    <td nowrap>{{ $inscripcion->asignatura->sigla }}</td>
                    <td style="text-align:left" nowrap>{{ $inscripcion->asignatura->nombre }}</td>
                    <td>
                        @php
                            $prerequisito = App\Prerequisito::where('asignatura_id', $inscripcion->asignatura_id)
                                                            ->first();
                        @endphp
                        @if($prerequisito->prerequisito_id)
                            {{ $prerequisito->prerequisito->sigla }}
                        @else
                            NINGUNO
                        @endif
                    </td>
                    <td>{{ $inscripcion->nota ? round($inscripcion->nota) : '0' }}</td>
                    <td>{{ $inscripcion->segundo_turno ? round($inscripcion->segundo_turno) : '' }}</td>
                    <td>{{ $inscripcion->aprobo ? 'APROBADO' : 'REPROBADO' }}</td>
                    <!-- <td></td>
                    <td></td> -->
                </tr>
            @endforeach
        </table>

        <p style="font: normal 12px/150% Times New Roman, Times, serif; text-align:left;">
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
        </table>

    </main>

    <!-- <footer>
        <table style="width:100%;">
            <tr>
                <td style="text-align:center; font-family: 'Times New Roman', Times, serif; font-size:14px;">
                    <strong>Firma Autoridad Academica</strong>
                </td>
            </tr>
        </table>
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
        </table>
    </footer> -->

</body>
</html>