<?php


namespace App\Imports;

use App\Models\TabelStokBlank;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class TabelStokBlankImport implements ToModel, WithStartRow, SkipsEmptyRows
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

        return new TabelStokBlank([
            'part_name'     => $row[2] ?? null,
            'part_no'       => $row[3] ?? null,
            'part_no2'      => $row[4] ?? null,
            'job_no'        => $row[5] ?? null,
            'model_id'      => $row[6] ?? null,
            'spek'          => $row[8] ?? null,
            'spek_t'        => $row[9] ?? null,
            'spek_w'        => $row[10] ?? null,
            'spek_l'        => $row[11] ?? null,
            'spek_bq'       => $row[12] ?? null,
            
            // 'customer'      => $row[7] ?? null,
            // 'qty_min'       => $row[16] ?? null,
            // 'qty_actual'    => $row[18] ?? null,
            // 'qty_kanban'    => $row[11] ?? null,
            'home_line'     => $row[21] ?? null,
            'line_proses'   => $row[20] ?? null,
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
