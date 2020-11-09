<?php

namespace App\Http\Controllers;

use DB;
use App\Nota;
use App\User;
use App\Persona;
use App\Asignatura;
use Illuminate\Http\Request;

class MigracionController extends Controller
{
    public function persona()
    {
		// $alum_nuevo = DB::select('SELECT * FROM alumno_nuevo');
		$alumnos = DB::table('alumno_nuevo')->get();
        foreach ($alumnos as $a) {
			// modificamos para las ciudades
			$primeraLetra = $a->ciu_a;
			if($primeraLetra[0] == "L" || $primeraLetra[0] == "l"){
				$ciudad = "La Paz";
			}elseif($primeraLetra[0] == "B"){
				$ciudad = "Beni";
			}elseif($primeraLetra[0] == "C"){
				$ciudad = "Cochabamba";
			}elseif($primeraLetra[0] == "O"){
				$ciudad = "Oruro";
			}elseif($primeraLetra[0] == "P"){
				$ciudad = "Potosi";
			}elseif($primeraLetra[0] == "S"){
				$ciudad = "Santa Cruz";
			}elseif($primeraLetra[0] == "T"){
				$ciudad = "Tarija";
			}elseif($primeraLetra[0] == null){
				$ciudad = "La Paz";
			}
			// fin modificamos para las ciudades

			// para el genero
			$sexoPersona = $a->sexo;
			if($sexoPersona == "F"){
				$genero = "Femenino";
			}elseif($sexoPersona == "M"){
				$genero = "Masculino";
			}elseif($sexoPersona == ""){
				$genero = null;
			}

			// para trabaja
			$trabajaPersona = $a->trabaja;
			if($trabajaPersona == "S"){
				$chambea = "Si";
			}elseif($trabajaPersona == "N"){
				$chambea = "No";
			}elseif($trabajaPersona == "Y"){
				$chambea = "Si";
			}elseif($trabajaPersona == ""){
				$chambea = "No";
			}

			// fecha nacimiento
			$fechaNacimiento = $a->fec_nac;
			if($fechaNacimiento == "0000-00-00"){
				$fechaN = null;
			}else{
				$fechaN = $a->fec_nac;
			}

			echo $a->alumnoID." - ".$a->nombres." - ".$ciudad." - ".$genero."<br />";
        	DB::table('personas')->insert([
            'codigo_anterior'      => $a->alumnoID,
            'user_id'              => 1,
            'apellido_paterno'     => $a->a_paterno,
            'apellido_materno'     => $a->a_materno,
            'nombres'              => $a->nombres,
            'cedula'               => $a->carnetIDA,
            'expedido'             => $ciudad,
            'fecha_nacimiento'     => $fechaN,
            'sexo'                 => $genero,
            'direccion'            => $a->direc_a,
            'numero_fijo'          => $a->telf_fijo,
            'numero_celular'       => $a->telf_cel,
            'email'                => $a->email,
            'trabaja'              => $chambea,
            'empresa'              => $a->empresa,
            'direccion_empresa'    => $a->direc_emp,
            'numero_empresa'       => $a->telf_emp,
            'fax'                  => $a->fax,
            'email_empresa'        => $a->email_emp,
            'nombre_padre'         => $a->nomb_pa,
            'celular_padre'        => $a->tel_pa,
            'nombre_madre'         => $a->nom_ma,
            'celular_madre'        => $a->tel_ma,
            'nombre_tutor'         => $a->nom_tut,
            'celular_tutor'        => $a->tel_tut,
            'nombre_pareja'        => $a->nom_esp,
            'celular_pareja'       => $a->tel_esp,
            'nit'                  => $a->nit,
            'razon_social_cliente' => $a->raz_cli
        	]);
		}
		dd($alumnos);
    }

