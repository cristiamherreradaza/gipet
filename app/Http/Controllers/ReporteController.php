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


}