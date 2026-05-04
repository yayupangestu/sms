<?php

namespace App\Http\Controllers;
// use App\Exports\ReportB3Export;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\TabelStokBlank;
use App\Models\TagLabelBlank;
use App\Models\PlanningLineB3;
use App\Models\TabelC2;
use App\Models\ScanInBlank;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use DB;

class TagLabelBlankController extends Controller
{
    // public function index()
    // {
    //     $title = 'Create Label';
    //     $tabel_stok_blanks = TabelStokBlank::all();
    //     $planning_lineb3_s = PlanningLineB3::all();
    //     return view('blank.taglabel', compact('title','tabel_stok_blanks'));
    // }

    public function index()
    {
        $title = 'Create Label';
        $today = Carbon::today()->toDateString();

        $tabel_stok_blanks = DB::table('tabel_stok_blanks as a')
        ->join('planning_line_b3_s as b', 'b.part_no', '=', 'a.part_no')
        ->where('b.date_plan', $today)
        ->select(
            'a.id',
            'a.part_no',
            'a.part_name',
            'a.part_no2',
            'a.job_no',
            'a.model_id',
            'b.createdby'
        )
        ->distinct()
        ->get();


        return view('blank.taglabel', compact('title', 'tabel_stok_blanks'));
    }

    public function list()
    {
        $query = DB::table('tag_label_blanks as a')
                ->select('a.plan_date','a.line_id',DB::raw('CONCAT(a.plan_date, a.line_id)as mix_id'))
                ->groupBy('a.plan_date')
                ->groupBy('a.line_id')
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('tag_label_blanks as a')
                ->select('a.id','a.line_id','a.product_id','a.qty_act','a.part_name','a.job_no','a.part_no','a.model_id','a.qty_ng','a.kode_material','a.uniqNo','a.spec','a.sts_scan','a.part_no2')
                ->where('a.plan_date', $request->plan_date)
                ->where('a.line_id', $request->line_id)
                ->get();
        return DataTables::of($query)->make();
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Ambil data qty_blank dan spec dari tabel scan_in_blanks berdasarkan kode_material
            $scanBlank = DB::table('scan_in_blanks')
                ->where('uniqno', $request->kode_material)
                ->first();

            if (!$scanBlank) {
                return response()->json([
                    'success' => false,
                    'msg'     => 'Kode material tidak ditemukan.'
                ]);
            }

            // Hitung total qty yang akan dikurangi
            // $total_dikurangi = $request->qty_act + $request->qty_ng;

            // Simpan data baru ke dalam tag_label_blanks
            $plan                   = new TagLabelBlank;
            $plan->plan_date        = $request->plan_date;
            $plan->part_name        = $request->part_name;
            $plan->job_no           = $request->job_no;
            $plan->part_no          = $request->part_no;
            $plan->part_no2         = $request->part_no2;
            $plan->line_id          = $request->line_id;
            $plan->qty_act          = $request->qty_act;
            $plan->model_id         = $request->model_id;
            $plan->qty_ng           = $request->qty_ng;
            $plan->kode_material    = $request->kode_material;
            $plan->spec             = $scanBlank->spec;
            $plan->createdby        = auth()->user()->username;

            if (!$request->uniqNo) {
                $currentTimestamp = now();
                $uniqNo = 'B' . date('dis', strtotime($currentTimestamp));
                $plan->uniqNo = $uniqNo;
            } else {
                $plan->uniqNo = $request->uniqNo;
            }

            $query = $plan->save();

            // // Kurangi qty_blank dari tabel scan_in_blanks
            // DB::table('scan_in_blanks')
            //     ->where('uniqno', $request->kode_material)
            //     ->decrement('qty_blank', $total_dikurangi);

            // Update qty_kanban pada tabel tabel_stok_blanks
            DB::table('tabel_stok_blanks')
                ->where('part_no2', $request->part_no2)
                ->increment('qty_kanban', $request->qty_act);

            // Kurangi qty_actual pada tabel tabel_stok_blanks
            DB::table('tabel_stok_blanks')
                ->where('part_no2', $request->part_no2)
                ->decrement('qty_actual', $request->qty_act);

            // Update status, actual_production, dan time_endProses untuk mesin KOMATSU dan FUKUI
            // Tentukan shift sekarang berdasarkan jam saat ini
            $currentHour = now()->format('H:i:s');

            // Shift 1: 07:00 - 19:59, Shift 2: 20:00 - 07:29 (besok)
            $shiftNow = ($currentHour >= '07:00:00' && $currentHour < '20:00:00') ? 1 : 2;

            // Update status, actual_production, dan time_endProses untuk mesin KOMATSU dan FUKUI
            DB::table('planning_line_b3_s')
                ->where('part_no2', $request->part_no2)
                ->whereIn('mesin', ['KOMATSU', 'FUKUI'])
                ->where('shift', $shiftNow) // tambahkan filter shift sesuai waktu
                ->update([
                    'status'            => 3,
                    'status_proses'     => 3,
                    'actual_production' => $request->qty_act,
                    'time_endProses'    => now(), // waktu akhir proses
                ]);

            DB::commit();
            return response()->json([
                'success'   => true,
                'msg'       => 'Insert success and qty_blank updated, qty_actual in tabel_stok_blanks updated.'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success'   => false,
                'msg'       => 'Insert failed: ' . $e->getMessage()
            ]);
        }
    }









    public function edit(Request $request)
    {
        $cek = TagLabelBlank::where('id', $request->id)->count();
        if($cek > 0){
            $row = TagLabelBlank::where('id', $request->id)->first();
            return response()->json([
                'success'           => true,
                'id'                => $row->id,
                'product_id'        => $row->product_id,
                'qty_ng'            => $row->qty_ng,
                'qty_act'           => $row->qty_act,
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Data Not found.'
            ]);
        }
    }

    public function update(Request $request)
    {
        $data['product_id']      = $request->product_id;
        $data['qty_ng']        = $request->qty_ng;
        $data['qty_act']        = $request->qty_act;
        $data['updatedby']       = auth()->user()->id;
        $query = TagLabelBlank::where('id', $request->id)->update($data);
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Edit success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Edit failed.'
            ]);
        }
    }


    public function destroyline(Request $request)
{
    DB::beginTransaction();
    try {
        // Ambil data yang akan dihapus
        $tag = TagLabelBlank::find($request->id);

        if (!$tag) {
            return response()->json([
                'success' => false,
                'msg'     => 'Data not found.'
            ]);
        }

        // Kembalikan qty_act dan qty_ng ke scan_in_blanks berdasarkan kode_material
        $total_ditambahkan = $tag->qty_act + $tag->qty_ng;
        DB::table('scan_in_blanks')
            ->where('uniqNo', $tag->kode_material)
            ->increment('qty_blank', $total_ditambahkan);

        // ✅ Kurangi qty_actual di tabel_stok_blanks berdasarkan part_no
        DB::table('tabel_stok_blanks')
            ->where('part_no', $tag->part_no)
            ->decrement('qty_actual', $tag->qty_act);

        DB::table('tabel_stok_blanks')
            ->where('part_no', $tag->part_no)
            ->decrement('qty_kanban', $tag->qty_act);

        // Hapus data
        $tag->delete();

        DB::commit();
        return response()->json([
            'success' => true,
            'msg'     => 'Delete success, Quantity adjustment completed.'
        ]);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'success' => false,
            'msg'     => 'Delete failed: ' . $e->getMessage()
        ]);
    }
}



    public function destroy(Request $request)
    {
        $query = TagLabelBlank::where('plan_date', $request->plan_date)->where('line_id', $request->idline)->delete();
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Delete success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Delete failed.'
            ]);
        }
    }

    public function export()

    {
         return Excel::download(new ReportB3Export, 'report.xlsx');
    }

    public function getKodeMaterial(Request $request)
    {
        $partNo = $request->part_no;

        // Tentukan range waktu shift (07:00 hari ini - 07:30 besok)
        $start = now()->setTime(7, 0, 0);
        $end   = now()->addDay()->setTime(7, 30, 0);

        $kode_materials = DB::table('scan_in_blanks as sib')
            ->select('sib.id', 'sib.uniqno', 'sib.spec', 'sib.part_no', 'sib.qty_blank')
            ->where('sib.part_no', $partNo)
            // ->where('sib.qty_blank', '>', 0)   // ❌ dihapus biar 0 / minus tetap tampil
            ->whereExists(function ($query) use ($start, $end) {
                $query->select(DB::raw(1))
                    ->from('planning_line_b3_s as pl')
                    ->where('pl.mesin_category', 2)
                    ->whereBetween('pl.created_at', [$start, $end]);
            })
            ->get();

        return response()->json($kode_materials);
    }




