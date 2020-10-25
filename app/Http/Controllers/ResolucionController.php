<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Resolucione;

class ResolucionController extends Controller
{
    public function listado()
    {
        $resoluciones = Resolucione::get();
        return view('resolucion.listado')->with(compact('resoluciones'));
    }

    public function guardar(Request $request)
    {
        $resolucion = new Resolucione();
        $resolucion->user_id = Auth::user()->id;
        $resolucion->resolucion = $request->nombre_resolucion;
        $resolucion->nota_aprobacion = $request->nota_aprobacion_resolucion;
        $resolucion->anio_vigente = $request->anio_vigente_resolucion;
        $resolucion->semestre = $request->semestre_resolucion;
        $resolucion->save();
        return redirect('Resolucion/listado');
    }

    public function actualizar(Request $request)
    {
        $resolucion = Resolucione::find($request->id);
        $resolucion->user_id = Auth::user()->id;
        $resolucion->resolucion = $request->nombre;
        $resolucion->nota_aprobacion = $request->nota_aprobacion;
        $resolucion->anio_vigente = $request->anio_vigente;
        $resolucion->semestre = $request->semestre;
        $resolucion->save();
        return redirect('Resolucion/listado');
    }

    public function eliminar($id)
    {
        $resolucion = Resolucione::find($id);
        $resolucion->delete();
        return redirect('Resolucion/listado');
    }
}
