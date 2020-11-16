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
            margin: 4cm 2cm 2cm;
        }
 
        header {
            position: fixed;
            top: 0cm;
            left: 2cm;
            right: 2cm;
            height: 4cm;
            background-color: #ffffff;
            color: black;
            text-align: center;
            line-height: 30px;
        }
 
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #ffffff;
            color: black;
            text-align: center;
            line-height: 35px;
        }

        .bordes {
            border: #24486C 1px solid;
            border-collapse: collapse;
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
        <br>
        <table style="width:100%">
            <tr>
                <!-- <td style="width:35%; text-align:right; background-color: #ffe100;"> -->
                <td style="width:35%; text-align:center;">
                    <img style="height:90px; width:100%" src="../public/assets/imagenes/portal_uno_R.png">
                </td>
                <td  style="width:65%; text-align:center;">
                    <p style="font-family: 'Times New Roman', Times, serif; font-size:20px; line-height:1%">
                        INSTITUTO TECNICO "EF-GIPET" S.R.L.
                    </p>
                    <p style="font-family: 'Times New Roman', Times, serif; font-size:9px; line-height:1%">
                        R.M. N° 889/2012 | R.M. N° 210/2014 | R.A. Nº 039/2018 | R.M. N° 0268/2019 | R.A Nº 379/2019
                    </p>
                </td>
            </tr>
        </table> 
    </header>

    <main>
        <p style="font-family: 'Times New Roman', Times, serif; font-size:20px; line-height:1%; text-align:center;">
            BOLETIN DE CALIFICACIONES
        </p>
        <table class="bordess" style="width:100%; font-family: 'Times New Roman', Times, serif; font-size:14px; text-align:center">
            <tr style="border: 1px solid black; border-collapse: collapse">
                <td style="width:50%;"><u>{{ $persona->apellido_paterno }}</u></td>
                <td style="width:50%;"><u>{{ $persona->apellido_materno }}</u></td>
                <td style="width:50%;"><u>{{ $persona->nombres }}</u></td>
                <td style="width:50%;"><u>{{ $persona->cedula }}</u></td>
            </tr>
            <tr style="border: 1px solid black; border-collapse: collapse">
                <td class="celdabg" style="width:50%;"><strong>Apellido Paterno</strong></td>
                <td class="celdabg" style="width:50%;"><strong>Apellido Materno</strong></td>
                <td class="celdabg" style="width:50%;"><strong>Nombres</strong></td>
                <td class="celdabg" style="width:50%;"><strong>N° Carnet</strong></td>
            </tr>
        </table>
        <br>
        <table class="bordess" style="width:100%; font-family: 'Times New Roman', Times, serif; font-size:14px; text-align:center">
            <tr style="border: 1px solid black; border-collapse: collapse">
                <td class="celdabg" style="width:50%;"><strong>Carrera: </strong></td>
                <td style="width:50%;" nowrap>{{ $carrera->nombre }}</td>
                <td class="celdabg" style="width:50%;"><strong>Nivel: </strong></td>
                <td style="width:50%;" nowrap>{{ $carrera->nivel }}</td>
                <td class="celdabg" style="width:50%;"><strong>Curso: </strong></td>
                <td style="width:50%;" nowrap>1° A&ntilde;o</td>
            </tr>
        </table>
        <br>
        <table class="bordess" style="width:100%; font-family: 'Times New Roman', Times, serif; font-size:14px; text-align:center">
            <tr style="border: 1px solid black; border-collapse: collapse">
                <td class="celdabg" style="width:50%;">En la gestión academica {{ date('Y') }} ha obtenido las siguientes calificaciones:</td>
            </tr>
        </table>
        <br>

        <p style="font-family: 'Times New Roman', Times, serif; font-size:16px; line-height:1%; text-align:center;">
            CALIFICACION ANUALIZADA
        </p>
        <table cellpadding="5" class="bordes" style="width:100%; font-family: 'Times New Roman', Times, serif; font-size:10px; text-align:center">
            <tr style="border: 1px solid black; border-collapse: collapse; background-color: #e5e5e5;">
                <th nowrap>CODIGO</th>
                <th nowrap>ASIGNATURA</th>
                <th nowrap>1° B</th>
                <th nowrap>2° B</th>
                <th nowrap>PROM</th>
                <th nowrap>3° B</th>
                <th nowrap>4° B</th>
                <th nowrap>PROM</th>
                <th nowrap>HAB</th>
                <th nowrap>FINAL</th>
            </tr>
            @foreach($inscripciones as $inscripcion)
                <tr>
                    <td nowrap>{{ $inscripcion->asignatura->sigla }}</td>
                    <td style="text-align:left" nowrap>{{ $inscripcion->asignatura->nombre }}</td>
                    <td></td>
                    <td></td>
                    <td style="background-color: #e5e5e5;">0</td>
                    <td></td>
                    <td></td>
                    <td style="background-color: #e5e5e5;">0</td>
                    <td></td>
                    <td style="background-color: #e5e5e5;">{{ $inscripcion->nota ? round($inscripcion->nota) : '0' }}</td>
                </tr>
            @endforeach
        </table>

        <p style="font: normal 10px/150% Times New Roman, Times, serif; text-align:left;">
        EQUIVALENCIAS: 1 - 60 "INSUFICIENTE"; 61 - 70 "SUFICIENTE"; 71 - 90 "BUENO"; 91 - 100 "EXCELENTE"
        <br>
        POR LO TANTO: De acuerdo al plan de estudios: 
        <u>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </u>
        en proceso de calificacion.
        <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Lugar y fecha: La Paz - {{ date('Y-m-d') }}.
        </p>
        
        <br><br><br><br>


        <table style="width:100%; font-family: 'Times New Roman', Times, serif; font-size:14px; text-align:center">
            <tr>
                <td>
                    <img style="height:150px; width:250px" src="../public/assets/imagenes/firmara.png">
                </td>
                <td>
                    <img style="height:150px; width:250px" src="../public/assets/imagenes/firmajm.png">
                </td>
            </tr>
            <tr>
                <td colspan="2">ALUMNO(A)</td>
            </tr>
        </table>

    </main>

    <!-- <footer>        
        <p style="font: normal 10px/150% Times New Roman, Times, serif; text-align:center; line-height:130%">
            www.opp.gob.bo <br>
            Av. Mariscal Santa Cruz, Esq. Calle Oruro, Edif. Centro de Comunicaciones La Paz, 4to. piso <br>
            Telefonos: (591) -2- 2119999-2156600
        </p>
    </footer> -->

</body>
</html>