public function getQtyBlank(Request $request)
{
    $uniqno = $request->uniqno;

    $data = DB::table('scan_in_blanks')
                ->where('uniqno', $uniqno)
                ->select('qty_blank')
                ->first();

    if ($data) {

        return response()->json([
            'success' => true,
            'qty_blank' => $data->qty_blank
        ]);
    } else {
        return response()->json([
            'success' => false,
            'msg' => 'Data Tidak Ditemukan'
        ]);
    }

}


public function cetak($id)
    {
        // Find the master record by ID
        $tag_label_blanks = TagLabelBlank::findOrFail($id);

        // $uniqNo = date('dm') . $tag_label_blanks->urutan . date('s', strtotime($tag_label_blanks->updated_at));

        $data_to_encode = $tag_label_blanks->part_no .'||'. $tag_label_blanks->spec . '||'. $tag_label_blanks->line_id . '||'.$tag_label_blanks->uniqNo .'||'. $tag_label_blanks->part_no2 .'||'. $tag_label_blanks->id .'||'. $tag_label_blanks->kode_material. '||'. $tag_label_blanks->qty_act ;

        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data_to_encode));

        $data = [
            'qrcode'            => $qrcode,
            // 'uniqNo'         => $uniqNo,
            'uniqNo'            => $tag_label_blanks->uniqNo,
            'part_no'           => $tag_label_blanks->part_no,
            'part_no2'           => $tag_label_blanks->part_no2,
            'line_id'           => $tag_label_blanks->line_id,
            'part_name'         => $tag_label_blanks->part_name,
            'createdby'         => $tag_label_blanks->createdby,
            'qty_act'           => $tag_label_blanks->qty_act,
            'job_no'            => $tag_label_blanks->job_no,  // Format dynamically without rounding
            'model_id'             => $tag_label_blanks->model_id,
            'kode_material'     => $tag_label_blanks->kode_material,
            // 'kg_sheet'       => $tag_label_blanks->kg_sheet,
            'created_at'        => $tag_label_blanks->created_at,
            // 'supplier'       => $tag_label_blanks->supplier,
            // 'actual'         => $tag_label_blanks->actual,
            'spec'              => $tag_label_blanks->spec,
            'no_rak'            => $tag_label_blanks->no_rak,
            // 'uniq_no'        => $tag_label_blanks->uniq_no,
        ];

        // Define custom paper size (100mm x 150mm in points)
        $customPaper = array(0, 0, 283.465, 425.1975);

        // Load PDF view with data and set custom paper size
        $pdf = PDF::loadView('blank.label', $data)
                  ->setPaper($customPaper, 'portrait');  // 'portrait' for normal orientation

        // Stream the generated PDF with a filename that includes the date and unique ID
        return $pdf->stream(date('d_M_Y') . '_' . $tag_label_blanks->id . '_qrcode.pdf');
    }

public function getPartNos()
{
    $parts = ScanInBlank::select('part_no')->distinct()->get();
    return response()->json($parts);
}

public function getMaterialCodes(Request $request)
{
    $partNo = $request->input('part_no');

    $data = DB::table('scan_in_blanks')
        ->where('part_no', $partNo)
        ->where('qty_blank', '!=', 0)
        ->select('uniqNo', 'part_no', 'qty_blank')

        ->get();

    return response()->json($data);
}

public function updateQtyBlank(Request $request)
{
    $request->validate([
        'uniq_no' => 'required|string',
        'qty_blank' => 'required|numeric',
    ]);

    DB::table('scan_in_blanks')
        ->where('uniqNo', $request->uniq_no)
        ->update(['qty_blank' => $request->qty_blank]);

    return response()->json(['message' => 'qty_blank berhasil diupdate']);
}





}
