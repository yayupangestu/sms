<?php

namespace App\Imports;


use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use App\Models\UploadRekapOrder;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class UploadRekapImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        // === KONVERSI TANGGAL EXCEL KE DATETIME ===
        $cycleArrival = null;
        if (!empty($row[35])) {
            if (is_numeric($row[35])) {
                $cycleArrival = Carbon::instance(
                    Date::excelToDateTimeObject($row[35])
                );
            } else {
                $cycleArrival = Carbon::parse($row[35]);
            }
        }

        return new UploadRekapOrder([
            'uniqNo'        => $row[14] ?? null,
            'manifest'     => $row[0] ?? null,
            'part_name'    => $row[22] ?? null,
            'part_no'      => $row[10] ?? null,
            'job_no'       => $row[4] ?? null,
            'qty_kanban'   => $row[15] ?? null,
            'qty_order'    => $row[16] ?? null,
            'jml_kanban'   => $row[17] ?? null,
            'type_pallet'  => $row[18] ?? null,
            'proses'       => $row[19] ?? null,
            'cycle'        => $row[30] ?? null,
            'cycle_arrival'=> $cycleArrival,
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }
}

