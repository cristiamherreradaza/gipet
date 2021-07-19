<?php

namespace App\Imports;

use App\Nota;
use App\Kardex;
use App\Asignatura;
use App\Inscripcion;
use App\Inscripcione;
use App\NotasPropuesta;
use App\CarrerasPersona;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NotasImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // buscammos la nota en funcion 
        // a la primera columna excel
        $nota = Nota::find($row[0]);

        // calculamos el total de la nota del bimestre
        $total = $row[4] + $row[5] + $row[6] + $row[7] + $row[8];

        $notapropuesta = NotasPropuesta::where('asignatura_id', $nota->asignatura_id)
                                        ->where('turno_id', $nota->turno_id)
                                        ->where('paralelo', $nota->paralelo)
                                        ->where('anio_vigente', $nota->anio_vigente)
                                        ->first();

        $registraNota = Nota::where('asignatura_id', $nota->asignatura_id)
                                ->where('turno_id', $nota->turno_id)
                                ->where('persona_id', $nota->persona_id)
                                ->where('paralelo', $nota->paralelo)
                                ->where('anio_vigente', $nota->anio_vigente)
                                ->where('trimestre', $row[3])
                                ->first();

        $registraNota->nota_asistencia       = $row[4];
        $registraNota->nota_practicas        = $row[5];
        $registraNota->nota_primer_parcial   = $row[6];
        $registraNota->nota_examen_final     = $row[7];
        $registraNota->nota_puntos_ganados   = $row[8];      //extras
        $registraNota->nota_total            = $total;
        $registraNota->save();

        if($row[3] == 2){

            $notaPrimerBimestre = Nota::where('asignatura_id', $nota->asignatura_id)
                                        ->where('turno_id', $nota->turno_id)
                                        ->where('persona_id', $nota->persona_id)
                                        ->where('paralelo', $nota->paralelo)
                                        ->where('anio_vigente', $nota->anio_vigente)
                                        ->where('trimestre', 1)
                                        ->first();

            $sumaNotas  = $notaPrimerBimestre->nota_total+$total;
            $promedio = $sumaNotas/2;

            $datosAsignatura = Asignatura::find($nota->asignatura_id);

            if($promedio >= $datosAsignatura->resolucion->nota_aprobacion){

                $aprobo = 'Si';

                $carrerasPersona = CarrerasPersona::where('persona_id', $nota->persona_id)
                                                ->where('carrera_id', $nota->carrera_id)
                                                ->where('turno_id', $nota->turno_id)
                                                ->where('gestion', $nota->gestion)
                                                ->where('paralelo', $nota->paralelo)
                                                ->where('anio_vigente', $nota->anio_vigente)
                                                ->first();

                if($carrerasPersona->estado == null){
                    
                    $modificaEstado = CarrerasPersona::find($carrerasPersona->id);
                    $modificaEstado->estado = 'APROBO';
                    $modificaEstado->save();
                }

            }else{
                $aprobo = null;
                $carrerasPersona = CarrerasPersona::where('persona_id', $nota->persona_id)
                                                ->where('carrera_id', $nota->carrera_id)
                                                ->where('turno_id', $nota->turno_id)
                                                ->where('gestion', $nota->gestion)
                                                ->where('paralelo', $nota->paralelo)
                                                ->where('anio_vigente', $nota->anio_vigente)
                                                ->first();

                $modificaEstado = CarrerasPersona::find($carrerasPersona->id);
                $modificaEstado->estado = 'REPROBO';
                $modificaEstado->save();                
            }

            $inscripcion = Inscripcione::find($notaPrimerBimestre->inscripcion_id);
            $inscripcion->nota = $promedio;
            $inscripcion->aprobo = $aprobo;
            $inscripcion->save();
        }
    }

    public function startRow(): int
    {
        return 2;
    }

}
