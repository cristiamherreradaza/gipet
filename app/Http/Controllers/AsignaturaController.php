<?php

namespace App\Http\Controllers;

use App\Asignatura;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    public function listado_malla(Request $request, $carrera_id)
    {
        $asignaturas = Asignatura::where("borrado", NULL)
                    ->where('carrera_id', $carrera_id)
                    ->get();
        // dd($carreras[0]->nombre);
        return view('asignatura.listado_malla', compact('asignaturas'));
    }
}
