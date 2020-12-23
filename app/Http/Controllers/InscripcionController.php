<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use App\Inscripcione;
use App\Carrera;
use App\Asignatura;
use App\Materia;
use App\Turno;
use App\User;
use App\Persona;
use App\Nota;
use App\NotasPropuesta;
use App\CarrerasPersona;
use App\Prerequisito;
use App\Kardex;
use App\CursosCorto;
use App\CobrosTemporada;
use App\Servicio;
use App\Predefinida;
use App\ServiciosAsignatura;
use App\SegundosTurno;
use DB;

class InscripcionController extends Controller
{
    public function nuevo()
    {
        $carreras = Carrera::get();
        $turnos = Turno::get();
        $anio_actual = date('Y');
        return view('inscripcion.nuevo')->with(compact('carreras', 'turnos', 'anio_actual'));
    }

    public function guardar(Request $request)
    {
        // Si existe el parametro $request->persona_id actualizamos, si no existe, creamos uno nuevo
        if($request->persona_id){
            $persona = Persona::find($request->persona_id);
        }else{
            $persona = new Persona();
        }
        $persona->user_id           = Auth::user()->id;
        $persona->apellido_paterno  = $request->apellido_paterno;
        $persona->apellido_materno  = $request->apellido_materno;
        $persona->nombres           = $request->nombres;
        $persona->cedula            = $request->carnet;
        $persona->expedido          = $request->expedido;
        $persona->fecha_nacimiento  = $request->fecha_nacimiento;
        $persona->sexo              = $request->sexo;
        $persona->direccion         = $request->direccion;
        // numero_fijo
        $persona->numero_celular    = $request->telefono_celular;
        $persona->email             = $request->email;
        $persona->trabaja           = $request->trabaja;
        $persona->empresa           = $request->empresa;
        $persona->direccion_empresa = $request->direccion_empresa;
        $persona->numero_empresa    = $request->telefono_empresa;
        // fax
        $persona->email_empresa     = $request->email_empresa;
        $persona->nombre_padre      = $request->nombre_padre;
        $persona->celular_padre     = $request->celular_padre;
        $persona->nombre_madre      = $request->nombre_madre;
        $persona->celular_madre     = $request->celular_madre;
        $persona->nombre_tutor      = $request->nombre_tutor;
        $persona->celular_tutor     = $request->telefono_tutor;
        $persona->nombre_pareja     = $request->nombre_esposo;
        $persona->celular_pareja    = $request->telefono_esposo;
        // nit
        // razon_social_cliente
        $persona->anio_vigente      = date('Y');                // PENDIENTE PARA 2 CARRERAS EN DIFERENTES ANIOS
        $persona->save();
        // En la variable $request->numero, que es un array, se envia la cantidad de carreras inscritas
        foreach ($request->numero as $registro) {
            // Por cada carrera existente, se crean los valores para cada carrera
            $datos_carrera  = 'carrera_'.$registro;
            $datos_turno    = 'turno_'.$registro;
            $datos_paralelo = 'paralelo_'.$registro;
            $datos_gestion  = 'gestion_'.$registro;
            // Si la variable $request->$datos_carrera es diferente de 0, en $request->$datos_carrera esta la carrera_id enviada por interfaz
            if ($request->$datos_carrera != 0) {
                // Para inscribirlo a esa materia, tenemos que validar, que no este inscrito ya en esa carrera
                $verificacion   = Inscripcione::where('carrera_id', $request->$datos_carrera)
                                            ->where('persona_id', $persona->id)
                                            ->first();
                // Si no existe un valor en verificacion es que el alumno no se encuentra en la carrera y se le puede inscribir
                if(!$verificacion){
                    // Resgistramos en la tabla carreras_personas
                    $carreras_persona                       = new CarrerasPersona();
                    $carreras_persona->user_id              = Auth::user()->id;
                    $carreras_persona->carrera_id           = $request->$datos_carrera;
                    $carreras_persona->persona_id           = $persona->id;
                    $carreras_persona->turno_id             = $request->$datos_turno;
                    $carreras_persona->gestion              = 1;
                    $carreras_persona->paralelo             = $request->$datos_paralelo;
                    $carreras_persona->fecha_inscripcion    = $request->fecha_inscripcion;
                    $carreras_persona->anio_vigente         = $request->$datos_gestion;
                    $carreras_persona->sexo                 = $persona->sexo;
                    $carreras_persona->vigencia             = 'Vigente';
                    //$carreras_persona->estado             = '';   APROBO/REPROBO/ABANDONO/AUXILIAR/CONGELADO/NULL/''
                    $carreras_persona->save();

                    // Buscaremos a las materias que pertenecen a la gestion 1, de la asignatura X con anio_vigente X
                    $asignaturas    = Asignatura::where('carrera_id', $request->$datos_carrera)
                                                ->where('gestion', 1)
                                                ->where('anio_vigente', $request->$datos_gestion)
                                                ->get();
                    // Inscribiremos a las asignaturas que se capturaron en la 
                    foreach($asignaturas as $asignatura)
                    {
                        // Verificamos que no este inscrito, e inscribimos
                        $registro   = Inscripcione::where('carrera_id', $asignatura->carrera_id)
                                                ->where('asignatura_id', $asignatura->id)
                                                ->where('turno_id', $request->$datos_turno)
                                                ->where('persona_id', $persona->id)
                                                ->where('paralelo', $request->$datos_paralelo)
                                                ->where('anio_vigente', $request->$datos_gestion)
                                                ->first();
                        // Si no existiera un registro creamos
                        if(!$registro)
                        {
                            $carrera = Carrera::find($request->$datos_carrera);     // MOD
                            // Resgistramos en la tabla inscripciones
                            $inscripcion                    = new Inscripcione();
                            $inscripcion->user_id           = Auth::user()->id;
                            $inscripcion->resolucion_id     = $carrera->resolucion_id;          // MOD
                            $inscripcion->carrera_id        = $request->$datos_carrera;
                            $inscripcion->asignatura_id     = $asignatura->id;
                            $inscripcion->turno_id          = $request->$datos_turno;
                            $inscripcion->persona_id        = $persona->id;
                            $inscripcion->paralelo          = $request->$datos_paralelo;
                            $inscripcion->semestre          = $asignatura->semestre;
                            $inscripcion->gestion           = $asignatura->gestion;
                            $inscripcion->anio_vigente      = $request->$datos_gestion;
                            $inscripcion->fecha_registro    = $request->fecha_inscripcion;
                            $inscripcion->nota_aprobacion   = $carrera->nota_aprobacion;        // MOD
                            $inscripcion->troncal           = $asignatura->troncal;
                            //$inscripcion->aprobo          = 'Si', 'No', 'Cursando';
                            $inscripcion->estado            = 'Cursando';  // Cuando acaba semestre/gestion cambiar a Finalizado
                            $inscripcion->save();
                            // Crearemos las notas correspondientes a esta inscripcion pero antes buscaremos si existe un docente ya asignado a esta asignatura
                            $docente    = NotasPropuesta::where('asignatura_id', $asignatura->id)
                                                        ->where('turno_id', $request->$datos_turno)
                                                        ->where('paralelo', $request->$datos_paralelo)
                                                        ->where('anio_vigente', $request->$datos_gestion)
                                                        ->first();
                            // Por cada materia inscrita, ingresamos 4 registros correspondientes a los 4 bimestres
                            for($i=1; $i<=4; $i++){
                                // Resgistramos en la tabla notas
                                $nota                   = new Nota();
                                $nota->user_id          = Auth::user()->id;
                                $nota->resolucion_id    = $carrera->resolucion_id;          // MOD
                                $nota->inscripcion_id   = $inscripcion->id;
                                if($docente){
                                    $nota->docente_id   = $docente->docente_id;
                                }
                                $nota->persona_id       = $persona->id;
                                $nota->asignatura_id    = $asignatura->id;
                                $nota->turno_id         = $request->$datos_turno;
                                $nota->paralelo         = $request->$datos_paralelo;
                                $nota->anio_vigente     = $request->$datos_gestion;
                                $nota->trimestre        = $i;
                                $nota->fecha_registro   = $request->fecha_inscripcion;
                                $nota->nota_aprobacion  = $carrera->nota_aprobacion;        // MOD
                                $nota->save();
                            }
                        }
                    }
                    /*
                        // Tenemos que ver como se lleva a cabo la 1era gestion, si es por semestres o anual
                        $info_primera_gestion   = Asignatura::where('carrera_id', $request->$datos_carrera)
                                                            ->where('gestion', 1)
                                                            ->where('ciclo', 'Semestral')
                                                            ->first();
                        // Si existe valor en $info_primera_gestion entonces la gestion esta divida en semestres, caso contrario es anual
                        if($info_primera_gestion){
                            // Procedemos a la inscripcion de forma SEMESTRAL
                            // Leeremos la curricula de la tabla Asignaturas y como es una nueva inscripcion capturamos las primeras asignaturas de la carrera
                            $asignaturas_carrera = Asignatura::where('carrera_id', $request->$datos_carrera)
                                                            ->where('anio_vigente', $request->$datos_gestion)
                                                            ->where('gestion', 1)
                                                            ->where('semestre', 1)
                                                            ->get();
                        }else{
                            // Procedemos a la inscripcion de forma ANUAL
                            // Leeremos la curricula de la tabla Asignaturas y como es una nueva inscripcion capturamos las primeras asignaturas de la carrera
                            $asignaturas_carrera = Asignatura::where('carrera_id', $request->$datos_carrera)
                                                            ->where('anio_vigente', $request->$datos_gestion)
                                                            ->where('gestion', 1)
                                                            ->get();
                        }
                        // Crearemos un array para guardar los id's que se inscribiran
                        $array_inscripciones = array();
                        // Por cada asignatura encontrada
                        foreach($asignaturas_carrera as $asignatura){
                            // Verificaremos que no exista un registro con estas variables
                            $registro = Inscripcione::where('carrera_id', $asignatura->carrera_id)
                                                    ->where('asignatura_id', $asignatura->id)
                                                    ->where('turno_id', $request->$datos_turno)
                                                    ->where('persona_id', $persona->id)
                                                    //->where('nota', '>', 60)
                                                    ->first();
                            if(!$registro){
                                // Si no existe un registro con las mismas variables, procedemos a registrar en las tablas inscripciones y notas
                                // Antes buscaremos la informacion de la carrera
                                $informacion_carrera = Carrera::find($request->$datos_carrera);
                                // Inscripcion en la tabla inscripciones
                                $inscripcion = new Inscripcione();
                                $inscripcion->user_id = Auth::user()->id;
                                $inscripcion->resolucion_id = $informacion_carrera->resolucion_id;
                                $inscripcion->carrera_id = $request->$datos_carrera;
                                $inscripcion->asignatura_id = $asignatura->id;
                                $inscripcion->turno_id = $request->$datos_turno;
                                $inscripcion->persona_id = $persona->id;
                                $inscripcion->paralelo = $request->$datos_paralelo;
                                $inscripcion->semestre = $asignatura->semestre;
                                $inscripcion->gestion = $asignatura->gestion;
                                $inscripcion->anio_vigente = $request->$datos_gestion;
                                $inscripcion->fecha_registro = $request->fecha_inscripcion;
                                $inscripcion->nota_aprobacion = $informacion_carrera->nota_aprobacion;
                                $inscripcion->troncal = $asignatura->troncal;
                                //$inscripcion->aprobo = 'Si', 'No', 'Cursando';
                                $inscripcion->estado = 'Cursando';  // Cuando acaba semestre/gestion cambiar a Finalizado
                                $inscripcion->save();
                                // en un array capturar los id's de las inscripciones realizadas - PENDIENTE
                                array_push($array_inscripciones, $inscripcion->id);
                                // Buscaremos si existe un docente ya asignado a esta materia
                                $docente = NotasPropuesta::where('asignatura_id', $asignatura->id)
                                                        ->where('turno_id', $request->$datos_turno)
                                                        ->where('paralelo', $request->$datos_paralelo)
                                                        ->where('anio_vigente', $request->$datos_gestion)
                                                        ->first();
                                // Por cada materia inscrita, ingresamos 4 registros correspondientes a los 4 bimestres
                                for($i=1; $i<=4; $i++){
                                    // Inscripcion en la tabla notas
                                    $nota = new Nota();
                                    $nota->user_id = Auth::user()->id;
                                    $nota->resolucion_id = $informacion_carrera->resolucion_id;
                                    $nota->inscripcion_id = $inscripcion->id;
                                    if($docente){
                                        $nota->docente_id = $docente->docente_id;
                                    }
                                    $nota->persona_id = $persona->id;
                                    $nota->asignatura_id = $asignatura->id;
                                    $nota->turno_id = $request->$datos_turno;
                                    $nota->paralelo = $request->$datos_paralelo;
                                    $nota->anio_vigente = $request->$datos_gestion;
                                    $nota->trimestre = $i;
                                    $nota->fecha_registro = $request->fecha_inscripcion;
                                    $nota->nota_aprobacion = $informacion_carrera->nota_aprobacion;
                                    $nota->save();
                                }
                            }
                        }
                    */
                }
            }
        }
        return redirect('Persona/ver_detalle/'.$persona->id);
    }


