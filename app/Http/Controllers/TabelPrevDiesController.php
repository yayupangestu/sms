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
use App\Models\UploadForcast;
use DataTables;
use Alert;
use PDF;
use DB;

class TabelPrevDiesController extends Controller
{
    public function index()
    {
        $title = 'Planning Line';
        $tabel_list_dies = DB::table('tabel_list_dies as a')
                ->select('a.id','a.part_no')
                ->get();
        return view('diemtc.index1', compact('tabel_list_dies','title'));
    }


    public function list(Request $request)
    {
        $year = $request->year ?? date('Y');

        /* ===============================
           DATA UTAMA (RINGAN & AKURAT)
        =============================== */
        $data = DB::table('tabel_list_dies as a')
            ->select(
                'a.part_no',
                'a.job_no',
                'a.model_id',
                'a.customer',
                'a.std_stroke',
                'a.date_prev',
                'a.proses',
                'a.line_id',

                // 🔥 total stroke dari date_prev (atau semua)
                DB::raw('(
                    SELECT COALESCE(SUM(b.actual_production),0)
                    FROM planning_line_b3_s b
                    WHERE b.part_no = a.part_no
                    AND (a.date_prev IS NULL OR b.date_plan >= a.date_prev)
                ) as jml_stroke'),

                // 🔥 Ambil SEMUA date_plan dari lkh_dies_mtcs (PREVENTIVE) di tahun ini
                DB::raw("(
                    SELECT GROUP_CONCAT(date_plan)
                    FROM lkh_dies_mtcs
                    WHERE job_no = a.job_no
                    AND category = 'PREVENTIVE'
                    AND YEAR(date_plan) = '{$year}'
                ) as date_plan_prev_list")
            )
            ->when($request->part_no !== 'all', function ($q) use ($request) {
                $q->where('a.part_no', $request->part_no);
            })
            ->groupBy(
                'a.part_no',
                'a.job_no',
                'a.model_id',
                'a.customer',
                'a.std_stroke',
                'a.date_prev',
                'a.proses',
                'a.line_id'
            )
            ->get();

        /* ===============================
           PRODUKSI WEEKLY (FILTER TAHUN)
        =============================== */
        $production = DB::table('planning_line_b3_s')
            ->select(
                'part_no',
                DB::raw('MONTH(date_plan) as month'),
                DB::raw('FLOOR((DAY(date_plan)-1)/7)+1 as week'),
                DB::raw('SUM(actual_production) as total')
            )
            ->whereYear('date_plan', $year)
            ->when($request->part_no !== 'all', function ($q) use ($request) {
                $q->where('part_no', $request->part_no);
            })
            ->groupBy('part_no','month','week')
            ->get();

        /* ===============================
           FORECAST (JOB NO + TAHUN)
        =============================== */
        $jobNos = $data->pluck('job_no')->unique();

        $forecast = UploadForcast::whereIn('job_no', $jobNos)
            ->where('tahun', $year)
            ->get()
            ->keyBy('job_no');

        return response()->json([
            'data'       => $data,
            'production' => $production,
            'forecast'   => $forecast
        ]);
    }

    public function weekDetail(Request $request)
{
    $part_no = $request->part_no;
    $month   = (int)$request->month;
    $week    = (int)$request->week - 1;
    $year    = $request->year ?? date('Y'); // Default tahun sekarang jika tidak dikirim

    $data = DB::table('planning_line_b3_s as b')
        ->leftJoin('tabel_list_dies as a', 'a.part_no', '=', 'b.part_no')
        ->where('b.part_no', $part_no)
        ->whereYear('b.date_plan', $year) // ✅ Tambahan Filter Tahun
        ->whereMonth('b.date_plan', $month)
        ->whereRaw('FLOOR((DAY(b.date_plan)-1)/7) = ?', [$week])
        ->where(function ($q) {
            $q
            // ✅ HISTORY → TETAP TAMPIL
            ->whereNotNull('b.actual_production')

            // ✅ PLANNING BARU → PATUH date_prev
            ->orWhere(function ($q2) {
                $q2->whereNull('a.date_prev')
                   ->orWhereColumn('b.date_plan', '>=', 'a.date_prev');
            });
        })
        ->orderBy('b.date_plan')
        ->get();

    return response()->json([
        'data' => $data
    ]);
}







}
