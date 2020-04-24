<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;   
use App\NotasPropuesta;
use App\Nota;
use App\Kardex;
use App\Inscripcion;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NotasExport;
use App\Imports\NotasImport;
use Validator;


class NotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado()
    {
        $usuario = Auth::user();
        $asignaturas = NotasPropuesta::where('user_id', Auth::user()->id)
                                    ->where('anio_vigente', date('Y'))
                                    ->where('borrado', NULL)
                                    ->get();
        return view('nota.listado')->with(compact('asignaturas'));
    }

    public function detalle($id)
    {
        $asignatura = NotasPropuesta::find($id);
        
        //En tabla Inscripcion leer filas que contengan valores similares a los de la NotaPropuesta
        $inscripciones = Inscripcion::where('asignatura_id', $asignatura->asignatura_id)
                                ->where('turno_id', $asignatura->turno_id)
                                ->where('paralelo', $asignatura->paralelo)
                                ->where('anio_vigente', $asignatura->anio_vigente)
                                ->where('borrado', NULL)
                                ->get();
        // Capturamos X registros de Inscripcion, ahora debemos colocarlos en Notas
        // Haremos el recorrido de cada registro de $inscripciones, verificando si este valor existe
        // si existe, no se hara nada, si no existe, se creara un nuevo registro en la tabla
        foreach($inscripciones as $inscripcion){
            //Capturamos en $nota al primer registro que contenga estos datos
            $nota = Nota::where('asignatura_id', $inscripcion->asignatura_id)
                        ->where('turno_id', $inscripcion->turno_id)
                        ->where('user_id', $asignatura->user_id)
                        ->where('persona_id', $inscripcion->persona_id)
                        ->where('paralelo', $inscripcion->paralelo)
                        ->where('anio_vigente', $inscripcion->anio_vigente)
                        ->where('borrado', NULL)
                        ->first();
            //Si $nota no tiene ningun registro nos devolvera NULL, por tanto preguntamos si $nota es NULL
            if(!$nota){
                //Como $nota es NULL creara un nuevo registro que tenga estos valores
                $nueva_nota = new Nota;
                $nueva_nota->asignatura_id = $inscripcion->asignatura_id;
                $nueva_nota->turno_id = $inscripcion->turno_id;
                $nueva_nota->user_id = $asignatura->user_id;
                $nueva_nota->persona_id = $inscripcion->persona_id;
                $nueva_nota->paralelo = $inscripcion->paralelo;
                $nueva_nota->anio_vigente = $inscripcion->anio_vigente;
                $nueva_nota->save();
            }
        }

        //Tomamos todas las notas que coincidan con estos valores y las devolveremos a la vista
        $notas = Nota::where('asignatura_id', $asignatura->asignatura_id)
                    ->where('turno_id', $asignatura->turno_id)
                    ->where('user_id', $asignatura->user_id)
                    ->where('paralelo', $asignatura->paralelo)
                    ->where('anio_vigente', $asignatura->anio_vigente)
                    ->where('borrado', NULL)
                    ->get();
        return view('nota.detalle')->with(compact('asignatura', 'notas'));
    }

    public function exportarexcel(Request $request)
    {
        return Excel::download(new NotasExport($request->id), date('Y-m-d').'-ListadoNotas.xlsx');
    }

    public function segundoTurno($id)
    {
        $asignatura = NotasPropuesta::find($id);
        $segundoTurno = Nota::where('asignatura_id', $asignatura->asignatura_id)
                    ->where('turno_id', $asignatura->turno_id)
                    ->where('user_id', $asignatura->user_id)
                    ->where('paralelo', $asignatura->paralelo)
                    ->where('anio_vigente', $asignatura->anio_vigente)
                    ->whereBetween('nota_total', [30,60])
                    ->where('borrado', NULL)
                    ->get();
        return view('nota.segundoTurno')->with(compact('asignatura', 'segundoTurno'));
    }

    public function actualizar(Request $request)
    {
        $nota = Nota::find($request->id);
        $nota->nota_asistencia = $request->asistencia;
        $nota->nota_practicas = $request->practicas;
        $nota->nota_puntos_ganados = $request->puntos;
        $nota->nota_primer_parcial = $request->parcial;
        $nota->nota_examen_final = $request->final;
        $nota->nota_total = $request->resultado;
        $nota->fecha_registro = date('Y-m-d H:i:s');
        $nota->save();

        $inscripcion = Inscripcion::where('asignatura_id', $nota->asignatura_id)
                                ->where('turno_id', $nota->turno_id)
                                ->where('persona_id', $nota->persona_id)
                                ->where('paralelo', $nota->paralelo) 
                                ->where('anio_vigente', $nota->anio_vigente)
                                ->where('borrado', NULL)
                                ->firstOrFail();

        if($nota->segundo_turno && $nota->segundo_turno >= 61){
            // si segundo turno esta definido y es mayor o igual a 61, entonces colocar en inscripciones la nota de segundo turno  
            $inscripcion->nota = $nota->segundo_turno;
            $inscripcion->save();
        }else{
            // segundo turno no esta definido o no es mayor o igual a 61, entonces colocar en inscripciones la nota de nota_total
            $inscripcion->nota = $nota->nota_total;
            $inscripcion->save();
        }

        if($nota->nota_total >= 61){
            //Actualización en Kardex
            $kardex = Kardex::where('persona_id', $nota->persona_id)
                            ->where('asignatura_id', $nota->asignatura_id)
                            ->where('borrado', NULL)
                            ->firstOrFail();
            $kardex->aprobado = 'Si';
            $kardex->anio_aprobado = date('Y');
            $kardex->save();
        }
    }

    public function ajax_importar(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xlsx|max:2048'
        ]);
        if($validation->passes())
        {
            $file = $request->file('select_file');
            Excel::import(new NotasImport, $file);
            return response()->json([
                'message' => 'Importacion realizada con exito',
                'sw' => 1
            ]);
        }
        else
        {
            switch ($validation->errors()->first()) {
                case "The select file field is required.":
                    $mensaje = "Es necesario agregar un archivo excel.";
                    break;
                case "The select file must be a file of type: xlsx.":
                    $mensaje = "El archivo debe ser del tipo: xlsx.";
                    break;
                default:
                    $mensaje = "Fallo al importar el archivo seleccionado.";
                    break;
            }
            return response()->json([
                //0
                'message' => $mensaje,
                'sw' => 0
            ]);
        }
    }

    public function segundoTurnoActualizar(Request $request)
    {
        $nota = Nota::find($request->id);
        $nota->segundo_turno = $request->segundo_turno;
        $nota->save();
        if($nota->segundo_turno >= 61){
            //Actualización en Kardex
            $kardex = Kardex::where('persona_id', $nota->persona_id)
                            ->where('asignatura_id', $nota->asignatura_id)
                            ->firstOrFail();
            $kardex->aprobado = 'Si';
            $kardex->anio_aprobado = date('Y');
            $kardex->save();
            //Actualización en Inscripciones
            $inscripcion = Inscripcion::where('asignatura_id', $nota->asignatura_id)
                                    ->where('turno_id', $nota->turno_id)
                                    ->where('persona_id', $nota->persona_id)
                                    ->where('paralelo', $nota->paralelo) 
                                    ->where('anio_vigente', $nota->anio_vigente)
                                    ->where('borrado', NULL)
                                    ->firstOrFail();
            $inscripcion->nota = $nota->segundo_turno;
            $inscripcion->save();
        }
    }
    
}
