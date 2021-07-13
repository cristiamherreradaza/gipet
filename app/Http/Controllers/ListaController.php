<?php

namespace App\Http\Controllers;

use App\Nota;
use App\User;
use App\Turno;
use DataTables;
use App\Carrera;
use App\Persona;
use App\Asignatura;
use App\Inscripcione;
use App\NotasPropuesta;
use App\CarrerasPersona;
use Illuminate\Http\Request;
use App\Exports\PersonasExport;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

        return view('lista.alumnos')->with(compact('carreras', 'cursos', 'gestiones', 'paralelos', 'turnos', 'estados'));
    }

    public function ajaxBusquedaAlumnos(Request $request)
    {
        // dd($request->all());
        if($request->estado == 'todos'){
            $resultado = CarrerasPersona::where('carreras_personas.carrera_id', $request->carrera)
                            ->where('carreras_personas.gestion', $request->gestion)
                            ->where('carreras_personas.turno_id', $request->turno)
                            ->where('carreras_personas.paralelo', $request->paralelo)
                            ->where('carreras_personas.anio_vigente', $request->anio_vigente)
                            // ->where('carreras_personas.estado', $request->estado)
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
                                'carreras_personas.estado as estado'
                            );

        }else{
            $resultado = CarrerasPersona::where('carreras_personas.carrera_id', $request->carrera)
                            ->where('carreras_personas.gestion', $request->gestion)
                            ->where('carreras_personas.turno_id', $request->turno)
                            ->where('carreras_personas.paralelo', $request->paralelo)
                            ->where('carreras_personas.anio_vigente', $request->anio_vigente)
                            ->where('carreras_personas.estado', $request->estado)
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
                                'carreras_personas.estado as estado'
                            );
            
        }
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

    public function notas()
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
        return view('lista.notas')->with(compact('carreras', 'cursos', 'gestiones', 'paralelos', 'turnos', 'estados'));
    } 

    public function generaPdfCentralizadorNotas(Request $request)
    {
        $carrera    = $request->carrera_id;
        $curso      = $request->gestion;
        $turno      = $request->turno_id;
        $paralelo   = $request->paralelo;
        $gestion    = $request->anio_vigente;
        $tipo       = $request->tipo;
        $imp_nombre = $request->imprime_nombre;

        $datosTurno = Turno::find($request->turno_id);

        $datosCarrera = Carrera::find($request->carrera_id);
        
        $materiasCarrera = Asignatura::where('carrera_id', $request->carrera_id)
                            ->where('anio_vigente', $request->anio_vigente)
                            ->where('gestion', $request->gestion)
                            ->whereNull('estado')
                            ->orderBy('orden_impresion', 'asc')
                            ->get();

        // dd($materiasCarrera);

        $nominaEstudiantes = CarrerasPersona::select(
                                'personas.apellido_paterno',
                                'personas.apellido_materno',
                                'personas.nombres',
                                'carreras_personas.id',
                                'carreras_personas.carrera_id',
                                'carreras_personas.persona_id',
                                'carreras_personas.turno_id',
                                'carreras_personas.gestion',
                                'carreras_personas.paralelo',
                                'carreras_personas.fecha_inscripcion',
                                'carreras_personas.anio_vigente',
                                'carreras_personas.estado'
                            )
                            ->where('carreras_personas.anio_vigente', $request->anio_vigente)
                            ->where('carreras_personas.carrera_id', $request->carrera_id)
                            ->where('carreras_personas.gestion', $request->gestion)
                            ->where('carreras_personas.turno_id', $request->turno_id)
                            ->where('carreras_personas.paralelo', $request->paralelo)
                            ->leftJoin('personas', 'carreras_personas.persona_id' , '=', 'personas.id')
                            ->orderBy('personas.apellido_paterno', 'ASC')
                            ->groupBy('carreras_personas.persona_id')
                            ->get();

        // buscamos el anio de inscripcion del primer estudiante
        // para buscar las materias de esa gestion
        // dd($nominaEstudiantes[0]->id);

        return view('pdf.generaPdfCentralizadorNotas')->with(compact('carrera', 'curso', 'paralelo', 'turno', 'gestion', 'datosTurno', 'materiasCarrera', 'nominaEstudiantes', 'datosCarrera', 'tipo', 'imp_nombre'));

        // $pdf = PDF::loadView('pdf.centralizadorNotas', compact('carrera', 'curso', 'paralelo', 'turno', 'gestion', 'datosTurno', 'materiasCarrera', 'nominaEstudiantes', 'datosCarrera', 'tipo', 'imp_nombre'))->setPaper('letter', 'landscape');
        // return $pdf->download('centralizador.pdf');
        // return $pdf->stream('listaAlumnos_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function excelCentralizadorNotas(Request $request)
    {
        $carrera    = $request->carrera_id;
        $curso      = $request->gestion;
        $turno      = $request->turno_id;
        $paralelo   = $request->paralelo;
        $gestion    = $request->anio_vigente;
        $tipo       = $request->tipo;
        $imp_nombre = $request->imprime_nombre;

        $datosTurno = Turno::find($request->turno_id);

        $datosCarrera = Carrera::find($request->carrera_id);
        
        $materiasCarrera = Asignatura::where('carrera_id', $request->carrera_id)
                            ->where('anio_vigente', $request->anio_vigente)
                            ->where('gestion', $request->gestion)
                            ->whereNull('estado')
                            ->orderBy('orden_impresion', 'asc')
                            ->get();

        $nominaEstudiantes = CarrerasPersona::select(
                                'personas.apellido_paterno',
                                'personas.apellido_materno',
                                'personas.nombres',
                                'carreras_personas.id',
                                'carreras_personas.carrera_id',
                                'carreras_personas.persona_id',
                                'carreras_personas.turno_id',
                                'carreras_personas.gestion',
                                'carreras_personas.paralelo',
                                'carreras_personas.fecha_inscripcion',
                                'carreras_personas.anio_vigente',
                                'carreras_personas.estado'
                            )
                            ->where('carreras_personas.anio_vigente', $request->anio_vigente)
                            ->where('carreras_personas.carrera_id', $request->carrera_id)
                            ->where('carreras_personas.gestion', $request->gestion)
                            ->where('carreras_personas.turno_id', $request->turno_id)
                            ->where('carreras_personas.paralelo', $request->paralelo)
                            ->leftJoin('personas', 'carreras_personas.persona_id' , '=', 'personas.id')
                            ->orderBy('personas.apellido_paterno', 'ASC')
                            ->groupBy('carreras_personas.persona_id')
                            ->get();

        
        $fileName = 'certifica_notas.xlsx';
        // return Excel::download(new CertificadoExport($carrera_persona_id), 'certificado.xlsx');
        $spreadsheet = new Spreadsheet();
        
        // definimos la hoja excel
        $sheet = $spreadsheet->getActiveSheet();

        // definimos estilos
        $spreadsheet->getActiveSheet()->getRowDimension('4')->setRowHeight(55);

        /*$style = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'wrap' => true
            )
        );*/

        // $spreadsheet->getActiveSheet()->getStyle('C4:M4')->applyFromArray($style);

        $spreadsheet->getActiveSheet()->getStyle("C4:M4")->applyFromArray(
            array(
                'borders' => array(
                    'allBorders' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => array('argb' => '000000')
                    )
                ),
                'alignment' => array(
                    // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                )
            )
        );

        // definimos el ancho de la columna alumnos
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(22);

        // $spreadsheet->getRowDimension('4')->setRowHeight(-1);

        // $spreadsheet->getActiveSheet()->getColumnDimension('C:M')->setWidth(150);


        //colocamos los nombres de las materias
        $contadorLetras = 67;
        foreach ($materiasCarrera as $m) {
            // extraemos la letra para la celda
            $letra = chr($contadorLetras);

            $sheet->setCellValue($letra.'4', $m->nombre. ' '.$m->sigla);

            $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setWidth(18);

            $contadorLetras++;
        }

        // colocamos la lista de los alumnos
        $contadorAlumnos = 5;
        foreach($nominaEstudiantes as $e){

            if($e->apellido_paterno != null){
                $paterno = $e->apellido_paterno;
            }else{
                $paterno = '';
            }

            $nombreCompleto = $paterno.' '.$e->apellido_materno.' '.$e->nombres;

            $sheet->setCellValue("B".$contadorAlumnos, $nombreCompleto);
            $contadorAlumnos++;

            // colocamos las notas
            $contadorLetrasNotas = 67;
            foreach ($materiasCarrera as $mn) {

                if($tipo == 'primero'){
                    $nota = Nota::where('persona_id', $e->persona_id)
                    ->where('carrera_id', $carrera)
                    ->where('anio_vigente', $gestion)
                    ->where('paralelo', $paralelo)
                    ->where('asignatura_id', $mn->id)
                    ->where('trimestre', 1)
                    ->first();
                }elseif ($tipo == 'segundo') {
                    $nota = Nota::where('persona_id', $e->persona_id)
                    ->where('carrera_id', $carrera)
                    ->where('anio_vigente', $gestion)
                    ->where('paralelo', $paralelo)
                    ->where('asignatura_id', $mn->id)
                    ->where('trimestre', 2)
                    ->first();
                }else{
                    $nota = Inscripcione::where('persona_id', $e->persona_id)
                    ->where('carrera_id', $carrera)
                    ->where('anio_vigente', $gestion)
                    ->where('asignatura_id', $mn->id)
                    ->first();
                }

                $estado = CarrerasPersona::where('persona_id', $e->persona_id)
                ->where('carrera_id', $carrera)
                ->where('anio_vigente', $gestion)
                ->first();

                // extraemos la letra para la celda
                $letra = chr($contadorLetrasNotas);

                $sheet->setCellValue($letra . '5', $nota->nota);

                $spreadsheet->getActiveSheet()->getColumnDimension($letra)->setWidth(18);

                $contadorLetrasNotas++;

            }

        }





        

        

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
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
        $anio_vigente = $request->anio_vigente;
        // si tiene carrera, se busca solo la carrera, si no tiene, es todas las carreras
        $query   = Carrera::whereNull('estado')
                        ->orderBy('id');
        if($request->carrera)
        {
            $query  = $query->where('id', $request->carrera);
        }
        $carreras   = $query->get();
        $turnos     = Turno::get();
        return view('lista.ajaxTotalAlumnos')->with(compact('carreras', 'turnos', 'anio_vigente'));

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

    public function centralizadorAlumnos()
    {
        $gestiones = Nota::select('anio_vigente')
                    ->groupBy('anio_vigente')
                    ->orderBy('anio_vigente', 'desc')
                    ->get();

        // dd($gestiones);
        return view('lista.centralizadorAlumnos')->with(compact('gestiones'));
    }

    public function ajax_centralizador_docente(Request $request)
    {
        $docentes = NotasPropuesta::where('anio_vigente', $request->gestion)
                    ->whereNotNull('docente_id')
                    ->groupBy('docente_id')
                    ->get();

                    // dd($docentes);
        return view('lista.ajax_centralizador_docente')->with(compact('docentes'));

    }

    public function ajax_centralizador_materia(Request $request)
    {
        // dd($request->all());
        $materias = NotasPropuesta::where('anio_vigente', $request->gestion)
                    ->where('docente_id', $request->docente)
                    // ->whereNotNull('asignatura_id')
                    // ->groupBy('asignatura_id')
                    ->get();

        return view('lista.ajax_centralizador_materia')->with(compact('materias'));
    }

    public function ajax_centralizador_turno(Request $request)
    {
        $turnos = Nota::where('anio_vigente', $request->gestion)
                    // ->where('docente_id', $request->docente)
                    ->where('asignatura_id', $request->materia)
                    ->whereNotNull('turno_id')
                    ->groupBy('turno_id')
                    ->get();
        // dd($turnos);
        return view('lista.ajax_centralizador_turno')->with(compact('turnos'));
    }

    public function ajax_centralizador_paralelo(Request $request)
    {
        $paralelos = Nota::where('anio_vigente', $request->gestion)
                    // ->where('docente_id', $request->docente)
                    ->where('asignatura_id', $request->materia)
                    // ->where('turno_id', $request->turno)
                    ->whereNotNull('paralelo')
                    ->groupBy('paralelo')
                    ->get();
        // dd($paralelos);
        return view('lista.ajax_centralizador_paralelo')->with(compact('paralelos'));
    }

    public function ajax_centralizador_trimestre(Request $request)
    {
        $trimestre = Nota::where('anio_vigente', $request->gestion)
                    // ->where('docente_id', $request->docente)
                    ->where('asignatura_id', $request->materia)
                    // ->where('turno_id', $request->turno)
                    ->where('paralelo', $request->paralelo)
                    ->whereNotNull('trimestre')
                    ->groupBy('trimestre')
                    ->get();

        return view('lista.ajax_centralizador_trimestre')->with(compact('trimestre'));
    }

    public function genera_centralizador(Request $request)
    {
        // dd($request->all());
        $alumnos = Nota::select(
                            'personas.apellido_paterno', 
                            'personas.apellido_materno', 
                            'personas.nombres',
                            'notas.nota_asistencia',
                            'notas.nota_practicas',
                            'notas.nota_primer_parcial',
                            'notas.nota_examen_final',
                            'notas.nota_puntos_ganados',
                            'notas.nota_total'
                            )
                            ->where('notas.anio_vigente', $request->gestion)
                            // ->where('notas.docente_id', $request->cod_docente)
                            ->where('notas.asignatura_id', $request->materia_id)
                            ->where('notas.turno_id', $request->turno_id)
                            ->where('notas.paralelo', $request->paralelo)
                            ->where('notas.trimestre', $request->trimestre)
                            ->leftJoin('personas', 'notas.persona_id', '=', 'personas.id')
                            ->orderBy('personas.apellido_paterno', 'asc')
                            ->get();

        $datos = Nota::where('anio_vigente', $request->gestion)
                    ->where('docente_id', $request->cod_docente)
                    ->where('asignatura_id', $request->materia_id)
                    ->where('turno_id', $request->turno_id)
                    ->where('paralelo', $request->paralelo)
                    ->where('trimestre', $request->trimestre)
                    ->first();

        return view('lista.centralizadorBimestral')->with(compact('alumnos', 'datos'));

        // $pdf = PDF::loadView('lista.centralizadorBimestral', compact('alumnos', 'datos'))->setPaper('letter');
        // return $pdf->stream('centralizador_bimestral.pdf');

    }

    public function genera_centralizador_asistencia(Request $request)
    {
        $inscritos  = Inscripcione::where('asignatura_id', $asignatura->asignatura_id)
                                ->where('turno_id', $asignatura->turno_id)
                                ->where('paralelo', $asignatura->paralelo)
                                ->where('anio_vigente', $asignatura->anio_vigente)
                                ->get();

        $pdf = PDF::loadView('pdf.centralizadorBimestral', compact('inscritos'))->setPaper('letter');
        return $pdf->stream('centralizador_bimestral.pdf');
    }

    public function generaExcelCentralizador(Request $request)
    {
        dd($request->all());
        return Excel::download(new NotasExport($request->carrera_id, $request->gestion, $request->turno_id, $request->paralelo, $request->tipo, $request->anio_vigente), date('Y-m-d') . "-$nombreAsignatura.xlsx");
    }

    public function generaCentralizador(Request $request)
    {
        // dd($request->all());
        $carrera    = $request->carrera;
        $curso      = $request->curso;
        $turno      = $request->turno;
        $paralelo   = $request->paralelo;
        $gestion    = $request->anio_vigente;
        $resolucion = $request->resolucion;

        $datosTurno = Turno::find($request->turno);

        $datosCarrera = Carrera::find($carrera);
        
        $materiasCarrera = Asignatura::where('carrera_id', $request->carrera)
                            ->where('anio_vigente', $request->anio_vigente)
                            ->where('gestion', $request->curso)
                            
                            // ->where('anio_vigente', $request->anio_vigente)
                            ->orderBy('orden_impresion', 'asc')
                            ->get();

        // dd($materiasCarrera);

        $nominaEstudiantes = CarrerasPersona::select(
                                'personas.apellido_paterno',
                                'personas.apellido_materno',
                                'personas.nombres',
                                'carreras_personas.id',
                                'carreras_personas.carrera_id',
                                'carreras_personas.persona_id',
                                'carreras_personas.turno_id',
                                'carreras_personas.gestion',
                                'carreras_personas.paralelo',
                                'carreras_personas.fecha_inscripcion',
                                'carreras_personas.anio_vigente',
                                'carreras_personas.estado'
                            )
                            ->where('carreras_personas.anio_vigente', $request->anio_vigente)
                            ->where('carreras_personas.carrera_id', $request->carrera)
                            ->where('carreras_personas.gestion', $request->curso)
                            ->where('carreras_personas.turno_id', $request->turno)
                            ->where('carreras_personas.paralelo', $request->paralelo)
                            ->leftJoin('personas', 'carreras_personas.persona_id' , '=', 'personas.id')
                            ->orderBy('personas.apellido_paterno', 'ASC')
                            ->groupBy('carreras_personas.persona_id')
                            ->get();

        // buscamos el anio de inscripcion del primer estudiante
        // para buscar las materias de esa gestion
        // dd($nominaEstudiantes[0]->id);

        return view('persona.formularioCentralizador')->with(compact('carrera', 'curso', 'paralelo', 'turno', 'gestion', 'datosTurno', 'materiasCarrera', 'nominaEstudiantes', 'datosCarrera'));
    }

}