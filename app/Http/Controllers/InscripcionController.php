<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inscripcion;
use App\Carrera;
use App\Asignatura;
use App\Turno;
use App\Persona;
use App\Nota;
use App\NotasPropuesta;
use App\CarreraPersona;
use App\Prerequisito;
use App\Kardex;
use App\CobrosTemporada;
use App\Servicio;
use DB;

class InscripcionController extends Controller
{
    public function inscripcion()
    {
        $carreras = Carrera::where("deleted_at", NULL)
                        ->get();
        $turnos = Turno::get();
        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$year = $fecha->format('Y');//obtenes solo el año actual
		// $asignaturas = DB::table('asignaturas')
		// 	    ->join('prerequisitos', 'asignaturas.id', '=', 'prerequisitos.asignatura_id')
		// 	    ->where('asignaturas.anio_vigente', '=', $year)
		// 	    ->where('prerequisitos.sigla', '=', NULL)
		// 	    ->select('asignaturas.*')
		// 	    ->get();
        
        $asignaturas = DB::table('asignaturas')
                ->where('asignaturas.anio_vigente', '=', $year)
                ->join('servicios_asignaturas', 'asignaturas.id', '=', 'servicios_asignaturas.asignatura_id')
                ->where('servicios_asignaturas.servicio_id', '!=', 2)
                ->select('asignaturas.*')
                ->get();      

        // $asignaturas = Asignatura::where('anio_vigente', '=', $year)
        //         ->where('servicio_id', '!=', 2)
        //         ->get();
        // dd($asignaturas);
        return view('inscripcion.inscripcion', compact('carreras', 'turnos', 'year', 'asignaturas'));    
    }