    public function reinscripcion($persona_id, $carrera_id)
    {
        $estudiante = Persona::find($persona_id);
        $carrera    = Carrera::find($carrera_id);
        $turnos     = Turno::get();
        // Buscamos el anioIngreso, para hacer seguimiento de la malla curricular de ese anioIngreso
        // $anioIngreso   = $estudiante->anio_vigente;
        $anioIngreso    = CarrerasPersona::where('persona_id', $estudiante->id)
                                        ->where('carrera_id', $carrera->id)
                                        ->min('anio_vigente');
        if(!$anioIngreso)
        {
            $anioIngreso    = Inscripcione::where('persona_id', $estudiante->id)
                                        ->where('carrera_id', $carrera->id)
                                        ->min('anio_vigente');
            if(!$anioIngreso)
            {
                $anioIngreso    = date('Y');
            }
        }
        // Tenemos que ver el caso en el que haya aprobado todo
        // Tenemos que ver el caso en el que haya aprobado algunas y reprobado otras
        // Vemos en que gestion se encuentra este alumno
        $gestionActual  = CarrerasPersona::where('carrera_id', $carrera->id)
                                        ->where('persona_id', $estudiante->id)
                                        ->max('gestion');
        $gestionActual  = ($gestionActual ? $gestionActual : '1');

        // NUEVA OPCION
        // Vemos cual es su maximo anio_vigente de este alumno
        $anioVigente    = CarrerasPersona::where('carrera_id', $carrera->id)
                                        ->where('persona_id', $estudiante->id)
                                        ->where('gestion', $gestionActual)
                                        ->max('anio_vigente');
        $anioVigente    = ($anioVigente ? $anioVigente : date('Y'));
        // Buscamos la gestion X con anio_vigente X
        $gestion        = CarrerasPersona::where('carrera_id', $carrera->id)
                                        ->where('persona_id', $estudiante->id)
                                        ->where('gestion', $gestionActual)
                                        ->where('anio_vigente', $anioVigente)
                                        ->first();
        
        // Ahora veremos si aprobo la gestion X con anio_vigente X
        if($gestion->estado == 'APROBO')
        {
            $gestionActual = $gestionActual + 1;
            // Buscamos las asignaturas que esta inscrito
            $asignaturasCursando    = Inscripcione::where('carrera_id', $carrera->id)
                                                ->where('persona_id', $estudiante->id)
                                                ->where('estado', 'Cursando')
                                                ->get();
            $arrayCursando  = array();
            foreach($asignaturasCursando as $cursando)
            {
                array_push($arrayCursando, $cursando->asignatura_id);
            }
            // Buscaremos a las materias que pertenecen a la siguiente gestion
            $pendientes = Asignatura::where('carrera_id', $carrera->id)
                                    ->where('gestion', $gestionActual)
                                    ->where('anio_vigente', $anioIngreso)
                                    ->whereNotIn('id', $asignaturasCursando)
                                    ->get();
        }
        else
        {
            // Buscamos las asignaturas que esta inscrito
            $asignaturasCursando    = Inscripcione::where('carrera_id', $carrera->id)
                                                ->where('persona_id', $estudiante->id)
                                                ->where('estado', 'Cursando')
                                                ->get();
            $arrayCursando  = array();
            foreach($asignaturasCursando as $cursando)
            {
                array_push($arrayCursando, $cursando->asignatura_id);
            }
            $pendientes = Asignatura::where('carrera_id', $carrera->id)
                                    ->where('gestion', $gestionActual)
                                    ->where('anio_vigente', $anioIngreso)
                                    ->whereNotIn('id', $asignaturasCursando)
                                    ->get();
        }

        /* OPCION 2
            // Pare eso buscamos la cantidad de asignaturas aprobadas y comparamos con las restantes
            $cantidadAprobadas  = Inscripcione::where('carrera_id', $carrera->id)
                                            ->where('persona_id', $estudiante->id)
                                            ->where('gestion', $gestionActual)
                                            ->where('aprobo', 'Si')
                                            ->where('estado', 'Finalizado')
                                            ->count();
            $cantidadCurricula  = Asignatura::where('carrera_id', $carrera->id)
                                            ->where('anio_vigente', $anioIngreso)
                                            ->where('gestion', $gestionActual)
                                            ->count();
            if($cantidadAprobadas == $cantidadCurricula)    // Si aprobo todo
            {
                // Pasa a la siguiente gestion
                // Buscamos las asignaturas que pertenecen a la siguiente gestion
                // Primero subimos una gestion
                $gestionActual = $gestionActual + 1;
                // Buscamos las asignaturas que esta inscrito
                $asignaturasCursando    = Inscripcione::where('carrera_id', $carrera->id)
                                                    ->where('persona_id', $estudiante->id)
                                                    ->where('estado', 'Cursando')
                                                    ->get();
                $arrayCursando    = array();
                foreach($asignaturasCursando as $cursando)
                {
                    array_push($arrayCursando, $cursando->asignatura_id);
                }
                // Buscaremos a las materias que pertenecen a la siguiente gestion
                $pendientes = Asignatura::where('carrera_id', $carrera->id)
                                        ->where('gestion', $gestionActual)
                                        ->where('anio_vigente', $anioIngreso)
                                        ->whereNotIn('id', $asignaturasCursando)
                                        ->get();
            }
            if($cantidadAprobadas < $cantidadCurricula)     // Si reprobo alguno o todo
            {
                
                // Se queda en la misma gestion
                // Buscamos las asignaturas que le faltan aprobar
                $asignaturasAprobadas   = Inscripcione::where('carrera_id', $carrera->id)
                                                    ->where('persona_id', $estudiante->id)
                                                    ->where('gestion', $gestionActual)
                                                    ->where('aprobo', 'Si')
                                                    ->where('estado', 'Finalizado')
                                                    ->get();
                $arrayAprobadas    = array();
                foreach($asignaturasAprobadas as $aprobada)
                {
                    array_push($arrayAprobadas, $aprobada->asignatura_id);
                }
                // Buscamos las asignaturas que esta inscrito
                $asignaturasCursando    = Inscripcione::where('carrera_id', $carrera->id)
                                                    ->where('persona_id', $estudiante->id)
                                                    ->where('estado', 'Cursando')
                                                    ->get();
                $arrayCursando    = array();
                foreach($asignaturasCursando as $cursando)
                {
                    array_push($arrayCursando, $cursando->asignatura_id);
                }
                $pendientes = Asignatura::where('carrera_id', $carrera->id)
                                        ->where('gestion', $gestionActual)
                                        ->where('anio_vigente', $anioIngreso)
                                        ->whereNotIn('id', $arrayAprobadas)
                                        ->whereNotIn('id', $arrayCursando)
                                        ->get();
            }
        */
        /*
            // Buscaremos las carreras en las que esta inscrito el Estudiante X
            $carreras_estudiante = Carrera::where('id', $carrera_id)->get();
            // Crearemos la variable $array_materias
            $array_materias = array();
            // Crearemos la variable $array_aprobadas
            $array_aprobadas = array();
            // Crearemos la variable $array_cursando
            $array_cursando = array();
            // Crearemos la variable $array_carreras
            $array_carreras = array();
            // Almacenaremos en $array_carreras, el id de las carreras en las que esta inscrito el estudiante
            foreach($carreras_estudiante as $carrera){
                array_push($array_carreras, $carrera->id);
            }
            // Por cada carrera que tenga el estudiante
            foreach($array_carreras as $carrera){
                // if($carrera == 3){              //  ELIMINAR     HECHO PARA PRUEBAS
                //     continue;                   //  ELIMINAR     HECHO PARA PRUEBAS
                // }                               //  ELIMINAR     HECHO PARA PRUEBAS
                // En una variable almacenaremos los datos de la carrera
                $informacion_carrera = Carrera::find($carrera);
                // Hallaremos la maxima gestion que aprobo el alumno en la carrera X
                $maxima_gestion = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                                ->where('persona_id', $estudiante->id)
                                                ->where('aprobo', 'Si')
                                                ->max('gestion');
                // Si no hubiera valor en maxima gestion, quiere decir que no aprobó nada
                if(!$maxima_gestion){
                    // Por tanto se asignara como que sigue en la gestión 1
                    $maxima_gestion = 1;
                }
                // Hallaremos el maximo semestre que aprobo el alumno en la carrera X
                $maximo_semestre = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                                ->where('persona_id', $estudiante->id)
                                                ->where('aprobo', 'Si')
                                                ->max('semestre');
                // Si no hubiera valor en maximo semestre, puede ser que el modo de inscripcion se lleva por gestiones o no aprobó nada
                if(!$maximo_semestre){
                    // Preguntaremos si en esa maxima_gestion de la carrera X se encuentran valores en semestre
                    $tipo_ciclo = Asignatura::where('carrera_id', $informacion_carrera->id)
                                            ->where('anio_vigente', $anio_ingreso)
                                            ->where('gestion', $maxima_gestion)
                                            ->first();
                    // Si el ciclo es Semestral no aprobó nada el estudiante, caso contrario la gestion se lleva de forma anual y no existe un valor en $maximo_semestre
                    if($tipo_ciclo->ciclo == 'Semestral'){
                        // Por tanto se asignara como que sigue en el semestre 1
                        $maximo_semestre = 1;
                    }
                }
                // Ahora procederemos a la busqueda de sus ultimas materias aprobadas
                $aprobadas = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                        ->where('persona_id', $estudiante->id)
                                        ->where('aprobo', 'Si')
                                        ->where('gestion', $maxima_gestion);
                if($maximo_semestre){
                    $aprobadas = $aprobadas->where('semestre', $maximo_semestre);
                }
                $total_aprobadas = $aprobadas->count();
                // Por otra parte hallaremos las materias de esa carrera X en la gestion X y semestre X
                $materias_curricula = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                ->where('anio_vigente', $anio_ingreso)
                                                ->where('gestion', $maxima_gestion);
                if($maximo_semestre){
                    $materias_curricula = $materias_curricula->where('semestre', $maximo_semestre);
                }
                $total_curricula = $materias_curricula->count();
                // Comprobaremos que sean iguales, para enviar las asignaturas que ahora le tocan
                if($total_aprobadas == $total_curricula){
                    // Si son iguales no se debe ninguna materia, por tanto se procede a la siguiente gestion/semestre
                    // Veremos si hay valor en $maximo_semestre
                    if($maximo_semestre){
                        // Como existe un valor, entonces la gestion se lleva por semestres
                        if($maximo_semestre == 1){
                            // Pasamos al siguiente semestre
                            $maximo_semestre = $maximo_semestre + 1;
                            $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                    ->where('anio_vigente', $anio_ingreso)
                                                    ->where('gestion', $maxima_gestion)
                                                    ->where('semestre', $maximo_semestre)
                                                    ->get();
                            // Pasaremos en un array las materias pendientes
                            foreach($pendientes as $materia){
                                array_push($array_materias, $materia->id);
                            }
                            // Ahora buscaremos materias que este cursando para descartarlas
                            $actuales = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                                    ->where('persona_id', $estudiante->id)
                                                    ->where('estado', 'Cursando')
                                                    ->get();
                            // Pasaremos en un array las materias que actualmente esta cursando el estudiante X
                            foreach($actuales as $materia){
                                array_push($array_cursando, $materia->asignatura_id);
                            }
                        }else{
                            // El semestre es 2 por tanto, pasamos a la siguiente gestion
                            $maxima_gestion = $maxima_gestion + 1;
                            // Buscaremos los pendientes de esa gestion
                            $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                    ->where('anio_vigente', $anio_ingreso)
                                                    ->where('gestion', $maxima_gestion)
                                                    //->where('semestre', $maximo_semestre)
                                                    ->first();
                            // Si tiene materias pendientes, si no tiene finalizo su carrera
                            if($pendientes){
                                // Tiene pendientes, preguntaremos si
                                if($pendientes->ciclo == 'Semestral'){
                                    // Pasamos al siguiente semestre que sera 1 de nuevo
                                    $maximo_semestre = 1;
                                    $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                            ->where('anio_vigente', $anio_ingreso)
                                                            ->where('gestion', $maxima_gestion)
                                                            ->where('semestre', $maximo_semestre)
                                                            ->get();
                                }else{
                                    // Es Anual por tanto
                                    $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                            ->where('anio_vigente', $anio_ingreso)
                                                            ->where('gestion', $maxima_gestion)
                                                            ->get();
                                }
                                // Pasaremos en un array las materias pendientes
                                foreach($pendientes as $materia){
                                    array_push($array_materias, $materia->id);
                                }
                                // Tambien debemos enviar las materias que esta cursando actualmente
                                $actuales = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                                        ->where('persona_id', $estudiante->id)
                                                        ->where('estado', 'Cursando')
                                                        ->get();
                                // Pasaremos en un array las materias que actualmente esta cursando el estudiante X
                                foreach($actuales as $materia){
                                    array_push($array_cursando, $materia->asignatura_id);
                                }
                            }
                        }
                    }else{
                        // Como no existe un valor, entonces la gestion se lleva de forma Anual
                        // Subiremos una gestion y buscaremos su hay pendientes
                        $maxima_gestion = $maxima_gestion + 1;
                        // Buscaremos los pendientes de esa gestion
                        $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                ->where('anio_vigente', $anio_ingreso)                        
                                                ->where('gestion', $maxima_gestion)
                                                ->first();
                        // Si tiene materias pendientes, si no tiene finalizo su carrera
                        if($pendientes){
                            // Tiene pendientes, preguntaremos si
                            if($pendientes->ciclo == 'Semestral'){
                                // Pasamos al siguiente semestre que sera 1 de nuevo
                                $maximo_semestre = 1;
                                $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                        ->where('anio_vigente', $anio_ingreso)
                                                        ->where('gestion', $maxima_gestion)
                                                        ->where('semestre', $maximo_semestre)
                                                        ->get();
                            }else{
                                // Es Anual por tanto
                                $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                        ->where('anio_vigente', $anio_ingreso)
                                                        ->where('gestion', $maxima_gestion)
                                                        ->get();
                            }
                            // Pasaremos en un array las materias pendientes
                            foreach($pendientes as $materia){
                                array_push($array_materias, $materia->id);
                            }
                            // Sera necesario agregar tambien a las materias que se estan cursando
                            $actuales = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                                    ->where('persona_id', $estudiante->id)
                                                    ->where('estado', 'Cursando')
                                                    ->get();
                            // Pasaremos en un array las materias que actualmente esta cursando el estudiante X
                            foreach($actuales as $materia){
                            array_push($array_cursando, $materia->asignatura_id);
                            }
                        }
                    }
                }else{
                    // Tiene materias pendientes en esa gestion/semestre
                    // Recuperaremos las que tiene pendientes 
                    $aprobadas = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                            ->where('persona_id', $estudiante->id)
                                            ->where('aprobo', 'Si')
                                            ->where('gestion', $maxima_gestion);
                    if($maximo_semestre){
                        $aprobadas = $aprobadas->where('semestre', $maximo_semestre);
                    }
                    $total_aprobadas = $aprobadas->get();
                    foreach($total_aprobadas as $materias){
                        array_push($array_aprobadas, $materias->asignatura_id);
                    }
                    // Por otra parte hallaremos las materias de esa carrera X en la gestion X y semestre X
                    $materias_curricula = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                    ->whereNotIn('id', $array_aprobadas)
                                                    ->where('anio_vigente', $anio_ingreso)
                                                    ->where('gestion', $maxima_gestion);
                    if($maximo_semestre){
                        $materias_curricula = $materias_curricula->where('semestre', $maximo_semestre);
                    }
                    $total_curricula = $materias_curricula->get();
                    
                    // Pasaremos en un array las materias pendientes
                    foreach($total_curricula as $materia){
                        array_push($array_materias, $materia->id);
                    }
                    // Sera necesario agregar a las materias que se estan cursando?? SI
                    $actuales = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                            ->where('persona_id', $estudiante->id)
                                            ->where('estado', 'Cursando')
                                            ->get();
                    // Pasaremos en un array las materias que actualmente esta cursando el estudiante X
                    foreach($actuales as $materia){
                        array_push($array_cursando, $materia->asignatura_id);
                    }
                    // Pendiente de Pruebas
                }
            }
            $pendientes = Asignatura::whereIn('id', $array_materias)
                                    ->whereNotIn('id', $array_cursando)     // Pendiente de Pruebas
                                    ->orderBy('id')
                                    ->get();
        */
        return view('inscripcion.reinscripcion')->with(compact('estudiante', 'pendientes', 'turnos', 'anioIngreso'));
    }

