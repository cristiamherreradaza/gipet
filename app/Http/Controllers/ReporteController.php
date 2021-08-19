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

        if($request->input('boton') == 'pdf'){

            $pdf = PDF::loadView('pdf.libroVentas', compact('facturas', 'fecha_inicio', 'fecha_final'))
                    ->setPaper('letter');

            return $pdf->stream('LibroVentas.pdf');

        }else{
            // generacion del excel
            $fileName = 'libro_ventas.xlsx';
            // return Excel::download(new CertificadoExport($carrera_persona_id), 'certificado.xlsx');
            $spreadsheet = new Spreadsheet();

            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('H1', "LIBRO DE VENTAS");

            $sheet->setCellValue('A3', "PERIODO $fecha_inicio HASTA $fecha_final");

            $sheet->setCellValue('A5', 'ESPECIFICACION');
            $sheet->setCellValue('B5', 'No');
            $sheet->setCellValue('C5', 'FECHA DE LA FACTURA');
            $sheet->setCellValue('D5', 'No DE LA FACTURA');
            $sheet->setCellValue('E5', 'No DE AUTORIZACION');
            $sheet->setCellValue('F5', 'ESTADO');
            $sheet->setCellValue('G5', 'NIT/CI CLIENTE');
            $sheet->setCellValue('H5', 'NOMBRE O RAZON SOCIAL');
            $sheet->setCellValue('I5', 'IMPORTE DE LA VENTA');
            $sheet->setCellValue('J5', 'IMPORTE ICE/IEHD/TASAS');
            $sheet->setCellValue('K5', 'EXPORTACIONES Y OPERACIONES EXENTAS');
            $sheet->setCellValue('L5', 'VENTAS GRAVADAS A TASA CERO');
            $sheet->setCellValue('M5', 'SUBTOTAL');
            $sheet->setCellValue('N5', 'DESCUENTOS, BONIFICACIONES Y REBAJAS OTORGADAS');
            $sheet->setCellValue('O5', 'IMPORTE BASE PARA DEBITO FISCAL');
            $sheet->setCellValue('P5', 'DEBITO FISCAL');
            $sheet->setCellValue('Q5', 'CODIGO CONTROL');

            $contadorFilas = 6;

            foreach($facturas as $key => $f)
            {
                if($f->estado == null){
                    $estadoFactura = 'V: VALIDA';
                }else{
                    $estadoFactura = 'V: ANULADO';
                }

                // para sacar el debito fiscal
                $debito = $f->total * 0.13;

                $sheet->setCellValue("A$contadorFilas", 3);
                $sheet->setCellValue("B$contadorFilas", ++$key);
                $sheet->setCellValue("C$contadorFilas", $f->fecha);
                $sheet->setCellValue("D$contadorFilas", $f->numero);
                $sheet->setCellValue("E$contadorFilas", $f->parametro->numero_autorizacion);
                $sheet->setCellValue("F$contadorFilas", $estadoFactura);
                $sheet->setCellValue("G$contadorFilas", $f->nit);
                $sheet->setCellValue("H$contadorFilas", $f->razon_social);
                $sheet->setCellValue("I$contadorFilas", $f->total);
                $sheet->setCellValue("J$contadorFilas", 0);
                $sheet->setCellValue("K$contadorFilas", 0);
                $sheet->setCellValue("L$contadorFilas", 0);
                $sheet->setCellValue("M$contadorFilas", $f->total);
                $sheet->setCellValue("N$contadorFilas", 0);
                $sheet->setCellValue("O$contadorFilas", $f->total);
                $sheet->setCellValue("P$contadorFilas", $debito);
                $sheet->setCellValue("Q$contadorFilas", $f->codigo_control);

                $contadorFilas++;
            }

            // estilos para el borde de las celdas
            $finalCeldas = $contadorFilas-1;
            $spreadsheet->getActiveSheet()->getStyle("A5:Q$finalCeldas")->applyFromArray(
                array(
                    'borders' => array(
                        'allBorders' => array(
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => array('argb' => '000000')
                        )
                    )
                )
            );

            // estilo para ajustar el contenido de las celdas
            $spreadsheet->getActiveSheet()->getStyle('A5:Q5')->getAlignment()->setWrapText(true);

            // damos el ancho a las celdas
            $contadorLetras = 68; //comenzamos a partir de la letra D
            for ($i=1; $i<=18; $i++) {
                // extraemos la letra para la celda
                $letra = chr($contadorLetras);

                $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setWidth(20);

                $contadorLetras++;
            }
            
           

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
            $writer->save('php://output');
        }

    }

    public function libroVentasExcel(Request $request)
    {
        // dd($request->all());
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

        return $pdf->download('LibroVentas.pdf');
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
        $spreadsheet->getActiveSheet()->setTitle("alumnos");

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(14);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(26);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(16);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        // $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(14);
        // $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(14);
        // $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(14);
        // $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(14);

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
        $spreadsheet->getActiveSheet()->getStyle("F1")->applyFromArray($fuenteNegritaTitulo);

        // estilos para las cabeceras con negrita
        $spreadsheet->getActiveSheet()->getStyle('A2:P2')->applyFromArray($fuenteNegrita);

        // fin de colocar estilos
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('F1', 'LISTADO DE ALUMNOS');
        
        $sheet->setCellValue('A2', 'PATERNO');
        $sheet->setCellValue('B2', 'MATERNO');
        $sheet->setCellValue('C2', 'NOMBRES');
        $sheet->setCellValue('D2', 'CARNET');
        $sheet->setCellValue('E2', 'EXPEDIDO');
        $sheet->setCellValue('F2', 'EMAIL');
        $sheet->setCellValue('G2', 'CELULAR');
        $sheet->setCellValue('H2', 'GENERO');
        $sheet->setCellValue('I2', 'DIRECCION');
        $sheet->setCellValue('J2', 'FECHA NAC');
        $sheet->setCellValue('K2', 'CARRERA');
        $sheet->setCellValue('L2', 'TURNO');
        $sheet->setCellValue('M2', 'AÑO');
        $sheet->setCellValue('N2', 'PARALELO');
        $sheet->setCellValue('O2', 'GESTION');
        $sheet->setCellValue('P2', 'ESTADO');

        $contadorCeldas = 3;
        foreach ($personasCarrerasPersona as $key => $pcp) {

            $sheet->setCellValue("A$contadorCeldas", $pcp->persona['apellido_paterno']);
            $sheet->setCellValue("B$contadorCeldas", $pcp->persona['apellido_materno']);
            $sheet->setCellValue("C$contadorCeldas", $pcp->persona['nombres']);
            $sheet->setCellValue("D$contadorCeldas", $pcp->persona['cedula']);
            $sheet->setCellValue("E$contadorCeldas", $pcp->persona['expedido']);
            $sheet->setCellValue("F$contadorCeldas", $pcp->persona['email']);
            $sheet->setCellValue("G$contadorCeldas", $pcp->persona['numero_celular']);
            $sheet->setCellValue("H$contadorCeldas", $pcp->persona['sexo']);
            $sheet->setCellValue("I$contadorCeldas", $pcp->persona['direccion']);
            $sheet->setCellValue("J$contadorCeldas", $pcp->persona['fecha_nacimiento']);
            $sheet->setCellValue("K$contadorCeldas", $pcp->carrera['nombre']);
            $sheet->setCellValue("L$contadorCeldas", $pcp->turno->descripcion);
            $sheet->setCellValue("M$contadorCeldas", $pcp->gestion);
            $sheet->setCellValue("N$contadorCeldas", $pcp->paralelo);
            $sheet->setCellValue("O$contadorCeldas", $pcp->anio_vigente);
            $sheet->setCellValue("P$contadorCeldas", $pcp->estado);
            // $sheet->setCellValue("H$contadorCeldas", $aLetras->toString($i->nota, 0));
            $contadorCeldas++;
        }

        // estilos para el borde de las celdas
        $spreadsheet->getActiveSheet()->getStyle("A2:P$contadorCeldas")->applyFromArray(
            array(
                'borders' => array(
                    'allBorders' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => array('argb' => '000000')
                    )
                )
            )
        );
        // fin estilos para el borde de las celdas

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
        // $writer->save('demo.xlsx');
    
    }

}