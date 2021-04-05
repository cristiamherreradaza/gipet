<?php

namespace App\Http\Controllers;

use App\Nota;
use App\Turno;
use App\Kardex;
use DataTables;
use App\Carrera;
use App\Persona;
use App\Descuento;
use App\Asignatura;
use App\Certificado;
use App\CursosCorto;
use App\Resolucione;
use App\Inscripcione;
use App\SegundosTurno;
use App\CarrerasPersona;
use App\TiposMensualidade;
use Illuminate\Http\Request;
use App\EstudiantesCertificado;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        return redirect('Persona/ver_detalle/'.$persona->id);
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
                return '<button onclick="ver_persona('.$estudiantes->id.')"        type="button" class="btn btn-info"      title="Ver"><i class="fas fa-eye"></i></button>
                        <button onclick="eliminar_persona('.$estudiantes->id.', '.$estudiantes->cedula.')" type="button" class="btn btn-danger" title="Eliminar Estudiante"><i class="fas fa-trash"></i></button>
                        <button onclick="contrato(' .  $estudiantes->id . ')"        type="button" class="btn btn-dark"    title="Contrato" ><i class="fas fa-file-alt"></i></button>';
            })
            ->make(true);

        /*
        return Datatables::of($estudiantes)
            ->addColumn('action', function ($estudiantes) {
                return '<button onclick="ver_persona('.$estudiantes->id.')"        type="button" class="btn btn-info"      title="Ver"><i class="fas fa-eye"></i></button>
                        <button onclick="inscripcion(' . $estudiantes->id . ')"    type="button" class="btn btn-warning"   title="Nueva Carrera"  ><i class="fas fa-address-book"></i></button>
                        <button onclick="reinscripcion(' .  $estudiantes->id . ')" type="button" class="btn btn-secondary" title="ReInscripcion"  ><i class="fas fa-address-card"></i></button>
                        <button onclick="varios(' .  $estudiantes->id . ')"        type="button" class="btn btn-dark"      title="Cursos Varios"  ><i class="fas fa-file-alt"></i></button>
                        <button onclick="recuperatorio(' .  $estudiantes->id . ')" type="button" class="btn btn-success"   title="Recuperatorio" ><i class="fas fa-reply"></i></button>
                        <button onclick="estado(' .  $estudiantes->id . ')"        type="button" class="btn btn-danger"    title="Estado(Activo/Inactivo)" ><i class="fas fa-user"></i></button>';
            })
            ->make(true);
        */
    }

    public function ver_detalle($id)
    {
        //dd('hola');
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
        $persona = Persona::find($request->persona_id);
        $carrerasPersonas           = CarrerasPersona::where('persona_id', $persona->id)->get();
        foreach($carrerasPersonas as $registro){
            $registro->delete();
        }
        // Sus notas
        $notas                      = Nota::where('persona_id', $persona->id)->get();
        foreach($notas as $registro){
            $registro->delete();
        }
        // Sus recuperatorios
        $segundosTurnos             = SegundosTurno::where('persona_id', $persona->id)->get();
        foreach($segundosTurnos as $registro){
            $registro->delete();
        }
        // Sus cursos varios
        $cursosCortos               = CursosCorto::where('persona_id', $persona->id)->get();
        foreach($cursosCortos as $registro){
            $registro->delete();
        }
        // Sus inscripciones
        $inscripciones              = Inscripcione::where('persona_id', $persona->id)->get();
        foreach($inscripciones as $registro){
            $registro->delete();
        }
        // Sus certificados
        $estudiantesCertificados    = EstudiantesCertificado::where('persona_id', $persona->id)->get();
        foreach($estudiantesCertificados as $registro){
            $registro->delete();
        }
        // Finalmente se elimina a la persona
        $persona->delete();
        return redirect('Persona/listado');
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

        $tiposMensualidades = TiposMensualidade::where('anio_vigente', $gestionActual)
                            ->get();

        $descuentos = Descuento::where('anio_vigente', $gestionActual)
                                ->where('servicio_id', 2)
                                ->get();
        
        $montoSinDescuento = Descuento::where('anio_vigente', $gestionActual)
                                ->where('servicio_id', 2)
                                ->where('nombre', 'NINGUNO')
                                ->first();

        $persona = Persona::find($request->persona_id);

        $carreras = Inscripcione::where('persona_id', $persona->id)
                                ->select('carrera_id')
                                ->groupBy('carrera_id')
                                ->get();
                                
        $array_carreras = array();
        foreach($carreras as $carrera){
            array_push($array_carreras, $carrera->carrera_id);
        }
        $carreras = Carrera::whereIn('id', $array_carreras)
                            ->whereNull('estado')
                            ->get();
        // Enviamos las carreras disponibles para inscribirse
        $disponibles = Carrera::whereNotIn('id', $array_carreras)->get();
        $turnos = Turno::get();
        // Posteriormente enviaremos esa coleccion a interfaz
        return view('persona.ajaxDetalleCarreras')->with(compact('carreras', 'persona', 'disponibles', 'turnos', 'tiposMensualidades', 'descuentos', 'montoSinDescuento'));
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
        $persona = Persona::where('id', $request->personaId)->first();
        $pdf = PDF::loadView('pdf.contrato', compact('persona'))->setPaper('letter');
        return $pdf->stream('contrato.pdf');

        // dd($persona);
        // echo "holas";
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
        $sw = 0;
        // verificamos si el alumnos ya esta inscrito
        $verifica = CarrerasPersona::where('persona_id', $request->persona_id)
                    ->where('anio_vigente', $request->anio_vigente)
                    ->where('gestion', $request->gestion)
                    ->where('turno_id', $request->turno_id)
                    ->where('carrera_id', $request->carrera_id)
                    ->where('paralelo', $request->paralelo)
                    ->count();

        if($verifica == 0){       

            $sw = 1;

            // guardamos los datos en carreras personas
            $fecha = date('Y-m-d');

            $carreraPersona = new CarrerasPersona();

            $carreraPersona->user_id           = Auth::user()->id;
            $carreraPersona->carrera_id        = $request->carrera_id;
            $carreraPersona->persona_id        = $request->persona_id;
            $carreraPersona->turno_id          = $request->turno_id;
            $carreraPersona->gestion           = $request->gestion;
            $carreraPersona->paralelo          = $request->paralelo;
            $carreraPersona->fecha_inscripcion = $fecha;
            $carreraPersona->anio_vigente      = $request->anio_vigente;
            $carreraPersona->sexo              = $request->sexo;
            $carreraPersona->vigencia          = "Vigente";

            $carreraPersona->save();

            // buscamos las materias de la gestion a inscribir
            $asignaturas = Asignatura::where('anio_vigente', $request->anio_vigente)
                            ->where('gestion', $request->gestion)
                            ->where('carrera_id', $request->carrera_id)
                            ->get();

            // por cada asignatura guardamos un registro en la
            // tabla inscripciones
            foreach($asignaturas as $a)
            {
                $inscripcion = new Inscripcione();

                $inscripcion->user_id         = Auth::user()->id;
                $inscripcion->resolucion_id   = $a->resolucion_id;
                $inscripcion->carrera_id      = $request->carrera_id;
                $inscripcion->asignatura_id   = $a->id;
                $inscripcion->turno_id        = $request->turno_id;
                $inscripcion->persona_id      = $request->persona_id;
                $inscripcion->paralelo        = $request->paralelo;
                $inscripcion->semestre        = $a->semestre;
                $inscripcion->gestion         = $a->gestion;
                $inscripcion->anio_vigente    = $request->anio_vigente;
                $inscripcion->fecha_registro  = $fecha;
                $inscripcion->nota_aprobacion = $a->resolucion->nota_aprobacion;
                $inscripcion->troncal         = "Si";
                $inscripcion->estado          = "Cursando";

                $inscripcion->save();

                $inscripcionId = $inscripcion->id;

                // verificamos si es semestral o anual
                if ($a->ciclo == "Anual") {
                    $cantidadBimestres = 2;
                }else{
                    $cantidadBimestres = 4;
                }

                // guardamos para el registro de notas
                for ($i=1; $i <= $cantidadBimestres ; $i++) { 

                    $nota = new Nota();

                    $nota->user_id         = Auth::user()->id;
                    $nota->resolucion_id   = $a->resolucion_id;
                    $nota->inscripcion_id  = $inscripcionId;
                    $nota->persona_id      = $request->persona_id;
                    $nota->asignatura_id   = $a->id;
                    $nota->turno_id        = $request->turno_id;
                    $nota->paralelo        = $request->paralelo;
                    $nota->anio_vigente    = $request->anio_vigente;
                    $nota->semestre        = $a->semestre;
                    $nota->trimestre       = $i;
                    $nota->fecha_registro  = $fecha;
                    $nota->nota_aprobacion = $a->resolucion->nota_aprobacion;

                    $nota->save();
        
                }
            }
        }else{
            $sw = 1;
        }

        // realizamos las consultas para mostar 
        // el datatable de los alumnos

        // dd($request->all());
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

        return view('persona.ajaxFormularioCentralizador')->with(compact('carrera', 'curso', 'paralelo', 'turno', 'gestion', 'datosTurno', 'materiasCarrera', 'nominaEstudiantes', 'datosCarrera', 'sw'));

    }
}