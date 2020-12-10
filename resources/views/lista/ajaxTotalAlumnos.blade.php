<div class="card">
    <div class="card-body">
        <h4 class="card-title">RESULTADO DE BUSQUEDA</h4>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-danger" onclick="reportePdfTotalAlumnos()">
                    <i class="fas fa-file-pdf">&nbsp; PDF</i>
                </button>
                
                <!-- <button class="btn btn-success" onclick="reporteExcelAlumnos()">
                    <i class="fas fa-file-excel">&nbsp; EXCEL</i>
                </button> -->
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped no-wrap">
                <thead class="text-center">
                    <tr>
                        <th>Detalle</th>
                        <th>Vigentes</th>
                        <th>Temporales</th>
                        <th>Nuevos</th>
                        <th>Abandonos</th>
                        <th>Subtotal</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalGeneralVigentes = 0;
                        $totalGeneralTemporales = 0;
                        $totalGeneralAbandonos = 0;
                    @endphp
                    @foreach($carreras as $carrera)
                        @php
                            $totalCarreraVigentes = 0;
                            $totalCarreraTemporales = 0;
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
                                $totalGestionTemporales = 0;
                                $totalGestionAbandonos = 0;
                            @endphp
                            <tr>
                                <th colspan="7">{{ $gestion }}</th>
                            </tr>
                            @foreach($turnos as $turno)
                                @php
                                    $vigentes   = App\CarrerasPersona::where('carrera_id', $carrera->id)
                                                                ->where('turno_id', $turno->id)
                                                                ->where('gestion', $i)
                                                                ->where('anio_vigente', date('Y'))
                                                                ->where('vigencia', 'Vigente')
                                                                ->count();
                                    $temporales = App\CarrerasPersona::where('carrera_id', $carrera->id)
                                                                ->where('turno_id', $turno->id)
                                                                ->where('gestion', $i)
                                                                ->where('anio_vigente', date('Y'))
                                                                ->where('vigencia', 'Temporal')
                                                                ->count();
                                    $abandonos = App\CarrerasPersona::where('carrera_id', $carrera->id)
                                                                ->where('turno_id', $turno->id)
                                                                ->where('gestion', $i)
                                                                ->where('anio_vigente', date('Y'))
                                                                ->where('vigencia', 'Abandono')
                                                                ->count();
                                    $totalGestionVigentes   = $totalGestionVigentes + $vigentes;
                                    $totalGestionTemporales = $totalGestionTemporales + $temporales;
                                    $totalGestionAbandonos  = $totalGestionAbandonos + $abandonos;
                                @endphp
                                <tr>
                                    <td>{{ strtoupper($turno->descripcion) }}</td>
                                    <td>{{ $vigentes }}</td>
                                    <td>{{ $temporales }}</td>
                                    <td>0</td>
                                    <td>{{ $abandonos }}</td>
                                    <td>{{ ($vigentes + $temporales + $abandonos) }}</td>
                                    <td>{{ ($vigentes + $temporales + $abandonos) }}</td>
                                </tr>
                            @endforeach
                            @php
                                $totalCarreraVigentes   = $totalCarreraVigentes + $totalGestionVigentes;
                                $totalCarreraTemporales = $totalCarreraTemporales + $totalGestionTemporales;
                                $totalCarreraAbandonos  = $totalCarreraAbandonos + $totalGestionAbandonos;
                            @endphp
                            <tr>
                                <th>TOTAL {{ $gestion }}</th>
                                <th>{{ $totalGestionVigentes }}</th>
                                <th>{{ $totalGestionTemporales }}</th>
                                <th>0</th>
                                <th>{{ $totalGestionAbandonos }}</th>
                                <th>{{ ($totalGestionVigentes + $totalGestionTemporales + $totalGestionAbandonos) }}</th>
                                <th>{{ ($totalGestionVigentes + $totalGestionTemporales + $totalGestionAbandonos) }}</th>
                            </tr>
                        @endfor
                        @php
                            $totalGeneralVigentes = $totalGeneralVigentes + $totalCarreraVigentes;
                            $totalGeneralTemporales = $totalGeneralTemporales + $totalCarreraTemporales;
                            $totalGeneralAbandonos = $totalGeneralAbandonos + $totalCarreraAbandonos;
                        @endphp
                        <tr>
                            <th>TOTAL {{ strtoupper($carrera->nombre) }}</th>
                            <th>{{ $totalCarreraVigentes }}</th>
                            <th>{{ $totalCarreraTemporales }}</th>
                            <th>0</th>
                            <th>{{ $totalCarreraAbandonos }}</th>
                            <th>{{ ($totalCarreraVigentes + $totalCarreraTemporales + $totalCarreraAbandonos) }}</th>
                            <th>{{ ($totalCarreraVigentes + $totalCarreraTemporales + $totalCarreraAbandonos) }}</th>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="text-primary">
                        <th>TOTAL GENERAL</th>
                        <th>{{ $totalGeneralVigentes }}</th>
                        <th>{{ $totalGeneralTemporales }}</th>
                        <th>0</th>
                        <th>{{ $totalGeneralAbandonos }}</th>
                        <th>{{ ($totalGeneralVigentes + $totalGeneralTemporales + $totalGeneralAbandonos) }}</th>
                        <th>{{ ($totalGeneralVigentes + $totalGeneralTemporales + $totalGeneralAbandonos) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>