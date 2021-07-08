<?php

namespace App\Imports;

use App\Pago;
use App\Pagos;
use App\Persona;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PagosImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $persona = Persona::where('cedula', $row[1])
                            ->first();
        if ($persona) {
            echo $persona->nombres." - ".$row[1]." - ".$row[5]."<br />";
            if($row[8]=='Pagado'){
                $fechaPago = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]));

                $pago                      = new Pago();
                $pago->user_id             = $row[7];
                $pago->turno_id            = $row[3];
                $pago->carrera_id          = 1;
                $pago->persona_id          = $persona->id;
                $pago->servicio_id         = 2;
                $pago->tipo_mensualidad_id = 1;
                $pago->importe             = $row[4];
                $pago->mensualidad         = $row[6];
                $pago->gestion             = $row[2];
                $pago->fecha               = $fechaPago;
                $pago->estado              = 'Pagado';
                $pago->save();

            }else{
                
                $pago                      = new Pago();
                $pago->user_id             = $row[7];
                $pago->turno_id            = $row[3];
                $pago->carrera_id          = 1;
                $pago->persona_id          = $persona->id;
                $pago->servicio_id         = 2;
                $pago->tipo_mensualidad_id = 1;
                $pago->importe             = $row[4];
                $pago->mensualidad         = $row[6];
                $pago->gestion             = $row[2];
                $pago->fecha               = $fechaPago;
                $pago->estado              = 'Pagado';
                $pago->save();
            }    
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
