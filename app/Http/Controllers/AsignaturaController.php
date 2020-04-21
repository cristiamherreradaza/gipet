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
        $asignatura->anio_vigente      = $request->anio_vigente;

        $sw = 0;

        if ($asignatura->save()) {
            $sw = 1;
        } else {
            $sw = 0;
        }

        return response()->json([
            'sw' => $sw,
        ]);

    }

    public function eliminar(Request $request, $asignatura_id)
    {
        // dd($asignatura_id);
        $hoy = date("Y-m-d H:i:s");

        $asignatura = Asignatura::where("borrado", NULL)
                    ->where('id', $asignatura_id)
                    ->first();

        $elim_asignatura = Asignatura::find($asignatura_id);
        $elim_asignatura->borrado = $hoy;

        $sw = 0;

        if ($elim_asignatura->save()) {
            $sw = 1;
        } else {
            $sw = 0;
        }

        return response()->json([
            'sw' => $sw,
            'anio_vigente' => $asignatura->anio_vigente,
            'carrera_id' => $asignatura->carrera_id,
        ]);
        
    }
}
