<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inscripcion;
use App\Carrera;
use App\Asignatura;
use App\Turno;
use App\Persona;
use App\Kardex;
use App\CarreraPersona;
use App\Prerequisito;
use DB;

class InscripcionController extends Controller
{
    public function inscripcion()
    {
        $carreras = Carrera::where('borrado',NULL)->get();
        $turnos = Turno::where('borrado', NULL)->get();
        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$year = $fecha->format('Y');//obtenes solo el año actual
		$asignaturas = DB::table('asignaturas')
			    ->join('prerequisitos', 'asignaturas.id', '=', 'prerequisitos.asignatura_id')
			    ->where('asignaturas.anio_vigente', '=', $year)
			    ->where('prerequisitos.sigla', '=', NULL)
			    ->select('asignaturas.*')
			    ->get();
        // dd($asignaturas);
        return view('inscripcion.inscripcion', compact('carreras', 'turnos', 'year', 'asignaturas'));    
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

    public function selecciona_asignatura()
    {
        $carreras = Carrera::where('estado',1)->get();
        $turnos = Turno::where('borrado', NULL)->get();
        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$year = $fecha->format('Y');//obtenes solo el año actual
        // dd($turnos);
        return view('inscripcion.selecciona_asignatura', compact('carreras', 'turnos', 'year'));    
    }

    public function busca_asignatura1(Request $request)
    {
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

    public function busca_asignatura(Request $request)
    {
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

    public function busca_carrera(Request $request)
    {
    	$asig = $request->id;//obtenes el id de la asignatura seleccioanda en la vista
		$carre = Carrera::where("borrado",NULL)
					    ->where('id',$asig)
					    ->get();
    	return response()->json($carre);
    }

    public function ver_persona($persona_id = null)
    {
    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$year = $fecha->format('Y');//obtenes solo el año actual

        $datosPersonales = Persona::where('borrado', NULL)
                        ->where('id', $persona_id)
                        ->first();

        $carrerasPersona = CarreraPersona::where('borrado', NULL)
                        ->where('persona_id', $persona_id)
                        ->get();
        $inscripciones = CarreraPersona::where('borrado', NULL)
                        ->where('persona_id', $persona_id)
                        ->get();
        $carreras = Carrera::where('borrado',NULL)->get();

        $turnos = Turno::where('borrado', NULL)
                        ->get();

        return view('inscripcion.detalle')->with(compact('datosPersonales', 'carrerasPersona', 'inscripciones', 'carreras', 'turnos', 'year'));

    }

    public function store(Request $request)
    {
    	// dd($request->all());
    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
    	$fecha_registro = $fecha->format('Y-m-d H:i:s');
		$anio_vigente = $fecha->format('Y');//obtenes solo el año actual

		// EN ESTE IF AGREGAREMOS O ACTUALIZAREMOS LOS DATOS DE UN ESTUDIANTE
		if (!empty($request->persona_id)) {
		        $persona = Persona::find($request->persona_id);
		       	$persona->apellido_paterno  = $request->apellido_paterno;
		        $persona->apellido_materno  = $request->apellido_materno;
		        $persona->nombres           = $request->nombres;
		        $persona->carnet            = $request->carnet;
		        $persona->expedido          = $request->expedido;
		        $persona->fecha_nacimiento  = $request->fecha_nacimiento;
		        $persona->sexo              = $request->sexo;
		        $persona->telefono_celular  = $request->telefono_celular;
		        $persona->email             = $request->email;
		        $persona->direccion         = $request->direccion;
		        $persona->trabaja           = $request->trabaja;
		        $persona->empresa           = $request->empresa;
		        $persona->direccion_empresa = $request->direccion_empresa;
		        $persona->telefono_empresa  = $request->telefono_empresa;
		        $persona->email_empresa     = $request->email_empresa;
		        $persona->nombre_padre      = $request->nombre_padre;
		        $persona->celular_padre     = $request->celular_padre;
		        $persona->nombre_madre      = $request->nombre_madre;
		        $persona->celular_madre     = $request->celular_madre;
		        $persona->nombre_tutor      = $request->nombre_tutor;
		        $persona->telefono_tutor    = $request->telefono_tutor;
		        $persona->nombre_esposo     = $request->nombre_esposo;
		        $persona->telefono_esposo   = $request->telefono_esposo;
		        $persona->save();
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
		        $persona->direccion         = $request->direccion;
		        $persona->trabaja           = $request->trabaja;
		        $persona->empresa           = $request->empresa;
		        $persona->direccion_empresa = $request->direccion_empresa;
		        $persona->telefono_empresa  = $request->telefono_empresa;
		        $persona->email_empresa     = $request->email_empresa;
		        $persona->nombre_padre      = $request->nombre_padre;
		        $persona->celular_padre     = $request->celular_padre;
		        $persona->nombre_madre      = $request->nombre_madre;
		        $persona->celular_madre     = $request->celular_madre;
		        $persona->nombre_tutor      = $request->nombre_tutor;
		        $persona->telefono_tutor    = $request->telefono_tutor;
		        $persona->nombre_esposo     = $request->nombre_esposo;
		        $persona->telefono_esposo   = $request->telefono_esposo;
		        $persona->save();
		}

		$id_persona = Persona::where("borrado", NULL)
                    ->where('carnet', $request->carnet)
                    ->get();
        $persona_id = $id_persona[0]->id;
        // CARRERAS
    	if (!empty($request->carrera_id_1)) {
    			// INSERTA A LA BASE DE DATOS UNA CARRERA
        		$carrera_1 = new CarreraPersona();
		        $carrera_1->carrera_id   = $request->carrera_id_1;
		        $carrera_1->persona_id   = $persona_id;
		        $carrera_1->turno_id     = $request->turno_id_1;
		        $carrera_1->paralelo     = $request->paralelo_1;
		        $carrera_1->anio_vigente = $request->gestion_1;
		        $carrera_1->sexo         = $request->sexo;
		        $carrera_1->save();

		        //INGRESA A LA BASE DE DATOS TODO SU PENSUM DE DICHA CARRERA
		        $asignaturas1 = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', $request->carrera_id_1)
	                       ->where('anio_vigente', $request->gestion_1)
	                       ->get();
		        foreach ($asignaturas1 as $key => $valor1) {
		        	$kardex = new kardex();
			        $kardex->persona_id = $persona_id;
					$kardex->asignatura_id = $asignaturas1[$key]->id;
					$kardex->carrera_id = $request->carrera_id_1;
					$kardex->turno_id = $request->turno_id_1;
					$kardex->paralelo = $request->paralelo_1;
					$kardex->gestion = $asignaturas1[$key]->gestion;
					$kardex->aprobado = 'No';
					$kardex->anio_registro = $fecha_registro;
					$kardex->save();
		        }
        }

        if (!empty($request->gestion_2)) {
        		$carrera_2 = new CarreraPersona();
		        $carrera_2->carrera_id   = 2;
		        $carrera_2->persona_id   = $persona_id;
		        $carrera_2->turno_id     = $request->turno_id_2;
		        $carrera_2->paralelo 	 = $request->paralelo_2;
		        $carrera_2->anio_vigente = $request->gestion_2;
		        $carrera_2->sexo         = $request->sexo;
		        $carrera_2->save();

		        //INGRESA A LA BASE DE DATOS TODO SU PENSUM DE DICHA CARRERA
		        $asignaturas2 = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', 2)
	                       ->where('anio_vigente', $request->gestion_2)
	                       ->get();
		        foreach ($asignaturas2 as $key => $valor1) {
		        	$kardex = new kardex();
			        $kardex->persona_id = $persona_id;
					$kardex->asignatura_id = $asignaturas2[$key]->id;
					$kardex->carrera_id = 2;
					$kardex->turno_id = $request->turno_id_2;
					$kardex->paralelo = $request->paralelo_2;
					$kardex->gestion = $asignaturas2[$key]->gestion;
					$kardex->aprobado = 'No';
					$kardex->anio_registro = $fecha_registro;
					$kardex->save();
		        }
        }

        if (!empty($request->gestion_3)) {
        		$carrera_3 = new CarreraPersona();
		        $carrera_3->carrera_id   = 3;
		        $carrera_3->persona_id   = $persona_id;
		        $carrera_3->turno_id     = $request->turno_id_3;
		        $carrera_3->paralelo 	 = $request->paralelo_3;
		        $carrera_3->anio_vigente = $request->gestion_3;
		        $carrera_3->sexo         = $request->sexo;
		        $carrera_3->save();

		        //INGRESA A LA BASE DE DATOS TODO SU PENSUM DE DICHA CARRERA
		        $asignaturas3 = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', 3)
	                       ->where('anio_vigente', $request->gestion_3)
	                       ->get();
		        foreach ($asignaturas3 as $key => $valor1) {
		        	$kardex = new kardex();
			        $kardex->persona_id = $persona_id;
					$kardex->asignatura_id = $asignaturas3[$key]->id;
					$kardex->carrera_id = 3;
					$kardex->turno_id = $request->turno_id_3;
					$kardex->paralelo = $request->paralelo_3;
					$kardex->gestion = $asignaturas3[$key]->gestion;
					$kardex->aprobado = 'No';
					$kardex->anio_registro = $fecha_registro;
					$kardex->save();
		        }
        }

        if (!empty($request->carrera_id_4)) {
        		$carrera_4 = new CarreraPersona();
		        $carrera_4->carrera_id   = $request->carrera_id_4;
		        $carrera_4->persona_id   = $persona_id;
		        $carrera_4->turno_id     = $request->turno_id_4;
		        $carrera_4->paralelo 	 = $request->paralelo_4;
		        $carrera_4->anio_vigente = $request->gestion_4;
		        $carrera_4->sexo         = $request->sexo;
		        $carrera_4->save();

		        //INGRESA A LA BASE DE DATOS TODO SU PENSUM DE DICHA CARRERA
		        $asignaturas4 = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', $request->carrera_id_4)
	                       ->where('anio_vigente', $request->gestion_4)
	                       ->get();
		        foreach ($asignaturas4 as $key => $valor1) {
		        	$kardex = new kardex();
			        $kardex->persona_id = $persona_id;
					$kardex->asignatura_id = $asignaturas4[$key]->id;
					$kardex->carrera_id = $request->carrera_id_4;
					$kardex->turno_id = $request->turno_id_4;
					$kardex->paralelo = $request->paralelo_4;
					$kardex->gestion = $asignaturas4[$key]->gestion;
					$kardex->aprobado = 'No';
					$kardex->anio_registro = $fecha_registro;
					$kardex->save();
		        }
        }

        if (!empty($request->carrera_id_5)) {
        		$carrera_5 = new CarreraPersona();
		        $carrera_5->carrera_id   = $request->carrera_id_5;
		        $carrera_5->persona_id   = $persona_id;
		        $carrera_5->turno_id     = $request->turno_id_5;
		        $carrera_5->paralelo 	 = $request->paralelo_5;
		        $carrera_5->anio_vigente = $request->gestion_5;
		        $carrera_5->sexo         = $request->sexo;
		        $carrera_5->save();

		        //INGRESA A LA BASE DE DATOS TODO SU PENSUM DE DICHA CARRERA
		        $asignaturas5 = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', $request->carrera_id_5)
	                       ->where('anio_vigente', $request->gestion_5)
	                       ->get();
		        foreach ($asignaturas5 as $key => $valor1) {
		        	$kardex = new kardex();
			        $kardex->persona_id = $persona_id;
					$kardex->asignatura_id = $asignaturas5[$key]->id;
					$kardex->carrera_id = $request->carrera_id_5;
					$kardex->turno_id = $request->turno_id_5;
					$kardex->paralelo = $request->paralelo_5;
					$kardex->gestion = $asignaturas5[$key]->gestion;
					$kardex->aprobado = 'No';
					$kardex->anio_registro = $fecha_registro;
					$kardex->save();
		        }
        }

        if (!empty($request->carrera_id_6)) {
        		$carrera_6 = new CarreraPersona();
		        $carrera_6->carrera_id   = $request->carrera_id_6;
		        $carrera_6->persona_id   = $persona_id;
		        $carrera_6->turno_id     = $request->turno_id_6;
		        $carrera_6->paralelo 	 = $request->paralelo_6;
		        $carrera_6->anio_vigente = $request->gestion_6;
		        $carrera_6->sexo         = $request->sexo;
		        $carrera_6->save();

		        //INGRESA A LA BASE DE DATOS TODO SU PENSUM DE DICHA CARRERA
		        $asignaturas6 = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', $request->carrera_id_6)
	                       ->where('anio_vigente', $request->gestion_6)
	                       ->get();
		        foreach ($asignaturas6 as $key => $valor1) {
		        	$kardex = new kardex();
			        $kardex->persona_id = $persona_id;
					$kardex->asignatura_id = $asignaturas6[$key]->id;
					$kardex->carrera_id = $request->carrera_id_6;
					$kardex->turno_id = $request->turno_id_6;
					$kardex->paralelo = $request->paralelo_6;
					$kardex->gestion = $asignaturas6[$key]->gestion;
					$kardex->aprobado = 'No';
					$kardex->anio_registro = $fecha_registro;
					$kardex->save();
		        }
        }

        if (!empty($request->carrera_id_7)) {
        		$carrera_7 = new CarreraPersona();
		        $carrera_7->carrera_id   = $request->carrera_id_7;
		        $carrera_7->persona_id   = $persona_id;
		        $carrera_7->turno_id     = $request->turno_id_7;
		        $carrera_7->paralelo 	 = $request->paralelo_7;
		        $carrera_7->anio_vigente = $request->gestion_7;
		        $carrera_7->sexo         = $request->sexo;
		        $carrera_7->save();

		        //INGRESA A LA BASE DE DATOS TODO SU PENSUM DE DICHA CARRERA
		        $asignaturas7 = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', $request->carrera_id_7)
	                       ->where('anio_vigente', $request->gestion_7)
	                       ->get();
		        foreach ($asignaturas7 as $key => $valor1) {
		        	$kardex = new kardex();
			        $kardex->persona_id = $persona_id;
					$kardex->asignatura_id = $asignaturas7[$key]->id;
					$kardex->carrera_id = $request->carrera_id_7;
					$kardex->turno_id = $request->turno_id_7;
					$kardex->paralelo = $request->paralelo_7;
					$kardex->gestion = $asignaturas7[$key]->gestion;
					$kardex->aprobado = 'No';
					$kardex->anio_registro = $fecha_registro;
					$kardex->save();
		        }
        }

        // ASIGNATURAS

        if (!empty($request->asignatura_id_1)) {
    			// INSERTA A LA BASE DE DATOS UNA ASIGNATURA INDIVIDUAL
	        	$inscripcion_1 = new Inscripcion();
				$inscripcion_1->asignatura_id = $request->asignatura_id_1;
				$inscripcion_1->turno_id = $request->asignatura_turno_id_1;
				$inscripcion_1->persona_id = $persona_id;
				$inscripcion_1->paralelo = $request->asignatura_paralelo_1;
				$inscripcion_1->gestion = $request->asignatura_gestion_1;
				$inscripcion_1->anio_vigente = $fecha_registro;
				$inscripcion_1->save();
        }

        if (!empty($request->asignatura_id_2)) {
    			// INSERTA A LA BASE DE DATOS UNA ASIGNATURA INDIVIDUAL
	        	$inscripcion_2 = new Inscripcion();
				$inscripcion_2->asignatura_id = $request->asignatura_id_2;
				$inscripcion_2->turno_id = $request->asignatura_turno_id_2;
				$inscripcion_2->persona_id = $persona_id;
				$inscripcion_2->paralelo = $request->asignatura_paralelo_2;
				$inscripcion_2->gestion = $request->asignatura_gestion_2;
				$inscripcion_2->anio_vigente = $fecha_registro;
				$inscripcion_2->save();
        }

        if (!empty($request->asignatura_id_3)) {
    			// INSERTA A LA BASE DE DATOS UNA ASIGNATURA INDIVIDUAL
	        	$inscripcion_3 = new Inscripcion();
				$inscripcion_3->asignatura_id = $request->asignatura_id_3;
				$inscripcion_3->turno_id = $request->asignatura_turno_id_3;
				$inscripcion_3->persona_id = $persona_id;
				$inscripcion_3->paralelo = $request->asignatura_paralelo_3;
				$inscripcion_3->gestion = $request->asignatura_gestion_3;
				$inscripcion_3->anio_vigente = $fecha_registro;
				$inscripcion_3->save();
        }

        if (!empty($request->asignatura_id_4)) {
    			// INSERTA A LA BASE DE DATOS UNA ASIGNATURA INDIVIDUAL
	        	$inscripcion_4 = new Inscripcion();
				$inscripcion_4->asignatura_id = $request->asignatura_id_4;
				$inscripcion_4->turno_id = $request->asignatura_turno_id_4;
				$inscripcion_4->persona_id = $persona_id;
				$inscripcion_4->paralelo = $request->asignatura_paralelo_4;
				$inscripcion_4->gestion = $request->asignatura_gestion_4;
				$inscripcion_4->anio_vigente = $fecha_registro;
				$inscripcion_4->save();
        }

        if (!empty($request->asignatura_id_5)) {
    			// INSERTA A LA BASE DE DATOS UNA ASIGNATURA INDIVIDUAL
	        	$inscripcion_5= new Inscripcion();
				$inscripcion_5->asignatura_id = $request->asignatura_id_5;
				$inscripcion_5->turno_id = $request->asignatura_turno_id_5;
				$inscripcion_5->persona_id = $persona_id;
				$inscripcion_5->paralelo = $request->asignatura_paralelo_5;
				$inscripcion_5->gestion = $request->asignatura_gestion_5;
				$inscripcion_5->anio_vigente = $fecha_registro;
				$inscripcion_5->save();
        }

        return redirect('Inscripcion/tomar_asignaturas/'.$persona_id);
	        

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


    public function re_inscripcion(Request $request)
    {

    	$carrera = new CarreraPersona();
        $carrera->carrera_id   = $request->re_carrera_id;
        $carrera->persona_id   = $request->re_persona_id;
        $carrera->turno_id     = $request->re_turno_id;
        $carrera->paralelo     = $request->re_paralelo;
        $carrera->anio_vigente = $request->re_anio_vigente;
        $carrera->sexo         = $request->re_sexo;
        $carrera->save();

        $id = $carrera->id;

        $this->asignaturas_reinscripcion($request->re_turno_id, $request->re_persona_id, $request->re_carrera_id, $request->re_paralelo, $request->re_anio_vigente);

        return redirect('Inscripcion/ver_persona/'.$request->re_persona_id);

  //   	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		// $year = $fecha->format('Y');//obtenes solo el año actual

  //   	$id = $request->id;//obtenes el id de la asignatura seleccioanda en la vista
  //   	$persona = Persona::find($id);
  //   	// $carreras = Carrera::where('estado',1)->get();
  //   	$carreras = DB::table('kardex')
		// 		      ->select(
		// 		        'kardex.carrera_id',
		// 		        'carreras.nombre',
		// 		        'carreras.gestion'
		// 		      )
		// 		      ->join('carreras', 'kardex.carrera_id','=','carreras.id')
		// 		      ->where('carreras.gestion',$year)
		// 		      ->distinct()->get();
  //       $turnos = Turno::where('borrado', NULL)->get();
		
  //       // dd($persona);
  //       return view('inscripcion.re_inscripcion', compact('persona', 'carreras', 'turnos', 'year'));    
    }

    public function asignaturas_reinscripcion($turno_id, $persona_id, $carrera_id, $paralelo, $anio_vigente)
    {
		//obtenemos todas las asignaturas que no estan aprobadas segun la carrera seleccionada
	    	$asignaturas = DB::table('kardex')
					      ->select('*')
					      ->where('carrera_id','=',$carrera_id)
					      ->where('persona_id','=',$persona_id)
					      ->where('aprobado','No')
					      ->distinct()->get();
			// dd($asignaturas);
			//este foreach nos ayuda a recorrer todas las asignaturas  
			foreach ($asignaturas as $value2) {
				$id = $value2->asignatura_id;
				//obtenemos los prerequisitos de las materias seleccionadas
				$pre_asig = DB::table('prerequisitos')
					      ->select('*')
					      ->where('asignatura_id',$id)
					      ->get();
				// dd($pre_asig);
				//este foreach nos ayuda a recorrer todos los prerequisitos     
				foreach ($pre_asig as $value3) {
					
					// $id1 = $pre_asig[$key1]->asignatura_id;
					//verificamos si tienen prerequisitos
					$datos_asig = Asignatura::find($value3->asignatura_id);
					// dd($datos_asig);

					if (!empty($value3->sigla)){
						$id2 = $value3->prerequisito_id;

						$asigna = DB::table('kardex')
					      ->select('*')
					      ->where('asignatura_id',$id2)
					      ->where('persona_id',$persona_id)
					      ->distinct()->get();
					    
					    $datos = $asigna[0]->aprobado;


					    if ($datos == 'Si') {
					    	echo $datos;
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
	        // dd($materias);
	        foreach ($materias as $value4) {
	        	$id_asig = $value4->asignatura_id;
	        	$valor = $value4->nro;

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
	        foreach ($asig_tomar as $asig_tomar1) {

	        		$kar1 = DB::table('kardex')
		            ->select('asignatura_id', 'paralelo', 'gestion', 'carrera_id')
					->where('persona_id','=',$persona_id)
		            ->where('asignatura_id','=',$asig_tomar1->asignatura_id)
		            ->get();

	        		$inscripcion = new Inscripcion();
					$inscripcion->asignatura_id = $asig_tomar1->asignatura_id;
					$inscripcion->turno_id = $turno_id;
					$inscripcion->persona_id = $persona_id;
					$inscripcion->carrera_id = $carrera_id;
					$inscripcion->paralelo = $paralelo;
					$inscripcion->gestion = $kar1[0]->gestion;
					$inscripcion->anio_vigente = $anio_vigente;
					$inscripcion->save();
	        }

	        DB::table('materias')->truncate();

    }

    public function tomar_asignaturas($persona_id)
    {
    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$anio = $fecha->format('Y');//obtenes solo el año actual

		$per = $persona_id;//obtenes el id de la persona seleccioanda en la vista
		$carreras = CarreraPersona::where("borrado", NULL)
	                       ->where('persona_id', $per)
	                       ->where('anio_vigente', $anio)
	                       ->get();

	    foreach ($carreras as $value1) {
	    	$carr = $value1->carrera_id;//obtenes el id de la carrera seleccioanda en la vista
		
			//obtenemos todas las asignaturas que no estan aprobadas segun la carrera seleccionada
	    	$asignaturas = DB::table('kardex')
					      ->select('*')
					      ->where('carrera_id','=',$carr)
					      ->where('persona_id','=',$per)
					      ->where('aprobado','No')
					      ->distinct()->get();
			// dd($asignaturas);
			//este foreach nos ayuda a recorrer todas las asignaturas  
			foreach ($asignaturas as $value2) {
				$id = $value2->asignatura_id;
				//obtenemos los prerequisitos de las materias seleccionadas
				$pre_asig = DB::table('prerequisitos')
					      ->select('*')
					      ->where('asignatura_id',$id)
					      ->get();
				// dd($pre_asig);
				//este foreach nos ayuda a recorrer todos los prerequisitos     
				foreach ($pre_asig as $value3) {
					
					// $id1 = $pre_asig[$key1]->asignatura_id;
					//verificamos si tienen prerequisitos
					$datos_asig = Asignatura::find($value3->asignatura_id);
					// dd($datos_asig);

					if (!empty($value3->sigla)){
						$id2 = $value3->prerequisito_id;

						$asigna = DB::table('kardex')
					      ->select('*')
					      ->where('asignatura_id',$id2)
					      ->where('persona_id',$per)
					      ->distinct()->get();
					    
					    $datos = $asigna[0]->aprobado;


					    if ($datos == 'Si') {
					    	echo $datos;
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
	        // dd($materias);
	        foreach ($materias as $value4) {
	        	$id_asig = $value4->asignatura_id;
	        	$valor = $value4->nro;

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
	        foreach ($asig_tomar as $asig_tomar1) {

	        		$kar1 = DB::table('kardex')
		            ->select('asignatura_id', 'paralelo', 'gestion', 'carrera_id')
					->where('persona_id','=',$per)
		            ->where('asignatura_id','=',$asig_tomar1->asignatura_id)
		            ->where('turno_id','=',$carreras[0]->turno_id)
		            ->get();

	        		$inscripcion = new Inscripcion();
					$inscripcion->asignatura_id = $asig_tomar1->asignatura_id;
					$inscripcion->turno_id = $carreras[0]->turno_id;
					$inscripcion->persona_id = $per;
					$inscripcion->carrera_id = $kar1[0]->carrera_id;
					$inscripcion->paralelo = $kar1[0]->paralelo;
					$inscripcion->gestion = $kar1[0]->gestion;
					$inscripcion->anio_vigente = $anio;
					$inscripcion->save();
	        }

	        DB::table('materias')->truncate();
	        
	    }
		return redirect('Persona/listado');
    	// return response()->json($asig_tomar);
    	    
    }


    public function vista()
    {
    	$id = 3185;//obtenes el id de la asignatura seleccioanda en la vista
    	$persona = Persona::find($id);
    	$carreras = Carrera::where('borrado',NULL)->get();
        $turnos = Turno::where('borrado', NULL)->get();
        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$year = $fecha->format('Y');//obtenes solo el año actual
		$asignaturas = DB::table('asignaturas')
			    ->join('prerequisitos', 'asignaturas.id', '=', 'prerequisitos.asignatura_id')
			    ->where('asignaturas.anio_vigente', '=', $year)
			    ->where('prerequisitos.sigla', '=', NULL)
			    ->select('asignaturas.*')
			    ->get();
        // dd($asignaturas);
    	return view('inscripcion.selecciona_asignatura', compact('carreras', 'turnos', 'year', 'asignaturas', 'persona')); 
    	
    }

}
