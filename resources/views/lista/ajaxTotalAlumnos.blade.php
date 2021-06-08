<div class="card">
    <div class="card-body">
        <h4 class="card-title">RESULTADO DE BUSQUEDA</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped no-wrap">
                <thead class="text-center">
                    <tr>
                        <th>Detalle</th>
                        <th>Incritos</th>
                        <th>Aband. Temp.</th>
                        <th>Abandonos</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalGeneralVigentes = 0;
                        $totalGeneralAbandonos = 0;
                        $totalGeneralAbandonosTemporales = 0;
                    @endphp
                    @foreach($carreras as $carrera)
                        @php
                            $totalCarreraVigentes = 0;
                            $totalCarreraAbandonosTemporales = 0;
                            $totalCarreraAbandonos = 0;
                        @endphp
                        <tr>
                            <th colspan="7" class="text-info">CARRERA: {{ strtoupper($carrera->nombre) }}</th>
                        </tr>
                        @for($i = 1; $i <= $carrera->duracion_anios; $i++)
                            @php
                                switch ($i) {
                                    case 1:
                                        $gestion = 'PRIMER AÑO';
                                        break;
                                    case 2:
                                        $gestion = 'SEGUNDO AÑO';
                                        break;
                                    case 3:
                                        $gestion = 'TERCER AÑO';
                                        break;
                                    case 4:
                                        $gestion = 'CUARTO AÑO';
                                        break;
                                    case 5:
                                        $gestion = 'QUINTO AÑO';
                                        break;
                                    default:
                                        $gestion = 'AÑO INDEFINIDO';
                                }
                                $totalGestionVigentes = 0;
                                $totalGestionAbandonos = 0;
                                $totalGestionAbandonosTemporales = 0;
                            @endphp
                            <tr>
                                <th colspan="7">{{ $gestion }}</th>
                            </tr>
                            @foreach($turnos as $turno)
                                @php

                                    $inscritos = App\CarrerasPersona::where('carrera_id', $carrera->id)
                                                                ->where('turno_id', $turno->id)
                                                                ->where('gestion', $i)
                                                                ->where('anio_vigente', $anio_vigente)
                                                                ->count();

                                    $abandonosTemporales = App\CarrerasPersona::where('carrera_id', $carrera->id)
                                                                        ->where('turno_id', $turno->id)
                                                                        ->where('gestion', $i)
                                                                        ->where('anio_vigente', $anio_vigente)
                                                                        ->where('estado', 'ABANDONO TEMPORAL')
                                                                        ->count();

                                    $abandonos = App\CarrerasPersona::where('carrera_id', $carrera->id)
                                                                        ->where('turno_id', $turno->id)
                                                                        ->where('gestion', $i)
                                                                        ->where('anio_vigente', $anio_vigente)
                                                                        ->where('estado', 'ABANDONO')
                                                                        ->count();

                                    $totalGestionVigentes   += $inscritos;
                                    $totalGestionAbandonosTemporales += $abandonosTemporales;
                                    $totalGestionAbandonos += $abandonos;

                                @endphp
                                <tr>
                                    <td>{{ strtoupper($turno->descripcion) }}</td>
                                    <td class="text-center">{{ $inscritos }}</td>
                                    <td class="text-center">{{ $abandonosTemporales }}</td>
                                    <td class="text-center">{{ $abandonos }}</td>
                                    <td class="text-right">{{ ($inscritos + $abandonosTemporales + $abandonos) }}</td>
                                </tr>
                            @endforeach
                            @php
                                $totalCarreraVigentes   = $totalCarreraVigentes + $totalGestionVigentes;
                                $totalCarreraAbandonos += $totalGestionAbandonos;
                                $totalCarreraAbandonosTemporales  += $totalGestionAbandonosTemporales;
                            @endphp
                            <tr>
                                <th>TOTAL {{ $gestion }}</th>
                                <th class="text-center">{{ $totalGestionVigentes }}</th>
                                <th class="text-center">{{ $totalGestionAbandonosTemporales }}</th>
                                <th class="text-center">{{ $totalGestionAbandonos }}</th>
                                <th class="text-right">{{ ($totalGestionVigentes + $totalGestionAbandonosTemporales + $totalGestionAbandonos) }}</th>
                            </tr>
                        @endfor
                        @php
                            $totalGeneralVigentes = $totalGeneralVigentes + $totalCarreraVigentes;
                            $totalGeneralAbandonos += $totalCarreraAbandonos;
                            $totalGeneralAbandonosTemporales += + $totalCarreraAbandonosTemporales;
                        @endphp
                        <tr>
                            <th>TOTAL {{ strtoupper($carrera->nombre) }}</th>
                            <th class="text-center">{{ $totalCarreraVigentes }}</th>
                            <th class="text-center">{{ $totalCarreraAbandonos }}</th>
                            <th class="text-center">{{ $totalCarreraAbandonosTemporales }}</th>
                            <th class="text-right">{{ ($totalCarreraVigentes + $totalCarreraAbandonosTemporales + $totalCarreraAbandonos) }}</th>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>