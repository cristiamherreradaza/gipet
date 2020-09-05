<?php

namespace App\Http\Controllers;

use App\Asignatura;
use App\Prerequisito;
use App\Carrera;
use App\AsignaturasEquivalente;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    public function listado_malla(Request $request, $carrera_id)
    {
        $asignaturas = Asignatura::where("deleted_at", NULL)
                    ->where('carrera_id', $carrera_id)
                    ->get();
        // dd($carreras[0]->nombre);
        return view('asignatura.listado_malla', compact('asignaturas'));
    }

    public function guarda(Request $request)
    {
        if ($request->asignatura_id) {
            $asignatura = Asignatura::find($request->asignatura_id);
        } else {
        	$asignatura = new Asignatura();
        }
        $asignatura->carrera_id        = $request->carrera_id;
        $asignatura->codigo_asignatura = $request->codigo_asignatura;
        $asignatura->nombre_asignatura = $request->nombre_asignatura;
        $asignatura->orden_impresion   = $request->orden_impresion;
        $asignatura->anio_vigente      = $request->anio_vigente;
        $asignatura->gestion           = $request->gestion;
        $asignatura->ciclo             = $request->ciclo;
        $asignatura->carga_horaria     = $request->carga_horaria;
        $asignatura->teorico           = $request->teorico;
        $asignatura->practico          = $request->practico;
        $asignatura->save();

        // Buscar en la tabla prerequisitos si existe este id de asignatura

        // si existe dejarlo pasar
        if (!$request->asignatura_id) {
            $prerequisito_nuevo = new Prerequisito();
            $prerequisito_nuevo->asignatura_id   = $asignatura->id;
            $prerequisito_nuevo->save();
        }
        // Si no existe crearlo con id pero en columna prerequisto NULL
        
        // Agregar en la tabla prerequisitos el id de esta asignatura creada

        // $sw = 0;
        // if ($asignatura->save()) {
        //     $sw = 1;
        // } else {
        //     $sw = 0;
        // }
        // return response()->json([
        //     'sw' => $sw,
        // ]);
    }

    public function eliminar($asignatura_id)
    {
        $asignatura = Asignatura::find($asignatura_id);
        $anio_vigente = $asignatura->anio_vigente;
        $carrera_id = $asignatura->carrera_id;
        $asignatura->delete();
        return response()->json([
            'anio_vigente' => $asignatura->anio_vigente,
            'carrera_id' => $asignatura->carrera_id,
        ]);
        // $hoy = date("Y-m-d H:i:s");
        // $asignatura = Asignatura::where("deleted_at", NULL)
        //             ->where('id', $asignatura_id)
        //             ->first();
        // $elim_asignatura = Asignatura::find($asignatura_id);
        // $elim_asignatura->borrado = $hoy;
        // $sw = 0;
        // if ($elim_asignatura->save()) {
        //     $sw = 1;
        // } else {
        //     $sw = 0;
        // }
        // return response()->json([
        //     'sw' => $sw,
        //     'anio_vigente' => $asignatura->anio_vigente,
        //     'carrera_id' => $asignatura->carrera_id,
        // ]);
    }

    public function ajax_muestra_prerequisitos(Request $request, $asignatura_id)
    {
        $prerequisitos = Prerequisito::where('asignatura_id', $asignatura_id)
                        ->where('deleted_at', NULL)
                        ->get();

        return view('asignatura.ajax_muestra_prerequisitos', compact('prerequisitos'));
    }

    public function guarda_prerequisito(Request $request)
    {
        $asignatura = Asignatura::find($request->fp_materia);
        $prerequisito = Prerequisito::where('asignatura_id', $request->fp_asignatura_id)
                                    ->first();
        if($prerequisito->prerequisito_id == NULL){
            //sobreescribir
            $prerequisito->prerequisito_id = $request->fp_materia;
            $prerequisito->sigla           = $asignatura->codigo_asignatura;
            $prerequisito->save();
        }else{
            //crear otro prerequisito
            $prerequisito                  = new Prerequisito();
            $prerequisito->asignatura_id   = $request->fp_asignatura_id;
            $prerequisito->prerequisito_id = $request->fp_materia;
            $prerequisito->sigla           = $asignatura->codigo_asignatura;
            $prerequisito->save();
        }
        // $asignatura = Asignatura::find($request->fp_materia);
        // $nPrerequisito                  = new Prerequisito();
        // $nPrerequisito->asignatura_id   = $request->fp_asignatura_id;
        // $nPrerequisito->prerequisito_id = $request->fp_materia;
        // $nPrerequisito->sigla           = $asignatura->codigo_asignatura;
        // $nPrerequisito->save();
        return response()->json([
            'asignatura_id' => $request->fp_asignatura_id
        ]);
    }

    public function elimina_prerequisito(Request $request, $prerequisito_id)
    {
        $prerequisito = Prerequisito::find($prerequisito_id);
        $cantidad = Prerequisito::where('asignatura_id', $prerequisito->asignatura_id)->count();
        if($cantidad > 1){
            $prerequisito->delete();
        }else{
            $prerequisito->prerequisito_id = NULL;
            $prerequisito->sigla = NULL;
            $prerequisito->save();
        }
        // $eliminaPrerequisito          = Prerequisito::find($prerequisito_id);
        // $eliminaPrerequisito->borrado = date("Y-m-d H:i:s");
        // $eliminaPrerequisito->save();
        return response()->json([
            'asignatura_id' => $prerequisito_id
        ]);
    }

    public function asignaturas_equivalentes()
    {
        $anio_vigente = 2020;
        $carrera = Carrera::whereNull('deleted_at')
                            ->orderBy('id', 'ASC')
                            ->get();

        $asignatura = Asignatura::whereNull('deleted_at')
                            ->where('anio_vigente', $anio_vigente)
                            ->orderBy('id', 'ASC')
                            ->get();

        return view('asignatura.asignaturas_equivalentes')->with(compact('carrera', 'asignatura'));  
    }

    public function ajax_lista(Request $request)
    {

        $asignaturas = AsignaturasEquivalente::whereNull('deleted_at')
                            ->orderBy('id', 'DESC')
                            ->get();

        return view('asignatura.lista')->with(compact('asignaturas'));  
    }

    public function guarda_equivalentes(Request $request)
    {
        $asig_1 = $request->tipo_asig_1;
        $asig_2 = $request->tipo_asig_2;
        $anio_vigente = $request->tipo_anio_vigente;

        $carrera_1 = Asignatura::find($asig_1);
        $carrera_2 = Asignatura::find($asig_2);

        $asig_equivalente                  = new AsignaturasEquivalente();
        $asig_equivalente->carrera_id_1    = $carrera_1->carrera_id;
        $asig_equivalente->asignatura_id_1 = $asig_1;
        $asig_equivalente->carrera_id_2    = $carrera_2->carrera_id;
        $asig_equivalente->asignatura_id_2 = $asig_2;
        $asig_equivalente->anio_vigente    = $anio_vigente;
        $asig_equivalente->save();

        $asignaturas = AsignaturasEquivalente::whereNull('deleted_at')
                            ->orderBy('id', 'DESC')
                            ->get();

        return view('asignatura.lista')->with(compact('asignaturas'));  
    }

    public function listado()
    {
        $asignaturas = Asignatura::where('carrera_id', 10)->get();
        return view('asignatura.listado')->with(compact('asignaturas'));
    }
}
