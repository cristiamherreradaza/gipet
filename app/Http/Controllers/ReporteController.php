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
        // dd($request->all());
        $facturas = Factura::whereBetween('fecha', [$request->input('fecha_inicio'), $request->input('fecha_final')])
                            ->get();

        return view('reporte.libroVentas')->with(compact('facturas'));
    }
}