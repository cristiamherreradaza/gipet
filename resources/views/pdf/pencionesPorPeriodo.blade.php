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
        <h2>REPORTE DE PAGOS</h2>
    </div>
    <div style="text-align: center;">
        (Expresado en Bolivianos)<br />
    </div>

    <table class="datos">
        <thead>
            <tr>
                <th>NOMINA ALUMNOS</th>
                <th>CARNET</th>
                <th>1&deg; Mens.</th>
                <th>2&deg; Mens.</th>
                <th>3&deg; Mens.</th>
                <th>4&deg; Mens.</th>
                <th>5&deg; Mens.</th>
                <th>6&deg; Mens.</th>
                <th>7&deg; Mens.</th>
                <th>8&deg; Mens.</th>
                <th>9&deg; Mens.</th>
                <th>10&deg; Mens.</th>
            </tr>
        </thead>
        <tbody>
            @forelse($carrerasPersonas as $cp)
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
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_final])
                                ->first();

                        echo ($primerPago!=null)?$primerPago->importe:0;
                    @endphp
                </td>
                <td>
                    @php
                        $primerPago = App\Pago::where('gestion', $gestion)
                                ->where('persona_id', $cp->persona->id)
                                ->where('turno_id', $turno_id)
                                ->where('carrera_id', 1)
                                ->where('mensualidad', 2)
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_final])
                                ->first();

                        echo ($primerPago!=null)?$primerPago->importe:0;
                    @endphp
                </td>
                <td>
                    @php
                        $primerPago = App\Pago::where('gestion', $gestion)
                                ->where('persona_id', $cp->persona->id)
                                ->where('turno_id', $turno_id)
                                ->where('carrera_id', 1)
                                ->where('mensualidad', 3)
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_final])
                                ->first();

                        echo ($primerPago!=null)?$primerPago->importe:0;
                    @endphp
                </td>
                <td>
                    @php
                        $primerPago = App\Pago::where('gestion', $gestion)
                                ->where('persona_id', $cp->persona->id)
                                ->where('turno_id', $turno_id)
                                ->where('carrera_id', 1)
                                ->where('mensualidad', 4)
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_final])
                                ->first();

                        echo ($primerPago!=null)?$primerPago->importe:0;
                    @endphp
                </td>
                <td>
                    @php
                        $primerPago = App\Pago::where('gestion', $gestion)
                                ->where('persona_id', $cp->persona->id)
                                ->where('turno_id', $turno_id)
                                ->where('carrera_id', 1)
                                ->where('mensualidad', 5)
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_final])
                                ->first();

                        echo ($primerPago!=null)?$primerPago->importe:0;
                    @endphp
                </td>
                <td>
                    @php
                        $primerPago = App\Pago::where('gestion', $gestion)
                                ->where('persona_id', $cp->persona->id)
                                ->where('turno_id', $turno_id)
                                ->where('carrera_id', 1)
                                ->where('mensualidad', 6)
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_final])
                                ->first();

                        echo ($primerPago!=null)?$primerPago->importe:0;
                    @endphp
                </td>
                <td>
                    @php
                        $primerPago = App\Pago::where('gestion', $gestion)
                                ->where('persona_id', $cp->persona->id)
                                ->where('turno_id', $turno_id)
                                ->where('carrera_id', 1)
                                ->where('mensualidad', 7)
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_final])
                                ->first();

                        echo ($primerPago!=null)?$primerPago->importe:0;
                    @endphp
                </td>
                <td>
                    @php
                        $primerPago = App\Pago::where('gestion', $gestion)
                                ->where('persona_id', $cp->persona->id)
                                ->where('turno_id', $turno_id)
                                ->where('carrera_id', 1)
                                ->where('mensualidad', 8)
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_final])
                                ->first();

                        echo ($primerPago!=null)?$primerPago->importe:0;
                    @endphp
                </td>
                <td>
                    @php
                        $primerPago = App\Pago::where('gestion', $gestion)
                                ->where('persona_id', $cp->persona->id)
                                ->where('turno_id', $turno_id)
                                ->where('carrera_id', 1)
                                ->where('mensualidad', 9)
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_final])
                                ->first();

                        echo ($primerPago!=null)?$primerPago->importe:0;
                    @endphp
                </td>
                <td>
                    @php
                        $primerPago = App\Pago::where('gestion', $gestion)
                                ->where('persona_id', $cp->persona->id)
                                ->where('turno_id', $turno_id)
                                ->where('carrera_id', 1)
                                ->where('mensualidad', 10)
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_final])
                                ->first();

                        echo ($primerPago!=null)?$primerPago->importe:0;
                    @endphp
                </td>
            </tr>
            @empty
            <h3 class="text-danger text-center">NO EXISTEN REGISTROS</h3>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th></th>
            </tr>
        </tfoot>
    </table>
</body>

</html>