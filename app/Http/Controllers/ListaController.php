<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\Asignatura;
use App\Carrera;
use App\Inscripcione;
use App\Persona;
use App\Turno;

class ListaController extends Controller
{
    public function alumnos()
    {
        $carreras   = Carrera::whereNull('estado')->get();
        $cursos     = Asignatura::select('gestion')
                                ->groupBy('gestion')
                                ->get();
        $gestiones  = Inscripcione::select('anio_vigente')
                                ->groupBy('anio_vigente')
                                ->get();
        $paralelos  = Inscripcione::select('paralelo')
                                ->groupBy('paralelo')
                                ->get();
        $turnos     = Turno::get();
        return view('lista.alumnos')->with(compact('carreras', 'cursos', 'gestiones', 'paralelos', 'turnos'));
    }

    public function ajaxBusquedaAlumnos(Request $request)
    {
        $resultado = DB::table('inscripciones')
                        ->whereNull('inscripciones.deleted_at')
                        ->where('inscripciones.carrera_id', $request->carrera)
                        ->where('inscripciones.gestion', $request->curso)
                        ->where('inscripciones.turno_id', $request->turno)
                        //->where('inscripciones.paralelo', $request->paralelo)
                        ->where('inscripciones.anio_vigente', $request->gestion)
                        // consulta de alumno vigente/novigente
                        ->leftJoin('personas', 'inscripciones.persona_id', '=', 'personas.id')
                        ->select(
                            'personas.cedula as cedula',
                            'personas.apellido_paterno as apellido_paterno',
                            'personas.apellido_materno as apellido_materno',
                            'personas.nombres as nombres',
                            'personas.numero_celular as numero_celular',
                            'personas.estado as estado'
                        )
                        ->groupBy('inscripciones.persona_id');
        return Datatables::of($resultado)->make(true);

        // $resultado = Inscripcione::with('persona')
        //                         ->where('carrera_id', $request->carrera)
        //                         ->where('gestion', $request->curso)
        //                         ->where('turno_id', $request->turno)
        //                         //->where('paralelo', $request->paralelo)
        //                         ->where('anio_vigente', $request->gestion)
        //                         // consulta de alumno vigente/novigente
        //                         ->get();
        // //dd($resultado);
        // // Envio de los datos a la vista
        // return Datatables::of($resultado)
        //                 ->addColumn('persona', function (Inscripcione $inscripcion){ $inscripcion->persona->cedula; })
        //                 ->make(true);


    }
}
