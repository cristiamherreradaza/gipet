<div class="card">
    <div class="card-body">
        <button onclick="ExportExcel('xlsx')">EXCEL</button>
        <div class="table-responsive">
            <table class="table table-bordered table-striped no-wrap" id="listadoTotalesAlumnos">
                <thead class="text-center">
                    <tr>
                        <th>Detalle</th>
                        <th>Incritos</th>
                        <th>Aband. Temp.</th>
                        <th>Abandonos</th>
                        <th>Congelados</th>
                        <th>Vigentes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carreras as $carrera)
                     @php
                        $totalGeneralVigentes = 0;
                        $totalGeneralAbandonos = 0;
                        $totalGeneralCongelados = 0;
                        $totalGeneralAbandonosTemporales = 0;
                        $totalGeneralAbandonaron = 0;
                    @endphp
                        <tr>
                            <th colspan="7" class="text-info">CARRERA: {{ strtoupper($carrera->nombre) }}</th>
                        </tr>
                        @for($i = 1; $i <= $carrera->duracion_anios; $i++)

                        @php
                            $totalCarreraVigentes = 0;
                            $totalCarreraAbandonosTemporales = 0;
                            $totalCarreraAbandonos = 0;
                            $totalCarreraCongelados = 0;
                        @endphp

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
                            @endphp
                            <tr>
                                <th colspan="7">{{ $gestion }}</th>
                            </tr>
                            @foreach($turnos as $turno)
                                @php
                                    $totalGestionVigentes = 0;
                                    $totalGestionAbandonos = 0;
                                    $totalGestionAbandonosTemporales = 0;
                                    $totalGestionCongelados = 0;
                                    $totalGestionAbandonos = 0;
                                    $totalGestionAbandonosFila = 0;

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

                                    $congelados = App\CarrerasPersona::where('carrera_id', $carrera->id)
                                                                        ->where('turno_id', $turno->id)
                                                                        ->where('gestion', $i)
                                                                        ->where('anio_vigente', $anio_vigente)
                                                                        ->where('estado', 'CONGELADO')
                                                                        ->count();

                                    $totalGestionVigentes   += $inscritos;
                                    $totalGestionAbandonosTemporales += $abandonosTemporales;
                                    $totalGestionAbandonos += $abandonos;
                                    $totalGestionCongelados += $congelados;

                                    $totalGestionAbandonosFila = $totalGestionAbandonosTemporales + $totalGestionAbandonos + $totalGestionCongelados;

                                    // calsulamos el total por anio
                                    $totalCarreraVigentes += $totalGestionVigentes;
                                    $totalCarreraAbandonos += $totalGestionAbandonos;
                                    $totalCarreraAbandonosTemporales += $totalGestionAbandonosTemporales;
                                    $totalCarreraCongelados += $totalGestionCongelados;
                                    
                                    $totalCarreraAbandonosGeneral = $totalCarreraAbandonos + $totalGestionAbandonosTemporales + $totalCarreraCongelados;

                                @endphp
                                <tr>
                                    <td>{{ strtoupper($turno->descripcion) }}</td>
                                    <td class="text-center">{{ $inscritos }}</td>
                                    <td class="text-center">{{ $abandonosTemporales }}</td>
                                    <td class="text-center">{{ $abandonos }}</td>
                                    <td class="text-center">{{ $congelados }}</td>
                                    <td class="text-right">{{ $totalGestionVigentes - $totalGestionAbandonosFila }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <th>TOTAL {{ $gestion }}</th>
                                <th class="text-center">{{ $totalCarreraVigentes }}</th>
                                <th class="text-center">{{ $totalCarreraAbandonosTemporales }}</th>
                                <th class="text-center">{{ $totalCarreraAbandonos }}</th>
                                <th class="text-center">{{ $totalCarreraCongelados }}</th>
                                <th class="text-right">{{ ($totalCarreraVigentes - $totalCarreraAbandonosGeneral) }}</th>
                            </tr>

                            @php
                                $totalGeneralVigentes += $totalCarreraVigentes;
                                $totalGeneralAbandonosTemporales += $totalCarreraAbandonosTemporales;
                                $totalGeneralAbandonos += $totalCarreraAbandonos;
                                $totalGeneralCongelados += $totalCarreraCongelados;
                                $totalGeneralAbandonaron = $totalGeneralAbandonosTemporales + $totalGeneralAbandonos + $totalGeneralCongelados;
                            @endphp

                        @endfor
                        <tr>
                            <th>TOTAL {{ strtoupper($carrera->nombre) }}</th>
                            <th class="text-center">{{ $totalGeneralVigentes}}</th>
                            <th class="text-center">{{ $totalGeneralAbandonosTemporales }}</th>
                            <th class="text-center">{{ $totalGeneralAbandonos }}</th>
                            <th class="text-center">{{ $totalGeneralCongelados }}</th>
                            <th class="text-right">{{ $totalGeneralVigentes - $totalGeneralAbandonaron }}</th>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>

        </div>
    </div>
</div>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<script type="text/javascript">

    function ExportExcel(type, fn, dl) {
       var elt = document.getElementById('listadoTotalesAlumnos');
       var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
       return dl ?
          XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
          XLSX.writeFile(wb, fn || ('Alumnos.' + (type || 'xlsx')));
    }
</script>