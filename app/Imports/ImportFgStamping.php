<?php


namespace App\Imports;

use App\Models\DataFgStamping;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ImportFgStamping implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    
    {

        //  // Periksa apakah nilai dari kolom yang diperlukan ada
        // if (empty($row[6]) || empty($row[26])) {
        //     return null; // Jangan masukkan data jika salah satu kolom tidak ada nilai
        // }

        return new DataFgStamping([
            'part_name'     => $row[2] ?? null,
            'part_no2'      => $row[4] ?? null,
            'part_no'       => $row[3] ?? null,
            'job_no'        => $row[6] ?? null,
            'category'      => $row[8] ?? null,
            'model'         => $row[7] ?? null,
            'spec'          => $row[9] ?? null,
            'spec_t'        => $row[10] ?? null,
            'spec_w'        => $row[11] ?? null,
            'spec_l'        => $row[12] ?? null,
            'spec_bq'       => $row[13] ?? null,
            'spec_kg'   => $row[14] ?? null,
            'createdby'     => auth()->user()->id,
    
        ]);
        
    }

    /**
     * Mulai dari baris ke-2 untuk mengabaikan header.
     */
    public function startRow(): int
    {
        return 10;
    }
}
