<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteController extends Controller
{
    
    public function formulario(Request $request)
    {
        return view('reporte.formulario');
    }

    public function libroVentas(Request $request)
    {
        return view('reporte.libroVentas');

    }
}
