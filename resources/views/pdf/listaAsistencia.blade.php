<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte</title>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 1cm 1cm 2cm;
            font-size: 6pt;
            font-family: Arial, Helvetica, sans-serif;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 0cm;
            background-color: #ff0000;
            color: black;
            text-align: center;
            line-height: 5px;
        }

        /*body {
            margin: 3cm 2cm 2cm;
        }*/

        footer {
            position: fixed;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 1cm;
            background-color: #fff;
            color: black;
            text-align: center;
            line-height: 35px;
        }

        table.notas {
            /* width: 100%; */
            background-color: #fff;
            /* border: 1px solid; */
            border-collapse: collapse;
        }

        .notas th,
        .notas td {
            border: 1px solid #000000;
            padding: 2px;
            /* text-align: left; */
        }

        .textCentrado{
            text-align: center;
        }
        .celdaVacia{
            padding: 5px;
            height: 10px;
        }
    </style>
</head>

<body>
    <header>

    </header>
    <main>
        <table width="100%">
            <tr>
                <td width="25%"><img src="{{ asset('assets/imagenes/portal_uno_R.png') }}" height="50"></td>
                
                <td width="25%" style="text-align: right;">
                    <span style="font-size: 13px;">
                        INSTITUTO TECNICO "EF-GIPET" S.R.L.
                    </span>
                    <br>
                    <span style="font-size: 8pt;">
                        
                    </span>
                    <span style="font-size: 8pt;">
                        FECHA: {{ date('d/m/Y') }}
                    </span>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="text-align: center; border-top:#000000 solid 1px; border-bottom: #000000 solid 1px;">
                    <span style="font-size: 15pt;">
                        CETRALIZADOR DE ASISTENCIA
                    </span>
                </td>
            </tr>

        </table>
        <table>
            <tbody>
                <tr>
                    <td>BIMESTRE</td>
                    <td>:</td>
                    <td>{{ $bimestre }}º Bimestre</td>
                </tr>
                <tr>
                    <td>ASIGNATURA</td>
                    <td>:</td>
                    <td>{{ $notapropuesta->asignatura->nombre }}</td>
                </tr>
                <tr>
                    <td>CURSO</td>
                    <td>:</td>
                    <td>{{ $notapropuesta->asignatura->gestion }}º Año</td>
                </tr>
                <tr>
                    <td>TURNO</td>
                    <td>:</td>
                    <td>{{ $notapropuesta->turno->descripcion }}</td>
                </tr>
                <tr>
                    <td>PARALELO</td>
                    <td>:</td>
                    <td>( {{ $notapropuesta->paralelo }} )</td>
                </tr>
                <tr>
                    <td>DOCENTE</td>
                    <td>:</td>
                    <td>{{ $notapropuesta->docente->apellido_paterno." ".$notapropuesta->docente->apellido_materno." ".$notapropuesta->docente->nombres }}</td>
                </tr>
            </tbody>
        </table>

        <table class="notas">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th class="textCentrado" width="290px">NOMINA ALUMNOS</th>
                    <th class="textCentrado" width="30px">EST.</th>
                    <th class="textCentrado" width="9px">A</th>
                    <th class="textCentrado" width="9px">Pts.</th>
                    <th class="textCentrado" width="9px">A</th>
                    <th class="textCentrado" width="9px">Pts.</th>
                    <th class="textCentrado" width="9px">A</th>
                    <th class="textCentrado" width="9px">Pts</th>
                    <th class="textCentrado" width="9px">A</th>
                    <th class="textCentrado" width="9px">Pts</th>
                    <th class="textCentrado" width="9px">A</th>
                    <th class="textCentrado" width="9px">Pts</th>
                    <th class="textCentrado" width="9px">A</th>
                    <th class="textCentrado" width="9px">Pts</th>
                    <th class="textCentrado" width="9px">A</th>
                    <th class="textCentrado" width="9px">Pts</th>
                    <th class="textCentrado" width="9px">A</th>
                    <th class="textCentrado" width="9px">Pts</th>
                    <th class="textCentrado" width="9px">A</th>
                    <th class="textCentrado" width="9px">Pts</th>
                    <th class="textCentrado" width="9px">A</th>
                    <th class="textCentrado" width="9px">Pts</th>
                    <th class="textCentrado" width="70px">OBSERV.</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $contador  = 1;
                @endphp
                @foreach ($inscritos as $key => $inscrito )
                    @if ($inscrito->persona)
                        @php
                            $sw = true;
                            $estado_alumno = App\CarrerasPersona::where('carrera_id', $inscrito->carrera_id)
                                                            ->where('persona_id', $inscrito->persona_id)
                                                            ->where('anio_vigente', $inscrito->anio_vigente)
                                                            ->first();
                            if($estado_alumno->estado == 'ABANDONO' || $estado_alumno->estado == 'ABANDONO TEMPORAL' || $estado_alumno->estado == 'CONGELADO'){
                                $sw = false; 
                            }

                        @endphp

                        @if ($sw)
                            <tr>
                                <td>{{ $contador }}</td>
                                <td>{{ $inscrito->persona->apellido_paterno." ".$inscrito->persona->apellido_materno." ".$inscrito->persona->nombres }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            @php
                                $contador++;
                            @endphp
                        @endif
                    @endif
                @endforeach
                @for ($i = 1 ; $i <= 10; $i++)
                    <tr>
                        <td class="celdaVacia"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>    
                @endfor
            </tbody>
        </table>

        <br>
        <table>
            <tbody>
                <tr>
                    <td><b>OBSERVACIONES</b></td>
                    <td><b>:</b></td>
                    <td>El registro de la presencia y/o ausencia de los alumnos se realizara segun las siguientes consideraciones:</td>
                </tr>
                <tr>
                    <td><b>ASISTENCIA</b></td>
                    <td><b>:</b></td>
                    <td>Registrar (A) dentro los 15 Min "Turno Mañana" y "Turno Tarde", 30 Min "Turno Noche"</td>
                </tr>
                <tr>
                    <td><b>FALTA</b></td>
                    <td><b>:</b></td>
                    <td>Registrar (F) Ausencia del alumno</td>
                </tr>
                <tr>
                    <td><b>PERMISO</b></td>
                    <td><b>:</b></td>
                    <td>Registrar (P) por una clase con autorizacion del Docente, mas de un dia, autorizacion con nota academica</td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>