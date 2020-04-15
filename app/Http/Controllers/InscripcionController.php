<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inscripcion;
use App\Carrera;
use App\Asignatura;
use App\Turno;
use App\Persona;
use App\Kardex;
use DB;

class InscripcionController extends Controller
{
    public function inscripcion()
    {
        $carreras = Carrera::where('estado',1)->get();
        $turnos = Turno::where('borrado', NULL)->get();
        // dd($turnos);
        return view('inscripcion.inscripcion', compact('carreras', 'turnos'));    
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

    public function lista()
    {
        return view('inscripcion.lista');
    }

    public function ajax_datos()
    {
        return datatables()->eloquent(Kardex::query())->toJson();
    }


    public function re_inscripcion(Request $request){

    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$year = $fecha->format('Y');//obtenes solo el año actual

    	$id = $request->id;//obtenes el id de la asignatura seleccioanda en la vista
    	$persona = Persona::find($id);
    	// $carreras = Carrera::where('estado',1)->get();
    	$carreras = DB::table('kardex')
				      ->select(
				        'kardex.carrera_id',
				        'carreras.nombre',
				        'carreras.gestion'
				      )
				      ->join('carreras', 'kardex.carrera_id','=','carreras.id')
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
    	$asignaturas = DB::table('kardex')
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

					$asigna = DB::table('kardex')
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