    public function guardar(Request $request)
    {
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
        $id_persona = Persona::where("deleted_at", NULL)
                    ->where('carnet', $request->carnet)
                    ->get();
        $persona_id = $id_persona[0]->id;


        // REGISTRA LAS CARRERAS INSCRITAS
        foreach ($request->numero as $carr) {
            $datos_carrera = 'carrera_'.$carr;
            $datos_turno = 'turno_'.$carr;
            $datos_paralelo = 'paralelo_'.$carr;
            $datos_gestion = 'gestion_'.$carr;

            if ($request->$datos_carrera != 0) {
                $carrera_1 = new CarreraPersona();
                $carrera_1->carrera_id   = $request->$datos_carrera;
                $carrera_1->persona_id   = $persona_id;
                $carrera_1->turno_id     = $request->$datos_turno;
                $carrera_1->paralelo     = $request->$datos_paralelo;
                $carrera_1->anio_vigente = $request->$datos_gestion;
                $carrera_1->sexo         = $request->sexo;
                $carrera_1->save();

                $this->asignaturas_inscripcion($request->$datos_carrera, $request->$datos_turno, $persona_id, $request->$datos_paralelo, $request->$datos_gestion);
                DB::table('materias')->truncate();
            }
            
        }

        $fecha_reg = new \DateTime();//aqui obtenemos la fecha y hora actual
        $fecha_registro = $fecha_reg->format('Y-m-d');//obtenes solo el año actual

        $consulta_carreras = CarreraPersona::whereDate('created_at', $fecha_registro)
                ->where('persona_id', $persona_id)
                ->orderBy('carrera_id')
                ->get();


        $nro_mensualidades = 10;

        if ($consulta_carreras[0]->carrera_id == 1) {

            foreach ($consulta_carreras as $con_carreras) {
                
                if ($con_carreras->carrera_id == 1) {

                        $cobros_matricula = new CobrosTemporada();
                        $cobros_matricula->servicio_id    = 1;
                        $cobros_matricula->persona_id     = $persona_id;
                        $cobros_matricula->carrera_id     = $con_carreras->carrera_id;
                        $cobros_matricula->nombre         = 'MATRICULA';
                        $cobros_matricula->gestion        = $con_carreras->anio_vigente;
                        $cobros_matricula->nombre_combo   = 1;
                        $cobros_matricula->estado         = 'Debe';
                        $cobros_matricula->save();

                            for ($i=1; $i <= $nro_mensualidades ; $i++) { 
                                $cobros_mensualidades = new CobrosTemporada();
                                $cobros_mensualidades->servicio_id    = 2;
                                $cobros_mensualidades->persona_id     = $persona_id;
                                $cobros_mensualidades->carrera_id     = $con_carreras->carrera_id;
                                $cobros_mensualidades->nombre         = 'MENSUALIDAD';
                                $cobros_mensualidades->mensualidad    = $i;
                                $cobros_mensualidades->gestion        = $con_carreras->anio_vigente;
                                $cobros_mensualidades->nombre_combo   = 1;
                                $cobros_mensualidades->estado         = 'Debe';
                                $cobros_mensualidades->save();

                            } 
                } else {
                        
                        if ($con_carreras->carrera_id != 2 && $con_carreras->carrera_id != 3 ) {

                                $cobros_matricula = new CobrosTemporada();
                                $cobros_matricula->servicio_id    = 1;
                                $cobros_matricula->persona_id     = $persona_id;
                                $cobros_matricula->carrera_id     = $con_carreras->carrera_id;
                                $cobros_matricula->nombre         = 'MATRICULA';
                                $cobros_matricula->gestion        = $con_carreras->anio_vigente;
                                $cobros_matricula->estado         = 'Debe';
                                $cobros_matricula->save();


                                

                                    for ($i=1; $i <= $nro_mensualidades ; $i++) { 
                                        $cobros_mensualidades = new CobrosTemporada();
                                        $cobros_mensualidades->servicio_id    = 2;
                                        $cobros_mensualidades->persona_id     = $persona_id;
                                        $cobros_mensualidades->carrera_id     = $con_carreras->carrera_id;
                                        $cobros_mensualidades->nombre         = 'MENSUALIDAD';
                                        $cobros_mensualidades->mensualidad    = $i;
                                        $cobros_mensualidades->gestion        = $con_carreras->anio_vigente;
                                        $cobros_mensualidades->estado         = 'Debe';
                                        $cobros_mensualidades->save();

                                    } 
                                
                            }                    
                }
            }



        } else {
            foreach ($consulta_carreras as $con_carre) {
                
                $cobros_matricula = new CobrosTemporada();
                $cobros_matricula->servicio_id    = 1;
                $cobros_matricula->persona_id     = $persona_id;
                $cobros_matricula->carrera_id     = $con_carre->carrera_id;
                $cobros_matricula->nombre         = 'MATRICULA';
                $cobros_matricula->gestion        = $con_carre->anio_vigente;
                $cobros_matricula->estado         = 'Debe';
                $cobros_matricula->save();



                    for ($i=1; $i <= $nro_mensualidades ; $i++) { 
                        $cobros_mensualidades = new CobrosTemporada();
                        $cobros_mensualidades->servicio_id    = 2;
                        $cobros_mensualidades->persona_id     = $persona_id;
                        $cobros_mensualidades->carrera_id     = $con_carre->carrera_id;
                        $cobros_mensualidades->nombre         = 'MENSUALIDAD';
                        $cobros_mensualidades->mensualidad    = $i;
                        $cobros_mensualidades->gestion        = $con_carre->anio_vigente;
                        $cobros_mensualidades->estado         = 'Debe';
                        $cobros_mensualidades->save();

                    }

            }
        }

        // REGISTRA LAS ASIGNATURAS SUELTAS INSCRITAS
        foreach ($request->numero_asig as $asig) {
            $datos_asig = 'asignatura_'.$asig;
            $datos_turno_asig = 'turno_asig_'.$asig;
            $datos_paralelo_asig = 'paralelo_asig_'.$asig;
            $datos_gestion_asig = 'gestion_asig_'.$asig;

            if ($request->$datos_asig != 0) {

            $inscripcion_1 = new Inscripcion();
            $inscripcion_1->asignatura_id = $request->$datos_asig;
            $inscripcion_1->turno_id = $request->$datos_turno_asig;
            $inscripcion_1->persona_id = $persona_id;
            $inscripcion_1->paralelo = $request->$datos_paralelo_asig;
            $inscripcion_1->anio_vigente = $request->$datos_gestion_asig;
            $inscripcion_1->save();

            }

            $asignaturass = Asignatura::find($request->$datos_asig);
            $servicioss = Servicio::find($asignaturass->servicio_id);

            $cobros_matricula = new CobrosTemporada();
            $cobros_matricula->servicio_id    = $asignaturass->servicio_id;
            $cobros_matricula->persona_id     = $persona_id;
            $cobros_matricula->asignatura_id  = $request->$datos_asig;
            $cobros_matricula->nombre         = $servicioss->nombre;
            $cobros_matricula->gestion        = $request->$datos_gestion_asig;
            $cobros_matricula->estado         = 'Debe';
            $cobros_matricula->save();



        }
        return redirect('Kardex/detalle_estudiante/'.$persona_id);
    }

