<?php

namespace App\Http\Controllers;

use App\Factura;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    
    public function formulario(Request $request)
    {
        return view('reporte.formulario');
    }

    public function libroVentas(Request $request)
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_final = $request->input('fecha_final');

        $facturas = Factura::where('facturado', 'Si')
                            ->whereBetween('fecha', [$request->input('fecha_inicio'), $request->input('fecha_final')])
                            ->get();

        return view('reporte.libroVentas')->with(compact('facturas', 'fecha_inicio', 'fecha_final'));
    }
}