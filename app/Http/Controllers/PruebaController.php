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

class PruebaController extends Controller
{
    public function inicia()
    {
        // echo 'Holas desde prueba';
        // $this->layout = '';
        return view('template');    
    }

    public function tabla()
    {
        // echo 'Holas desde prueba';
        // $this->layout = '';
        return view('tabla');    
    }

    public function listado()
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

        return view('prueba', compact('carreras', 'turnos', 'year', 'asignaturas')); 
    }

    public function guardar(Request $request)
    {
        // $datos = $request->all();
        // dd($datos);
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

        // REGISTRA LAS CARRERAS INSCRITAS
        foreach ($request->numero as $carr) {
            $datos_carrera = 'carrera_'.$carr;
            $datos_turno = 'turno_'.$carr;
            $datos_paralelo = 'paralelo_'.$carr;
            $datos_gestion = 'gestion_'.$carr;

            $carrera_1 = new CarreraPersona();
            $carrera_1->carrera_id   = $request->$datos_carrera;
            $carrera_1->persona_id   = $persona_id;
            $carrera_1->turno_id     = $request->$datos_turno;
            $carrera_1->paralelo     = $request->$datos_paralelo;
            $carrera_1->anio_vigente = $request->$datos_gestion;
            $carrera_1->sexo         = $request->sexo;
            $carrera_1->save();
        }

        // REGISTRA LAS ASIGNATURAS SUELTAS INSCRITAS
        foreach ($request->numero_asig as $asig) {
            $datos_asig = 'asignatura_'.$asig;
            $datos_turno_asig = 'turno_asig_'.$asig;
            $datos_paralelo_asig = 'paralelo_asig_'.$asig;
            $datos_gestion_asig = 'gestion_asig_'.$asig;

            $inscripcion_1 = new Inscripcion();
            $inscripcion_1->asignatura_id = $request->$datos_asig;
            $inscripcion_1->turno_id = $request->$datos_turno_asig;
            $inscripcion_1->persona_id = $persona_id;
            $inscripcion_1->paralelo = $request->$datos_paralelo_asig;
            $inscripcion_1->anio_vigente = $request->$datos_gestion_asig;
            $inscripcion_1->save();
        }

        return redirect('Persona/listado');
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
                $carrera_2->paralelo     = $request->paralelo_2;
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
                $carrera_3->paralelo     = $request->paralelo_3;
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
                $carrera_4->paralelo     = $request->paralelo_4;
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
                $carrera_5->paralelo     = $request->paralelo_5;
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
                $carrera_6->paralelo     = $request->paralelo_6;
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
                $carrera_7->paralelo     = $request->paralelo_7;
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
}
