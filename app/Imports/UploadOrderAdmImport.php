<?php

namespace App\Imports;

use App\Models\UploadRekapOrderAdm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class UploadOrderAdmImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $cycleArrival = null;

        if (!empty($row[15])) {
            if (is_numeric($row[15])) {
                $cycleArrival = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15])
                    ->format('Y-m-d');
            } else {
                try {
                    $cycleArrival = \Carbon\Carbon::parse($row[15])->format('Y-m-d');
                } catch (\Exception $e) {
                    $cycleArrival = $row[15];
                }
            }
        }

        // 🔹 Ambil 2 digit terakhir dari kolom route
        $route2 = isset($row[3]) ? substr(trim($row[3]), -2) : null;

        if (!in_array($route2, ['K1', 'K2'])) {
            // Ambil no DN (misalnya di kolom 10)
            $noDn = $row[10] ?? 'Tidak diketahui';

            throw new \Exception("No DN yang anda masukan bukan KAP-1 atau KAP-2, cek lagi!");
        }


        // 🔹 Simpan data kalau lolos validasi
        return new UploadRekapOrderAdm([
            'uniqNo'        => $row[25] ?? null,
            'manifest'      => $row[10] ?? null,
            'doc_dn'        => $row[10] ?? null,
            'part_name'     => $row[24] ?? null,
            'part_no'       => $row[23] ?? null,
            'job_no'        => $row[25] ?? null,
            'qty_kanban'    => $row[27] ?? null,
            'qty_order'     => $row[29] ?? null,
            'jml_kanban'    => $row[28] ?? null,
            'type_pallet'   => $row[21] ?? null,
            'proses'        => $row[22] ?? null,
            'cycle'         => $row[5] ?? null,
            'route'         => $row[3] ?? null,
            'cycle_arrival' => $cycleArrival,
            'route2'        => $route2,
        ]);
    }

    public function startRow(): int
    {
        return 5;
    }
}
