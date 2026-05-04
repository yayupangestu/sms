<?php

namespace App\Imports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\ToModel;

class MaterialsImport implements ToModel
{
    public function model(array $row)
    {
        return new Material([
            'part_no'      => $row[0],
            'spec_material'=> $row[1],
            'model'        => $row[2],
            'tinggi'       => $row[3],
            'panjang'      => $row[4],
            'lebar'        => $row[5],
            'supplier'     => $row[6],
            'no_rak'       => $row[7],
        ]);
    }
}
