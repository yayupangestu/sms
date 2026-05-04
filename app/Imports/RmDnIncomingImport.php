<?php

namespace App\Imports;

use App\Models\RmDnIncoming;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RmDnIncomingImport implements ToModel, WithStartRow
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
        // Skip jika kolom wajib kosong
        if (empty($row[3]) || empty($row[22]) || empty($row[20])) {
            return null;
        }
    
        $orderKg = is_numeric($row[22]) ? number_format((float)$row[22], 2, '.', '') : $row[22];
        $specT = is_numeric($row[8]) ? number_format((float)$row[8], 2, '.', '') : $row[8];
    
        // Handle actual_sheet dan actual_kg jika berupa '-' maka jadikan null
        $actualSheet = ($row[23] === '-' || $row[23] === null) ? null : $row[23];
        $actualKg = ($row[25] === '-' || $row[25] === null) ? null : $row[25];
    
        // Handle no_rak jika null maka jadikan '-'
        $noRak = ($row[37] === null || $row[37] === '') ? '-' : $row[37];
    
        return new RmDnIncoming([
            'doc_dn' => $row[35],
            'doc_po' => $row[34],
            'supplier' => $row[4],
            'urutan' => $row[2],
            'part_no' => $row[3],
            'kanban' => $row[5],
            'model' => $row[6],
            'spec'  => $row[7],
            'spec_t' => $specT,
            'spec_w' => $row[9],
            'spec_l' => $row[10],
            'spec_bq' => $row[11],
            'spec_kg' => $row[12],
            'kg_sheet' => $row[13],
            'order_sheet' => $row[20],
            'order_kg' => $orderKg,
            'actual_sheet' => $actualSheet,
            'actual_kg' => $actualKg,
            'balance_sheet' => $row[27],
            'balance_weight' => $row[29],
            'no_rak' => $noRak,
            'aj_data' => $row[35],
            'delivery' => $row[36],
        ]);
    }
    

    
    
}


