<?php

namespace App\Imports;

use App\Asignatura;
use App\Carrera;
use App\CarrerasPersona;
use App\Inscripcione;
use App\Nota;
use App\NotasPropuesta;
use App\Persona;
use App\Turno;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;

class AsignaturaNotasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Primero verificamos que la fila $row que leemos sea de datos y no parte del heading
        if(is_numeric($row[1]))         // Si es numerico (si es un ID de inscripciones)
        {
            // Tomamos la inscripcion y la cedula de identidad y verificamos que exista en la base de datos
            $inscripcion    = Inscripcione::find($row[0]);
            $persona        = Persona::where('cedula', $row[1])->first();
            // Buscamos el anio_ingreso, para hacer seguimiento de la malla curricular de ese anio_ingreso
            $anio_ingreso   = CarrerasPersona::where('persona_id', $persona->id)
                                            ->min('anio_vigente');
            if(!$anio_ingreso)
            {
                $anio_ingreso   = Inscripcione::where('persona_id', $persona->id)
                                            ->min('anio_vigente');
                if(!$anio_ingreso)
                {
                    $anio_ingreso   = $row[9];
                }
            }
            if($persona)         // Si existe un registro, procedemos
            {
                // Si existe una inscripcion (un id)
                if($inscripcion)
                {
                    $carrera    = Carrera::where('id', $inscripcion->carrera_id)->first();
                    $asignatura = Asignatura::where('id', $inscripcion->asignatura_id)->first();
                    $turno      = Turno::where('id', $inscripcion->turno_id)->first();
                }
                else    // un nuevo registro creado desde el excel
                {
                    $carrera    = Carrera::where('nombre', $row[3])->first();
                    $asignatura = Asignatura::where('sigla', $row[4])
                                            ->where('nombre', $row[5])
                                            // ->where('ciclo', $row[4])
                                            ->where('anio_vigente', $anio_ingreso)
                                            ->first();
                    $turno      = Turno::where('descripcion', $row[8])->first();
                }
                // Preguntaremos si encontramos esos registros
                if($carrera && $asignatura && $turno)         // Si carrera, asignatura y turno estan definidos (se encontro valores)
                {
                    // Preguntamos si coinciden carrera con asignatura
                    if($carrera->id == $asignatura->carrera_id)     // Si el id de carrera en la tabla carrera es igual a carrera_id en la tabla asignaturas
                    {
                        // Capturamos variables de session
                        // $numero = session('numero');
                        // En carreras_personas, inscripciones, notas
                        // Vemos si existe un registro en carreras_personas con las variables
                        $registro   = CarrerasPersona::where('carrera_id', $carrera->id)
                                                    ->where('persona_id', $persona->id)
                                                    // ->where('turno_id', $turno->id)
                                                    // ->where('gestion', $row[5])
                                                    //->where('paralelo', $row[8])
                                                    ->where('anio_vigente', $row[10])
                                                    ->first();
                        // Si no existe el registro, creamos uno nuevo, si existe, pasamos de largo
                        if(!$registro)
                        {
                            $carrerasPersona                        = new CarrerasPersona();
                            $carrerasPersona->user_id               = Auth::user()->id;
                            $carrerasPersona->carrera_id            = $carrera->id;
                            $carrerasPersona->persona_id            = $persona->id;
                            $carrerasPersona->turno_id              = $turno->id;
                            $carrerasPersona->gestion               = $row[6];
                            $carrerasPersona->paralelo              = $row[9];
                            $carrerasPersona->fecha_inscripcion     = date('Y-m-d');
                            $carrerasPersona->anio_vigente          = $row[10];
                            $carrerasPersona->sexo                  = $persona->sexo;
                            $carrerasPersona->save();
                        }
                        // Tenemos que crear inscripciones
                        // Buscaremos si existe un registro con los datos enviados para inscripciones
                        if(!$inscripcion)
                        {
                            $inscripcion    = Inscripcione::where('carrera_id', $carrera->id)
                                                        ->where('asignatura_id', $asignatura->id)
                                                        ->where('turno_id', $turno->id)
                                                        ->where('persona_id', $persona->id)
                                                        ->where('gestion', $row[6])
                                                        ->where('paralelo', $row[9])
                                                        ->where('anio_vigente', $row[10])
                                                        ->first();
                            // Si no existe el inscripcion, creamos uno nuevo, si existe, pasamos de largo
                            if(!$inscripcion)
                            {
                                $inscripcion                        = new Inscripcione();
                                $inscripcion->user_id               = Auth::user()->id;
                                $inscripcion->resolucion_id         = $carrera->resolucion->id;
                                $inscripcion->carrera_id            = $carrera->id;
                                $inscripcion->asignatura_id         = $asignatura->id;
                                $inscripcion->turno_id              = $turno->id;
                                $inscripcion->persona_id            = $persona->id;
                                $inscripcion->paralelo              = $row[9];
                                $inscripcion->semestre              = $asignatura->semestre;
                                $inscripcion->gestion               = $row[6];
                                $inscripcion->anio_vigente          = $row[10];
                                $inscripcion->fecha_registro        = date('Y-m-d');
                                $inscripcion->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                                $inscripcion->troncal               = 'Si';
                                $inscripcion->save();
                            }
                        }
                        // Buscaremos si existe un docente ya asignado a esta materia
                        $docente = NotasPropuesta::where('asignatura_id', $asignatura->id)
                                                ->where('turno_id', $turno->id)
                                                ->where('paralelo', $row[9])
                                                ->where('anio_vigente', $row[10])
                                                ->first();
                        // Tenemos que crear notas
                        // Validamos en caso de que la celda se encuentre vacia
                        ($row[12] ? $row[12] = $row[12] : $row[12] = 0);
                        ($row[13] ? $row[13] = $row[13] : $row[13] = 0);
                        ($row[14] ? $row[14] = $row[14] : $row[14] = 0);
                        ($row[15] ? $row[15] = $row[15] : $row[15] = 0);
                        ($row[16] ? $row[16] = $row[16] : $row[16] = 0);
                        ($row[17] ? $row[17] = $row[17] : $row[17] = 0);
                        ($row[18] ? $row[18] = $row[18] : $row[18] = 0);
                        ($row[19] ? $row[19] = $row[19] : $row[19] = 0);
                        ($row[20] ? $row[20] = $row[20] : $row[20] = 0);
                        ($row[21] ? $row[21] = $row[21] : $row[21] = 0);
                        ($row[22] ? $row[22] = $row[22] : $row[22] = 0);
                        ($row[23] ? $row[23] = $row[23] : $row[23] = 0);
                        ($row[24] ? $row[24] = $row[24] : $row[24] = 0);
                        ($row[25] ? $row[25] = $row[25] : $row[25] = 0);
                        ($row[26] ? $row[26] = $row[26] : $row[26] = 0);
                        ($row[27] ? $row[27] = $row[27] : $row[27] = 0);
                        ($row[28] ? $row[28] = $row[28] : $row[28] = 0);
                        ($row[29] ? $row[29] = $row[29] : $row[29] = 0);
                        ($row[30] ? $row[30] = $row[30] : $row[30] = 0);
                        ($row[31] ? $row[31] = $row[31] : $row[31] = 0);
                        // Preguntamos cual es el ciclo de la asignatura
                        if($row[7] == 'Semestral')          // Si es Semestral
                        {
                            // Leera 2 bimestres y replicara 2
                            // Primero calcularemos para llenar la nota total del registro 1
                            $totalUno = $row[12] + $row[13] + $row[14] + $row[15];
                            $necesario = 100 - $totalUno;
                            if($necesario >= 10)
                            {
                                $totalUno = $totalUno + $row[16];
                            }
                            else
                            {
                                if($necesario <= $row[16])
                                {
                                    $totalUno = $totalUno + $necesario;
                                }
                                else
                                {
                                    $totalUno = $totalUno + $row[16];
                                }
                            }
                            // Buscaremos si existe registro de notaUno
                            $notaUno    = Nota::where('inscripcion_id', $inscripcion->id)
                                            ->where('trimestre', 1)
                                            ->first();
                            // Creando registros para bimestre 1
                            if(!$notaUno)
                            {
                                $notaUno                    = new Nota();
                            }
                            $notaUno->user_id               = Auth::user()->id;
                            $notaUno->resolucion_id         = $carrera->resolucion->id;
                            $notaUno->inscripcion_id        = $inscripcion->id;
                            if($docente)
                            {
                                $notaUno->docente_id        = $docente->docente_id;
                            }
                            $notaUno->persona_id            = $persona->id;
                            $notaUno->asignatura_id         = $asignatura->id;
                            $notaUno->turno_id              = $turno->id;
                            $notaUno->paralelo              = $row[10];
                            $notaUno->anio_vigente          = $row[11];
                            $notaUno->trimestre             = 1;
                            $notaUno->fecha_registro        = date('Y-m-d');
                            $notaUno->nota_asistencia       = $row[12];
                            $notaUno->nota_practicas        = $row[13];
                            $notaUno->nota_primer_parcial   = $row[14];
                            $notaUno->nota_examen_final     = $row[15];
                            $notaUno->nota_puntos_ganados   = $row[16];
                            $notaUno->nota_total            = $totalUno;
                            $notaUno->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                            $notaUno->finalizado            = 'Si';
                            //$notaUno->numero_importacion    = $numero;
                            $notaUno->save();
                            // Primero calcularemos para llenar la nota total del registro 2
                            $totalDos = $row[17] + $row[18] + $row[19] + $row[20];
                            $necesario = 100 - $totalDos;
                            if($necesario >= 10)
                            {
                                $totalDos = $totalDos + $row[21];
                            }
                            else
                            {
                                if($necesario <= $row[21])
                                {
                                    $totalDos = $totalDos + $necesario;
                                }
                                else
                                {
                                    $totalDos = $totalDos + $row[21];
                                }
                            }
                            // Buscaremos si existe registro de notaDos
                            $notaDos    = Nota::where('inscripcion_id', $inscripcion->id)
                                            ->where('trimestre', 2)
                                            ->first();
                            // Creando registros para bimestre 2
                            if(!$notaDos)
                            {
                                $notaDos                    = new Nota();
                            }
                            $notaDos->user_id               = Auth::user()->id;
                            $notaDos->resolucion_id         = $carrera->resolucion->id;
                            $notaDos->inscripcion_id        = $inscripcion->id;
                            if($docente)
                            {
                                $notaDos->docente_id        = $docente->docente_id;
                            }
                            $notaDos->persona_id            = $persona->id;
                            $notaDos->asignatura_id         = $asignatura->id;
                            $notaDos->turno_id              = $turno->id;
                            $notaDos->paralelo              = $row[10];
                            $notaDos->anio_vigente          = $row[11];
                            $notaDos->trimestre             = 2;
                            $notaDos->fecha_registro        = date('Y-m-d');
                            $notaDos->nota_asistencia       = $row[17];
                            $notaDos->nota_practicas        = $row[18];
                            $notaDos->nota_primer_parcial   = $row[19];
                            $notaDos->nota_examen_final     = $row[20];
                            $notaDos->nota_puntos_ganados   = $row[21];
                            $notaDos->nota_total            = $totalDos;
                            $notaDos->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                            $notaDos->finalizado            = 'Si';
                            //$notaDos->numero_importacion    = $numero;
                            $notaDos->save();
                            // Buscaremos si existe registro de notaTres
                            $notaTres    = Nota::where('inscripcion_id', $inscripcion->id)
                                            ->where('trimestre', 3)
                                            ->first();
                            // Creando registros para bimestre 3
                            if(!$notaTres)
                            {
                                $notaTres                    = new Nota();
                            }
                            $notaTres->user_id               = Auth::user()->id;
                            $notaTres->resolucion_id         = $carrera->resolucion->id;
                            $notaTres->inscripcion_id        = $inscripcion->id;
                            if($docente)
                            {
                                $notaTres->docente_id        = $docente->docente_id;
                            }
                            $notaTres->persona_id            = $persona->id;
                            $notaTres->asignatura_id         = $asignatura->id;
                            $notaTres->turno_id              = $turno->id;
                            $notaTres->paralelo              = $row[10];
                            $notaTres->anio_vigente          = $row[11];
                            $notaTres->trimestre             = 3;
                            $notaTres->fecha_registro        = date('Y-m-d');
                            $notaTres->nota_asistencia       = $notaUno->nota_asistencia;
                            $notaTres->nota_practicas        = $notaUno->nota_practicas;
                            $notaTres->nota_primer_parcial   = $notaUno->nota_primer_parcial;
                            $notaTres->nota_examen_final     = $notaUno->nota_examen_final;
                            $notaTres->nota_puntos_ganados   = $notaUno->nota_puntos_ganados;
                            $notaTres->nota_total            = $notaUno->nota_total;
                            $notaTres->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                            $notaTres->finalizado            = 'Si';
                            //$notaTres->numero_importacion    = $numero;
                            $notaTres->save();
                            // Buscaremos si existe registro de notaCuatro
                            $notaCuatro     = Nota::where('inscripcion_id', $inscripcion->id)
                                                ->where('trimestre', 4)
                                                ->first();
                            // Creando registros para bimestre 4
                            if(!$notaCuatro)
                            {
                                $notaCuatro                    = new Nota();
                            }
                            $notaCuatro->user_id               = Auth::user()->id;
                            $notaCuatro->resolucion_id         = $carrera->resolucion->id;
                            $notaCuatro->inscripcion_id        = $inscripcion->id;
                            if($docente)
                            {
                                $notaCuatro->docente_id        = $docente->docente_id;
                            }
                            $notaCuatro->persona_id            = $persona->id;
                            $notaCuatro->asignatura_id         = $asignatura->id;
                            $notaCuatro->turno_id              = $turno->id;
                            $notaCuatro->paralelo              = $row[10];
                            $notaCuatro->anio_vigente          = $row[11];
                            $notaCuatro->trimestre             = 4;
                            $notaCuatro->fecha_registro        = date('Y-m-d');
                            $notaCuatro->nota_asistencia       = $notaDos->nota_asistencia;
                            $notaCuatro->nota_practicas        = $notaDos->nota_practicas;
                            $notaCuatro->nota_primer_parcial   = $notaDos->nota_primer_parcial;
                            $notaCuatro->nota_examen_final     = $notaDos->nota_examen_final;
                            $notaCuatro->nota_puntos_ganados   = $notaDos->nota_puntos_ganados;
                            $notaCuatro->nota_total            = $notaDos->nota_total;
                            $notaCuatro->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                            $notaCuatro->finalizado            = 'Si';
                            //$notaCuatro->numero_importacion    = $numero;
                            $notaCuatro->save();
                        }
                        if($row[7] == 'Anual')              // Si es Anual
                        {
                            // Leera 4 bimestres y replicara 0
                            // Primero calcularemos para llenar la nota total del registro 1
                            $totalUno = $row[12] + $row[13] + $row[14] + $row[15];
                            $necesario = 100 - $totalUno;
                            if($necesario >= 10)
                            {
                                $totalUno = $totalUno + $row[16];
                            }
                            else
                            {
                                if($necesario <= $row[16])
                                {
                                    $totalUno = $totalUno + $necesario;
                                }
                                else
                                {
                                    $totalUno = $totalUno + $row[16];
                                }
                            }
                            // Buscaremos si existe registro de notaUno
                            $notaUno    = Nota::where('inscripcion_id', $inscripcion->id)
                                            ->where('trimestre', 1)
                                            ->first();
                            // Creando registros para bimestre 1
                            if(!$notaUno)
                            {
                                $notaUno                    = new Nota();
                            }
                            $notaUno->user_id               = Auth::user()->id;
                            $notaUno->resolucion_id         = $carrera->resolucion->id;
                            $notaUno->inscripcion_id        = $inscripcion->id;
                            if($docente)
                            {
                                $notaUno->docente_id        = $docente->docente_id;
                            }
                            $notaUno->persona_id            = $persona->id;
                            $notaUno->asignatura_id         = $asignatura->id;
                            $notaUno->turno_id              = $turno->id;
                            $notaUno->paralelo              = $row[10];
                            $notaUno->anio_vigente          = $row[11];
                            $notaUno->trimestre             = 1;
                            $notaUno->fecha_registro        = date('Y-m-d');
                            $notaUno->nota_asistencia       = $row[12];
                            $notaUno->nota_practicas        = $row[13];
                            $notaUno->nota_primer_parcial   = $row[14];
                            $notaUno->nota_examen_final     = $row[15];
                            $notaUno->nota_puntos_ganados   = $row[16];
                            $notaUno->nota_total            = $totalUno;
                            $notaUno->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                            $notaUno->finalizado            = 'Si';
                            //$notaUno->numero_importacion    = $numero;
                            $notaUno->save();
                            // Primero calcularemos para llenar la nota total del registro 2
                            $totalDos = $row[17] + $row[18] + $row[19] + $row[20];
                            $necesario = 100 - $totalDos;
                            if($necesario >= 10)
                            {
                                $totalDos = $totalDos + $row[21];
                            }
                            else
                            {
                                if($necesario <= $row[21])
                                {
                                    $totalDos = $totalDos + $necesario;
                                }
                                else
                                {
                                    $totalDos = $totalDos + $row[21];
                                }
                            }
                            // Buscaremos si existe registro de notaDos
                            $notaDos    = Nota::where('inscripcion_id', $inscripcion->id)
                                            ->where('trimestre', 2)
                                            ->first();
                            // Creando registros para bimestre 2
                            if(!$notaDos)
                            {
                                $notaDos                    = new Nota();
                            }
                            $notaDos->user_id               = Auth::user()->id;
                            $notaDos->resolucion_id         = $carrera->resolucion->id;
                            $notaDos->inscripcion_id        = $inscripcion->id;
                            if($docente)
                            {
                                $notaDos->docente_id        = $docente->docente_id;
                            }
                            $notaDos->persona_id            = $persona->id;
                            $notaDos->asignatura_id         = $asignatura->id;
                            $notaDos->turno_id              = $turno->id;
                            $notaDos->paralelo              = $row[10];
                            $notaDos->anio_vigente          = $row[11];
                            $notaDos->trimestre             = 2;
                            $notaDos->fecha_registro        = date('Y-m-d');
                            $notaDos->nota_asistencia       = $row[17];
                            $notaDos->nota_practicas        = $row[18];
                            $notaDos->nota_primer_parcial   = $row[19];
                            $notaDos->nota_examen_final     = $row[20];
                            $notaDos->nota_puntos_ganados   = $row[21];
                            $notaDos->nota_total            = $totalDos;
                            $notaDos->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                            $notaDos->finalizado            = 'Si';
                            //$notaDos->numero_importacion    = $numero;
                            $notaDos->save();
                            // Primero calcularemos para llenar la nota total del registro 3
                            $totalTres = $row[22] + $row[23] + $row[24] + $row[25];
                            $necesario = 100 - $totalTres;
                            if($necesario >= 10)
                            {
                                $totalTres = $totalTres + $row[26];
                            }
                            else
                            {
                                if($necesario <= $row[26])
                                {
                                    $totalTres = $totalTres + $necesario;
                                }
                                else
                                {
                                    $totalTres = $totalTres + $row[26];
                                }
                            }
                            // Buscaremos si existe registro de notaTres
                            $notaTres    = Nota::where('inscripcion_id', $inscripcion->id)
                                            ->where('trimestre', 3)
                                            ->first();
                            // Creando registros para bimestre 3
                            if(!$notaTres)
                            {
                                $notaTres                    = new Nota();
                            }
                            $notaTres->user_id               = Auth::user()->id;
                            $notaTres->resolucion_id         = $carrera->resolucion->id;
                            $notaTres->inscripcion_id        = $inscripcion->id;
                            if($docente)
                            {
                                $notaTres->docente_id        = $docente->docente_id;
                            }
                            $notaTres->persona_id            = $persona->id;
                            $notaTres->asignatura_id         = $asignatura->id;
                            $notaTres->turno_id              = $turno->id;
                            $notaTres->paralelo              = $row[10];
                            $notaTres->anio_vigente          = $row[11];
                            $notaTres->trimestre             = 3;
                            $notaTres->fecha_registro        = date('Y-m-d');
                            $notaTres->nota_asistencia       = $row[22];
                            $notaTres->nota_practicas        = $row[23];
                            $notaTres->nota_primer_parcial   = $row[24];
                            $notaTres->nota_examen_final     = $row[25];
                            $notaTres->nota_puntos_ganados   = $row[26];
                            $notaTres->nota_total            = $totalTres;
                            $notaTres->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                            $notaTres->finalizado            = 'Si';
                            //$notaTres->numero_importacion    = $numero;
                            $notaTres->save();
                            // Primero calcularemos para llenar la nota total del registro 4
                            $totalCuatro = $row[27] + $row[28] + $row[29] + $row[30];
                            $necesario = 100 - $totalCuatro;
                            if($necesario >= 10)
                            {
                                $totalCuatro = $totalCuatro + $row[31];
                            }
                            else
                            {
                                if($necesario <= $row[31])
                                {
                                    $totalCuatro = $totalCuatro + $necesario;
                                }
                                else
                                {
                                    $totalCuatro = $totalCuatro + $row[31];
                                }
                            }
                            // Buscaremos si existe registro de notaCuatro
                            $notaCuatro     = Nota::where('inscripcion_id', $inscripcion->id)
                                                ->where('trimestre', 4)
                                                ->first();
                            // Creando registros para bimestre 4
                            if(!$notaCuatro)
                            {
                                $notaCuatro                    = new Nota();
                            }
                            $notaCuatro->user_id               = Auth::user()->id;
                            $notaCuatro->resolucion_id         = $carrera->resolucion->id;
                            $notaCuatro->inscripcion_id        = $inscripcion->id;
                            if($docente)
                            {
                                $notaCuatro->docente_id        = $docente->docente_id;
                            }
                            $notaCuatro->persona_id            = $persona->id;
                            $notaCuatro->asignatura_id         = $asignatura->id;
                            $notaCuatro->turno_id              = $turno->id;
                            $notaCuatro->paralelo              = $row[10];
                            $notaCuatro->anio_vigente          = $row[11];
                            $notaCuatro->trimestre             = 4;
                            $notaCuatro->fecha_registro        = date('Y-m-d');
                            $notaCuatro->nota_asistencia       = $row[27];
                            $notaCuatro->nota_practicas        = $row[28];
                            $notaCuatro->nota_primer_parcial   = $row[29];
                            $notaCuatro->nota_examen_final     = $row[30];
                            $notaCuatro->nota_puntos_ganados   = $row[31];
                            $notaCuatro->nota_total            = $totalCuatro;
                            $notaCuatro->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                            $notaCuatro->finalizado            = 'Si';
                            //$notaCuatro->numero_importacion    = $numero;
                            $notaCuatro->save();
                        }
                        // Actualizamos inscripcion
                        // Sumamos las notas
                        $totalNotas = $notaUno->nota_total + $notaDos->nota_total + $notaTres->nota_total + $notaCuatro->nota_total;
                        $totalNotas = round($totalNotas/4);
                        if(!$row[32] || $row[32] == 'No')       // Si la casilla de convalidado esta vacia, o si esta con el valor No
                        {
                            // Comparamos con respecto a la nota de aprobacion y registramos
                            ($totalNotas >= $inscripcion->nota_aprobacion ? $aprobo = 'Si' : $aprobo = 'No');
                            $inscripcion->nota      = $totalNotas;
                            $inscripcion->aprobo    = $aprobo;
                            $inscripcion->estado    = 'Finalizado';
                            $inscripcion->save();
                        }
                        else        // La celda de convalidado tiene un valor diferente a NO, que es SI
                        {
                            $inscripcion->nota      = $row[34];
                            ($row[34] >= $inscripcion->nota_aprobacion ? $aprobo = 'Si' : $aprobo = 'No');
                            $inscripcion->aprobo    = $aprobo;
                            $inscripcion->estado    = 'Finalizado';
                            $inscripcion->save();
                        }
                        // Aqui debemos evaluar el hecho si todas las inscripciones pertenecientes a esta gestion
                        // se aprobaron o reprobaron, por tanto debe actualizarse en carreras_personas
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
                    }
                }
            }
        }
    }
}
