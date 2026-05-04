<?php


namespace App\Imports;

use App\Models\DataWelding;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class WeldingImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
{
    return new DataWelding([
        'part_name' => $row[0] ?? null,
        'part_no'   => $row[1] ?? null,
        'part_no2'  => isset($row[1]) ? str_replace('-', '', $row[1]) . '00' : null,
        'job_no'    => $row[2] ?? null,
        'model'     => $row[3] ?? null,
        'qty_kanban'  => $row[4] ?? null,
        'customer'  => $row[5] ?? null,
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
