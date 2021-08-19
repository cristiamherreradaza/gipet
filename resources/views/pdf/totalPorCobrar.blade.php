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
        <div class="titulo">TOTAL PAGOS POR COBRAR</div>
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
                <th>1&deg; Pago</th>
                <th>2&deg; Pago</th>
                <th>3&deg; Pago</th>
                <th>4&deg; Pago</th>
                <th>5&deg; Pago</th>
                <th>6&deg; Pago</th>
                <th>7&deg; Pago</th>
                <th>8&deg; Pago</th>
                <th>9&deg; Pago</th>
                <th>10&deg; Pago</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="12" style="text-align: center;"><b>PRIMER A&Ntilde;O</b></td>
            </tr>
            <tr>
                <td style="text-align: left;">Turno Ma&ntilde;ana</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 1, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 2, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 3, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 4, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 5, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 6, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 7, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 8, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 9, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 10, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 1, 1, $anio_vigente) }}     
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Tarde</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 1, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 2, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 3, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 4, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 5, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 6, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 7, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 8, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 9, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 10, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 1, 2, $anio_vigente) }}     
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Noche</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 1, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 2, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 3, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 4, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 5, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 6, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 7, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 8, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 9, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 10, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 1, 3, $anio_vigente) }}     
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Especial</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 1, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 2, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 3, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 4, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 5, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 6, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 7, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 8, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 9, 4, $anio_vigente) }}     
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 10, 4, $anio_vigente) }}     
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 1, 4, $anio_vigente) }}     
                </td>                
            </tr>
            
            <tr>
                <td><b>TOTAL PRIMER A&Ntilde;O</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 1, 1, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 1, 2, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 1, 3, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 1, 4, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 1, 5, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 1, 6, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 1, 7, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 1, 8, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 1, 9, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 1, 10, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaTotalGestion(1, 1, $anio_vigente) }}</b></td>
            </tr>


            <tr>
                <td colspan="12" style="text-align: center;"><b>SEGUNDO A&Ntilde;O</b></td>
            </tr>
            <tr>
                <td style="text-align: left;">Turno Ma&ntilde;ana</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 1, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 2, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 3, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 4, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 5, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 6, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 7, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 8, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 9, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 10, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 2, 1, $anio_vigente) }}     
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Tarde</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 1, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 2, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 3, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 4, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 5, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 6, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 7, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 8, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 9, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 10, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 2, 2, $anio_vigente) }}     
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Noche</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 1, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 2, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 3, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 4, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 5, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 6, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 7, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 8, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 9, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 10, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 2, 3, $anio_vigente) }}     
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Especial</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 1, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 2, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 3, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 4, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 5, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 6, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 7, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 8, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 2, 9, 4, $anio_vigente) }}     
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 1, 10, 4, $anio_vigente) }}     
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 2, 4, $anio_vigente) }}     
                </td>                
            </tr>
            
            <tr>
                <td><b>TOTAL SEGUNDO A&Ntilde;O</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 2, 1, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 2, 2, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 2, 3, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 2, 4, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 2, 5, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 2, 6, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 2, 7, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 2, 8, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 2, 9, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 2, 10, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaTotalGestion(1, 2, $anio_vigente) }}</b></td>
            </tr>


            <tr>
                <td colspan="12" style="text-align: center;"><b>TERCER A&Ntilde;O</b></td>
            </tr>
            <tr>
                <td style="text-align: left;">Turno Ma&ntilde;ana</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 1, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 2, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 3, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 4, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 5, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 6, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 7, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 8, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 9, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 10, 1, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 3, 1, $anio_vigente) }}     
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Tarde</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 1, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 2, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 3, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 4, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 5, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 6, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 7, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 8, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 9, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 10, 2, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 3, 2, $anio_vigente) }}     
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Noche</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 1, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 2, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 3, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 4, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 5, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 6, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 7, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 8, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 9, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 10, 3, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 3, 3, $anio_vigente) }}     
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Especial</td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 1, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 2, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 3, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 4, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 5, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 6, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 7, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 8, 4, $anio_vigente) }}
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 9, 4, $anio_vigente) }}     
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosCobrar(1, 3, 10, 4, $anio_vigente) }}     
                </td>
                <td style="text-align: right;">
                    {{ ReporteController::calculaPagosTurnos(1, 3, 4, $anio_vigente) }}     
                </td>                
            </tr>
            
            <tr>
                <td><b>TOTAL TECER A&Ntilde;O</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 3, 1, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 3, 2, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 3, 3, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 3, 4, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 3, 5, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 3, 6, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 3, 7, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 3, 8, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 3, 9, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaPagosCuotas(1, 3, 10, $anio_vigente) }}</b></td>
                <td style="text-align: right;"><b>{{ ReporteController::calculaTotalGestion(1, 3, $anio_vigente) }}</b></td>
            </tr>

        </tbody>        
        <tfoot>
            <tr>
                <th>TOTAL</th>
                <th style="text-align: right;">{{ ReporteController::calculaTotalPagosCuotas(1, 1, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::calculaTotalPagosCuotas(1, 2, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::calculaTotalPagosCuotas(1, 3, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::calculaTotalPagosCuotas(1, 4, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::calculaTotalPagosCuotas(1, 5, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::calculaTotalPagosCuotas(1, 6, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::calculaTotalPagosCuotas(1, 7, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::calculaTotalPagosCuotas(1, 8, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::calculaTotalPagosCuotas(1, 9, $anio_vigente) }}</th>
                <th style="text-align: right;">{{ ReporteController::calculaTotalPagosCuotas(1, 10, $anio_vigente) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>