<?php

namespace App\Http\Controllers;

use App\Turno;
use App\Carrera;
use DataTables;
use App\Persona;
use App\Inscripcion;
use App\Kardex;
use App\CarrerasPersona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    public function nuevo()
    {
        // $combo_carreras = DB::table('carreras');
        $carreras = Carrera::where('borrado', NULL)->get();
        $turnos = Turno::where('borrado', NULL)->get();
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

    public function listado()
    {
        return view('persona.listado');
    }

    public function ajax_listado()
    {
        $lista_persona = Persona::all();
        return Datatables::of($lista_persona)
            ->addColumn('action', function ($lista_persona) {
                return '<button onclick="ver_persona('.$lista_persona->id.')" class="btn btn-info"><i class="fas fa-eye"></i></a>';
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->make(true);

    }

    public function ver_persona($persona_id = null)
    {
        $datosPersonales = Persona::where('borrado', NULL)
                        ->where('id', $persona_id)
                        ->first();

        $carrerasPersona = CarrerasPersona::where('borrado', NULL)
                        ->where('persona_id', $persona_id)
                        ->get();
        $inscripciones = CarrerasPersona::where('borrado', NULL)
                        ->where('persona_id', $persona_id)
                        ->get();

        return view('persona.detalle')->with(compact('datosPersonales', 'carrerasPersona', 'inscripciones'));

    }


    public function detalle(Request $request, $persona_id)
    {
        // $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
        // $anio = $fecha->format('Y');//obtenes solo el año actual
        $datosPersonales = Persona::where('borrado', NULL)
                        ->where('id', $persona_id)
                        ->first();

        $carrerasPersona = CarrerasPersona::where('borrado', NULL)
                        ->where('persona_id', $persona_id)
                        ->get();
        // $turnos = Turno::where('borrado', NULL)->get();
        // dd($turnos);
        return view('persona.detalle')->with(compact('datosPersonales', 'carrerasPersona'));
    }

    public function ajax_materias(Request $request, $carrera_id, $persona_id, $anio_vigente)
    {
        $materiasCarrera = Inscripcion::where('borrado', NULL)
                            ->where('carrera_id', $carrera_id)    
                            ->where('persona_id', $persona_id)    
                            ->where('anio_vigente', $anio_vigente)
                            ->get();

        return view('persona.ajax_materias')->with(compact('materiasCarrera'));
    }

    public function verifica(Request $request)
    {
        $id = $request->id;
        $carrera_persona = CarrerasPersona::where("borrado", NULL)
                    ->where('id', $id)
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

   
}
