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
                <td colspan="12" style="text-align: center;"><b>PRIMER A&Ntilde;O</b></td>
            </tr>
            <tr>
                <td style="text-align: left;">Turno Ma&ntilde;ana</td>
                <td style="text-align: right;">
                    @php
                        $primerPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_primero'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 1)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $pPago = ($primerPago->total_primero != null)?$primerPago->total_primero:'0.00';
                        echo number_format($pPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $segundoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_segundo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 2)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sPago = ($segundoPago->total_segundo != null)?$segundoPago->total_segundo:'0.00';
                        echo number_format($sPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $tercerPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_tercero'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 3)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $tPago = ($tercerPago->total_tercero != null)?$tercerPago->total_tercero:'0.00';
                        echo number_format($tPago, 2, '.', ',');
                            
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $cuartoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_cuarto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 4)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $cPago = ($cuartoPago->total_cuarto != null)?$cuartoPago->total_cuarto:'0.00';
                        echo number_format($cPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $quintoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_quinto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 5)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $qPago = ($quintoPago->total_quinto != null)?$quintoPago->total_quinto:'0.00';
                        echo number_format($qPago, 2, '.', ',');
                        
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $sextoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_sexto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 6)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sePago = ($sextoPago->total_sexto != null)?$sextoPago->total_sexto:'0.00';                            
                        echo number_format($sePago, 2, '.', ',');
                        
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $septimoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_septimo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 7)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sepPago = ($septimoPago->total_septimo != null)?$septimoPago->total_septimo:'0.00';                            
                        echo number_format($sepPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $octavoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_octavo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 8)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $oPago = ($octavoPago->total_octavo != null)?$octavoPago->total_octavo:'0.00';
                        echo number_format($oPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $novenoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_noveno'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 9)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $nPago = ($novenoPago->total_noveno != null)?$novenoPago->total_noveno:'0.00';                            
                        echo number_format($nPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $decimoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_decimo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 10)
                            ->where('turno_id', 1)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();
                        $dPago = ($decimoPago->total_decimo != null)?$decimoPago->total_decimo:'0.00';
                        echo number_format($dPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                       $totalPM = $pPago + $sPago + $tPago + $cPago + $qPago + $sePago + $sepPago + $oPago + $nPago + $dPago; 
                       echo number_format($totalPM, 2, '.', ',');
                    @endphp
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Tarde</td>
                <td style="text-align: right;">
                    @php
                        $primerPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_primero'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 1)
                            ->where('turno_id', 2)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $pPago = ($primerPago->total_primero != null)?$primerPago->total_primero:'0.00';
                        echo number_format($pPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $segundoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_segundo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 2)
                            ->where('turno_id', 2)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sPago = ($segundoPago->total_segundo != null)?$segundoPago->total_segundo:'0.00';
                        echo number_format($sPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $tercerPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_tercero'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 3)
                            ->where('turno_id', 2)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $tPago = ($tercerPago->total_tercero != null)?$tercerPago->total_tercero:'0.00';
                        echo number_format($tPago, 2, '.', ',');
                            
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $cuartoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_cuarto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 4)
                            ->where('turno_id', 2)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $cPago = ($cuartoPago->total_cuarto != null)?$cuartoPago->total_cuarto:'0.00';
                        echo number_format($cPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $quintoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_quinto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 5)
                            ->where('turno_id', 2)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $qPago = ($quintoPago->total_quinto != null)?$quintoPago->total_quinto:'0.00';
                        echo number_format($qPago, 2, '.', ',');
                        
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $sextoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_sexto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 6)
                            ->where('turno_id', 2)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sePago = ($sextoPago->total_sexto != null)?$sextoPago->total_sexto:'0.00';                            
                        echo number_format($sePago, 2, '.', ',');
                        
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $septimoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_septimo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 7)
                            ->where('turno_id', 2)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sepPago = ($septimoPago->total_septimo != null)?$septimoPago->total_septimo:'0.00';                            
                        echo number_format($sepPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $octavoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_octavo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 8)
                            ->where('turno_id', 2)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $oPago = ($octavoPago->total_octavo != null)?$octavoPago->total_octavo:'0.00';
                        echo number_format($oPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $novenoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_noveno'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 9)
                            ->where('turno_id', 2)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $nPago = ($novenoPago->total_noveno != null)?$novenoPago->total_noveno:'0.00';                            
                        echo number_format($nPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $decimoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_decimo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 10)
                            ->where('turno_id', 2)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();
                        $dPago = ($decimoPago->total_decimo != null)?$decimoPago->total_decimo:'0.00';
                        echo number_format($dPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                       $totalPM = $pPago + $sPago + $tPago + $cPago + $qPago + $sePago + $sepPago + $oPago + $nPago + $dPago; 
                       echo number_format($totalPM, 2, '.', ',');
                    @endphp
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Noche</td>
                <td style="text-align: right;">
                    @php
                        $primerPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_primero'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 1)
                            ->where('turno_id', 3)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $pPago = ($primerPago->total_primero != null)?$primerPago->total_primero:'0.00';
                        echo number_format($pPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $segundoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_segundo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 2)
                            ->where('turno_id', 3)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sPago = ($segundoPago->total_segundo != null)?$segundoPago->total_segundo:'0.00';
                        echo number_format($sPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $tercerPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_tercero'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 3)
                            ->where('turno_id', 3)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $tPago = ($tercerPago->total_tercero != null)?$tercerPago->total_tercero:'0.00';
                        echo number_format($tPago, 2, '.', ',');
                            
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $cuartoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_cuarto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 4)
                            ->where('turno_id', 3)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $cPago = ($cuartoPago->total_cuarto != null)?$cuartoPago->total_cuarto:'0.00';
                        echo number_format($cPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $quintoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_quinto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 5)
                            ->where('turno_id', 3)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $qPago = ($quintoPago->total_quinto != null)?$quintoPago->total_quinto:'0.00';
                        echo number_format($qPago, 2, '.', ',');
                        
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $sextoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_sexto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 6)
                            ->where('turno_id', 3)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sePago = ($sextoPago->total_sexto != null)?$sextoPago->total_sexto:'0.00';                            
                        echo number_format($sePago, 2, '.', ',');
                        
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $septimoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_septimo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 7)
                            ->where('turno_id', 3)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sepPago = ($septimoPago->total_septimo != null)?$septimoPago->total_septimo:'0.00';                            
                        echo number_format($sepPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $octavoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_octavo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 8)
                            ->where('turno_id', 3)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $oPago = ($octavoPago->total_octavo != null)?$octavoPago->total_octavo:'0.00';
                        echo number_format($oPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $novenoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_noveno'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 9)
                            ->where('turno_id', 3)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $nPago = ($novenoPago->total_noveno != null)?$novenoPago->total_noveno:'0.00';                            
                        echo number_format($nPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $decimoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_decimo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 10)
                            ->where('turno_id', 3)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();
                        $dPago = ($decimoPago->total_decimo != null)?$decimoPago->total_decimo:'0.00';
                        echo number_format($dPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                       $totalPM = $pPago + $sPago + $tPago + $cPago + $qPago + $sePago + $sepPago + $oPago + $nPago + $dPago; 
                       echo number_format($totalPM, 2, '.', ',');
                    @endphp
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">Turno Especial</td>
                <td style="text-align: right;">
                    @php
                        $primerPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_primero'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 1)
                            ->where('turno_id', 4)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $pPago = ($primerPago->total_primero != null)?$primerPago->total_primero:'0.00';
                        echo number_format($pPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $segundoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_segundo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 2)
                            ->where('turno_id', 4)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sPago = ($segundoPago->total_segundo != null)?$segundoPago->total_segundo:'0.00';
                        echo number_format($sPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $tercerPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_tercero'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 3)
                            ->where('turno_id', 4)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $tPago = ($tercerPago->total_tercero != null)?$tercerPago->total_tercero:'0.00';
                        echo number_format($tPago, 2, '.', ',');
                            
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $cuartoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_cuarto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 4)
                            ->where('turno_id', 4)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $cPago = ($cuartoPago->total_cuarto != null)?$cuartoPago->total_cuarto:'0.00';
                        echo number_format($cPago, 2, '.', ',');

                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $quintoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_quinto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 5)
                            ->where('turno_id', 4)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $qPago = ($quintoPago->total_quinto != null)?$quintoPago->total_quinto:'0.00';
                        echo number_format($qPago, 2, '.', ',');
                        
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $sextoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_sexto'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 6)
                            ->where('turno_id', 4)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sePago = ($sextoPago->total_sexto != null)?$sextoPago->total_sexto:'0.00';                            
                        echo number_format($sePago, 2, '.', ',');
                        
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $septimoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_septimo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 7)
                            ->where('turno_id', 4)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $sepPago = ($septimoPago->total_septimo != null)?$septimoPago->total_septimo:'0.00';                            
                        echo number_format($sepPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $octavoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_octavo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 8)
                            ->where('turno_id', 4)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $oPago = ($octavoPago->total_octavo != null)?$octavoPago->total_octavo:'0.00';
                        echo number_format($oPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $novenoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_noveno'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 9)
                            ->where('turno_id', 4)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

                        $nPago = ($novenoPago->total_noveno != null)?$novenoPago->total_noveno:'0.00';                            
                        echo number_format($nPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                        $decimoPago = App\Pago::select(Illuminate\Support\Facades\DB::raw('SUM(a_pagar) as total_decimo'))
                            ->where('carrera_id', 1)
                            ->where('gestion', 1)
                            ->where('mensualidad', 10)
                            ->where('turno_id', 4)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();
                        $dPago = ($decimoPago->total_decimo != null)?$decimoPago->total_decimo:'0.00';
                        echo number_format($dPago, 2, '.', ',');
                    @endphp
                </td>
                <td style="text-align: right;">
                    @php
                       $totalPM = $pPago + $sPago + $tPago + $cPago + $qPago + $sePago + $sepPago + $oPago + $nPago + $dPago; 
                       echo number_format($totalPM, 2, '.', ',');
                    @endphp
                </td>
            </tr>

            
        </tbody>        
        <tfoot>
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
        </tfoot>
    </table>
</body>

</html>