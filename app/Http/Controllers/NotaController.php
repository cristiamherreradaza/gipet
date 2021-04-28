<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Asignatura;
use App\Persona;
use App\NotasPropuesta;
use App\Nota;
use App\Kardex;
use App\Inscripcione;
use App\SegundosTurno;
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
        $asignaturasDocente = NotasPropuesta::where('docente_id', Auth::user()->id)
                                            ->where('anio_vigente', date('Y'))
                                            ->groupBy('asignatura_id')
                                            ->get();

        $gestiones          = NotasPropuesta::select('anio_vigente')
                                            ->groupBy('anio_vigente')
                                            ->orderBy('anio_vigente', 'desc')
                                            ->get();
        return view('nota.listado')->with(compact('asignaturasDocente', 'gestiones'));
    }

    public function ajaxAsignaturasGestion(Request $request)
    {
        //dd($request->gestion);
        $asignaturasDocente = NotasPropuesta::where('docente_id', Auth::user()->id)
                                            ->where('anio_vigente', $request->gestion)
                                            ->groupBy('asignatura_id')
                                            ->get();
                                            
        return view('nota.ajaxAsignaturasGestion')->with(compact('asignaturasDocente'));
    }

    public function detalle($id)
    {
        
        $datosNP = NotasPropuesta::where('id', $id)->first();
        
        // buscamos el bimestre actual
        $notaBimestre  = Nota::where('asignatura_id', $datosNP->asignatura_id)
                    ->where('turno_id', $datosNP->turno_id)
                    ->where('paralelo', $datosNP->paralelo)
                    ->where('anio_vigente', $datosNP->anio_vigente)
                    ->first();
        // dd($notaBimestre);
        if($notaBimestre->finalizado == "Si"){
            $bimestreActual = 2;
        }else{
            $bimestreActual = 1;
        }
    
        
        $comboTurnos = NotasPropuesta::where('asignatura_id', $datosNP->asignatura_id)
                                    ->where('user_id', $datosNP->user_id)
                                    ->where('anio_vigente', $datosNP->anio_vigente)
                                    ->groupBy('turno_id')
                                    ->get();
                                    
        // Buscamos los detalles de la materia a mostrar
        $asignatura = NotasPropuesta::find($id);
        // Buscamos a los estudiantes inscritos en esa materia
        $inscritos  = Inscripcione::where('asignatura_id', $asignatura->asignatura_id)
                                ->where('turno_id', $asignatura->turno_id)
                                ->where('paralelo', $asignatura->paralelo)
                                ->where('anio_vigente', $asignatura->anio_vigente)
                                ->get();
        //Tomamos todas las notas que coincidan con estos valores y las devolveremos a la vista
        $notas  = Nota::where('asignatura_id', $asignatura->asignatura_id)
                    ->where('turno_id', $asignatura->turno_id)
                    //->where('user_id', $asignatura->user_id)
                    ->where('paralelo', $asignatura->paralelo)
                    ->where('anio_vigente', $asignatura->anio_vigente)
                    ->get();
        // Veremos si la asignatura se lleva de forma semestral o anual
        $materia    = Asignatura::find($asignatura->asignatura_id);
        $ciclo    = $materia->ciclo;
        if($ciclo == 'Semestral')
        {
            $maximo  = 2;
        }
        else
        {
            $maximo  = 4;
        }
        // Haremos una iteracion para encontrar en que bimestre se tiene que registrar las notas
        for($i = 1; $i <= $maximo; $i++)
        {
            // Buscamos un registro donde no se haya finalizado las notas
            $bimestre   = Nota::where('asignatura_id', $asignatura->asignatura_id)
                            ->where('turno_id', $asignatura->turno_id)
                            ->where('paralelo', $asignatura->paralelo)
                            ->where('anio_vigente', $asignatura->anio_vigente)
                            ->where('trimestre', $i)
                            ->whereNull('finalizado')
                            ->first();
            if($bimestre)
            {
                $bimestre   = $i;
                break;
            }
        }
        // Verificamos que en el caso de que el valor de bimestre NO exista
        if(!$bimestre)
        {
            // $bimestre tomara el valor de 0, y en ese caso es un indicador de que finalizo todos los registros de notas
            $bimestre   = 0;
        }
        return view('nota.detalle')->with(compact('asignatura', 'inscritos', 'notas', 'ciclo', 'bimestre', 'comboTurnos', 'bimestreActual'));
    }

    public function ajaxMuestraNota(Request $request)
    {
        $asignatura = NotasPropuesta::where('asignatura_id', $request->asignatura_id)
                                    ->where('turno_id', $request->turno_id)
                                    ->where('docente_id', Auth::user()->id)
                                    ->where('paralelo', $request->paralelo)
                                    ->where('anio_vigente', $request->anio_vigente)
                                    ->first();
        $notas = Nota::where('asignatura_id', $request->asignatura_id)
                    ->where('turno_id', $request->turno_id)
                    ->where('persona_id', $request->persona_id)
                    ->where('paralelo', $request->paralelo)
                    ->where('anio_vigente', $request->anio_vigente)
                    ->where('trimestre', $request->bimestre)
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

    // public function exportarexcel(Request $request)
    // {
    //     return Excel::download(new NotasExport($request->id), date('Y-m-d').'-ListadoNotas.xlsx');
    // }

    public function exportarexcel($asignatura_id, $bimestre)
    {
        $asignatura = NotasPropuesta::find($asignatura_id);
        $nombreAsignatura = $asignatura->asignatura->nombre;
        // dd($nombreAsignatura);
        return Excel::download(new NotasExport($asignatura_id, $bimestre), date('Y-m-d')."-$nombreAsignatura.xlsx");
    }

    public function actualizar(Request $request)
    {
        $val = 1;                                   // Variable para validacion de notas $val=1 ->todo en orden $val=0 -> error
        $nota = Nota::find($request->id);           // Encuentra la nota con el registro $id
        $ponderacion = NotasPropuesta::where('asignatura_id', $nota->asignatura_id)
                                    ->where('turno_id', $nota->turno_id)
                                    ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
                                            ->where('docente_id', $nota->docente_id)
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
            $inscripcion = Inscripcione::where('asignatura_id', $nota->asignatura_id)
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
            // Sumar sus notas totales en un registro           REVISAR
            $notas = Nota::groupBy('persona_id')
                        ->selectRaw('persona_id, sum(nota_total) as total')
                        ->where('asignatura_id', $request->asignatura_id)
                        ->where('turno_id', $request->turno_id)
                        ->where('paralelo', $request->paralelo)
                        ->where('anio_vigente', $request->anio_vigente)
                        ->get();
            // dd($notas);
            // Por cada registro guardar en inscripcion
            foreach($notas as $nota){
                $inscripcion = Inscripcione::where('asignatura_id', $request->asignatura_id)
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

    public function finalizarBimestre($nota_propuesta_id, $bimestre)
    {
        $nota_propuesta = NotasPropuesta::find($nota_propuesta_id);
        $notas  = Nota::where('asignatura_id', $nota_propuesta->asignatura_id)
                        ->where('turno_id', $nota_propuesta->turno_id)
                        ->where('paralelo', $nota_propuesta->paralelo)
                        ->where('anio_vigente', $nota_propuesta->anio_vigente)
                        // ->where('docente_id', $nota_propuesta->docente_id)
                        ->where('trimestre', $bimestre)
                        ->get();
        $base   = Nota::where('asignatura_id', $nota_propuesta->asignatura_id)
                    ->where('turno_id', $nota_propuesta->turno_id)
                    ->where('paralelo', $nota_propuesta->paralelo)
                    ->where('anio_vigente', $nota_propuesta->anio_vigente)
                    ->first();
        $inscripcion    = Inscripcione::where('id', $base->inscripcion_id)
                                    ->first();
        
        // Verificamos como se lleva a cabo esta asignatura, si es semestral o anual
        if($nota_propuesta->asignatura->ciclo == 'Semestral')
        {
            // Finalizaremos 2 bimestres, dependiendo de la variable de entrada
            // Preguntaremos si $bimestre es 1 o 2
            if($bimestre == 1)
            {
                // Buscamos los registros del bimestre 3
                $notas_anexo    = Nota::where('asignatura_id', $nota_propuesta->asignatura_id)
                                    ->where('turno_id', $nota_propuesta->turno_id)
                                    ->where('paralelo', $nota_propuesta->paralelo)
                                    ->where('anio_vigente', $nota_propuesta->anio_vigente)
                                    // ->where('docente_id', $nota_propuesta->docente_id)
                                    ->where('trimestre', 3)
                                    ->get();
                // Finalizamos bimestre 1 y 3
                foreach($notas as $nota)
                {
                    $nota->finalizado = 'Si';
                    $nota->save();
                }
                foreach($notas_anexo as $nota)
                {
                    $nota->finalizado = 'Si';
                    $nota->save();
                }
            }
            if($bimestre == 2)
            {
                // Buscamos los registros del bimestre 3
                $notas_anexo    = Nota::where('asignatura_id', $nota_propuesta->asignatura_id)
                                    ->where('turno_id', $nota_propuesta->turno_id)
                                    ->where('paralelo', $nota_propuesta->paralelo)
                                    ->where('anio_vigente', $nota_propuesta->anio_vigente)
                                    // ->where('docente_id', $nota_propuesta->docente_id)
                                    ->where('trimestre', 4)
                                    ->get();
                // Finalizamos bimestre 2 y 4
                foreach($notas as $nota)
                {
                    $nota->finalizado = 'Si';
                    $nota->save();
                }
                foreach($notas_anexo as $nota)
                {
                    $nota->finalizado = 'Si';
                    $nota->save();
                }
            }
        }
        else
        {
            // Finalizaremos bimestre por bimestre
            foreach($notas as $nota)
            {
                $nota->finalizado = 'Si';
                $nota->save();
            }
        }
        // Analizamos si todos los bimestre estan finalizados y si es asi, en inscripciones cambiamos el estado a Finalizado
        $no_finalizado  = Nota::where('asignatura_id', $nota_propuesta->asignatura_id)
                                ->where('turno_id', $nota_propuesta->turno_id)
                                ->where('paralelo', $nota_propuesta->paralelo)
                                ->where('anio_vigente', $nota_propuesta->anio_vigente)
                                // ->where('docente_id', $nota_propuesta->docente_id)
                                ->whereNull('finalizado')
                                ->first();
        if(!$no_finalizado)
        {
            // No existen registros que esten pendientes por calificar, por tanto en inscripciones, el estado se vuelve finalizado
            // Tenemos que buscar a las personas inscritas en esta asignatura
            $inscritos  = Inscripcione::where('asignatura_id', $nota_propuesta->asignatura_id)
                                    ->where('turno_id', $nota_propuesta->turno_id)
                                    ->where('paralelo', $nota_propuesta->paralelo)
                                    ->where('anio_vigente', $nota_propuesta->anio_vigente)
                                    // ->where('docente_id', $nota_propuesta->docente_id)
                                    ->get();
            foreach($inscritos as $inscrito)
            {
                $inscrito->estado = 'Finalizado';
                $inscrito->save();
            }
            // Ahora evaluaremos el estado de todas las asignaturas correspondientes a esta gestion
            // Buscamos las inscripciones correspondientes a esta gestion X
            $inscripciones  = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                        ->where('persona_id', $inscripcion->persona_id)
                                        ->where('gestion', $inscripcion->gestion)
                                        ->where('anio_vigente', $inscripcion->anio_vigente)
                                        ->get();
            // Hallamos la cantidad de materias inscritas
            $cantidadInscritas  = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                            ->where('persona_id', $inscripcion->persona_id)
                                            ->where('gestion', $inscripcion->gestion)
                                            ->where('anio_vigente', $inscripcion->anio_vigente)
                                            ->count();
            // Hallamos la cantidad de materias inscritas que finalizaron
            $cantidadFinalizadas    = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                                ->where('persona_id', $inscripcion->persona_id)
                                                ->where('gestion', $inscripcion->gestion)
                                                ->where('anio_vigente', $inscripcion->anio_vigente)
                                                ->where('estado', 'Finalizado')
                                                ->count();
            // Verificamos que se hayan finalizado todas las materias inscritas
            if($cantidadInscritas == $cantidadFinalizadas)
            {
                // Crearemos una variable para contar las materias que se aprobaron
                $cantidadAprobadas = 0;
                // Iteramos sobre las inscripciones para ver cuantas se aprobaron
                foreach($inscripciones as $materia)
                {
                    if($materia->aprobo == 'Si')
                    {
                        $cantidadAprobadas++;
                    }
                }
                // Buscaremos en la tabla carreras_personas el registro que esta asociado a estas inscripciones
                $carrerasPersona    = CarrerasPersona::where('carrera_id', $inscripcion->carrera_id)
                                                    ->where('persona_id', $inscripcion->persona_id)
                                                    ->where('gestion', $inscripcion->gestion)
                                                    ->where('anio_vigente', $inscripcion->anio_vigente)
                                                    ->first();
                // Si existe un registro que corresponda al grupo de inscripciones
                if($carrerasPersona)
                {
                    // Evaluamos si se aprobo la gestion o no
                    if($cantidadAprobadas == $cantidadInscritas)
                    {
                        $carrerasPersona->estado    = 'APROBO';
                    }
                    else
                    {
                        $carrerasPersona->estado    = 'REPROBO';
                    }
                    $carrerasPersona->save();
                }
            }
        }
        return redirect('nota/detalle/'.$nota_propuesta_id);
    }

    public function segundoTurno(Request $request)
    {
        $inscripcion    = Inscripcione::find($request->inscripcion_id);
        $segundo_turno  = SegundosTurno::where('inscripcion_id', $inscripcion->id)
                                        ->first();
        if($segundo_turno)
        {
            // reemplazar nota
            $segundo_turno->user_id         = Auth::user()->id;
            $segundo_turno->fecha_examen    = date('Y-m-d');
            $segundo_turno->nota_examen     = $request->nota_segundo_turno;
            $segundo_turno->save();
        }
        else
        {
            // Crear un registro nuevo
            $segundo_turno                  = new SegundosTurno();
            $segundo_turno->user_id         = Auth::user()->id;
            $segundo_turno->inscripcion_id  = $inscripcion->id;
            $segundo_turno->carrera_id      = $inscripcion->carrera_id;
            $segundo_turno->asignatura_id   = $inscripcion->asignatura_id;
            $segundo_turno->turno_id        = $inscripcion->turno_id;
            $segundo_turno->persona_id      = $inscripcion->persona_id;
            $segundo_turno->fecha_examen    = date('Y-m-d');
            $segundo_turno->cedula          = $inscripcion->persona->cedula;
            $segundo_turno->nota_examen     = $request->nota_segundo_turno;
            $segundo_turno->save();
        }

        // Actualizamos la nota en la inscripcion
        $nota   = ($request->nota_segundo_turno >= $inscripcion->nota_aprobacion ? '61' : '40');
        $aprobo = ($nota == '61' ? 'Si' : 'No');
        $inscripcion->segundo_turno = $nota;
        $inscripcion->aprobo        = $aprobo;
        $inscripcion->save();

        // // Colocamos en los registros de la nota el valor que obtuvo el estudiante
        // $notas = Nota::where('asignatura_id', $inscripcion->asignatura_id)
        //                 ->where('persona_id', $inscripcion->persona_id)
        //                 ->where('turno_id', $inscripcion->turno_id)
        //                 ->where('paralelo', $inscripcion->paralelo)
        //                 ->where('anio_vigente', $inscripcion->anio_vigente)
        //                 ->get();
        // foreach($notas as $nota)
        // {
        //     $nota->segundo_turno = $request->nota_segundo_turno;
        //     $nota->save();
        // }

        // if($request->nota_segundo_turno >= 61)
        // {
        //     $inscripcion->nota = 61;
        //     $inscripcion->save();
        // }
        return redirect('nota/listado');
    }

    public function ajaxBuscaParalelo(Request $request)
    {
        // dd($request->turno);
        $comboParalelos = NotasPropuesta::where('turno_id', $request->turno)
                                        ->where('asignatura_id', $request->asignatura)
                                        ->where('docente_id', Auth::user()->id)
                                        ->where('anio_vigente', $request->anio)
                                        ->get();

        return view('nota.ajaxBuscaParalelo')->with(compact('comboParalelos'));
    }

    public function cambiaTurnoParalelo(Request $request)
    {
        // dd($request->all());
        $notasPropuestaId = NotasPropuesta::where('turno_id', $request->turno_id)
                                        ->where('asignatura_id', $request->asignatura_id)
                                        ->where('docente_id', Auth::user()->id)
                                        ->where('anio_vigente', $request->anio)
                                        ->where('paralelo', $request->paralelo)
                                        ->first();
        // dd($notasPropuestaId);
        return redirect('nota/detalle/' . $notasPropuestaId->id);
    }

    public function ajaxRegistraNota(Request $request)
    {
        // dd($request->all());

        $nota = Nota::where('inscripcion_id', $request->id)
                    ->where('trimestre', $request->numero)
                    ->first();
        
        $registro = Nota::find($nota->id);

        switch ($request->tipo) {
            case 'asistencia':
                $registro->nota_asistencia = $request->nota;
                break;

            case 'practica':
                $registro->nota_practicas = $request->nota;
                break;

            case 'parcial':
                $registro->nota_primer_parcial = $request->nota;
                break;

            case 'examen':
                $registro->nota_examen_final = $request->nota;
                break;

            case 'extras':
                $registro->nota_puntos_ganados = $request->nota;
                break;

            case 'total':
                $registro->nota_total = $request->nota;
                break;

            default:
                # code...
                break;
        }
        $registro->docente_id = Auth::user()->id;
        $registro->save();

    }
    
}
