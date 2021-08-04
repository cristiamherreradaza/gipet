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

        .titulos {
            font-size: 18pt;
        }
        .subtitulos {
            font-size: 14pt;
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
    <br/>
    <div style="text-align: center;">
        <span class="titulos">INSTITUTO TECNICO "EF - GIPET" S.R.L</span><br>
        <span class="subtitulos">LISTADO DE PAGOS</span><br>
        @php
            $hoy = date('Y-m-d H:m:i');
            $utilidades = new App\librerias\Utilidades();
            $fechaHoraEs = $utilidades->fechaHoraCastellano($hoy);
        @endphp
        FECHA: {{ $fechaHoraEs }}
    </div>

    <br>
    @if ($numero != null)
        <b>NUMERO FACTURA: </b>{{ $numero }} <br>
    @endif

    @if ($numero_recibo != null)
        <b>NUMERO RECIBO: </b>{{ $numero_recibo }} <br>
    @endif

    @if ($ci != null)
        <b>CARNET: </b>{{ $ci }} <br>
    @endif

    @if ($user_id != null)
        @php
            $usuario = App\User::find($user_id);
        @endphp
        <b>USUARIO: </b>{{ $usuario->nombres }}<br>
    @endif

    @if ($fecha_inicio != null)
        <b>FECHA DESDE: </b>{{ $fecha_inicio }}
    @endif

    @if ($fecha_final != null)
        <b>HASTA: </b>{{ $fecha_final }}
    @endif

    <br>
    <table class="datos">
        <thead>
            <tr>
                <th>TIPO</th>
                <th>NUMERO</th>
                <th>CARNET</th>
                <th>ESTUDIANTE</th>
                <th>RAZON</th>
                <th>NIT</th>
                <th>FECHA</th>
                <th>MONTO</th>
                <th>USUARIO</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @foreach ($cobros as $c)
            @php
                $total += $c->total;
            @endphp
            <tr>
                <td style="text-align: left;">
                    @if ($c->facturado == 'Si')
                    <span class="text-info">FACTURA</span>
                    @else
                    <span class="text-primary">RECIBO</span>
                    @endif
                </td>
                <td style="text-align: right;">
                    @if ($c->facturado == 'Si')
                    <span class="text-info">{{ $c->numero }}</span>
                    @else
                    <span class="text-primary">{{ $c->numero_recibo }}</span>
    
                    @endif
                </td>
                <td style="text-align: right">{{ $c->persona->cedula }}</td>
                <td style="text-align: left">{{ $c->persona->nombres }}</td>
                <td style="text-align: left">{{ $c->razon_social }}</td>
                <td style="text-align: right">{{ $c->nit }}</td>
                <td>{{ $c->fecha }}</td>
                <td style="text-align: right">{{ $c->total }}</td>
                <td>{{ $c->user->nombres }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>TOTAL</th>
                <th>{{ number_format($total, 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

</body>

</html>