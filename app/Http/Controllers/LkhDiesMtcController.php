<?php
namespace App\Http\Controllers;
// use App\Exports\ReportB3Export;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\TabelListDies;
use App\Models\TabelC2;
use App\Models\DataPartName;
use App\Models\LkhDiesMtc;
// use App\Models\DataModel;
use App\Models\RmMaterial;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use DB;

use Barryvdh\DomPDF\Facade\Pdf;

class LkhDiesMtcController extends Controller
{
    public function index()
    {
        $title = 'LKH DIES';

        // 👇 jumlah data
        $TotalDies = TabelListDies::count();

        // 👇 semua data untuk dropdown
        $TabelListDies = TabelListDies::all();
        $TabelListDies2 = TabelListDies::count();


        $TotalStrokeKurang = DB::table('tabel_list_dies as a')
        ->leftJoin('planning_line_b3_s as b', function ($join) {
            $join->on('a.part_no', '=', 'b.part_no')
                 ->where(function ($q) {
                     $q->whereNull('a.date_prev')
                       ->orWhereColumn('b.created_at', '>=', 'a.date_prev');
                 });
        })
        ->select(
            'a.part_no',
            DB::raw('MIN(a.std_stroke) as std_stroke'),
            DB::raw('COALESCE(SUM(b.actual_production), 0) as jml_stroke')
        )
        ->groupBy('a.part_no')
        ->havingRaw('
            CASE
                WHEN MIN(a.std_stroke) = 0 THEN 0
                ELSE ((COALESCE(SUM(b.actual_production), 0) / MIN(a.std_stroke)) * 100)
            END BETWEEN 90 AND 100
        ')
        ->count();


       $TotalStrokeOver = DB::table('tabel_list_dies as a')
            ->leftJoin('planning_line_b3_s as b', function ($join) {
                $join->on('a.part_no', '=', 'b.part_no')
                    ->where(function ($q) {
                        $q->whereNull('a.date_prev')
                        ->orWhereColumn('b.created_at', '>=', 'a.date_prev');
                    });
            })
            ->select(
                'a.part_no',
                DB::raw('MIN(a.std_stroke) as std_stroke'),
                DB::raw('COALESCE(SUM(b.actual_production), 0) as jml_stroke')
            )
            ->groupBy('a.part_no')
            ->havingRaw('
                CASE
                    WHEN MIN(a.std_stroke) = 0 THEN 0
                    ELSE ((COALESCE(SUM(b.actual_production), 0) / MIN(a.std_stroke)) * 100)
                END > 100
            ')
            ->count();

        //////////BATAS
        $StrokeList = DB::table('tabel_list_dies as a')
        ->leftJoin('planning_line_b3_s as b', function ($join) {
            $join->on('a.part_no', '=', 'b.part_no')
                 ->where(function ($q) {
                     $q->whereNull('a.date_prev')
                       ->orWhereColumn('b.created_at', '>=', 'a.date_prev');
                 });
        })
        ->select(
            'a.part_no',
            DB::raw('MIN(a.std_stroke) as std_stroke'),
            DB::raw('COALESCE(SUM(b.actual_production), 0) as jml_stroke'),
            DB::raw('
                CASE
                    WHEN MIN(a.std_stroke) = 0 THEN 0
                    ELSE ROUND((COALESCE(SUM(b.actual_production), 0) / MIN(a.std_stroke)) * 100, 2)
                END as persen_progress
            ')
        )
        ->groupBy('a.part_no')
        ->havingRaw('
            CASE
                WHEN MIN(a.std_stroke) = 0 THEN 0
                ELSE ((COALESCE(SUM(b.actual_production), 0) / MIN(a.std_stroke)) * 100)
            END BETWEEN 90 AND 100
        ')
        ->get();


        $StrokeList2 = DB::table('tabel_list_dies as a')
            ->leftJoin('planning_line_b3_s as b', 'a.part_no', '=', 'b.part_no')
            ->select(
                'a.part_no',
                DB::raw('MIN(a.std_stroke) as std_stroke'),
                DB::raw('COALESCE(SUM(b.actual_production), 0) as jml_stroke'),
                DB::raw('
            CASE
                WHEN MIN(a.std_stroke) = 0 THEN 0
                ELSE ROUND((COALESCE(SUM(b.actual_production), 0) / MIN(a.std_stroke)) * 100, 2)
            END as persen_progress
        '),
            )
            ->groupBy('a.part_no')
            ->havingRaw(
                '
        CASE
            WHEN MIN(a.std_stroke) = 0 THEN 0
            ELSE ((COALESCE(SUM(b.actual_production), 0) / MIN(a.std_stroke)) * 100)
        END > 100
    ',
            )
            ->get();

        $TotalHistory = LkhDiesMtc::count();

        return view('diemtc.lkhdies', compact('title', 'TotalDies', 'TabelListDies', 'TotalStrokeKurang', 'StrokeList', 'StrokeList2', 'TotalStrokeOver','TabelListDies2', 'TotalHistory'));
    }

    // public function getList() {
    //     $data = TabelListDies::all();
    //     return response()->json($data);
    // }
    public function getList()
    {
        $data = DB::table('tabel_list_dies as a')
            ->leftJoin('planning_line_b3_s as b', function ($join) {
                $join->on('a.part_no', '=', 'b.part_no')
                     ->where(function ($q) {
                         $q->whereNull('a.date_prev')
                           ->orWhereColumn('b.created_at', '>=', 'a.date_prev');
                     });
            })
            ->select(
                'a.part_name',
                'a.part_no',
                'a.job_no',
                'a.model_id',
                'a.line_id',
                'a.std_stroke',

                // actual stroke
                DB::raw('COALESCE(SUM(b.actual_production),0) as actual_stroke'),

                // progress %
                DB::raw('
                    CASE
                        WHEN a.std_stroke IS NULL OR a.std_stroke = 0 THEN NULL
                        ELSE ROUND(
                            (COALESCE(SUM(b.actual_production),0) / a.std_stroke) * 100
                        ,2)
                    END as progress
                ')
            )
            ->groupBy(
                'a.part_name',
                'a.part_no',
                'a.job_no',
                'a.model_id',
                'a.line_id',
                'a.std_stroke',
                'a.date_prev'
            )
            ->orderByDesc(DB::raw('
                COALESCE(SUM(b.actual_production),0) / NULLIF(a.std_stroke,0)
            '))
            ->get();

        return response()->json($data);
    }


    public function refreshStroke()
    {
        /*
     Ambil actual_stroke dari planning_line_b3_s
     lalu update ke tabel_list_dies.jml_stroke
     berdasarkan part_no
    */

        $data = DB::table('planning_line_b3_s')->select('part_no', DB::raw('SUM(actual_production) as actual_stroke'))->groupBy('part_no')->get();

        foreach ($data as $row) {
            DB::table('tabel_list_dies')
                ->where('part_no', $row->part_no)
                ->update([
                    'jml_stroke' => $row->actual_stroke,
                ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Actual stroke berhasil diperbarui',
        ]);
    }

    public function list()
    {
        $query = DB::table('lkh_dies_mtcs as a')
            ->select(
                'a.doc_job',
                'a.category',
                'a.date_plan',
                DB::raw("
                    GROUP_CONCAT(
                        DISTINCT CONCAT(a.part_no, ' (', (
                            SELECT COUNT(*)
                            FROM lkh_dies_mtcs
                            WHERE doc_job = a.doc_job
                            AND part_no = a.part_no
                        ), ')')
                        ORDER BY a.part_no ASC
                        SEPARATOR ', '
                    ) as part_nos
                "),
                DB::raw('MAX(a.created_at) as last_created')
            )
            ->groupBy('a.doc_job', 'a.category', 'a.date_plan')
            ->orderByDesc('last_created')
            ->get();

        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('lkh_dies_mtcs as a')->select('a.id', 'a.job_no', 'a.part_no', 'a.model_id', 'a.line_id', 'a.foto_awal', 'a.foto_akhir','a.proses')->where('a.doc_job', $request->doc_job);

        return DataTables::of($query)->make(true);
    }

    public function getdoc()
    {
        $cek = LkhDiesMtc::select(DB::raw('COUNT(doc_job) as jml'))->whereMonth('created_at', date('m'))->groupBy('doc_job')->count();
        if ($cek > 0) {
            $array = [];
            $rows = LkhDiesMtc::select('doc_job')->whereMonth('created_at', date('m'))->groupBy('doc_job')->get();
            foreach ($rows as $key => $value) {
                $array[] = $value->doc_job;
            }
            $arr_doc = count($array);
            return response()->json([
                'jml' => $arr_doc + 1,
            ]);
        } else {
            return response()->json([
                'jml' => 1,
            ]);
        }
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'foto_awal' => 'nullable|image|max:1024',
    //         'foto_akhir' => 'nullable|image|max:1024',
    //     ]);

    //     // =======================
    //     // FORMAT TANGGAL
    //     // =======================
    //     $datePlan = $request->date_plan
    //         ? Carbon::createFromFormat('d/m/Y', $request->date_plan)->format('Y-m-d')
    //         : null;

    //     $dtStart = $request->dt_start
    //         ? Carbon::createFromFormat('d/m/Y H:i', $request->dt_start)->format('Y-m-d H:i:s')
    //         : null;

    //     $dtFinish = $request->dt_finish
    //         ? Carbon::createFromFormat('d/m/Y H:i', $request->dt_finish)->format('Y-m-d H:i:s')
    //         : null;

    //     // =======================
    //     // INSERT LKH
    //     // =======================
    //     $plan = new LkhDiesMtc();
    //     $plan->doc_job   = $request->doc_job;
    //     $plan->date_plan = $datePlan;
    //     $plan->part_no   = $request->part_no;
    //     $plan->job_no    = $request->job_no;
    //     $plan->model_id  = $request->model_id;
    //     $plan->line_id   = $request->line_id;
    //     $plan->proses    = $request->proses;
    //     $plan->problem   = $request->problem;
    //     $plan->category  = $request->category;
    //     $plan->tindakan  = $request->tindakan;
    //     $plan->pic       = $request->pic;
    //     $plan->dt_start  = $dtStart;
    //     $plan->dt_finish = $dtFinish;
    //     $plan->remarks   = $request->remarks;
    //     $plan->createdby = auth()->user()->username;

    //     // =======================
    //     // UPLOAD FOTO
    //     // =======================
    //     $folder = public_path('dist/img');

    //     if ($request->hasFile('foto_awal')) {
    //         $nameAwal = time().'_awal.'.$request->foto_awal->extension();
    //         $request->foto_awal->move($folder, $nameAwal);
    //         $plan->foto_awal = $nameAwal;
    //     }

    //     if ($request->hasFile('foto_akhir')) {
    //         $nameAkhir = time().'_akhir.'.$request->foto_akhir->extension();
    //         $request->foto_akhir->move($folder, $nameAkhir);
    //         $plan->foto_akhir = $nameAkhir;
    //     }

    //     $plan->save();


    //     if ($request->category === 'PREVENTIVE') {

    //         // hitung berapa kali preventive untuk job_no ini
    //         $countPreventive = LkhDiesMtc::where('job_no', $request->job_no)
    //             ->where('category', 'PREVENTIVE')
    //             ->count();

    //         TabelListDies::where('job_no', $request->job_no)->update([
    //             'cycle_prev' => $countPreventive,
    //             'date_prev'  => now(),
    //         ]);
    //     }


    //     return response()->json([
    //         'success' => true,
    //         'msg' => 'Insert success.',
    //     ]);
    // }

    public function store(Request $request)
    {
        // =======================
        // VALIDASI
        // =======================
        $request->validate([
            'foto_awal'  => 'nullable|image|max:1024',
            'foto_akhir' => 'nullable|image|max:1024',
        ]);

        // =======================
        // FORMAT TANGGAL & JAM
        // =======================
        $datePlan = $request->date_plan
            ? Carbon::createFromFormat('d/m/Y', $request->date_plan)->format('Y-m-d')
            : null;

        $dtStart = $request->dt_start
            ? Carbon::createFromFormat('d/m/Y H:i', $request->dt_start)->format('Y-m-d H:i:s')
            : null;

        $dtFinish = $request->dt_finish
            ? Carbon::createFromFormat('d/m/Y H:i', $request->dt_finish)->format('Y-m-d H:i:s')
            : null;

        // =======================
        // HITUNG SELISIH MENIT
        // =======================
        $dtTotal = null;

        if ($dtStart && $dtFinish) {

            $start  = Carbon::parse($dtStart);
            $finish = Carbon::parse($dtFinish);

            // Validasi logika waktu
            if ($finish->lt($start)) {
                return response()->json([
                    'success' => false,
                    'msg' => 'Waktu finish tidak boleh lebih kecil dari start'
                ], 422);
            }

            // 🔥 HASIL DALAM MENIT SAJA
            $dtTotal = $start->diffInMinutes($finish);
        }

        // =======================
        // INSERT DATA
        // =======================
        $plan = new LkhDiesMtc();
        $plan->doc_job   = $request->doc_job;
        $plan->date_plan = $datePlan;
        $plan->part_no   = $request->part_no;
        $plan->job_no    = $request->job_no;
        $plan->model_id  = $request->model_id;
        $plan->line_id   = $request->line_id;
        $plan->proses    = $request->proses;
        $plan->problem   = $request->problem;
        $plan->category  = $request->category;
        $plan->tindakan  = $request->tindakan;
        $plan->pic       = $request->pic;
        $plan->dt_start  = $dtStart;
        $plan->dt_finish = $dtFinish;
        $plan->dt_total  = $dtTotal; // ✅ MENIT
        $plan->remarks   = $request->remarks;
        $plan->createdby = auth()->user()->id;
        // $plan->created_at = $datePlan;
        // $plan->updated_at = $datePlan;

        // =======================
        // UPLOAD FOTO
        // =======================
        $folder = public_path('dist/img');

        if ($request->hasFile('foto_awal')) {
            $nameAwal = time().'_awal.'.$request->foto_awal->extension();
            $request->foto_awal->move($folder, $nameAwal);
            $plan->foto_awal = $nameAwal;
        }

        if ($request->hasFile('foto_akhir')) {
            $nameAkhir = time().'_akhir.'.$request->foto_akhir->extension();
            $request->foto_akhir->move($folder, $nameAkhir);
            $plan->foto_akhir = $nameAkhir;
        }

        $plan->save();

        // =======================
        // UPDATE PREVENTIVE
        // =======================
        if ($request->category === 'PREVENTIVE') {

            $countPreventive = LkhDiesMtc::where('job_no', $request->job_no)
                ->where('category', 'PREVENTIVE')
                ->count();

            TabelListDies::where('job_no', $request->job_no)->update([
                'cycle_prev' => $countPreventive,
                'date_prev'  => $datePlan,
            ]);
        }

        // =======================
        // RESPONSE
        // =======================
        return response()->json([
            'success'  => true,
            'msg'      => 'Insert success',
            'dt_total' => $dtTotal
        ]);
    }


    // public function edit(Request $request)
    // {
    //     $cek = PlanningLineC2::where('id', $request->id)->count();
    //     if ($cek > 0) {
    //         $row = PlanningLineC2::where('id', $request->id)->first();
    //         return response()->json([
    //             'success' => true,
    //             'id' => $row->id,
    //             'product_id' => $row->product_id,
    //             'qty_plan' => $row->qty_plan,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'msg' => 'Data Not found.',
    //         ]);
    //     }
    // }

    public function update(Request $request)
    {
        $data['product_id'] = $request->product_id;
        $data['qty_plan'] = $request->qty_plan;
        $data['updatedby'] = auth()->user()->id;
        $query = PlanningLineC2::where('id', $request->id)->update($data);
        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Edit success.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Edit failed.',
            ]);
        }
    }

    public function destroyline(Request $request)
    {
        $query = LkhDiesMtc::where('id', $request->id)->delete();
        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Delete success.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Delete failed.',
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $query = LkhDiesMtc::where('doc_job', $request->doc_job)->delete();

        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Delete success.',
            ]);
        }

        return response()->json([
            'success' => false,
            'msg' => 'Delete failed.',
        ]);
    }

    public function export()
    {
        return Excel::download(new ReportB3Export(), 'report.xlsx');
    }

    // public function generatePdf($id)
    // {

    //     // dd('MASUK CONTROLLER', $id);
    //     $data = LkhDiesMtc::findOrFail($id);
    //     $pdf = Pdf::loadView('diemtc.lkh', compact('data'))
    //     ->setPaper('A4', 'landscape')
    //     ->setOption('dpi', 96)
    //     ->setOption('defaultFont', 'Arial');

    // return $pdf->stream('LKH-DIES-'.$data->job_no.'.pdf');

    // }

    // public function generatePdf2($doc_job)
    // {
    //     $datas = LkhDiesMtc::where('doc_job', $doc_job)->get();

    //     if ($datas->isEmpty()) {
    //         abort(404, 'Data tidak ditemukan');
    //     }

    //     $header = $datas->first(); // ✅ ambil header

    //     $pdf = Pdf::loadView('diemtc.lkh2', compact('datas', 'header'))
    //         ->setPaper('A4', 'landscape')
    //         ->setOption('dpi', 96)
    //         ->setOption('defaultFont', 'Arial');

    //     return $pdf->stream('LKH-DIES-' . $doc_job . '.pdf');
    // }

    public function generatePdf($doc_job)
    {
        // Ambil semua data berdasarkan doc_job
        $datas = LkhDiesMtc::where('doc_job', $doc_job)->get();

        if ($datas->isEmpty()) {
            abort(404, 'Data tidak ditemukan');
        }

        // Header (ambil data pertama)
        $header = $datas->first();

        // ===============================
        // INIT DOWNTIME (MENIT)
        // ===============================
        $downtime = [
             'AREA' => 0,
            'LINE A1' => 0,
            'LINE A2' => 0,
            'LINE A3' => 0,
            'LINE B1' => 0,
            'LINE B2' => 0,
            'LINE B3' => 0,
            'LINE C1' => 0,
            'LINE C2' => 0,
        ];

        // ===============================
        // ISI DOWNTIME DARI dt_total
        // ===============================
        foreach ($datas as $row) {
            if (
                isset($downtime[$row->line_id]) &&
                !is_null($row->dt_total)
            ) {
                $downtime[$row->line_id] += (int) $row->dt_total;
            }
        }

        // ===============================
        // GENERATE PDF
        // ===============================
        $pdf = Pdf::loadView(
            'diemtc.lkh2',
            compact('datas', 'header', 'downtime')
        )
        ->setPaper('A4', 'landscape')
        ->setOption('dpi', 96)
        ->setOption('defaultFont', 'Arial');

        return $pdf->stream('LKH-DIES-' . $doc_job . '.pdf');
    }

    public function generatePdf2($doc_job)
    {
        // Ambil semua data berdasarkan doc_job
        $datas = LkhDiesMtc::where('doc_job', $doc_job)->get();

        if ($datas->isEmpty()) {
            abort(404, 'Data tidak ditemukan');
        }

        // Header (ambil data pertama)
        $header = $datas->first();

        // ===============================
        // INIT DOWNTIME (MENIT)
        // ===============================
        $downtime = [
             'AREA' => 0,
            'LINE A1' => 0,
            'LINE A2' => 0,
            'LINE A3' => 0,
            'LINE B1' => 0,
            'LINE B2' => 0,
            'LINE B3' => 0,
            'LINE C1' => 0,
            'LINE C2' => 0,
        ];

        // ===============================
        // ISI DOWNTIME DARI dt_total
        // ===============================
        foreach ($datas as $row) {
            if (
                isset($downtime[$row->line_id]) &&
                !is_null($row->dt_total)
            ) {
                $downtime[$row->line_id] += (int) $row->dt_total;
            }
        }

        // ===============================
        // GENERATE PDF
        // ===============================
        $pdf = Pdf::loadView(
            'diemtc.lkh2',
            compact('datas', 'header', 'downtime')
        )
        ->setPaper('A4', 'landscape')
        ->setOption('dpi', 96)
        ->setOption('defaultFont', 'Arial');

        return $pdf->stream('LKH-DIES-' . $doc_job . '.pdf');
    }


    public function getHistory(Request $request)
    {
        $jobNo = $request->job_no;
        $partNo = $request->part_no;

        $query = LkhDiesMtc::where('part_no', $partNo);

        if ($jobNo) {
            $query->where('job_no', $jobNo);
        }

        $data = $query->select(
                'id',
                'date_plan as tanggal',
                'category',
                'problem',
                'tindakan as perbaikan',
                'dt_total',
                'dt_start',
                'dt_finish',
                'pic',
                'remarks as status'
            )
            ->orderBy('date_plan', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }




}
