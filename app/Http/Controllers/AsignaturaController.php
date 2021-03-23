<?php

namespace App\Http\Controllers;

use App\Carrera;
use App\Asignatura;
use App\Prerequisito;
use App\CarrerasPersona;
use Illuminate\Http\Request;
use App\AsignaturasEquivalente;
use Illuminate\Support\Facades\Auth;

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
        $asignatura->user_id                = Auth::user()->id;
        $asignatura->carrera_id             = $request->carrera_id;
        $asignatura->resolucion_id          = $request->resolucion_asignatura;
        $asignatura->gestion                = $request->gestion;
        $asignatura->sigla                  = $request->codigo_asignatura;
        $asignatura->nombre                 = $request->nombre_asignatura;
        $asignatura->troncal                = $request->troncal;
        $asignatura->ciclo                  = $request->ciclo;
        if($request->ciclo == 'Semestral')
        {
            $asignatura->semestre           = $request->semestre;
        }
        $asignatura->carga_horaria_virtual  = $request->carga_virtual;
        $asignatura->carga_horaria          = $request->carga_horaria;
        $asignatura->teorico                = $request->teorico;
        $asignatura->practico               = $request->practico;
        $asignatura->anio_vigente           = $request->anio_vigente;
        $asignatura->orden_impresion        = $request->orden_impresion;
        $asignatura->troncal                = $request->troncal;q
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
        $valida = 0;
        // dd($request->all());
        $asignatura = Asignatura::find($request->fp_materia);
        $prerequisito = Prerequisito::where('asignatura_id', $request->fp_asignatura_id)
                                    ->first();
        
        $validaPrerequisito = Prerequisito::where('asignatura_id', $request->fp_asignatura_id)
                                            ->where('prerequisito_id', $request->fp_materia)
                                            ->where('anio_vigente', $request->gestion)
                                            ->count();
        if ($validaPrerequisito > 0) {
            $valida = 1;
        }else{
            $valida                        = 0;
            $prerequisito                  = new Prerequisito();
            $prerequisito->user_id         = Auth::user()->id;
            $prerequisito->asignatura_id   = $request->fp_asignatura_id;
            $prerequisito->prerequisito_id = $request->fp_materia;
            $prerequisito->sigla           = $asignatura->sigla;
            $prerequisito->anio_vigente    = $request->gestion;
            $prerequisito->save();
        }

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

        $gestiones  = CarrerasPersona::select('anio_vigente')
                        ->groupBy('anio_vigente')
                        ->get();

        $carreras = Carrera::where('anio_vigente', $anio_vigente)
                        ->orderBy('id', 'ASC')
                        ->get();

        $asignaturas = Asignatura::where('anio_vigente', $anio_vigente)
                                ->where('carrera_id', 1)
                                ->orderBy('id', 'ASC')
                                ->get();

        $equivalentes = AsignaturasEquivalente::get();
        return view('asignatura.asignaturas_equivalentes')->with(compact('carreras', 'asignaturas', 'equivalentes', 'gestiones', 'anio_vigente'));  
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
        $asignatura_equivalente = new AsignaturasEquivalente();
        $asignatura_equivalente->user_id = Auth::user()->id;
        $asignatura_equivalente->carrera_id_1 = $request->carrera_1;
        $asignatura_equivalente->asignatura_id_1 = $request->asignatura_1;
        $asignatura_equivalente->carrera_id_2 = $request->carrera_2;
        $asignatura_equivalente->asignatura_id_2 = $request->asignatura_2;
        $asignatura_equivalente->anio_vigente = $request->gestion_1;
        $asignatura_equivalente->save();
        return redirect('Asignatura/asignaturas_equivalentes');
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

    public function ajax_busca_asignatura(Request $request)
    {
        $asignaturas = Asignatura::where('anio_vigente', $request->gestion)
                        ->where('carrera_id', $request->carrera)
                        ->get();
        return view('asignatura.ajax_busca_asignatura')->with(compact('asignaturas'));
    }

    public function ajax_busca_asignaturas(Request $request)
    {
        $asignaturas = Asignatura::where('anio_vigente', $request->gestion)
                        ->where('carrera_id', $request->carrera)
                        ->get();
        return view('asignatura.ajax_busca_asignaturas')->with(compact('asignaturas'));
    }

}
