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
                                ->get();
        //Tomamos todas las notas que coincidan con estos valores y las devolveremos a la vista
        $notas = Nota::where('asignatura_id', $asignatura->asignatura_id)
                    ->where('turno_id', $asignatura->turno_id)
                    //->where('user_id', $asignatura->user_id)
                    ->where('paralelo', $asignatura->paralelo)
                    ->where('anio_vigente', $asignatura->anio_vigente)
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
                                    ->first();
        $notas = Nota::where('asignatura_id', $request->asignatura_id)
                    ->where('turno_id', $request->turno_id)
                    ->where('persona_id', $request->persona_id)
                    ->where('paralelo', $request->paralelo)
                    ->where('anio_vigente', $request->anio_vigente)
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
                                    ->first();      // Encuentra la NotaPropuesta correspondiente a la Nota

        // Validacion para asistencia                                    
        if($request->asistencia <= $ponderacion->nota_asistencia && $request->asistencia >= 0)
        {
            // Aqui preguntar si es semestral o anual
            if($ponderacion->asignatura->ciclo == 'Semestral')                      // Es semestral, se registra en su 2 bimestres
            {
                // Si es semestral, ver a que bimestre hace referencia la nota (1ro -> 3ro y 2do -> 4to)
                if($nota->trimestre == 1)
                {
                    // Si es 1er bimestre, buscar el registro que corresponde al 3er bimestre y llenar en ambos
                    // Buscamos ese registro
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 3)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_asistencia = $request->asistencia;       // 3er Bimestre
                }
                if($nota->trimestre == 2)
                {
                    // Si es 2do bimestre, buscar el registro que corresponde al 4to bimestre y llenar en ambos
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 4)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_asistencia = $request->asistencia;       // 4to Bimestre
                }
                $segundoregistro->registrado = 'Si';
                $segundoregistro->fecha_registro = date('Y-m-d H:i:s');
                $segundoregistro->save();                                           // Guardamos registro
                $nota->registrado = 'Si';
                $nota->nota_asistencia = $request->asistencia;                      // 1er o 2do Bimestre
            }
            else                                                                    // Es anual, se registra en su bimestre
            {
                $nota->registrado = 'Si';
                $nota->nota_asistencia = $request->asistencia;                      // Nota del bimestre     
            }
        }
        else
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
            // Aqui preguntar si es semestral o anual
            if($ponderacion->asignatura->ciclo == 'Semestral')                      // Es semestral, se registra en su 2 bimestres
            {
                // Si es semestral, ver a que bimestre hace referencia la nota (1ro -> 3ro y 2do -> 4to)
                if($nota->trimestre == 1)
                {
                    // Si es 1er bimestre, buscar el registro que corresponde al 3er bimestre y llenar en ambos
                    // Buscamos ese registro
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 3)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_practicas = $request->practicas;       // 3er Bimestre
                }
                if($nota->trimestre == 2)
                {
                    // Si es 2do bimestre, buscar el registro que corresponde al 4to bimestre y llenar en ambos
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 4)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_practicas = $request->practicas;       // 4to Bimestre
                }
                $segundoregistro->registrado = 'Si';
                $segundoregistro->fecha_registro = date('Y-m-d H:i:s');
                $segundoregistro->save();                                           // Guardamos registro
                $nota->registrado = 'Si';
                $nota->nota_practicas = $request->practicas;                      // 1er o 2do Bimestre
            }
            else                                                                    // Es anual, se registra en su bimestre
            {
                $nota->registrado = 'Si';
                $nota->nota_practicas = $request->practicas;                        // Nota del bimestre     
            }
            
        }
        else
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
            // Aqui preguntar si es semestral o anual
            if($ponderacion->asignatura->ciclo == 'Semestral')                      // Es semestral, se registra en su 2 bimestres
            {
                // Si es semestral, ver a que bimestre hace referencia la nota (1ro -> 3ro y 2do -> 4to)
                if($nota->trimestre == 1)
                {
                    // Si es 1er bimestre, buscar el registro que corresponde al 3er bimestre y llenar en ambos
                    // Buscamos ese registro
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 3)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_puntos_ganados = $request->puntos;       // 3er Bimestre
                }
                if($nota->trimestre == 2)
                {
                    // Si es 2do bimestre, buscar el registro que corresponde al 4to bimestre y llenar en ambos
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 4)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_puntos_ganados = $request->puntos;       // 4to Bimestre
                }
                $segundoregistro->registrado = 'Si';
                $segundoregistro->fecha_registro = date('Y-m-d H:i:s');
                $segundoregistro->save();                                           // Guardamos registro
                $nota->registrado = 'Si';
                $nota->nota_puntos_ganados = $request->puntos;                      // 1er o 2do Bimestre
            }
            else                                                                    // Es anual, se registra en su bimestre
            {
                $nota->registrado = 'Si';
                $nota->nota_puntos_ganados = $request->puntos;                      // Nota del bimestre     
            }
        }
        else
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
            // Aqui preguntar si es semestral o anual
            if($ponderacion->asignatura->ciclo == 'Semestral')                      // Es semestral, se registra en su 2 bimestres
            {
                // Si es semestral, ver a que bimestre hace referencia la nota (1ro -> 3ro y 2do -> 4to)
                if($nota->trimestre == 1)
                {
                    // Si es 1er bimestre, buscar el registro que corresponde al 3er bimestre y llenar en ambos
                    // Buscamos ese registro
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 3)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_primer_parcial = $request->parcial;       // 3er Bimestre
                }
                if($nota->trimestre == 2)
                {
                    // Si es 2do bimestre, buscar el registro que corresponde al 4to bimestre y llenar en ambos
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 4)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_primer_parcial = $request->parcial;      // 4to Bimestre
                }
                $segundoregistro->registrado = 'Si';
                $segundoregistro->fecha_registro = date('Y-m-d H:i:s');
                $segundoregistro->save();                                           // Guardamos registro
                $nota->nota_primer_parcial = $request->parcial;                     // 1er o 2do Bimestre
                $nota->registrado = 'Si';
            }
            else                                                                    // Es anual, se registra en su bimestre
            {
                $nota->registrado = 'Si';
                $nota->nota_primer_parcial = $request->parcial;                     // Nota del bimestre     
            }
        }
        else
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
            // Aqui preguntar si es semestral o anual
            if($ponderacion->asignatura->ciclo == 'Semestral')                      // Es semestral, se registra en su 2 bimestres
            {
                // Si es semestral, ver a que bimestre hace referencia la nota (1ro -> 3ro y 2do -> 4to)
                if($nota->trimestre == 1)
                {
                    // Si es 1er bimestre, buscar el registro que corresponde al 3er bimestre y llenar en ambos
                    // Buscamos ese registro
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 3)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_examen_final = $request->final;          // 3er Bimestre
                }
                if($nota->trimestre == 2)
                {
                    // Si es 2do bimestre, buscar el registro que corresponde al 4to bimestre y llenar en ambos
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 4)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_examen_final = $request->final;          // 4to Bimestre
                }
                $segundoregistro->registrado = 'Si';
                $segundoregistro->fecha_registro = date('Y-m-d H:i:s');
                $segundoregistro->save();                                           // Guardamos registro
                $nota->nota_examen_final = $request->final;                         // 1er o 2do Bimestre
                $nota->registrado = 'Si';
            }
            else                                                                    // Es anual, se registra en su bimestre
            {
                $nota->registrado = 'Si';
                $nota->nota_examen_final = $request->final;                         // Nota del bimestre     
            }
        }
        else
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
            // Aqui tambien preguntamos si es semestral o anual, para llenar 1 o 2 registros
            // Aqui preguntar si es semestral o anual
            if($ponderacion->asignatura->ciclo == 'Semestral')                      // Es semestral, se registra en su 2 bimestres
            {
                // Si es semestral, ver a que bimestre hace referencia la nota (1ro -> 3ro y 2do -> 4to)
                if($nota->trimestre == 1)
                {
                    // Si es 1er bimestre, buscar el registro que corresponde al 3er bimestre y llenar en ambos
                    // Buscamos ese registro
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 3)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_total = $request->resultado;       // 3er Bimestre
                }
                if($nota->trimestre == 2)
                {
                    // Si es 2do bimestre, buscar el registro que corresponde al 4to bimestre y llenar en ambos
                    $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('user_id', $nota->user_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo)
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->where('trimestre', 4)
                                            ->first();
                    // Colocamos la nota
                    $segundoregistro->nota_total = $request->resultado;       // 4to Bimestre
                }
                $segundoregistro->registrado = 'Si';
                $segundoregistro->fecha_registro = date('Y-m-d H:i:s');
                $segundoregistro->save();                                           // Guardamos registro
                $nota->nota_total = $request->resultado;                      // 1er o 2do Bimestre
                $nota->registrado = 'Si';
            }
            else                                                                    // Es anual, se registra en su bimestre
            {
                $nota->registrado = 'Si';
                $nota->nota_total = $request->resultado;                      // Nota del bimestre     
            }
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
                                    ->firstOrFail();

            // Colocamos en inscripciones la nota de 2do turno
            $puntuaciones = Nota::where('asignatura_id', $inscripcion->asignatura_id)
                                ->where('persona_id', $inscripcion->persona_id)
                                ->where('turno_id', $inscripcion->turno_id)
                                ->where('paralelo', $inscripcion->paralelo)
                                ->where('anio_vigente', $inscripcion->anio_vigente)
                                ->get();        // Encontraremos los 4 registros correspondientes a esa asignatura
            $suma=0;
            $cantidad=4;
            $habilitado='Si';
            foreach($puntuaciones as $puntuacion){
                $suma = $suma + $puntuacion->nota_total;
            }
            $resultado = round($suma/$cantidad);
            $inscripcion->nota = $resultado;
            $inscripcion->save();
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
            //             ->get();
            // Sumar sus notas totales en un registro   REVISAR
            $notas = Nota::groupBy('persona_id')
                        ->selectRaw('persona_id, sum(nota_total) as total')
                        ->where('asignatura_id', $request->asignatura_id)
                        ->where('turno_id', $request->turno_id)
                        ->where('paralelo', $request->paralelo)
                        ->where('anio_vigente', $request->anio_vigente)
                        ->get();
            //dd($notas);
            // Por cada registro guardar en inscripcion
            foreach($notas as $nota){
                $inscripcion = Inscripcion::where('asignatura_id', $request->asignatura_id)
                                        ->where('turno_id', $request->turno_id)
                                        ->where('persona_id', $nota->persona_id)
                                        ->where('paralelo', $request->paralelo)
                                        ->where('anio_vigente', $request->anio_vigente)
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
        //dd($request->inscripcion_id);
        //llega el dato
        // crear un registro en tabla segundo turno con los datos de inscripcion
        // colocar 61 en las 4 notas del estudiante con los datos de inscripcion
        // colocar en inscripcion el valor de 61 solo si aprobo el examen el alumno
        
        
        if($request->nota_segundo_turno > 61)
        {
            $inscripcion = Inscripcion::find($request->inscripcion_id);
            $notas = Nota::where('asignatura_id', $inscripcion->asignatura_id)
                        ->where('persona_id', $inscripcion->persona_id)
                        ->where('turno_id', $inscripcion->turno_id)
                        ->where('paralelo', $inscripcion->paralelo)
                        ->where('anio_vigente', $inscripcion->anio_vigente)
                        ->get();
            foreach($notas as $nota)
            {
                $nota->segundo_turno = 61;
                $nota->save();
            }
            $inscripcion->nota = 61;
            $inscripcion->save();
        }
        return redirect('nota/listado');
        // $nota = Nota::find($request->id);
        // $nota->segundo_turno = $request->segundo_turno;
        // $nota->save();
        // if($nota->segundo_turno >= 61){
        //     //Actualización en Kardex
        //     $kardex = Kardex::where('persona_id', $nota->persona_id)
        //                     ->where('asignatura_id', $nota->asignatura_id)
        //                     ->firstOrFail();
        //     $kardex->aprobado = 'Si';
        //     $kardex->anio_aprobado = date('Y');
        //     $kardex->save();
        //     //Actualización en Inscripciones
        //     $inscripcion = Inscripcion::where('asignatura_id', $nota->asignatura_id)
        //                             ->where('turno_id', $nota->turno_id)
        //                             ->where('persona_id', $nota->persona_id)
        //                             ->where('paralelo', $nota->paralelo) 
        //                             ->where('anio_vigente', $nota->anio_vigente)
        //                             ->firstOrFail();
        //     $inscripcion->nota = $nota->segundo_turno;
        //     $inscripcion->save();
        // }
    }
    
}
