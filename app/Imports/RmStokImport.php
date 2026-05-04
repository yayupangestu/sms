<?php


namespace App\Imports;

use App\Models\RmStok;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class RmStokImport implements ToModel, WithStartRow, SkipsEmptyRows
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

        return new RmStok([
            'part_name'         => $row[2] ?? null,
            'part_no'           => $row[4] ?? null,
            'part_no2'          => $row[4] ?? null,
            'job_no'            => $row[5] ?? null,
            'model_id'          => $row[6] ?? null,
            'category_id'       => $row[7] ?? null,
            'spek'              => $row[8] ?? null,
            'spek_t'            => $row[9] ?? null,
            'spek_w'            => $row[10] ?? null,
            'spek_l'            => $row[11] ?? null,
            'spek_bq'           => $row[12] ?? null,
            'spek_kg'           => $row[13] ?? null,
            'supplier'          => $row[14] ?? null,
            'minimal'           => $row[15] ?? null,
            'actual_sheet'      => $row[17] ?? null,
            'actual_kg'         => $row[18] ?? null,
            'no_rak'            => $row[20] ?? null,
            // 'keterangan'        => $row[21] ?? null,
            'status'            => $row[19] ?? null,


        ]);

    }

    /**
     * Mulai dari baris ke-2 untuk mengabaikan header.
     */
    public function startRow(): int
    {
        return 10;
    }}
