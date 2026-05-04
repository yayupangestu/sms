<?php

namespace App\Http\Controllers;
// use App\Exports\ReportB3Export;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LineStmp;
use App\Models\TabelB3;
use App\Models\DataPartName;
use App\Models\PlanningLineB3;
use App\Models\DataModel;
use App\Models\RmMaterial;
use Illuminate\Http\Request;
use App\Models\RmStok;
use Carbon\Carbon; // Pastikan Anda sudah mengimpor Carbon
use Yajra\DataTables\Facades\DataTables;
use DB;

class Dashbaord2Controller extends Controller
{
    public function index()
    {
        $title = 'Dashboard2';

        // Ambil data dari tabel planning_line_b3_s dengan filter kolom mesin = 'LINE B3'
        // $planningDataB3         = PlanningLineB3::where('mesin', 'LINE B3')->get();
        // $planningDataC1         = PlanningLineB3::where('mesin', 'LINE C1')->get();
        // $planningDataC2         = PlanningLineB3::where('mesin', 'LINE C2')->get();
        // $planningDataB1         = PlanningLineB3::where('mesin', 'LINE B1')->get();
        // $planningDataB2         = PlanningLineB3::where('mesin', 'LINE B2')->get();
        // $planningDataA1         = PlanningLineB3::where('mesin', 'LINE A1')->get();
        // $planningDataA2         = PlanningLineB3::where('mesin', 'LINE A2')->get();
        // $planningData3000       = PlanningLineB3::where('mesin', 'TRANSFERS')->get();
        // $planningDataKomatsu    = PlanningLineB3::where('mesin', 'KOMATSU')->get();
        // $planningDataFukui      = PlanningLineB3::where('mesin', 'FUKUI')->get();


        return view('pcstore.dashboard2', compact('title'));
    }

    // app/Http/Controllers/Dashbaord2Controller.php
    public function getDashboardData(Request $request)
    {
        $shift = $request->shift;

        $now = Carbon::now();

        // Tentukan waktu shift: 01:00 hari ini sampai 07:00 besok
        if ($now->hour < 7) {
            // Shift masih termasuk hari sebelumnya
            $startTime = Carbon::yesterday()->setHour(7)->setMinute(0)->setSecond(0);
            $endTime   = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
        } else {
            // Hari produksi berjalan normal
            $startTime = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
            $endTime   = Carbon::tomorrow()->setHour(7)->setMinute(0)->setSecond(0);
        }

        $planningDataB3 = PlanningLineB3::where('mesin', 'LINE B3')
                            ->whereBetween('created_at', [$startTime, $endTime])
                            ->when($shift, function ($query) use ($shift) {
                                return $query->where('shift', $shift);
                            })
                            ->orderBy('position', 'asc')
                            ->get();

        $planningDataC1 = PlanningLineB3::where('mesin', 'LINE C1')
                            ->whereBetween('created_at', [$startTime, $endTime])
                            ->when($shift, function ($query) use ($shift) {
                                return $query->where('shift', $shift);
                            })
                            ->orderBy('position', 'asc')
                            ->get();

        $planningDataA2 = PlanningLineB3::where('mesin', 'LINE A2')
                            ->whereBetween('created_at', [$startTime, $endTime])
                            ->when($shift, function ($query) use ($shift) {
                                return $query->where('shift', $shift);
                            })
                            ->orderBy('position', 'asc')
                            ->get();

         $planningDataA1 = PlanningLineB3::where('mesin', 'LINE A1')
                            ->whereBetween('created_at', [$startTime, $endTime])
                            ->when($shift, function ($query) use ($shift) {
                                return $query->where('shift', $shift);
                            })
                            ->orderBy('position', 'asc')
                            ->get();


        $planningDataB2 = PlanningLineB3::where('mesin', 'LINE B2')
                            ->whereBetween('created_at', [$startTime, $endTime])
                            ->when($shift, function ($query) use ($shift) {
                                return $query->where('shift', $shift);
                            })
                            ->orderBy('position', 'asc')
                            ->get();

         $planningDataB1 = PlanningLineB3::where('mesin', 'LINE B1')
                            ->whereBetween('created_at', [$startTime, $endTime])
                            ->when($shift, function ($query) use ($shift) {
                                return $query->where('shift', $shift);
                            })
                            ->orderBy('position', 'asc')
                            ->get();

        $planningDataC2 = PlanningLineB3::where('mesin', 'LINE C2')
                            ->whereBetween('created_at', [$startTime, $endTime])
                            ->when($shift, function ($query) use ($shift) {
                                return $query->where('shift', $shift);
                            })
                            ->orderBy('position', 'asc')
                            ->get();

        $planningDataKomatsu = PlanningLineB3::where('mesin', 'KOMATSU')
                            ->whereBetween('created_at', [$startTime, $endTime])
                            ->when($shift, function ($query) use ($shift) {
                                return $query->where('shift', $shift);
                            })
                            ->orderBy('position', 'asc')
                            ->get();

        $planningDataFukui = PlanningLineB3::where('mesin', 'FUKUI')
                            ->whereBetween('created_at', [$startTime, $endTime])
                            ->when($shift, function ($query) use ($shift) {
                                return $query->where('shift', $shift);
                            })
                            ->orderBy('position', 'asc')
                            ->get();
        $planningData3000 = PlanningLineB3::where('mesin', 'TRANSFERS')
                            ->whereBetween('created_at', [$startTime, $endTime])
                            ->when($shift, function ($query) use ($shift) {
                                return $query->where('shift', $shift);
                            })
                            ->orderBy('position', 'asc')
                            ->get();

        return response()->json([
            'planningDataB3'        => $planningDataB3,
            'planningDataC1'        => $planningDataC1,
            'planningDataC2'        => $planningDataC2,
            'planningDataB1'        => $planningDataB1,
            'planningDataB2'        => $planningDataB2,
            'planningDataA1'        => $planningDataA1,
            'planningDataA2'        => $planningDataA2,
             'planningData3000'   => $planningData3000,
            'planningDataKomatsu'   => $planningDataKomatsu,
            'planningDataFukui'     => $planningDataFukui,
        ]);
    }



}
