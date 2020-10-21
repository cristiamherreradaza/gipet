<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\NotasPropuesta;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\NotasPropuestasExport;
use App\Imports\NotasPropuestasImport;
use Validator;
use DB;

class NotasPropuestaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado()
    {
        $usuario = Auth::user();
        $asignaturas = NotasPropuesta::where('docente_id', Auth::user()->id)
                                    ->where('anio_vigente', date('Y'))
                                    ->get();
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
        return Excel::download(new NotasPropuestasExport($request->id), date('Y-m-d').'-ListadoPonderaciones.xlsx');
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
            return response()->json([
                'message' => 'Importación realizada con exito.',
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
                'message' => $mensaje,
                'sw' => 0
            ]);
        }
    }
}
