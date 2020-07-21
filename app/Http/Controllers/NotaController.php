<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Persona;
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
        $asignaturas = NotasPropuesta::where('user_id', Auth::user()->id)
                                    ->where('anio_vigente', date('Y'))
                                    ->where('borrado', NULL)
                                    ->get();
        return view('nota.listado')->with(compact('asignaturas'));
    }

    public function detalle($id)
    {
        // Buscamos los detalles de la materia a mostrar
        $asignatura = NotasPropuesta::find($id);
        // Buscamos a los estudiantes inscritos en esa materia
        $inscritos = Inscripcion::where('asignatura_id', $asignatura->asignatura_id)
                                ->where('turno_id', $asignatura->turno_id)
                                ->where('paralelo', $asignatura->paralelo)
                                ->where('anio_vigente', $asignatura->anio_vigente)
                                ->whereNull('borrado')
                                ->get();
        //Tomamos todas las notas que coincidan con estos valores y las devolveremos a la vista
        $notas = Nota::where('asignatura_id', $asignatura->asignatura_id)
                    ->where('turno_id', $asignatura->turno_id)
                    //->where('user_id', $asignatura->user_id)
                    ->where('paralelo', $asignatura->paralelo)
                    ->where('anio_vigente', $asignatura->anio_vigente)
                    ->whereNull('borrado')
                    ->get();
        return view('nota.detalle')->with(compact('asignatura', 'inscritos', 'notas'));
    }

    public function ajaxMuestraNota(Request $request)
    {
        $asignatura = NotasPropuesta::where('asignatura_id', $request->asignatura_id)
                                    ->where('turno_id', $request->turno_id)
                                    ->where('user_id', Auth::user()->id)
                                    ->where('paralelo', $request->paralelo)
                                    ->where('anio_vigente', $request->anio_vigente)
                                    ->whereNull('borrado')
                                    ->first();
        $notas = Nota::where('asignatura_id', $request->asignatura_id)
                    ->where('turno_id', $request->turno_id)
                    ->where('persona_id', $request->persona_id)
                    ->where('paralelo', $request->paralelo)
                    ->where('anio_vigente', $request->anio_vigente)
                    ->whereNull('borrado')
                    ->get();
        if($asignatura->asignatura->ciclo == 'Semestral')
        {
            // Enviar a la vista donde registrará las notas correspondientes a 2 bimestres
            return view('nota.ajaxMuestraNotaSemestral')->with(compact('asignatura', 'notas'));
        }
        else
        {
            // Enviar a la vista donde registrará las notas correspondientes a 4 bimestres
            return view('nota.ajaxMuestraNotaAnual')->with(compact('asignatura', 'notas'));
        }
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
        $val = 1;                                   // Variable para validacion de notas $val=1 ->todo en orden $val=0 -> error
        $nota = Nota::find($request->id);           // Encuentra la nota con el registro $id
        $ponderacion = NotasPropuesta::where('asignatura_id', $nota->asignatura_id)
                                    ->where('turno_id', $nota->turno_id)
                                    ->where('user_id', $nota->user_id)
                                    ->where('paralelo', $nota->paralelo)
                                    ->where('anio_vigente', $nota->anio_vigente)
                                    ->where('borrado', NULL)
                                    ->first();      // Encuentra la NotaPropuesta correspondiente a la Nota
        if($ponderacion->asignatura->ciclo == 'Semestral')
        {
            
        }

        
        // Validacion para asistencia                                    
        if($request->asistencia <= $ponderacion->nota_asistencia && $request->asistencia >= 0)
        {
            $nota->nota_asistencia = $request->asistencia;    
        }else
        {
            return response()->json([
                //0
                'message' => 'Valor Máximo('.$ponderacion->nota_asistencia.')',
                'sw' => 0
            ]);
            $val = 0;
        }

        // Validacion para practicas
        if($request->practicas <= $ponderacion->nota_practicas && $request->practicas >= 0)
        {
            $nota->nota_practicas = $request->practicas;    
        }else
        {
            return response()->json([
                //0
                'message' => 'Valor Máximo('.$ponderacion->nota_practicas.')',
                'sw' => 0
            ]);
            $val = 0;
        }

        // Validacion para puntos ganados(extras)
        if($request->puntos <= $ponderacion->nota_puntos_ganados && $request->puntos >= 0)
        {
            $nota->nota_puntos_ganados = $request->puntos;    
        }else
        {
            return response()->json([
                //0
                'message' => 'Valor Máximo('.$ponderacion->nota_puntos_ganados.')',
                'sw' => 0
            ]);
            $val = 0;
        }

        // Validacion para primer parcial
        if($request->parcial <= $ponderacion->nota_primer_parcial && $request->nota_primer_parcial >= 0)
        {
            $nota->nota_primer_parcial = $request->parcial;    
        }else
        {
            return response()->json([
                //0
                'message' => 'Valor Máximo('.$ponderacion->nota_primer_parcial.')',
                'sw' => 0
            ]);
            $val = 0;
        }

        // Validacion para examen final
        if($request->final <= $ponderacion->nota_examen_final && $request->final >= 0)
        {
            $nota->nota_examen_final = $request->final;    
        }else
        {
            return response()->json([
                //0
                'message' => 'Valor Máximo('.$ponderacion->nota_examen_final.')',
                'sw' => 0
            ]);
            $val = 0;
        }

        // Si $val=1(si no hubo problemas con las notas), asignamos a la nota_total el valor acumulado por los inputs en interfaz
        if($val == 1)
        {
            $nota->nota_total = $request->resultado;
        }
        $nota->fecha_registro = date('Y-m-d H:i:s');
        $nota->save();                  // Guardamos en la tabla notas el registro correspondiente al bimestre

        // Si $val=1(si no hubo problemas con las notas), buscamos el registro del alumno correspondiente a esa asignatura
        if($val == 1)
        {
            $inscripcion = Inscripcion::where('asignatura_id', $nota->asignatura_id)
                        ->where('turno_id', $nota->turno_id)
                        ->where('persona_id', $nota->persona_id)
                        ->where('paralelo', $nota->paralelo) 
                        ->where('anio_vigente', $nota->anio_vigente)
                        ->where('borrado', NULL)
                        ->firstOrFail();

            // ESTA PARTE DEBE SER EVALUADA
            if($nota->segundo_turno && $nota->segundo_turno >= 61)
            {
                // si 2do turno esta definido y es mayor o igual a 61, entonces colocar en inscripciones la nota de 2do turno  
                $inscripcion->nota = $nota->segundo_turno;
                $inscripcion->save();
            }
            else
            {
                // 2do turno no esta definido o no es mayor o igual a 61, entonces colocar en inscripciones el promedio total de las notas
                $puntuaciones = Nota::where('asignatura_id', $inscripcion->asignatura_id)
                                    ->where('persona_id', $inscripcion->persona_id)
                                    ->where('turno_id', $inscripcion->turno_id)
                                    ->where('paralelo', $inscripcion->paralelo)
                                    ->where('anio_vigente', $inscripcion->anio_vigente)
                                    ->where('borrado', NULL)
                                    ->get();        // Encontraremos los 4 registros correspondientes a esa asignatura
                $suma=0;
                $cantidad=4;
                foreach($puntuaciones as $puntuacion){
                    $suma = $suma + $puntuacion->nota_total;
                }
                $resultado = round($suma/$cantidad);
                $inscripcion->nota = $resultado;
                $inscripcion->save();
            }
            // ESTA PARTE DEBE SER EVALUADA

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
    }

    public function ajax_importar(Request $request)
    {
        //dd($request->asignatura);
        $validation = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xlsx|max:2048'
        ]);
        if($validation->passes())
        {
            $file = $request->file('select_file');
            Excel::import(new NotasImport, $file);
            // Una vez cargado los datos de los estudiantes de la materia, actualizar sus datos, en la tabla inscripciones
            // Capturar todas las notas correspondientes a esa materia
            // $notas = Nota::where('asignatura_id', $request->asignatura_id)
            //             ->where('turno_id', $request->turno_id)
            //             ->where('paralelo', $request->paralelo)
            //             ->where('anio_vigente', $request->anio_vigente)
            //             ->whereNull('borrado')
            //             ->get();
            // Sumar sus notas totales en un registro   REVISAR
            $notas = Nota::groupBy('persona_id')
                        ->selectRaw('persona_id, sum(nota_total) as total')
                        ->where('asignatura_id', $request->asignatura_id)
                        ->where('turno_id', $request->turno_id)
                        ->where('paralelo', $request->paralelo)
                        ->where('anio_vigente', $request->anio_vigente)
                        ->whereNull('borrado')
                        ->get();
            //dd($notas);
            // Por cada registro guardar en inscripcion
            foreach($notas as $nota){
                $inscripcion = Inscripcion::where('asignatura_id', $request->asignatura_id)
                                        ->where('turno_id', $request->turno_id)
                                        ->where('persona_id', $nota->persona_id)
                                        ->where('paralelo', $request->paralelo)
                                        ->where('anio_vigente', $request->anio_vigente)
                                        ->whereNull('borrado')
                                        ->first();
                $inscripcion->nota = round($nota->total/4);
                $inscripcion->save();
            }
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
