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

class DataImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Primero verificamos que la fila $row que leemos sea de datos y no parte del heading
        if(is_numeric($row[0]))         // Si es numerico (si es una cedula de identidad)
        {
            // Tomamos la cedula de identidad y verificamos que exista en la base de datos
            $persona = Persona::where('cedula', $row[0])->first();
            if($persona)         // Si existe un registro, procedemos
            {
                // Tomamos Carrera, Asignatura y Turno y verificamos que existan y se correspondan
                $carrera    = Carrera::where('nombre', $row[1])->first();
                $asignatura = Asignatura::where('sigla', $row[2])
                                        ->where('nombre', $row[3])
                                        ->where('ciclo', $row[4])
                                        ->where('anio_vigente', $row[7])
                                        ->first();
                $turno      = Turno::where('descripcion', $row[5])->first();
                // Preguntaremos si encontramos esos registros
                if($carrera && $asignatura && $turno)         // Si carrera, asignatura y turno estan definidos (se encontro valores)
                {
                    // Preguntamos si coinciden carrera con asignatura
                    if($carrera->id == $asignatura->carrera_id)     // Si el id de carrera en la tabla carrera es igual a carrera_id en la tabla asignaturas
                    {
                        // Tenemos que crear carreras_personas
                        // Buscaremos si existe un registro con los datos enviados para carreras_personas
                        $registro   = CarrerasPersona::where('carrera_id', $carrera->id)
                                                    ->where('persona_id', $persona->id)
                                                    ->where('turno_id', $turno->id)
                                                    ->where('gestion', $asignatura->gestion)    // Pendiente de observaciones
                                                    ->where('paralelo', $row[6])
                                                    ->where('anio_vigente', $row[7])
                                                    ->first();
                        // Si no existe el registro, creamos uno nuevo, si existe, pasamos de largo
                        if(!$registro)
                        {
                            $carrerasPersona                    = new CarrerasPersona();
                            $carrerasPersona->user_id           = Auth::user()->id;
                            $carrerasPersona->carrera_id        = $carrera->id;
                            $carrerasPersona->persona_id        = $persona->id;
                            $carrerasPersona->turno_id          = $turno->id;
                            $carrerasPersona->gestion           = $asignatura->gestion;
                            $carrerasPersona->paralelo          = $row[6];
                            $carrerasPersona->fecha_inscripcion = date('Y-m-d');
                            $carrerasPersona->anio_vigente      = $row[7];
                            $carrerasPersona->sexo              = $persona->sexo;
                            $carrerasPersona->save();
                        }
                        // Tenemos que crear inscripciones
                        // Buscaremos si existe un registro con los datos enviados para inscripciones
                        $registro   = Inscripcione::where('carrera_id', $carrera->id)
                                                ->where('asignatura_id', $asignatura->id)
                                                ->where('turno_id', $turno->id)
                                                ->where('persona_id', $persona->id)
                                                ->where('paralelo', $row[6])
                                                ->where('gestion', $asignatura->gestion)    // Pendiente de observaciones
                                                ->where('anio_vigente', $row[7])
                                                ->first();
                        // Si no existe el registro, creamos uno nuevo, si existe, pasamos de largo
                        if(!$registro)
                        {
                            $inscripcion                    = new Inscripcione();
                            $inscripcion->user_id           = Auth::user()->id;
                            $inscripcion->resolucion_id     = $carrera->resolucion->id;
                            $inscripcion->carrera_id        = $carrera->id;
                            $inscripcion->asignatura_id     = $asignatura->id;
                            $inscripcion->turno_id          = $turno->id;
                            $inscripcion->persona_id        = $persona->id;
                            $inscripcion->paralelo          = $row[6];
                            $inscripcion->semestre          = $asignatura->semestre;
                            $inscripcion->gestion           = $asignatura->gestion;
                            $inscripcion->anio_vigente      = $row[7];
                            $inscripcion->fecha_registro    = date('Y-m-d');
                            $inscripcion->nota_aprobacion   = $carrera->resolucion->nota_aprobacion;
                            $inscripcion->troncal           = 'Si';
                            $inscripcion->save();

                            // Buscaremos si existe un docente ya asignado a esta materia
                            $docente = NotasPropuesta::where('asignatura_id', $asignatura->id)
                                                    ->where('turno_id', $turno->id)
                                                    ->where('paralelo', $row[6])
                                                    ->where('anio_vigente', $row[7])
                                                    ->first();
                            // Tenemos que crear notas
                            // Preguntamos cual es el ciclo de la asignatura
                            if($row[4] == 'Semestral')          // Si es Semestral
                            {
                                // Leera 2 bimestres y replicara 2
                                // Primero calcularemos para llenar la nota total del registro 1
                                $totalUno = $row[8] + $row[9] + $row[10] + $row[11];
                                $necesario = 100 - $totalUno;
                                if($necesario >= 10)
                                {
                                    $totalUno = $totalUno + $row[12];
                                }
                                else
                                {
                                    if($necesario <= $row[12])
                                    {
                                        $totalUno = $totalUno + $necesario;
                                    }
                                    else
                                    {
                                        $totalUno = $totalUno + $row[12];
                                    }
                                }
                                // Creando registros para bimestre 1
                                $notaUno                        = new Nota();
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
                                $notaUno->paralelo              = $row[6];
                                $notaUno->anio_vigente          = $row[7];
                                $notaUno->trimestre             = 1;
                                $notaUno->fecha_registro        = date('Y-m-d');
                                $notaUno->nota_asistencia       = $row[8];
                                $notaUno->nota_practicas        = $row[9];
                                $notaUno->nota_primer_parcial   = $row[10];
                                $notaUno->nota_examen_final     = $row[11];
                                $notaUno->nota_puntos_ganados   = $row[12];
                                $notaUno->nota_total            = $totalUno;
                                $notaUno->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                                $notaUno->finalizado            = 'Si';
                                $notaUno->save();
                                // Primero calcularemos para llenar la nota total del registro 2
                                $totalDos = $row[13] + $row[14] + $row[15] + $row[16];
                                $necesario = 100 - $totalDos;
                                if($necesario >= 10)
                                {
                                    $totalDos = $totalDos + $row[17];
                                }
                                else
                                {
                                    if($necesario <= $row[17])
                                    {
                                        $totalDos = $totalDos + $necesario;
                                    }
                                    else
                                    {
                                        $totalDos = $totalDos + $row[17];
                                    }
                                }
                                // Creando registros para bimestre 2
                                $notaDos                        = new Nota();
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
                                $notaDos->paralelo              = $row[6];
                                $notaDos->anio_vigente          = $row[7];
                                $notaDos->trimestre             = 2;
                                $notaDos->fecha_registro        = date('Y-m-d');
                                $notaDos->nota_asistencia       = $row[13];
                                $notaDos->nota_practicas        = $row[14];
                                $notaDos->nota_primer_parcial   = $row[15];
                                $notaDos->nota_examen_final     = $row[16];
                                $notaDos->nota_puntos_ganados   = $row[17];
                                $notaDos->nota_total            = $totalDos;
                                $notaDos->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                                $notaDos->finalizado            = 'Si';
                                $notaDos->save();
                                // Creando registros para bimestre 3
                                $notaTres                        = new Nota();
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
                                $notaTres->paralelo              = $row[6];
                                $notaTres->anio_vigente          = $row[7];
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
                                $notaTres->save();
                                // Creando registros para bimestre 4
                                $notaCuatro                        = new Nota();
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
                                $notaCuatro->paralelo              = $row[6];
                                $notaCuatro->anio_vigente          = $row[7];
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
                                $notaCuatro->save();
                            }
                            if($row[4] == 'Anual')              // Si es Anual
                            {
                                // Leera 4 bimestres y replicara 0
                                // Primero calcularemos para llenar la nota total del registro 1
                                $totalUno = $row[8] + $row[9] + $row[10] + $row[11];
                                $necesario = 100 - $totalUno;
                                if($necesario >= 10)
                                {
                                    $totalUno = $totalUno + $row[12];
                                }
                                else
                                {
                                    if($necesario <= $row[12])
                                    {
                                        $totalUno = $totalUno + $necesario;
                                    }
                                    else
                                    {
                                        $totalUno = $totalUno + $row[12];
                                    }
                                }
                                // Creando registros para bimestre 1
                                $notaUno                        = new Nota();
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
                                $notaUno->paralelo              = $row[6];
                                $notaUno->anio_vigente          = $row[7];
                                $notaUno->trimestre             = 1;
                                $notaUno->fecha_registro        = date('Y-m-d');
                                $notaUno->nota_asistencia       = $row[8];
                                $notaUno->nota_practicas        = $row[9];
                                $notaUno->nota_primer_parcial   = $row[10];
                                $notaUno->nota_examen_final     = $row[11];
                                $notaUno->nota_puntos_ganados   = $row[12];
                                $notaUno->nota_total            = $totalUno;
                                $notaUno->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                                $notaUno->finalizado            = 'Si';
                                $notaUno->save();
                                // Primero calcularemos para llenar la nota total del registro 2
                                $totalDos = $row[13] + $row[14] + $row[15] + $row[16];
                                $necesario = 100 - $totalDos;
                                if($necesario >= 10)
                                {
                                    $totalDos = $totalDos + $row[17];
                                }
                                else
                                {
                                    if($necesario <= $row[17])
                                    {
                                        $totalDos = $totalDos + $necesario;
                                    }
                                    else
                                    {
                                        $totalDos = $totalDos + $row[17];
                                    }
                                }
                                // Creando registros para bimestre 2
                                $notaDos                        = new Nota();
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
                                $notaDos->paralelo              = $row[6];
                                $notaDos->anio_vigente          = $row[7];
                                $notaDos->trimestre             = 2;
                                $notaDos->fecha_registro        = date('Y-m-d');
                                $notaDos->nota_asistencia       = $row[13];
                                $notaDos->nota_practicas        = $row[14];
                                $notaDos->nota_primer_parcial   = $row[15];
                                $notaDos->nota_examen_final     = $row[16];
                                $notaDos->nota_puntos_ganados   = $row[17];
                                $notaDos->nota_total            = $totalDos;
                                $notaDos->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                                $notaDos->finalizado            = 'Si';
                                $notaDos->save();
                                // Primero calcularemos para llenar la nota total del registro 3
                                $totalTres = $row[18] + $row[19] + $row[20] + $row[21];
                                $necesario = 100 - $totalTres;
                                if($necesario >= 10)
                                {
                                    $totalTres = $totalTres + $row[22];
                                }
                                else
                                {
                                    if($necesario <= $row[22])
                                    {
                                        $totalTres = $totalTres + $necesario;
                                    }
                                    else
                                    {
                                        $totalTres = $totalTres + $row[22];
                                    }
                                }
                                // Creando registros para bimestre 3
                                $notaTres                        = new Nota();
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
                                $notaTres->paralelo              = $row[6];
                                $notaTres->anio_vigente          = $row[7];
                                $notaTres->trimestre             = 3;
                                $notaTres->fecha_registro        = date('Y-m-d');
                                $notaTres->nota_asistencia       = $row[18];
                                $notaTres->nota_practicas        = $row[19];
                                $notaTres->nota_primer_parcial   = $row[20];
                                $notaTres->nota_examen_final     = $row[21];
                                $notaTres->nota_puntos_ganados   = $row[22];
                                $notaTres->nota_total            = $totalTres;
                                $notaTres->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                                $notaTres->finalizado            = 'Si';
                                $notaTres->save();
                                // Primero calcularemos para llenar la nota total del registro 4
                                $totalCuatro = $row[23] + $row[24] + $row[25] + $row[26];
                                $necesario = 100 - $totalCuatro;
                                if($necesario >= 10)
                                {
                                    $totalCuatro = $totalCuatro + $row[27];
                                }
                                else
                                {
                                    if($necesario <= $row[27])
                                    {
                                        $totalCuatro = $totalCuatro + $necesario;
                                    }
                                    else
                                    {
                                        $totalCuatro = $totalCuatro + $row[27];
                                    }
                                }
                                // Creando registros para bimestre 4
                                $notaCuatro                        = new Nota();
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
                                $notaCuatro->paralelo              = $row[6];
                                $notaCuatro->anio_vigente          = $row[7];
                                $notaCuatro->trimestre             = 4;
                                $notaCuatro->fecha_registro        = date('Y-m-d');
                                $notaCuatro->nota_asistencia       = $row[23];
                                $notaCuatro->nota_practicas        = $row[24];
                                $notaCuatro->nota_primer_parcial   = $row[25];
                                $notaCuatro->nota_examen_final     = $row[26];
                                $notaCuatro->nota_puntos_ganados   = $row[27];
                                $notaCuatro->nota_total            = $totalCuatro;
                                $notaCuatro->nota_aprobacion       = $carrera->resolucion->nota_aprobacion;
                                $notaCuatro->finalizado            = 'Si';
                                $notaCuatro->save();
                            }
                            // Actualizamos inscripcion
                            // Sumamos las notas
                            $totalNotas = $notaUno->nota_total + $notaDos->nota_total + $notaTres->nota_total + $notaCuatro->nota_total;
                            $totalNotas = round($totalNotas/4);
                            // Comparamos con respecto a la nota de aprobacion y registramos
                            if($totalNotas >= $inscripcion->nota_aprobacion)    // Si su nota total es mayor o igual que la nota de aprobacion
                            {
                                $aprobo = 'Si';
                            }
                            else        // Su nota total es menor a la nota de aprobacion
                            {
                                $aprobo = 'No';
                            }
                            $inscripcion->nota      = $totalNotas;
                            $inscripcion->aprobo    = $aprobo;
                            $inscripcion->estado    = 'Finalizado';
                            $inscripcion->save();
                        }
                    }
                }
            }
        }
    }
}
