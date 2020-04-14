<?php

namespace App\Imports;

use App\Nota;
use Maatwebsite\Excel\Concerns\ToModel;

class NotasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        if( is_numeric($row[0]) ){
            $nota = Nota::find($row[0]);
            $nota->nota_asistencia = $row[2];
            $nota->nota_practicas = $row[3];
            $nota->nota_puntos_ganados = $row[4];
            $nota->nota_primer_parcial = $row[5];
            $nota->nota_examen_final = $row[6];
            $nota->nota_total = ($row[2]+$row[3]+$row[4]+$row[5]+$row[6]);
            $nota->save();
        }

        // return new Nota([
        //     'nota_asistencia' => $row[2],
        //     'nota_practicas' => $row[3],
        //     'nota_puntos_ganados' => $row[4],
        //     'nota_primer_parcial' => $row[5],
        //     'nota_examen_final' => $row[6],
        //     'nota_total' => $row[7]
        // ]);
    }
}