    public function usuario()
    {

        $docente = DB::select('SELECT doc.*, com.*
								FROM docentes doc, docentes_complemento com
								WHERE doc.docenID = com.docenID');
        //dd($docente);
        foreach ($docente as $valor) {
        	 DB::table('usuarios')->insert([
            'codigo_anterior' => $valor->docenID,
			'apellido_paterno' => $valor->a_paterno,
			'apellido_materno' => $valor->a_materno,
			'nombres' => $valor->nombres,
			'nomina' => $valor->nomi,
			'password' => $valor->codID,
			'cedula' => $valor->carnet,
			'expedido' => $valor->ciu_d,
			'tipo_usuario' => $valor->tipo_usu,
			'nombre_usuario' => $valor->nom_usua,
			'fecha_incorporacion' => $valor->fec_incor,
			'vigente' => $valor->vig,
			'rol' => $valor->rol,
			'fecha_nacimiento' => $valor->fec_nac,
			'lugar_nacimiento' => $valor->lug_nac,
			'sexo' => $valor->sexo,
			'estado_civil' => $valor->est_civil,
			'nombre_conyugue' => $valor->nom_cony,
			'nombre_hijo' => $valor->nom_hijo,
			'direccion' => $valor->direcc_doc,
			'zona' => $valor->zona,
			'numero_celular' => $valor->num_cel,
			'numero_fijo' => $valor->num_fijo,
			'email' => $valor->email_d,
			'foto' => $valor->foto,
			'persona_referencia' => $valor->p_referencia,
			'numero_referencia' => $valor->f_referencia,
        	]);
        }

    }

    public function docentes()
    {
    	$docentes = DB::table('docentes')->get();

        foreach ($docentes as $valor) {

			// fecha de fecha_incorporacion
			$fechaIncorporacion = $valor->fec_incor;
			if($fechaIncorporacion == "0000-00-00"){
				$fechaN = null;
			}else{
				$fechaN = $valor->fec_incor;
			}

        	DB::table('users')->insert([
            'codigo_anterior' => $valor->docenID,
            'perfil_id' => 2,
			'apellido_paterno' => $valor->a_paterno,
			'apellido_materno' => $valor->a_materno,
			'nombres' => $valor->nombres,
			'nomina' => $valor->nomi,
			'password' => 123456789,
			'cedula' => $valor->carnet,
			'expedido' => "La Paz",
			'tipo_usuario' => "Docente",
			'nombre_usuario' => $valor->nom_usua,
			'fecha_incorporacion' => $fechaN,
			'vigente' => $valor->vig,
			'rol' => $valor->rol,
        	]);
        }

    	dd($docentes);	
    }

    public function asignatura()
    {
        $asignaturas = DB::select('SELECT * FROM asignaturas_anterior');
        // dd($asignaturas);
        foreach ($asignaturas as $valor) {
        	DB::table('asignaturas')->insert([
            'codigo_anterior'       => $valor->asignaturaID,
            'user_id'               => 1,
            'carrera_id'            => $valor->carreraID,
            'gestion'               => $valor->gestion,
            'sigla'                 => $valor->cod_asig,
            'nombre'                => $valor->asignatura,
            'troncal'               => "Si",
            'ciclo'                 => "Anual",
            'semestre'              => $valor->semes,
            'carga_horaria_virtual' => 80,
            'carga_horaria'         => $valor->carga_horaria,
            'teorico'               => $valor->teorico,
            'practico'              => $valor->practico,
            'nivel'                 => $valor->nivel,
            'periodo'               => $valor->periodo,
            'anio_vigente'          => $valor->anio_vigen,
            'orden_impresion'       => $valor->ord_imp,
        	]);

        echo $valor->asignaturaID."<br />";
        }
    }

    public function asignaturas_prerequisitos()
    {
		$asignaturas = DB::table('asignaturas')->get();
		foreach ($asignaturas as $a) {
			echo $a->nombre."<br />";
			DB::table('prerequisitos')->insert([
				'user_id'=>1,
				'asignatura_id'=>$a->id,
				'anio_vigente'=>$a->anio_vigente
			]);
		}
		// dd($asignaturas);
    	// $asignaturasAnterior = DB::table('asignaturas_anterior')->where('asignaturaID', 2133)->first();
    	// dd($asignaturasAnterior);

    	/*$asignaturasArray = [];
        $gestiones = DB::select("
        	select anio_vigente
			from asignaturas
			group by anio_vigente;");
        foreach ($gestiones as $g) {
        	$asignaturas = DB::select("select * from asignaturas where anio_vigente = '$g->anio_vigente'");
        	echo $g->anio_vigente. "<br />";
        	foreach ($asignaturas as $a) {
	        	// $asignaturasAnterior = DB::select("select * from asignaturas_anterior where asignaturaID = '$a->codigo_anterior'")->first();
	        	$asignaturasAnterior = DB::table('asignaturas_anterior')->where('asignaturaID', $a->codigo_anterior)->first();
	        	echo $a->nombre. "<br />";
	        	if($asignaturasAnterior->pre_req != null || $asignaturasAnterior->pre_req != 'NINGUNO' || $asignaturasAnterior->pre_req != ""){
	        		echo 'tiene';
	        	}

        	}
        }
        dd($asignaturas);*/


    }

    public function datosKardex()
    {
    	$kardex = DB::table('datos_kardex')
    				// ->where('anio_act', 2015)
    				->get();

    	foreach($kardex as $k){

    		// fecha nacimiento
    		$fechaInscripcion = $k->fecha_ins;
    		if($fechaInscripcion == "0000-00-00"){
    			$fechaN = null;
    		}else{
    			$fechaN = $k->fecha_ins;
    		}

    		$datosPersona = DB::table('personas')
    						->where('cedula', $k->carnetIDA)
    						->first();

    		if($datosPersona != null){

    			echo $datosPersona->cedula."-".$fechaN."<br />";

    			DB::table('carreras_personas')->insert([
    				'codigo_anterior'=>$k->kardexID,
    				'user_id'=>1,
    				'carrera_id'=>$k->carreraID,
    				'persona_id'=>$datosPersona->id,
    				'turno_id'=>$k->turnoID,
    				'fecha_inscripcion'=>$fechaN,
    				'anio_vigente'=>$k->anio_act,
    			]);

    		}
    		// dd($datosPersona);
    	}
    	dd($kardex);
    }

    public function notas()
    {

        // para la gestion 2015
		$notas = DB::table('reg_notas')
				->whereNull('nota')
    			->whereYear('fec_reg', 2015)
				->get();
		// dd($notas);

		foreach($notas as $key => $n)
		{
			$alumno = Persona::where('cedula', $n->carnetID)->first();
            
			$docente = User::where('codigo_anterior', $n->docenID)->first();
			$asignatura = Asignatura::where('codigo_anterior', $n->asignaturaID)->first();
			echo $key." - ".$n->regID." - ".$n->carnetID." - ".$alumno->cedula."<br />";
			$notaFinal = $n->asist_a+$n->trab_a+$n->p_ganados+$n->p_parcial+$n->e_final;

			if($n->trim == 1)
			{
                if($alumno && $docente && $asignatura)
                {
                    $notas                      = new Nota();
                    $notas->codigo_anterior     = $n->regID;
                    $notas->user_id             = 1;
                    $notas->resolucion_id       = 1;
                    $notas->docente_id          = $docente->id;
                    $notas->asignatura_id       = $asignatura->id;
                    $notas->turno_id            = $n->turn;
                    $notas->anio_vigente        = 2015;
                    $notas->trimestre           = $n->trim;
                    $notas->fecha_registro      = $n->fec_reg;
                    $notas->nota_asistencia     = $n->asist_a;
                    $notas->nota_practicas      = $n->trab_a;
                    $notas->nota_puntos_ganados = $n->p_ganados;
                    $notas->nota_primer_parcial = $n->p_parcial;
                    $notas->nota_examen_final   = $n->e_final;
                    $notas->nota_total          = $notaFinal;
                    $notas->nota_aprobacion     = 61;
                    $notas->save();

                    $notas                      = new Nota();
                    $notas->codigo_anterior     = $n->regID;
                    $notas->user_id             = 1;
                    $notas->resolucion_id       = 1;
                    $notas->docente_id          = $docente->id;
                    $notas->asignatura_id       = $asignatura->id;
                    $notas->turno_id            = $n->turn;
                    $notas->anio_vigente        = 2015;
                    $notas->trimestre           = $n->trim+2;
                    $notas->fecha_registro      = $n->fec_reg;
                    $notas->nota_asistencia     = $n->asist_a;
                    $notas->nota_practicas      = $n->trab_a;
                    $notas->nota_puntos_ganados = $n->p_ganados;
                    $notas->nota_primer_parcial = $n->p_parcial;
                    $notas->nota_examen_final   = $n->e_final;
                    $notas->nota_total          = $notaFinal;
                    $notas->nota_aprobacion     = 61;
                    $notas->save();
    			}
    		}else{
                $notas                      = new Nota();
                $notas->codigo_anterior     = $n->regID;
                $notas->user_id             = 1;
                $notas->resolucion_id       = 1;
                $notas->docente_id          = $docente->id;
                $notas->asignatura_id       = $asignatura->id;
                $notas->turno_id            = $n->turn;
                $notas->anio_vigente        = 2015;
                $notas->trimestre           = $n->trim;
                $notas->fecha_registro      = $n->fec_reg;
                $notas->nota_asistencia     = $n->asist_a;
                $notas->nota_practicas      = $n->trab_a;
                $notas->nota_puntos_ganados = $n->p_ganados;
                $notas->nota_primer_parcial = $n->p_parcial;
                $notas->nota_examen_final   = $n->e_final;
                $notas->nota_total          = $notaFinal;
                $notas->nota_aprobacion     = 61;
                $notas->save();

                $notas                      = new Nota();
                $notas->codigo_anterior     = $n->regID;
                $notas->user_id             = 1;
                $notas->resolucion_id       = 1;
                $notas->docente_id          = $docente->id;
                $notas->asignatura_id       = $asignatura->id;
                $notas->turno_id            = $n->turn;
                $notas->anio_vigente        = 2015;
                $notas->trimestre           = $n->trim+2;
                $notas->fecha_registro      = $n->fec_reg;
                $notas->nota_asistencia     = $n->asist_a;
                $notas->nota_practicas      = $n->trab_a;
                $notas->nota_puntos_ganados = $n->p_ganados;
                $notas->nota_primer_parcial = $n->p_parcial;
                $notas->nota_examen_final   = $n->e_final;
                $notas->nota_total          = $notaFinal;
                $notas->nota_aprobacion     = 61;
                $notas->save();
            }
    	}
    	//saco todas las notas totales de la gestion
/*    	$notas = DB::select("
    		SELECT
    		  carnetID,
    		  asignaturaID,
    		  AVG(asist_a + trab_a + p_parcial + e_final + p_ganados) AS total
    		FROM reg_notas
    		WHERE gestionn = 1
    		AND YEAR(fec_reg) = 2019
    		GROUP BY carnetID, asignaturaID;
    		");
    	foreach($notas as $n)
    	{
    		// echo $n->regID." - ".$n->asignaturaID." - ".$n->regID;
    	}
		dd($notas);

    	// 8360693  2017
    	// 9094729  2017
    	// 13643259 2019   4
    	// 4745132  2019
    	// 9126591  2019
    	
/*    	foreach ($notas as $n) {

    		DB::table('notas')->insert([
    			'codigo_anterior'=>$n->regID,
    			'user_id'=>1,
    			'resolucion_id'=>1,
    			'persona_id'=>$datosPersona->id,
    			'turno_id'=>$k->turnoID,
    			'fecha_inscripcion'=>$fechaN,
    			'anio_vigente'=>$k->anio_act,
    		]);		
		}	
*/
    }
}
