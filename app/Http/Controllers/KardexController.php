<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inscripcion;
use App\Carrera;
use App\Asignatura;
use App\Turno;
use App\Persona;
use App\Kardex;
use App\Nota;
use App\Materia;
use App\CarreraPersona;
use App\NotasPropuesta;
use App\Prerequisito;
use DB;

class KardexController extends Controller
{
    public function detalle_estudiante($persona_id = null)
    {
        // $persona_id = 3185;
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
        return view('kardex.detalle_estudiante')->with(compact('datosPersonales', 'carrerasPersona', 'inscripciones', 'carreras', 'turnos', 'year'));   
    }

    public function ajax_datos_principales(Request $request)
    {
    	$ci = $request->tipo;
        $datosPersonales = Persona::where('borrado', NULL)
                        ->where('carnet', $ci)
                        ->first();
        return view('kardex.datos_principales')->with(compact('datosPersonales'));
    }

    public function guardar_datosPrincipales(Request $request){
    	$persona = Persona::find($request->tipo_persona_id);
        $persona->carnet = $request->tipo_carnet;
        $persona->expedido = $request->tipo_expedido;
        $persona->apellido_paterno = $request->tipo_apellido_paterno;
        $persona->apellido_materno = $request->tipo_apellido_materno;
        $persona->nombres = $request->tipo_nombres;
        $persona->fecha_nacimiento = $request->tipo_fecha_nacimiento;
        $persona->email = $request->tipo_email;
        $persona->direccion = $request->tipo_direccion;
        $persona->telefono_celular = $request->tipo_telefono_celular;
        $persona->sexo = $request->tipo_sexo;
        $persona->save();

        $datosPersonales = Persona::where('borrado', NULL)
                        ->where('id', $request->tipo_persona_id)
                        ->first();
        return view('kardex.datos_principales')->with(compact('datosPersonales'));
    }

    public function ajax_datos_adicionales(Request $request)
    {
    	$ci = $request->tipo;
        $datosPersonales = Persona::where('borrado', NULL)
                        ->where('carnet', $ci)
                        ->first();
        return view('kardex.datos_adicionales')->with(compact('datosPersonales'));
    }

    public function guardar_datosAdicionales(Request $request){
    	$persona = Persona::find($request->tipo_persona_id);
        $persona->trabaja = $request->tipo_trabaja;
        $persona->empresa = $request->tipo_empresa;
        $persona->direccion_empresa = $request->tipo_direccion_empresa;
        $persona->telefono_empresa = $request->tipo_telefono_empresa;
        $persona->fax = $request->tipo_fax;
        $persona->email_empresa = $request->tipo_email_empresa;
        $persona->nombre_padre = $request->tipo_nombre_padre;
        $persona->celular_padre = $request->tipo_celular_padre;
        $persona->nombre_madre = $request->tipo_nombre_madre;
        $persona->celular_madre = $request->tipo_celular_madre;
        $persona->nombre_tutor = $request->tipo_nombre_tutor;
        $persona->telefono_tutor = $request->tipo_telefono_tutor;
        $persona->nombre_esposo = $request->tipo_nombre_esposo;
        $persona->telefono_esposo = $request->tipo_telefono_esposo;
        $persona->save();

        $datosPersonales = Persona::where('borrado', NULL)
                        ->where('id', $request->tipo_persona_id)
                        ->first();
        return view('kardex.datos_adicionales')->with(compact('datosPersonales'));
    }

    public function ajax_datos_carreras(Request $request)
    {
    	$ci = $request->tipo;
    	$carreras = Carrera::where('borrado',NULL)->get();

        $turnos = Turno::where('borrado', NULL)
                        ->get();

    	$datosPersonales = Persona::where('borrado', NULL)
                        ->where('carnet', $ci)
                        ->first();
        $carrerasPersona = CarreraPersona::where('borrado', NULL)
                        ->where('persona_id', $datosPersonales->id)
                        ->distinct()
                        ->get('carrera_id');
        return view('kardex.datos_carreras')->with(compact('carrerasPersona', 'datosPersonales', 'carreras', 'turnos'));
    }

    public function guardar_datosCarreras(Request $request){
    	$carreras_persona = CarreraPersona::where('borrado', NULL)
                        ->where('carrera_id', $request->tipo_carrera_id)
                        ->where('persona_id', $request->tipo_persona_id)
                        ->first();
        if (!empty($carreras_persona)) {

        	return response()->json(['mensaje'=>'si']);

        } else {
        	$carrera = new CarreraPersona();
	        $carrera->carrera_id   = $request->tipo_carrera_id;
	        $carrera->persona_id   = $request->tipo_persona_id;
	        $carrera->turno_id     = $request->tipo_turno_id;
	        $carrera->paralelo     = $request->tipo_paralelo;
	        $carrera->anio_vigente = $request->tipo_gestion;
	        $carrera->sexo         = $request->tipo_persona_sexo;
	        $carrera->save();

	        $carreras = Carrera::where('borrado',NULL)->get();

	        $turnos = Turno::where('borrado', NULL)
	                        ->get();

	    	$datosPersonales = Persona::where('borrado', NULL)
	                        ->where('id', $request->tipo_persona_id)
	                        ->first();
	        $carrerasPersona = CarreraPersona::where('borrado', NULL)
	                        ->where('persona_id', $datosPersonales->id)
	                        ->distinct()
	                        ->get('carrera_id');
            $this->asignaturas_inscripcion($request->tipo_carrera_id, $request->tipo_turno_id, $request->tipo_persona_id, $request->tipo_paralelo, $request->tipo_gestion);

            DB::table('materias')->truncate();

	        return view('kardex.datos_carreras')->with(compact('carrerasPersona', 'datosPersonales', 'carreras', 'turnos'));
        }

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

        $this->inscripcion_asig_notas($carrera_id, $turno_id, $persona_id, $paralelo, $anio_vigente);
      
    }

