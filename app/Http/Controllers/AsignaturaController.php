<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Asignatura;
use App\Prerequisito;
use App\Carrera;
use App\AsignaturasEquivalente;

class AsignaturaController extends Controller
{
    public function listado_malla(Request $request, $carrera_id)
    {
        $asignaturas = Asignatura::where('carrera_id', $carrera_id)
                                ->get();
        return view('asignatura.listado_malla', compact('asignaturas'));
    }

    public function guarda(Request $request)
    {
        if ($request->asignatura_id) {
            $asignatura = Asignatura::find($request->asignatura_id);
        } else {
        	$asignatura = new Asignatura();
        }
        $asignatura->user_id = Auth::user()->id;
        $asignatura->carrera_id = $request->carrera_id;
        $asignatura->gestion = $request->gestion;
        $asignatura->sigla = $request->codigo_asignatura;
        $asignatura->nombre = $request->nombre_asignatura;
        $asignatura->troncal = $request->troncal;
        $asignatura->ciclo = $request->ciclo;
        $asignatura->semestre = $request->semestre;
        $asignatura->carga_horaria_virtual = $request->carga_virtual;
        $asignatura->carga_horaria = $request->carga_horaria;
        $asignatura->teorico = $request->teorico;
        $asignatura->practico = $request->practico;
        $asignatura->anio_vigente = $request->anio_vigente;
        $asignatura->orden_impresion = $request->orden_impresion;
        $asignatura->save();

        // Buscar en la tabla prerequisitos si existe este id de asignatura

        // si existe dejarlo pasar
        if (!$request->asignatura_id) {
            $prerequisito_nuevo = new Prerequisito();
            $prerequisito_nuevo->asignatura_id = $asignatura->id;
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

    public function ajax_muestra_prerequisitos($asignatura_id)
    {
        $asignaturas = Prerequisito::where('asignatura_id', $asignatura_id)
                                    ->get();
        return view('asignatura.ajax_muestra_prerequisitos')->with(compact('asignaturas'));
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

    // Funcion que envia los datos de las carreras y asignaturas correspondientes para el formulario
    public function asignaturas_equivalentes()
    {
        $anio_vigente = date('Y');
        $carreras = Carrera::orderBy('id', 'ASC')
                            ->get();
        $asignaturas = Asignatura::where('anio_vigente', $anio_vigente)
                                ->orderBy('id', 'ASC')
                                ->get();
        $equivalentes = AsignaturasEquivalente::get();
        return view('asignatura.asignaturas_equivalentes')->with(compact('carreras', 'asignaturas', 'equivalentes'));  
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
        // Si existen los parametros enviados desde interfaz
        if($request->asignatura_1 && $request->asignatura_2 && $request->anio_vigente){
            // Buscaremos los valores respectivos
            $asignatura_a = Asignatura::find($request->asignatura_1);
            $asignatura_b = Asignatura::find($request->asignatura_2);
            // Si existen los valores buscados, creamos la equivalencia
            if($asignatura_a && $asignatura_b){
                $asignatura_equivalente = new AsignaturasEquivalente();
                $asignatura_equivalente->user_id = Auth::user()->id;
                $asignatura_equivalente->carrera_id_1 = $asignatura_a->carrera_id;
                $asignatura_equivalente->asignatura_id_1 = $asignatura_a->id;
                $asignatura_equivalente->carrera_id_2 = $asignatura_b->carrera_id;
                $asignatura_equivalente->asignatura_id_2 = $asignatura_b->id;
                $asignatura_equivalente->anio_vigente = $request->anio_vigente;
                $asignatura_equivalente->save();
            }
        }
        return redirect('Asignatura/asignaturas_equivalentes');
        // $asig_1 = $request->asignatura_1;
        // $asig_2 = $request->asignatura_2;
        // $anio_vigente = $request->tipo_anio_vigente;

        // $carrera_1 = Asignatura::find($request->asignatura_1);
        // $carrera_2 = Asignatura::find($request->asignatura_2);

        // $asig_equivalente                  = new AsignaturasEquivalente();
        // $asig_equivalente->carrera_id_1    = $carrera_1->carrera_id;
        // $asig_equivalente->asignatura_id_1 = $asig_1;
        // $asig_equivalente->carrera_id_2    = $carrera_2->carrera_id;
        // $asig_equivalente->asignatura_id_2 = $asig_2;
        // $asig_equivalente->anio_vigente    = $anio_vigente;
        // $asig_equivalente->save();

        // $asignaturas = AsignaturasEquivalente::whereNull('deleted_at')
        //                     ->orderBy('id', 'DESC')
        //                     ->get();

        // return view('asignatura.lista')->with(compact('asignaturas'));  
    }

    public function elimina_equivalentes($id)
    {
        $asignatura = AsignaturasEquivalente::find($id);
        $asignatura->delete();
        return redirect('Asignatura/asignaturas_equivalentes');
    }

    public function listado()
    {
        $asignaturas = Asignatura::where('carrera_id', 10)->get();
        return view('asignatura.listado')->with(compact('asignaturas'));
    }
}
