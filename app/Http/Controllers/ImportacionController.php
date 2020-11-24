<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataExport;
use App\Imports\DataImport;
use App\Asignatura;
use App\Carrera;
use App\CarrerasPersona;
use App\Turno;
use Validator;

class ImportacionController extends Controller
{
    public function excel()
    {
        $carreras   = Carrera::whereNull('estado')->get();
        $turnos     = Turno::get();
        $paralelos  = CarrerasPersona::select('paralelo')
                                ->groupBy('paralelo')
                                ->get();
        $gestiones  = CarrerasPersona::select('anio_vigente')
                                ->groupBy('anio_vigente')
                                ->get();
        return view('excel.excel')->with(compact('carreras', 'gestiones', 'paralelos', 'turnos'));
    }

    public function exportar($carrera, $turno, $paralelo, $anio_vigente)
    {
        return Excel::download(new DataExport($carrera, $turno, $paralelo, $anio_vigente), date('Y-m-d').'-formatoImportacion.xlsx');
    }

    public function importar(Request $request)
    {
        //dd($request->asignatura);
        $validation = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xlsx|max:2048'
        ]);
        if($validation->passes())
        {
            $file = $request->file('select_file');
            Excel::import(new DataImport, $file);

            //dd('hola');
            // Una vez cargado los datos de los estudiantes de la materia, actualizar sus datos, en la tabla inscripciones
            // Capturar todas las notas correspondientes a esa materia
            // $notas = Nota::where('asignatura_id', $request->asignatura_id)
            //             ->where('turno_id', $request->turno_id)
            //             ->where('paralelo', $request->paralelo)
            //             ->where('anio_vigente', $request->anio_vigente)
            //             ->get();
            // Sumar sus notas totales en un registro           REVISAR
            // $notas = Nota::groupBy('persona_id')
            //             ->selectRaw('persona_id, sum(nota_total) as total')
            //             ->where('asignatura_id', $request->asignatura_id)
            //             ->where('turno_id', $request->turno_id)
            //             ->where('paralelo', $request->paralelo)
            //             ->where('anio_vigente', $request->anio_vigente)
            //             ->get();
            // dd($notas);
            // Por cada registro guardar en inscripcion
            // foreach($notas as $nota){
            //     $inscripcion = Inscripcione::where('asignatura_id', $request->asignatura_id)
            //                                 ->where('turno_id', $request->turno_id)
            //                                 ->where('persona_id', $nota->persona_id)
            //                                 ->where('paralelo', $request->paralelo)
            //                                 ->where('anio_vigente', $request->anio_vigente)
            //                                 ->first();
            //     $inscripcion->nota = round($nota->total/4);
            //     $inscripcion->save();
            // }
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
}
