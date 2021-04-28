<?php

namespace App\Imports;

use App\Nota;
use App\Kardex;
use App\Inscripcion;
use App\NotasPropuesta;
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
        // print_r($row);

        $nota = Nota::find($row[0]);

        $total = $row[4] + $row[5] + $row[6] + $row[7];

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

    }

    public function startRow(): int
    {
        return 2;
    }

}
