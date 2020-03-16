<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class MigracionController extends Controller
{
    public function inicia()
    {

    	/*$unidad = $request->input('unidad');
	    DB::table('unidads')->insertGetId([
	      'unidad'=>$unidad,
	      'activo'=>'1'
	    ]);*/
	           
        $alum_nuevo = DB::select('SELECT 
        	* FROM alumno_nuevo');
        dd($alum_nuevo);
        /*foreach ($alum_nuevo as $valor) {
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
        }*/

    }
}
