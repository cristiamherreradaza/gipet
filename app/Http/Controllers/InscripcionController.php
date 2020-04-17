<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inscripcion;
use App\Carrera;
use App\Asignatura;
use App\Turno;
use App\Persona;
use App\Kardexes;
use DB;

class InscripcionController extends Controller
{
    public function inscripcion()
    {
        $carreras = Carrera::where('estado',1)->get();
        $turnos = Turno::where('borrado', NULL)->get();
        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$year = $fecha->format('Y');//obtenes solo el año actual
        // dd($turnos);
        return view('inscripcion.inscripcion', compact('carreras', 'turnos', 'year'));    
    }

    public function busca_ci(Request $request)
    {
    	$carnet = $request->ci;//buscar el carnet de identidad de una persona
    	$persona_id = Persona::where("borrado", NULL)
                    ->where('carnet', $carnet)
                    ->get();
    	$per = Persona::find($persona_id[0]->id);
        return response()->json($per);
    }

    public function busca_asignatura1(Request $request){
    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$hoy = $fecha->format('Y');//obtenes solo el año actual
    	$asig = $request->asignatura;//obtenes el id de la asignatura seleccioanda en la vista
    	if ($asig == '1') {
    		$contabilidad = Asignatura::where("borrado",NULL)
						    ->where('carrera_id','1')
						    ->where('anio_vigente',$hoy)
						    ->where('gestion','1')
						    ->orderBy('orden_impresion','asc')
						    ->get();
    		$secretariado = Asignatura::where("borrado",NULL)
						    ->where('carrera_id','2')
						    ->where('anio_vigente',$hoy)
						    ->where('gestion','1')
						    ->orderBy('orden_impresion','asc')
						    ->get();
    		$auxiliar 	  = Asignatura::where("borrado",NULL)
						    ->where('carrera_id','3')
						    ->where('anio_vigente',$hoy)
						    ->where('gestion','1')
						    ->orderBy('orden_impresion','asc')
						    ->get();
    	}
    	return response()->json($contabilidad);
    }

    public function contabilidad(Request $request){
    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$hoy = $fecha->format('Y');//obtenes solo el año actual
    	$asig = $request->asignatura;//obtenes el id de la asignatura seleccioanda en la vista
		$contabilidad = Asignatura::where("borrado",NULL)
					    ->where('carrera_id',$asig)
					    ->where('anio_vigente',$hoy)
					    ->where('gestion','1')
					    ->orderBy('orden_impresion','asc')
					    ->get();
    	return response()->json($contabilidad);
    }

    public function secretariado(Request $request){
    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$hoy = $fecha->format('Y');//obtenes solo el año actual
		$secretariado = Asignatura::where("borrado",NULL)
					    ->where('carrera_id','2')
					    ->where('anio_vigente',$hoy)
					    ->where('gestion','1')
					    ->orderBy('orden_impresion','asc')
					    ->get();
    	return response()->json($secretariado);
    }

    public function auxiliar(Request $request){
    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$hoy = $fecha->format('Y');//obtenes solo el año actual
		$auxiliar 	  = Asignatura::where("borrado",NULL)
					    ->where('carrera_id','3')
					    ->where('anio_vigente',$hoy)
					    ->where('gestion','1')
					    ->orderBy('orden_impresion','asc')
					    ->get();
    	return response()->json($auxiliar);
    }

    public function busca_asignatura(Request $request){
    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$hoy = $fecha->format('Y');//obtenes solo el año actual
    	$asig = $request->asignatura;//obtenes el id de la asignatura seleccioanda en la vista
		$asignad = Asignatura::where("borrado",NULL)
					    ->where('carrera_id',$asig)
					    ->where('anio_vigente',$hoy)
					    ->where('gestion','1')
					    ->orderBy('orden_impresion','asc')
					    ->get();
    	return response()->json($asignad);
    }

    public function busca_carrera(Request $request){
    	$asig = $request->id;//obtenes el id de la asignatura seleccioanda en la vista
		$carre = Carrera::where("borrado",NULL)
					    ->where('id',$asig)
					    ->get();
    	return response()->json($carre);
    }

    public function store(Request $request)
    {
    	$carnet = $request->carnet;
    	$persona_id = Persona::where("borrado", NULL)
                    ->where('carnet', $carnet)
                    ->get();
        if ($persona_id[0]->nombres) {
        	echo 'si';
        } else {
        	// INGRESAR AL ALUMNO NUEVO SI NO SE ENCUENTRA REGISTRADO
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

	        // INGRESAR LOS DATOS A KARDEX
	        $persona = new kardexes();

        }
       
    }

    public function lista()
    {
    	$personas = Persona::all();
        return view('inscripcion.lista' , compact('personas'));
    }

