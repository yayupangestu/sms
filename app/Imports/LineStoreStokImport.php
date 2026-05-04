<?php


namespace App\Imports;

use App\Models\LineStoreStok;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class LineStoreStokImport implements ToModel, WithStartRow, SkipsEmptyRows
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

        return new LineStoreStok([
            'part_name'     => $row[2] ?? null,
            'part_no'       => $row[3] ?? null,
            'part_no2'      => $row[4] ?? null,
            'job_no'        => $row[6] ?? null,
            'model'         => $row[7] ?? null,
            'category'      => $row[8] ?? null,
            // 'customer'      => $row[7] ?? null,
            'qty_min'       => $row[17] ?? null,
            'qty_actual'    => $row[19] ?? null,
            // 'qty_kanban'    => $row[] ?? null,
            'home_line'     => $row[8] ?? null,
            // 'line_proses'   => $row[0] ?? null,
            'createdby'     => auth()->user()->id,
    
        ]);
        // credit: Mas Yayu Pangestu - pALEMBANG
    }

    /**
     * Mulai dari baris ke-2 untuk mengabaikan header.
     */
    public function startRow(): int
    {
        return 10;
    }
}