    /*
    public function reinscripcion($id)
    {
        $estudiante = Persona::find($id);
        $turnos = Turno::get();
        // Buscaremos las carreras en las que esta inscrito el Estudiante X
        $carreras_estudiante = Inscripcione::where('persona_id', $id)
                                            ->groupBy('carrera_id')
                                            ->select('carrera_id')
                                            ->get();
        // Crearemos la variable $array_materias
        $array_materias = array();
        // Crearemos la variable $array_aprobadas
        $array_aprobadas = array();
        // Crearemos la variable $array_cursando
        $array_cursando = array();
        // Crearemos la variable $array_carreras
        $array_carreras = array();
        // Almacenaremos en $array_carreras, el id de las carreras en las que esta inscrito el estudiante
        foreach($carreras_estudiante as $carrera){
            array_push($array_carreras, $carrera->carrera_id);
        }
        // Por cada carrera que tenga el estudiante
        foreach($array_carreras as $carrera){
            // if($carrera == 3){              //  ELIMINAR     HECHO PARA PRUEBAS
            //     continue;                   //  ELIMINAR     HECHO PARA PRUEBAS
            // }                               //  ELIMINAR     HECHO PARA PRUEBAS
            // En una variable almacenaremos los datos de la carrera
            $informacion_carrera = Carrera::find($carrera);
            // Hallaremos la maxima gestion que aprobo el alumno en la carrera X
            $maxima_gestion = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                            ->where('persona_id', $estudiante->id)
                                            ->where('aprobo', 'Si')
                                            ->max('gestion');
            // Si no hubiera valor en maxima gestion, quiere decir que no aprobó nada
            if(!$maxima_gestion){
                // Por tanto se asignara como que sigue en la gestión 1
                $maxima_gestion = 1;
            }
            // Hallaremos el maximo semestre que aprobo el alumno en la carrera X
            $maximo_semestre = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                            ->where('persona_id', $estudiante->id)
                                            ->where('aprobo', 'Si')
                                            ->max('semestre');
            // Si no hubiera valor en maximo semestre, puede ser que el modo de inscripcion se lleva por gestiones o no aprobó nada
            if(!$maximo_semestre){
                // Preguntaremos si en esa maxima_gestion de la carrera X se encuentran valores en semestre
                $tipo_ciclo = Asignatura::where('carrera_id', $informacion_carrera->id)
                                        ->where('anio_vigente', $informacion_carrera->anio_vigente)
                                        ->where('gestion', $maxima_gestion)
                                        ->first();
                // Si el ciclo es Semestral no aprobó nada el estudiante, caso contrario la gestion se lleva de forma anual y no existe un valor en $maximo_semestre
                if($tipo_ciclo->ciclo == 'Semestral'){
                    // Por tanto se asignara como que sigue en el semestre 1
                    $maximo_semestre = 1;
                }
            }
            // Ahora procederemos a la busqueda de sus ultimas materias aprobadas
            $aprobadas = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                    ->where('persona_id', $estudiante->id)
                                    ->where('aprobo', 'Si')
                                    ->where('gestion', $maxima_gestion);
            if($maximo_semestre){
                $aprobadas = $aprobadas->where('semestre', $maximo_semestre);
            }
            $total_aprobadas = $aprobadas->count();
            // Por otra parte hallaremos las materias de esa carrera X en la gestion X y semestre X
            $materias_curricula = Asignatura::where('carrera_id', $informacion_carrera->id)
                                            ->where('anio_vigente', $informacion_carrera->anio_vigente)
                                            ->where('gestion', $maxima_gestion);
            if($maximo_semestre){
                $materias_curricula = $materias_curricula->where('semestre', $maximo_semestre);
            }
            $total_curricula = $materias_curricula->count();
            // Comprobaremos que sean iguales, para enviar las asignaturas que ahora le tocan
            if($total_aprobadas == $total_curricula){
                // Si son iguales no se debe ninguna materia, por tanto se procede a la siguiente gestion/semestre
                // Veremos si hay valor en $maximo_semestre
                if($maximo_semestre){
                    // Como existe un valor, entonces la gestion se lleva por semestres
                    if($maximo_semestre == 1){
                        // Pasamos al siguiente semestre
                        $maximo_semestre = $maximo_semestre + 1;
                        $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                ->where('anio_vigente', $informacion_carrera->anio_vigente)
                                                ->where('gestion', $maxima_gestion)
                                                ->where('semestre', $maximo_semestre)
                                                ->get();
                        // Pasaremos en un array las materias pendientes
                        foreach($pendientes as $materia){
                            array_push($array_materias, $materia->id);
                        }
                        // Ahora buscaremos materias que este cursando para descartarlas
                        $actuales = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                                ->where('persona_id', $estudiante->id)
                                                ->where('estado', 'Cursando')
                                                ->get();
                        // Pasaremos en un array las materias que actualmente esta cursando el estudiante X
                        foreach($actuales as $materia){
                            array_push($array_cursando, $materia->asignatura_id);
                        }
                    }else{
                        // El semestre es 2 por tanto, pasamos a la siguiente gestion
                        $maxima_gestion = $maxima_gestion + 1;
                        // Buscaremos los pendientes de esa gestion
                        $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                ->where('anio_vigente', $informacion_carrera->anio_vigente)
                                                ->where('gestion', $maxima_gestion)
                                                //->where('semestre', $maximo_semestre)
                                                ->first();
                        // Si tiene materias pendientes, si no tiene finalizo su carrera
                        if($pendientes){
                            // Tiene pendientes, preguntaremos si
                            if($pendientes->ciclo == 'Semestral'){
                                // Pasamos al siguiente semestre que sera 1 de nuevo
                                $maximo_semestre = 1;
                                $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                        ->where('anio_vigente', $informacion_carrera->anio_vigente)
                                                        ->where('gestion', $maxima_gestion)
                                                        ->where('semestre', $maximo_semestre)
                                                        ->get();
                            }else{
                                // Es Anual por tanto
                                $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                        ->where('anio_vigente', $informacion_carrera->anio_vigente)
                                                        ->where('gestion', $maxima_gestion)
                                                        ->get();
                            }
                            // Pasaremos en un array las materias pendientes
                            foreach($pendientes as $materia){
                                array_push($array_materias, $materia->id);
                            }
                            // Tambien debemos enviar las materias que esta cursando actualmente
                            $actuales = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                                    ->where('persona_id', $estudiante->id)
                                                    ->where('estado', 'Cursando')
                                                    ->get();
                            // Pasaremos en un array las materias que actualmente esta cursando el estudiante X
                            foreach($actuales as $materia){
                                array_push($array_cursando, $materia->asignatura_id);
                            }
                        }
                    }
                }else{
                    // Como no existe un valor, entonces la gestion se lleva de forma Anual
                    // Subiremos una gestion y buscaremos su hay pendientes
                    $maxima_gestion = $maxima_gestion + 1;
                    // Buscaremos los pendientes de esa gestion
                    $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                            ->where('anio_vigente', $informacion_carrera->anio_vigente)                        
                                            ->where('gestion', $maxima_gestion)
                                            ->first();
                    // Si tiene materias pendientes, si no tiene finalizo su carrera
                    if($pendientes){
                        // Tiene pendientes, preguntaremos si
                        if($pendientes->ciclo == 'Semestral'){
                            // Pasamos al siguiente semestre que sera 1 de nuevo
                            $maximo_semestre = 1;
                            $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                    ->where('anio_vigente', $informacion_carrera->anio_vigente)
                                                    ->where('gestion', $maxima_gestion)
                                                    ->where('semestre', $maximo_semestre)
                                                    ->get();
                        }else{
                            // Es Anual por tanto
                            $pendientes = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                    ->where('anio_vigente', $informacion_carrera->anio_vigente)
                                                    ->where('gestion', $maxima_gestion)
                                                    ->get();
                        }
                        // Pasaremos en un array las materias pendientes
                        foreach($pendientes as $materia){
                            array_push($array_materias, $materia->id);
                        }
                        // Sera necesario agregar tambien a las materias que se estan cursando
                        $actuales = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                                ->where('persona_id', $estudiante->id)
                                                ->where('estado', 'Cursando')
                                                ->get();
                        // Pasaremos en un array las materias que actualmente esta cursando el estudiante X
                        foreach($actuales as $materia){
                        array_push($array_cursando, $materia->asignatura_id);
                        }
                    }
                }
            }else{
                // Tiene materias pendientes en esa gestion/semestre
                // Recuperaremos las que tiene pendientes 
                $aprobadas = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                        ->where('persona_id', $estudiante->id)
                                        ->where('aprobo', 'Si')
                                        ->where('gestion', $maxima_gestion);
                if($maximo_semestre){
                    $aprobadas = $aprobadas->where('semestre', $maximo_semestre);
                }
                $total_aprobadas = $aprobadas->get();
                foreach($total_aprobadas as $materias){
                    array_push($array_aprobadas, $materias->asignatura_id);
                }
                // Por otra parte hallaremos las materias de esa carrera X en la gestion X y semestre X
                $materias_curricula = Asignatura::where('carrera_id', $informacion_carrera->id)
                                                ->whereNotIn('id', $array_aprobadas)
                                                ->where('anio_vigente', $informacion_carrera->anio_vigente)
                                                ->where('gestion', $maxima_gestion);
                if($maximo_semestre){
                    $materias_curricula = $materias_curricula->where('semestre', $maximo_semestre);
                }
                $total_curricula = $materias_curricula->get();
                
                // Pasaremos en un array las materias pendientes
                foreach($total_curricula as $materia){
                    array_push($array_materias, $materia->id);
                }
                // Sera necesario agregar a las materias que se estan cursando?? SI
                $actuales = Inscripcione::where('carrera_id', $informacion_carrera->id)
                                        ->where('persona_id', $estudiante->id)
                                        ->where('estado', 'Cursando')
                                        ->get();
                // Pasaremos en un array las materias que actualmente esta cursando el estudiante X
                foreach($actuales as $materia){
                    array_push($array_cursando, $materia->asignatura_id);
                }
                // Pendiente de Pruebas
            }
        }
        $pendientes = Asignatura::whereIn('id', $array_materias)
                                ->whereNotIn('id', $array_cursando)     // Pendiente de Pruebas
                                ->orderBy('id')
                                ->get();
        return view('inscripcion.reinscripcion0')->with(compact('estudiante', 'pendientes', 'turnos')); // CAMBIAR NOMBRE DE VISTA, PRIMERO PRUEBAS
    }
    */

    public function inscribirCarrera(Request $request)
    {
        // Verificaremos que todos los elementos necesarios existan para la inscripcion del alumno
        if($request->persona_id && $request->nueva_carrera && $request->nuevo_turno && $request->nuevo_paralelo && $request->nueva_gestion && $request->nueva_fecha_inscripcion)
        {
            $persona = Persona::find($request->persona_id);
            // Verificamos que en la nueva carrera que vaya a inscribirse, no existan los registros
            $carreras_persona   = CarrerasPersona::where('carrera_id', $request->nueva_carrera)
                                                ->where('persona_id', $request->persona_id)
                                                ->where('turno_id', $request->nuevo_turno)
                                                ->where('paralelo', $request->nuevo_paralelo)
                                                ->where('anio_vigente', $request->nueva_gestion)
                                                ->first();
            // Si no se encuentra ningun valor, se crea
            if(!$carreras_persona)
            {
                // Se crea un nuevo registro
                $carreras_persona                       = new CarrerasPersona();
                $carreras_persona->user_id              = Auth::user()->id;
                $carreras_persona->carrera_id           = $request->nueva_carrera;
                $carreras_persona->persona_id           = $persona->id;
                $carreras_persona->turno_id             = $request->nuevo_turno;
                $carreras_persona->gestion              = 1;
                $carreras_persona->paralelo             = $request->nuevo_paralelo;
                $carreras_persona->fecha_inscripcion    = $request->nueva_fecha_inscripcion;
                $carreras_persona->anio_vigente         = $request->nueva_gestion;
                $carreras_persona->sexo                 = $persona->sexo;
                $carreras_persona->vigencia             = 'Vigente';
                //$carreras_persona->estado             = '';   APROBO/REPROBO/ABANDONO/NULL
                $carreras_persona->save();
            }
            // Verificaremos que el alumno no este inscrito en la carrera deseada
            $verificacion = Inscripcione::where('carrera_id', $request->nueva_carrera)
                                        ->where('turno_id', $request->nuevo_turno)
                                        ->where('persona_id', $request->persona_id)
                                        ->where('paralelo', $request->nuevo_paralelo)
                                        ->first();
            // Si no se encuentra un registro
            if(!$verificacion)
            {
                // Buscaremos a las materias que pertenecen a la gestion 1, de la asignatura X con anio_vigente X
                $asignaturas    = Asignatura::where('carrera_id', $request->nueva_carrera)
                                            ->where('gestion', 1)
                                            ->where('anio_vigente', $request->nueva_gestion)
                                            ->get();
                // Inscribiremos a las asignaturas que se capturaron en la varialbe $asignatura
                foreach($asignaturas as $asignatura)
                {
                    // Verificamos que no este inscrito, e inscribimos
                    $registro   = Inscripcione::where('carrera_id', $asignatura->carrera_id)
                                            ->where('asignatura_id', $asignatura->id)
                                            ->where('turno_id', $request->nuevo_turno)
                                            ->where('persona_id', $persona->id)
                                            ->where('paralelo', $request->nuevo_paralelo)
                                            ->where('anio_vigente', $request->nueva_gestion)
                                            ->first();
                    // Si no existiera un registro creamos
                    if(!$registro)
                    {
                        $carrera = Carrera::find($request->nueva_carrera);     // MOD
                        // Resgistramos en la tabla inscripciones
                        $inscripcion                    = new Inscripcione();
                        $inscripcion->user_id           = Auth::user()->id;
                        $inscripcion->resolucion_id     = $carrera->resolucion_id;          // MOD
                        $inscripcion->carrera_id        = $request->nueva_carrera;
                        $inscripcion->asignatura_id     = $asignatura->id;
                        $inscripcion->turno_id          = $request->nuevo_turno;
                        $inscripcion->persona_id        = $persona->id;
                        $inscripcion->paralelo          = $request->nuevo_paralelo;
                        $inscripcion->semestre          = $asignatura->semestre;
                        $inscripcion->gestion           = $asignatura->gestion;
                        $inscripcion->anio_vigente      = $request->nueva_gestion;
                        $inscripcion->fecha_registro    = $request->nueva_fecha_inscripcion;
                        $inscripcion->nota_aprobacion   = $carrera->nota_aprobacion;        // MOD
                        $inscripcion->troncal           = $asignatura->troncal;
                        //$inscripcion->aprobo          = 'Si', 'No', 'Cursando';
                        $inscripcion->estado            = 'Cursando';  // Cuando acaba semestre/gestion cambiar a Finalizado
                        $inscripcion->save();
                        // Crearemos las notas correspondientes a esta inscripcion pero antes buscaremos si existe un docente ya asignado a esta asignatura
                        $docente    = NotasPropuesta::where('asignatura_id', $asignatura->id)
                                                    ->where('turno_id', $request->nuevo_turno)
                                                    ->where('paralelo', $request->nuevo_paralelo)
                                                    ->where('anio_vigente', $request->nueva_gestion)
                                                    ->first();
                        // Por cada materia inscrita, ingresamos 4 registros correspondientes a los 4 bimestres
                        for($i=1; $i<=4; $i++){
                            // Resgistramos en la tabla notas
                            $nota                   = new Nota();
                            $nota->user_id          = Auth::user()->id;
                            $nota->resolucion_id    = $carrera->resolucion_id;          // MOD
                            $nota->inscripcion_id   = $inscripcion->id;
                            if($docente){
                                $nota->docente_id   = $docente->docente_id;
                            }
                            $nota->persona_id       = $persona->id;
                            $nota->asignatura_id    = $asignatura->id;
                            $nota->turno_id         = $request->nuevo_turno;
                            $nota->paralelo         = $request->nuevo_paralelo;
                            $nota->anio_vigente     = $request->nueva_gestion;
                            $nota->trimestre        = $i;
                            $nota->fecha_registro   = $request->nueva_fecha_inscripcion;
                            $nota->nota_aprobacion  = $carrera->nota_aprobacion;        // MOD
                            $nota->save();
                        }
                    }
                }
                /*
                    // Procedemos a inscribir a la carrera deseada
                    // Tenemos que ver como se lleva a cabo la 1era gestion, si es por semestres o anual
                    $info_primera_gestion = Asignatura::where('carrera_id', $request->nueva_carrera)
                                                    ->where('gestion', 1)
                                                    ->where('ciclo', 'Semestral')
                                                    ->first();
                    // Si existe valor en $info_primera_gestion entonces la gestion esta divida en semestres, caso contrario es anual
                    if($info_primera_gestion)
                    {
                        // Procedemos a la inscripcion de forma SEMESTRAL
                        // Leeremos la curricula de la tabla Asignaturas y como es una nueva inscripcion capturamos las primeras asignaturas de la carrera
                        $asignaturas_carrera = Asignatura::where('carrera_id', $request->nueva_carrera)
                                                        ->where('anio_vigente', $request->nueva_gestion)
                                                        ->where('gestion', 1)
                                                        ->where('semestre', 1)
                                                        ->get();
                    }
                    else
                    {
                        // Procedemos a la inscripcion de forma ANUAL
                        // Leeremos la curricula de la tabla Asignaturas y como es una nueva inscripcion capturamos las primeras asignaturas de la carrera
                        $asignaturas_carrera = Asignatura::where('carrera_id', $request->nueva_carrera)
                                                        ->where('anio_vigente', $request->nueva_gestion)
                                                        ->where('gestion', 1)
                                                        ->get();
                    }
                    // Crearemos un array para guardar los id's que se inscribiran
                    $array_inscripciones = array();
                    // Por cada asignatura encontrada
                    foreach($asignaturas_carrera as $asignatura)
                    {
                        // Verificaremos que no exista un registro con estas variables
                        $registro = Inscripcione::where('carrera_id', $asignatura->carrera_id)
                                                ->where('asignatura_id', $asignatura->id)
                                                ->where('turno_id', $request->nuevo_turno)
                                                ->where('persona_id', $persona->id)
                                                //->where('nota', '>', 60)
                                                ->first();
                        if(!$registro)
                        {
                            // Si no existe un registro con las mismas variables, procedemos a registrar en las tablas inscripciones y notas
                            // Antes buscaremos la informacion de la carrera
                            $informacion_carrera = Carrera::find($request->nueva_carrera);
                            // Inscripcion en la tabla inscripciones
                            $inscripcion                    = new Inscripcione();
                            $inscripcion->user_id           = Auth::user()->id;
                            $inscripcion->resolucion_id     = $informacion_carrera->resolucion_id;
                            $inscripcion->carrera_id        = $request->nueva_carrera;
                            $inscripcion->asignatura_id     = $asignatura->id;
                            $inscripcion->turno_id          = $request->nuevo_turno;
                            $inscripcion->persona_id        = $persona->id;
                            $inscripcion->paralelo          = $request->nuevo_paralelo;
                            $inscripcion->semestre          = $asignatura->semestre;
                            $inscripcion->gestion           = $asignatura->gestion;
                            $inscripcion->anio_vigente      = $request->nueva_gestion;
                            $inscripcion->fecha_registro    = $request->nueva_fecha_inscripcion;
                            $inscripcion->nota_aprobacion   = $informacion_carrera->nota_aprobacion;
                            $inscripcion->troncal           = $asignatura->troncal;
                            //$inscripcion->aprobo          = 'Si', 'No', 'Cursando';
                            $inscripcion->estado            = 'Cursando';  // Cuando acaba semestre/gestion cambiar a Finalizado
                            $inscripcion->save();
                            // en un array capturar los id's de las inscripciones realizadas - PENDIENTE
                            array_push($array_inscripciones, $inscripcion->id);
                            // Buscaremos si existe un docente ya asignado a esta materia
                            $docente = NotasPropuesta::where('asignatura_id', $asignatura->id)
                                                    ->where('turno_id', $request->nuevo_turno)
                                                    ->where('paralelo', $request->nuevo_paralelo)
                                                    ->where('anio_vigente', $request->nueva_gestion)
                                                    ->first();
                            // Por cada materia inscrita, ingresamos 4 registros correspondientes a los 4 bimestres
                            for($i=1; $i<=4; $i++)
                            {
                                // Inscripcion en la tabla notas
                                $nota                   = new Nota();
                                $nota->user_id          = Auth::user()->id;
                                $nota->resolucion_id    = $informacion_carrera->resolucion_id;
                                $nota->inscripcion_id   = $inscripcion->id;
                                if($docente)
                                {
                                    $nota->docente_id   = $docente->docente_id;
                                }
                                $nota->persona_id       = $persona->id;
                                $nota->asignatura_id    = $asignatura->id;
                                $nota->turno_id         = $request->nuevo_turno;
                                $nota->paralelo         = $request->nuevo_paralelo;
                                $nota->anio_vigente     = $request->nueva_gestion;
                                $nota->trimestre        = $i;
                                $nota->fecha_registro   = $request->nueva_fecha_inscripcion;
                                $nota->nota_aprobacion  = $informacion_carrera->nota_aprobacion;
                                $nota->save();
                            }
                        }
                    }
                */
            }
        }
        return redirect('Persona/ver_detalle/'.$persona->id);
    }

