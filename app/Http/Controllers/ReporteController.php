<?php

namespace App\Http\Controllers;

use App\Pago;
use App\Turno;
use App\Factura;
use App\Persona;
use App\CarrerasPersona;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class ReporteController extends Controller
{
    
    public function formularioLibro(Request $request)
    {
        $usuarios = Factura::groupBy('user_id')
                        ->get();

        return view('reporte.formularioLibro')->with(compact('usuarios'));
    }

    public function libroVentas(Request $request)
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_final = $request->input('fecha_final');

        $facturasQ = Factura::orderBy('id', 'asc');

        if($request->input('user_id') != ''){
            $facturasQ->where('user_id', $request->input('user_id'));
        }

        $facturasQ->where('facturado', 'Si')
                ->whereBetween('fecha', [$request->input('fecha_inicio'), $request->input('fecha_final')])
                ->orderBy('numero', 'desc')
                ->get();

        $facturas = $facturasQ->get();

        $pdf = PDF::loadView('pdf.libroVentas', compact('facturas', 'fecha_inicio', 'fecha_final'))
                    ->setPaper('letter');

        return $pdf->stream('LibroVentas.pdf');
    }

    public function libroVentasExcel(Request $request)
    {

    }

    public function formularioReportes()
    {
        $turnos = Turno::all();
        return view('reporte.formularioReportes')->with(compact('turnos'));
    }

    public function pencionesPorPeriodo(Request $request)
    {
        $gestion = $request->input('gestion');
        $turno_id = $request->input('turno_id');
        $anio_vigente = $request->input('anio_vigente');

        $datosTurno = Turno::find($turno_id);

        $carrerasPersonas = CarrerasPersona::where('gestion', $gestion)
                                ->where('turno_id', $turno_id)
                                ->where('carrera_id', 1)
                                ->where('anio_vigente', $anio_vigente)
                                ->get();
        
        $pdf = PDF::loadView('pdf.pencionesPorPeriodo', compact('carrerasPersonas', 'gestion', 'turno_id', 'anio_vigente', 'datosTurno'))
                    ->setPaper('letter', 'landscape');

        return $pdf->stream('pensionesPeriodo.pdf');

    }

    public function pencionesPorCobrar(Request $request)
    {
        $gestion = $request->input('gestion');
        $turno_id = $request->input('turno_id');
        $anio_vigente = $request->input('anio_vigente');

        $datosTurno = Turno::find($turno_id);

        $carrerasPersonas = CarrerasPersona::where('gestion', $gestion)
                                ->where('turno_id', $turno_id)
                                ->where('carrera_id', 1)
                                ->where('anio_vigente', $anio_vigente)
                                ->get();
        
        $pdf = PDF::loadView('pdf.pencionesPorCobrar', compact('carrerasPersonas', 'gestion', 'turno_id', 'anio_vigente', 'datosTurno'))
                    ->setPaper('letter', 'landscape');

        return $pdf->stream('pensionesCobrar.pdf');

    }

    public function totalPorCobrar(Request $request)
    {
        $anio_vigente = $request->input('anio_vigente');

        $pdf = PDF::loadView('pdf.totalPorCobrar', compact('anio_vigente'))
                    ->setPaper('letter', 'landscape');

        return $pdf->stream('totalCobrar.pdf');

    }

    public static function calculaPagosCobrar($carrera_id, $gestion, $mensualidad, $turno_id, $anio_vigente)
    {
        $pago = "";
        $decimoPago = Pago::select(DB::raw('SUM(a_pagar) as total_decimo'))
                            ->where('carrera_id', $carrera_id)
                            ->where('gestion', $gestion)
                            ->where('mensualidad', $mensualidad)
                            ->where('turno_id', $turno_id)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

        $pago = ($decimoPago->total_decimo != null)?$decimoPago->total_decimo:'0.00';
        $pagoFormateado = number_format($pago, 2, '.', ',');
                        
        return $pagoFormateado;
    }

    public static function calculaPagosTurnos($carrera_id, $gestion, $turno_id, $anio_vigente)
    {
        $pago="";
        $decimoPago = Pago::select(DB::raw('SUM(a_pagar) as total_decimo'))
                            ->where('carrera_id', $carrera_id)
                            ->where('gestion', $gestion)
                            ->where('turno_id', $turno_id)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

        $pago = ($decimoPago->total_decimo != null)?$decimoPago->total_decimo:'0.00';
        $pagoFormateado = number_format($pago, 2, '.', ',');
                        
        return $pagoFormateado;
    }

    public static function calculaPagosCuotas($carrera_id, $gestion, $mensualidad, $anio_vigente)
    {
        $pago="";
        $decimoPago = Pago::select(DB::raw('SUM(a_pagar) as total_decimo'))
                            ->where('carrera_id', $carrera_id)
                            ->where('gestion', $gestion)
                            ->where('mensualidad', $mensualidad)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

        $pago = ($decimoPago->total_decimo != null)?$decimoPago->total_decimo:'0.00';
        $pagoFormateado = number_format($pago, 2, '.', ',');
                        
        return $pagoFormateado;
    }

    public static function calculaTotalGestion($carrera_id, $gestion, $anio_vigente)
    {
        $pago="";
        $decimoPago = Pago::select(DB::raw('SUM(a_pagar) as total_decimo'))
                            ->where('carrera_id', $carrera_id)
                            ->where('gestion', $gestion)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

        $pago = ($decimoPago->total_decimo != null)?$decimoPago->total_decimo:'0.00';
        $pagoFormateado = number_format($pago, 2, '.', ',');
                        
        return $pagoFormateado;
    }

    public static function calculaTotalPagosCuotas($carrera_id, $mensualidad, $anio_vigente)
    {
        $pago="";
        $decimoPago = Pago::select(DB::raw('SUM(a_pagar) as total_decimo'))
                            ->where('carrera_id', $carrera_id)
                            ->where('mensualidad', $mensualidad)
                            ->where('importe', 0)
                            ->whereYear('created_at', $anio_vigente)
                            ->first();

        $pago = ($decimoPago->total_decimo != null)?$decimoPago->total_decimo:'0.00';
        $pagoFormateado = number_format($pago, 2, '.', ',');
                        
        return $pagoFormateado;
    }

    public function formularioTotalAlumnosExcel(Request $request)
    {
        return view('reporte.formularioTotalAlumnosExcel');
    }

    public function generaTotalAlumnosExcel(Request $request)
    {
        $personasCarrerasPersona = CarrerasPersona::where('anio_vigente', $request->anio_vigente)
                                                    ->get();

        // generacion del excel
        $fileName = 'total_alumnos.xlsx';
        // return Excel::download(new CertificadoExport($carrera_persona_id), 'certificado.xlsx');
        $spreadsheet = new Spreadsheet();

        // estilos
        $spreadsheet->getActiveSheet()->getStyle("A2:K600")->applyFromArray(
            array(
                'borders' => array(
                    'allBorders' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => array('argb' => '000000')
                    )
                )
            )
        );

        $spreadsheet->getActiveSheet()->setTitle("alumnos");

        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(18);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('j')->setWidth(16);

        // colocando estilos
        $fuenteNegrita = array(
            'font'  => array(
                'bold'  => true,
                // 'color' => array('rgb' => 'FF0000'),
                'size'  => 10,
                'name'  => 'Verdana'
            ));

        $fuenteNegritaTitulo = array(
            'font'  => array(
                'bold'  => true,
                // 'color' => array('rgb' => 'FF0000'),
                'size'  => 14,
                'name'  => 'Verdana'
            ));


        // $spreadsheet->getActiveSheet()->getCell('D1')->setValue('Some text');
        $spreadsheet->getActiveSheet()->getStyle("D1")->applyFromArray($fuenteNegritaTitulo);
        $spreadsheet->getActiveSheet()->getStyle('A2:K2')->applyFromArray($fuenteNegrita);

        // fin de colocar estilos

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('D1', 'LISTADO DE ALUMNOS');
        
        $sheet->setCellValue('A2', 'PATERNO');
        $sheet->setCellValue('B2', 'MATERNO');
        $sheet->setCellValue('C2', 'NOMBRES');
        $sheet->setCellValue('D2', 'CARNET');
        $sheet->setCellValue('E2', 'EMAIL');
        $sheet->setCellValue('F2', 'CELULAR');
        $sheet->setCellValue('G2', 'CARRERA');
        $sheet->setCellValue('H2', 'TURNO');
        $sheet->setCellValue('I2', 'AÑO');
        $sheet->setCellValue('J2', 'PARALELO');
        $sheet->setCellValue('K2', 'GESTION');

        $contadorCeldas = 3;
        foreach ($personasCarrerasPersona as $key => $pcp) {

            $sheet->setCellValue("A$contadorCeldas", $pcp->persona->apellido_paterno);
            $sheet->setCellValue("B$contadorCeldas", $pcp->persona->apellido_paterno);
            $sheet->setCellValue("C$contadorCeldas", $pcp->persona->nombres);
            $sheet->setCellValue("D$contadorCeldas", $pcp->persona->cedula);
            $sheet->setCellValue("E$contadorCeldas", $pcp->persona->email);
            $sheet->setCellValue("F$contadorCeldas", $pcp->persona->numero_celular);
            $sheet->setCellValue("G$contadorCeldas", $pcp->carrera->nombre);
            $sheet->setCellValue("H$contadorCeldas", $pcp->turno->descripcion);
            $sheet->setCellValue("I$contadorCeldas", $pcp->gestion);
            $sheet->setCellValue("J$contadorCeldas", $pcp->paralelo);
            $sheet->setCellValue("K$contadorCeldas", $pcp->anio_vigente);
            // $sheet->setCellValue("H$contadorCeldas", $aLetras->toString($i->nota, 0));
            $contadorCeldas++;
        }
        // $sheet->getRowDimension(1)->setRowHeight(35);


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
        // $writer->save('demo.xlsx');
    
    }

}