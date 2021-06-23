<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Boletin de Calificaciones</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }
 
        body {
            margin: 4cm 2cm 2cm;
        }
 
        header {
            position: fixed;
            top: 0cm;
            left: 2cm;
            right: 2cm;
            height: 4cm;
            background-color: #ffffff;
            color: black;
            text-align: center;
            line-height: 30px;
        }
 
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #ffffff;
            color: black;
            text-align: center;
            line-height: 35px;
        }

        .bordes {
            border: #24486C 1px solid;
            border-collapse: collapse;
        }

        .celdabg {
            /* background-color: #E1ECF4; */
            background-color: #ffffff;
        }

    </style>
    <!-- <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet"> -->
</head>
<body>
    
    <header>
                <button onclick="ExportExcel('xlsx')">EXCEL</button>

        <br>
        <table style="width:100%" id="datos">
            <tr>
                <!-- <td style="width:35%; text-align:right; background-color: #ffe100;"> -->
                <td  style="width:65%; text-align:center;">
                    <p style="font-family: 'Times New Roman', Times, serif; font-size:20px; line-height:1%">
                        INSTITUTO TECNICO "EF-GIPET" S.R.L.
                    </p>
                    <p style="font-family: 'Times New Roman', Times, serif; font-size:9px; line-height:1%">
                        R.M. N° 889/2012 | R.M. N° 210/2014 | R.A. Nº 039/2018 | R.M. N° 0268/2019 | R.A Nº 379/2019
                    </p>
                </td>
            </tr>
        </table> 
    </header>

    <main>
        <p style="font-family: 'Times New Roman', Times, serif; font-size:24px; text-align:center;">
            CERTIFICADO DE CALIFICACIONES
        </p>
        <table class="bordess" style="width:100%; font-family: 'Times New Roman', Times, serif; font-size:14px; text-align:center">
            <tr style="border: 1px solid black; border-collapse: collapse">
                <td style="width:50%;"><u>{{ $persona->apellido_paterno }}</u></td>
                <td style="width:50%;"><u>{{ $persona->apellido_materno }}</u></td>
                <td style="width:50%;"><u>{{ $persona->nombres }}</u></td>
                <td style="width:50%;"><u>{{ $persona->cedula }} {{ $expedido }}</u></td>
            </tr>
            <tr style="border: 1px solid black; border-collapse: collapse">
                <td class="celdabg" style="width:50%;"><strong>Apellido Paterno</strong></td>
                <td class="celdabg" style="width:50%;"><strong>Apellido Materno</strong></td>
                <td class="celdabg" style="width:50%;"><strong>Nombres</strong></td>
                <td class="celdabg" style="width:50%;"><strong>N° Carnet</strong></td>
            </tr>
        </table>
        <br>
        @php
            $detalle = App\Inscripcione::where('carrera_id', $registro->carrera_id)
                                        ->where('persona_id', $registro->persona_id)
                                        ->where('turno_id', $registro->turno_id)
                                        ->where('anio_vigente', $registro->anio_vigente)        //anio_vigente
                                        ->first();
        @endphp
        <table class="bordess" style="width:100%; font-family: 'Times New Roman', Times, serif; font-size:14px; text-align:center">
            <tr style="border: 1px solid black; border-collapse: collapse">
                <td class="celdabg" style="width:50%;"><strong>Carrera: </strong></td>
                <td style="width:50%;" nowrap>{{ $carrera->nombre }}</td>
                <td class="celdabg" style="width:50%;"><strong>Nivel: </strong></td>
                <td style="width:50%;" nowrap>{{ $carrera->nivel }}</td>
                <td class="celdabg" style="width:50%;"><strong>Curso: </strong></td>
                <td style="width:50%;" nowrap>{{ $detalle ? $detalle->gestion : 'N/T' }}° A&ntilde;o</td>
            </tr>
        </table>
        <br>
        
        <br>

        <table cellpadding="5" class="bordes" style="width:100%; font-family: 'Times New Roman', Times, serif; font-size:10px; text-align:center">
            <tr style="border: 1px solid black; border-collapse: collapse; background-color: #e5e5e5;">
                <th nowrap>CODIGO</th>
                <th nowrap>ASIGNATURA</th>
                <th nowrap>NUMERAL</th>
                <th nowrap>LITERAL</th>
                <th nowrap>OBSERVACIONES</th>
            </tr>
            @foreach($inscripciones as $inscripcion)
                @php
                    $notas = App\Nota::where('inscripcion_id', $inscripcion->id)
                                    ->get();
                    $notaUno = App\Nota::where('inscripcion_id', $inscripcion->id)
                                    ->where('trimestre', '1')
                                    ->first();
                    $notaDos = App\Nota::where('inscripcion_id', $inscripcion->id)
                                    ->where('trimestre', '2')
                                    ->first();
                    $notaTres = App\Nota::where('inscripcion_id', $inscripcion->id)
                                    ->where('trimestre', '3')
                                    ->first();
                    $notaCuatro = App\Nota::where('inscripcion_id', $inscripcion->id)
                                    ->where('trimestre', '4')
                                    ->first();
                @endphp
                <tr>
                    <td nowrap>{{ $inscripcion->asignatura->sigla }}</td>
                    <td style="text-align:left" nowrap>{{ $inscripcion->asignatura->nombre }}</td>
                    <td>{{ $inscripcion->nota ? round($inscripcion->nota) : '0' }}</td>
                    <td style="text-align: left;">
                        @php
                            $formatter = new App\librerias\NumeroALetras();
                            echo $formatter->toString($inscripcion->nota, 0);
                        @endphp
                    </td>
                    <td></td>
                </tr>
            @endforeach
        </table>

        <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        @php
            $dia = date('l');
            switch ($dia) {
                case 'Monday':
                    $dia = 'Lunes';
                    break;
                case 'Tuesday':
                    $dia = 'Martes';
                    break;
                case 'Wednesday':
                    $dia = 'Miercoles';
                    break;
                case 'Thursday':
                    $dia = 'Jueves';
                    break;
                case 'Friday':
                    $dia = 'Viernes';
                    break;
                case 'Saturday':
                    $dia = 'Sabado';
                    break;
                case 'Sunday':
                    $dia = 'Domingo';
                    break;
            }
            $mes = date('m');
            switch ($mes) {
                case 1:
                    $mes = 'Enero';
                    break;
                case 2:
                    $mes = 'Febrero';
                    break;
                case 3:
                    $mes = 'Marzo';
                    break;
                case 4:
                    $mes = 'Abril';
                    break;
                case 5:
                    $mes = 'Mayo';
                    break;
                case 6:
                    $mes = 'Junio';
                    break;
                case 7:
                    $mes = 'Julio';
                    break;
                case 8:
                    $mes = 'Agosto';
                    break;
                case 9:
                    $mes = 'Septiembre';
                    break;
                case 10:
                    $mes = 'Octubre';
                    break;
                case 11:
                    $mes = 'Noviembre';
                    break;
                case 12:
                    $mes = 'Diciembre';
                    break;
            }
        @endphp
        Lugar y fecha: La Paz - {{ $dia }}, {{ date('d') }} de {{ $mes }} de {{ date('Y') }}.
        </p>
        
        <br><br><br><br>

        <table style="width:100%; font-family: 'Times New Roman', Times, serif; font-size:14px; text-align:center">
            <tr>
                <td>
                    <img style="height:150px; width:250px" src="../public/assets/imagenes/firmara.png">
                </td>
                <td>
                    <img style="height:150px; width:250px" src="../public/assets/imagenes/firmajm.png">
                </td>
            </tr>
            <tr>
                <td colspan="2">ALUMNO(A)</td>
            </tr>
        </table>

    </main>

    <!-- <footer>        
        <p style="font: normal 10px/150% Times New Roman, Times, serif; text-align:center; line-height:130%">
            www.opp.gob.bo <br>
            Av. Mariscal Santa Cruz, Esq. Calle Oruro, Edif. Centro de Comunicaciones La Paz, 4to. piso <br>
            Telefonos: (591) -2- 2119999-2156600
        </p>
    </footer> -->
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<script type="text/javascript">

    function ExportExcel(type, fn, dl) {
       var elt = document.getElementById('datos');
       var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
       return dl ?
          XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
          XLSX.writeFile(wb, fn || ('Alumnos.' + (type || 'xlsx')));
    }
</script>
</body>
</html>