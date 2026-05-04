<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardAndonTsController extends Controller
{
    public function index() {

        $title = 'Dashboard Andon';

        // ------------ AMBIL DATA BARIS AKTIF TIAP LINE (status_proses=2, hari ini) ---------------
        $lineB1 = DB::table('planning_line_b3_s')->where('mesin', 'LINE B1')
            ->where('status_proses', 2)
            ->whereDate('date_plan', now()->toDateString())
            ->first();

        $lineB2 = DB::table('planning_line_b3_s')->where('mesin', 'LINE B2')
            ->where('status_proses', 2)
            ->whereDate('date_plan', now()->toDateString())
            ->first();

        $lineB3 = DB::table('planning_line_b3_s')->where('mesin', 'LINE B3')
            ->where('status_proses', 2)
            ->whereDate('date_plan', now()->toDateString())
            ->first();

        $lineC1 = DB::table('planning_line_b3_s')->where('mesin', 'LINE C1')
            ->where('status_proses', 2)
            ->whereDate('date_plan', now()->toDateString())
            ->first();

        $lineC2 = DB::table('planning_line_b3_s')->where('mesin', 'LINE C2')
            ->where('status_proses', 2)
            ->whereDate('date_plan', now()->toDateString())
            ->first();


        // ------------ TOTAL actual_production (status_proses=3) HANYA JIKA ADA DATA AKTIF ---------------

        $totalProdB1 = $lineB1
            ? DB::table('planning_line_b3_s')
                ->where('mesin', 'LINE B1')
                ->where('status_proses', 3)
                ->where('part_no', $lineB1->part_no)   // ⬅️ Tambahkan filter part_no aktif
                ->sum('actual_production')
            : null;

        $totalProdB2 = $lineB2
            ? DB::table('planning_line_b3_s')
                ->where('mesin', 'LINE B2')
                ->where('status_proses', 3)
                ->where('part_no', $lineB2->part_no)   // ⬅️ Tambahkan filter part_no aktif
                ->sum('actual_production')
            : null;

        $totalProdB3 = $lineB3
            ? DB::table('planning_line_b3_s')
                ->where('mesin', 'LINE B3')
                ->where('status_proses', 3)
                ->where('part_no', $lineB3->part_no)   // ⬅️ Tambahkan filter part_no aktif
                ->sum('actual_production')
            : null;

        $totalProdC1 = $lineC1
            ? DB::table('planning_line_b3_s')
                ->where('mesin', 'LINE C1')
                ->where('status_proses', 3)
                ->where('part_no', $lineC1->part_no)   // ⬅️ Tambahkan filter part_no aktif
                ->sum('actual_production')
            : null;

        $totalProdC2 = $lineC2
            ? DB::table('planning_line_b3_s')
                ->where('mesin', 'LINE C2')
                ->where('status_proses', 3)
                ->where('part_no', $lineC2->part_no)   // ⬅️ Tambahkan filter part_no aktif
                ->sum('actual_production')
            : null;


        return view('diemtc.dashboardandon', compact(
            'title',
            'lineB1', 'lineB2', 'lineB3', 'lineC1', 'lineC2',
            'totalProdB1', 'totalProdB2', 'totalProdB3', 'totalProdC1', 'totalProdC2'
        ));
    }
}
