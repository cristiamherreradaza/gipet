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
        }
 
        body {
            margin: 2cm 1cm 1cm;
            font-family: Arial, Helvetica, sans-serif;
        }
 
        header {
            position: fixed;
            top: 1cm;
            left: 2cm;
            right: 2cm;
            height: 1cm;
            background-color: #ffffff;
            color: black;
            text-align: center;
            line-height: 30px;
        }
 
        footer {
            position: fixed;
            bottom: 1cm;
            left: 1cm;
            right: 1cm;
            height: 0cm;
            background-color: #fff;
            color: black;
            text-align: center;
            line-height: 35px;
        }

        .bordes {
            /* border: #24486C 1px solid; */
            border: 1px solid;
            border-collapse: collapse;
        }
        
        table.celdas {
            width: 100%;
            background-color: #fff;
            /* border: 1px solid; */
            border-collapse: collapse;
        }

        .celdas th {
            height: 10px;
            background-color: #E0E0E0;
            /* color: #fff; */
        }

        .celdas td {
            height: 12px;
        }
        
        .celdas th, .celdas td {
            border: 1px solid black;
            padding: 2px;
            text-align: center;
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
        <table style="width:100%">
            <tr>
                <td style="width:65%; text-align:center;">
                    <p style="font-size:20px; line-height:1%">
                        <strong>HISTORIAL ACAD&Eacute;MICO</strong>
                    </p>
                </td>
            </tr>
        </table> 
    </header>
    <main>
        <table style="width:100%; font-size:12px;">
            <tr>
                <td><strong>INSTITUTO:</strong></td>
                <td>INSTITUTO TÉCNICO EF-GIPET S.R.L.</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                @php
                    $anioInicial    = App\CarrerasPersona::where('carrera_id', $carrera->id)
                                                        ->where('persona_id', $persona->id)
                                                        ->min('anio_vigente');
                                                        // dd($anioInicial);
                    if($anioInicial)
                    {
                        $fechaAdmision = App\InicioGestion::where('anio_vigente',$anioInicial)
                                                            ->first();
                                                            // dd($fechaAdmision);
                        // $fechaAdmision  = App\CarrerasPersona::where('carrera_id', $carrera->id)
                        //                                     ->where('persona_id', $persona->id)
                        //                                     ->where('anio_vigente', $anioInicial)
                        //                                     ->first();
                        if($fechaAdmision->inicio)
                        {
                            $fechaAdmision = date('d/m/Y',strtotime($fechaAdmision->inicio));
                            // $dia    = date("d", strtotime($fechaAdmision->fecha_inscripcion));
                            // $mes    = date("m", strtotime($fechaAdmision->fecha_inscripcion));
                            // $anio   = date("Y", strtotime($fechaAdmision->fecha_inscripcion));
                            // $fechaAdmision  = $dia.'/'.$mes.'/'.$anio;
                        }
                        else
                        {
                            $fechaAdmision = '-/-/-';
                        }
                    }
                    else
                    {
                        $fechaAdmision = '-/-/-';
                    }

                    // Para el anio final

                    $anioFinal    = App\CarrerasPersona::where('carrera_id', $carrera->id)
                                                        ->where('persona_id', $persona->id)
                                                        ->max('anio_vigente');
                                                        // dd($anioFinal);
                    if($anioFinal)
                    {
                        $fechaAdmisionFinal = App\InicioGestion::where('anio_vigente',$anioFinal)
                                                            ->first();
                                                            // dd($fechaAdmisionFinal);
                        if($fechaAdmisionFinal->fin)
                        {
                            $fechaAdmisionFinal = date('d/m/Y',strtotime($fechaAdmisionFinal->fin));
                        }
                        else
                        {
                            $fechaAdmisionFinal = '-/-/-';
                        }
                    }
                    else
                    {
                        $fechaAdmisionFinal = '-/-/-';
                    }
                @endphp
                <td><strong>CARRERA:</strong></td>
                <td>{{ strtoupper($carrera->nombre) }}</td>
                <td><strong>FECHA DE ADMISION:</strong></td>
                <td>{{ $fechaAdmision }}</td>
            </tr>
            <tr>
                <td><strong>NIVEL DE FORMACION:</strong></td>
                <td>{{ strtoupper($carrera->nivel) }}</td>
                <td><strong>FECHA DE CONCLUSION:</strong></td>
                {{-- <td>{{ date('d') }}/{{ date('m') }}/{{ date('Y') }}</td> --}}
                <td>{{ $fechaAdmisionFinal }}</td>
            </tr>
            <tr>
                <td><strong>REGIMEN:</strong></td>
                <td>ANUAL</td>
                <td><strong>MATRICULA</strong></td>
                <td></td>
            </tr>
            <tr>
                <td><strong>ESTUDIANTE:</strong></td>
                <td>{{ strtoupper($persona->apellido_paterno) }} {{ strtoupper($persona->apellido_materno) }} {{ strtoupper($persona->nombres) }}</td>
                <td><strong>CEDULA DE IDENTIDAD:</strong></td>
                <td>{{ strtoupper($persona->cedula) }} {{ $expedido }}</td>
            </tr>
        </table>
        <br>
        <table cellpadding="1" class="celdas" style="font-size:9px; text-align:center">
            <tr>
                <th>N°</th>
                <th>GESTION ACADEMICA</th>
                <th>SEMESTRE / A&Ntilde;O</th>
                <th>CODIGO</th>
                <th>ASIGNATURA</th>
                <th>REQUISITOS</th>
                <th>NOTA</th>
                <th>PRUEBA RECUP</th>
                <th>OBSERVACIONES</th>
                <th>No. FOLIO</th>
                <th>No. LIBRO</th>
                <!-- <th>N° DE LIBRO</th>
                <th>N° DE FOLIO</th> -->
            </tr>
            @php
                // dd($cantidadAprobados);
                $contadorMateriasAprobadas = 0;
            @endphp
            @foreach($inscripciones as $key => $inscripcion)
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>{{ $inscripcion->anio_vigente }}</td>
                    <td>
                        @switch($inscripcion->gestion)
                            @case(1)
                                PRIMERO
                                @break
                            @case(2)
                                SEGUNDO
                                @break
                            @case(3)
                                TERCERO
                                @break
                            @case(4)
                                CUARTO
                                @break
                            @case(5)
                                QUINTO
                                @break
                        @endswitch
                    </td>
                    <td nowrap>{{ $inscripcion->asignatura->sigla }}</td>
                    <td style="text-align:left" nowrap>{{ $inscripcion->asignatura->nombre }}</td>
                    <td>
                        @php
                            // dd($inscripcion);
                            // dd($inscripcion);
                            $prerequisito = App\Prerequisito::where('asignatura_id', $inscripcion->asignatura_id)
                                                            // ->where('anio_vigente', $inscripcion->anio_vigente)
                                                            ->first();
                            // dd($prerequisito);
                        @endphp
                        @if($prerequisito && $prerequisito->prerequisito_id != null)
                            {{ $prerequisito->prerequisito->sigla }}
                        @else
                            NINGUNO
                        @endif
                    </td>
                    <td>{{ $inscripcion->nota ? round($inscripcion->nota) : '0' }}</td>
                    <td>{{ $inscripcion->segundo_turno ? round($inscripcion->segundo_turno) : '' }}</td>
                    <td>
                        @php
                            $carreraPersona = App\CarrerasPersona::where('persona_id', $inscripcion->persona_id)
                                                                ->where('anio_vigente', $inscripcion->anio_vigente)
                                                                ->where('carrera_id', $inscripcion->carrera_id)
                                                                ->where('turno_id', $inscripcion->turno_id)
                                                                ->where('paralelo', $inscripcion->paralelo)
                                                                ->where('gestion', $inscripcion->gestion)
                                                                ->first();
                            // echo $carreraPersona;
                            if($carreraPersona){
                                echo $carreraPersona->estado;
                                if($carreraPersona->estado == "APROBO"){
                                    $contadorMateriasAprobadas++;
                                }
                            }
                        @endphp
                        {{-- {{ ($carreraPersona->estado)? $carreraPersona->estado:'' }} --}}
                    </td>
                    <td></td>
                    <td></td>
                    <!-- <td></td>
                    <td></td> -->
                </tr>
            @endforeach
        </table>

        <p style="font-size: 9pt;">
            @php
                $hoy = date('Y-m-d');
                $utilidades = new App\librerias\Utilidades();
                $fechaEs = $utilidades->fechaCastellano($hoy);
            @endphp
            <strong>Lugar y fecha: </strong> La Paz - {{ $fechaEs }}.
        </p>
        <br><br><br><br>
        <table style="width:100%;">
            <tr>
                <td style="text-align:center; font-size:14px;">
                    <strong>Firma Autoridad Academica</strong>
                </td>
            </tr>
        </table>
        <br>
        <table style="width:100%;">
            <tr>
                <td style="width:30%;">
                    <table class="celdas" style="width:100%; text-align:center; font-size:10px; line-height:100%">
                        <tr>
                            <td colspan="2">ESCALA DE VALORACION</td>
                        </tr>
                        <tr>
                            <td style="width:50%;">61 - 100</td>
                            <td style="width:50%;">APROBADO</td>
                        </tr>
                        <tr>
                            <td>0 - 60</td>
                            <td>REPROBADO</td>
                        </tr>
                        <tr>
                            <td>61</td>
                            <td>NOTA MINIMA</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align:center; vertical-align:bottom; font-size:14px;">
                    Sello de la Instituci&oacute;n
                </td>
                <td style="width:30%;">
                    <table class="celdas" style="width:100%; text-align:center; font-size:10px; line-height:100%">
                        <tr>
                            <td style="width:50%;">Carga Horaria</td>
                            {{-- <td style="width:50%;">{{ $cargaHoraria }}</td> --}}
                            <td style="width:50%;">3600</td>
                        </tr>
                        <tr>
                            <td>Asignaturas Aprobadas</td>
                            <td>{{ $contadorMateriasAprobadas }} / {{ $cantidadCurricula }}</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Promedio de Calificaciones</td>
                            <td rowspan="2">{{ round($promedioCalificaciones, 0) }}</td>
                        </tr>

                    </table>
                </td>
            </tr>
            
            <tr>
                <td style="width:30%;">
                    <table class="celdas" style="width:100%; text-align:center; font-size:10px; line-height:100%">
                        <tr>
                            <td colspan="3">PLAN DE ESTUDIOS</td>
                        </tr>
                        @foreach($gestionesInscritas as $gestion)
                            @php
                                // dd($persona->id." < - > ".$carrera->id." < - > ".$gestion->anio_vigente);
                                $resolucion = App\Inscripcione::where('persona_id',$persona->id)
                                                            ->where('carrera_id',$carrera->id)
                                                            ->where('anio_vigente',$gestion->anio_vigente)
                                                            ->first();

                                // dd($resolucion);
                                // echo $gestion;
                                // $resolucion = App\Resolucione::where('anio_vigente', $gestion->anio_vigente)
                                //                             ->orderBy('anio_vigente','desc')
                                //                             ->first();
                                                            // dd($resolucion);

                                // if(!$resolucion)
                                // {
                                //     for($i=1; $i<=10; $i++)
                                //     {
                                //         $anioIngreso    = $anioIngreso - 1;
                                //         $resolucion     = App\Resolucione::where('anio_vigente', $anioIngreso)
                                //                             ->first();
                                //         if($resolucion)
                                //         {
                                //             break;
                                //         }
                                //     }
                                // }
                            @endphp
                            <tr>
                                <td style="width:30%;">R. M.</td>
                                <td style="width:35%;">{{ $resolucion->resolucion->resolucion }}</td>
                                <td style="width:35%;">{{ $gestion->anio_vigente }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
                <td style="text-align:center; font-size:14px;">
                    
                </td>
                <td style="width:30%;">
                    
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid; border-collapse: collapse; width:100%; text-align:center; font-size:12px; line-height:100%">
                    Cualquier raspadura o enmienda invalida el presente documento
                </td>
            </tr>
        </table>

    </main>

    <!-- <footer>
        <table style="width:100%;">
            <tr>
                <td style="text-align:center; font-size:14px;">
                    <strong>Firma Autoridad Academica</strong>
                </td>
            </tr>
        </table>
        <table style="width:100%;">
            <tr>
                <td style="width:30%;">
                    <table cellpadding="1" border="1px" style="width:100%; text-align:center; font-size:12px; line-height:100%">
                        <tr>
                            <td colspan="2">ESCALA DE VALORACION</td>
                        </tr>
                        <tr>
                            <td style="width:50%;">61 - 100</td>
                            <td style="width:50%;">APROBADO</td>
                        </tr>
                        <tr>
                            <td>0 - 60</td>
                            <td>REPROBADO</td>
                        </tr>
                        <tr>
                            <td>61</td>
                            <td>NOTA MINIMA</td>
                        </tr>
                    </table>
                </td>
                <td style="text-align:center; font-size:14px;">
                    Sello del Instituto
                </td>
                <td style="width:30%;">
                    <table cellpadding="1" border="1px" style="width:100%; text-align:center; font-size:12px; line-height:100%">
                        <tr>
                            <td style="width:50%;">Carga Horaria</td>
                            <td style="width:50%;">3620</td>
                        </tr>
                        <tr>
                            <td>Asignaturas Aprobadas</td>
                            <td>17 / 17</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Promedio de Calificaciones</td>
                            <td rowspan="2">75</td>
                        </tr>

                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: 1px solid; border-collapse: collapse; width:100%; text-align:center; font-size:12px; line-height:100%">
                    Cualquier raspadura o enmienda invalida el presente documento
                </td>
            </tr>
        </table>
    </footer> -->

</body>
</html>