    /*
    public function reinscripcion($id)
    {
        $estudiante = Persona::find($id);
        $turnos = Turno::get();
        // Veremos en que carreras esta inscrito el estudiante, para sacar las notas de aprobacion de sus respectivas resoluciones
        // Conseguir las carreras en las que esta inscrito el estudiante
        $array_carreras = array();
        // Creamos una variable array que almacenara los ids de las materias/inscripcion aprobadas y las que se cursan actualmente
        // para mostrar las materias que tiene por tomar
        $array_aprobadas = array();
        // Creamos un array sobre el cual se guardaran todas las materias para tomar
        $array_pendientes = array();
        // Buscaremos las carreras en las que esta inscrito el Estudiante X
        $carreras_estudiante = Inscripcione::where('persona_id', $id)
                                            ->groupBy('carrera_id')
                                            ->select('carrera_id')
                                            ->get();
        // Almacenaremos en $array_carreras, el id de las carreras en las que esta inscrito el estudiante
        foreach($carreras_estudiante as $carrera){
            array_push($array_carreras, $carrera->carrera_id);
        }
        // Ya que tenemos la(s) carrera(s) del estudiante, iteramos sobre esta para hallar todas sus materias aprobadas
        // foreach($array_carreras as $carrera){
        //     $informacion_carrera = Carrera::find($carrera);
        //     // Conseguir las materias que aprobó el estudiante
        //     $aprobadas = Inscripcione::where('persona_id', $id)
        //                             ->where('carrera_id', $informacion_carrera->id)
        //                             // ANALIZAR PARA CUANDO SE HAGA LA CONVALIDACION DE LA RESOLUCION MINISTERIAL, NOTA_APROBACION
        //                             ->where('aprobo', 'Si')
        //                             ->get();
        //     foreach($aprobadas as $materia){
        //         array_push($array_aprobadas, $materia->asignatura_id);
        //     }
        // }
        // Tambien se conseguira las materias que esta cursando el estudiante actualmente
        $cursando = Inscripcione::where('persona_id', $id)
                                ->where('estado', 'Cursando')
                                ->get();
        // Y se almacenara en el mismo $array_aprobadas las carreras que este cursando actualmente
        foreach($cursando as $materia){
            array_push($array_aprobadas, $materia->asignatura_id);
        }
        
        // Procedemos a la inscripcion, por cada carrera existente
        foreach($array_carreras as $carrera){
            // Sacamos la gestion maxima, gestion que tiene el estudiante con sus materias aprobadas
            $gestion = Inscripcione::where('persona_id', $id)
                                    ->where('carrera_id', $carrera)
                                    ->where('aprobo', 'Si')
                                    ->max('gestion');
            // Si no hubiera aprobado nada, por defecto estara en gestion 1
            if(!$gestion){
                $gestion = 1;
            }
            // Tenemos que ver como se lleva a cabo la gestion X, si es por semestres o anual
            $info_gestion_x = Asignatura::where('carrera_id', $carrera)
                                        ->where('gestion', $gestion)
                                        ->where('ciclo', 'Semestral')
                                        ->first();
            // Si existe valor en $info_gestion_x entonces la gestion esta divida en semestres, caso contrario es anual
            if($info_gestion_x){
                // Es semestral, debemos ver en que semestre se encuentra si es 1 o 2
                $semestre = Inscripcione::where('persona_id', $id)
                                        ->where('carrera_id', $carrera)
                                        ->where('gestion', $gestion)
                                        ->where('aprobo', 'Si')
                                        ->max('semestre');
                // Si no hubiera aprobado nada, por defecto estara en semestre 1
                if(!$semestre){
                    $semestre = 1;
                }
                // Para enviar las materias que tiene para tomar, debemos verificar que sus troncales 
                // de ese semestre y esa gestion, esten como aprobadas
                $materias_aprobadas_carrera = Inscripcione::where('carrera_id', $carrera)
                                                            ->where('persona_id', $id)
                                                            ->where('gestion', $gestion)
                                                            ->where('semestre', $semestre)
                                                            ->where('aprobo', 'Si')
                                                            ->get();
                foreach($materias_aprobadas_carrera as $materia){
                    array_push($array_aprobadas, $materia->asignatura_id);
                }
                // Haremos la busqueda de esas asignaturas pendientes en ese semestre
                $pendientes = Asignatura::where('carrera_id', $carrera)
                                        ->where('gestion', $gestion)
                                        ->where('semestre', $semestre)
                                        ->whereNotIn('id', $array_aprobadas)
                                        ->get();
                // Contaremos la cantidad que tiene para tomar
                $cantidad = count($pendientes);
                // Si la cantidad es = 0, si no tiene ninguna materia pendiente de ese semestre/gestion
                if($cantidad == 0){
                    // Si todas las que aprobo pertenecen a primer semestre
                    if($semestre == 1){
                        // Desplegara las materias que corresponden a segundo semestre
                        // Subiremos un semestre y hacer una nueva busqueda de pendientes
                        $semestre = $semestre + 1;
                        $pendientes = Asignatura::where('carrera_id', $carrera)
                                                ->where('gestion', $gestion)
                                                ->where('semestre', $semestre)
                                                ->whereNotIn('id', $array_aprobadas)
                                                ->get();
                    }else{
                        // El semestre es 2, entonces desplegara las materias que pertenecen a la siguiente gestion
                        // y volvera a evaluar si la gestion es semestral o anual
                        // Antes procedemos a subirle una gestion y hacer una nueva busqueda de pendientes
                        $gestion = $gestion + 1;
                        // y ver si esta gestione esta dividida en semestres o es anual
                        $info_gestion_x = Asignatura::where('carrera_id', $carrera)
                                                    ->where('gestion', $gestion)
                                                    ->where('ciclo', 'Semestral')
                                                    ->first();
                        if($info_gestion_x){
                            // es semestral
                            $pendientes = Asignatura::where('carrera_id', $carrera)
                                                    ->where('gestion', $gestion)
                                                    ->where('semestre', 1)      // debemos sacar el maximo de semestre
                                                    ->whereNotIn('id', $array_aprobadas)
                                                    ->get();
                        }else{
                            // es anual
                            $pendientes = Asignatura::where('carrera_id', $carrera)
                                                    ->where('gestion', $gestion)
                                                    ->whereNotIn('id', $array_aprobadas)
                                                    ->get();
                        }
                    }
                }
                // AQUI ACUMULAR PENDIENTES EN UN ARRAY_PENDIENTE
                foreach($pendientes as $pendiente){
                    array_push($array_pendientes, $pendiente->id);
                }
            }else{
                // Es Anual, procedemos a ver que materias de esa gestion tiene aprobadas y si estuviera cursando
                $materias_aprobadas_carrera = Inscripcione::where('carrera_id', $carrera)
                                                        ->where('persona_id', $id)
                                                        ->where('gestion', $gestion)
                                                        ->where('aprobo', 'Si')
                                                        ->get();
                // Adicionaremos en $array_aprobadas, las materias que tenga aprobadas de esa gestion
                foreach($materias_aprobadas_carrera as $materia){
                    array_push($array_aprobadas, $materia->asignatura_id);
                }
                // Haremos la busqueda de esas asignaturas pendientes en esa gestion
                $pendientes = Asignatura::where('carrera_id', $carrera)
                                        ->where('gestion', $gestion)
                                        ->whereNotIn('id', $array_aprobadas)
                                        ->get();
                // Contaremos la cantidad que tiene para tomar
                $cantidad = count($pendientes);
                if($cantidad == 0){
                    // No tiene materias pendientes en esa gestion, por tanto se sube una gestion
                    // y se busca todas las que tenga pendientes
                    $gestion = $gestion + 1;
                    $pendientes = Asignatura::where('carrera_id', $carrera)
                                            ->where('gestion', $gestion)
                                            ->whereNotIn('id', $array_aprobadas)
                                            ->get();
                }
                // AQUI ACUMULAR PENDIENTES EN UN ARRAY_PENDIENTE
                foreach($pendientes as $pendiente){
                    array_push($array_pendientes, $pendiente->id);
                }
            }
        }
        // Finalmente en pendientes almacenaremos todas las asignaturas que se encontraron que deberian poder tomarse por el alumno
        $pendientes = Asignatura::whereIn('id', $array_pendientes)
                                ->orderBy('id')
                                ->get();
        return view('inscripcion.reinscripcion0')->with(compact('estudiante', 'pendientes', 'turnos')); // CAMBIAR NOMBRE DE VISTA, PRIMERO PRUEBAS
    }
    */

    public function guarda_reinscripcion(Request $request)
    {
        // Si existen asignaturas enviadas
        $array_carreras = array();
        if($request->asignatura)
        {
            $llaves = array_keys($request->asignatura);
            // Por cada asignatura
            foreach($llaves as $ll)
            {
                $asignatura = Asignatura::find($request->asignatura[$ll]);
                // Almacenaremos en un array su info
                array_push($array_carreras, $asignatura->carrera_id);
                $informacion_carrera = Carrera::find($asignatura->carrera_id);
                // $turno_id = 'turno_'.$request->asignatura[$ll];
                // $paralelo = 'paralelo_'.$request->asignatura[$ll];
                
                // Verificamos que en la nueva carrera que vaya a inscribirse, no existan los registros
                $carreras_persona   = CarrerasPersona::where('persona_id', $request->persona_id)
                                                    ->where('carrera_id', $informacion_carrera->id)
                                                    // ->where('turno_id', $request->turno)
                                                    // ->where('gestion', $asignatura->gestion)
                                                    // ->where('paralelo', $request->paralelo)
                                                    ->where('anio_vigente', $request->gestion)
                                                    ->first();
                // Si no se encuentra ningun valor, se crea
                if(!$carreras_persona)
                {
                    $persona    = Persona::find($request->persona_id);
                    // Se crea un nuevo registro
                    $carreras_persona                       = new CarrerasPersona();
                    $carreras_persona->user_id              = Auth::user()->id;
                    $carreras_persona->carrera_id           = $asignatura->carrera_id;
                    $carreras_persona->persona_id           = $request->persona_id;
                    $carreras_persona->turno_id             = $request->turno;
                    $carreras_persona->gestion              = $asignatura->gestion;
                    $carreras_persona->paralelo             = $request->paralelo;
                    $carreras_persona->fecha_inscripcion    = $request->fecha_inscripcion;
                    $carreras_persona->anio_vigente         = $request->gestion;
                    $carreras_persona->sexo                 = $persona->sexo;
                    $carreras_persona->vigencia             = 'Vigente';
                    //$carreras_persona->estado             = '';   APROBO/REPROBO/ABANDONO/NULL
                    $carreras_persona->save();
                }
                // Verificaremos que no este registrada la asignatura
                $registro = Inscripcione::where('carrera_id', $asignatura->carrera_id)
                                        ->where('asignatura_id', $asignatura->id)
                                        ->where('turno_id', $request->turno)
                                        ->where('persona_id', $request->persona_id)
                                        ->where('estado', 'Cursando')
                                        ->first();
                // Si no esta registrada, se procede a la inscripcion
                if(!$registro)
                {
                    // Si no existe un registro con las mismas variables, procedemos a registrar en las tablas inscripciones y notas
                    // Inscripcion en la tabla inscripciones
                    $inscripcion                    = new Inscripcione();
                    $inscripcion->user_id           = Auth::user()->id;
                    $inscripcion->resolucion_id     = $informacion_carrera->resolucion_id;
                    $inscripcion->carrera_id        = $asignatura->carrera_id;
                    $inscripcion->asignatura_id     = $asignatura->id;
                    $inscripcion->turno_id          = $request->turno;
                    $inscripcion->persona_id        = $request->persona_id;
                    $inscripcion->paralelo          = $request->paralelo;
                    $inscripcion->semestre          = $asignatura->semestre;
                    $inscripcion->gestion           = $asignatura->gestion;
                    $inscripcion->anio_vigente      = $request->gestion;
                    $inscripcion->fecha_registro    = $request->fecha_inscripcion;
                    $inscripcion->nota_aprobacion   = $informacion_carrera->nota_aprobacion;
                    $inscripcion->troncal           = $asignatura->troncal;
                    $inscripcion->estado            = 'Cursando';  // Cuando acaba semestre/gestion cambiar a Finalizado
                    $inscripcion->save();
                    // Buscaremos si existe un docente ya asignado a esta materia
                    $docente = NotasPropuesta::where('asignatura_id', $asignatura->id)
                                            ->where('turno_id', $request->turno)
                                            ->where('paralelo', $request->paralelo)
                                            ->where('anio_vigente', $request->gestion)          //$request->$datos_gestion
                                            ->first();
                    // Por cada materia inscrita, ingresamos 4 registros correspondientes a los 4 bimestres
                    for($i=1; $i<=4; $i++)
                    {
                        // Inscripcion en la tabla notas
                        $nota                   = new Nota();
                        $nota->user_id          = Auth::user()->id;
                        $nota->resolucion_id    = $informacion_carrera->resolucion_id;
                        $nota->inscripcion_id   = $inscripcion->id;
                        if($docente)
                        {
                            $nota->docente_id   = $docente->docente_id;
                        }
                        $nota->persona_id       = $request->persona_id;
                        $nota->asignatura_id    = $asignatura->id;
                        $nota->turno_id         = $request->turno;
                        $nota->paralelo         = $request->paralelo;
                        $nota->anio_vigente     = $request->gestion;
                        $nota->trimestre        = $i;
                        $nota->fecha_registro   = $request->fecha_inscripcion;
                        $nota->nota_aprobacion  = $informacion_carrera->nota_aprobacion;
                        $nota->save();
                    }
                }
            }
            // // Aqui crearemos los registros de carreras_personas dependiendo de cuantas carreras se inscribio el estudiante X
            // $array_carreras = array_unique($array_carreras);
            // foreach($array_carreras as $carrera){
            //     // Finalmente por cada carrera reinscirta resgistramos en la tabla carreras_personas
            //     $carreras_persona = new CarrerasPersona();
            //     $carreras_persona->user_id = Auth::user()->id;
            //     $carreras_persona->carrera_id = $carrera;
            //     $carreras_persona->persona_id = $request->persona_id;
            //     $carreras_persona->turno_id = $request->turno;
            //     $carreras_persona->paralelo = $request->paralelo;
            //     $carreras_persona->fecha_inscripcion = $request->fecha_inscripcion;
            //     $carreras_persona->anio_vigente = $request->gestion;
            //     //$carreras_persona->sexo = $persona->sexo;
            //     $carreras_persona->save();
            // }
        }
        //return redirect('Persona/listado');
        return redirect('Persona/ver_detalle/'.$request->persona_id);
    }

    public function ajaxBuscaAsignatura(Request $request)
    {
        $asignaturas = Asignatura::where('anio_vigente', $request->anioIngreso)
                                ->where('nombre', 'like',  "%$request->termino%")
                                ->orWhere('sigla', 'like', "%$request->termino%")
                                ->limit(8)
                                ->get();
        // $termino = $request->termino;
        // $asignaturas = Asignatura::where('anio_vigente', $request->anioIngreso)
        //                         ->where(function ($query) {
        //                             $query->where('nombre', 'like', "%$termino%")
        //                                 ->orWhere('sigla', 'like', "%$termino%");
        //                         })
        //                         ->limit(8)
        //                         ->get();
        return view('inscripcion.ajaxBuscaAsignatura')->with(compact('asignaturas'));
    }

    /*
    public function reinscripcion()
    {
        $carreras = Carrera::where("deleted_at", NULL)
                        ->get();
        $turnos = Turno::get();
        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
        $year = $fecha->format('Y');//obtenes solo el año actual
        
        $asignaturas = DB::table('asignaturas')
                ->where('asignaturas.anio_vigente', '=', $year)
                ->join('servicios_asignaturas', 'asignaturas.id', '=', 'servicios_asignaturas.asignatura_id')
                ->where('servicios_asignaturas.servicio_id', '!=', 2)
                ->select('asignaturas.*')
                ->get();      

        return view('inscripcion.reinscripcion', compact('carreras', 'turnos', 'year', 'asignaturas'));    
    }
    */

    public function varios()
    {
        $carreras = Carrera::where("deleted_at", NULL)
                        ->get();
        $turnos = Turno::get();
        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
        $year = $fecha->format('Y');//obtenes solo el año actual
        
        $asignaturas = DB::table('asignaturas')
                ->where('asignaturas.anio_vigente', '=', $year)
                ->join('servicios_asignaturas', 'asignaturas.id', '=', 'servicios_asignaturas.asignatura_id')
                ->where('servicios_asignaturas.servicio_id', '!=', 2)
                ->select('asignaturas.*')
                ->get();      

        return view('inscripcion.varios', compact('carreras', 'turnos', 'year', 'asignaturas'));    
    }

