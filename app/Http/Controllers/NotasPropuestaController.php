<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\NotasPropuesta;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NotasPropuestasExport;
use App\Imports\NotasPropuestasImport;
use Validator;

class NotasPropuestaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado()
    {
        $usuario = Auth::user();
        $asignaturas = $usuario->notaspropuestas;
        return view('notaspropuesta.listado')->with(compact('usuario', 'asignaturas'));
    }

    public function actualizar(Request $request)
    {
        $notapropuesta = NotasPropuesta::find($request->id);
        $notapropuesta->fecha = date('Y-m-d H:i:s');
        $notapropuesta->nota_asistencia = $request->asistencia;
        $notapropuesta->nota_practicas = $request->practicas;
        $notapropuesta->nota_puntos_ganados = $request->puntos;
        $notapropuesta->nota_primer_parcial = $request->parcial;
        $notapropuesta->nota_examen_final = $request->final;
        $notapropuesta->save();
    }

    public function exportarexcel(Request $request)
    {
        return Excel::download(new NotasPropuestasExport($request->id), 'notas-propuestas-list.xlsx');
    }

    public function ajax_importar(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xlsx|max:2048'
        ]);
        if($validation->passes())
        {
            $file = $request->file('select_file');
            Excel::import(new NotasPropuestasImport, $file);
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
}
