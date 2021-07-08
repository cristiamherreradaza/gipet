<?php

namespace App\Http\Controllers;

use DB;
use App\Nota;
use App\User;
use App\Persona;
use App\Inscritos;
use App\Asignatura;
use App\Inscripcione;
use App\NotasPropuesta;
use App\CarrerasPersona;
use App\Imports\PagosImport;
use App\Imports\InscritosImport;
use App\Imports\InscripcionesImport;
use Maatwebsite\Excel\Facades\Excel;


class MigracionController extends Controller
{
    public function persona()
    {
        // $alum_nuevo = DB::select('SELECT * FROM alumno_nuevo');
        $alumnos = DB::table('alumno_nuevo')->get();
        foreach ($alumnos as $a) {
            // modificamos para las ciudades
            $primeraLetra = $a->ciu_a;
            if ($primeraLetra[0] == "L" || $primeraLetra[0] == "l") {
                $ciudad = "La Paz";
            } elseif ($primeraLetra[0] == "B") {
                $ciudad = "Beni";
            } elseif ($primeraLetra[0] == "C") {
                $ciudad = "Cochabamba";
            } elseif ($primeraLetra[0] == "O") {
                $ciudad = "Oruro";
            } elseif ($primeraLetra[0] == "P") {
                $ciudad = "Potosi";
            } elseif ($primeraLetra[0] == "S") {
                $ciudad = "Santa Cruz";
            } elseif ($primeraLetra[0] == "T") {
                $ciudad = "Tarija";
            } elseif ($primeraLetra[0] == null) {
                $ciudad = "La Paz";
            }
            // fin modificamos para las ciudades

            // para el genero
            $sexoPersona = $a->sexo;
            if ($sexoPersona == "F") {
                $genero = "Femenino";
            } elseif ($sexoPersona == "M") {
                $genero = "Masculino";
            } elseif ($sexoPersona == "") {
                $genero = null;
            }

            // para trabaja
            $trabajaPersona = $a->trabaja;
            if ($trabajaPersona == "S") {
                $chambea = "Si";
            } elseif ($trabajaPersona == "N") {
                $chambea = "No";
            } elseif ($trabajaPersona == "Y") {
                $chambea = "Si";
            } elseif ($trabajaPersona == "") {
                $chambea = "No";
            }

            // fecha nacimiento
            $fechaNacimiento = $a->fec_nac;
            if ($fechaNacimiento == "0000-00-00") {
                $fechaN = null;
            } else {
                $fechaN = $a->fec_nac;
            }

            echo $a->alumnoID . " - " . $a->nombres . " - " . $ciudad . " - " . $genero . "<br />";
            DB::table('personas')->insert([
                'codigo_anterior' => $a->alumnoID,
                'user_id' => 1,
                'apellido_paterno' => $a->a_paterno,
                'apellido_materno' => $a->a_materno,
                'nombres' => $a->nombres,
                'cedula' => $a->carnetIDA,
                'expedido' => $ciudad,
                'fecha_nacimiento' => $fechaN,
                'sexo' => $genero,
                'direccion' => $a->direc_a,
                'numero_fijo' => $a->telf_fijo,
                'numero_celular' => $a->telf_cel,
                'email' => $a->email,
                'trabaja' => $chambea,
                'empresa' => $a->empresa,
                'direccion_empresa' => $a->direc_emp,
                'numero_empresa' => $a->telf_emp,
                'fax' => $a->fax,
                'email_empresa' => $a->email_emp,
                'nombre_padre' => $a->nomb_pa,
                'celular_padre' => $a->tel_pa,
                'nombre_madre' => $a->nom_ma,
                'celular_madre' => $a->tel_ma,
                'nombre_tutor' => $a->nom_tut,
                'celular_tutor' => $a->tel_tut,
                'nombre_pareja' => $a->nom_esp,
                'celular_pareja' => $a->tel_esp,
                'nit' => $a->nit,
                'razon_social_cliente' => $a->raz_cli,
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
            if ($fechaIncorporacion == "0000-00-00") {
                $fechaN = null;
            } else {
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
                'codigo_anterior' => $valor->asignaturaID,
                'user_id' => 1,
                'carrera_id' => $valor->carreraID,
                'gestion' => $valor->gestion,
                'sigla' => $valor->cod_asig,
                'nombre' => $valor->asignatura,
                'troncal' => "Si",
                'ciclo' => "Anual",
                'semestre' => $valor->semes,
                'carga_horaria_virtual' => 80,
                'carga_horaria' => $valor->carga_horaria,
                'teorico' => $valor->teorico,
                'practico' => $valor->practico,
                'nivel' => $valor->nivel,
                'periodo' => $valor->periodo,
                'anio_vigente' => $valor->anio_vigen,
                'orden_impresion' => $valor->ord_imp,
            ]);

            echo $valor->asignaturaID . "<br />";
        }
    }

    public function asignaturas_prerequisitos()
    {
        $asignaturas = DB::table('asignaturas')->get();
        foreach ($asignaturas as $a) {
            echo $a->nombre . "<br />";
            DB::table('prerequisitos')->insert([
                'user_id' => 1,
                'asignatura_id' => $a->id,
                'anio_vigente' => $a->anio_vigente,
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

    // funcion para migrar de datos kardex
    // a carreras personas
    public function datosKardex()
    {
        // columna paralelo
        // N = A
        // PA = B
        // PB = C

        // columna vigen
        // V = Vigente
        // A = Abandonos
        // S = Temporal
        //  = Todos

        // en gestion va lo de gestionk
        // en vigiencia lo de vig
        $kardex = DB::table('datos_kardex')
        // ->where('anio_act', 2015)
            ->get();

        foreach ($kardex as $k) {

            // fecha nacimiento
            $fechaInscripcion = $k->fecha_ins;
            if ($fechaInscripcion == "0000-00-00") {
                $fechaN = null;
            } else {
                $fechaN = $k->fecha_ins;
            }

            if ($k->vigen == "V") {
                $vigenciaAlumno = 'Vigente';
            } elseif ($k->vigen == 'A') {
                $vigenciaAlumno = 'Abandono';
            } elseif ($k->vigen == 'S') {
                $vigenciaAlumno = 'Temporal';
            }

            if ($k->a_paralelo == 'N') {
                $paraleloAlumno = "A";
            } elseif ($k->a_paralelo == 'PA') {
                $paraleloAlumno = "B";
            } elseif ($k->a_paralelo == 'PB') {
                $paraleloAlumno = "C";

            }

            $datosPersona = DB::table('personas')
                ->where('cedula', $k->carnetIDA)
                ->first();

            echo $k->kardexID . " - " . $k->carnetIDA . "<br />";

            if ($datosPersona != null) {

                echo $datosPersona->cedula . "-" . $fechaN . "<br />";

                DB::table('carreras_personas')->insert([
                    'codigo_anterior' => $k->kardexID,
                    'user_id' => 1,
                    'carrera_id' => $k->carreraID,
                    'persona_id' => $datosPersona->id,
                    'turno_id' => $k->turnoID,
                    'paralelo' => $paraleloAlumno,
                    'fecha_inscripcion' => $fechaN,
                    'anio_vigente' => $k->anio_act,
                    'gestion' => $k->gestionk,
                    'vigencia' => $vigenciaAlumno,
                    'estado' => $k->observacion,
                ]);

            }
            // dd($datosPersona);
        }
        // dd($kardex);
    }

    // para las gestion es 2015 - 2018 este es el oficial
    public function notas()
    {
        $gestion = 2012;
        // para la gestion 2015
        $notas = DB::table('reg_notas')
            ->whereNull('nota')
            ->where('gestion', $gestion)
            ->get();
        // dd($notas);0

        foreach ($notas as $key => $n) {
            $alumno = Persona::where('cedula', $n->carnetID)->first();
            $docente = User::where('codigo_anterior', $n->docenID)->first();
            $asignatura = Asignatura::where('codigo_anterior', $n->asignaturaID)->first();
            if ($alumno && $docente && $asignatura) {
                // echo $key." - ".$n->regID." - ".$n->carnetID." - ".$alumno->cedula." - ".$alumno->id." - ".$asignatura->id."<br />";
                echo $key . " - " . $n->regID . " - " . $n->carnetID . " - " . $alumno->cedula . "<br />";
            }
            $notaFinal = $n->asist_a + $n->trab_a + $n->p_ganados + $n->p_parcial + $n->e_final;

            if ($n->trim == 1) {
                if ($alumno && $docente && $asignatura) {
                    $notas = new Nota();
                    $notas->codigo_anterior = $n->regID;
                    $notas->user_id = 36;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $docente->id;
                    $notas->persona_id = $alumno->id;
                    $notas->asignatura_id = $asignatura->id;
                    $notas->turno_id = $n->turn;
                    $notas->anio_vigente = $gestion;
                    $notas->semestre = $n->semesn;
                    $notas->trimestre = $n->trim;
                    $notas->fecha_registro = $n->fec_reg;
                    $notas->nota_asistencia = $n->asist_a;
                    $notas->nota_practicas = $n->trab_a;
                    $notas->nota_puntos_ganados = $n->p_ganados;
                    $notas->nota_primer_parcial = $n->p_parcial;
                    $notas->nota_examen_final = $n->e_final;
                    $notas->nota_total = $notaFinal;
                    $notas->nota_aprobacion = 61;
                    $notas->save();

                    $notas = new Nota();
                    $notas->codigo_anterior = $n->regID;
                    $notas->user_id = 36;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $docente->id;
                    $notas->persona_id = $alumno->id;
                    $notas->asignatura_id = $asignatura->id;
                    $notas->turno_id = $n->turn;
                    $notas->anio_vigente = $gestion;
                    $notas->semestre = $n->semesn;
                    $notas->trimestre = $n->trim + 2;
                    $notas->fecha_registro = $n->fec_reg;
                    $notas->nota_asistencia = $n->asist_a;
                    $notas->nota_practicas = $n->trab_a;
                    $notas->nota_puntos_ganados = $n->p_ganados;
                    $notas->nota_primer_parcial = $n->p_parcial;
                    $notas->nota_examen_final = $n->e_final;
                    $notas->nota_total = $notaFinal;
                    $notas->nota_aprobacion = 61;
                    $notas->save();
                }
            } else {
                if ($alumno && $docente && $asignatura) {
                    $notas = new Nota();
                    $notas->codigo_anterior = $n->regID;
                    $notas->user_id = 36;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $docente->id;
                    $notas->persona_id = $alumno->id;
                    $notas->asignatura_id = $asignatura->id;
                    $notas->turno_id = $n->turn;
                    $notas->anio_vigente = $gestion;
                    $notas->semestre = $n->semesn;
                    $notas->trimestre = $n->trim;
                    $notas->fecha_registro = $n->fec_reg;
                    $notas->nota_asistencia = $n->asist_a;
                    $notas->nota_practicas = $n->trab_a;
                    $notas->nota_puntos_ganados = $n->p_ganados;
                    $notas->nota_primer_parcial = $n->p_parcial;
                    $notas->nota_examen_final = $n->e_final;
                    $notas->nota_total = $notaFinal;
                    $notas->nota_aprobacion = 61;
                    $notas->save();

                    $notas = new Nota();
                    $notas->codigo_anterior = $n->regID;
                    $notas->user_id = 36;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $docente->id;
                    $notas->persona_id = $alumno->id;
                    $notas->asignatura_id = $asignatura->id;
                    $notas->turno_id = $n->turn;
                    $notas->anio_vigente = $gestion;
                    $notas->semestre = $n->semesn;
                    $notas->trimestre = $n->trim + 2;
                    $notas->fecha_registro = $n->fec_reg;
                    $notas->nota_asistencia = $n->asist_a;
                    $notas->nota_practicas = $n->trab_a;
                    $notas->nota_puntos_ganados = $n->p_ganados;
                    $notas->nota_primer_parcial = $n->p_parcial;
                    $notas->nota_examen_final = $n->e_final;
                    $notas->nota_total = $notaFinal;
                    $notas->nota_aprobacion = 61;
                    $notas->save();
                }
            }
        }
        //saco todas las notas totales de la gestion
        /*        $notas = DB::select("
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

    /*        foreach ($notas as $n) {

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

    // para las gestiones 2019-2020
    public function notas3()
    {
        $gestion = 2019;
        // para la gestion 2015
        $notas = DB::table('reg_notas')
            ->whereNull('nota')
            ->where('gestion', $gestion)
            ->get();
        // dd($notas);0

        foreach ($notas as $key => $n) {
            $alumno = Persona::where('cedula', $n->carnetID)->first();
            $docente = User::where('codigo_anterior', $n->docenID)->first();
            $asignatura = Asignatura::where('codigo_anterior', $n->asignaturaID)->first();
            if ($alumno && $docente && $asignatura) {
                // echo $key." - ".$n->regID." - ".$n->carnetID." - ".$alumno->cedula." - ".$alumno->id." - ".$asignatura->id."<br />";
                echo $key . " - " . $n->regID . " - " . $n->carnetID . " - " . $alumno->cedula . "<br />";
            }
            $notaFinal = $n->asist_a + $n->trab_a + $n->p_ganados + $n->p_parcial + $n->e_final;

            if ($alumno && $docente && $asignatura) {
                $notas = new Nota();
                $notas->codigo_anterior = $n->regID;
                $notas->user_id = 36;
                $notas->resolucion_id = 1;
                $notas->docente_id = $docente->id;
                $notas->persona_id = $alumno->id;
                $notas->asignatura_id = $asignatura->id;
                $notas->turno_id = $n->turn;
                $notas->anio_vigente = $gestion;
                $notas->semestre = $n->semesn;
                $notas->trimestre = $n->trim;
                $notas->fecha_registro = $n->fec_reg;
                $notas->nota_asistencia = $n->asist_a;
                $notas->nota_practicas = $n->trab_a;
                $notas->nota_puntos_ganados = $n->p_ganados;
                $notas->nota_primer_parcial = $n->p_parcial;
                $notas->nota_examen_final = $n->e_final;
                $notas->nota_total = $notaFinal;
                $notas->nota_aprobacion = 61;
                $notas->save();
            }
        }
    }

    // para la gestion 2016, 2017, 2018
    public function notas2()
    {
        $gestion = 2017;
        // dd($gestion);
        $notas = DB::table('reg_notas')
            ->whereNull('nota')
            ->whereYear('fec_reg', $gestion)
            ->get();
        // dd($notas);

        foreach ($notas as $key => $n) {
            $alumno = Persona::where('cedula', $n->carnetID)->first();
            $docente = User::where('codigo_anterior', $n->docenID)->first();
            $asignatura = Asignatura::where('codigo_anterior', $n->asignaturaID)->first();

            if ($alumno && $docente && $asignatura) {
                echo $key . " - " . $n->regID . " - " . $n->carnetID . " - " . $alumno->cedula . " - " . $alumno->id . " - " . $asignatura->id . "<br />";
            }

            $notaFinal = $n->asist_a + $n->trab_a + $n->p_ganados + $n->p_parcial + $n->e_final;

            if ($n->trim == 1) {
                if ($alumno && $docente && $asignatura) {
                    $notas = new Nota();
                    $notas->codigo_anterior = $n->regID;
                    $notas->user_id = 1;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $docente->id;
                    $notas->persona_id = $alumno->id;
                    $notas->asignatura_id = $asignatura->id;
                    $notas->turno_id = $n->turn;
                    $notas->anio_vigente = $gestion;
                    $notas->trimestre = $n->trim;
                    $notas->fecha_registro = $n->fec_reg;
                    $notas->nota_asistencia = $n->asist_a;
                    $notas->nota_practicas = $n->trab_a;
                    $notas->nota_puntos_ganados = $n->p_ganados;
                    $notas->nota_primer_parcial = $n->p_parcial;
                    $notas->nota_examen_final = $n->e_final;
                    $notas->nota_total = $notaFinal;
                    $notas->nota_aprobacion = 61;
                    $notas->save();

                    $notas = new Nota();
                    $notas->codigo_anterior = $n->regID;
                    $notas->user_id = 1;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $docente->id;
                    $notas->persona_id = $alumno->id;
                    $notas->asignatura_id = $asignatura->id;
                    $notas->turno_id = $n->turn;
                    $notas->anio_vigente = $gestion;
                    $notas->trimestre = $n->trim + 2;
                    $notas->fecha_registro = $n->fec_reg;
                    $notas->nota_asistencia = $n->asist_a;
                    $notas->nota_practicas = $n->trab_a;
                    $notas->nota_puntos_ganados = $n->p_ganados;
                    $notas->nota_primer_parcial = $n->p_parcial;
                    $notas->nota_examen_final = $n->e_final;
                    $notas->nota_total = $notaFinal;
                    $notas->nota_aprobacion = 61;
                    $notas->save();
                }
            } else {

                if ($alumno && $docente && $asignatura) {

                    $notas = new Nota();
                    $notas->codigo_anterior = $n->regID;
                    $notas->user_id = 1;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $docente->id;
                    $notas->persona_id = $alumno->id;
                    $notas->asignatura_id = $asignatura->id;
                    $notas->turno_id = $n->turn;
                    $notas->anio_vigente = $gestion;
                    $notas->trimestre = $n->trim;
                    $notas->fecha_registro = $n->fec_reg;
                    $notas->nota_asistencia = $n->asist_a;
                    $notas->nota_practicas = $n->trab_a;
                    $notas->nota_puntos_ganados = $n->p_ganados;
                    $notas->nota_primer_parcial = $n->p_parcial;
                    $notas->nota_examen_final = $n->e_final;
                    $notas->nota_total = $notaFinal;
                    $notas->nota_aprobacion = 61;
                    $notas->save();

                    $notas = new Nota();
                    $notas->codigo_anterior = $n->regID;
                    $notas->user_id = 1;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $docente->id;
                    $notas->persona_id = $alumno->id;
                    $notas->asignatura_id = $asignatura->id;
                    $notas->turno_id = $n->turn;
                    $notas->anio_vigente = $gestion;
                    $notas->trimestre = $n->trim + 2;
                    $notas->fecha_registro = $n->fec_reg;
                    $notas->nota_asistencia = $n->asist_a;
                    $notas->nota_practicas = $n->trab_a;
                    $notas->nota_puntos_ganados = $n->p_ganados;
                    $notas->nota_primer_parcial = $n->p_parcial;
                    $notas->nota_examen_final = $n->e_final;
                    $notas->nota_total = $notaFinal;
                    $notas->nota_aprobacion = 61;
                    $notas->save();

                }
            }
        }
        //saco todas las notas totales de la gestion
    }

    // para migrar todas las materias de convalidacion
    public function convalidacion()
    {
        $gestion = 2011;
        // dd($gestion);
        $notas = DB::table('reg_notas')
            ->whereNotNull('nota')
            ->where('gestion', $gestion)
            ->get();

        // dd($notas);
        foreach ($notas as $n) {
            $asignatura = Asignatura::where('codigo_anterior', $n->asignaturaID)
                ->first();

            $alumno = Persona::where('cedula', $n->carnetID)->first();

            if ($n->docenID == 0) {
                $codigoDocente = 36;
            } else {
                $docente = User::where('codigo_anterior', $n->docenID)->first();
                $codigoDocente = $docente->id;
            }

            /*if($n->fec_reg){
            $gestion = substr($n->fec_reg, 0, 4);
            }*/

            if ($n->nota >= 61) {
                $aprobo = "Si";
            } else {
                $aprobo = "No";
            }
            echo $n->regID . " - " . $gestion . " - " . $n->carnetID . "<br />";

            if ($asignatura && $alumno) {
                $inscripcion                  = new Inscripcione();
                $inscripcion->codigo_anterior = $n->regID;
                $inscripcion->user_id         = $codigoDocente;
                $inscripcion->resolucion_id   = 1;
                $inscripcion->carrera_id      = $asignatura->carrera_id;
                $inscripcion->asignatura_id   = $asignatura->id;
                $inscripcion->turno_id        = $n->turn;
                $inscripcion->persona_id      = $alumno->id;
                $inscripcion->semestre        = $n->semesn;
                $inscripcion->gestion         = $n->gestionn;
                $inscripcion->anio_vigente    = $gestion;
                $inscripcion->fecha_registro  = $n->fec_reg;
                $inscripcion->nota            = $n->nota;
                $inscripcion->nota_aprobacion = 61;
                $inscripcion->troncal         = "Si";
                $inscripcion->aprobo          = $aprobo;
                $inscripcion->convalidado     = "Si";
                $inscripcion->estado          = "Finalizado";
                $inscripcion->save();
            }
        }

    }

    // esta function nos permite llenar las
    // inscripciones a partir de las notas
    public function notasAInscripciones()
    {
        $gestion = 2013;

        $notas = Nota::where('anio_vigente', $gestion)
            ->selectRaw("
                    id,
                    user_id,
                    docente_id,
                    persona_id,
                    turno_id,
                    paralelo,
                    anio_vigente,
                    semestre,
                    trimestre,
                    fecha_registro,
                    asignatura_id, AVG(nota_asistencia + nota_practicas+ nota_primer_parcial + nota_examen_final + nota_puntos_ganados) AS total ")
            ->groupBy('persona_id', 'asignatura_id')
            ->get();
        foreach ($notas as $n) {
            $notaRedondeada = round($n['total'], 0, PHP_ROUND_HALF_UP);
            $asignatura = Asignatura::where('id', $n->asignatura_id)->first();
            echo $n['id'] . " - " . $n['persona_id'] . " - " . $n['total'] . " - " . $notaRedondeada . "<br />";
            // aqui preguntamos si la nota fue aprobada
            if ($notaRedondeada > 61) {
                $alumnoAprobo = "Si";
            } else {
                $alumnoAprobo = "No";
            }

            $inscripcion = new Inscripcione();
            $inscripcion->user_id = $n['docente_id'];
            $inscripcion->resolucion_id = 1;
            $inscripcion->carrera_id = $asignatura->carrera_id;
            $inscripcion->asignatura_id = $n['asignatura_id'];
            $inscripcion->turno_id = $n['turno_id'];
            $inscripcion->persona_id = $n['persona_id'];
            $inscripcion->paralelo = $n['paralelo'];
            $inscripcion->semestre = $n['semestre'];
            $inscripcion->gestion = $asignatura->gestion;
            $inscripcion->anio_vigente = $n['anio_vigente'];
            $inscripcion->fecha_registro = $n['fecha_registro'];
            $inscripcion->nota_aprobacion = 61;
            $inscripcion->aprobo = $alumnoAprobo;
            $inscripcion->troncal = "Si";
            $inscripcion->nota = $notaRedondeada;
            $inscripcion->estado = "Finalizado";
            $inscripcion->save();
            // $inscripcion->persona_id = $n->persona_id;
            /*echo "<pre>";
        print_r($n);
        echo "</pre>";*/
        }
        // dd($notas);
    }

    public function deInscripcionesANotas()
    {
        $gestion = 2015;
        $inscripciones = Inscripcione::where('anio_vigente', $gestion);
        foreach ($inscripciones as $i) {
            echo $i->id . "<br />";

        }
    }

    // funcion para regularizar los paralelos en inscripciones
    public function llenaParalelos()
    {
        $gestion = 2013;
        $carreras = CarrerasPersona::where('anio_vigente', $gestion)->get();
        foreach ($carreras as $c) {
            echo $c->id . " - " . $c->carrera_id . " - " . $c->estado . "<br />";
            $inscripciones = Inscripcione::where('anio_vigente', $gestion)
                ->where('persona_id', $c->persona_id)
                ->update(['paralelo' => $c->paralelo]);
        }
    }

    // funcion para regularizar la tabla notas
    // con la inscripcion y el paralelo
    public function llenaNotas()
    {
        $gestion = 2013;
        $inscripciones = Inscripcione::where('anio_vigente', $gestion)->get();
        foreach ($inscripciones as $i) {
            echo $i->id . " - " . $i->persona_id . " - " . $i->nota . "<br />";
            $notas = Nota::where('anio_vigente', $gestion)
                ->where('persona_id', $i->persona_id)
                ->where('asignatura_id', $i->asignatura_id)
                ->update([
                    'inscripcion_id' => $i->id,
                    'paralelo' => $i->paralelo,
                ]);
        }
    }

    // esta funcion completa todas las notas a 4 filas
    public function regularizaNotasAlumnos()
    {

    }

    public function regularizaAnio()
    {

        $inscripciones = Inscripcione::where()->get();

        foreach ($inscripciones as $i) {
            $asignatura = Asignatura::where('id', $i->asignatura_id)->first();
            echo $i->id . " - " . $asignatura->gestion . "<br />";

            /*$modIns = Inscripcione::find($i->asignatura_id);
        $modIns->gestion = $asignatura->gestion;
        $modIns->save();*/
        }
    }

    // para la migracion en funcion a la gestion de la materia
    public function notasPorAsignatura()
    {
        $gestion = 2019;
        // para la gestion 2015
        $notas = DB::table('reg_notas')
            ->whereNull('nota')
            ->where('gestion', $gestion)
            ->get();
        // dd($notas);0

        foreach ($notas as $key => $n) {
            $alumno = Persona::where('cedula', $n->carnetID)->first();
            $docente = User::where('codigo_anterior', $n->docenID)->first();
            $asignatura = Asignatura::where('codigo_anterior', $n->asignaturaID)->first();
            if ($alumno && $docente && $asignatura) {
                // echo $key." - ".$n->regID." - ".$n->carnetID." - ".$alumno->cedula." - ".$alumno->id." - ".$asignatura->id."<br />";
                echo $key . " - " . $n->regID . " - " . $n->carnetID . " - " . $alumno->cedula . "<br />";
            }
            $notaFinal = $n->asist_a + $n->trab_a + $n->p_ganados + $n->p_parcial + $n->e_final;

            /*if($n->trim == 1)
        {
        if($alumno && $docente && $asignatura)
        {
        $notas                      = new Nota();
        $notas->codigo_anterior     = $n->regID;
        $notas->user_id             = 36;
        $notas->resolucion_id       = 1;
        $notas->docente_id          = $docente->id;
        $notas->persona_id          = $alumno->id;
        $notas->asignatura_id       = $asignatura->id;
        $notas->turno_id            = $n->turn;
        $notas->anio_vigente        = $gestion;
        $notas->semestre            = $n->semesn;
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
        $notas->user_id             = 36;
        $notas->resolucion_id       = 1;
        $notas->docente_id          = $docente->id;
        $notas->persona_id          = $alumno->id;
        $notas->asignatura_id       = $asignatura->id;
        $notas->turno_id            = $n->turn;
        $notas->anio_vigente        = $gestion;
        $notas->semestre            = $n->semesn;
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
        if($alumno && $docente && $asignatura)
        {
        $notas                      = new Nota();
        $notas->codigo_anterior     = $n->regID;
        $notas->user_id             = 36;
        $notas->resolucion_id       = 1;
        $notas->docente_id          = $docente->id;
        $notas->persona_id          = $alumno->id;
        $notas->asignatura_id       = $asignatura->id;
        $notas->turno_id            = $n->turn;
        $notas->anio_vigente        = $gestion;
        $notas->semestre            = $n->semesn;
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
        $notas->user_id             = 36;
        $notas->resolucion_id       = 1;
        $notas->docente_id          = $docente->id;
        $notas->persona_id          = $alumno->id;
        $notas->asignatura_id       = $asignatura->id;
        $notas->turno_id            = $n->turn;
        $notas->anio_vigente        = $gestion;
        $notas->semestre            = $n->semesn;
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
        }*/
        }

    }

    // esta function regulariza las notas de la ggestion
    // 2019 y 2020 para que sean 4 calificaciones
    // caso de los que tienen una sola nota y tienen el primer trimestre
    public function regularizaNotas1()
    {

        $gestion = 2019;
        $asignaturas = DB::select("
            SELECT codigo_anterior, docente_id, persona_id, asignatura_id, turno_id,
                   anio_vigente, semestre, trimestre, fecha_registro,
                   nota_asistencia, nota_practicas, nota_puntos_ganados,
                   nota_primer_parcial, nota_examen_final, nota_total, COUNT(*) AS total
            FROM notas
            WHERE anio_vigente = $gestion
            GROUP BY persona_id, asignatura_id
            HAVING total < 2;
        ");

        foreach ($asignaturas as $k => $a) {

            // $masTrimestre = 0;

            /*if($a->trimestre == 1){
            $masTrimestre = $a->trimestre+2;
            }else{
            $masTrimestre = $a->trimestre+2;
            }*/

            $notas = Nota::where('persona_id', $a->persona_id)
                ->where('asignatura_id', $a->asignatura_id)
                ->where('anio_vigente', $gestion)
                ->get();

            foreach ($notas as $no) {
                if ($no->trimestre == 1) {

                    echo ++$k . " - " . $no->id . " - " . $no->asignatura_id . " - " . $no->trimestre . "<br />";

                    $notas = new Nota();
                    $notas->codigo_anterior = $no->codigo_anterior;
                    $notas->user_id = 36;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $no->docente_id;
                    $notas->persona_id = $no->persona_id;
                    $notas->asignatura_id = $no->asignatura_id;
                    $notas->turno_id = $no->turno_id;
                    $notas->anio_vigente = $no->anio_vigente;
                    $notas->semestre = $no->semestre;
                    $notas->trimestre = 3;
                    $notas->fecha_registro = $no->fecha_registro;
                    $notas->nota_asistencia = $no->nota_asistencia;
                    $notas->nota_practicas = $no->nota_practicas;
                    $notas->nota_puntos_ganados = $no->nota_puntos_ganados;
                    $notas->nota_primer_parcial = $no->nota_primer_parcial;
                    $notas->nota_examen_final = $no->nota_examen_final;
                    $notas->nota_total = $no->nota_total;
                    $notas->nota_aprobacion = 61;
                    $notas->save();

                    $notas = new Nota();
                    $notas->codigo_anterior = $no->codigo_anterior;
                    $notas->user_id = 36;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $no->docente_id;
                    $notas->persona_id = $no->persona_id;
                    $notas->asignatura_id = $no->asignatura_id;
                    $notas->turno_id = $no->turno_id;
                    $notas->anio_vigente = $no->anio_vigente;
                    $notas->semestre = $no->semestre;
                    $notas->trimestre = 2;
                    $notas->fecha_registro = $no->fecha_registro;
                    $notas->nota_asistencia = 0;
                    $notas->nota_practicas = 0;
                    $notas->nota_puntos_ganados = 0;
                    $notas->nota_primer_parcial = 0;
                    $notas->nota_examen_final = 0;
                    $notas->nota_total = 0;
                    $notas->nota_aprobacion = 61;
                    $notas->save();

                    $notas = new Nota();
                    $notas->codigo_anterior = $no->codigo_anterior;
                    $notas->user_id = 36;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $no->docente_id;
                    $notas->persona_id = $no->persona_id;
                    $notas->asignatura_id = $no->asignatura_id;
                    $notas->turno_id = $no->turno_id;
                    $notas->anio_vigente = $no->anio_vigente;
                    $notas->semestre = $no->semestre;
                    $notas->trimestre = 4;
                    $notas->fecha_registro = $no->fecha_registro;
                    $notas->nota_asistencia = 0;
                    $notas->nota_practicas = 0;
                    $notas->nota_puntos_ganados = 0;
                    $notas->nota_primer_parcial = 0;
                    $notas->nota_examen_final = 0;
                    $notas->nota_total = 0;
                    $notas->nota_aprobacion = 61;
                    $notas->save();
                }

            }
        }

    }

    // esta function regulariza las notas de la ggestion
    // 2019 y 2020 para que sean 4 calificaciones
    // caso de los que tienen 2 notas que son trimestre 1 y 2
    public function regularizaNotas2()
    {

        $gestion = 2019;
        $asignaturas = DB::select("
            SELECT codigo_anterior, docente_id, persona_id, asignatura_id, turno_id,
                   anio_vigente, semestre, trimestre, fecha_registro,
                   nota_asistencia, nota_practicas, nota_puntos_ganados,
                   nota_primer_parcial, nota_examen_final, nota_total, COUNT(*) AS total
            FROM notas
            WHERE anio_vigente = $gestion
            GROUP BY persona_id, asignatura_id
            HAVING total = 2;
        ");

        foreach ($asignaturas as $k => $a) {

            // $masTrimestre = 0;

            /*if($a->trimestre == 1){
            $masTrimestre = $a->trimestre+2;
            }else{
            $masTrimestre = $a->trimestre+2;
            }*/

            $notas = Nota::where('persona_id', $a->persona_id)
                ->where('asignatura_id', $a->asignatura_id)
                ->where('anio_vigente', $gestion)
                ->get();

            foreach ($notas as $no) {
                if ($no->trimestre == 1) {

                    echo ++$k . " - " . $no->id . " - " . $no->asignatura_id . " - " . $no->trimestre . "<br />";

                    $notas = new Nota();
                    $notas->codigo_anterior = $no->codigo_anterior;
                    $notas->user_id = 36;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $no->docente_id;
                    $notas->persona_id = $no->persona_id;
                    $notas->asignatura_id = $no->asignatura_id;
                    $notas->turno_id = $no->turno_id;
                    $notas->anio_vigente = $no->anio_vigente;
                    $notas->semestre = $no->semestre;
                    $notas->trimestre = 3;
                    $notas->fecha_registro = $no->fecha_registro;
                    $notas->nota_asistencia = $no->nota_asistencia;
                    $notas->nota_practicas = $no->nota_practicas;
                    $notas->nota_puntos_ganados = $no->nota_puntos_ganados;
                    $notas->nota_primer_parcial = $no->nota_primer_parcial;
                    $notas->nota_examen_final = $no->nota_examen_final;
                    $notas->nota_total = $no->nota_total;
                    $notas->nota_aprobacion = 61;
                    $notas->save();

                }

                if ($no->trimestre == 2) {

                    echo ++$k . " - " . $no->id . " - " . $no->asignatura_id . " - " . $no->trimestre . "<br />";

                    $notas = new Nota();
                    $notas->codigo_anterior = $no->codigo_anterior;
                    $notas->user_id = 36;
                    $notas->resolucion_id = 1;
                    $notas->docente_id = $no->docente_id;
                    $notas->persona_id = $no->persona_id;
                    $notas->asignatura_id = $no->asignatura_id;
                    $notas->turno_id = $no->turno_id;
                    $notas->anio_vigente = $no->anio_vigente;
                    $notas->semestre = $no->semestre;
                    $notas->trimestre = 4;
                    $notas->fecha_registro = $no->fecha_registro;
                    $notas->nota_asistencia = $no->nota_asistencia;
                    $notas->nota_practicas = $no->nota_practicas;
                    $notas->nota_puntos_ganados = $no->nota_puntos_ganados;
                    $notas->nota_primer_parcial = $no->nota_primer_parcial;
                    $notas->nota_examen_final = $no->nota_examen_final;
                    $notas->nota_total = $no->nota_total;
                    $notas->nota_aprobacion = 61;
                    $notas->save();

                }

            }
        }

    }

    // esta function regulariza las notas de la ggestion
    // 2019 y 2020 para que sean 4 calificaciones
    // caso de los que tienen 3 notas y le falta 1
    public function regularizaNotas3()
    {

        $gestion = 2019;
        $asignaturas = DB::select("
            SELECT codigo_anterior, docente_id, persona_id, asignatura_id, turno_id,
                   anio_vigente, semestre, trimestre, fecha_registro,
                   nota_asistencia, nota_practicas, nota_puntos_ganados,
                   nota_primer_parcial, nota_examen_final, nota_total, COUNT(*) AS total
            FROM notas
            WHERE anio_vigente = $gestion
            GROUP BY persona_id, asignatura_id
            HAVING total = 3;
        ");

        foreach ($asignaturas as $k => $a) {

            // $masTrimestre = 0;

            /*if($a->trimestre == 1){
            $masTrimestre = $a->trimestre+2;
            }else{
            $masTrimestre = $a->trimestre+2;
            }*/

            for ($i = 1; $i <= 4; $i++) {

                $notas = Nota::where('persona_id', $a->persona_id)
                    ->where('asignatura_id', $a->asignatura_id)
                    ->where('anio_vigente', $gestion)
                    ->where('trimestre', $i)
                    ->first();
                // print_r($notas->trimestre);
                if ($notas) {
                    echo ++$k . " - " . "hay - " . $i . " - " . $notas->persona_id . " - " . $notas->asignatura_id . " - " . $notas->trimestre . "<br />";
                } else {
                    echo "falta -" . $i . "<br>";
                    if ($i == 1) {
                        $notaUno = Nota::where('persona_id', $a->persona_id)
                            ->where('asignatura_id', $a->asignatura_id)
                            ->where('anio_vigente', $gestion)
                            ->where('trimestre', 3)
                            ->first();
                        if ($notaUno) {
                            $notas = new Nota();
                            $notas->codigo_anterior = $notaUno->codigo_anterior;
                            $notas->user_id = 36;
                            $notas->resolucion_id = 1;
                            $notas->inscripcion_id = $notaUno->inscripcion_id;
                            $notas->docente_id = $notaUno->docente_id;
                            $notas->persona_id = $notaUno->persona_id;
                            $notas->asignatura_id = $notaUno->asignatura_id;
                            $notas->turno_id = $notaUno->turno_id;
                            $notas->paralelo = $notaUno->paralelo;
                            $notas->anio_vigente = $notaUno->anio_vigente;
                            $notas->semestre = $notaUno->semestre;
                            $notas->trimestre = 1;
                            $notas->fecha_registro = $notaUno->fecha_registro;
                            $notas->nota_asistencia = $notaUno->nota_asistencia;
                            $notas->nota_practicas = $notaUno->nota_practicas;
                            $notas->nota_puntos_ganados = $notaUno->nota_puntos_ganados;
                            $notas->nota_primer_parcial = $notaUno->nota_primer_parcial;
                            $notas->nota_examen_final = $notaUno->nota_examen_final;
                            $notas->nota_total = $notaUno->nota_total;
                            $notas->nota_aprobacion = 61;
                            $notas->save();
                        }
                    }

                    if ($i == 2) {
                        $notaUno = Nota::where('persona_id', $a->persona_id)
                            ->where('asignatura_id', $a->asignatura_id)
                            ->where('anio_vigente', $gestion)
                            ->where('trimestre', 4)
                            ->first();
                        if ($notaUno) {
                            $notas = new Nota();
                            $notas->codigo_anterior = $notaUno->codigo_anterior;
                            $notas->user_id = 36;
                            $notas->resolucion_id = 1;
                            $notas->inscripcion_id = $notaUno->inscripcion_id;
                            $notas->docente_id = $notaUno->docente_id;
                            $notas->persona_id = $notaUno->persona_id;
                            $notas->asignatura_id = $notaUno->asignatura_id;
                            $notas->turno_id = $notaUno->turno_id;
                            $notas->paralelo = $notaUno->paralelo;
                            $notas->anio_vigente = $notaUno->anio_vigente;
                            $notas->semestre = $notaUno->semestre;
                            $notas->trimestre = 2;
                            $notas->fecha_registro = $notaUno->fecha_registro;
                            $notas->nota_asistencia = $notaUno->nota_asistencia;
                            $notas->nota_practicas = $notaUno->nota_practicas;
                            $notas->nota_puntos_ganados = $notaUno->nota_puntos_ganados;
                            $notas->nota_primer_parcial = $notaUno->nota_primer_parcial;
                            $notas->nota_examen_final = $notaUno->nota_examen_final;
                            $notas->nota_total = $notaUno->nota_total;
                            $notas->nota_aprobacion = 61;
                            $notas->save();
                        }
                    }
                }
            }
            echo "<hr>";

            /*foreach($notas as $no){

        if($no->trimestre == 3){

        echo ++$k." - ".$no->id." - ".$no->asignatura_id." - ".$no->trimestre."<br />";

        $notas                      = new Nota();
        $notas->codigo_anterior     = $no->codigo_anterior;
        $notas->user_id             = 36;
        $notas->resolucion_id       = 1;
        $notas->docente_id          = $no->docente_id;
        $notas->persona_id          = $no->persona_id;
        $notas->asignatura_id       = $no->asignatura_id;
        $notas->turno_id            = $no->turno_id;
        $notas->anio_vigente        = $no->anio_vigente;
        $notas->semestre            = $no->semestre;
        $notas->trimestre           = 1;
        $notas->fecha_registro      = $no->fecha_registro;
        $notas->nota_asistencia     = $no->nota_asistencia;
        $notas->nota_practicas      = $no->nota_practicas;
        $notas->nota_puntos_ganados = $no->nota_puntos_ganados;
        $notas->nota_primer_parcial = $no->nota_primer_parcial;
        $notas->nota_examen_final   = $no->nota_examen_final;
        $notas->nota_total          = $no->nota_total;
        $notas->nota_aprobacion     = 61;
        $notas->save();

        }

        }*/
        }

    }

    public function regularizaGestionAlumnos()
    {
        $gestiones = DB::select("SELECT persona_id, MIN(anio_vigente) AS gestion
                                FROM inscripciones
                                GROUP BY persona_id;");

        foreach ($gestiones as $key => $g) {
            echo $g->persona_id." - ".$g->gestion."<br />";
            $persona = Persona::find($g->persona_id);
            $persona->anio_vigente = $g->gestion;
            $persona->save();
        }
    }

    public function regularizaDocentesMaterias()
    {
        $notas = Nota::groupBy('docente_id', 'asignatura_id', 'paralelo', 'turno_id', 'anio_vigente')
                    ->get();

        foreach($notas as $n){
            if ($n->docente_id != null) {
                $asignatura = Asignatura::where('id', $n->asignatura_id)->first();
                echo $n->docente_id." - ".$asignatura->carrera_id." - ".$n->asignatura_id." - ".$n->turno_id." - ".$n->paralelo." - ".$n->anio_vigente."<br />";

                $materia = new NotasPropuesta();
                $materia->user_id = 36;
                $materia->docente_id = $n->docente_id;
                $materia->carrera_id = $asignatura->carrera_id;
                $materia->asignatura_id = $n->asignatura_id;
                $materia->turno_id = $n->turno_id;
                $materia->paralelo = $n->paralelo;
                $materia->anio_vigente = $n->anio_vigente;
                $materia->save();
            }
        }

        // dd($notas);

        /*
        SET sql_mode = ''; 
SELECT *
  FROM notas n
  GROUP BY n.docente_id, n.asignatura_id, n.paralelo, n.turno_id, n.anio_vigente;*/
    }

    // para regularizar las materias de los alumnos 2020
    public function regularizaAlumnosMaterias()
    {
        $fecha = date('Y-m-d');
        // vemos a todos los alumnos que esten inscritos en la gestion 2020
        $alumnos = CarrerasPersona::where('anio_vigente', 2020)
                    ->get();

        foreach ($alumnos as $key => $a) {

            echo $a->id.' - '.$a->persona->nombres.' - '.$a->carrera_id.'<br />';

            // buscamos las materias que pertenescan a la carrera
            $materias = Asignatura::where('carrera_id', $a->carrera_id)
                        ->where('anio_vigente', 2020)
                        ->where('gestion', $a->gestion)
                        ->get();
            
            foreach($materias as $m){

                $inscripcion                  = new Inscripcione();
                $inscripcion->user_id         = 36;
                $inscripcion->resolucion_id   = 1;
                $inscripcion->carrera_id      = $a->carrera_id;
                $inscripcion->asignatura_id   = $m->id;
                $inscripcion->turno_id        = $a->turno_id;
                $inscripcion->persona_id      = $a->persona_id;
                $inscripcion->paralelo        = $a->paralelo;
                $inscripcion->semestre        = $m->semestre;
                $inscripcion->gestion         = $a->gestion;
                $inscripcion->anio_vigente    = 2020;
                $inscripcion->fecha_registro  = $fecha;
                $inscripcion->nota            = 0;
                $inscripcion->convalidado     = 'No';
                $inscripcion->nota_aprobacion = 61;
                $inscripcion->troncal         = 'Si';
                $inscripcion->estado          = 'Cursando';
                $inscripcion->save();
                $inscripcionId = $inscripcion->id;

                echo $m->nombre.'<br />';
                for ($i=1; $i <= 4; $i++) { 
                    $docente = NotasPropuesta::where('anio_vigente', 2020)
                        ->where('turno_id', $a->turno_id)
                        ->where('paralelo', $a->paralelo)
                        ->where('asignatura_id', $m->id)
                        ->first();

                    if($docente){
                        $nombreDocente = $docente->docente_id;
                    }else{
                        $nombreDocente = null;
                    }
                    echo 'Bimestre '.$i.'-' .$nombreDocente. '<br />';
                    $notas                  = new Nota();
                    $notas->user_id         = 36;
                    $notas->resolucion_id   = 1;
                    $notas->inscripcion_id  = $inscripcionId;
                    $notas->docente_id      = $nombreDocente;
                    $notas->persona_id      = $a->persona_id;
                    $notas->asignatura_id   = $m->id;
                    $notas->turno_id        = $a->turno_id;
                    $notas->paralelo        = $a->paralelo;
                    $notas->anio_vigente    = 2020;
                    $notas->semestre        = $m->semestre;
                    $notas->trimestre       = $i;
                    $notas->fecha_registro  = $fecha;
                    $notas->nota_aprobacion = 61;
                    $notas->save();
                }
            }
        }
        // dd($alumnos);
    }

    public function migracion2021()
    {
        $c = 1;
        $arrayAlumnos = array();
        $inscripciones = DB::table('datos_kardex')
                        ->where('anio_act', 2021)
                        ->get();

        foreach ($inscripciones as $key => $i) {
            $alumnos = Persona::where('cedula', $i->carnetIDA)
                        ->count();

            if($alumnos < 1){
                // echo "No esta $c -".$i->carnetIDA."<br />";
                $arrayAlumnos[] = $i->carnetIDA; 
                $c++;
            }
            
        }

        $alumnosNuevos = DB::table('alumno_nuevo')
                        ->whereIn('carnetIda', $arrayAlumnos)
                        ->get();

        // dd($alumnosNuevos);
        foreach ($alumnosNuevos as $a) {
            // modificamos para las ciudades
            $primeraLetra = $a->ciu_a;
            if ($primeraLetra[0] == "L" || $primeraLetra[0] == "l") {
                $ciudad = "La Paz";
            } elseif ($primeraLetra[0] == "B") {
                $ciudad = "Beni";
            } elseif ($primeraLetra[0] == "C") {
                $ciudad = "Cochabamba";
            } elseif ($primeraLetra[0] == "O") {
                $ciudad = "Oruro";
            } elseif ($primeraLetra[0] == "P") {
                $ciudad = "Potosi";
            } elseif ($primeraLetra[0] == "S") {
                $ciudad = "Santa Cruz";
            } elseif ($primeraLetra[0] == "T") {
                $ciudad = "Tarija";
            } elseif ($primeraLetra[0] == null) {
                $ciudad = "La Paz";
            }
            // fin modificamos para las ciudades

            // para el genero
            $sexoPersona = $a->sexo;
            if ($sexoPersona == "F") {
                $genero = "Femenino";
            } elseif ($sexoPersona == "M") {
                $genero = "Masculino";
            } elseif ($sexoPersona == "") {
                $genero = null;
            }

            // para trabaja
            $trabajaPersona = $a->trabaja;
            if ($trabajaPersona == "S") {
                $chambea = "Si";
            } elseif ($trabajaPersona == "N") {
                $chambea = "No";
            } elseif ($trabajaPersona == "Y") {
                $chambea = "Si";
            } elseif ($trabajaPersona == "") {
                $chambea = "No";
            }

            // fecha nacimiento
            $fechaNacimiento = $a->fec_nac;
            if ($fechaNacimiento == "0000-00-00") {
                $fechaN = null;
            } else {
                $fechaN = $a->fec_nac;
            }

            echo $a->alumnoID . " - " . $a->nombres . " - " . $ciudad . " - " . $genero . "<br />";
            DB::table('personas')->insert([
                'codigo_anterior' => $a->alumnoID,
                'user_id' => 1,
                'apellido_paterno' => $a->a_paterno,
                'apellido_materno' => $a->a_materno,
                'nombres' => $a->nombres,
                'cedula' => $a->carnetIDA,
                'expedido' => $ciudad,
                'fecha_nacimiento' => $fechaN,
                'sexo' => $genero,
                'direccion' => $a->direc_a,
                'numero_fijo' => $a->telf_fijo,
                'numero_celular' => $a->telf_cel,
                'email' => $a->email,
                'trabaja' => $chambea,
                'empresa' => $a->empresa,
                'direccion_empresa' => $a->direc_emp,
                'numero_empresa' => $a->telf_emp,
                'fax' => $a->fax,
                'email_empresa' => $a->email_emp,
                'nombre_padre' => $a->nomb_pa,
                'celular_padre' => $a->tel_pa,
                'nombre_madre' => $a->nom_ma,
                'celular_madre' => $a->tel_ma,
                'nombre_tutor' => $a->nom_tut,
                'celular_tutor' => $a->tel_tut,
                'nombre_pareja' => $a->nom_esp,
                'celular_pareja' => $a->tel_esp,
                'nit' => $a->nit,
                'razon_social_cliente' => $a->raz_cli,
            ]);
        }

    }

    public function migracionInscripciones2021()
    {
        $karadex = DB::table('datos_kardex')
                            ->where('anio_act', 2021)
                            ->get();

        foreach ($karadex as $key => $k) {

            $alumno = Persona::where('cedula', $k->carnetIDA)
                        ->first();
            
            $cp = new CarrerasPersona();
            $cp->codigo_anterior = $k->kardexID;
            $cp->user_id = 36;
            $cp->carrera_id = $k->carreraID;
            $cp->persona_id = $alumno->id;
            $cp->turno_id = $k->turnoID;
            $cp->gestion = $k->gestionk;
            $cp->paralelo = "A";
            $cp->fecha_inscripcion = $k->fecha_ins;
            $cp->anio_vigente = '2021';
            $cp->vigencia = 'Vigente';
            $cp->save();
            
        }

        // dd($inscripciones);
        
    }

    public function regularizaAlumnosMaterias2021()
    {
        $fecha = date('Y-m-d');
        // vemos a todos los alumnos que esten inscritos en la gestion 2020
        $alumnos = CarrerasPersona::where('anio_vigente', 2021)
                    ->get();

        foreach ($alumnos as $key => $a) {

            echo $a->id.' - '.$a->persona->nombres.' - '.$a->carrera_id.'<br />';

            // buscamos las materias que pertenescan a la carrera
            $materias = Asignatura::where('carrera_id', $a->carrera_id)
                        ->where('anio_vigente', 2021)
                        ->where('gestion', $a->gestion)
                        ->get();
            
            foreach($materias as $m){

                $inscripcion                  = new Inscripcione();
                $inscripcion->user_id         = 36;
                $inscripcion->resolucion_id   = 1;
                $inscripcion->carrera_id      = $a->carrera_id;
                $inscripcion->asignatura_id   = $m->id;
                $inscripcion->turno_id        = $a->turno_id;
                $inscripcion->persona_id      = $a->persona_id;
                $inscripcion->paralelo        = $a->paralelo;
                $inscripcion->semestre        = $m->semestre;
                $inscripcion->gestion         = $a->gestion;
                $inscripcion->anio_vigente    = 2021;
                $inscripcion->fecha_registro  = $fecha;
                $inscripcion->nota            = 0;
                $inscripcion->convalidado     = 'No';
                $inscripcion->nota_aprobacion = 61;
                $inscripcion->troncal         = 'Si';
                $inscripcion->estado          = 'Cursando';
                $inscripcion->save();
                $inscripcionId = $inscripcion->id;

                echo $m->nombre.'<br />';
                for ($i=1; $i <= 4; $i++) { 
                    $docente = NotasPropuesta::where('anio_vigente', 2021)
                        ->where('turno_id', $a->turno_id)
                        ->where('paralelo', $a->paralelo)
                        ->where('asignatura_id', $m->id)
                        ->first();

                    if($docente){
                        $nombreDocente = $docente->docente_id;
                    }else{
                        $nombreDocente = null;
                    }
                    echo 'Bimestre '.$i.'-' .$nombreDocente. '<br />';
                    $notas                  = new Nota();
                    $notas->user_id         = 36;
                    $notas->resolucion_id   = 1;
                    $notas->inscripcion_id  = $inscripcionId;
                    $notas->docente_id      = $nombreDocente;
                    $notas->persona_id      = $a->persona_id;
                    $notas->asignatura_id   = $m->id;
                    $notas->turno_id        = $a->turno_id;
                    $notas->paralelo        = $a->paralelo;
                    $notas->anio_vigente    = 2021;
                    $notas->semestre        = $m->semestre;
                    $notas->trimestre       = $i;
                    $notas->fecha_registro  = $fecha;
                    $notas->nota_aprobacion = 61;
                    $notas->save();
                }
            }
        }
        // dd($alumnos);
    }

    public function regularizaInscripcionesSemestre()
    {
        $inscripciones = Inscripcione::where('anio_vigente', 2019)
                        ->whereNull('semestre')
                        ->get();

        foreach ($inscripciones as $i) {
            echo $i->id.'<br />';
            $asignatura = Asignatura::find($i->asignatura_id);

            $modInscripcion = Inscripcione::find($i->id);
            $modInscripcion->semestre = $asignatura->semestre;
            $modInscripcion->save();    
        }

        dd($inscripciones);
    }

    public function migracionj2021()
    {
        $archivo = public_path("sec2.xlsx");
        Excel::import(new InscripcionesImport, $archivo);
    }

    public function migracionInscripcionj()
    {   
        $archivo = public_path("m1218.xlsx");
        Excel::import(new InscritosImport, $archivo);
    }

    public function migracionPagos()
    {
        $archivo = public_path("fp1.xlsx");
        Excel::import(new PagosImport, $archivo);
    }
}