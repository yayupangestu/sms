<?php

namespace App\Imports;

use App\Models\UploadForcast;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ForcastImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
     * Sanitasi nilai: jika '-' atau kosong → jadikan 0
     * Jika ada koma/desimal → dibulatkan
     */
    private function fixValue($val)
    {
        if ($val === '-' || $val === '' || $val === null) {
            return 0;
        }

        // Ganti koma dengan titik (Excel Indonesia)
        $val = str_replace(',', '.', $val);

        // Hapus karakter selain angka dan titik
        $val = preg_replace('/[^0-9.]/', '', $val);

        // Jika tetap kosong setelah dibersihkan
        if ($val === '') {
            return 0;
        }

        // Bulatkan angka
        return round((float)$val);
    }

    public function model(array $row)
    {
        return new UploadForcast([
            'job_no'        => $row[0] ?? null,
            'uniqNo'        => $row[1] ?? null,
            'part_name'     => $row[2] ?? null,
            'part_no'       => $row[3] ?? null,
            'part_no2'      => isset($row[3]) ? str_replace('-', '', $row[3]) . '00' : null,
            'model'         => $row[4] ?? null,
            'qty_kanban'    => $row[5] ?? null,
            'customer'      => $row[6] ?? null,
            'tahun'         => $row[7] ?? null,
            'jan'           => $this->fixValue($row[8]  ?? null),
            'feb'           => $this->fixValue($row[9]  ?? null),
            'mar'           => $this->fixValue($row[10] ?? null),
            'apr'           => $this->fixValue($row[11] ?? null),
            'may'           => $this->fixValue($row[12] ?? null),
            'jun'           => $this->fixValue($row[13] ?? null),
            'jul'           => $this->fixValue($row[14] ?? null),
            'aug'           => $this->fixValue($row[15] ?? null),
            'sep'           => $this->fixValue($row[16] ?? null),
            'oct'           => $this->fixValue($row[17] ?? null),
            'nov'           => $this->fixValue($row[18] ?? null),
            'dec'           => $this->fixValue($row[19] ?? null),
        ]);
    }

    public function startRow(): int
    {
        return 4;
    }
}
