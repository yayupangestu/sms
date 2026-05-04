<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RbtTmmin;
use Illuminate\Support\Facades\DB;

class DashboardWelding1Controller extends Controller
{
    // Halaman utama dashboard
    public function index()
    {
        $title = 'Dashboard Welding';

        // Ambil semua data dari DB, termasuk kolom sts
        $robotsData = RbtTmmin::select('job_no', 'qty_proses', 'sts', 'part_no', 'qty_plan')->get();
        $initialHourly = $this->getHourlyBuckets($robotsData);

        return view('welding.dashboard1', compact('title', 'robotsData', 'initialHourly'));
    }

    // Endpoint untuk auto-refresh data dashboard
    public function getData()
    {
        $data = DB::table('rbt_tmmins')
            ->select('job_no', 'qty_proses', 'sts', 'part_no', 'qty_plan')
            ->get();

        $hourly = $this->getHourlyBuckets($data);

        return response()->json([
            'production' => $data,
            'hourly' => $hourly
        ]);
    }

    private function getHourlyBuckets($actualData = null)
    {
        $now = now();
        $timeStr = $now->format('H:i');

        // Define Shift Window
        if ($timeStr >= '07:30') {
            $start = $now->copy()->setTime(7, 30, 0);
            $end = $now->copy()->setTime(16, 30, 0);
        } else {
            $start = $now->copy()->subDay()->setTime(7, 30, 0);
            $end = $now->copy()->subDay()->setTime(16, 30, 0);
        }

        $dateStr = $start->format('Y-m-d');
        $slotThresholds = [
            strtotime($dateStr . ' 08:30:00'),
            strtotime($dateStr . ' 09:30:00'),
            strtotime($dateStr . ' 10:30:00'),
            strtotime($dateStr . ' 11:30:00'),
            strtotime($dateStr . ' 13:15:00'),
            strtotime($dateStr . ' 14:15:00'),
            strtotime($dateStr . ' 15:15:00'),
            strtotime($dateStr . ' 16:30:00')
        ];

        // 1. Get Baseline (Max qty BEFORE shift start, limited to last 24h)
        $baselineCounters = DB::table('rbt_transaksis')
            ->select('job_no', 'part_no', DB::raw('MAX(qty_proses) as last_qty'))
            ->where('waktu', '<', $start->format('Y-m-d H:i:s'))
            ->where('waktu', '>', $start->copy()->subDay()->format('Y-m-d H:i:s'))
            ->groupBy('job_no', 'part_no')
            ->get()
            ->mapWithKeys(function ($item) {
                return [trim($item->job_no) . '|' . trim($item->part_no) => $item->last_qty];
            })
            ->toArray();

        // 2. Get Historical Records for today's slots
        $transaksis = DB::table('rbt_transaksis')
            ->select('job_no', 'part_no', 'waktu', 'qty_proses')
            ->whereBetween('waktu', [$start->format('Y-m-d H:i:s'), $end->format('Y-m-d H:i:s')])
            ->orderBy('waktu', 'asc')
            ->get();

        $maxInSlot = [];
        $latestRecordToday = [];
        foreach ($transaksis as $t) {
            $key = trim($t->job_no) . '|' . trim($t->part_no);
            $time = strtotime($t->waktu);
            $qty = (int) $t->qty_proses;

            if (!isset($maxInSlot[$key]))
                $maxInSlot[$key] = array_fill(0, 8, -1);

            for ($i = 0; $i < 8; $i++) {
                if ($time < $slotThresholds[$i]) {
                    if ($qty > $maxInSlot[$key][$i])
                        $maxInSlot[$key][$i] = $qty;
                    break;
                }
            }
            $latestRecordToday[$key] = ['qty' => $qty, 'time' => $time];
        }

        // 3. Determine Current Active Slot
        $currentSlot = -1;
        $isShiftActive = false;
        if ($timeStr >= '07:30' && $timeStr <= '16:30') {
            $isShiftActive = true;
            if ($timeStr >= '07:30' && $timeStr < '08:30')
                $currentSlot = 0;
            elseif ($timeStr >= '08:30' && $timeStr < '09:30')
                $currentSlot = 1;
            elseif ($timeStr >= '09:30' && $timeStr < '10:30')
                $currentSlot = 2;
            elseif ($timeStr >= '10:30' && $timeStr < '11:30')
                $currentSlot = 3;
            elseif ($timeStr >= '12:15' && $timeStr < '13:15')
                $currentSlot = 4;
            elseif ($timeStr >= '13:15' && $timeStr < '14:15')
                $currentSlot = 5;
            elseif ($timeStr >= '14:15' && $timeStr < '15:15')
                $currentSlot = 6;
            elseif ($timeStr >= '15:15' && $timeStr <= '16:30')
                $currentSlot = 7;
        }

        $hourly = [];
        if ($actualData && $isShiftActive) {
            foreach ($actualData as $t) {
                $jobId = trim($t->job_no);
                $partNo = trim($t->part_no);
                $key = $jobId . '|' . $partNo;
                $currentQty = (int) ($t->qty_proses ?? 0);

                // Handle Counter Reset
                $baseline = $baselineCounters[$key] ?? 0;
                if ($currentQty < $baseline) {
                    $baseline = 0;
                }

                $slots = $maxInSlot[$key] ?? array_fill(0, 8, -1);

                // Auto-Snapshot Mechanism
                $lastVal = $latestRecordToday[$key]['qty'] ?? -1;
                $lastTime = $latestRecordToday[$key]['time'] ?? 0;
                if ($currentQty > 0 && ($currentQty > $lastVal || (time() - $lastTime > 600))) {
                    DB::table('rbt_transaksis')->insert([
                        'job_no' => $jobId,
                        'part_no' => $partNo,
                        'qty_proses' => $currentQty,
                        'waktu' => now()->format('Y-m-d H:i:s'),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                    if ($currentSlot != -1) {
                        if (!isset($maxInSlot[$key])) $maxInSlot[$key] = array_fill(0, 8, -1);
                        $maxInSlot[$key][$currentSlot] = $currentQty;
                        $slots = $maxInSlot[$key];
                    }
                }

                $hourly[$key] = [
                    'actual' => [0, 0, 0, 0, 0, 0, 0, 0],
                    'target' => [0, 0, 0, 0, 0, 0, 0, 0]
                ];

                // Target Calculation
                $plan = (int) ($t->qty_plan ?? 0);
                $hourlyTarget = floor($plan / 8);
                $remainder = $plan % 8;
                for ($i = 0; $i < 8; $i++) {
                    $hourly[$key]['target'][$i] = $hourlyTarget + ($i < $remainder ? 1 : 0);
                }

                // Production Delta Calculation (with strict Isolation)
                $prevMax = $baseline;
                for ($i = 0; $i < 8; $i++) {
                    if ($i <= $currentSlot) {
                        // For past slots, use history. If missing, assume it stayed at prevMax to prevent bleeding.
                        // For current slot, use real-time qty.
                        $val = ($i == $currentSlot) ? $currentQty : ($slots[$i] != -1 ? $slots[$i] : $prevMax);

                        $hourly[$key]['actual'][$i] = max(0, $val - $prevMax);
                        $prevMax = $val;
                    } else {
                        $hourly[$key]['actual'][$i] = 0;
                    }
                }
            }
        }

        return $hourly;
    }


    public function getJobDetail(Request $request)
    {
        $jobNo = $request->job_no;

        // Waktu sekarang
        $now = now();

        if ($now->format('H:i') >= '07:00') {
            // Shift dari 07:00 hari ini sampai 06:59 besok
            $start = $now->copy()->setTime(7, 0, 0);
            $end = $now->copy()->addDay()->setTime(6, 59, 59);
        } else {
            // Shift dari 07:00 kemarin sampai 06:59 hari ini
            $start = $now->copy()->subDay()->setTime(7, 0, 0);
            $end = $now->copy()->setTime(6, 59, 59);
        }

        $data = DB::table('rbt_transaksis')
            ->select('id', 'part_no', 'job_no', 'waktu', 'qty_proses', 'model')
            ->where('job_no', $jobNo)
            ->whereBetween('waktu', [$start, $end])
            ->orderBy('waktu', 'desc')
            ->get();

        return response()->json($data);
    }

}

