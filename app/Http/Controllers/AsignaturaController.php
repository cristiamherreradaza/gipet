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

    public function guarda(Request $request)
    {
        if ($request->asignatura_id != "") {
            $asignatura = Asignatura::find($request->asignatura_id);
        } else {
        	$asignatura = new Asignatura();
        }
        $asignatura->codigo_asignatura = $request->codigo_asignatura;
        $asignatura->nombre_asignatura = $request->nombre_asignatura;
        $asignatura->orden_impresion   = $request->orden_impresion;
        $asignatura->semestre          = $request->semestre;
        $asignatura->nivel             = $request->nivel;
        $asignatura->carrera_id        = $request->carrera_id;
        $asignatura->gestion           = $request->gestion;
        $asignatura->carga_horaria     = $request->carga_horaria;
        $asignatura->teorico           = $request->teorico;
        $asignatura->practico          = $request->practico;
        if ($asignatura->save()) {
            return response()->json([
                'sw' => 1,
            ]);
        } else {
            return response()->json([
                'sw' => 0,
            ]);
        }
    }
}
