<?php

namespace App\Imports;

use App\Models\LineStoreUpload;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LsDnIncomingImport implements ToModel, WithStartRow
{
    // Variabel untuk menyimpan data dari kolom AJ baris ke-5
    protected $ajData;

    /**
     * Tentukan baris awal yang ingin diimpor (baris ke-9).
     *
     * @return int
     */
    public function startRow(): int
    {
        return 9;
    }

    /**
     * Setiap baris dari file Excel akan dikonversi menjadi instance model.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
{
    // Check for required columns
    if (empty($row[3]) || empty($row[20]) || empty($row[4])) {
        return null; // Skip if any required field is missing
    }

    // // Process `order_kg` to keep only two decimal places if it contains commas
    // $orderKg = is_numeric($row[22]) ? number_format((float)$row[22], 2, '.', '') : $row[22];
    // $specT = is_numeric($row[8]) ? number_format((float)$row[8], 2, '.', '') : $row[8];

    return new LineStoreUpload([
        'part_no' => $row[3],
        'supplier' => $row[4],
        // 'no_po' => $row[34], // Directly use $row[35] here
        // 'no_dn' => $row[35],
        // 'part_no' => $row[3], // Directly use $row[35] here
        'order_part' => $row[20],
        'no_dn' => $row[35],
        'no_dn2' => $row[35],
        // 'urutan' => $row[2],
        // 'balance_order' => $row[28],
        // // 'balance_weight' => $row[29],
        // // 'no_rak' => $row[37],
        // // 'aj_data' => $row[35], // Use $row[35] directly here
        // 'tgl_delivery' => $row[36],
    ]);
}

    
    
}


