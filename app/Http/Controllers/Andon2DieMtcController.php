<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ⬅️ WAJIB ADA

class Andon2DieMtcController extends Controller
{
    public function index() {
        $title = 'DASHBOARD ANTRIAN';
        return view('diemtc.andonantrian', compact('title'));
    }

    public function getAndonToday()
    {
        // ✅ Ambil awal bulan dan akhir bulan ini
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
        $endOfMonth   = \Carbon\Carbon::now()->endOfDay();
        $today        = \Carbon\Carbon::now()->day;
        
        // Sesuai dengan andonantrian.blade.php: MAX_BOX_PER_DAY = 3
        $perDay = 3;
        $offset = ($today - 1) * $perDay;

        $data = DB::table('tabel_list_dies as a')
            ->leftJoin('planning_line_b3_s as b', 'a.part_no', '=', 'b.part_no')
            ->whereNotNull('a.std_stroke')
            ->where('a.std_stroke', '>', 0)
            ->select(
                'a.customer',
                'a.part_no',
                'a.job_no',
                'a.model_id',
                'a.line_id',
                'a.date_prev',
                DB::raw('MIN(a.std_stroke) as std_stroke'),
                DB::raw('MIN(a.proses) as op_proses'),
                
                // logic actual_stroke yang sama dengan Andon Board (production since last PM)
                DB::raw('
                    SUM(
                        CASE
                            WHEN a.date_prev IS NULL
                                 OR b.created_at >= a.date_prev
                            THEN b.actual_production
                            ELSE 0
                        END
                    ) as actual_stroke
                '),
                
                // Sorting logic (bulan ini)
                DB::raw("
                    SUM(
                        CASE
                            WHEN b.created_at >= '{$startOfMonth}' AND b.created_at <= '{$endOfMonth}'
                            THEN b.actual_production
                            ELSE 0
                        END
                    ) as actual_stroke_month
                ")
            )
            ->groupBy(
                'a.customer',
                'a.part_no',
                'a.job_no',
                'a.model_id',
                'a.line_id',
                'a.date_prev'
            )
            ->havingRaw('MIN(a.std_stroke) > 0')
            ->orderByDesc(DB::raw('
                SUM(
                    CASE
                        WHEN b.created_at >= \'' . $startOfMonth . '\' AND b.created_at <= \'' . $endOfMonth . '\'
                        THEN b.actual_production
                        ELSE 0
                    END
                )
            '))
            ->offset($offset)
            ->limit($perDay)
            ->get();

        return response()->json($data);
    }

    public function getLkhToday()
    {
        $today = \Carbon\Carbon::today()->toDateString();
        
        $data = DB::table('lkh_dies_mtcs')
            ->where('date_plan', $today)
            ->select(
                'part_no',
                'job_no',
                'model_id',
                'line_id',
                'problem',
                'proses',
                'tindakan',
                'dt_total',
                'pic'
            )
            ->get();
            
        return response()->json($data);
    }

    public function getDies()
    {
        // ✅ Ambil awal bulan dan akhir bulan ini
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
        $endOfMonth   = \Carbon\Carbon::now()->endOfDay();

        $data = DB::table('tabel_list_dies as a')
            ->leftJoin('planning_line_b3_s as b', 'a.part_no', '=', 'b.part_no')
            ->whereNotNull('a.std_stroke')
            ->where('a.std_stroke', '>', 0)
            ->select(
                'a.customer',
                'a.part_no',
                'a.job_no',
                'a.model_id',
                'a.line_id',
                'a.date_prev',
    
                DB::raw('MIN(a.std_stroke) as std_stroke'),
                DB::raw('MIN(a.proses) as op_proses'),
    
                // ✅ actual stroke UNTUK DISPLAY (tetap reset setelah preventive)
                DB::raw('
                    SUM(
                        CASE
                            WHEN a.date_prev IS NULL
                                 OR b.created_at >= a.date_prev
                            THEN b.actual_production
                            ELSE 0
                        END
                    ) as actual_stroke
                '),

                // ✅ actual stroke BULAN INI (untuk sorting & persistensi posisi)
                DB::raw("
                    SUM(
                        CASE
                            WHEN b.created_at >= '{$startOfMonth}' AND b.created_at <= '{$endOfMonth}'
                            THEN b.actual_production
                            ELSE 0
                        END
                    ) as actual_stroke_month
                "),
    
                // ✅ actual stroke TOTAL (TANPA filter date_prev)
                DB::raw('
                    COALESCE(SUM(b.actual_production),0) as actual_stroke_all
                ')
            )
            ->groupBy(
                'a.customer',
                'a.part_no',
                'a.job_no',
                'a.model_id',
                'a.line_id',
                'a.date_prev'
            )
            // ✅ Hanya tampilkan jika bulan ini ada produksi pembagi (mencegah pembagian nol jika data kosong)
            ->havingRaw('MIN(a.std_stroke) > 0')
            // ✅ Urutkan berdasarkan total produksi BULAN INI (actual_stroke_month)
            ->orderByDesc(DB::raw('
                SUM(
                    CASE
                        WHEN b.created_at >= \'' . $startOfMonth . '\' AND b.created_at <= \'' . $endOfMonth . '\'
                        THEN b.actual_production
                        ELSE 0
                    END
                )
            '))
            ->get();
    
        return response()->json($data);
    }
}
