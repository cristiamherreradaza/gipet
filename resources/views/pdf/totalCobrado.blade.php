<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pensiones Por periodo</title>
    <style type="text/css">
        @page {
            margin: 15px;
        }

        body {
            /* background-image: url('<?php //echo base_url(); ?>public/assets/images/reportes/formato.png'); */
            background-repeat: no-repeat;
            font-size: 13px;
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
            /* text-transform: uppercase; */
            height: 25px;
            background-color: #616362;
            color: #fff;
        }

        .datos td {
            font-size: 8pt;
            height: 20px;
        }

        .datos th,
        .datos td {
            border: 1px solid #ddd;
            padding: 2px;
            text-align: center;
        }

        .datos tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /*fin de estilos para tablas de datos*/
        /*estilos para tablas de contenidos*/
        table.contenidos {
            /*font-size: 13px;*/
            line-height: 14px;
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

        .contenidos th,
        .contenidos td {
            border-bottom: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }

        .titulo{
            font-size: 14pt;
            font-weight: bolder;
        }

        .centrado{
            text-align: center;
        }

        /*.contenidos tr:nth-child(even) {background-color: #f2f2f2;}*/
        /*fin de estilos para tablas de contenidos*/
    </style>
    <!-- <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet"> -->
</head>

<body>
    @php
        use \App\Http\Controllers\ReporteController;
    @endphp
    <div class="centrado">
        <br />
        <div class="titulo">ESCUELA FINANCIERA GIPET S.R.L.</div>
        <div class="titulo">TOTAL PAGOS COBRADOS</div>
        <br />
        <b>CARRERA: </b> CONTADURIA GENERAL
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>GESTION: </b> {{ $anio_vigente }}
    </div>

    <table class="datos">
        <thead>
            <tr>
                <th>TURNO</th>
                <th>Enero</th>
                <th>Febrero</th>
                <th>Marzo</th>
                <th>Abril</th>
                <th>Mayo</th>
                <th>Junio</th>
                <th>Julio</th>
                <th>Agosto</th>
                <th>Septiembre</th>
                <th>Octubre</th>
                <th>Noviembre</th>
                <th>Diciembre</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="12" style="text-align: center;"><b>PRIMER A&Ntilde;O "A"</b></td>
            </tr>
            <tr>
                <td style="text-align: left;">Turno Ma&ntilde;ana</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(1, 2, 1, 1, $anio_vigente, "A") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Tarde</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(1, 2, 1, 2, $anio_vigente, "A") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Noche</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(1, 2, 1, 3, $anio_vigente, "A") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Especial</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>  
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 1, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(1, 2, 1, 4, $anio_vigente, "A") }}
                </td>               
            </tr>
            
            <tr>
                <td><b>TOTAL PRIMER A&Ntilde;O</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(1, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(2, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(3, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(4, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(5, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(6, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(7, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(8, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(9, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(10, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(11, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(12, 2, 1, 1, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalPagadoAnual(1, 1, 2, $anio_vigente, "A") }}</b></td>
            </tr>
            
            <tr>
                <td colspan="12" style="text-align: center;"><b>PRIMER A&Ntilde;O "B"</b></td>
            </tr>
            <tr>
                <td style="text-align: left;">Turno Ma&ntilde;ana</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(1, 2, 1, 1, $anio_vigente, "B") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Tarde</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(1, 2, 1, 2, $anio_vigente, "B") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Noche</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(1, 2, 1, 3, $anio_vigente, "B") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Especial</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>  
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 1, 2, 1, 4, $anio_vigente, "B") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(1, 2, 1, 4, $anio_vigente, "B") }}
                </td>               
            </tr>
            
            <tr>
                <td><b>TOTAL PRIMER A&Ntilde;O</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(1, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(2, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(3, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(4, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(5, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(6, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(7, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(8, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(9, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(10, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(11, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(12, 2, 1, 1, $anio_vigente, "B") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalPagadoAnual(1, 1, 2, $anio_vigente, "B") }}</b></td>
            </tr>

            <tr>
                <td colspan="12" style="text-align: center;"><b>SEGUNDO A&Ntilde;O</b></td>
            </tr>
            
            
            <tr>
                <td style="text-align: left;">Turno Ma&ntilde;ana</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(2, 2, 1, 1, $anio_vigente, "A") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Tarde</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(2, 2, 1, 2, $anio_vigente, "A") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Noche</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(2, 2, 1, 3, $anio_vigente, "A") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Especial</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>  
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 2, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(2, 2, 1, 4, $anio_vigente, "A") }}
                </td>               
            </tr>
            
            <tr>
                <td><b>TOTAL SEGUNDO A&Ntilde;O</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(1, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(2, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(3, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(4, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(5, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(6, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(7, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(8, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(9, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(10, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(11, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(12, 2, 1, 2, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalPagadoAnual(2, 1, 2, $anio_vigente, "A") }}</b></td>
            </tr>


            <tr>
                <td colspan="12" style="text-align: center;"><b>TERCER A&Ntilde;O</b></td>
            </tr>
            
            
            
            <tr>
                <td style="text-align: left;">Turno Ma&ntilde;ana</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(3, 2, 1, 1, $anio_vigente, "A") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Tarde</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(3, 2, 1, 2, $anio_vigente, "A") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Noche</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(3, 2, 1, 3, $anio_vigente, "A") }}
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Especial</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(1, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(2, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(3, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(4, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(5, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(6, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(7, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(8, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(9, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(10, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(11, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>  
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrados(12, 3, 2, 1, 4, $anio_vigente, "A") }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::sumaTotalCobrado(3, 2, 1, 4, $anio_vigente, "A") }}
                </td>               
            </tr>
            
            <tr>
                <td><b>TOTAL TERCER A&Ntilde;O</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(1, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(2, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(3, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(4, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(5, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(6, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(7, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(8, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(9, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(10, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(11, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalMes(12, 2, 1, 3, $anio_vigente, "A") }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::sumaTotalPagadoAnual(3, 1, 2, $anio_vigente, "A") }}</b></td>
            </tr>

        </tbody>        
        <tfoot>
            <tr>
                <th>TOTAL</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(1, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(2, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(3, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(4, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(5, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(6, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(7, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(8, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(9, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(10, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(11, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalGestionesCobrado(12, 2, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::sumaTotalPagosCobrado(1, 2, $anio_vigente) }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>