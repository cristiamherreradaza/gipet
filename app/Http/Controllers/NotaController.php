<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;   
use App\NotasPropuesta;
use App\Nota;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NotasExport;
use App\Imports\NotasImport;
use Validator;


class NotaController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function listado()
    {
        $usuario = Auth::user();
        $asignaturas = $usuario->notaspropuestas;
        return view('nota.listado')->with(compact('asignaturas'));
    }

    public function detalle($id)
    {
        $asignatura = NotasPropuesta::find($id);
        $notas = Nota::where('asignatura_id', $asignatura->asignatura_id)
                    ->where('turno_id', $asignatura->turno_id)
                    ->where('user_id', $asignatura->user_id)
                    ->where('paralelo', $asignatura->paralelo)
                    ->where('gestion', $asignatura->gestion)
                    ->get();
        return view('nota.detalle')->with(compact('asignatura', 'notas'));
    }

    public function segundoTurno($id)
    {
        $asignatura = NotasPropuesta::find($id);
        $segundoTurno = Nota::where('asignatura_id', $asignatura->asignatura_id)
                    ->where('turno_id', $asignatura->turno_id)
                    ->where('user_id', $asignatura->user_id)
                    ->where('paralelo', $asignatura->paralelo)
                    ->where('gestion', $asignatura->gestion)
                    ->whereBetween('nota_total', [30,50])
                    ->get();
        return view('nota.segundoTurno')->with(compact('asignatura', 'segundoTurno'));
    }

    public function segundoTurnoActualizar(Request $request)
    {
        $nota = Nota::find($request->id);
        $nota->segundo_turno = $request->segundo_turno;
        $nota->nota_total = $request->segundo_turno;
        $nota->save();
    }



    

    public function detalle2(Request $request)
    {        
        $notapropuesta = NotasPropuesta::find($request->id);
        $notas = Nota::where('asignatura_id', $notapropuesta->asignatura_id)
                    ->where('turno_id', $notapropuesta->turno_id)
                    ->where('user_id', $notapropuesta->user_id)
                    ->where('paralelo', $notapropuesta->paralelo)
                    ->where('gestion', $notapropuesta->gestion)
                    ->get();
        return view('nota.detalle')->with(compact('notapropuesta', 'notas'));
    }
    
    public function show2()
    {
        $usuario = Auth::user();
        $asignaturas = $usuario->notaspropuestas;
        return view('nota.show2')->with(compact('asignaturas'));
    }

    public function detalle1(Request $request)
    {        
        $notapropuesta = NotasPropuesta::find($request->id);
        $notas = Nota::where('asignatura_id', $notapropuesta->asignatura_id)
                    ->where('turno_id', $notapropuesta->turno_id)
                    ->where('user_id', $notapropuesta->user_id)
                    ->where('paralelo', $notapropuesta->paralelo)
                    ->where('gestion', $notapropuesta->gestion)
                    ->get();
                    //dd($notas);
        return $notas;
    }

    public function show()
    {
        $usuario = Auth::user();
        $asignaturas = $usuario->notaspropuestas;
        return view('nota.show')->with(compact('asignaturas'));
    }

    public function asignatura($id)
    {
        $propuesta = NotasPropuesta::find($id);
        $alumnos = Nota::where('asignatura_id', $propuesta->asignatura_id)
                        ->where('turno_id', $propuesta->turno_id)
                        ->where('user_id', $propuesta->user_id)
                        ->where('paralelo', $propuesta->paralelo)
                        ->where('gestion', date('Y'))
                        ->get();
        return view('nota/asignatura')->with(compact('propuesta', 'alumnos'));
    }

    // public function listado()
    // {
    //     $usuario = Auth::user();
    //     $asignaturas = $usuario->notaspropuestas;
    //     $cursantes = $usuario->notas;
    //     return view('nota.listado')->with(compact('usuario', 'asignaturas', 'cursantes'));
    // }

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
    }

    // public function exportarexcel()
    // {
    //     return Excel::download(new NotasExport, 'notas-list.xlsx');
    // }

    public function exportarexcel(Request $request)
    {
        return Excel::download(new NotasExport($request->id), 'notas-list.xlsx');
        //$date = date('Y-m-d H:i:s');
        //return (new NotasExport($request->id))->download($date.'notas-list.xlsx'); 
    }

    public function importarexcel(Request $request)
    {
        $file = $request->file('file');
        Excel::import(new NotasImport, $file);
        return back()->with('message', 'Importacion de notas completada');
    }

    /*
    public function exportarexcel($id)
    {
        Excel::create('Notas', function($excel) use ($id) {
            $excel->sheet('Datos', function($sheet) use ($id) {
                $notapropuesta = NotasPropuesta::find($id);
                $nota = Nota::where('asignatura_id', $notapropuesta->asignatura_id)
                    ->where('turno_id', $notapropuesta->turno_id)
                    ->where('user_id', $notapropuesta->user_id)
                    ->where('paralelo', $notapropuesta->paralelo)
                    ->where('gestion', $notapropuesta->gestion)
                    ->get();
                $sheet->fromArray($nota);
            });
        })->export('xls');
    }
    */

    public function ajax_importar(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xlsx|max:2048'
        ]);
        if($validation->passes())
        {
            $file = $request->file('select_file');
            Excel::import(new NotasImport, $file);
            //todo el proceso de excel
            //alert('bien');
            return response()->json([
                //1
                'message' => 'Importacion realizada con exito',
                'sw' => 1,
                'class_name' => 'alert-success'
            ]);
        }
        else
        {
            //alert('mal');
            return response()->json([
                //0
                'message' => $validation->errors()->all(),
                'sw' => 0,
                'class_name' => 'alert-danger'
            ]);
        }
    }

    public function index(Request $request)
    {   
        $usuario = Auth::user();

        // buscamos a las materias que propuso el docente (que esta dictando)
        $asignaturas = $usuario->notaspropuestas;

        // foreach($asignaturas as $row){
        //     echo $row->asignatura->nombre_asignatura;
        // }

        // buscamos a los alumnos que estan pasando clases con este docente
        $cursantes = $usuario->notas;

        // foreach($cursantes as $row){
        //     echo $row->persona->apellido_paterno . "<br>";
        // }

        
        /* imprimimos a las materias con sus respectivos estudiantes que estan tomando materias con el docente X

        foreach($asignaturas as $x){
            echo $x->asignatura->nombre_asignatura . "<br>";
            echo $x->id . "<br>";
            foreach($cursantes as $y){
                if($x->asignatura_id == $y->asignatura_id){
                    echo $y->persona->apellido_paterno . "<br>";
                }
            }
        }

        */
        
        //dd($cursantes);

        return view('nota.index')->with(compact('usuario', 'asignaturas', 'cursantes'));
    }

}
