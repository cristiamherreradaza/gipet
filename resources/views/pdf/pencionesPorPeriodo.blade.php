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
        <div class="titulo">CENTRALIZADOR DE PENSIONES POR PERIDO</div>
        <br />
        <b>CARRERA: </b> CONTADURIA GENERAL
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>GESTION: </b> {{ $anio_vigente }}
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>TURNO: </b> {{ $datosTurno->descripcion }}
    </div>

    <table class="datos">
        <thead>
            <tr>
                <th>NOMINA ALUMNOS</th>
                <th>CARNET</th>
                <th>1&deg; Mens</th>
                <th>2&deg; Mens</th>
                <th>3&deg; Mens</th>
                <th>4&deg; Mens</th>
                <th>5&deg; Mens</th>
                <th>6&deg; Mens</th>
                <th>7&deg; Mens</th>
                <th>8&deg; Mens</th>
                <th>9&deg; Mens</th>
                <th>10&deg; Mens</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPrimero = 0;
                $totalSegundo = 0;
                $totalTercero = 0;
                $totalCuarto = 0;
                $totalQuinto = 0;
                $totalSexto = 0;
                $totalSeptimo = 0;
                $totalOctavo = 0;
                $totalNoveno = 0;
                $totalDecimo = 0;
            @endphp
            @forelse($carrerasPersonas as $cp)
                @if ($cp->persona)
                    <tr>
                        <td style="text-align: left;">
                            {{ $cp->persona->apellido_paterno }}
                            {{ $cp->persona->apellido_materno }}
                            {{ $cp->persona->nombres }}
                        </td>
                        <td>{{ $cp->persona->cedula }}</td>
                        <td>
                            @php
                                $primerPago = App\Pago::where('gestion', $gestion)
                                        ->where('persona_id', $cp->persona->id)
                                        ->where('turno_id', $turno_id)
                                        ->where('carrera_id', 1)
                                        ->where('mensualidad', 1)
                                        ->whereYear('fecha', $anio_vigente)
                                        ->first();

                                echo $primer = ($primerPago!=null)?$primerPago->importe:0;
                                $totalPrimero += $primer;
                            @endphp
                        </td>
                        <td>
                            @php
                                $segundoPago = App\Pago::where('gestion', $gestion)
                                        ->where('persona_id', $cp->persona->id)
                                        ->where('turno_id', $turno_id)
                                        ->where('carrera_id', 1)
                                        ->where('mensualidad', 2)
                                        ->whereYear('fecha', $anio_vigente)
                                        ->first();

                                echo $segundo = ($segundoPago!=null)?$segundoPago->importe:0;
                                $totalSegundo += $segundo;
                            @endphp
                        </td>
                        <td>
                            @php
                                $tercerPago = App\Pago::where('gestion', $gestion)
                                        ->where('persona_id', $cp->persona->id)
                                        ->where('turno_id', $turno_id)
                                        ->where('carrera_id', 1)
                                        ->where('mensualidad', 3)
                                        ->whereYear('fecha', $anio_vigente)
                                        ->first();

                                echo $tercer = ($tercerPago!=null)?$tercerPago->importe:0;
                                $totalTercero += $tercer;
                            @endphp
                        </td>
                        <td>
                            @php
                                $cuartoPago = App\Pago::where('gestion', $gestion)
                                        ->where('persona_id', $cp->persona->id)
                                        ->where('turno_id', $turno_id)
                                        ->where('carrera_id', 1)
                                        ->where('mensualidad', 4)
                                        ->whereYear('fecha', $anio_vigente)
                                        ->first();

                                echo $cuarto = ($cuartoPago!=null)?$cuartoPago->importe:0;
                                $totalCuarto += $cuarto;
                            @endphp
                        </td>
                        <td>
                            @php
                                $quintoPago = App\Pago::where('gestion', $gestion)
                                        ->where('persona_id', $cp->persona->id)
                                        ->where('turno_id', $turno_id)
                                        ->where('carrera_id', 1)
                                        ->where('mensualidad', 5)
                                        ->whereYear('fecha', $anio_vigente)
                                        ->first();

                                echo $quinto = ($quintoPago!=null)?$quintoPago->importe:0;
                                $totalQuinto += $quinto;
                            @endphp
                        </td>
                        <td>
                            @php
                                $sextoPago = App\Pago::where('gestion', $gestion)
                                        ->where('persona_id', $cp->persona->id)
                                        ->where('turno_id', $turno_id)
                                        ->where('carrera_id', 1)
                                        ->where('mensualidad', 6)
                                        ->whereYear('fecha', $anio_vigente)
                                        ->first();

                                echo $sexto = ($sextoPago!=null)?$sextoPago->importe:0;
                                $totalSexto += $sexto;
                            @endphp
                        </td>
                        <td>
                            @php
                                $septimoPago = App\Pago::where('gestion', $gestion)
                                        ->where('persona_id', $cp->persona->id)
                                        ->where('turno_id', $turno_id)
                                        ->where('carrera_id', 1)
                                        ->where('mensualidad', 7)
                                        ->whereYear('fecha', $anio_vigente)
                                        ->first();

                                echo $septimo = ($septimoPago!=null)?$septimoPago->importe:0;
                                $totalSeptimo += $septimo;
                            @endphp
                        </td>
                        <td>
                            @php
                                $octavoPago = App\Pago::where('gestion', $gestion)
                                        ->where('persona_id', $cp->persona->id)
                                        ->where('turno_id', $turno_id)
                                        ->where('carrera_id', 1)
                                        ->where('mensualidad', 8)
                                        ->whereYear('fecha', $anio_vigente)
                                        ->first();

                                echo $octavo = ($octavoPago!=null)?$octavoPago->importe:0;
                                $totalOctavo += $octavo;
                            @endphp
                        </td>
                        <td>
                            @php
                                $novenoPago = App\Pago::where('gestion', $gestion)
                                        ->where('persona_id', $cp->persona->id)
                                        ->where('turno_id', $turno_id)
                                        ->where('carrera_id', 1)
                                        ->where('mensualidad', 9)
                                        ->whereYear('fecha', $anio_vigente)
                                        ->first();

                                echo $noveno = ($novenoPago!=null)?$novenoPago->importe:0;
                                $totalNoveno += $noveno;
                            @endphp
                        </td>
                        <td>
                            @php
                                $decimoPago = App\Pago::where('gestion', $gestion)
                                        ->where('persona_id', $cp->persona->id)
                                        ->where('turno_id', $turno_id)
                                        ->where('carrera_id', 1)
                                        ->where('mensualidad', 10)
                                        ->whereYear('fecha', $anio_vigente)
                                        ->first();

                                echo $decimo = ($decimoPago!=null)?$decimoPago->importe:0;
                                $totalDecimo += $decimo;
                            @endphp
                        </td>
                        <td style="text-align: right;">
                            {{ $primer + $segundo + $tercer + $cuarto + $quinto + $sexto + $septimo + $octavo + $noveno + $decimo }}
                        </td>
                    </tr>
                @endif
            @empty
            <h3 class="text-danger text-center">NO EXISTEN REGISTROS</h3>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>TOTALES</th>
                <th></th>
                <th>{{ $totalPrimero }}</th>
                <th>{{ $totalSegundo }}</th>
                <th>{{ $totalTercero }}</th>
                <th>{{ $totalCuarto }}</th>
                <th>{{ $totalQuinto }}</th>
                <th>{{ $totalSexto }}</th>
                <th>{{ $totalSeptimo }}</th>
                <th>{{ $totalOctavo }}</th>
                <th>{{ $totalNoveno }}</th>
                <th>{{ $totalDecimo }}</th>
                <th style="text-align: right;">{{ $totalPrimero + $totalSegundo + $totalTercero + $totalCuarto + $totalQuinto + $totalSexto + $totalSeptimo + $totalOctavo + $totalNoveno + $totalDecimo }}</th>
            </tr>
        </tfoot>
    </table>
</body>

</html>