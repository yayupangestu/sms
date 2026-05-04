<?php


namespace App\Imports;

use App\Models\TabelStokSbc;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class SubcontImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
{
    return new TabelStokSbc([
        'part_name'         => $row[0] ?? null,
        'part_no'           => $row[1] ?? null,
        'part_no2'          => isset($row[1]) ? str_replace('-', '', $row[1]) . '00' : null,
        'job_no'            => $row[2] ?? null,
        'model'             => $row[3] ?? null,
        'qty_min'           => $row[4] ?? null,
        'qty_kanban'        => $row[5] ?? null,
        'qty_act_ls'        => $row[6] ?? null,
        'qty_act_prepare'   => $row[7] ?? null,
        'customer'          => $row[8] ?? null,
        'supplier'          => $row[9] ?? null,
        'home_line'         => $row[10] ?? null,
    ]);
}

    /**
     * Mulai dari baris ke-2 untuk mengabaikan header.
     */
    public function startRow(): int
    {
        return 4;
    }
}
