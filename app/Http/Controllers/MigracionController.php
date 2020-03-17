<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MigracionController extends Controller
{
    public function persona()
    {

        $alum_nuevo = DB::select('SELECT 
        						* FROM alumno_nuevo');
        foreach ($alum_nuevo as $valor) {
        	 DB::table('personas')->insert([
            'codigo_anterior' => $valor->alumnoID,
            'apellido_paterno' => $valor->a_paterno,
			'apellido_materno' => $valor->a_materno,
			'nombres' => $valor->nombres,
			'carnet' => $valor->carnetIDA,
			'expedido' => $valor->ciu_a,
			'fecha_nacimiento' => $valor->fec_nac,
			'sexo' => $valor->sexo,
			'direccion' => $valor->direc_a,
			'telefono_fijo' => $valor->telf_fijo,
			'telefono_celular' => $valor->telf_cel,
			'email' => $valor->email,
			'trabaja' => $valor->trabaja,
			'empresa' => $valor->empresa,
			'direccion_empresa' => $valor->direc_emp,
			'telefono_empresa' => $valor->telf_emp,
			'fax' => $valor->fax,
			'email_empresa' => $valor->email_emp,
			'nombre_padre' => $valor->nomb_pa,
			'celular_padre' => $valor->tel_pa,
			'nombre_madre' => $valor->nom_ma,
			'celular_madre' => $valor->tel_ma,
			'nombre_tutor' => $valor->nom_tut,
			'telefono_tutor' => $valor->tel_tut,
			'nombre_esposo' => $valor->nom_esp,
			'telefono_esposo' => $valor->tel_esp,
        	]);
        }

    }

    public function usuario()
    {

        $docente = DB::select('SELECT doc.*, com.*
								FROM docentes doc, docentes_complemento com
								WHERE doc.docenID = com.docenID');
        dd($docente);
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

    public function asignatura()
    {

        $asignatura = DB::select('SELECT *
								FROM asignaturas_copy');
        //dd($docente);
        foreach ($asignatura as $valor) {
        	 DB::table('personas')->insert([
            'codigo_anterior' => $valor->asignaturaID,
			'carrera_id' => $valor->carreraID,
			'gestion' => $valor->gestion,
			'codigo_asignatura' => $valor->cod_asig,
			'nombre_asignatura' => $valor->asignatura,
			'carga_horaria' => $valor->carga_horaria,
			'teorico' => $valor->teorico,
			'practico' => $valor->practico,
			'nivel' => $valor->nivel,
			'semestre' => $valor->semes,
			'periodo' => $valor->periodo,
			'anio_vigente' => $valor->anio_vigen,
			'orden_impresion' => $valor->ord_imp,
        	]);
        }

    }
}
