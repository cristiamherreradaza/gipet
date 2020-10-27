<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Nota;
use App\Turno;
use App\Kardex;
use DataTables;
use App\Carrera;
use App\Persona;
use App\Inscripcione;
use App\CarrerasPersona;

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
                        <button onclick="reinscripcion(' .  $estudiantes->id . ')" type="button" class="btn btn-light" title="ReInscripcion"  ><i class="fas fa-address-card"></i></button>
                        <button onclick="estado(' .  $estudiantes->id . ')"        type="button" class="btn btn-danger"    title="Estado(Activo/Inactivo)" ><i class="fas fa-user"></i></button>';
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

    public function ajaxDetalleInscripciones(Request $request)
    {
        $persona = Persona::find($request->persona_id);
        // Buscaremos todas las materias en las que aprobo este como  'Si'
        $aprobadas = Inscripcione::where('persona_id', $request->persona_id)
                                ->where('aprobo', 'Si')
                                ->get();
        // Buscaremos todas las materias en las que su estado sea 'Cursando'
        $cursando = Inscripcione::where('persona_id', $request->persona_id)
                                ->where('estado', 'Cursando')
                                ->get();
        // Crearemos $array_carreras
        $array_elegidas = array();
        // Almacenaremos en $array_elegidas los id de la coleccion aprobadas
        foreach($aprobadas as $aprobada){
            array_push($array_elegidas, $aprobada->id);
        }
        // Almacenaremos en $array_elegidas los id de la coleccion cursando
        foreach($cursando as $cursar){
            array_push($array_elegidas, $cursar->id);
        }
        // Volveremos a juntar en una coleccion todas esta
        $inscripciones = Inscripcione::whereIn('id', $array_elegidas)
                                    ->get();

        // Agruparemos por fechas de inscripcione
        $inscripciones = Inscripcione::where('persona_id', $request->persona_id)
                                    ->select('carrera_id', 'gestion', 'semestre', 'anio_vigente', 'estado')
                                    ->groupBy('carrera_id', 'gestion', 'semestre', 'anio_vigente', 'estado')
                                    ->get();
        
        // Posteriormente enviaremos esa coleccion a interfaz
        return view('persona.ajaxDetalleInscripciones')->with(compact('inscripciones'));
    }

    public function ajaxDetalleMaterias(Request $request)
    {
        $persona = Persona::find($request->persona_id);
        // Primero queremos saber en cuantas carreras esta inscrito
        $carreras = Inscripcione::where('persona_id', $request->persona_id)
                                ->groupBy('carrera_id')
                                ->select('carrera_id')
                                ->get();
        // Crearemos $array_carreras
        $array_carreras = array();
        // Almacenaremos en este array los id de las carreras en las que esta registrado el estudiante (1,2,...)
        foreach($carreras as $carrera){
            array_push($array_carreras, $carrera->carrera_id);
        }
        // Despues tenemos que ver las gestiones/semestres que aprobo o esta cursando

        // Posteriormente enviaremos eso a interfaz
        return view('persona.ajaxDetalleMaterias')->with(compact('carreras', 'persona'));
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
        return view('persona.crear_persona');
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
   
}