<?php

namespace App\Http\Controllers;

use App\Carrera;
use App\Asignatura;
use App\Resolucione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function generaResolucion(Request $request){

        // dd($request->all());
        $gestionAsignatura = Asignatura::where('resolucion_id', $request->resolucion_curricula)->max('anio_vigente');
        $asignaturas = Asignatura::where('resolucion_id', $request->resolucion_curricula)
                                ->where('anio_vigente', $gestionAsignatura)
                                ->get();
        // dd($asignaturas);
        foreach ($asignaturas as $key => $a) {
            // echo $a->nombre."<br />";
            $materia = new Asignatura();
            $materia->user_id = Auth::user()->id;
            $materia->resolucion_id = $request->resolucion_curricula;
            $materia->carrera_id = $a->carrera_id;
            $materia->gestion = $a->gestion;
            $materia->sigla = $a->sigla;
            $materia->nombre = $a->nombre;
            $materia->troncal = $a->troncal;
            $materia->ciclo = $a->ciclo;
            $materia->semestre = $a->semestre;
            $materia->carga_horaria_virtual = $a->carga_horaria_virtual;
            $materia->carga_horaria = $a->carga_horaria;
            $materia->teorico = $a->teorico;
            $materia->practico = $a->practico;
            $materia->nivel = $a->nivel;
            $materia->periodo = $a->periodo;
            $materia->anio_vigente = $request->gestion_curricula;
            $materia->orden_impresion = $a->orden_impresion;
            $materia->save();
        }

        return redirect('Carrera/listado');

    }
}