    public function asignaturas_inscripcion($carrera_id, $turno_id, $persona_id, $paralelo, $anio_vigente)
    {
        $asignaturas = DB::select("SELECT asig.id, asig.codigo_asignatura, asig.nombre_asignatura, prer.sigla, prer.prerequisito_id
                                    FROM asignaturas asig, prerequisitos prer
                                    WHERE asig.carrera_id = '$carrera_id'
                                    AND asig.anio_vigente = '$anio_vigente'
                                    AND asig.id = prer.asignatura_id
                                    ORDER BY asig.gestion, asig.orden_impresion");
        foreach ($asignaturas as $asig) {
            $inscripciones = DB::select("SELECT MAX(nota) as nota
                                            FROM inscripciones
                                            WHERE asignatura_id = '$asig->id'
                                            AND persona_id = '$persona_id'
                                            AND carrera_id = '$carrera_id'");

            if(!empty($inscripciones[0]->nota)){
               if ($inscripciones[0]->nota < 71) {
                   DB::table('materias')->insert([
                              'asignatura_id' => $asig->id,
                              'codigo_asignatura' => $asig->codigo_asignatura,
                              'nombre_asignatura' => $asig->nombre_asignatura,                              
                              'estado' => 1,
                            ]);
               }

            } else {

                if (!empty($asig->prerequisito_id)) {
                    $prerequisito = DB::select("SELECT MAX(nota) as nota
                                        FROM inscripciones
                                        WHERE asignatura_id = '$asig->prerequisito_id'
                                        AND persona_id = '$persona_id'
                                        AND carrera_id = '$carrera_id'");
                    if ($prerequisito[0]->nota > 70) {
                        DB::table('materias')->insert([
                              'asignatura_id' => $asig->id,
                              'codigo_asignatura' => $asig->codigo_asignatura,
                              'nombre_asignatura' => $asig->nombre_asignatura,                              
                              'estado' => 1,
                            ]);
                    }

                } else {
                    DB::table('materias')->insert([
                              'asignatura_id' => $asig->id,
                              'codigo_asignatura' => $asig->codigo_asignatura,
                              'nombre_asignatura' => $asig->nombre_asignatura,                              
                              'estado' => 1,
                            ]);
                }
            }
        }

        // en toda esta seccion verificamos si tienen mas de un prerequisitos y si los puede tomar
            $materia = DB::table('materias')
                 ->select('asignatura_id', DB::raw('count(asignatura_id) as nro'))
                 ->groupBy('asignatura_id')
                 ->get();
            foreach ($materia as $mate) {
                $id_asig = $mate->asignatura_id;
                $valor_mate = $mate->nro;

                $pre_requisitos = DB::table('prerequisitos')
                 ->select('asignatura_id', DB::raw('count(asignatura_id) as nro'))
                 ->where('asignatura_id','=',$id_asig)
                 ->groupBy('asignatura_id')
                 ->get();

                $valor_prer = $pre_requisitos[0]->nro;
                if ($valor_mate != $valor_prer) {
                    DB::table('materias')
                    ->where('asignatura_id','=',$id_asig)
                    ->delete();
                }
            }
        // aqui inscribimos las asignaturas que les corresponde
        $asig_tomar = DB::select("SELECT DISTINCT asignatura_id, codigo_asignatura, nombre_asignatura
                                    FROM materias");
            foreach ($asig_tomar as $asig_tomar1) {

                $asignatu = DB::table('asignaturas')
                ->select('id', 'gestion')
                ->where('id','=',$asig_tomar1->asignatura_id)
                ->where('anio_vigente','=',$anio_vigente)
                ->get();

                $inscripcion = new Inscripcion();
                $inscripcion->asignatura_id = $asig_tomar1->asignatura_id;
                $inscripcion->turno_id = $turno_id;
                $inscripcion->persona_id = $persona_id;
                $inscripcion->carrera_id = $carrera_id;
                $inscripcion->paralelo = $paralelo;
                $inscripcion->gestion = $asignatu[0]->gestion;
                $inscripcion->anio_vigente = $anio_vigente;
                $inscripcion->save();

                // en esta parte registramos la nota del alumno inscrito
                $notas_pro = NotasPropuesta::where('asignatura_id', $asig_tomar1->asignatura_id)
                                            ->where('turno_id', $turno_id)
                                            ->where('paralelo', $paralelo)
                                            ->where('anio_vigente', $anio_vigente)
                                            ->select('user_id')
                                            ->get();
                // dd($notas_pro[0]->user_id);
                if (!empty($notas_pro[0]->user_id)) {
                    for($i=1; $i<=4; $i++){
                        $nueva_nota = new Nota;
                        $nueva_nota->asignatura_id = $asig_tomar1->asignatura_id;
                        $nueva_nota->turno_id = $turno_id;
                        $nueva_nota->user_id = $notas_pro[0]->user_id;
                        $nueva_nota->persona_id = $persona_id;
                        $nueva_nota->paralelo = $paralelo;
                        $nueva_nota->anio_vigente = $anio_vigente;
                        $nueva_nota->trimestre = $i;
                        $nueva_nota->save();
                    }                        
                }
            }
    }

    public function busca_ci(Request $request)
    {
    	$carnet = $request->ci;//buscar el carnet de identidad de una persona
    	$persona_id = Persona::where("deleted_at", NULL)
                    ->where('carnet', $carnet)
                    ->get();
        if (!empty($persona_id[0]->id)) {
           $per = Persona::find($persona_id[0]->id);
            return response()->json([
                'mensaje' => 'si',
                'persona' => $per]);
        } else {
        return response()->json([
                'mensaje' => 'no'
            ]);
        }
    }


    public function ver_persona($persona_id = null)
    {
    	$fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
		$year = $fecha->format('Y');//obtenes solo el año actual

        $datosPersonales = Persona::where('deleted_at', NULL)
                        ->where('id', $persona_id)
                        ->first();

        $carrerasPersona = CarreraPersona::where('deleted_at', NULL)
                        ->where('persona_id', $persona_id)
                        ->get();
        $inscripciones = CarreraPersona::where('deleted_at', NULL)
                        ->where('persona_id', $persona_id)
                        ->get();
        $carreras = Carrera::where('deleted_at',NULL)->get();

        $turnos = Turno::where('deleted_at', NULL)
                        ->get();

        return view('inscripcion.detalle')->with(compact('datosPersonales', 'carrerasPersona', 'inscripciones', 'carreras', 'turnos', 'year'));

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
  //       $turnos = Turno::where('deleted_at', NULL)->get();
		
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

		$carreras = CarreraPersona::where("deleted_at", NULL)
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

    	$carreras = Carrera::where('deleted_at',NULL)->get();
        $turnos = Turno::where('deleted_at', NULL)->get();

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