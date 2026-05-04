<?php

namespace App\Imports;

use App\Models\UploadForcast;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class ForcastImport2 implements ToModel, WithStartRow, SkipsEmptyRows
{
    private function fixValue($val)
    {
        if ($val === '-' || $val === '' || $val === null) {
            return null; // jangan ubah jadi 0 → agar tidak overwrite
        }

        $val = str_replace(',', '.', $val);
        $val = preg_replace('/[^0-9.]/', '', $val);

        if ($val === '') {
            return null;
        }

        return round((float) $val);
    }

    public function model(array $row)
    {
        $tahun  = $row[4] ?? null;
        $uniqNo = $row[0] ?? null;

        // Data akan diupdate hanya jika ada nilai di Excel
        $updateData = [];

        // Jan
        $jan = $this->fixValue($row[5] ?? null);
        if (!is_null($jan)) {
            $updateData['jan_month'] = $jan;
        }
        // Feb
        $feb = $this->fixValue($row[6] ?? null);
        if (!is_null($feb)) {
            $updateData['feb_month'] = $feb;
        }
        // Mar
        $mar = $this->fixValue($row[7] ?? null);
        if (!is_null($mar)) {
            $updateData['mar_month'] = $mar;
        }

         $apr = $this->fixValue($row[8] ?? null);
        if (!is_null($apr)) {
            $updateData['apr_month'] = $apr;
        }
        $may = $this->fixValue($row[9] ?? null);
        if (!is_null($may)) {
            $updateData['may_month'] = $may;
        }

         $jun = $this->fixValue($row[10] ?? null);
        if (!is_null($jun)) {
            $updateData['jun_month'] = $jun;
        }

        $jul = $this->fixValue($row[11] ?? null);
        if (!is_null($jul)) {
            $updateData['jul_month'] = $jul;
        }

        $aug = $this->fixValue($row[12] ?? null);
        if (!is_null($aug)) {
            $updateData['aug_month'] = $aug;
        }

        $sep = $this->fixValue($row[13] ?? null);
        if (!is_null($sep)) {
            $updateData['sep_month'] = $sep;
        }

        $oct = $this->fixValue($row[14] ?? null);
        if (!is_null($oct)) {
            $updateData['oct_month'] = $oct;
        }

        $nov = $this->fixValue($row[15] ?? null);
        if (!is_null($nov)) {
            $updateData['nov_month'] = $nov;
        }

        $dec = $this->fixValue($row[16] ?? null);
        if (!is_null($dec)) {
            $updateData['dec_month'] = $dec;
        }

        return UploadForcast::updateOrCreate(
            [
                'tahun'  => $tahun,
                'uniqNo' => $uniqNo,
            ],
            $updateData
        );
    }

    public function startRow(): int
    {
        return 4;
    }
}
