<?php

namespace App\Imports;

use App\NotasPropuesta;
use Maatwebsite\Excel\Concerns\ToModel;

class NotasPropuestasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Si el valor que esta en la posición 0 es numerico (id de la tabla notas_propuestas)
        if( is_numeric($row[0]) ){
            // Buscamos ese id en notas_propuestas
            $notapropuesta = NotasPropuesta::find($row[0]);
            // Si el valor que se encuentra en la BBDD es igual al valor del excel (codigo_asignatura)
            if($notapropuesta->asignatura->codigo_asignatura == $row[1] && $notapropuesta->asignatura->nombre_asignatura == $row[2]){
                // Si la suma total de los valores es igual a 100
                if($row[3]+$row[4]+$row[5]+$row[6] == 100){
                    $notapropuesta->nota_asistencia = $row[3];
                    $notapropuesta->nota_practicas = $row[4];
                    $notapropuesta->nota_primer_parcial = $row[5];
                    $notapropuesta->nota_examen_final = $row[6];
                    $notapropuesta->nota_puntos_ganados = $row[7];
                    $notapropuesta->fecha = date('Y-m-d H:i:s');
                    $notapropuesta->save();
                }
            }
        }
    }
}
