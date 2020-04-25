<?php

namespace App\Imports;

use App\Nota;
use App\Kardex;
use App\Inscripcion;
use App\NotasPropuesta;
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
        // Si el valor que esta en la posición 0 es numerico (id de la tabla notas)
        if( is_numeric($row[0]) ){
            // Buscamos ese id en notas
            $nota = Nota::find($row[0]);
            // Buscamos la Notapropuesta relacionada a esta Nota
            $notapropuesta = NotasPropuesta::where('asignatura_id', $nota->asignatura_id)
                                        ->where('turno_id', $nota->turno_id)
                                        ->where('paralelo', $nota->paralelo)
                                        ->where('anio_vigente', $nota->anio_vigente)
                                        ->where('borrado', NULL)
                                        ->first();
            // Si el valor que se encuentra en la BBDD es igual al valor del excel (carnet)
            if($nota->persona->carnet == $row[2]){
                // Si el valor de cada Nota no sobrepasa al de su NotaPropuesta
                if($row[3] <= $notapropuesta->nota_asistencia && $row[4] <= $notapropuesta->nota_practicas && $row[5] <= $notapropuesta->nota_puntos_ganados && $row[6] <= $notapropuesta->nota_primer_parcial && $row[7] <= $notapropuesta->nota_examen_final){
                    $nota->nota_asistencia = $row[3];
                    $nota->nota_practicas = $row[4];
                    $nota->nota_puntos_ganados = $row[5];
                    $nota->nota_primer_parcial = $row[6];
                    $nota->nota_examen_final = $row[7];
                    $nota->nota_total = ($row[3]+$row[4]+$row[5]+$row[6]+$row[7]);
                    $nota->save();
                    // Registro en Inscripción
                    $inscripcion = Inscripcion::where('asignatura_id', $nota->asignatura_id)
                                            ->where('turno_id', $nota->turno_id)
                                            ->where('persona_id', $nota->persona_id)
                                            ->where('paralelo', $nota->paralelo) 
                                            ->where('anio_vigente', $nota->anio_vigente)
                                            ->firstOrFail();
                    $inscripcion->nota = $nota->nota_total;
                    $inscripcion->save();
                    // Registro en Kardex
                    if($nota->nota_total >= 61){
                        // Procederemos a la busqueda en kardex y actualización
                        $kardex = Kardex::where('persona_id', $nota->persona_id)
                                        ->where('asignatura_id', $nota->asignatura_id)
                                        ->firstOrFail();
                        $kardex->aprobado = 'Si';
                        $kardex->anio_aprobado = date('Y');
                        $kardex->save();
                    }
                }
            }
        }
    }
}
