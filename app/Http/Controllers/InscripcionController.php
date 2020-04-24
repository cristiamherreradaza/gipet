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

    public function contabilidad(Request $request)
    {
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

    public function secretariado(Request $request)
    {
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

    public function auxiliar(Request $request)
    {
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

    public function store1(Request $request)
    {
    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
    	$fecha_registro = $fecha->format('Y-m-d H:i:s');
		$year = $fecha->format('Y');//obtenes solo el año actual
    	$carnet = $request->carnet;
    	$persona_id = Persona::where("borrado", NULL)
                    ->where('carnet', $carnet)
                    ->get();
        if (!empty($persona_id[0]->nombres)) {

        	// INGRESAR LOS DATOS A KARDEX DE LA CARRERA QUE TOMARA
	        $persona_id1 = $persona_id[0]->id;
	        $asignaturas = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', $request->carrera_id)
	                       ->where('anio_vigente', $year)
	                       ->get();
	        foreach ($asignaturas as $key => $valor1) {
	        	$kardex = new kardex();
		        $kardex->persona_id = $persona_id1;
				$kardex->asignatura_id = $asignaturas[$key]->id;
				$kardex->carrera_id = $request->carrera_id;
				$kardex->turno_id = $request->turno_id;
				$kardex->paralelo = $request->paralelo;
				$kardex->gestion = $asignaturas[$key]->gestion;
				$kardex->aprobado = 'No';
				$kardex->fecha_registro = $fecha_registro;
				$kardex->save();

				//INSERTAR A LA TABLA DE INSCRIPCIONES TODAS LAS ASIGNATURAS QUE NO TIENEN PREREQUISITOS
				$pre_requisitos = Prerequisito::where("sigla", NULL)
	                       ->where('asignatura_id', $asignaturas[$key]->id)
	                       ->get();
	            if (!empty($pre_requisitos[0]->id)) {
	            	$inscripcion = new Inscripcion();
					$inscripcion->asignatura_id = $asignaturas[$key]->id;
					$inscripcion->turno_id = $request->turno_id;
					$inscripcion->persona_id = $persona_id1;
					$inscripcion->paralelo = $request->paralelo;
					$inscripcion->gestion = $asignaturas[$key]->gestion;
					$inscripcion->fecha_inscripcion = $fecha_registro;
					$inscripcion->save();
	            }
	        }

	        // INGRESAR LOS DATOS A KARDEX DE LA CARRERA QUE SECRETARIADO
	        if (!empty($request->gestion_secre)) {
	        	$asignaturas_secre = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', '2')
	                       ->where('anio_vigente', $year)
	                       ->get();
	            if (!empty($asignaturas_secre)) {
	            	foreach ($asignaturas_secre as $keys => $valors) {
		        	$kardex = new kardex();
			        $kardex->persona_id = $persona_id1;
					$kardex->asignatura_id = $asignaturas_secre[$keys]->id;
					$kardex->carrera_id = '2';
					$kardex->turno_id = $request->turno_id_secre;
					$kardex->paralelo = $request->paralelo_secre;
					$kardex->gestion = $asignaturas_secre[$keys]->gestion;
					$kardex->aprobado = 'No';
					$kardex->fecha_registro = $fecha_registro;
					$kardex->save();

						//INSERTAR A LA TABLA DE INSCRIPCIONES TODAS LAS ASIGNATURAS QUE NO TIENEN PREREQUISITOS
						$pre_requisitos_se = Prerequisito::where("sigla", NULL)
			                       ->where('asignatura_id', $asignaturas_secre[$keys]->id)
			                       ->get();
			            if (!empty($pre_requisitos_se[0]->id)) {
			            	$inscripcion_se = new Inscripcion();
							$inscripcion_se->asignatura_id = $asignaturas_secre[$keys]->id;
							$inscripcion_se->turno_id = $request->turno_id_secre;
							$inscripcion_se->persona_id = $persona_id1;
							$inscripcion_se->paralelo = $request->paralelo_secre;
							$inscripcion_se->gestion = $asignaturas_secre[$keys]->gestion;
							$inscripcion_se->fecha_inscripcion = $fecha_registro;
							$inscripcion_se->save();
			            }
		        	}
	            }
	            
	        }

	        // INGRESAR LOS DATOS A KARDEX DE LA CARRERA QUE AUXILIAR
	        if (!empty($request->gestion_auxi)) {
	        	$asignaturas_auxi = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', '3')
	                       ->where('anio_vigente', $year)
	                       ->get();
	            if (!empty($asignaturas_auxi)) {
	            	foreach ($asignaturas_auxi as $keya => $valora) {
		        	$kardex = new kardex();
			        $kardex->persona_id = $persona_id1;
					$kardex->asignatura_id = $asignaturas_auxi[$keya]->id;
					$kardex->carrera_id = '3';
					$kardex->turno_id = $request->turno_id_auxi;
					$kardex->paralelo = $request->paralelo_auxi;
					$kardex->gestion = $asignaturas_auxi[$keya]->gestion;
					$kardex->aprobado = 'No';
					$kardex->fecha_registro = $fecha_registro;
					$kardex->save();

						//INSERTAR A LA TABLA DE INSCRIPCIONES TODAS LAS ASIGNATURAS QUE NO TIENEN PREREQUISITOS
						$pre_requisitos_au = Prerequisito::where("sigla", NULL)
			                       ->where('asignatura_id', $asignaturas_auxi[$keya]->id)
			                       ->get();
			            if (!empty($pre_requisitos_au[0]->id)) {
			            	$inscripcion_au = new Inscripcion();
							$inscripcion_au->asignatura_id = $asignaturas_auxi[$keya]->id;
							$inscripcion_au->turno_id = $request->turno_id_auxi;
							$inscripcion_au->persona_id = $persona_id1;
							$inscripcion_au->paralelo = $request->paralelo_auxi;
							$inscripcion_au->gestion = $asignaturas_auxi[$keya]->gestion;
							$inscripcion_au->fecha_inscripcion = $fecha_registro;
							$inscripcion_au->save();
			            }
		        	}
	            }
	            
	        }

        } else {
        	// echo 'no';
        	//INGRESAR AL ALUMNO NUEVO SI NO SE ENCUENTRA REGISTRADO
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
	        

	        // INGRESAR LOS DATOS A KARDEX
	        $persona_id2 = $persona->id;
	        $asignaturas = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', $request->carrera_id)
	                       ->where('anio_vigente', $year)
	                       ->get();
	        foreach ($asignaturas as $key => $valor) {
	        	$kardex = new kardex();
		        $kardex->persona_id = $persona_id2;
				$kardex->asignatura_id = $asignaturas[$key]->id;
				$kardex->carrera_id = $request->carrera_id;
				$kardex->turno_id = $request->turno_id;
				$kardex->paralelo = $request->paralelo;
				$kardex->gestion = $asignaturas[$key]->gestion;
				$kardex->aprobado = 'No';
				$kardex->fecha_registro = $fecha_registro;
				$kardex->save();

				//INSERTAR A LA TABLA DE INSCRIPCIONES TODAS LAS ASIGNATURAS QUE NO TIENEN PREREQUISITOS
				$pre_requisitos = Prerequisito::where("sigla", NULL)
	                       ->where('asignatura_id', $asignaturas[$key]->id)
	                       ->get();
	            if (!empty($pre_requisitos[0]->id)) {
	            	$inscripcion = new Inscripcion();
					$inscripcion->asignatura_id = $asignaturas[$key]->id;
					$inscripcion->turno_id = $request->turno_id;
					$inscripcion->persona_id = $persona_id2;
					$inscripcion->paralelo = $request->paralelo;
					$inscripcion->gestion = $asignaturas[$key]->gestion;
					$inscripcion->fecha_inscripcion = $fecha_registro;
					$inscripcion->save();
	            }
	        }

	         // INGRESAR LOS DATOS A KARDEX DE LA CARRERA QUE SECRETARIADO
	        if (!empty($request->gestion_secre)) {
	        	$asignaturas_secre = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', '2')
	                       ->where('anio_vigente', $year)
	                       ->get();
	            if (!empty($asignaturas_secre)) {
		            foreach ($asignaturas_secre as $keys => $valors) {
		        	$kardex = new kardex();
			        $kardex->persona_id = $persona_id2;
					$kardex->asignatura_id = $asignaturas_secre[$keys]->id;
					$kardex->carrera_id = '2';
					$kardex->turno_id = $request->turno_id_secre;
					$kardex->paralelo = $request->paralelo_secre;
					$kardex->gestion = $asignaturas_secre[$keys]->gestion;
					$kardex->aprobado = 'No';
					$kardex->fecha_registro = $fecha_registro;
					$kardex->save();

						//INSERTAR A LA TABLA DE INSCRIPCIONES TODAS LAS ASIGNATURAS QUE NO TIENEN PREREQUISITOS
						$pre_requisitos_se = Prerequisito::where("sigla", NULL)
			                       ->where('asignatura_id', $asignaturas_secre[$keys]->id)
			                       ->get();
			            if (!empty($pre_requisitos_se[0]->id)) {
			            	$inscripcion_se = new Inscripcion();
							$inscripcion_se->asignatura_id = $asignaturas_secre[$keys]->id;
							$inscripcion_se->turno_id = $request->turno_id_secre;
							$inscripcion_se->persona_id = $persona_id2;
							$inscripcion_se->paralelo = $request->paralelo_secre;
							$inscripcion_se->gestion = $asignaturas_secre[$keys]->gestion;
							$inscripcion_se->fecha_inscripcion = $fecha_registro;
							$inscripcion_se->save();
			            }
		        	}
		       	}
	        }

	        // INGRESAR LOS DATOS A KARDEX DE LA CARRERA QUE AUXILIAR
	        if (!empty($request->gestion_auxi)) {
	        	$asignaturas_auxi = Asignatura::where("borrado", NULL)
	                       ->where('carrera_id', '3')
	                       ->where('anio_vigente', $year)
	                       ->get();
	            if (!empty($asignaturas_auxi)) {
		            foreach ($asignaturas_auxi as $keya => $valora) {
		        	$kardex = new kardex();
			        $kardex->persona_id = $persona_id2;
					$kardex->asignatura_id = $asignaturas_auxi[$keya]->id;
					$kardex->carrera_id = '3';
					$kardex->turno_id = $request->turno_id_auxi;
					$kardex->paralelo = $request->paralelo_auxi;
					$kardex->gestion = $asignaturas_auxi[$keya]->gestion;
					$kardex->aprobado = 'No';
					$kardex->fecha_registro = $fecha_registro;
					$kardex->save();

					//INSERTAR A LA TABLA DE INSCRIPCIONES TODAS LAS ASIGNATURAS QUE NO TIENEN PREREQUISITOS
						$pre_requisitos_au = Prerequisito::where("sigla", NULL)
			                       ->where('asignatura_id', $asignaturas_auxi[$keya]->id)
			                       ->get();
			            if (!empty($pre_requisitos_au[0]->id)) {
			            	$inscripcion_au = new Inscripcion();
							$inscripcion_au->asignatura_id = $asignaturas_auxi[$keya]->id;
							$inscripcion_au->turno_id = $request->turno_id_auxi;
							$inscripcion_au->persona_id = $persona_id2;
							$inscripcion_au->paralelo = $request->paralelo_auxi;
							$inscripcion_au->gestion = $asignaturas_auxi[$keya]->gestion;
							$inscripcion_au->fecha_inscripcion = $fecha_registro;
							$inscripcion_au->save();
			            }
		        	}
		        }
	        }

        }

        return redirect('Inscripcion/lista');
       
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

    public function tomar_asignaturas1($persona_id){
    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$anio = $fecha->format('Y');//obtenes solo el año actual

    	$carreras = CarreraPersona::where("borrado", NULL)
	                       ->where('persona_id', $persona_id)
	                       ->where('anio_vigente', $anio)
	                       ->get();
	    foreach ($carreras as $key => $value) {

	    	$asignatura_kardex = Kardex::where("borrado", NULL)
		                       ->where('persona_id', $persona_id)
		                       ->where('carrera_id', $carreras[$key]->carrera_id)
		                       ->where('aprobado', 'No')
		                       ->get();
		    foreach ($asignatura_kardex as $key1 => $value1) {
		    	$pre_requisitos = Prerequisito::where("borrado", NULL)
		                       ->where('asignatura_id', $asignatura_kardex[$key1]->asignatura_id)
		                       ->get();
		        foreach ($pre_requisitos as $key2 => $value2) {
		        	if ($pre_requisitos[$key2]->sigla == NULL) {
		        		echo $pre_requisitos[$key2]->asignatura_id. "\n";
		        		DB::table('materias')->insert([
			            'asignatura_id' => $pre_requisitos[$key2]->asignatura_id,
			        	]);
					} else {
						echo $pre_requisitos[$key2]->asignatura_id. "\n";
						$verifica = Kardex::where("borrado", NULL)
		                       ->where('persona_id', $persona_id)
		                       ->where('carrera_id', $carreras[$key]->carrera_id)
		                       ->where('asignatura_id', $pre_requisitos[$key2]->asignatura_id)
		                       ->get();
		                if ($verifica[0]->aprobado == 'Si') {
		                	echo $verifica[0]->asignatura_id. "\n";
		                	DB::table('materias')->insert([
				            'asignatura_id' => $pre_requisitos[$key2]->asignatura_id,
				        	]);
		                }
					}
		        }
		    }
	    }
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

	    foreach ($carreras as $key => $value) {
	    	$carr = $carreras[$key]->carrera_id;//obtenes el id de la carrera seleccioanda en la vista
		
			//obtenemos todas las asignaturas que no estan aprobadas segun la carrera seleccionada
	    	$asignaturas = DB::table('kardex')
					      ->select('*')
					      ->where('carrera_id','=',$carr)
					      ->where('persona_id','=',$per)
					      ->where('aprobado','No')
					      ->distinct()->get();
			// dd($asignaturas);
			//este foreach nos ayuda a recorrer todas las asignaturas  
			foreach ($asignaturas as $key => $value) {
				$id = $asignaturas[$key]->asignatura_id;
				//obtenemos los prerequisitos de las materias seleccionadas
				$pre_asig = DB::table('prerequisitos')
					      ->select('*')
					      ->where('asignatura_id',$id)
					      ->get();
				// dd($pre_asig);
				//este foreach nos ayuda a recorrer todos los prerequisitos     
				foreach ($pre_asig as $key1 => $value1) {
					
					// $id1 = $pre_asig[$key1]->asignatura_id;
					//verificamos si tienen prerequisitos
					$datos_asig = Asignatura::find($pre_asig[$key1]->asignatura_id);
					// dd($datos_asig);

					if (!empty($pre_asig[$key1]->sigla)){
						$id2 = $pre_asig[$key1]->prerequisito_id;

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
	    }
		

    	return response()->json($asig_tomar);       

    }

}
