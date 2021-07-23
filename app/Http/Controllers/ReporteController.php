<?php

namespace App\Http\Controllers;

use App\Pago;
use App\Turno;
use App\Factura;
use App\Persona;
use App\CarrerasPersona;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
class ReporteController extends Controller
{
    
    public function formularioLibro(Request $request)
    {
        return view('reporte.formularioLibro');
    }

    public function libroVentas(Request $request)
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_final = $request->input('fecha_final');

        $facturas = Factura::where('facturado', 'Si')
                            ->whereBetween('fecha', [$request->input('fecha_inicio'), $request->input('fecha_final')])
                            ->get();

        $pdf = PDF::loadView('pdf.libroVentas', compact('facturas', 'fecha_inicio', 'fecha_final'))
                    ->setPaper('letter', 'landscape');

        return $pdf->stream('LibroVentas.pdf');
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


}