<?php

namespace App\Imports;

use App\Models\UploadRekapOrderAdmP4;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class UploadOrderAdmP4Import implements ToModel, WithStartRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $cycleArrival = null;

        // 🔹 Convert cycle_arrival
        if (!empty($row[16])) {
            if (is_numeric($row[16])) {
                $cycleArrival = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[16])
                    ->format('H:i:s');
            } else {
                $timeString = str_replace('.', ':', $row[16]);
                $time = \DateTime::createFromFormat('H:i:s', $timeString);
                if ($time) {
                    $cycleArrival = $time->format('H:i:s');
                }
            }
        }

        // 🔹 Ambil 2 digit terakhir dari kolom route
        $route2 = isset($row[3]) ? substr(trim($row[3]), -2) : null;

        if (!in_array($route2, ['-C', 'GM'])) {
            // Ambil no DN (misalnya di kolom 10)
            $noDn = $row[10] ?? 'Tidak diketahui';

            throw new \Exception("No DN yang anda masukan bukan ADM PLANT 4 cek lagi!");
        }

        // 🔹 Convert del_date
        $delDate = null;
        if (!empty($row[15])) {
            if (is_numeric($row[15])) {
                // Kalau format Excel number (serial date)
                $delDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[15])
                    ->format('Y-m-d');
            } else {
                // Kalau format string (misalnya "6-Okt-25")
                $delDateObj = \DateTime::createFromFormat('j-M-y', $row[15]);
                if ($delDateObj) {
                    $delDate = $delDateObj->format('Y-m-d');
                }
            }
        }

        return new UploadRekapOrderAdmP4([
            'route'         => $row[3] ?? null,
            'uniqNo'        => $row[23] ?? null,
            'route2'        => $route2,
            'manifest'      => $row[10] ?? null,
            'doc_dn'        => $row[10] ?? null,
            'part_name'     => $row[25] ?? null,
            'part_no'       => $row[24] ?? null,
            'job_no'        => $row[26] ?? null,
            'qty_kanban'    => $row[28] ?? null,
            'qty_order'     => $row[30] ?? null,
            'jml_kanban'    => $row[29] ?? null,
            'type_pallet'   => $row[21] ?? null,
            'del_date'      => $delDate,  // ✅ sudah diformat jadi Y-m-d
            'proses'        => $row[22] ?? null,
            'cycle'         => $row[17] ?? null,
            'cycle_arrival' => $cycleArrival,
        ]);
    }


    public function startRow(): int
    {
        return 5;
    }
}
