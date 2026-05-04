<?php


namespace App\Imports;

use App\Models\TabelListDies;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ListDiesImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
{
    return new TabelListDies([
        'part_name'     => $row[0] ?? null,
        'part_no'       => $row[1] ?? null,
        'job_no'        => $row[2] ?? null,
        'model_id'      => $row[3] ?? null,
        'line_id'       => $row[4] ?? null,
        'std_stroke'    => $row[5] ?? null,
        'proses'        => $row[6] ?? null,
        'customer'      => $row[7] ?? null,
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
