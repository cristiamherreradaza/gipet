<?php

namespace App\Imports;

use App\Inscripcione;
use Maatwebsite\Excel\Concerns\ToModel;

class AsignaturaNotasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Inscripcione([
            //
        ]);
    }
}
