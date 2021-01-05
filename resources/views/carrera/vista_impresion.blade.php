<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Impresion Malla Curricular</title>
    <!-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> -->
    <style type="text/css">
        @media print {
            #boton_imprimir {
                display: none;
            }
        }
        @page {
            margin: 15px;
        }
        body {
            background-repeat: no-repeat; 
            font-size: 8px;
        }
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        a {
            color: #fff;
            text-decoration: none;
        }
        /*estilos para tablas de datos*/
        table.datos {
            /*font-size: 13px;*/
            /*line-height:14px;*/
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        .datos th {
          height: 10px;
          background-color: #616362;
          color: #fff;
        }
        .datos td {
          height: 12px;
        }
        .datos th, .datos td {
          border: 1px solid #ddd;
          padding: 2px;
          text-align: center;
        }
        .datos tr:nth-child(even) {background-color: #f2f2f2;}
        /*fin de estilos para tablas de datos*/
        /*estilos para tablas de contenidos*/
        table.contenidos {
            /*font-size: 13px;*/
            line-height:10px;
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        .contenidos th {
          height: 20px;
          background-color: #616362;
          color: #fff;
        }
        .contenidos td {
          height: 10px;
        }
        .contenidos th, .contenidos td {
          border-bottom: 1px solid #ddd;
          padding: 5px;
          text-align: left;
        }
        /*.contenidos tr:nth-child(even) {background-color: #f2f2f2;}*/
        /*fin de estilos para tablas de contenidos*/
        .titulo {
            font-weight: bolder;
        }
        .invoice {
            margin-left: 15px;
            width: 813px;
        }
        .information {
            background-color: #60A7A6;
            color: #FFF;
            line-height:7px;
        }
        .information .logo {
            margin: 5px;
        }
        .information table {
            padding: 10px;
        }
        .glosa {
            font-size: 10px;
            line-height:14px;
        }
        .pie_pagina {
            font-size: 10px;
            line-height:14px;
        }
        .titulo {
            font-size: 13px;
            line-height:18px;    
        }
        .firmas td {
            padding-top: 30px;
            text-align: center;
        }
        .firmas {
            width: 100%;
        }

    </style>
</head>
<body>
<div class="invoice" id="printableArea">
    <p style="margin-top: 5px; font-size: 15px; text-align: center;">
        ESCUELA FINANCIERA GIPET
        <br>
        CARRERA DE {{ strtoupper($carrera->nombre) }}
        <br>
        MALLA CURRICULAR {{ $gestion }}
        <br>
        APROBADA EN JORNADAS ACADEMICAS DOCENTE-ESTUDIANTIL
        <br>
        PROGRAMA DE {{ $carrera->duracion_anios }} AÑOS OBLIGATORIOS CON TITULACION A NIVEL {{ strtoupper($carrera->nivel) }}
    </p>
    <br>
    <div class="titulo">Detalle de Asignaturas</div>
    <table class="datos">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-right">SIGLA</th>
                <th class="text-right">MATERIA</th>
                <th class="text-right">GESTION</th>
                <th class="text-right">HORAS ACAD. VIRTUALES</th>
                <th class="text-right">HORAS ACADEMICAS</th>
                <th class="text-right">TEORICO</th>
                <th class="text-right">PRACTICO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaturas as $key => $asignatura)
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td class="text-right">{{ $asignatura->sigla }}</td>
                    <td class="text-right">{{ $asignatura->nombre }}</td>
                    <td class="text-right">{{ $asignatura->gestion }}</td>
                    <td class="text-right">{{ $asignatura->carga_horaria_virtual }}</td>
                    <td class="text-right">{{ $asignatura->carga_horaria }}</td>
                    <td class="text-right">{{ $asignatura->teorico }}</td>
                    <td class="text-right">{{ $asignatura->practico }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <!-- <table class="firmas">
        <tr>
            <td><hr style="width: 150px"> Entregue Conforme</td>
            <td><hr style="width: 150px"> Recibi Conforme</td>
        </tr>
    </table> -->
</div>
<input type="button" name="imprimir" id="boton_imprimir" value="Imprimir" onclick="window.print();">
<!-- <button id="botonImprimir" class="btn btn-inverse btn-block print-page" type="button"> <span><i class="fa fa-print"></i> IMPRIMIR </span></button> -->

<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('dist/js/pages/samplepages/jquery.PrintArea.js') }}"></script>
<script src="{{ asset('dist/js/pages/invoice/invoice.js') }}"></script>
<script>
    $("#botonImprimir").click(function() {
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = {
                mode: mode,
                popClose: close
        };
        $("div#printableArea").printArea(options);
    });
</script>