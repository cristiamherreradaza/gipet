<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use DataTables;
use App\Asignatura;
use App\Carrera;
use App\CarrerasPersona;
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
        $turnos     = Turno::get();
        $paralelos  = CarrerasPersona::select('paralelo')
                                ->groupBy('paralelo')
                                ->get();
        $gestiones  = CarrerasPersona::select('anio_vigente')
                                ->groupBy('anio_vigente')
                                ->get();
        $estados    = CarrerasPersona::select('vigencia')
                                    ->groupBy('vigencia')
                                    ->orderBy('vigencia', 'desc')
                                    ->get();
        return view('lista.alumnos')->with(compact('carreras', 'cursos', 'gestiones', 'paralelos', 'turnos', 'estados'));
    }

    public function ajaxBusquedaAlumnos(Request $request)
    {
        $resultado = DB::table('carreras_personas')
                        ->whereNull('carreras_personas.deleted_at')
                        ->where('carreras_personas.carrera_id', $request->carrera)
                        ->where('carreras_personas.gestion', $request->curso)
                        ->where('carreras_personas.turno_id', $request->turno)
                        ->where('carreras_personas.paralelo', $request->paralelo)
                        ->where('carreras_personas.anio_vigente', $request->gestion)
                        ->where('carreras_personas.vigencia', $request->estado)
                        ->leftJoin('personas', 'carreras_personas.persona_id', '=', 'personas.id')
                        ->orderBy('personas.apellido_paterno')
                        ->orderBy('personas.apellido_materno')
                        ->orderBy('personas.nombres')
                        ->select(
                            'personas.cedula as cedula',
                            'personas.apellido_paterno as apellido_paterno',
                            'personas.apellido_materno as apellido_materno',
                            'personas.nombres as nombres',
                            'personas.numero_celular as numero_celular',
                            'carreras_personas.vigencia as estado'
                        );
                        //->groupBy('carreras_personas.persona_id');
        return Datatables::of($resultado)->make(true);
        // $resultado = DB::table('inscripciones')
        //                 ->whereNull('inscripciones.deleted_at')
        //                 ->where('inscripciones.carrera_id', $request->carrera)
        //                 ->where('inscripciones.gestion', $request->curso)
        //                 ->where('inscripciones.turno_id', $request->turno)
        //                 //->where('inscripciones.paralelo', $request->paralelo)
        //                 ->where('inscripciones.anio_vigente', $request->gestion)
        //                 // consulta de alumno vigente/novigente
        //                 ->leftJoin('personas', 'inscripciones.persona_id', '=', 'personas.id')
        //                 ->select(
        //                     'personas.cedula as cedula',
        //                     'personas.apellido_paterno as apellido_paterno',
        //                     'personas.apellido_materno as apellido_materno',
        //                     'personas.nombres as nombres',
        //                     'personas.numero_celular as numero_celular',
        //                     'personas.estado as estado'
        //                 )
        //                 ->groupBy('inscripciones.persona_id');
        // return Datatables::of($resultado)->make(true);

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

    public function reportePdfAlumnos($carrera_id, $curso_id, $turno_id, $paralelo, $gestion, $estado)
    {
        $listado    = CarrerasPersona::where('carrera_id', $carrera_id)
                                    ->where('gestion', $curso_id)
                                    ->where('turno_id', $turno_id)
                                    ->where('paralelo', $paralelo)
                                    ->where('anio_vigente', $gestion)
                                    ->where('vigencia', $estado)
                                    ->get();
        $pdf    = PDF::loadView('pdf.listaAlumnoCarreraCursoTurnoParalelo', compact('listado'))->setPaper('letter');
        // return $pdf->download('boletinInscripcion_'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream('listaAlumnos_'.date('Y-m-d H:i:s').'.pdf');
    }
}
