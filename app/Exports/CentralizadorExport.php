<?php

namespace App\Exports;

use App\Nota;
use Maatwebsite\Excel\Concerns\FromCollection;

class CentralizadorExport implements FromCollection
{

    public function __construct($carrera_id, $turno_id, $paralelo, $tipo, $anio_vigente)
    {
        $this->carrera_id = $carrera_id;
        $this->gestion    = $gestion;
        $this->turno_id   = $turno_id;
        $this->paralelo   = $paralelo;
        $this->tipo       = $tipo;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Nota::all();
    }
}