    public function ajax_datos()
    {
        return datatables()->eloquent(Persona::query())->toJson();
    }


    public function re_inscripcion(Request $request){

    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$year = $fecha->format('Y');//obtenes solo el año actual

    	$id = $request->id;//obtenes el id de la asignatura seleccioanda en la vista
    	$persona = Persona::find($id);
    	// $carreras = Carrera::where('estado',1)->get();
    	$carreras = DB::table('kardexes')
				      ->select(
				        'kardex.carrera_id',
				        'carreras.nombre',
				        'carreras.gestion'
				      )
				      ->join('carreras', 'kardexes.carrera_id','=','carreras.id')
				      ->where('carreras.gestion',$year)
				      ->distinct()->get();
        $turnos = Turno::where('borrado', NULL)->get();
		
        // dd($persona);
        return view('inscripcion.re_inscripcion', compact('persona', 'carreras', 'turnos', 'year'));    
    }


    public function asignaturas_a_tomar(Request $request){

		$per = $request->id_persona;//obtenes el id de la persona seleccioanda en la vista
		$carr = $request->id_asignatu;//obtenes el id de la carrera seleccioanda en la vista
		
		//obtenemos todas las asignaturas que no estan aprobadas segun la carrera seleccionada
    	$asignaturas = DB::table('kardexes')
				      ->select('*')
				      ->where('carrera_id','=',$carr)
				      ->where('persona_id','=',$per)
				      ->where('aprobado','No')
				      ->distinct()->get();
		// dd($asignaturas[0]->asignatura_id);
		//este foreach nos ayuda a recorrer todas las asignaturas  
		foreach ($asignaturas as $key => $value) {
			$id = $asignaturas[$key]->asignatura_id;
			//obtenemos los prerequisitos de las materias seleccionadas
			$pre_asig = DB::table('prerequisitos')
				      ->select('*')
				      ->where('asignatura_id',$id)
				      ->get();
			//este foreach nos ayuda a recorrer todos los prerequisitos     
			foreach ($pre_asig as $key1 => $value1) {
				// $id1 = $pre_asig[$key1]->asignatura_id;
				//verificamos si tienen prerequisitos
				$datos_asig = Asignatura::find($pre_asig[$key1]->asignatura_id);

				if (!empty($pre_asig[$key1]->prerequisito_id)){
					$id2 = $pre_asig[$key1]->prerequisito_id;

					$asigna = DB::table('kardexes')
				      ->select('*')
				      ->where('asignatura_id',$id2)
				      ->where('persona_id','=',$per)
				      ->distinct()->get();
				    
				    $datos= $asigna[0]->aprobado;

				    if ($datos == 'Si') {
				    	DB::table('materias')->insert([
					          'asignatura_id' => $id,
							  'codigo_asignatura' => $datos_asig->codigo_asignatura,
							  'nombre_asignatura' => $datos_asig->nombre_asignatura,					          
					          'estado' => 1,
					        ]);
				    }
				}
				else{
					//En esta parte se insertara momentaneamente el id de las asignaturas que no tienen ningun requisito a la tabla de MATERIAS
					DB::table('materias')->insert([
					          'asignatura_id' => $pre_asig[0]->asignatura_id,
					          'codigo_asignatura' => $datos_asig->codigo_asignatura,
							  'nombre_asignatura' => $datos_asig->nombre_asignatura,		
					          'estado' => 1,
					        ]);
				}
			}
		}
		// DB::table('users')->truncate();
		// en toda esta seccion verificaos si tienen mas de un prerequisitos y si los puede tomar
		$materias = DB::table('materias')
             ->select('asignatura_id', DB::raw('count(asignatura_id) as nro'))
             ->groupBy('asignatura_id')
             ->get();
        foreach ($materias as $key => $value) {
        	$id_asig = $materias[$key]->asignatura_id;
        	$valor = $materias[$key]->nro;

        	$prerequisitos = DB::table('prerequisitos')
             ->select('asignatura_id', DB::raw('count(asignatura_id) as nro'))
             ->where('asignatura_id','=',$id_asig)
             ->groupBy('asignatura_id')
             ->get();

            $valor1 = $prerequisitos[0]->nro;
            if ($valor != $valor1) {
            	DB::table('materias')
            	->where('asignatura_id','=',$id_asig)
            	->delete();
            }
        }

        $asig_tomar = DB::select("SELECT DISTINCT asignatura_id, codigo_asignatura, nombre_asignatura
								FROM materias");
		// $asig_tomar = DB::table('materias')
		// 		      ->select('*')
		// 		      ->distinct('asignatura_id')->get();

    	return response()->json($asig_tomar);        

    }

}