    public function recuperatorio()
    {
        $carreras = Carrera::where("deleted_at", NULL)
                        ->get();
        $turnos = Turno::get();
        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
        $year = $fecha->format('Y');//obtenes solo el año actual
        
        $asignaturas = DB::table('asignaturas')
                ->where('asignaturas.anio_vigente', '=', $year)
                ->join('servicios_asignaturas', 'asignaturas.id', '=', 'servicios_asignaturas.asignatura_id')
                ->where('servicios_asignaturas.servicio_id', '!=', 2)
                ->select('asignaturas.*')
                ->get();      

        return view('inscripcion.recuperatorio', compact('carreras', 'turnos', 'year', 'asignaturas'));    
    }
    
    public function buscar_recuperatorio(Request $request)
    {

        $fecha = new \DateTime();//aqui obtenemos la fecha y hora actual
        $year = $fecha->format('Y');//obtenes solo el año actual

        $nota_menor = 35;
        $nota_mayor = 60;

        $asignaturas = DB::table('inscripciones')
                        ->where('inscripciones.persona_id', '=', $request->tipo_persona_id)
                        ->where('inscripciones.anio_vigente', '=', $year)
                        ->where('inscripciones.estado', '=', NULL)
                        ->whereBetween('inscripciones.nota', array($nota_menor, $nota_mayor))
                        ->join('carreras', 'inscripciones.carrera_id', '=', 'carreras.id')
                        ->join('asignaturas', 'inscripciones.asignatura_id', '=', 'asignaturas.id')
                        ->join('turnos', 'inscripciones.turno_id', '=', 'turnos.id')
                        ->select('inscripciones.id', 'inscripciones.asignatura_id', 'inscripciones.persona_id', 'inscripciones.carrera_id', 'inscripciones.anio_vigente', 'carreras.nombre', 'asignaturas.nombre_asignatura', 'turnos.descripcion', 'inscripciones.paralelo', 'inscripciones.nota')
                        ->get();

         if (count($asignaturas) > 0) {
            return response()->json([
                'asignaturas' => $asignaturas,
                'mensaje' => 'si'
            ]);  
        } else {
            return response()->json([
                'mensaje' => 'no'
            ]);  
        } 
    }

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

    /*
    public function guardar(Request $request)
    {
        //dd('hola');
        // Si existe el parametro $request->persona_id actualizamos, si no existe, creamos uno nuevo
        if($request->persona_id){
            $persona = Persona::find($request->persona_id);
        }else{
            $persona = new Persona();
        }
        $persona->user_id           = Auth::user()->id;
        $persona->apellido_paterno  = $request->apellido_paterno;
        $persona->apellido_materno  = $request->apellido_materno;
        $persona->nombres           = $request->nombres;
        $persona->cedula            = $request->carnet;
        $persona->expedido          = $request->expedido;
        $persona->fecha_nacimiento  = $request->fecha_nacimiento;
        $persona->sexo              = $request->sexo;
        $persona->direccion         = $request->direccion;
        // numero_fijo
        $persona->numero_celular    = $request->telefono_celular;
        $persona->email             = $request->email;
        $persona->trabaja           = $request->trabaja;
        $persona->empresa           = $request->empresa;
        $persona->direccion_empresa = $request->direccion_empresa;
        $persona->numero_empresa    = $request->telefono_empresa;
        // fax
        $persona->email_empresa     = $request->email_empresa;
        $persona->nombre_padre      = $request->nombre_padre;
        $persona->celular_padre     = $request->celular_padre;
        $persona->nombre_madre      = $request->nombre_madre;
        $persona->celular_madre     = $request->celular_madre;
        $persona->nombre_tutor      = $request->nombre_tutor;
        $persona->celular_tutor     = $request->telefono_tutor;
        $persona->nombre_pareja     = $request->nombre_esposo;
        $persona->celular_pareja    = $request->telefono_esposo;
        // nit
        // razon_social_cliente
        $persona->save();

        // Capturamos el id de esa persona
        $persona_id = $persona->id;

        // REGISTRA LAS CARRERAS INSCRITAS
        // En la variable $request->numero, que es un array, se envia la cantidad de carreras inscritas
        dd($request->numero);
        foreach ($request->numero as $registro) {
            // Por cada carrera existente, se crean los valores para cada carrera
            $datos_carrera = 'carrera_'.$registro;
            $datos_turno = 'turno_'.$registro;
            $datos_paralelo = 'paralelo_'.$registro;
            $datos_gestion = 'gestion_'.$registro;
            // Si la variable $request->$datos_carrera es diferente de 0
            if ($request->$datos_carrera != 0) {
                // Se crean un nuevo registro en la tabla carreras_personas
                $carrera_1 = new CarreraPersona();
                $carrera_1->user_id      = Auth::user()->id;
                $carrera_1->carrera_id   = $request->$datos_carrera;
                $carrera_1->persona_id   = $persona_id;
                $carrera_1->turno_id     = $request->$datos_turno;
                $carrera_1->paralelo     = $request->$datos_paralelo;
                $carrera_1->anio_vigente = $request->$datos_gestion;
                $carrera_1->sexo         = $request->sexo;
                $carrera_1->save();
                // Se llama a la funcion asignaturas_inscripcion, insertando los datos
                $this->asignaturas_inscripcion($request->$datos_carrera,
                                                $request->$datos_turno,
                                                $persona_id,
                                                $request->$datos_paralelo,
                                                $request->$datos_gestion);

                DB::table('materias')->truncate();
            }
            
        }

        // Datos para facturacion
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
     
        return redirect('Kardex/detalle_estudiante/'.$persona_id);
    }
    */

    public function guardar_antiguo(Request $request)
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

            $asignaturass = ServiciosAsignatura::where('asignatura_id', $request->$datos_asig)
                                                ->where('asignatura_id', '!=', 2)
                                                ->get();
            $servicioss = Servicio::find($asignaturass[0]->servicio_id);

