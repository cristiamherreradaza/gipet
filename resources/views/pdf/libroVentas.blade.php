<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Historial Academico</title>
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
    
        /*.contenidos tr:nth-child(even) {background-color: #f2f2f2;}*/
        /*fin de estilos para tablas de contenidos*/

    </style>
    <!-- <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet"> -->
</head>

<body>
    <div style="text-align: center;"><h2>LIBRO DE VENTAS</h2></div>
    <div style="text-align: center;">
        (Expresado en Bolivianos)<br />
        Periodo: {{ $fecha_inicio }} hasta: {{ $fecha_final }}
    </div>
    
    <table class="datos">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Factura</th>
                {{-- <th>Caja</th> --}}
                <th>N. Autoriz.</th>
                <th>NIT</th>
                <th>Razon Social</th>
                <th>T.Ventas</th>
                <th>T.Des</th>
                <th>T.Fac</th>
                <th>T.Imp</th>
                <th>V.Neta</th>
                <th>AdmIN</th>
            </tr>
        </thead>
        <tbody>
            @php
            $totalVentas = 0;
            $totalImpositivo = 0;
            @endphp
            @forelse ($facturas as $f)
            @php
            $totalVentas += $f->total;
            $totalImpositivo += $f->total*0.13;
            @endphp
            <tr>
                <td style="font-size: 6pt;">{{ $f->fecha }}</td>
                <td>{{ $f->numero }}</td>
                {{-- <td>Caja 1</td> --}}
                <td>{{ $f->parametro->numero_autorizacion }}</td>
                <td>{{ $f->nit }}</td>
                <td style="text-align: left;">{{ $f->razon_social }}</td>
                <td style="text-align: right;">{{ number_format($f->total, 2) }}</td>
                <td style="text-align: right;">0</td>
                <td style="text-align: right;">{{ number_format($f->total, 2) }}</td>
                <td style="text-align: right;">{{ number_format($f->total*0.13, 2) }}</td>
                <td style="text-align: right;">{{ number_format($f->total-($f->total*0.13), 2) }}</td>
                <td>{{ $f->user->nombres }}</td>
            </tr>
            @empty
            <h3 class="text-danger text-center">NO EXISTEN REGISTROS</h3>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="text-align: left;"><b>TOTAL</b></td>
                <td style="text-align: right;"><b>{{ number_format($totalVentas, 2) }}</b></td>
                <td></td>
                <td style="text-align: right;"><b>{{ number_format($totalVentas,2) }}</b></td>
                <td style="text-align: right;"><b>{{ number_format($totalImpositivo, 2) }}</b></td>
                <td style="text-align: right;"><b>{{ number_format(($totalVentas - $totalImpositivo), 2) }}</b></td>
                <td></td>
            </tr>
        </tfoot>
    </table>        
</body>

</html>