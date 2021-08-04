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
    <div style="text-align: center;">
        <h2>LISTADO DE PAGOS</h2>
    </div>
    <div style="text-align: center;">
        (Expresado en Bolivianos)<br />
        
    </div>

    <table class="datos">
        <thead>
            <tr>
                <th>ID</th>
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
            @foreach ($cobros as $c)
            <tr>
                <td>{{ $c->id }}</td>
                <td>
                    @if ($c->facturado == 'Si')
                    <span class="text-info">FACTURA</span>
                    @else
                    <span class="text-primary">RECIBO</span>
                    @endif
                </td>
                <td>
                    @if ($c->facturado == 'Si')
                    <span class="text-info">{{ $c->numero }}</span>
                    @else
                    <span class="text-primary">{{ $c->numero_recibo }}</span>
    
                    @endif
                </td>
                <td>{{ $c->persona->cedula }}</td>
                <td>{{ $c->persona->nombres }}</td>
                <td>{{ $c->razon_social }}</td>
                <td>{{ $c->nit }}</td>
                <td>{{ $c->fecha }}</td>
                <td>{{ $c->total }}</td>
                <td>{{ $c->user->nombres }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>