<?php

namespace App\Http\Controllers;

use App\Nota;
use App\Pago;
use App\Turno;
use App\Kardex;
use DataTables;
use App\Carrera;
use App\Persona;
use App\Servicio;
use App\Descuento;
use App\Asignatura;
use App\Certificado;
use App\CursosCorto;
use App\Resolucione;
use App\Inscripcione;
use App\SegundosTurno;
use App\CarrerasPersona;
use App\DescuentosPersona;
use App\TiposMensualidade;
use Illuminate\Http\Request;
use App\librerias\Utilidades;
use App\EstudiantesCertificado;
use App\librerias\NumeroALetras;
use App\Exports\CertificadoExport;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PersonaController extends Controller
{
    public function nuevo()
    {
        // $combo_carreras = DB::table('carreras');
        $carreras = Carrera::get();
        $turnos = Turno::get();
        // dd($carreras);
        return view('persona/nuevo')->with(compact('carreras', 'turnos'));
    }

    public function guarda(Request $request)
    {
        // dd($request->all());
        $persona = new Persona();
        $persona->apellido_paterno  = $request->apellido_paterno;
        $persona->apellido_materno  = $request->apellido_materno;
        $persona->nombres           = $request->nombres;
        $persona->carnet            = $request->carnet;
        $persona->expedido          = $request->expedido;
        $persona->fecha_nacimiento  = $request->fecha_nacimiento;
        $persona->sexo              = $request->sexo;
        $persona->telefono_celular  = $request->telefono_celular;
        $persona->email             = $request->email;
        $persona->trabaja           = $request->trabaja;
        $persona->empresa           = $request->empresa;
        $persona->direccion_empresa = $request->direccion_empresa;
        $persona->telefono_empresa  = $request->telefono_empresa;
        $persona->nombre_padre      = $request->nombre_padre;
        $persona->celular_padre     = $request->celular_padre;
        $persona->nombre_madre      = $request->nombre_madre;
        $persona->celular_madre     = $request->celular_madre;
        $persona->nombre_tutor      = $request->nombre_tutor;
        $persona->telefono_tutor    = $request->telefono_tutor;
        $persona->nombre_esposo     = $request->nombre_esposo;
        $persona->telefono_esposo   = $request->telefono_esposo;
        $persona->save();
        return redirect('persona/nuevo');
        // se guardo a la persona
    }

    public function actualizar(Request $request)
    {
        // dd($request->all());
        $persona                    = Persona::find($request->persona_id);
        $persona->user_id           = Auth::user()->id;
        $persona->apellido_paterno  = $request->apellido_paterno;
        $persona->apellido_materno  = $request->apellido_materno;
        $persona->nombres           = $request->nombres;
        $persona->cedula            = $request->carnet;
        $persona->expedido          = $request->expedido;
        $persona->fecha_nacimiento  = $request->fecha_nacimiento;
        $persona->sexo              = $request->sexo;
        $persona->direccion         = $request->direccion;
        // numero_fijo
        $persona->numero_celular    = $request->telefono_celular;
        $persona->email             = $request->email;
        $persona->trabaja           = $request->trabaja;
        $persona->empresa           = $request->empresa;
        $persona->direccion_empresa = $request->direccion_empresa;
        $persona->numero_empresa    = $request->telefono_empresa;
        // fax
        $persona->email_empresa     = $request->email_empresa;
        $persona->nombre_padre      = $request->nombre_padre;
        $persona->celular_padre     = $request->celular_padre;
        $persona->nombre_madre      = $request->nombre_madre;
        $persona->celular_madre     = $request->celular_madre;
        $persona->nombre_tutor      = $request->nombre_tutor;
        $persona->celular_tutor     = $request->telefono_tutor;
        $persona->nombre_pareja     = $request->nombre_esposo;
        $persona->celular_pareja    = $request->telefono_esposo;
        $persona->save();
        // return redirect('Persona/ver_detalle/'.$persona->id);
    }

    public function listado()
    {
        return view('persona.listado');
    }

    public function ajax_listado()
    {
        $estudiantes = Persona::get();
        //$estudiantes = Persona::select('id', 'apellido_paterno', 'apellido_materno', 'nombres', 'carnet', 'telefono_celular', 'razon_social_cliente', 'nit');
        return Datatables::of($estudiantes)
            ->addColumn('action', function ($estudiantes) {
                return '<button onclick="ver_persona('.$estudiantes->id.')"        type="button" class="btn btn-info"      title="Ver"><i class="fas fa-list"></i></button>
                        <button onclick="eliminar_persona('.$estudiantes->id.', '.$estudiantes->cedula.')" type="button" class="btn btn-danger" title="Eliminar Estudiante"><i class="fas fa-trash"></i></button>';
            })
            ->make(true);
    }

    public function ver_detalle($id)
    {
        $estudiante = Persona::find($id);
        $inscripciones = Inscripcione::where('persona_id', $estudiante->id)->get();
        $carreras = Inscripcione::where('persona_id', $estudiante->id)
                                ->groupBy('carrera_id')
                                ->pluck('carrera_id');
        // foreach($carreras as $id){
        //     echo "carrera_id: " . $id . "<br>";
        //     $carrera = Carrera::find($id);
        //     for($i=1; $i<=$carrera->duracion_anios; $i++){
        //         echo "gestion " . $i . "<br>";
        //     }
        // }
        
        return view('persona.ver_detalle')->with(compact('estudiante', 'carreras'));
    }

    public function eliminar_persona(Request $request)
    {
        // Aqui debe eliminarse todo registro de la persona en el sistema
        // Su usuario

        $eliminaPersona = Persona::where('id', $request->persona_id)
                            ->delete();

        $eliminaCarrerasPersona = CarrerasPersona::where('persona_id', $request->persona_id)
                                    ->delete();

        $eliminaInscripcion = Inscripcione::where('persona_id', $request->persona_id)
                                ->delete();

        $eliminaNotas = Nota::where('persona_id', $request->persona_id)
                                ->delete();

        $eliminaPagos = Pago::where('persona_id', $request->persona_id)
                            ->delete();

        return redirect('Factura/formularioFacturacion');
    }

    public function ajaxDetalleHistorialAcademico(Request $request)
    {
        $persona    = Persona::find($request->persona_id);
        $turnos     = Turno::get();
        $paralelos  = CarrerasPersona::select('paralelo')
                                    ->groupBy('paralelo')
                                    ->get();
        $array_carreras = array();
        $carreras = Inscripcione::where('persona_id', $request->persona_id)
                                ->groupBy('carrera_id')
                                ->select('carrera_id')
                                ->get();
        foreach($carreras as $carrera){
            array_push($array_carreras, $carrera->carrera_id);
        }
        $carreras = Carrera::whereIn('id', $array_carreras)
                            ->whereNull('estado')
                            ->get();
        $inscripciones = Inscripcione::where('persona_id', $request->persona_id)
                                    ->orderBy('anio_vigente', 'asc')
                                    ->get();
        return view('persona.ajaxDetalleHistorialAcademico')->with(compact('persona', 'carreras', 'inscripciones', 'turnos', 'paralelos'));
    }

    public function ajaxDetallePensum(Request $request)
    {
        $persona = Persona::find($request->persona_id);
        $array_carreras = array();
        $carreras = Inscripcione::where('persona_id', $request->persona_id)
                                ->groupBy('carrera_id')
                                ->select('carrera_id')
                                ->get();
        foreach($carreras as $carrera){
            array_push($array_carreras, $carrera->carrera_id);
        }
        $carreras = Carrera::whereIn('id', $array_carreras)
                            ->whereNull('estado')
                            ->get();
        return view('persona.ajaxDetallePensum')->with(compact('carreras', 'persona'));
    }

    public function ajaxDetalleMaterias(Request $request)
    {
        $persona = Persona::find($request->persona_id);
        $array_carreras = array();
        $carreras = Inscripcione::where('persona_id', $request->persona_id)
                                ->groupBy('carrera_id')
                                ->select('carrera_id')
                                ->get();
        foreach($carreras as $carrera){
            array_push($array_carreras, $carrera->carrera_id);
        }
        $carreras = Carrera::whereIn('id', $array_carreras)
                            ->whereNull('estado')
                            ->get();
        $inscripciones = Inscripcione::where('persona_id', $request->persona_id)
                                    ->orderBy('fecha_registro', 'asc')
                                    ->get();
        return view('persona.ajaxDetalleMaterias')->with(compact('persona', 'carreras', 'inscripciones'));
    }

    public function ajaxDetalleCarreras(Request $request)
    {
        $gestionActual = date('Y');

        $persona = Persona::find($request->persona_id);

        $carreras = Carrera::get();

        $inscripciones = CarrerasPersona::where('persona_id', $request->persona_id)
                        ->orderBy('anio_vigente', 'desc')
                        ->get();

        $turnos = Turno::get();
        // Posteriormente enviaremos esa coleccion a interfaz
        return view('persona.ajaxDetalleCarreras')->with(compact('carreras', 'persona', 'turnos', 'inscripciones'));
    }

    public function ajaxDetalleHistorialInscripciones(Request $request)
    {
        $persona = Persona::find($request->persona_id);
        $inscripciones = CarrerasPersona::where('persona_id', $persona->id)
                                    ->orderBy('carrera_id')
                                    ->get();
        return view('persona.ajaxDetalleHistorialInscripciones')->with(compact('persona', 'inscripciones'));
    }

    public function ajaxDetalleCertificados(Request $request)
    {
        $persona = Persona::find($request->persona_id);
        $certificados = Certificado::get();
        return view('persona.ajaxDetalleCertificados')->with(compact('certificados', 'persona'));
    }

    public function ajaxDetalleMensualidades(Request $request)
    {
        $persona = Persona::find($request->persona_id);
        $carreras = Inscripcione::where('persona_id', $persona->id)
                                ->select('carrera_id')
                                ->groupBy('carrera_id')
                                ->get();
        $array_carreras = array();
        foreach($carreras as $carrera){
            array_push($array_carreras, $carrera->carrera_id);
        }
        // Enviamos las carreras disponibles para inscribirse
        $disponibles = Carrera::whereNotIn('id', $array_carreras)->get();
        $turnos = Turno::get();
        // Posteriormente enviaremos esa coleccion a interfaz
        return view('persona.ajaxDetalleMensualidades')->with(compact('carreras', 'persona', 'disponibles', 'turnos'));
    }

    public function ajaxDetalleExtras(Request $request)
    {
        $persona = Persona::find($request->persona_id);
        $carreras = Carrera::whereNotNull('estado')->get();
        // Posteriormente enviaremos esa coleccion a interfaz
        return view('persona.ajaxDetalleExtras')->with(compact('carreras', 'persona'));
    }

    /*
    public function ajax_listado()
    {
        $lista_persona = Persona::select('id', 'apellido_paterno', 'apellido_materno', 'nombres', 'carnet', 'telefono_celular', 'razon_social_cliente', 'nit');
        return Datatables::of($lista_persona)
            ->addColumn('action', function ($lista_persona) {
                return '<button onclick="ver_persona('.$lista_persona->id.')" title="Ver" class="btn btn-info"><i class="fas fa-eye"></i></button>
                        <button type="button" class="btn btn-warning" title="Nueva Carrera"  onclick="inscripcion(' . $lista_persona->id . ')"><i class="fas fa-address-book"></i></button>
                        <button type="button" class="btn btn-secondary" title="ReInscripcion"  onclick="reinscripcion(' .  $lista_persona->id . ')"><i class="fas fa-address-card"></i></button>
                        <button type="button" class="btn btn-dark" title="Cursos Varios"  onclick="varios(' .  $lista_persona->id . ')"><i class="fas fa-file-alt"></i></button>
                        <button type="button" class="btn btn-success" title="Recuperatorio"  onclick="recuperatorio(' .  $lista_persona->id . ')"><i class="fas fa-reply"></i></button>
                        <button type="button" class="btn btn-danger" title="Estado(Activo/Inactivo)"  onclick="estado(' .  $lista_persona->id . ')"><i class="fas fa-user"></i></button>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);
    }
    */

    public function ver_persona($persona_id)
    {
        $datosPersonales = Persona::where('id', $persona_id)
                                ->first();

        $carrerasPersona = CarrerasPersona::where('persona_id', $persona_id)
                                        ->get();
        $inscripciones = CarrerasPersona::where('persona_id', $persona_id)
                                        ->get();

        return view('persona.detalle')->with(compact('datosPersonales', 'carrerasPersona', 'inscripciones'));

    }


    public function detalle(Request $request, $persona_id)
    {
        // $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
        // $anio = $fecha->format('Y');//obtenes solo el año actual
        $datosPersonales = Persona::where('id', $persona_id)
                                ->first();

        $carrerasPersona = CarrerasPersona::where('persona_id', $persona_id)
                                        ->get();
        
        $notas = Nota::where('persona_id', $persona_id)
                    ->get();
        
        // $turnos = Turno::where('borrado', NULL)->get();
        // dd($turnos);
        return view('persona.detalle')->with(compact('datosPersonales', 'carrerasPersona', 'notas'));
    }

    public function ajax_materias(Request $request, $carrera_id, $persona_id, $anio_vigente)
    {
        $materiasCarrera = Inscripcion::where('carrera_id', $carrera_id)    
                                    ->where('persona_id', $persona_id)    
                                    ->where('anio_vigente', $anio_vigente)
                                    ->get();

        return view('persona.ajax_materias')->with(compact('materiasCarrera'));
    }

    public function ajax_asignaturas_adicionales(Request $request)
    {
        $persona_id = $request->persona_id;
        $asignaturas_adicionales = DB::select("SELECT insc.id, insc.asignatura_id, insc.carrera_id, carre.nombre, asig.codigo_asignatura, asig.nombre_asignatura
                                                FROM inscripciones insc, carreras carre, asignaturas asig 
                                                WHERE insc.persona_id = '$persona_id'
                                                AND insc.carrera_id = carre.id
                                                AND insc.asignatura_id = asig.id
                                                AND insc.carrera_id NOT IN (SELECT carrera_id
                                                                                                FROM carreras_personas
                                                                                                WHERE persona_id = '$persona_id')");

        // dd($asignaturas_adicionales);
        return view('persona.ajax_asignaturas_adicionales')->with(compact('asignaturas_adicionales'));
    }

    public function verifica(Request $request)
    {
        $id = $request->id;
        $carrera_persona = CarrerasPersona::where('id', $id)
                                        ->get();
        $carreras = DB::table('inscripciones')
                      ->select(
                        'inscripciones.id',
                        'asignaturas.codigo_asignatura',
                        'asignaturas.nombre_asignatura'
                      )
                      ->where('inscripciones.borrado', NULL)
                      ->where('inscripciones.persona_id',$carrera_persona[0]->persona_id)
                      ->where('inscripciones.gestion', $carrera_persona[0]->anio_vigente)
                      ->join('kardex', 'inscripciones.asignatura_id','=','kardex.asignatura_id')
                      ->where('kardex.persona_id',$carrera_persona[0]->persona_id)
                      ->where('kardex.carrera_id',$carrera_persona[0]->carrera_id)
                      ->join('asignaturas', 'inscripciones.asignatura_id','=','asignaturas.id')
                      ->where('asignaturas.borrado', NULL)
                      ->distinct()->get();
        // foreach ($carreras as $key => $value) {
        //    echo $carreras[$key]->id;
        //    echo ' ';
        //    echo $carreras[$key]->codigo_asignatura;
        //    echo ' ';
        // }
        return response()->json($carreras);
        
    }

    public function crear_persona()
    {
        // return view('persona.crear_persona');
    }

    public function guardar_nuevos(Request $request)
    {
        $pers = Persona::where('carnet', $request->carnet)
                        ->first();
        if (!empty($pers)) {
            return response()->json([
                'mensaje' => 'no'
            ]); 
        } else {
            $persona = new Persona();
            $persona->apellido_paterno  = $request->apellido_paterno;
            $persona->apellido_materno  = $request->apellido_materno;
            $persona->nombres           = $request->nombres;
            $persona->carnet            = $request->carnet;
            $persona->expedido          = $request->expedido;
            $persona->fecha_nacimiento  = $request->fecha_nacimiento;
            $persona->sexo              = $request->sexo;
            $persona->telefono_celular  = $request->telefono_celular;
            $persona->email             = $request->email;
            $persona->trabaja           = $request->trabaja;
            $persona->empresa           = $request->empresa;
            $persona->direccion_empresa = $request->direccion_empresa;
            $persona->telefono_empresa  = $request->telefono_empresa;
            $persona->nombre_padre      = $request->nombre_padre;
            $persona->celular_padre     = $request->celular_padre;
            $persona->nombre_madre      = $request->nombre_madre;
            $persona->celular_madre     = $request->celular_madre;
            $persona->nombre_tutor      = $request->nombre_tutor;
            $persona->telefono_tutor    = $request->telefono_tutor;
            $persona->nombre_esposo     = $request->nombre_esposo;
            $persona->telefono_esposo   = $request->telefono_esposo;
            $persona->save();

            return response()->json([
                    'mensaje' => 'si'
                ]); 
        }                
        
    }

    public function contrato(Request $request)
    {
        // dd($request->personaId);
        $persona = Persona::where('id', $request->personaId)->first();

        $datosCarrera = Inscripcione::where('persona_id', $request->personaId)
                                    ->where('carrera_id', $request->carreraId)
                                    ->where('gestion', $request->curso)
                                    ->where('turno_id', $request->turnoId)
                                    ->where('anio_vigente', $request->anio_vigente)
                                    ->first();
        // dd($datosCarrera);

        $pdf = PDF::loadView('pdf.contrato', compact('persona', 'datosCarrera'))->setPaper('letter');
        return $pdf->stream('contrato.pdf');
    }

    public function ajaxMuestraMontos(Request $request)
    {
        // dd($request->all());
        // $datosDescuentos = Descuento::where('id', $request->descuento)->toJson();
        $datosDescuentos = Descuento::find($request->descuento)->toJson();
        // dd($datosDescuentos);

        return response()->json($datosDescuentos);
        // return view('persona.ajaxMuestraMontos')->with(compact('datosDescuentos'));
    }

    public function ajaxMuestraMensualidades(Request $request)
    {
        $tiposMensualidades = TiposMensualidade::where('carrera_id', $request->carrera)
                                ->get();

        return view('persona.ajaxMuestraMensualidades')->with(compact('tiposMensualidades'));
    }

    public function regularizaFinales(Request $request)
    {
        $resoluciones  = Resolucione::orderBy('anio_vigente', 'desc')
                        ->get();
        
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
                                ->orderBy('anio_vigente', 'desc')
                                ->get();
        $estados    = CarrerasPersona::select('vigencia')
                                    ->groupBy('vigencia')
                                    ->orderBy('vigencia', 'desc')
                                    ->get();

        return view('persona.regularizaFinales')->with(compact('carreras', 'cursos', 'gestiones', 'paralelos', 'turnos', 'estados', 'resoluciones'));
    }

    public function formularioCentralizador(Request $request)
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

    public function ajaxGuardaNota(Request $request)
    {
        // dd($request->all());
        $inscripcion = Inscripcione::find($request->inscripcion_id);
        // dd($inscripcion);
        $inscripcion->nota = $request->nota;
        if($inscripcion->save()){
            return response()->json(['sw'=>1]);
        }else{
            return response()->json(['sw'=>0]);
        }
    }

    public function ajaxBusca(Request $request)
    {
        $persona = Persona::where('cedula', $request->carnet)
                    ->first();

        return view('persona.ajaxPersona')->with(compact('persona'));
    }

    public function ajaxInscribe(Request $request)
    {
        // funcion para inscribir un alumno
        $this->inscripcion(
            $request->persona_id, 
            $request->carrera_id, 
            $request->turno_id, 
            $request->paralelo, 
            $request->gestion, 
            $request->anio_vigente);
            
        // realizamos las consultas para mostar 
        // el datatable de los alumnos
        $carrera    = $request->carrera_id;
        $curso      = $request->gestion;
        $turno      = $request->turno_id;
        $paralelo   = $request->paralelo;
        $gestion    = $request->anio_vigente;
        $resolucion = $request->resolucion;

        $datosTurno = Turno::find($request->turno_id);

        $datosCarrera = Carrera::find($carrera);
        
        $materiasCarrera = Asignatura::where('carrera_id', $request->carrera_id)
                            ->where('anio_vigente', $request->anio_vigente)
                            ->where('gestion', $request->gestion)
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

        return view('persona.ajaxFormularioCentralizador')->with(compact('carrera', 'curso', 'paralelo', 'turno', 'gestion', 'datosTurno', 'materiasCarrera', 'nominaEstudiantes', 'datosCarrera'));

    }

    public function ajaxEliminaInscripcion(Request $request)
    {
        $this->eliminaInscripcion(
            $request->persona_id, 
            $request->carrera_id, 
            $request->turno_id, 
            $request->paralelo, 
            $request->gestion, 
            $request->anio_vigente);
        // Hacemos las consultas para mostrar los 
        // alumnos inscritos

            $carrera    = $request->carrera_id;
            $curso      = $request->gestion;
            $turno      = $request->turno_id;
            $paralelo   = $request->paralelo;
            $gestion    = $request->anio_vigente;
            $resolucion = $request->resolucion;
    
            $datosTurno = Turno::find($request->turno_id);
    
            $datosCarrera = Carrera::find($carrera);
            
            $materiasCarrera = Asignatura::where('carrera_id', $request->carrera_id)
                                ->where('anio_vigente', $request->anio_vigente)
                                ->where('gestion', $request->gestion)
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
    
            return view('persona.ajaxFormularioCentralizador')->with(compact('carrera', 'curso', 'paralelo', 'turno', 'gestion', 'datosTurno', 'materiasCarrera', 'nominaEstudiantes', 'datosCarrera'));
    }

    public function ajaxCambiaEstado(Request $request)
    {
        $carreraPersona = CarrerasPersona::where('persona_id', $request->persona_id)
                    ->where('anio_vigente', $request->anio_vigente)
                    ->where('gestion', $request->gestion)
                    ->where('turno_id', $request->turno_id)
                    ->where('carrera_id', $request->carrera_id)
                    ->where('paralelo', $request->paralelo)
                    ->first();

        // dd($request->estado);

        $modificaEstado = CarrerasPersona::find($carreraPersona->id);
        $modificaEstado->estado = $request->estado;
        $modificaEstado->save();
    }

    public function informacion(Request $request, $id)
    {
        $estudiante = Persona::find($id);

        $carrerasPersona = CarrerasPersona::where('persona_id', $id)
                        ->orderBy('anio_vigente', 'desc')
                        ->get();

        $carrerasPensum = CarrerasPersona::where('persona_id', $id)
                    ->groupBy('carrera_id')
                    ->get();
                        
        $materiasInscripcion = Inscripcione::where('persona_id', $request->id)
                                ->get();

        $descuentos = Descuento::where('servicio_id', 2)
                                ->get();

        $pagos = Pago::where('persona_id', $estudiante->id)
                    ->orderBy('id', 'desc')
                    ->get();

        $tiposMensualidades = TiposMensualidade::get();

        $mensualidad = Servicio::find(2);

        $carreras = Carrera::get();

        $turnos = Turno::get();
        
        return view('persona.informacion')->with(compact('estudiante', 'carrerasPersona', 'carreras', 'turnos', 'materiasInscripcion', 'carrerasPensum', 'descuentos', 'tiposMensualidades', 'pagos', 'mensualidad'));

    }

    public function ajaxInscribeAlumno(Request $request)
    {
        $this->inscripcion(
            $request->persona_id, 
            $request->carrera_id, 
            $request->turno_id, 
            $request->paralelo, 
            $request->gestion, 
            $request->anio_vigente);

        if($request->generacion_cuotas == 'Si' && $request->carrera_id == 1)
        {     
            // generamos los datos para los pagos
            if($request->aplica_promo == 'inicio'){
                $cuotaInicioPromo = 1;
            }else{
                $cuotaInicioPromo = ($request->cantidad_cuotas_pagar - $request->cuotas_promo)+1;
            }

            $hoy = date("Y-m-d");

            $datosServicios = Servicio::find(2);
            // Guardamos los datos para las mensualidades
            $descuento                         = new DescuentosPersona();
            $descuento->user_id                = Auth::user()->id;
            $descuento->tipos_mensualidades_id = $request->tipo_mensualidad_id;
            $descuento->carrera_id             = $request->carrera_id;
            $descuento->persona_id             = $request->persona_id;
            $descuento->servicio_id            = 2;
            $descuento->descuento_id           = $request->descuento_id;
            // $descuento->monto_director      = $request->monto;
            $descuento->numero_mensualidad     = $cuotaInicioPromo;
            $descuento->a_pagar                = $request->monto_pagar;
            $descuento->fecha                  = $request->hoy;
            $descuento->cantidad_cuotas        = $request->cuotas_promo;
            $descuento->anio_vigente           = $request->anio_vigente;
            $descuento->vigente                = "Si";
            $descuento->save();
            $descuentoId = $descuento->id;
            // Fin uardamos los datos para las mensualidades
            
            $inicioPromo = $cuotaInicioPromo;
            $finalPromo = ($inicioPromo + $request->cuotas_promo)-1;

            // guardamos los futuros pagos
            for ($i = 1; $i <= $request->cantidad_cuotas_pagar; $i++) {

                // guardamos si tienen promocion
                if($i >= $inicioPromo && $i <= $finalPromo){
                    $pagos                       = new Pago();
                    $pagos->user_id              = Auth::user()->id;
                    $pagos->carrera_id           = $request->carrera_id;
                    $pagos->persona_id           = $request->persona_id;
                    $pagos->servicio_id          = 2;
                    $pagos->turno_id             = $request->turno_id;
                    $pagos->tipo_mensualidad_id  = $request->tipo_mensualidad_id;
                    $pagos->descuento_persona_id = $descuentoId;
                    $pagos->a_pagar              = $request->monto_pagar;
                    $pagos->gestion              = $request->gestion;
                    $pagos->importe              = 0;
                    $pagos->faltante             = 0;
                    $pagos->total                = 0;
                    $pagos->mensualidad          = $i;
                    $pagos->anio_vigente         = $request->anio_vigente;
                    $pagos->save();
                }else{
                    // guardamos las que no tienen promocion
                    $pagos                       = new Pago();
                    $pagos->user_id              = Auth::user()->id;
                    $pagos->carrera_id           = $request->carrera_id;
                    $pagos->persona_id           = $request->persona_id;
                    $pagos->servicio_id          = 2;
                    $pagos->turno_id             = $request->turno_id;
                    $pagos->tipo_mensualidad_id  = $request->tipo_mensualidad_id;
                    $pagos->descuento_persona_id = null;
                    $pagos->a_pagar              = $datosServicios->precio;
                    $pagos->gestion              = $request->gestion;
                    $pagos->importe              = 0;
                    $pagos->faltante             = 0;
                    $pagos->total                = 0;
                    $pagos->mensualidad          = $i;
                    $pagos->anio_vigente         = $request->anio_vigente;
                    $pagos->save();
                }
            }

        }

        // guardamos las mensualidades
        // fin guardamos las mensualidades
    }

    // funcion privada para inscribir a un alumno
    private function inscripcion($persona_id, $carrera_id, $turno_id, $paralelo, $gestion, $anio_vigente)
    {
        // verificamos si el alumnos ya esta inscrito
        $verifica = CarrerasPersona::where('persona_id', $persona_id)
                    ->where('anio_vigente', $anio_vigente)
                    ->where('gestion', $gestion)
                    ->where('turno_id', $turno_id)
                    ->where('carrera_id', $carrera_id)
                    ->where('paralelo', $paralelo)
                    ->count();

        $datosPersona = Persona::find($persona_id);

        if($verifica == 0){       

            $fecha = date('Y-m-d');

            // guardamos los datos en carreras personas
            $carreraPersona = new CarrerasPersona();

            $carreraPersona->user_id = Auth::user()->id;
            $carreraPersona->carrera_id = $carrera_id;
            $carreraPersona->persona_id = $persona_id;
            $carreraPersona->turno_id = $turno_id;
            $carreraPersona->gestion = $gestion;
            $carreraPersona->paralelo = $paralelo;
            $carreraPersona->fecha_inscripcion = $fecha;
            $carreraPersona->anio_vigente = $anio_vigente;
            $carreraPersona->sexo = $datosPersona->sexo;
            $carreraPersona->vigencia = "Finalizado";

            $carreraPersona->save();

            // buscamos las materias de la gestion a inscribir
            $asignaturas = Asignatura::where('anio_vigente', $anio_vigente)
                ->where('gestion', $gestion)
                ->where('carrera_id', $carrera_id)
                ->get();

            // por cada asignatura guardamos un registro en la
            // tabla inscripciones
            foreach ($asignaturas as $a) {
                $inscripcion = new Inscripcione();

                $inscripcion->user_id = Auth::user()->id;
                $inscripcion->resolucion_id = $a->resolucion_id;
                $inscripcion->carrera_id = $carrera_id;
                $inscripcion->asignatura_id = $a->id;
                $inscripcion->turno_id = $turno_id;
                $inscripcion->persona_id = $persona_id;
                $inscripcion->paralelo = $paralelo;
                $inscripcion->semestre = $a->semestre;
                $inscripcion->gestion = $a->gestion;
                $inscripcion->anio_vigente = $anio_vigente;
                $inscripcion->fecha_registro = $fecha;
                $inscripcion->nota_aprobacion = $a->resolucion->nota_aprobacion;
                $inscripcion->troncal = "Si";
                $inscripcion->estado = "Finalizado";

                $inscripcion->save();

                $inscripcionId = $inscripcion->id;

                // verificamos si es semestral o anual
                if ($a->ciclo == "Anual") {
                    $cantidadBimestres = 2;
                } else {
                    $cantidadBimestres = 4;
                }

                // guardamos para el registro de notas
                for ($i = 1; $i <= 2; $i++) {

                    $nota = new Nota();

                    $nota->user_id = Auth::user()->id;
                    $nota->resolucion_id = $a->resolucion_id;
                    $nota->carrera_id = $a->carrera_id;
                    $nota->inscripcion_id = $inscripcionId;
                    $nota->persona_id = $persona_id;
                    $nota->asignatura_id = $a->id;
                    $nota->gestion = $a->gestion;
                    $nota->turno_id = $turno_id;
                    $nota->paralelo = $paralelo;
                    $nota->anio_vigente = $anio_vigente;
                    $nota->semestre = $a->semestre;
                    $nota->trimestre = $i;
                    $nota->fecha_registro = $fecha;
                    $nota->nota_aprobacion = $a->resolucion->nota_aprobacion;

                    $nota->save();

                }
            }
        }
    }

    public function ajaxEliminaInscripcionAlumno(Request $request)
    {
        $this->eliminaInscripcion(
            $request->persona_id, 
            $request->carrera_id, 
            $request->turno_id, 
            $request->paralelo, 
            $request->gestion, 
            $request->anio_vigente);
    }

    private function eliminaInscripcion($persona_id, $carrera_id, $turno_id, $paralelo, $gestion, $anio_vigente)
    {
        $eliminaNotas = Nota::where('persona_id', $persona_id)
            ->where('anio_vigente', $anio_vigente)
            ->where('gestion', $gestion)
            ->where('turno_id', $turno_id)
            ->where('carrera_id', $carrera_id)
            ->where('paralelo', $paralelo)
            ->delete();

        $eliminaInscripcion = Inscripcione::where('persona_id', $persona_id)
            ->where('anio_vigente', $anio_vigente)
            ->where('gestion', $gestion)
            ->where('turno_id', $turno_id)
            ->where('carrera_id', $carrera_id)
            ->where('paralelo', $paralelo)
            ->delete();

        $eliminaCarrerasPersona = CarrerasPersona::where('persona_id', $persona_id)
            ->where('anio_vigente', $anio_vigente)
            ->where('gestion', $gestion)
            ->where('turno_id', $turno_id)
            ->where('carrera_id', $carrera_id)
            ->where('paralelo', $paralelo)
            ->delete();

    }

    public function adicionaMateriaAlumno()
    {
        
    }

    public function generaExcelCertificado(Request $request, $carrera_persona_id)
    {
        $datosCarrerasPersona = CarrerasPersona::find($carrera_persona_id);

        $datosPersona = Persona::find($datosCarrerasPersona->persona_id);
        
        $datosCarrera = Carrera::find($datosCarrerasPersona->carrera_id);
        // En la variable inscripciones hallaremos la relacion entre 
        // el registro de la tabla carreras_personas e inscripciones
        $inscripciones  = Inscripcione::where('carrera_id', $datosCarrerasPersona->carrera_id)
                                    ->where('persona_id', $datosCarrerasPersona->persona_id)
                                    //->where('turno_id', $datosCarrerasPersona->turno_id)
                                    //->where('paralelo', $datosCarrerasPersona->paralelo)                  //paralelo
                                    //->where('fecha_registro', $datosCarrerasPersona->fecha_inscripcion)   //fecha_inscripcion
                                    ->whereNull('oyente')
                                    ->where('anio_vigente', $datosCarrerasPersona->anio_vigente)            //anio_vigente
                                    ->get();

        $utilidades = new Utilidades();
        $expedido = $utilidades->cambiaExpedido($datosPersona->expedido);

        // generacion del excel
        $fileName = 'certifica_notas.xlsx';
        // return Excel::download(new CertificadoExport($carrera_persona_id), 'certificado.xlsx');
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getActiveSheet()->getStyle("A9:F17")->applyFromArray(
            array(
                'borders' => array(
                    'allBorders' => array(
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => array('argb' => '000000')
                    )
                )
            )
        );

        $spreadsheet->getActiveSheet()->setTitle("certifica_cal");

        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(80);
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);

        // colocando estilos
        $fuenteNegrita = array(
            'font'  => array(
                'bold'  => true,
                // 'color' => array('rgb' => 'FF0000'),
                'size'  => 10,
                'name'  => 'Verdana'
            ));

        $fuenteNegritaTitulo = array(
            'font'  => array(
                'bold'  => true,
                // 'color' => array('rgb' => 'FF0000'),
                'size'  => 14,
                'name'  => 'Verdana'
            ));


        // $spreadsheet->getActiveSheet()->getCell('D1')->setValue('Some text');
        $spreadsheet->getActiveSheet()->getStyle("A1:A6")->applyFromArray($fuenteNegritaTitulo);
        $spreadsheet->getActiveSheet()->getStyle('A2:A6')->applyFromArray($fuenteNegrita);

        $spreadsheet->getActiveSheet()->getStyle('C5')->applyFromArray($fuenteNegrita);
        $spreadsheet->getActiveSheet()->getStyle('C7')->applyFromArray($fuenteNegrita);

        $spreadsheet->getActiveSheet()->getStyle('A9:F9')->applyFromArray($fuenteNegrita);
        // fin de colocar estilos

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'CERTIFICADO DE CALIFICACIONES');
        
        $sheet->setCellValue('A2', 'CARRERA: ');
        $sheet->setCellValue('A3', 'TURNO: ');
        $sheet->setCellValue('A4', 'CURSO: ');
        $sheet->setCellValue('A5', 'NIVEL: ');
        $sheet->setCellValue('A6', 'ALUMNO: ');

        $sheet->setCellValue('B2', $datosCarrera->nombre);
        $sheet->setCellValue('B3', $datosCarrerasPersona->turno->descripcion);
        $sheet->setCellValue('B4', $datosCarrerasPersona->gestion);
        $sheet->setCellValue('B5', 'Tecnico Superior');
        $sheet->setCellValue('B6', $datosPersona->apellido_paterno);
        $sheet->setCellValue('B7', $datosPersona->apellido_materno);
        $sheet->setCellValue('B8', $datosPersona->nombres);
        
        $sheet->setCellValue('C5', 'Carnet');
        $sheet->setCellValue('C6', $datosPersona->cedula." ".$expedido);

        $sheet->setCellValue('C7', 'Gestion');
        $sheet->setCellValue('C8', $datosCarrerasPersona->anio_vigente);

        $sheet->setCellValue('A9', 'No');
        $sheet->setCellValue('B9', 'Asignaturas');
        $sheet->setCellValue('C9', 'Promedio');
        $sheet->setCellValue('D9', 'S. Turno');
        $sheet->setCellValue('E9', 'Convalida');
        $sheet->setCellValue('F9', 'Codigo');

        $contadorCeldas = 10;
        foreach ($inscripciones as $key => $i) {

            // $sheet->getRowDimension($contadorCeldas)->setRowHeight(35);

            // $aLetras = new NumeroALetras();

            $sheet->setCellValue("A$contadorCeldas", ++$key);
            $sheet->setCellValue("B$contadorCeldas", $i->asignatura->nombre);
            $sheet->setCellValue("C$contadorCeldas", $i->nota);
            $sheet->setCellValue("D$contadorCeldas", 0);
            $sheet->setCellValue("E$contadorCeldas", 0);
            $sheet->setCellValue("F$contadorCeldas", $i->asignatura->sigla);
            // $sheet->setCellValue("H$contadorCeldas", $aLetras->toString($i->nota, 0));
            $contadorCeldas++;
        }
        // $sheet->getRowDimension(1)->setRowHeight(35);


        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
        // $writer->save('demo.xlsx');
    }

    public function modifica_pago(request $request){

        // dd($request->all());
        $pago = Pago::find($request->input('pago_id'));

        $pago->a_pagar = $request->input('a_pagar');

        if($request->input('tipo_pago') == 'parcial'){

            $faltante = $request->input('a_pagar') - $request->input('monto_pago');
            $importe = $request->input('monto_pago');
            $estado = null;
        }else{
            $faltante = 0;
            $importe = ($request->input('estado')=='Pagado')?$request->input('a_pagar'):0;
            $estado = ($request->input('estado')=='Pagado')?'Pagado':null;
        }

        $pago->faltante = $faltante;
        $pago->importe  = $importe;
        $pago->fecha    = $request->fecha_pago;
        $pago->estado   = $estado;

        $pago->save();
        // dd("Id de pago => ".$request->input('pago_id')."<br>a pagar=> ".$request->input('a_pagar')."<br>monto de pago=> ".$request->input('monto_pago')."<br>fecha=> ".$request->input('fecha_pago')."<br>fecha=> ".$request->input('estado'));

        return redirect('Persona/informacion/'.$request->input('persona_id'));

    }

    public function login(Request $request){

        // dd("holas como estan desde el login");
        return view('persona.login');

    }

    public function ingresa(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        $user = $request->input('name');
        $pass = $request->input('password');

        $persona  = Persona::where('usuario',$user)
                            ->first();

        if($persona->cantidad_intentos == 1){

            if($persona && Hash::check($pass, $persona->password)){

                return view('persona.editadatos')->with(compact('persona'));
    
            }else{

                $html = 1;

            }

        }else{
            
            $html = 2;

        }
        
        return json_encode($html);

    }

    public function guardaDatos(Request $request){

        if($request->ajax()){

            $validator = Validator::make($request->all(), [
                'apellido_paterno' => 'required',
                'apellido_materno' => 'required',
                'nombres' => 'required',
                'fecha_nacimiento' => 'required',
                'genero' => 'required',
                'cedula' => 'required',
                'expedido' => 'required',
                'numero_celular' => 'required'
            ]);

            if ($validator->fails()) {

                return json_encode(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);

            }else{

                $persona = Persona::find();

                // $campania = new Campania();

                // $campania->nombre       = $request->input('nombre_campania');
                // $campania->fecha_inicio = $request->input('fecha_inicio');
                // $campania->fecha_fin    = $request->input('fecha_fin');
                // $campania->descripcion  = $request->input('descripcion_campania');

                // $campania->save();

                // return json_encode(['success' => true]);
            }
        }else{

        }

    }
}