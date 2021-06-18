<?php

namespace App\Imports;

use App\Nota;
use App\Persona;
use App\Asignatura;
use App\Inscripcione;
use App\CarrerasPersona;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InscritosImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        print_r($row[1]);
        echo "<br />";

        $hoy = date('Y-m-d');
        $alumno = Persona::where('cedula', $row[1])
                ->first();
        
        if($alumno){

            echo $alumno->nombres."<br />";

            $consultaCarrerasPersona = CarrerasPersona::where('persona_id', $alumno->id)
                                                    ->where('anio_vigente', $row[7])
                                                    ->where('carrera_id', $row[2])
                                                    ->first();

            if ($consultaCarrerasPersona == null) {

                $carrera = new CarrerasPersona();
                $carrera->user_id           = 36;
                $carrera->carrera_id        = $row[2];
                $carrera->persona_id        = $alumno->id;
                $carrera->turno_id          = $row[5];
                $carrera->gestion           = $row[4];
                $carrera->paralelo          = $row[6];
                $carrera->anio_vigente      = $row[7];
                $carrera->sexo              = $alumno->sexo;
                $carrera->vigencia          = "Vigente";
                $carrera->fecha_inscripcion = $hoy;
                $carrera->estado            = $row[9];
                $carrera->save();

            } 

            // dd($consultaInscriciones);

            $materia = Asignatura::where('carrera_id', $row[2])
                                    ->where('sigla', $row[3])
                                    ->where('anio_vigente', $row[7])
                                    ->first();

            if($materia){

                $inscripcion = new Inscripcione();

                $inscripcion->user_id         = 36;
                $inscripcion->resolucion_id   = $materia->resolucion_id;
                $inscripcion->carrera_id      = $row[2];
                $inscripcion->asignatura_id   = $materia->id;
                $inscripcion->turno_id        = $row[5];
                $inscripcion->persona_id      = $alumno->id;
                $inscripcion->paralelo        = $row[6];
                $inscripcion->semestre        = $materia->semestre;
                $inscripcion->gestion         = $row[4];
                $inscripcion->anio_vigente    = $row[7];
                $inscripcion->fecha_registro  = $hoy;
                $inscripcion->nota            = $row[8];
                $inscripcion->nota_aprobacion = 61;
                $inscripcion->troncal         = 'Si';
                $inscripcion->estado          = 'Finalizado';
                
                $inscripcion->save();

                $inscripcionId = $inscripcion->id;


                for ($i=1; $i <= 2; $i++) 
                { 
                    $nota = new Nota();

                    $nota->user_id         = 36;
                    $nota->resolucion_id   = $materia->resolucion_id;
                    $nota->carrera_id      = $materia->carrera_id;
                    $nota->inscripcion_id  = $inscripcionId;
                    $nota->persona_id      = $alumno->id;
                    $nota->asignatura_id   = $materia->id;
                    $nota->gestion         = $row[4];
                    $nota->turno_id        = $row[5];
                    $nota->paralelo        = $row[6];
                    $nota->anio_vigente    = $row[7];
                    $nota->semestre        = $materia->semestre;
                    $nota->trimestre       = $i;
                    $nota->fecha_registro  = $hoy;
                    $nota->nota_aprobacion = $materia->resolucion->nota_aprobacion;

                    $nota->save();
                
                }

            }

        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
