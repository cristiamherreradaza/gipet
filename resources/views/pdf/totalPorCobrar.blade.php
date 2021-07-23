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
                <td>PRIMER A&Ntilde;O</td>
                <td>
                    @php
                        $pagos
                    @endphp
                </td>
            </tr>
            <tr>
                <td>Turno Ma&ntilde;ana</td>
                <td>
                    @php
                        $primerPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_primero'))
                            ->where('carrera_id', 1)
                            ->where('mensualidad', 1)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        echo $primerPago->total_primero;
                    @endphp
                </td>
                <td>
                    @php
                        $segundoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_segundo'))
                            ->where('carrera_id', 1)
                            ->where('mensualidad', 2)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        echo $segundoPago->total_segundo;
                    @endphp
                </td>
                <td>
                    @php
                        $tercerPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_tercero'))
                            ->where('carrera_id', 1)
                            ->where('mensualidad', 1)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        echo $primerPago->total_tercero;
                    @endphp
                </td>
            </tr>
        </tbody>        
        <tfoot>
            <tr>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>