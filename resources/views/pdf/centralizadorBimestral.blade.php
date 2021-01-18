<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Historial Academico</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 1cm 1cm 2cm;
            font-size: 9pt;
            font-family: Arial, Helvetica, sans-serif;
        }

        .bordes {
            /* border: #24486C 1px solid; */
            border: 1px solid;
            border-collapse: collapse;
        }

        /*estilos para tablas de datos*/
        table.datos {
            font-size: 8pt;
            /*line-height:14px;*/
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        .datos th {
          height: 25px;
          background-color: #616362;
          color: #fff;
        }
        .datos td {
          height: 20px;
        }
        .datos th, .datos td {
          border: 1px solid #ddd;
          padding: 5px;
          text-align: center;
        }
        .datos tr:nth-child(even) {background-color: #f2f2f2;}
        /*fin de estilos para tablas de datos*/
        

    </style>
    <!-- <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet"> -->
</head>
<body>
    <header></header>
    <main>
        <div style="font-size: 22pt; font-weight: bolder; text-align: center; padding-top: 40px;">INSTITUTO TECNICO "EF - GIPET" S.R.L.</div>
        <div style="font-size: 14pt; text-align: center;">CENTRALIZADOR DE CALIFICACIONES ({{ $datos->trimestre }} - BIMESTRE)</div>
        <div style="font-size: 14pt; text-align: center; text-transform: uppercase;">{{ $datos->asignatura->carrera->nombre }}</div>
        <p>&nbsp;</p>
        <b>Matreria: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>{{ $datos->asignatura->nombre }}
        <hr>
        <b>Docente: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>{{ $datos->docente->nombres }} {{ $datos->docente->apellido_paterno }} {{ $datos->docente->apellido_materno }}
        <hr>
        <b>Curso: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>{{ $datos->inscripcion->gestion }} A&ntilde;o
        <b>Turno: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>{{ $datos->turno->descripcion }}
        <b>Fecha: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>{{ date("Y/m/d") }}
        <hr>
        <b>Parelelo: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>{{ $datos->paralelo }}
        <b>Gestion: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>{{ $datos->anio_vigente }}

        <table class="datos">
            <tr>
                <td>No.</td>
                <td colspan="3">APELLIDOS Y NOMBRES</td>
                <td>ASISTENCIA</td>
                <td>TRABAJOS PRACTICOS</td>
                <td>EXAMEN PARCIAL</td>
                <td>EXAMEN FINAL</td>
                <td>PUNTOS GANADOS</td>
                <td>BIM</td>
            </tr>
            @foreach ($alumnos as $key => $a)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td style="text-align: left;">{{ $a->apellido_paterno }}</td>
                    <td style="text-align: left;">{{ $a->apellido_materno }}</td>
                    <td style="text-align: left; width: 120px;">{{ $a->nombres }}</td>
                    <td>{{ intval($a->nota_asistencia) }}</td>
                    <td>{{ intval($a->nota_practicas) }}</td>
                    <td>{{ intval($a->nota_primer_parcial) }}</td>
                    <td>{{ intval($a->nota_examen_final) }}</td>
                    <td>{{ intval($a->nota_puntos_ganados) }}</td>
                    <td>{{ intval($a->nota_total) }}</td>
                </tr>    
            @endforeach

        </table>

        
    </main>


</body>
</html>