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

class InscripcionesImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $hoy = date('Y-m-d');
        $alumno = Persona::where('cedula', $row[1])
                ->first();
        
        if($alumno){
            echo $alumno->nombres."<br />";
            $carrera = new CarrerasPersona();
            $carrera->user_id           = 36;
            $carrera->carrera_id        = 2;
            $carrera->persona_id        = $alumno->id;
            $carrera->turno_id          = $row[13];
            $carrera->gestion           = 2;
            $carrera->paralelo          = $row[14];
            $carrera->anio_vigente      = 2020;
            $carrera->sexo              = $alumno->sexo;
            $carrera->vigencia          = "Finalizado";
            $carrera->fecha_inscripcion = $hoy;
            $carrera->estado            = $row[12];
            $carrera->save();

            // definimos las materias
            $arrayMaterias = array();

            // sec 2
            $arrayMaterias[1]=519;
            $arrayMaterias[2]=520;
            $arrayMaterias[3]=521;
            $arrayMaterias[4]=522;
            $arrayMaterias[5]=523;
            $arrayMaterias[6]=524;
            $arrayMaterias[7]=525;

            $contadorMaterias = 5;
            foreach ($arrayMaterias as $key => $m) {
                $datosMateria = Asignatura::find($m);

                echo $m."<br />";

                $inscripcion = new Inscripcione();

                $inscripcion->user_id         = 36;
                $inscripcion->resolucion_id   = $datosMateria->resolucion_id;
                $inscripcion->carrera_id      = 2;
                $inscripcion->asignatura_id   = $m;
                $inscripcion->turno_id        = $row[13];
                $inscripcion->persona_id      = $alumno->id;
                $inscripcion->paralelo        = $row[14];
                $inscripcion->semestre        = $datosMateria->semestre;
                $inscripcion->gestion         = 2;
                $inscripcion->anio_vigente    = 2020;
                $inscripcion->fecha_registro  = $hoy;
                $inscripcion->nota            = $row[$contadorMaterias];
                $inscripcion->nota_aprobacion = 61;
                $inscripcion->troncal         = 'Si';
                $inscripcion->estado          = 'Finalizado';
                
                $inscripcion->save();

                $inscripcionId = $inscripcion->id;

                $contadorMaterias++;

                // verificamos si es semestral o anual
                if ($datosMateria->ciclo == "Anual") {
                    $cantidadBimestres = 2;
                }else{
                    $cantidadBimestres = 4;
                }

                // guardamos para el registro de notas
                for ($i=1; $i <= $cantidadBimestres ; $i++) { 

                    $nota = new Nota();

                    $nota->user_id         = 36;
                    $nota->resolucion_id   = $datosMateria->resolucion_id;
                    $nota->carrera_id      = $datosMateria->carrera_id;
                    $nota->inscripcion_id  = $inscripcionId;
                    $nota->persona_id      = $alumno->id;
                    $nota->asignatura_id   = $datosMateria->id;
                    $nota->gestion         = $datosMateria->gestion;
                    $nota->turno_id        = $row[13];
                    $nota->paralelo        = $row[14];
                    $nota->anio_vigente    = 2020;
                    $nota->semestre        = $datosMateria->semestre;
                    $nota->trimestre       = $i;
                    $nota->fecha_registro  = $hoy;
                    $nota->nota_aprobacion = $datosMateria->resolucion->nota_aprobacion;

                    $nota->save();
        
                }
    
            }
        }


        // echo "<pre>";
        // print_r($row);
        // echo "</pre>";
        // dd($row);
        // return new Inscripcione([
        //     //
        // ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
