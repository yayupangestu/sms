<?php

namespace App\Imports;

use App\Models\PcStoreDirect;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DataPcsNameImport implements ToModel, WithStartRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Ambil bulan & tahun berjalan
        $now = Carbon::now();
        $start = $now->copy()->startOfMonth();
        $end   = $now->copy()->endOfMonth();

        // Buat periode tanggal
        $period = CarbonPeriod::create($start, $end);

        // Hitung hari kerja (exclude Sabtu & Minggu)
        $workingDays = collect($period)->filter(function ($date) {
            return !$date->isWeekend(); // Sabtu & Minggu dikecualikan
        })->count();

        // Ambil monthly_volume dari file excel (konversi ke float)
        $monthlyVolume = isset($row[4]) ? (float) $row[4] : 0;

        // Hitung daily_volume
        $dailyVolume = $workingDays > 0 ? ceil($monthlyVolume / $workingDays) : 0;

        // Ambil qty_act (konversi ke float)
        $qtyAct = isset($row[6]) ? (float) $row[6] : 0;

        // Hitung strength (qty_act / daily_volume) → 1 angka di belakang koma
        $strength = 0;
        if ($dailyVolume > 0) {
            $strength = floor(($qtyAct / $dailyVolume) * 10) / 10;
            // contoh: 2.36 → 2.3 (tidak dibulatkan ke atas, hanya dipotong)
        }

        return new PcStoreDirect([
            'part_name'      => $row[0] ?? null,
            'part_no'        => $row[1] ?? null,
            'job_no'         => $row[2] ?? null,
            'part_no2'       => isset($row[1]) ? str_replace('-', '', $row[1]) . '00' : null,
            'model'          => $row[3] ?? null,
            'qty_kanban'     => $row[5] ?? null,
            'monthly_volume' => $monthlyVolume,
            'daily_volume'   => $dailyVolume,
            'qty_act'        => $qtyAct,
            'customer'       => $row[7] ?? null,
             'home_line'       => $row[8] ?? null,
             'vendor'       => $row[9] ?? null,
             'proses'       => $row[10] ?? null,
             'line'       => $row[11] ?? null,
            'strength'       => $strength,  // <--- tambahan disini
        ]);
    }



    /**
     * Mulai dari baris ke-3 untuk mengabaikan header.
     */
    public function startRow(): int
    {
        return 4;
    }
}
