<?php

namespace App\Http\Controllers;

use App\Pago;
use App\Turno;
use App\Factura;
use App\Persona;
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

        return $pdf->stream('LibroVentas.pdf', array('Attachment'=>false));
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
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_final = $request->input('fecha_final');
        $alumnosArray = array();

        $listaAlumnosPagos = Pago::where('gestion', $gestion)
                            ->where('turno_id', $turno_id)
                            ->where('carrera_id', 1)
                            ->whereBetween('fecha', [$fecha_inicio, $fecha_final])
                            ->groupBy('persona_id')
                            ->get();

        foreach ($listaAlumnosPagos as $ap) {
            array_push($alumnosArray, $ap->id);
        }

        $alumnos = Persona::whereIn('id', $alumnosArray)
                            ->get();

        dd($alumnos);
    }
}