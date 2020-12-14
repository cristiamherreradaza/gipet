<?php

namespace App\Http\Controllers;

use App\Turno;
use DataTables;
use App\Carrera;
use App\Persona;
use App\Asignatura;
use App\Inscripcione;
use App\CarrerasPersona;
use Illuminate\Http\Request;
use App\Exports\PersonasExport;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
        $array_personas = array();
        foreach($listado as $registro)
        {
            array_push($array_personas, $registro->persona_id);
        }
        $estudiantes    = Persona::whereIn('id', $array_personas)
                                ->orderBy('apellido_paterno')
                                ->orderBy('apellido_materno')
                                ->orderBy('nombres')
                                ->get();
        $pdf    = PDF::loadView('pdf.listaAlumnoCarreraCursoTurnoParalelo', compact('listado', 'estudiantes', 'estado'))->setPaper('letter');
        // return $pdf->download('boletinInscripcion_'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream('listaAlumnos_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function reporteExcelAlumnos($carrera_id, $curso_id, $turno_id, $paralelo, $gestion, $estado)
    {
        return Excel::download(new PersonasExport($carrera_id, $curso_id, $turno_id, $paralelo, $gestion, $estado), date('Y-m-d') . '-listado.xlsx');

    }

    public function totalALumnos()
    {
        $carreras   = Carrera::get();
        $gestiones  = CarrerasPersona::select('anio_vigente')
                                ->groupBy('anio_vigente')
                                ->get();
        return view('lista.totalAlumnos')->with(compact('carreras', 'gestiones'));
    }

    public function ajaxTotalAlumnos(Request $request)
    {
        // si tiene carrera, se busca solo la carrera, si no tiene, es todas las carreras
        $query   = Carrera::whereNull('estado')
                        ->orderBy('id');
        if($request->carrera)
        {
            $query  = $query->where('id', $request->carrera);
        }
        $carreras   = $query->get();
        $turnos     = Turno::get();
        return view('lista.ajaxTotalAlumnos')->with(compact('carreras', 'turnos'));
    }

    public function reportePdfTotalAlumnos($carrera_id)
    {
        $query   = Carrera::whereNull('estado')
                        ->orderBy('id');
        if($carrera_id != 0)
        {
            $query  = $query->where('id', $carrera_id);
        }
        $carreras   = $query->get();
        $turnos     = Turno::get();
        $pdf    = PDF::loadView('pdf.reportePdfTotalAlumnos', compact('carreras', 'turnos'))->setPaper('letter');
        // return $pdf->download('boletinInscripcion_'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream('cantidadAlumnos_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function estadistica()
    {

    }

    public function pruebaAleatorio()
    {
        // Encontrar esa inscripcion
        // Ver cual es la nota minima de aprobacion
        // Ver cual es sus maximos estimados para cada puntaje, asistencia, practicas, primer_parcial, examen_final y extras
        // Generar 5 numeros aleatorios que sumandolos hagan un total de nota_minima_aprobacion (61) en 4 ocasiones.

        // TENEMOS LAS NOTAS MAXIMAS
        $maximo_asistencia      = 10;
        $maximo_practicas       = 20;
        $maximo_primer_parcial  = 30;
        $maximo_examen_final    = 40;
        $maximo_extras          = 10;

        // TENEMOS LA NOTA MINIMA DE APROBACION
        $minimo = 61;

        // ITERAMOS PARA ENCONTRAR LA NOTA
        do {
            $total  = 0;
            $aleatorio_asistencia       =  mt_rand(1, $maximo_asistencia);
            $aleatorio_practicas        =  mt_rand(1, $maximo_practicas);
            $aleatorio_primer_parcial   =  mt_rand(1, $maximo_primer_parcial);
            $aleatorio_examen_final     =  mt_rand(1, $maximo_examen_final);
            $aleatorio_extras           =  mt_rand(1, $maximo_extras);
            $total = $aleatorio_asistencia + $aleatorio_practicas + $aleatorio_primer_parcial + $aleatorio_examen_final + $aleatorio_extras;
        } while( $total <> $minimo);

        echo $total . "<br>";
        echo 'Nota asistencia: ' . $aleatorio_asistencia . "<br>";
        echo 'Nota practicas: ' . $aleatorio_practicas . "<br>";
        echo 'Nota primer parcial: ' . $aleatorio_primer_parcial . "<br>";
        echo 'Nota examen final: ' . $aleatorio_examen_final . "<br>";
        echo 'Nota extras: ' . $aleatorio_extras . "<br>";
        dd($total);

        // TENEMOS QUE ITERARLOS HASTA LOGRAR EL MINIMO DESEADO
        // $aleatorio_asistencia       =  mt_rand(1, $maximo_asistencia);
        // $aleatorio_practicas        =  mt_rand(1, $maximo_practicas);
        // $aleatorio_primer_parcial   =  mt_rand(1, $maximo_primer_parcial);
        // $aleatorio_examen_final     =  mt_rand(1, $maximo_examen_final);
        // $aleatorio_extras           =  mt_rand(1, $maximo_extras);
        // dd($aleatorio);
    }
}
