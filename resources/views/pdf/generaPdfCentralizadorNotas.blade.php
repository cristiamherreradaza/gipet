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

        .titulo {
            font-size: 14pt;
            font-weight: bolder;
        }

        .centrado {
            text-align: center;
        }

        /*.contenidos tr:nth-child(even) {background-color: #f2f2f2;}*/
        /*fin de estilos para tablas de contenidos*/
    </style>
    <!-- <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet"> -->
</head>

<body>
{{-- <button onclick="ExportExcel('xlsx')">EXCEL</button> --}}
<table width="100%">
    <tr>
        <td width="25%"><img src="{{ asset('assets/imagenes/portal_uno_R.png') }}" height="80"></td>
        <td width="50%" style="text-align: center;"><span style="font-size: 18pt;">CETRALIZADOR DE CALIFICACIONES</span>
        </td>
        <td width="25%" style="text-align: right;"><span style="font-size: 8pt;"> FECHA: {{ date('d/m/Y') }}</span></td>
    </tr>

    <tr>
        <td><span style="font-size: 7pt;"><b>CARRERA: </b> {{ $datosCarrera->nombre }}</span></td>
        <td style="text-align: center;">
            <span style="font-size: 7pt;">
                <b>CURSO: </b>{{ $curso }}&deg; A&ntilde;o
                <b>TURNO: </b>{{ $datosTurno->descripcion }}
                <b>PARALELO: </b>"{{ $paralelo }}" -
                @if ($tipo == 'primero')
                1&deg; Bim
                @elseif ($tipo == 'segundo')
                2&deg; Bim
                @else
                Anual
                @endif
            </span>
        </td>
        <td><span style="font-size: 7pt;"><b>GESTION: </b> {{ $gestion }}</span></td>
    </tr>
</table>

<div class="table-responsive m-t-40">
    <table class="datos" id="tablaCentralizador">
        <tr>
            <td>
                CARRERA:<BR>                 
                TURNO: <BR>
            </td>
        </tr>

        <tr>
            @if ($imp_nombre == 'Si')
            <td style="width: 180px;">
                <b>NOMINA ESTUDIANTES</b>
            </td>
            @endif
            <td style="width: 20px;">CARNET</td>
            @foreach ($materiasCarrera as $mc)
            <td style="font-size: 10pt; width: 22px; text-transform: uppercase;vertical-align: top;">
                ({{ $mc->sigla }})<br /> {{ $mc->nombre }}
            </td>
            @endforeach
            {{-- <td><b>OBSERVACIONES</b></td> --}}
        </tr>

        @foreach ($nominaEstudiantes as $k => $ne)
        <tr>
            @if ($imp_nombre == 'Si')
            <td style="width: 190px;">{{ $ne->persona->apellido_paterno }} {{ $ne->persona->apellido_materno }} {{ $ne->persona->nombres }}</td>
            @endif
            <td>{{ $ne->persona->cedula }}</td>
            @foreach ($materiasCarrera as $mc)
            @php

            if($tipo == 'primero'){
                $nota = App\Nota::where('persona_id', $ne->persona_id)
                ->where('carrera_id', $carrera)
                ->where('anio_vigente', $gestion)
                ->where('paralelo', $paralelo)
                ->where('asignatura_id', $mc->id)
                ->where('trimestre', 1)
                ->first();
            }elseif ($tipo == 'segundo') {
                $nota = App\Nota::where('persona_id', $ne->persona_id)
                ->where('carrera_id', $carrera)
                ->where('anio_vigente', $gestion)
                ->where('paralelo', $paralelo)
                ->where('asignatura_id', $mc->id)
                ->where('trimestre', 2)
                ->first();
            }else{
                $nota = App\Inscripcione::where('persona_id', $ne->persona_id)
                ->where('carrera_id', $carrera)
                ->where('anio_vigente', $gestion)
                ->where('asignatura_id', $mc->id)
                ->first();
            }

            $estado = App\CarrerasPersona::where('persona_id', $ne->persona_id)
            ->where('carrera_id', $carrera)
            ->where('anio_vigente', $gestion)
            ->first();
            @endphp
            <td style="text-align: center;">
                @if ($nota)
                    @if ($tipo == 'primero' || $tipo == 'segundo')
                        {{ intval($nota->nota_total) }}
                    @else
                        @php
                            $notaAlumno = intval($nota->nota);
                            if($nota->segundo_turno != null){
                                $notaAlumno = $notaAlumno."(".$nota->segundo_turno.")";
                            }
                            echo $notaAlumno;
                        @endphp
                        {{-- @if ($nota->segundo_turno > 60)
                            {{ intval($nota->segundo_turno) }}*
                        @else
                            {{ intval($nota->nota) }}
                        @endif --}}
                    @endif
                @else
                    0
                @endif
            </td>
            @endforeach
            {{-- <td>{{ $estado->estado }}</td> --}}
        </tr>
        @endforeach
    </table>
</div>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<script type="text/javascript">

    function ExportExcel(type, fn, dl) {
     var elt = document.getElementById('tablaCentralizador');
    //  var elt = document.getElementsByClassName('tablaCentralizador');
     var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
     return dl ?
     XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
     XLSX.writeFile(wb, fn || ('Centralizador.' + (type || 'xlsx')));
 }

</script>
</body>
</html>