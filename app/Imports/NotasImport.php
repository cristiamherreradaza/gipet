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
        if( is_numeric($row[0]) )
        {
            // Buscamos ese id en notas
            $nota = Nota::find($row[0]);
            if($nota)
            {
                // Buscamos la Notapropuesta relacionada a esta Nota
                $notapropuesta = NotasPropuesta::where('asignatura_id', $nota->asignatura_id)
                                                ->where('turno_id', $nota->turno_id)
                                                ->where('paralelo', $nota->paralelo)
                                                ->where('anio_vigente', $nota->anio_vigente)
                                                ->first();
                // Si el valor que se encuentra en la BBDD es igual al valor del excel (cedula)
                if($nota->persona->cedula == $row[2])
                {
                    // Si el valor de cada Nota no sobrepasa al de su NotaPropuesta
                    if($row[4] <= $notapropuesta->nota_asistencia && $row[5] <= $notapropuesta->nota_practicas && $row[6] <= $notapropuesta->nota_primer_parcial && $row[7] <= $notapropuesta->nota_examen_final && $row[8] <= $notapropuesta->nota_puntos_ganados)
                    {
                        // Aplicamos la validacion para que ninguna nota sobrepase el 100 y ademas se registre como corresponde
                        // Primero calcularemos para llenar la nota total
                        $total = $row[4] + $row[5] + $row[6] + $row[7];
                        $necesario = 100 - $total;
                        if($necesario >= 10)
                        {
                            $total = $total + $row[8];
                        }
                        else
                        {
                            if($necesario <= $row[8])
                            {
                                $total = $total + $necesario;
                            }
                            else
                            {
                                $total = $total + $row[8];
                            }
                        }
                        //consultamos si la materia es semestral o anual
                        if($notapropuesta->asignatura->ciclo == 'Semestral')        // Si es semestral
                        {
                            // Si es semestral, ver a que bimestre hace referencia la nota (1ro -> 3ro y 2do -> 4to)
                            if($nota->trimestre == 1)
                            {
                                // Si es 1er bimestre, buscar el registro que corresponde al 3er bimestre y llenar en ambos
                                // Buscamos ese registro
                                $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                                        ->where('turno_id', $nota->turno_id)
                                                        //->where('docente_id', $nota->docente_id)
                                                        ->where('persona_id', $nota->persona_id)
                                                        ->where('paralelo', $nota->paralelo)
                                                        ->where('anio_vigente', $nota->anio_vigente)
                                                        ->where('trimestre', 3)
                                                        ->first();
                                // Colocamos la nota del 3er Bimestre
                                $segundoregistro->nota_asistencia = $row[4];
                                $segundoregistro->nota_practicas = $row[5];
                                $segundoregistro->nota_primer_parcial = $row[6];
                                $segundoregistro->nota_examen_final = $row[7];
                                $segundoregistro->nota_puntos_ganados = $row[8];   //extras
                                $segundoregistro->nota_total = $total;
                            }
                            if($nota->trimestre == 2)
                            {
                                // Si es 2do bimestre, buscar el registro que corresponde al 4to bimestre y llenar en ambos
                                $segundoregistro = Nota::where('asignatura_id', $nota->asignatura_id)
                                                        ->where('turno_id', $nota->turno_id)
                                                        //->where('docente_id', $nota->docente_id)
                                                        ->where('persona_id', $nota->persona_id)
                                                        ->where('paralelo', $nota->paralelo)
                                                        ->where('anio_vigente', $nota->anio_vigente)
                                                        ->where('trimestre', 4)
                                                        ->first();
                                // Colocamos la nota del 4to Bimestre
                                $segundoregistro->nota_asistencia = $row[4];
                                $segundoregistro->nota_practicas = $row[5];
                                $segundoregistro->nota_primer_parcial = $row[6];
                                $segundoregistro->nota_examen_final = $row[7];
                                $segundoregistro->nota_puntos_ganados = $row[8];    //extras
                                $segundoregistro->nota_total = $total;
                            }
                            $segundoregistro->fecha_registro = date('Y-m-d H:i:s');
                            $segundoregistro->save();                               // Guardamos registro

                            $nota->nota_asistencia = $row[4];
                            $nota->nota_practicas = $row[5];
                            $nota->nota_primer_parcial = $row[6];
                            $nota->nota_examen_final = $row[7];
                            $nota->nota_puntos_ganados = $row[8];   //extras
                            $nota->nota_total = $total;
                            $nota->save();
                        }
                        else                                                        // Si es anual
                        {
                            $nota->nota_asistencia = $row[4];
                            $nota->nota_practicas = $row[5];
                            $nota->nota_primer_parcial = $row[6];
                            $nota->nota_examen_final = $row[7];
                            $nota->nota_puntos_ganados = $row[8];   //extras
                            $nota->nota_total = $total;
                            $nota->save();
                        }
                    }
                }
            }
        }
    }
}
