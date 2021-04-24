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
        print_r($row);
        echo "<br />";

        $hoy = date('Y-m-d');
        $alumno = Persona::where('cedula', $row[1])
                ->first();
        
        if($alumno){
            echo $alumno->nombres."<br />";
            $carrera = new CarrerasPersona();
            $carrera->user_id           = 36;
            $carrera->carrera_id        = $row[5];
            $carrera->persona_id        = $alumno->id;
            $carrera->turno_id          = $row[6];
            $carrera->gestion           = $row[8];
            $carrera->paralelo          = $row[7];
            $carrera->anio_vigente      = 2021;
            $carrera->sexo              = $alumno->sexo;
            $carrera->vigencia          = "Vigente";
            $carrera->fecha_inscripcion = $hoy;
            $carrera->estado            = null;
            $carrera->save();

            // definimos las materias
            $arrayMaterias = array();

            $materias = Asignatura::where('carrera_id', $row[5])
                        ->where('anio_vigente', 2021)
                        ->where('gestion', 2021)
                        ->get();

            foreach ($arrayMaterias as $key => $m) {

                echo $m."<br />";

                $inscripcion = new Inscripcione();

                $inscripcion->user_id         = 36;
                $inscripcion->resolucion_id   = $m->resolucion_id;
                $inscripcion->carrera_id      = $row[5];
                $inscripcion->asignatura_id   = $m->id;
                $inscripcion->turno_id        = $row[6];
                $inscripcion->persona_id      = $alumno->id;
                $inscripcion->paralelo        = $row[7];
                $inscripcion->semestre        = $m->semestre;
                $inscripcion->gestion         = $row[8];
                $inscripcion->anio_vigente    = 2021;
                $inscripcion->fecha_registro  = $hoy;
                // $inscripcion->nota            = $row[$contadorMaterias];
                $inscripcion->nota_aprobacion = 61;
                $inscripcion->troncal         = 'Si';
                $inscripcion->estado          = 'Cursando';
                
                $inscripcion->save();

                $inscripcionId = $inscripcion->id;

                // verificamos si es semestral o anual
                if ($datosMateria->ciclo == "Anual") {
                    $cantidadBimestres = 2;
                }else{
                    $cantidadBimestres = 4;
                }

                // guardamos para el registro de notas
                for ($i=1; $i <= 2; $i++) 
                { 
                    $nota = new Nota();

                    $nota->user_id         = 36;
                    $nota->resolucion_id   = $m->resolucion_id;
                    $nota->carrera_id      = $m->carrera_id;
                    $nota->inscripcion_id  = $inscripcionId;
                    $nota->persona_id      = $alumno->id;
                    $nota->asignatura_id   = $m->id;
                    $nota->gestion         = $row[8];
                    $nota->turno_id        = $row[6];
                    $nota->paralelo        = $row[7];
                    $nota->anio_vigente    = 2021;
                    $nota->semestre        = $m->semestre;
                    $nota->trimestre       = $i;
                    $nota->fecha_registro  = $hoy;
                    $nota->nota_aprobacion = $m->resolucion->nota_aprobacion;

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