            $cobros_matricula = new CobrosTemporada();
            $cobros_matricula->servicio_id    = $asignaturass[0]->servicio_id;
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
        //dd('hola');
        $asignaturas = DB::select("SELECT asig.id, asig.codigo_asignatura, asig.nombre_asignatura, prer.sigla, prer.prerequisito_id
                                    FROM asignaturas asig, prerequisitos prer
                                    WHERE asig.carrera_id = '$carrera_id'
                                    AND asig.anio_vigente = '$anio_vigente'
                                    AND asig.id = prer.asignatura_id
                                    ORDER BY asig.gestion, asig.orden_impresion");
        /*  1
        $materias = Asignatura::where('carrera_id', $carrera_id)
                                ->where('anio_vigente', $anio_vigente)
                                ->orderBy('gestion', 'asc')
                                ->get();
        dd($materias);
        */

        //Verifica que no este inscrito el alumno ya en esas materias
        foreach ($asignaturas as $asignatura) {
            $inscripciones = DB::select("SELECT MAX(nota) as nota
                                        FROM inscripciones
                                        WHERE asignatura_id = '$asignatura->id'
                                        AND persona_id = '$persona_id'
                                        AND carrera_id = '$carrera_id'");
            /*  2
            $inscripciones = Inscripcion::where('asignatura_id', $asignatura->id)
                                        ->where('persona_id', $persona_id)
                                        ->where('carrera_id', $carrera_id)
                                        ->get();
            dd($inscripciones);
            */
            
            if(!empty($inscripciones[0]->nota)){
                //dd('hola');
                // Si la nota maxima es menor que 71
               if ($inscripciones[0]->nota < 61) {
                   DB::table('materias')->insert([
                        'asignatura_id' => $asignatura->id,
                        'codigo_asignatura' => $asignatura->codigo_asignatura,
                        'nombre_asignatura' => $asignatura->nombre_asignatura,                              
                        'estado' => 1,
                    ]);
               }

            } else {
                //dd('falso');
                if (!empty($asignatura->prerequisito_id)) {
                    $prerequisito = DB::select("SELECT MAX(nota) as nota
                                                FROM inscripciones
                                                WHERE asignatura_id = '$asignatura->prerequisito_id'
                                                AND persona_id = '$persona_id'
                                                AND carrera_id = '$carrera_id'");
                    if ($prerequisito[0]->nota > 60) {
                        DB::table('materias')->insert([
                              'asignatura_id' => $asignatura->id,
                              'codigo_asignatura' => $asignatura->codigo_asignatura,
                              'nombre_asignatura' => $asignatura->nombre_asignatura,                              
                              'estado' => 1,
                            ]);
                    }

                } else {
                    DB::table('materias')->insert([
                              'asignatura_id' => $asignatura->id,
                              'codigo_asignatura' => $asignatura->codigo_asignatura,
                              'nombre_asignatura' => $asignatura->nombre_asignatura,                              
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

                // Buscaremos si existe un docente ya asignado a esta materia
                $materia_docente = NotasPropuesta::where('asignatura_id', $inscripcion->asignatura_id)
                                                ->where('turno_id', $inscripcion->turno_id)
                                                ->where('paralelo', $inscripcion->paralelo)
                                                ->where('anio_vigente', $inscripcion->anio_vigente)
                                                ->first();

                // Aqui crearemos los 4 registros para la tabla notas, por cada inscripcion
                for($i=1; $i<=4; $i++){
                    $nueva_nota = new Nota;
                    $nueva_nota->asignatura_id = $inscripcion->asignatura_id;
                    if($materia_docente){       //Si existe un docente ya asignado a esa materia, adiciona ese dato
                        $nueva_nota->user_id = $materia_docente->user_id;
                    }
                    $nueva_nota->turno_id = $inscripcion->turno_id;
                    $nueva_nota->persona_id = $inscripcion->persona_id;
                    $nueva_nota->paralelo = $inscripcion->paralelo;
                    $nueva_nota->anio_vigente = $inscripcion->anio_vigente;
                    $nueva_nota->trimestre = $i;
                    $nueva_nota->save();
                }

                // en esta parte registramos la nota del alumno inscrito
                // $notas_pro = NotasPropuesta::where('asignatura_id', $asig_tomar1->asignatura_id)
                //                             ->where('turno_id', $turno_id)
                //                             ->where('paralelo', $paralelo)
                //                             ->where('anio_vigente', $anio_vigente)
                //                             ->select('user_id')
                //                             ->get();
                // dd($notas_pro[0]->user_id);
                // if (!empty($notas_pro[0]->user_id)) {
                //     for($i=1; $i<=4; $i++){
                //         $nueva_nota = new Nota;
                //         $nueva_nota->asignatura_id = $asig_tomar1->asignatura_id;
                //         $nueva_nota->turno_id = $turno_id;
                //         $nueva_nota->user_id = $notas_pro[0]->user_id;
                //         $nueva_nota->persona_id = $persona_id;
                //         $nueva_nota->paralelo = $paralelo;
                //         $nueva_nota->anio_vigente = $anio_vigente;
                //         $nueva_nota->trimestre = $i;
                //         $nueva_nota->save();
                //     }                        
                // }
            }
    }

    // Funcion que busca y devuelve coincidencias con respeocto al campo CI insertado
    public function busca_ci(Request $request)
    {
        $persona = Persona::where('cedula', $request->ci)->first();
        if ($persona)
        {
            $carreras = CarrerasPersona::where('persona_id', $persona->id)->get();
            // $carreras = DB::table('carreras_personas')
            //                 ->where('carreras_personas.persona_id', $persona->id)
            //                 ->join('carreras', 'carreras_personas.carrera_id', '=', 'carreras.id')
            //                 ->select('carreras.id', 'carreras.nombre')
            //                 ->get();
            // dd($carreras);
            return response()->json([
                'mensaje' => 'si',
                'persona' => $persona,
                'carreras' => $carreras
            ]);
        }
        else
        {
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

    public function ajaxMuestraNotaInscripcion(Request $request)
    {
        $inscripcion = Inscripcione::find($request->inscripcion_id);
        $notas = Nota::where('inscripcion_id', $request->inscripcion_id)
                    ->get();
        return view('inscripcion.ajaxMuestraNotaInscripcion')->with(compact('inscripcion', 'notas'));
    }

    public function actualizaNotaInscripcion(Request $request)
    {
        // Capturaremos las inscripcion_id y desde ahi crearemos las variables necesarias para el proceso
        $inscripcion = Inscripcione::find($request->inscripcion_id);
        $asignatura = Asignatura::find($inscripcion->asignatura_id);
        $persona = Persona::find($inscripcion->persona_id);
        $notas = Nota::where('inscripcion_id', $inscripcion->id)
                    ->get();
        // Actualizaremos los valores correspondientes a la tabla Motas
        // Preguntamos por el ciclo, si es semestral
        if($asignatura->ciclo == 'Semestral'){
            // Es Semestral, las notas se actualizaran en base a los bimestres 1->3 y 2->4
            foreach($notas as $nota){
                // Capturamos las registros enviados desde interfaz, respectivos a cada nota
                $asistencia = 'asistencia-'.$nota->id;
                $practicas = 'practicas-'.$nota->id;
                $parcial = 'parcial-'.$nota->id;
                $final = 'final-'.$nota->id;
                $puntos = 'puntos-'.$nota->id;
                // Si el trimestre es 1
                if($nota->trimestre == 1){
                    // Primero calcularemos para llenar la nota total
                    $total = $request->$asistencia + $request->$practicas + $request->$parcial + $request->$final;
                    $necesario = 100 - $total;
                    if($necesario >= 10){
                        $total = $total + $request->$puntos;
                    }else{
                        if($necesario <= $request->$puntos){
                            $total = $total + $necesario;
                        }else{
                            $total = $total + $request->$puntos;
                        }
                    }
                    // Ahora si guardaremos los valores que se mandaron para el trimestre 1
                    $nota->nota_asistencia = $request->$asistencia;
                    $nota->nota_practicas = $request->$practicas;
                    $nota->nota_primer_parcial = $request->$parcial;
                    $nota->nota_examen_final = $request->$final;
                    $nota->nota_puntos_ganados = $request->$puntos;
                    $nota->nota_total = $total;
                    $nota->save();
                    // Hallaremos el registro con en el trimestre 3
                    $terceraNota = Nota::where('inscripcion_id', $inscripcion->id)
                                        ->where('trimestre', 3)
                                        ->first();
                    // Guardaremos los registros con los datos del trimestre 1
                    $terceraNota->nota_asistencia = $request->$asistencia;
                    $terceraNota->nota_practicas = $request->$practicas;
                    $terceraNota->nota_primer_parcial = $request->$parcial;
                    $terceraNota->nota_examen_final = $request->$final;
                    $terceraNota->nota_puntos_ganados = $request->$puntos;
                    $terceraNota->nota_total = $total;
                    $terceraNota->save();
                }
                // Si el trimestre es 2
                if($nota->trimestre == 2){
                    // Primero calcularemos para llenar la nota total
                    $total = $request->$asistencia + $request->$practicas + $request->$parcial + $request->$final;
                    $necesario = 100 - $total;
                    if($necesario >= 10){
                        $total = $total + $request->$puntos;
                    }else{
                        if($necesario <= $request->$puntos){
                            $total = $total + $necesario;
                        }else{
                            $total = $total + $request->$puntos;
                        }
                    }
                    // Ahora si guardaremos los valores que se mandaron para el trimestre 2
                    $nota->nota_asistencia = $request->$asistencia;
                    $nota->nota_practicas = $request->$practicas;
                    $nota->nota_primer_parcial = $request->$parcial;
                    $nota->nota_examen_final = $request->$final;
                    $nota->nota_puntos_ganados = $request->$puntos;
                    $nota->nota_total = $total;
                    $nota->save();
                    // Hallaremos el registro con en el trimestre 4
                    $cuartaNota = Nota::where('inscripcion_id', $inscripcion->id)
                                        ->where('trimestre', 4)
                                        ->first();
                    // Guardaremos los registros con los datos del trimestre 2
                    $cuartaNota->nota_asistencia = $request->$asistencia;
                    $cuartaNota->nota_practicas = $request->$practicas;
                    $cuartaNota->nota_primer_parcial = $request->$parcial;
                    $cuartaNota->nota_examen_final = $request->$final;
                    $cuartaNota->nota_puntos_ganados = $request->$puntos;
                    $cuartaNota->nota_total = $total;
                    $cuartaNota->save();
                }
            }
        }else{
            // Es Anual, las notas se actualizaran de forma independiente
            foreach($notas as $nota){
                // Capturamos las registros enviados desde interfaz, respectivos a cada nota
                $asistencia = 'asistencia-'.$nota->id;
                $practicas = 'practicas-'.$nota->id;
                $parcial = 'parcial-'.$nota->id;
                $final = 'final-'.$nota->id;
                $puntos = 'puntos-'.$nota->id;
                // Primero calcularemos para llenar la nota total
                $total = $request->$asistencia + $request->$practicas + $request->$parcial + $request->$final;
                $necesario = 100 - $total;
                if($necesario >= 10){
                    $total = $total + $request->$puntos;
                }else{
                    if($necesario <= $request->$puntos){
                        $total = $total + $necesario;
                    }else{
                        $total = $total + $request->$puntos;
                    }
                }
                // Ahora si guardaremos los valores que se mandaron
                $nota->nota_asistencia = $request->$asistencia;
                $nota->nota_practicas = $request->$practicas;
                $nota->nota_primer_parcial = $request->$parcial;
                $nota->nota_examen_final = $request->$final;
                $nota->nota_puntos_ganados = $request->$puntos;
                $nota->nota_total = $total;
                $nota->save();
            }
        }
        // Actualizaremos los valores correspondientes a la tabla Inscripciones
        $notaTotal = 0;
        // Volvemos a capturar en la variable $notas la coleccion del modelo Notas
        $notas = Nota::where('inscripcion_id', $inscripcion->id)
                    ->get();
        foreach($notas as $nota){
            $notaTotal = $notaTotal + $nota->nota_total;
        }
        $notaTotal = round($notaTotal/4);
        $inscripcion->nota = $notaTotal;
        if($notaTotal >= $inscripcion->nota_aprobacion){
            $inscripcion->aprobo = 'Si';
        }else{
            $inscripcion->aprobo = 'No';
        }
        $inscripcion->save();
        // Ahora evaluaremos el estado de todas las asignaturas correspondientes a esta gestion
        // Buscamos las inscripciones correspondientes a esta gestion X
        $inscripciones  = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                    ->where('persona_id', $inscripcion->persona_id)
                                    ->where('gestion', $inscripcion->gestion)
                                    ->where('anio_vigente', $inscripcion->anio_vigente)
                                    ->get();
        // Hallamos la cantidad de materias inscritas
        $cantidadInscritas  = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                        ->where('persona_id', $inscripcion->persona_id)
                                        ->where('gestion', $inscripcion->gestion)
                                        ->where('anio_vigente', $inscripcion->anio_vigente)
                                        ->count();
        // Hallamos la cantidad de materias inscritas que finalizaron
        $cantidadFinalizadas    = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                            ->where('persona_id', $inscripcion->persona_id)
                                            ->where('gestion', $inscripcion->gestion)
                                            ->where('anio_vigente', $inscripcion->anio_vigente)
                                            ->where('estado', 'Finalizado')
                                            ->count();
        // Verificamos que se hayan finalizado todas las materias inscritas
        if($cantidadInscritas == $cantidadFinalizadas)
        {
            // Crearemos una variable para contar las materias que se aprobaron
            $cantidadAprobadas = 0;
            // Iteramos sobre las inscripciones para ver cuantas se aprobaron
            foreach($inscripciones as $materia)
            {
                if($materia->aprobo == 'Si')
                {
                    $cantidadAprobadas++;
                }
            }
            // Buscaremos en la tabla carreras_personas el registro que esta asociado a estas inscripciones
            $carrerasPersona    = CarrerasPersona::where('carrera_id', $inscripcion->carrera_id)
                                                ->where('persona_id', $inscripcion->persona_id)
                                                ->where('gestion', $inscripcion->gestion)
                                                ->where('anio_vigente', $inscripcion->anio_vigente)
                                                ->first();
            // Si existe un registro que corresponda al grupo de inscripciones
            if($carrerasPersona)
            {
                // Evaluamos si se aprobo la gestion o no
                if($cantidadAprobadas == $cantidadInscritas)
                {
                    $carrerasPersona->estado    = 'APROBO';
                }
                else
                {
                    $carrerasPersona->estado    = 'REPROBO';
                }
                $carrerasPersona->save();
            }
        }
        return redirect('Persona/ver_detalle/'.$persona->id);
    }

    public function inscribirCursoCorto($persona_id, $asignatura_id)
    {
        // Si existen los dos parametros
        if($persona_id && $asignatura_id)
        {
            // Buscaremos si no existe un registro ya en inscripciones
            $registro = Inscripcione::where('persona_id', $persona_id)
                                    ->where('asignatura_id', $asignatura_id)
                                    ->where('aprobo', 'Si')
                                    ->first();
            // Si no existe un registro, procedemos a la inscripcion
            if(!$registro)
            {
                $asignatura = Asignatura::find($asignatura_id);
                $persona = Persona::find($persona_id);
                // Buscaremos si existe un docente ya asignado a esta materia
                $docente = NotasPropuesta::where('asignatura_id', $asignatura->id)
                                        //->where('turno_id', $request->$datos_turno)
                                        //->where('paralelo', $request->$datos_paralelo)
                                        ->where('anio_vigente', date('Y'))
                                        ->first();
                // Registramos en inscripciones
                $inscripcion = new Inscripcione();
                $inscripcion->user_id = Auth::user()->id;
                $inscripcion->resolucion_id = $asignatura->carrera->resolucion_id;
                $inscripcion->carrera_id = $asignatura->carrera->id;
                $inscripcion->asignatura_id = $asignatura->id;
                $inscripcion->persona_id = $persona->id;
                $inscripcion->gestion = $asignatura->gestion;
                $inscripcion->anio_vigente = date('Y');
                $inscripcion->fecha_registro = date('Y-m-d');
                $inscripcion->nota_aprobacion = $asignatura->carrera->nota_aprobacion;
                //$inscripcion->aprobo = 'Si', 'No', 'Cursando';
                $inscripcion->estado = 'Cursando';  // Cuando acaba semestre/gestion cambiar a Finalizado
                $inscripcion->save();
                // Registramos en cursos_cortos
                $curso_corto = new CursosCorto();
                $curso_corto->user_id = Auth::user()->id;
                $curso_corto->resolucion_id = $asignatura->carrera->resolucion_id;
                $curso_corto->inscripcion_id = $inscripcion->id;
                if($docente){
                    $curso_corto->docente_id = $docente->docente_id;
                }
                $curso_corto->persona_id = $persona->id;
                $curso_corto->asignatura_id = $asignatura->id;
                $curso_corto->anio_vigente = date('Y');
                //$curso_corto->trimestre = $i;
                $curso_corto->fecha_registro = date('Y-m-d');
                $curso_corto->nota_aprobacion = $asignatura->carrera->nota_aprobacion;
                $curso_corto->save();
            }
            return redirect('Persona/ver_detalle/'.$persona_id);
        }
        return redirect('Persona/listado');
    }

    public function ajaxVerCursoCorto(Request $request)
    {
        $inscripcion = Inscripcione::find($request->inscripcion_id);
        $curso = CursosCorto::where('inscripcion_id', $request->inscripcion_id)
                            ->first();
        return view('inscripcion.ajaxVerCursoCorto')->with(compact('inscripcion', 'curso'));
    }

    public function actualizaCursoCorto(Request $request)
    {
        // Capturaremos las inscripcion_id y desde ahi crearemos las variables necesarias para el proceso
        $inscripcion = Inscripcione::find($request->inscripcion_id);
        $asignatura = Asignatura::find($inscripcion->asignatura_id);
        $persona = Persona::find($inscripcion->persona_id);
        $curso = CursosCorto::where('inscripcion_id', $inscripcion->id)
                    ->first();

        // Primero calcularemos para llenar la nota total
        $total = $request->asistencia + $request->practicas + $request->parcial + $request->final;
        $necesario = 100 - $total;
        if($necesario >= 10){
            $total = $total + $request->puntos;
        }else{
            if($necesario <= $request->puntos){
                $total = $total + $necesario;
            }else{
                $total = $total + $request->puntos;
            }
        }
        // Ahora si guardaremos los valores que se mandaron para el trimestre 1
        $curso->nota_asistencia = $request->asistencia;
        $curso->nota_practicas = $request->practicas;
        $curso->nota_primer_parcial = $request->parcial;
        $curso->nota_examen_final = $request->final;
        $curso->nota_puntos_ganados = $request->puntos;
        $curso->nota_total = $total;
        $curso->save();

        // Actualizaremos los valores correspondientes a la tabla Inscripciones
        $inscripcion->nota = $total;
        if($total >= $inscripcion->nota_aprobacion){
            $inscripcion->aprobo = 'Si';
        }else{
            $inscripcion->aprobo = 'No';
        }
        $inscripcion->save();
        return redirect('Persona/ver_detalle/'.$persona->id);
    }

    public function eliminarCursoCorto($id)
    {
        if($id)
        {
            $inscripcion = Inscripcione::find($id);
            if($inscripcion)
            {
                $persona_id = $inscripcion->persona_id;
                $curso_corto = CursosCorto::where('inscripcion_id', $inscripcion->id)
                                        ->first();
                if($curso_corto)
                {
                    $curso_corto->delete();
                }
                $inscripcion->delete();
                return redirect('Persona/ver_detalle/'.$persona_id);
            }
        }
        return redirect('Persona/listado');
    }

    public function ajaxMuestraInscripcion(Request $request)
    {
        // capturamos las variables
        $registro = CarrerasPersona::find($request->inscripcion_id);
        $inscripciones = Inscripcione::where('carrera_id', $registro->carrera_id)
                                    ->where('persona_id', $registro->persona_id)
                                    //->where('turno_id', $registro->turno_id)
                                    //->where('fecha_registro', $registro->fecha_inscripcion)
                                    ->where('anio_vigente', $registro->anio_vigente)
                                    ->get();
        return view('inscripcion.ajaxMuestraInscripcion')->with(compact('registro', 'inscripciones'));
    }

    public function actualizarEstadoInscripcionGlobal(Request $request)
    {
        $carreraPersona             = CarrerasPersona::find($request->registro_inscripcion);
        $persona                    = Persona::find($carreraPersona->persona_id);
        $carreraPersona->user_id    = Auth::user()->id;
        $carreraPersona->estado     = $request->estado_inscripcion;
        // AQUI MODIFICAR ALGO MAS, ESTADOS DE INSCRIPCIONES, ACORDES AL ESTADO GLOBAL
        $carreraPersona->save();
        return redirect('Persona/ver_detalle/'.$persona->id);
    }

    public function congelaAsignatura($inscripcion_id)
    {
        $inscripcion            = Inscripcione::find($inscripcion_id);
        $persona                = Persona::find($inscripcion->persona_id);
        $inscripcion->user_id   = Auth::user()->id;
        if($inscripcion->congelado == 'Si')
        {
            $inscripcion->congelado = NULL;
            $inscripcion->aprobo    = NULL;
        }
        else
        {
            $inscripcion->congelado = 'Si';
            $inscripcion->aprobo    = 'No';
        }
        $inscripcion->save();
        // AQUI COLOCAR DE FORMA
        return redirect('Persona/ver_detalle/'.$persona->id);
    }

    public function finalizarCalificaciones($persona_id, $carrera_id)
    {
        $inscripciones  = Inscripcione::where('persona_id', $persona_id)
                                        ->where('carrera_id', $carrera_id)
                                        ->get();
        $notas          = Nota::where('persona_id', $persona_id)
                                ->whereNull('finalizado')
                                ->get();
        foreach($notas as $nota)
        {
            $nota->finalizado   = 'Si';
            $nota->save();
        }
        foreach($inscripciones as $inscripcion)
        {
            if($inscripcion->nota)
            {
                ($inscripcion->nota >= $inscripcion->nota_aprobacion ? $aprobo = 'Si' : $aprobo = 'No');
                $inscripcion->aprobo    = $aprobo;
            }
            $inscripcion->estado    = 'Finalizado';
            $inscripcion->save();

        }
        // Ahora finalizaremos y evaluaremos carreras inscripciones
        $carrerasPersonas   = CarrerasPersona::where('carrera_id', $carrera_id)
                                            ->where('persona_id', $persona_id)
                                            ->get();
        foreach($carrerasPersonas as $carreraPersona)
        {
            // Buscaremos sus inscripciones y evaluaremos
            // Buscamos las inscripciones correspondientes a esta gestion X
            $inscripciones  = Inscripcione::where('carrera_id', $carreraPersona->carrera_id)
                                        ->where('persona_id', $carreraPersona->persona_id)
                                        ->where('gestion', $carreraPersona->gestion)
                                        ->where('anio_vigente', $carreraPersona->anio_vigente)
                                        ->get();
            // Hallamos la cantidad de materias inscritas
            $cantidadInscritas  = Inscripcione::where('carrera_id', $carreraPersona->carrera_id)
                                            ->where('persona_id', $carreraPersona->persona_id)
                                            ->where('gestion', $carreraPersona->gestion)
                                            ->where('anio_vigente', $carreraPersona->anio_vigente)
                                            ->count();
            // Hallamos la cantidad de materias inscritas que finalizaron
            $cantidadFinalizadas    = Inscripcione::where('carrera_id', $carreraPersona->carrera_id)
                                                ->where('persona_id', $carreraPersona->persona_id)
                                                ->where('gestion', $carreraPersona->gestion)
                                                ->where('anio_vigente', $carreraPersona->anio_vigente)
                                                ->where('estado', 'Finalizado')
                                                ->count();
            // Verificamos que se hayan finalizado todas las materias inscritas
            if($cantidadInscritas == $cantidadFinalizadas)
            {
                // Crearemos una variable para contar las materias que se aprobaron
                $cantidadAprobadas = 0;
                // Iteramos sobre las inscripciones para ver cuantas se aprobaron
                foreach($inscripciones as $materia)
                {
                    if($materia->aprobo == 'Si')
                    {
                        $cantidadAprobadas++;
                    }
                }
                // Evaluamos si se aprobo la gestion o no
                if($cantidadAprobadas == $cantidadInscritas)
                {
                    $carreraPersona->estado    = 'APROBO';
                }
                else
                {
                    $carreraPersona->estado    = 'REPROBO';
                }
                $carreraPersona->save();
            }
        }
        return redirect('Persona/ver_detalle/'.$persona_id);
    }

    public function boletin($id)
    {
        $registro   = CarrerasPersona::find($id);
        $persona    = Persona::find($registro->persona_id);
        $carrera    = Carrera::find($registro->carrera_id);
        // En la variable inscripciones hallaremos la relacion entre el registro de la tabla carreras_personas e inscripciones
        $inscripciones  = Inscripcione::where('carrera_id', $registro->carrera_id)
                                    ->where('persona_id', $registro->persona_id)
                                    //->where('turno_id', $registro->turno_id)
                                    //->where('paralelo', $registro->paralelo)                  //paralelo
                                    //->where('fecha_registro', $registro->fecha_inscripcion)   //fecha_inscripcion
                                    ->whereNull('oyente')
                                    ->where('anio_vigente', $registro->anio_vigente)            //anio_vigente
                                    ->get();
        switch ($persona->expedido) {
            case 'La Paz':
                $expedido = 'LP';
                break;
            case 'Oruro':
                $expedido = 'OR';
                break;
            case 'Potosi':
                $expedido = 'PT';
                break;
            case 'Cochabamba':
                $expedido = 'CB';
                break;
            case 'Santa Cruz':
                $expedido = 'SC';
                break;
            case 'Beni':
                $expedido = 'BN';
                break;
            case 'Pando':
                $expedido = 'PA';
                break;
            case 'Tarija':
                $expedido = 'TJ';
                break;
            case 'Chuquisaca':
                $expedido = 'CH';
                break;
            default:
                $expedido = '';
        }
        $gestionAcademica   = $registro->anio_vigente;
        $pdf    = PDF::loadView('pdf.boletinCalificacionInscripcion', compact('registro', 'carrera', 'persona', 'inscripciones', 'gestionAcademica', 'expedido'))->setPaper('letter');
        // return $pdf->download('boletinInscripcion_'.date('Y-m-d H:i:s').'.pdf');
        return $pdf->stream('boletinInscripcion_'.date('Y-m-d H:i:s').'.pdf');
    }

    public function reportePdfHistorialAcademico($persona_id, $carrera_id)
    {
        if($persona_id && $carrera_id)
        {
            $persona        = Persona::find($persona_id);
            $carrera        = Carrera::find($carrera_id);
            $inscripciones  = Inscripcione::where('persona_id', $persona->id)
                                        ->where('carrera_id', $carrera->id)
                                        ->whereNull('oyente')
                                        ->orderBy('id')
                                        ->get();
            switch ($persona->expedido) {
                case 'La Paz':
                    $expedido = 'LP';
                    break;
                case 'Oruro':
                    $expedido = 'OR';
                    break;
                case 'Potosi':
                    $expedido = 'PT';
                    break;
                case 'Cochabamba':
                    $expedido = 'CB';
                    break;
                case 'Santa Cruz':
                    $expedido = 'SC';
                    break;
                case 'Beni':
                    $expedido = 'BN';
                    break;
                case 'Pando':
                    $expedido = 'PA';
                    break;
                case 'Tarija':
                    $expedido = 'TJ';
                    break;
                case 'Chuquisaca':
                    $expedido = 'CH';
                    break;
                default:
                    $expedido = '';
            }
            $anioIngreso    = CarrerasPersona::where('persona_id', $persona->id)
                                            ->where('carrera_id', $carrera->id)
                                            ->min('anio_vigente');
            if(!$anioIngreso)
            {
                $anioIngreso    = Inscripcione::where('persona_id', $persona->id)
                                            ->where('carrera_id', $carrera->id)
                                            ->min('anio_vigente');
            }
            $cantidadCurricula  = Asignatura::where('carrera_id', $carrera->id)
                                            ->where('anio_vigente', $anioIngreso)
                                            ->count();
            $cantidadAprobados  = Inscripcione::where('carrera_id', $carrera->id)
                                            ->where('persona_id', $persona->id)
                                            ->where('aprobo', 'Si')
                                            ->count();
            $totalAsignaturas   = Inscripcione::where('carrera_id', $carrera->id)
                                            ->where('persona_id', $persona->id)
                                            ->where('aprobo', 'Si')
                                            ->sum('nota');
            $promedio   = round($totalAsignaturas/$cantidadAprobados);
            // Para la carga horaria, buscaremos la gestion maxima aprobada
            $gestionMaxima  = Inscripcione::where('carrera_id', $carrera->id)
                                        ->where('persona_id', $persona->id)
                                        ->where('aprobo', 'Si')
                                        ->max('gestion');
            $cargaGestion   = 1200;
            $cargaHoraria   = 0;
            for($i=1; $i<=$gestionMaxima; $i++)
            {
                $cantidadAsignaturasGestion = Asignatura::where('carrera_id', $carrera->id)
                                                        ->where('anio_vigente', $anioIngreso)
                                                        ->where('gestion', $i)
                                                        ->count();
                $cantidadAsignaturasAprobadas   = Inscripcione::where('carrera_id', $carrera->id)
                                                            ->where('persona_id', $persona->id)
                                                            ->where('gestion', $i)
                                                            ->where('aprobo', 'Si')
                                                            ->count();
                $cargaHoraria   = $cargaHoraria + round(($cargaGestion*$cantidadAsignaturasAprobadas)/$cantidadAsignaturasGestion);
            }
            $gestionesInscritas = CarrerasPersona::where('carrera_id', $carrera->id)
                                                ->where('persona_id', $persona->id)
                                                ->get();
            $pdf    = PDF::loadView('pdf.historialAcademico', compact('carrera', 'persona', 'inscripciones', 'expedido', 'cantidadCurricula', 'cantidadAprobados', 'promedio', 'cargaHoraria', 'gestionesInscritas', 'anioIngreso'))->setPaper('letter');
            // return $pdf->download('boletinInscripcion_'.date('Y-m-d H:i:s').'.pdf');
            return $pdf->stream('historialAcademico_'.date('Y-m-d H:i:s').'.pdf');
        }
        return redirect('Persona/listado');
    }

    public function pruebapdf()
    {
        $users  = User::get();
        // En la variable pdf se cargara la vista con sus respectivos datos
        $pdf    = PDF::loadView('pdf.users', compact('users'));
        // Nombre del pdf a exportar
        return $pdf->download('users-list.pdf');
    }

    public function eliminaAsignatura($id)
    {
        $inscripcion    = Inscripcione::find($id);
        if($inscripcion)
        {
            $persona_id = $inscripcion->persona_id;
            $notas  = Nota::where('inscripcion_id', $inscripcion->id)
                        ->get();
            $segundoTurno   = SegundosTurno::where('inscripcion_id', $inscripcion->id)
                                            ->first();
            ($segundoTurno ? $segundoTurno->delete() : '');
            foreach($notas as $nota)
            {
                $nota->delete();
            }
            $inscripcion->delete();
            return redirect('Persona/ver_detalle/'.$persona_id);
        }
        else
        {
            return redirect('Persona/listado');
        }
    }

    public function apruebaInscripcion($inscripcion_id)
    {
        $inscripcion    = Inscripcione::find($inscripcion_id);
        if($inscripcion)
        {
            // Hallamos al estudiante, la nota maxima para esa asignatura y las 4 notas correspondientes a esa inscripcion
            $persona        = Persona::find($inscripcion->persona_id);
            $notaAprobacion = $inscripcion->nota_aprobacion;
            $asignatura     = NotasPropuesta::where('asignatura_id', $inscripcion->asignatura_id)
                                        ->where('turno_id', $inscripcion->turno_id)
                                        ->where('paralelo', $inscripcion->paralelo)
                                        ->where('anio_vigente', $inscripcion->anio_vigente)
                                        ->first();
            if(!$asignatura)
            {
                $asignatura = Predefinida::where('activo', 'Si')
                                        ->first();
            }
            if($notaAprobacion && $asignatura)
            {
                // Obtenemos los 4 registros pertenecientes a la inscripcion
                $notas  = Nota::where('inscripcion_id', $inscripcion->id)
                                ->get();
                foreach($notas as $nota)
                {
                    // Iteramos para encontrar la nota
                    do {
                        $total  = 0;
                        $aleatorio_asistencia       =  mt_rand(1, $asignatura->nota_asistencia);
                        $aleatorio_practicas        =  mt_rand(1, $asignatura->nota_practicas);
                        $aleatorio_primer_parcial   =  mt_rand(1, $asignatura->nota_primer_parcial);
                        $aleatorio_examen_final     =  mt_rand(1, $asignatura->nota_examen_final);
                        $aleatorio_extras           =  mt_rand(1, $asignatura->nota_puntos_ganados);
                        $total = $aleatorio_asistencia + $aleatorio_practicas + $aleatorio_primer_parcial + $aleatorio_examen_final + $aleatorio_extras;
                    } while( $total <> $notaAprobacion);
                    $nota->nota_asistencia      = $aleatorio_asistencia;
                    $nota->nota_practicas       = $aleatorio_practicas;
                    $nota->nota_primer_parcial  = $aleatorio_primer_parcial;
                    $nota->nota_examen_final    = $aleatorio_examen_final;
                    $nota->nota_puntos_ganados  = $aleatorio_extras;
                    $nota->nota_total           = $total;
                    $nota->save();
                }
                $inscripcion->nota_reprobacion  = $inscripcion->nota;
                $inscripcion->nota              = $inscripcion->nota_aprobacion;
                $inscripcion->aprobo            = 'Si';
                $inscripcion->save();
            }
            // Ahora evaluaremos el estado de todas las asignaturas correspondientes a esta gestion
            // Buscamos las inscripciones correspondientes a esta gestion X
            $inscripciones  = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                        ->where('persona_id', $inscripcion->persona_id)
                                        ->where('gestion', $inscripcion->gestion)
                                        ->where('anio_vigente', $inscripcion->anio_vigente)
                                        ->get();
            // Hallamos la cantidad de materias inscritas
            $cantidadInscritas  = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                            ->where('persona_id', $inscripcion->persona_id)
                                            ->where('gestion', $inscripcion->gestion)
                                            ->where('anio_vigente', $inscripcion->anio_vigente)
                                            ->count();
            // Hallamos la cantidad de materias inscritas que finalizaron
            $cantidadFinalizadas    = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                                ->where('persona_id', $inscripcion->persona_id)
                                                ->where('gestion', $inscripcion->gestion)
                                                ->where('anio_vigente', $inscripcion->anio_vigente)
                                                ->where('estado', 'Finalizado')
                                                ->count();
            // Verificamos que se hayan finalizado todas las materias inscritas
            if($cantidadInscritas == $cantidadFinalizadas)
            {
                // Crearemos una variable para contar las materias que se aprobaron
                $cantidadAprobadas = 0;
                // Iteramos sobre las inscripciones para ver cuantas se aprobaron
                foreach($inscripciones as $materia)
                {
                    if($materia->aprobo == 'Si')
                    {
                        $cantidadAprobadas++;
                    }
                }
                // Buscaremos en la tabla carreras_personas el registro que esta asociado a estas inscripciones
                $carrerasPersona    = CarrerasPersona::where('carrera_id', $inscripcion->carrera_id)
                                                    ->where('persona_id', $inscripcion->persona_id)
                                                    ->where('gestion', $inscripcion->gestion)
                                                    ->where('anio_vigente', $inscripcion->anio_vigente)
                                                    ->first();
                // Si existe un registro que corresponda al grupo de inscripciones
                if($carrerasPersona)
                {
                    // Evaluamos si se aprobo la gestion o no
                    if($cantidadAprobadas == $cantidadInscritas)
                    {
                        $carrerasPersona->estado    = 'APROBO';
                    }
                    else
                    {
                        $carrerasPersona->estado    = 'REPROBO';
                    }
                    $carrerasPersona->save();
                }
            }
            return redirect('Persona/ver_detalle/'.$persona->id);
        }
        else
        {
            return redirect('Persona/listado');
        }
    }

    public function inscribeOyente(Request $request)
    {
        $inscripcion    = Inscripcione::find($request->inscripcion_id);
        $persona        = Persona::find($inscripcion->persona_id);
        // Comprobemos que no tiene una materia ya que compensa esta
        $registro       = Inscripcione::where('asignatura_id', $inscripcion->asignatura_id)
                                    ->where('persona_id', $inscripcion->persona_id)
                                    //->where('turno_id', $inscripcion->turno_id)
                                    //->where('paralelo', $inscripcion->paralelo)
                                    //->where('anio_vigente', $inscripcion->anio_vigente)
                                    ->where('estado', 'Cursando')
                                    ->where('oyente', 'Si')
                                    ->first();
        if(!$registro)
        {
            // Verificamos que en la tabla carreras_personas, no existan los registros
            $carrerasPersona    = CarrerasPersona::where('carrera_id', $inscripcion->carrera_id)
                                                ->where('persona_id', $persona->id)
                                                // ->where('gestion', $inscripcion->gestion)
                                                // ->where('turno_id', $request->nuevo_turno)
                                                // ->where('paralelo', $request->nuevo_paralelo)
                                                ->where('anio_vigente', $request->gestion)
                                                ->first();
            // Si no se encuentra ningun valor, se crea
            if(!$carrerasPersona)
            {
                // Se crea un nuevo registro
                $carrerasPersona                    = new CarrerasPersona();
                $carrerasPersona->user_id           = Auth::user()->id;
                $carrerasPersona->carrera_id        = $inscripcion->carrera_id;
                $carrerasPersona->persona_id        = $persona->id;
                $carrerasPersona->turno_id          = $request->turno;
                $carrerasPersona->gestion           = $inscripcion->gestion;
                $carrerasPersona->paralelo          = $request->paralelo;
                $carrerasPersona->fecha_inscripcion = $request->fecha_inscripcion;
                $carrerasPersona->anio_vigente      = $request->gestion;
                $carrerasPersona->sexo              = $persona->sexo;
                $carrerasPersona->vigencia          = 'Vigente';
                //$carrerasPersona->estado          = '';   APROBO/REPROBO/ABANDONO/NULL
                $carrerasPersona->save();
            }
            // Tenemos que crear una nueva inscripcion con los datos de la anterior inscripcion, pero diferenciarlo con la columna oyente
            $nueva_inscripcion                  = new Inscripcione();
            $nueva_inscripcion->user_id         = Auth::user()->id;
            $nueva_inscripcion->resolucion_id   = $inscripcion->resolucion_id;          // MOD
            $nueva_inscripcion->carrera_id      = $inscripcion->carrera_id;
            $nueva_inscripcion->asignatura_id   = $inscripcion->asignatura_id;
            $nueva_inscripcion->turno_id        = $request->turno;
            $nueva_inscripcion->persona_id      = $inscripcion->persona_id;
            $nueva_inscripcion->paralelo        = $request->paralelo;
            $nueva_inscripcion->semestre        = $inscripcion->semestre;
            $nueva_inscripcion->gestion         = $inscripcion->gestion;
            $nueva_inscripcion->anio_vigente    = $request->gestion;
            $nueva_inscripcion->fecha_registro  = $request->fecha_inscripcion;
            $nueva_inscripcion->nota_aprobacion = $inscripcion->nota_aprobacion;        // MOD
            $nueva_inscripcion->oyente          = 'Si';
            $nueva_inscripcion->troncal         = $inscripcion->troncal;
            //$nueva_inscripcion->aprobo        = 'Si', 'No', 'Cursando';
            $nueva_inscripcion->estado          = 'Cursando';  // Cuando acaba semestre/gestion cambiar a Finalizado
            $nueva_inscripcion->save();
            // Crearemos las notas correspondientes a esta inscripcion pero antes buscaremos si existe un docente ya asignado a esta asignatura
            $docente    = NotasPropuesta::where('asignatura_id', $nueva_inscripcion->asignatura_id)
                                        ->where('turno_id', $nueva_inscripcion->turno_id)
                                        ->where('paralelo', $nueva_inscripcion->paralelo)
                                        ->where('anio_vigente', $nueva_inscripcion->anio_vigente)
                                        ->first();
            // Por cada materia inscrita, ingresamos 4 registros correspondientes a los 4 bimestres
            for($i=1; $i<=4; $i++)
            {
                // Resgistramos en la tabla notas
                $nota                   = new Nota();
                $nota->user_id          = Auth::user()->id;
                $nota->resolucion_id    = $nueva_inscripcion->resolucion_id;          // MOD
                $nota->inscripcion_id   = $nueva_inscripcion->id;
                if($docente)
                {
                    $nota->docente_id   = $docente->docente_id;
                }
                $nota->persona_id       = $nueva_inscripcion->persona_id;
                $nota->asignatura_id    = $nueva_inscripcion->asignatura_id;
                $nota->turno_id         = $nueva_inscripcion->turno_id;
                $nota->paralelo         = $nueva_inscripcion->paralelo;
                $nota->anio_vigente     = $nueva_inscripcion->anio_vigente;
                $nota->trimestre        = $i;
                $nota->fecha_registro   = $nueva_inscripcion->fecha_registro;
                $nota->nota_aprobacion  = $nueva_inscripcion->nota_aprobacion;        // MOD
                $nota->save();
            }
        }
        return redirect('Persona/ver_detalle/'.$inscripcion->persona_id);
    }

    public function asignarPuntaje(Request $request)
    {
        $inscripcion    = Inscripcione::find($request->id);
        if($inscripcion)
        {
            // Hallamos al estudiante, la nota maxima para esa asignatura y las 4 notas correspondientes a esa inscripcion
            $persona        = Persona::find($inscripcion->persona_id);
            $notaAprobacion = $request->nota;
            $asignatura     = NotasPropuesta::where('asignatura_id', $inscripcion->asignatura_id)
                                        ->where('turno_id', $inscripcion->turno_id)
                                        ->where('paralelo', $inscripcion->paralelo)
                                        ->where('anio_vigente', $inscripcion->anio_vigente)
                                        ->first();
            if(!$asignatura)
            {
                $asignatura = Predefinida::where('activo', 'Si')
                                        ->first();
            }
            if($notaAprobacion && $asignatura)
            {                
                // Sacamos las notas finales por cada Bimestre
                do {
                    $total  = 0;
                    $primerBimestre     = mt_rand(1, 100);
                    $segundoBimestre    = mt_rand(1, 100);
                    $tercerBimestre     = mt_rand(1, 100);
                    $cuartoBimestre     = mt_rand(1, 100);
                    $total  = $primerBimestre + $segundoBimestre + $tercerBimestre + $cuartoBimestre;
                    $total = round($total/4);
                } while( $total <> $notaAprobacion);
                // Obtenemos los 4 registros pertenecientes a la inscripcion
                $notas  = Nota::where('inscripcion_id', $inscripcion->id)
                                ->get();
                foreach($notas as $nota)
                {
                    if($nota->trimestre == 1)
                    {
                        $notaAprobacion = $primerBimestre;
                    }
                    if($nota->trimestre == 2)
                    {
                        $notaAprobacion = $segundoBimestre;
                    }
                    if($nota->trimestre == 3)
                    {
                        $notaAprobacion = $tercerBimestre;
                    }
                    if($nota->trimestre == 4)
                    {
                        $notaAprobacion = $cuartoBimestre;
                    }
                    // Iteramos para encontrar la nota
                    do {
                        $total  = 0;
                        $aleatorio_asistencia       =  mt_rand(1, $asignatura->nota_asistencia);
                        $aleatorio_practicas        =  mt_rand(1, $asignatura->nota_practicas);
                        $aleatorio_primer_parcial   =  mt_rand(1, $asignatura->nota_primer_parcial);
                        $aleatorio_examen_final     =  mt_rand(1, $asignatura->nota_examen_final);
                        $aleatorio_extras           =  mt_rand(1, $asignatura->nota_puntos_ganados);
                        $total = $aleatorio_asistencia + $aleatorio_practicas + $aleatorio_primer_parcial + $aleatorio_examen_final + $aleatorio_extras;
                    } while( $total <> $notaAprobacion);
                    $nota->nota_asistencia      = $aleatorio_asistencia;
                    $nota->nota_practicas       = $aleatorio_practicas;
                    $nota->nota_primer_parcial  = $aleatorio_primer_parcial;
                    $nota->nota_examen_final    = $aleatorio_examen_final;
                    $nota->nota_puntos_ganados  = $aleatorio_extras;
                    $nota->nota_total           = $total;
                    $nota->finalizado           = 'Si';
                    $nota->registrado           = 'Si';
                    $nota->save();
                }
                $inscripcion->nota              = $request->nota;
                if($inscripcion->nota_aprobacion)
                {
                    $aprobo = ($request->nota >= $inscripcion->nota_aprobacion ? 'Si' : 'No');
                    $inscripcion->aprobo        = $aprobo;
                }
                $inscripcion->convalidacion_externa = 'Si';
                $inscripcion->estado                = 'Finalizado';
                $inscripcion->save();
            }
            // Ahora evaluaremos el estado de todas las asignaturas correspondientes a esta gestion
            // Buscamos las inscripciones correspondientes a esta gestion X
            $inscripciones  = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                        ->where('persona_id', $inscripcion->persona_id)
                                        ->where('gestion', $inscripcion->gestion)
                                        ->where('anio_vigente', $inscripcion->anio_vigente)
                                        ->get();
            // Hallamos la cantidad de materias inscritas
            $cantidadInscritas  = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                            ->where('persona_id', $inscripcion->persona_id)
                                            ->where('gestion', $inscripcion->gestion)
                                            ->where('anio_vigente', $inscripcion->anio_vigente)
                                            ->count();
            // Hallamos la cantidad de materias inscritas que finalizaron
            $cantidadFinalizadas    = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                                ->where('persona_id', $inscripcion->persona_id)
                                                ->where('gestion', $inscripcion->gestion)
                                                ->where('anio_vigente', $inscripcion->anio_vigente)
                                                ->where('estado', 'Finalizado')
                                                ->count();
            // Verificamos que se hayan finalizado todas las materias inscritas
            if($cantidadInscritas == $cantidadFinalizadas)
            {
                // Crearemos una variable para contar las materias que se aprobaron
                $cantidadAprobadas = 0;
                // Iteramos sobre las inscripciones para ver cuantas se aprobaron
                foreach($inscripciones as $materia)
                {
                    if($materia->aprobo == 'Si')
                    {
                        $cantidadAprobadas++;
                    }
                }
                // Buscaremos en la tabla carreras_personas el registro que esta asociado a estas inscripciones
                $carrerasPersona    = CarrerasPersona::where('carrera_id', $inscripcion->carrera_id)
                                                    ->where('persona_id', $inscripcion->persona_id)
                                                    ->where('gestion', $inscripcion->gestion)
                                                    ->where('anio_vigente', $inscripcion->anio_vigente)
                                                    ->first();
                // Si existe un registro que corresponda al grupo de inscripciones
                if($carrerasPersona)
                {
                    // Evaluamos si se aprobo la gestion o no
                    if($cantidadAprobadas == $cantidadInscritas)
                    {
                        $carrerasPersona->estado    = 'APROBO';
                    }
                    else
                    {
                        $carrerasPersona->estado    = 'REPROBO';
                    }
                    $carrerasPersona->save();
                }
            }
            return redirect('Persona/ver_detalle/'.$persona->id);
        }
        else
        {
            return redirect('Persona/listado');
        }
    }

    public function convalidarAsignaturaAprobada($inscripcion_id)
    {
        $inscripcion    = Inscripcione::find($inscripcion_id);
        // Comprobemos que no tiene una materia ya que compensa esta
        $asignaturaAprobada = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                        ->where('asignatura_id', $inscripcion->asignatura_id)
                                        ->where('persona_id', $inscripcion->persona_id)
                                        ->where('estado', 'Finalizado')
                                        ->where('aprobo', 'Si')
                                        ->first();
        if($asignaturaAprobada)
        {
            $notas  = Nota::where('inscripcion_id', $inscripcion->id)
                        ->get();
            foreach($notas as $nota){
                // Buscamos el registro de notas de la anterior asignatura aprobada y copiamos sus valores
                $registro   = Nota::where('inscripcion_id', $asignaturaAprobada->id)
                                ->where('trimestre', $nota->trimestre)
                                ->first();
                if($registro)
                {
                    $nota->fecha_registro       = date('Y-m-d');
                    $nota->nota_asistencia      = $registro->nota_asistencia;
                    $nota->nota_practicas       = $registro->nota_practicas;
                    $nota->nota_primer_parcial  = $registro->nota_primer_parcial;
                    $nota->nota_examen_final    = $registro->nota_examen_final;
                    $nota->nota_puntos_ganados  = $registro->nota_puntos_ganados;
                    $nota->nota_total           = $registro->nota_total;
                    $nota->finalizado           = $registro->finalizado;
                    $nota->registrado           = $registro->registrado;
                    $nota->save();
                }
            }
            $inscripcion->fecha_registro    = date('Y-m-d');
            $inscripcion->nota              = $asignaturaAprobada->nota;
            $inscripcion->segundo_turno     = $asignaturaAprobada->segundo_turno;
            $inscripcion->aprobo            = $asignaturaAprobada->aprobo;
            $inscripcion->estado            = $asignaturaAprobada->estado;
            $inscripcion->save();
        }
        return redirect('Persona/ver_detalle/'.$inscripcion->persona_id);
    }

    public function regularizarAsignatura(Request $request)
    {
        $inscripcion    = Inscripcione::find($request->id);
        if($inscripcion)
        {
            // Hallamos al estudiante, la nota maxima para esa asignatura y las 4 notas correspondientes a esa inscripcion
            $persona        = Persona::find($inscripcion->persona_id);
            $notaAprobacion = $request->nota;
            $asignatura     = NotasPropuesta::where('asignatura_id', $inscripcion->asignatura_id)
                                        ->where('turno_id', $inscripcion->turno_id)
                                        ->where('paralelo', $inscripcion->paralelo)
                                        ->where('anio_vigente', $inscripcion->anio_vigente)
                                        ->first();
            if(!$asignatura)
            {
                $asignatura = Predefinida::where('activo', 'Si')
                                        ->first();
            }
            if($notaAprobacion && $asignatura)
            {                
                // Sacamos las notas finales por cada Bimestre
                do {
                    $total  = 0;
                    $primerBimestre     = mt_rand(1, 100);
                    $segundoBimestre    = mt_rand(1, 100);
                    $tercerBimestre     = mt_rand(1, 100);
                    $cuartoBimestre     = mt_rand(1, 100);
                    $total  = $primerBimestre + $segundoBimestre + $tercerBimestre + $cuartoBimestre;
                    $total = round($total/4);
                } while( $total <> $notaAprobacion);
                // Obtenemos cada registro de la inscripcion, si no se encontrase, lo crea
                $notaUno    = Nota::where('inscripcion_id', $inscripcion->id)
                                ->where('trimestre', 1)
                                ->first();
                $notaDos    = Nota::where('inscripcion_id', $inscripcion->id)
                                ->where('trimestre', 2)
                                ->first();
                $notaTres   = Nota::where('inscripcion_id', $inscripcion->id)
                                ->where('trimestre', 3)
                                ->first();
                $notaCuatro = Nota::where('inscripcion_id', $inscripcion->id)
                                ->where('trimestre', 4)
                                ->first();
                if(!$notaUno)
                {
                    $notaUno                    = new Nota();
                    $notaUno->user_id           = Auth::user()->id;
                    $notaUno->resolucion_id     = $inscripcion->resolucion_id;          // MOD
                    $notaUno->inscripcion_id    = $inscripcion->id;
                    if($asignatura){
                        $notaUno->docente_id    = $asignatura->docente_id;
                    }
                    $notaUno->persona_id        = $inscripcion->persona_id;
                    $notaUno->asignatura_id     = $inscripcion->asignatura_id;
                    $notaUno->turno_id          = $inscripcion->turno_id;
                    $notaUno->paralelo          = $inscripcion->paralelo;
                    $notaUno->anio_vigente      = $inscripcion->anio_vigente;
                    $notaUno->trimestre         = 1;
                    $notaUno->fecha_registro    = date('Y-m-d');
                    $notaUno->nota_aprobacion   = $inscripcion->nota_aprobacion;        // MOD
                    $notaUno->save();
                }
                if(!$notaDos)
                {
                    $notaDos                    = new Nota();
                    $notaDos->user_id           = Auth::user()->id;
                    $notaDos->resolucion_id     = $inscripcion->resolucion_id;          // MOD
                    $notaDos->inscripcion_id    = $inscripcion->id;
                    if($asignatura){
                        $notaDos->docente_id    = $asignatura->docente_id;
                    }
                    $notaDos->persona_id        = $inscripcion->persona_id;
                    $notaDos->asignatura_id     = $inscripcion->asignatura_id;
                    $notaDos->turno_id          = $inscripcion->turno_id;
                    $notaDos->paralelo          = $inscripcion->paralelo;
                    $notaDos->anio_vigente      = $inscripcion->anio_vigente;
                    $notaDos->trimestre         = 2;
                    $notaDos->fecha_registro    = date('Y-m-d');
                    $notaDos->nota_aprobacion   = $inscripcion->nota_aprobacion;        // MOD
                    $notaDos->save();
                }
                if(!$notaTres)
                {
                    $notaTres                    = new Nota();
                    $notaTres->user_id           = Auth::user()->id;
                    $notaTres->resolucion_id     = $inscripcion->resolucion_id;          // MOD
                    $notaTres->inscripcion_id    = $inscripcion->id;
                    if($asignatura){
                        $notaTres->docente_id    = $asignatura->docente_id;
                    }
                    $notaTres->persona_id        = $inscripcion->persona_id;
                    $notaTres->asignatura_id     = $inscripcion->asignatura_id;
                    $notaTres->turno_id          = $inscripcion->turno_id;
                    $notaTres->paralelo          = $inscripcion->paralelo;
                    $notaTres->anio_vigente      = $inscripcion->anio_vigente;
                    $notaTres->trimestre         = 3;
                    $notaTres->fecha_registro    = date('Y-m-d');
                    $notaTres->nota_aprobacion   = $inscripcion->nota_aprobacion;        // MOD
                    $notaTres->save();
                }
                if(!$notaCuatro)
                {
                    $notaCuatro                    = new Nota();
                    $notaCuatro->user_id           = Auth::user()->id;
                    $notaCuatro->resolucion_id     = $inscripcion->resolucion_id;          // MOD
                    $notaCuatro->inscripcion_id    = $inscripcion->id;
                    if($asignatura){
                        $notaCuatro->docente_id    = $asignatura->docente_id;
                    }
                    $notaCuatro->persona_id        = $inscripcion->persona_id;
                    $notaCuatro->asignatura_id     = $inscripcion->asignatura_id;
                    $notaCuatro->turno_id          = $inscripcion->turno_id;
                    $notaCuatro->paralelo          = $inscripcion->paralelo;
                    $notaCuatro->anio_vigente      = $inscripcion->anio_vigente;
                    $notaCuatro->trimestre         = 4;
                    $notaCuatro->fecha_registro    = date('Y-m-d');
                    $notaCuatro->nota_aprobacion   = $inscripcion->nota_aprobacion;        // MOD
                    $notaCuatro->save();
                }
                // Obtenemos los 4 registros pertenecientes a la inscripcion
                $notas  = Nota::where('inscripcion_id', $inscripcion->id)
                                ->get();
                foreach($notas as $nota)
                {
                    if($nota->trimestre == 1)
                    {
                        $notaAprobacion = $primerBimestre;
                    }
                    if($nota->trimestre == 2)
                    {
                        $notaAprobacion = $segundoBimestre;
                    }
                    if($nota->trimestre == 3)
                    {
                        $notaAprobacion = $tercerBimestre;
                    }
                    if($nota->trimestre == 4)
                    {
                        $notaAprobacion = $cuartoBimestre;
                    }
                    // Iteramos para encontrar la nota
                    do {
                        $total  = 0;
                        $aleatorio_asistencia       =  mt_rand(1, $asignatura->nota_asistencia);
                        $aleatorio_practicas        =  mt_rand(1, $asignatura->nota_practicas);
                        $aleatorio_primer_parcial   =  mt_rand(1, $asignatura->nota_primer_parcial);
                        $aleatorio_examen_final     =  mt_rand(1, $asignatura->nota_examen_final);
                        $aleatorio_extras           =  mt_rand(1, $asignatura->nota_puntos_ganados);
                        $total = $aleatorio_asistencia + $aleatorio_practicas + $aleatorio_primer_parcial + $aleatorio_examen_final + $aleatorio_extras;
                    } while( $total <> $notaAprobacion);
                    $nota->nota_asistencia      = $aleatorio_asistencia;
                    $nota->nota_practicas       = $aleatorio_practicas;
                    $nota->nota_primer_parcial  = $aleatorio_primer_parcial;
                    $nota->nota_examen_final    = $aleatorio_examen_final;
                    $nota->nota_puntos_ganados  = $aleatorio_extras;
                    $nota->nota_total           = $total;
                    $nota->finalizado           = 'Si';
                    $nota->registrado           = 'Si';
                    $nota->save();
                }
                $inscripcion->nota              = $request->nota;
                if($inscripcion->nota_aprobacion)
                {
                    $aprobo = ($request->nota >= $inscripcion->nota_aprobacion ? 'Si' : 'No');
                    $inscripcion->aprobo        = $aprobo;
                }
                $inscripcion->estado                = 'Finalizado';
                $inscripcion->save();
            }
            // Ahora evaluaremos el estado de todas las asignaturas correspondientes a esta gestion
            // Buscamos las inscripciones correspondientes a esta gestion X
            $inscripciones  = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                        ->where('persona_id', $inscripcion->persona_id)
                                        ->where('gestion', $inscripcion->gestion)
                                        ->where('anio_vigente', $inscripcion->anio_vigente)
                                        ->get();
            // Hallamos la cantidad de materias inscritas
            $cantidadInscritas  = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                            ->where('persona_id', $inscripcion->persona_id)
                                            ->where('gestion', $inscripcion->gestion)
                                            ->where('anio_vigente', $inscripcion->anio_vigente)
                                            ->count();
            // Hallamos la cantidad de materias inscritas que finalizaron
            $cantidadFinalizadas    = Inscripcione::where('carrera_id', $inscripcion->carrera_id)
                                                ->where('persona_id', $inscripcion->persona_id)
                                                ->where('gestion', $inscripcion->gestion)
                                                ->where('anio_vigente', $inscripcion->anio_vigente)
                                                ->where('estado', 'Finalizado')
                                                ->count();
            // Verificamos que se hayan finalizado todas las materias inscritas
            if($cantidadInscritas == $cantidadFinalizadas)
            {
                // Crearemos una variable para contar las materias que se aprobaron
                $cantidadAprobadas = 0;
                // Iteramos sobre las inscripciones para ver cuantas se aprobaron
                foreach($inscripciones as $materia)
                {
                    if($materia->aprobo == 'Si')
                    {
                        $cantidadAprobadas++;
                    }
                }
                // Buscaremos en la tabla carreras_personas el registro que esta asociado a estas inscripciones
                $carrerasPersona    = CarrerasPersona::where('carrera_id', $inscripcion->carrera_id)
                                                    ->where('persona_id', $inscripcion->persona_id)
                                                    ->where('gestion', $inscripcion->gestion)
                                                    ->where('anio_vigente', $inscripcion->anio_vigente)
                                                    ->first();
                // Si existe un registro que corresponda al grupo de inscripciones
                if($carrerasPersona)
                {
                    // Evaluamos si se aprobo la gestion o no
                    if($cantidadAprobadas == $cantidadInscritas)
                    {
                        $carrerasPersona->estado    = 'APROBO';
                    }
                    else
                    {
                        $carrerasPersona->estado    = 'REPROBO';
                    }
                    $carrerasPersona->save();
                }
            }
            return redirect('Persona/ver_detalle/'.$persona->id);
        }
        else
        {
            return redirect('Persona/listado');
        }
    }

    public function pruebaMigracion()
    {
        // Agarramos las inscripciones respectivas al anio X
        $inscripciones  = Inscripcione::where('anio_vigente', 2012)
                                    ->get();
                                    //->count();
        $notas          = Nota::count();
        //dd($notas);
        foreach($inscripciones as $inscripcion)
        {
            //dd($inscripcion->id);
            dd($inscripcion->persona->cedula);
            // Obtenemos las notas correspondientes a esa inscripcion_id
            $notas  = Nota::where('inscripcion_id', $inscripcion->id)
                            ->get();
            
            dd(count($notas));
            // Caso 1 -> 4 registros
            if(count($notas) == 4)
            {
                // Si tiene todo no pasa nada
            }
            // Caso 2 -> 3 registros
            if(count($notas) == 3)
            {
                // Le falta un registro, crear un registro con 0 en sus puntuaciones
                // Cual es el trimestre faltante?, buscaremos los semestres existentes
                $array_trimestres   = array();
                foreach($notas as $nota)
                {
                    
                }
            }
            // Caso 3 -> 2 registros
            if(count($notas) == 2)
            {
                // Le falta dos registros, crear 2 copiando los otros 2 existentes
            }
            // Caso 4 -> 1 registros
            if(count($notas) == 1)
            {
                // Le falta tres registros, crear tres registros copiandose del unico existente
            }
            // Caso 5 -> 0 registros    inscripcion_id->37630(14229120)
            if(count($notas) == 0)
            {
                // No tiene registros en notas, por tanto crear registro con nota_total
                // igual al de la inscripcion, si lo tiene, si no tiene
            }
        }
        // de todas las inscripciones del 2011, verificar por cada inscripcione
        // que tenga sus respectivos 4 registros por inscripcion
        
        
        
        
        // 5. si le falta 4 registros.... pendiente de evaluacion
        dd($inscripciones);
    }

}