    public function inscripcion_asig_notas($carrera_id, $turno_id, $persona_id, $paralelo, $anio_vigente){
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

    public function ajax_datos_reinscripcion(Request $request)
    {
        DB::table('materias')->truncate();
        $carrera_id = $request->tipo_carrera_id;
        $persona_id = $request->tipo_persona_id;
        $sexo = $request->tipo_sexo;
        $turnos = Turno::where('borrado', NULL)
                        ->get();

        return view('kardex.datos_reinscripcion')->with(compact('turnos', 'carrera_id', 'persona_id', 'sexo'));
    }

    public function ajax_datos_asig_tomar(Request $request)
    {
        $turno_id = $request->tipo_turno_id;
        $paralelo = $request->tipo_paralelo;
        $anio_vigente = $request->tipo_gestion;
        $carrera_id = $request->tipo_carrera_id;
        $persona_id = $request->tipo_persona_id;

        //desde aqui hace la verificacion de las asignaturas
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

        $asig_tomar = DB::select("SELECT DISTINCT asignatura_id, codigo_asignatura, nombre_asignatura
                                    FROM materias");
        //hasta aqui
        DB::table('materias')->truncate();

        $turnos = Turno::where('borrado', NULL)
                        ->get();

        return view('kardex.datos_asig_tomar')->with(compact('turno_id', 'paralelo', 'turnos', 'asig_tomar', 'anio_vigente', 'carrera_id', 'persona_id'));
    }

     public function guarda_reinscripcion(Request $request)
    {
        $persona = Persona::find($request->persona_id);
        $carrera = new CarreraPersona();
            $carrera->carrera_id   = $request->carrera_id;
            $carrera->persona_id   = $request->persona_id;
            $carrera->turno_id     = $request->turno_id;
            $carrera->paralelo     = $request->paralelo;
            $carrera->anio_vigente = $request->anio_vigente;
            $carrera->sexo         = $persona->sexo;
            $carrera->save();

        // $nro = sizeof($request->producto_id);
        foreach ($request->asignatura_id as $key => $valor) {
            
            $asignatu = DB::table('asignaturas')
                    ->select('id', 'gestion')
                    ->where('id','=',$request->asignatura_id[$key])
                    ->where('anio_vigente','=',$request->anio_vigente)
                    ->get();

                $inscripcion = new Inscripcion();
                $inscripcion->asignatura_id = $request->asignatura_id[$key];
                $inscripcion->turno_id = $request->re_asig_turno[$key];
                $inscripcion->persona_id = $request->persona_id;
                $inscripcion->carrera_id = $request->carrera_id;
                $inscripcion->paralelo = $request->re_asig_paralelo[$key];
                $inscripcion->gestion = $asignatu[0]->gestion;
                $inscripcion->anio_vigente = $request->anio_vigente;
                $inscripcion->save();

                // en esta parte registramos la nota del alumno inscrito
                $notas_pro = NotasPropuesta::where('asignatura_id', $request->asignatura_id[$key])
                                            ->where('turno_id', $request->re_asig_turno[$key])
                                            ->where('paralelo', $request->re_asig_paralelo[$key])
                                            ->where('anio_vigente', $request->anio_vigente)
                                            ->select('user_id')
                                            ->get();
                // dd($notas_pro[0]->user_id);
                if (!empty($notas_pro[0]->user_id)) {
                    for($i=1; $i<=4; $i++){
                        $nueva_nota = new Nota;
                        $nueva_nota->asignatura_id = $request->asignatura_id[$key];
                        $nueva_nota->turno_id = $request->re_asig_turno[$key];
                        $nueva_nota->user_id = $notas_pro[0]->user_id;
                        $nueva_nota->persona_id = $request->persona_id;
                        $nueva_nota->paralelo = $request->re_asig_paralelo[$key];
                        $nueva_nota->anio_vigente = $request->anio_vigente;
                        $nueva_nota->trimestre = $i;
                        $nueva_nota->save();
                    }
                }
        }

        return redirect('Kardex/detalle_estudiante/'.$request->persona_id);
    }

    public function ajax_datos_notas_carreras(Request $request)
    {
        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
        $fecha_actual = $fecha->format('Y-m-d');//obtenes la fecha actual
        $mes = $fecha->format('m');//obtenes la fecha actual
        $anio = $fecha->format('Y');//obtenes la fecha actual

        $carrera_id = $request->tipo_carrera_id;
        $persona_id = $request->tipo_persona_id;
        // dd($inscripciones);
        $inscripciones = DB::select("SELECT insc.*
                    FROM inscripciones insc, (SELECT MAX(id) as id
                                                                        FROM inscripciones 
                                                                        WHERE anio_vigente = '$anio'
                                                                        AND carrera_id = '$carrera_id'
                                                                        AND persona_id = '$persona_id'
                                                                        GROUP BY asignatura_id)tmp
                    WHERE insc.id = tmp.id
                    ORDER BY insc.id ASC");

        // $inscripciones = Inscripcion::where('persona_id', $persona_id)
        //             ->where('carrera_id', $carrera_id)
        //             ->where('anio_vigente', $anio)
        //             ->orderBy('id', 'ASC')
        //             ->groupBy('asignatura_id')
        //             ->get(['asignatura_id', DB::raw('MAX(id) as id')]);
        // dd($inscripciones);

        return view('kardex.datos_notas_carreras')->with(compact('inscripciones'));
        
    }
}
