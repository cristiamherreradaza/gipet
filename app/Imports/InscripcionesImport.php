<?php

namespace App\Imports;

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
            $carrera->carrera_id        = 1;
            $carrera->persona_id        = $alumno->id;
            $carrera->turno_id          = $row[15];
            $carrera->gestion           = 1;
            $carrera->paralelo          = $row[16];
            $carrera->anio_vigente      = 2020;
            $carrera->sexo              = $alumno->sexo;
            $carrera->vigencia          = "Finalizado";
            $carrera->fecha_inscripcion = $hoy;
            $carrera->estado            = $row[14];
            $carrera->save();

            // definimos las materias
            $arrayMaterias = array();
            $arrayMaterias[1]=442;
            $arrayMaterias[2]=443;
            $arrayMaterias[3]=444;
            $arrayMaterias[4]=445;
            $arrayMaterias[5]=446;
            $arrayMaterias[6]=447;
            $arrayMaterias[7]=448;
            $arrayMaterias[8]=449;

            $contadorMaterias = 5;
            foreach ($arrayMaterias as $key => $m) {
                $datosMateria = Asignatura::find($m);

                echo $m."<br />";

                $inscripcion = new Inscripcione();

                $inscripcion->user_id         = 36;
                $inscripcion->resolucion_id   = $datosMateria->resolucion_id;
                $inscripcion->carrera_id      = 1;
                $inscripcion->asignatura_id   = $m;
                $inscripcion->turno_id        = $row[15];
                $inscripcion->turno_id        = $row[15];
                $inscripcion->persona_id      = $alumno->id;
                $inscripcion->paralelo        = $row[16];
                $inscripcion->semestre        = $datosMateria->semestre;
                $inscripcion->gestion         = 1;
                $inscripcion->anio_vigente    = 2020;
                $inscripcion->fecha_registro  = $hoy;
                $inscripcion->nota            = $row[$contadorMaterias];
                $inscripcion->nota_aprobacion = 61;
                $inscripcion->troncal         = 'Si';
                $inscripcion->estado          = 'Finalizado';
                
                $inscripcion->save();

                $contadorMaterias++;
    
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
