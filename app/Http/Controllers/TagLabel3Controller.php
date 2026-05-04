<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use  App\Models\DataFgStamping;
use App\Models\RmInMaterial;
use App\Models\RmStok;
use App\Models\User;
use App\Models\TabelStokBlank;
use App\Models\TagLabel3;
use App\Imports\RmStokImport; // Pastikan namespace ini benar
use DataTables;
use DB;


class TagLabel3Controller extends Controller
{

    public function index()
    {
        $title = 'TAG LABEL BLANK';
        $data_fg_stampings = DataFgStamping::all();
        // $rm_materials = DB::table('rm_materials as a')
        //                 ->select('a.id as id','a.name_material','a.spek')
        //                 // ->join('data_fg_stampings as b', 'b.id', '=', 'a.model', 'left')
        //                 ->get();

        return view('blank.TagLabel3', compact('title'));
    }

    // public function list() {
    //     $data = DB::table('data_blanks as a')
    //             ->select('a.id','a.part_no','a.part_no2','a.part_name','a.model_id','a.spek')
    //             ->get();

    //     return DataTables::of($data)->make();
    // }

    // public function list()
    // {
    //     $query = DB::table('data_blanks as a')
    //         ->select('a.id','a.part_name','a.part_no', 'a.model_id','a.spek','a.spek_t','a.spek_w','a.spek_l')
    //         ->groupBy('a.id','a.part_name','a.part_no', 'a.model_id','a.spek','a.spek_t','a.spek_w','a.spek_l');

    //     return DataTables::of($query)->make(true);
    // }

    public function list()
    {
        $query = DB::table('tabel_stok_blanks as a')
            ->select(
                'a.id',
                'a.part_name',
                'a.part_no',
                'a.part_no2',
                'a.job_no',
                'a.model_id',
                'a.spek',
                'a.spek_t',
                'a.spek_w',
                'a.spek_l',
                'a.spek_kg',
                'a.spek_bq',
                'a.home_line',


            );

            return DataTables::of($query)
            ->addColumn('part_count', function ($row) {
                $count1 = DB::table('tag_label3s')
                    ->where('part_no', $row->part_no) // ganti pakai part_no
                    // ->where('category', 1)
                    ->count();

                // $count2 = DB::table('tag_label3s')
                //     ->where('part_no', $row->part_no) // ganti pakai part_no
                //     ->where('category', 2)
                //     ->count();

                return [
                    'count1' => $count1,
                    // 'count2' => $count2
                ];
            })
            ->make(true);


    }


    public function listdetail(Request $request)
    {
        $partNo2 = $request->part_no2;

        $query = DB::table('tag_label3s as a')
            ->select('a.id', 'a.part_no','a.part_no2','a.part_name', 'a.model_id','a.job_no','a.spek','a.spek_w','a.actual_sheet','a.tanggal','a.category','a.doc_po','a.actual_kg','a.sts')
            ->where('a.part_no2', $partNo2);

        return DataTables::of($query)->make(true);
    }


    // TagLabel3Controller.php

    public function getByPart(Request $request)
    {
        $part_no2 = $request->part_no2;

        $data = DB::table('tabel_stok_blanks')->where('part_no2', $part_no2)->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'id' => $data->id,
                'part_name' => $data->part_name,
                'part_no' => $data->part_no,
                'part_no2' => $data->part_no2,
                'model_id' => $data->model_id,
                'job_no' => $data->job_no,
                'spek' => $data->spek,
                'spek_t' => $data->spek_t,
                'spek_w' => $data->spek_w,
                'spek_l' => $data->spek_l,
                'spek_kg' => $data->spek_kg,

                // 'model_id' => $data->model_id,
            ]);

        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Data tidak ditemukan.'
            ]);
        }
    }


    public function store(Request $request)
{
    DB::beginTransaction();
    try {
        $label                  = new TagLabel3;
        $label->part_no         = $request->part_no;
        $label->part_no2        = $request->part_no2;
        $label->model_id        = $request->model_id;
        $label->job_no          = $request->job_no;
        $label->part_name       = $request->part_name;
        $label->spek            = $request->spek;
        $label->spek_t          = $request->spek_t;
        $label->spek_w          = $request->spek_w;
        $label->spek_l          = $request->spek_l;
        $label->actual_sheet    = $request->actual_sheet;
        $label->supplier        = $request->supplier;
        $label->category        = $request->category;
        $label->doc_po          = $request->doc_po;

        if (!$request->doc_po) {
            $time = now();
            $count = TagLabel3::where('part_no', $request->part_no)
                        ->where('category', $request->category)
                        ->count() + 1;

            if ($request->category == 1) {
                $prefix = 'LABEL/BLANK/KOMATSU';
            } elseif ($request->category == 2) {
                $prefix = 'LABEL/BLANK/FUKUI';
            } elseif ($request->category == 3) {
                $prefix = 'LABEL/BLANK/AMINO';
            } else {
                $prefix = 'PO/OPSIONAL/UNKNOWN';
            }

            $label->doc_po = $prefix . '/' . $time->format('md') . '/' . $time->format('s') . '/' . $count;
        } else {
            $label->doc_po = $request->doc_po;
        }

        $spek_kg        = floatval($request->spek_kg);
        $actual_sheet   = floatval($request->actual_sheet);
        $label->actual_kg = round($actual_sheet * $spek_kg, 3);

        if (!$request->uniqNo) {
            $now   = now();
            $year  = $now->format('y');   // 2 digit tahun
            $month = $now->format('n');   // 1 digit bulan tanpa leading zero
            $sec   = $now->format('s');   // detik (ambil 1 digit terakhir)
            $sec   = substr($sec, -1);

            // hitung urutan uniq untuk hari ini atau bisa per part_no (pilih sesuai kebutuhanmu)
            $count = TagLabel3::whereDate('created_at', $now->toDateString())->count() + 1;

            $uniqNo = "BP{$year}{$month}{$sec}{$count}";
            $label->uniqNo = $uniqNo;
        } else {
            $label->uniqNo = $request->uniqNo;
        }


        $label->createdby = auth()->user()->username;
        $label->tanggal = now();

        $query = $label->save();

        if ($query) {
            // ✅ Update stok di tabel_stok_blanks
            DB::table('tabel_stok_blanks')
                ->where('part_no2', $request->part_no2)
                ->increment('qty_kanban', $actual_sheet);

            DB::table('tabel_stok_blanks')
                ->where('part_no2', $request->part_no)
                ->decrement('qty_actual', $actual_sheet);

            // ✅ Update status di planning_line_b3_s (KOMATSU & FUKUI)
            // DB::table('planning_line_b3_s')
            //     ->where('part_no', $request->part_no)
            //     ->whereIn('mesin', ['KOMATSU', 'FUKUI'])
            //     ->update([
            //         'status'            => 3,
            //         'status_proses'     => 3,
            //         'actual_production' => $request->qty_act, // ambil dari input
            //         'time_endProses'    => now(),
            //     ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'msg'     => 'Insert success, stok & planning updated.'
            ]);
        } else {
            DB::rollback();
            return response()->json([
                'success' => false,
                'msg'     => 'Insert failed.'
            ]);
        }
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'success' => false,
            'msg'     => 'Insert failed: ' . $e->getMessage()
        ]);
    }
}



    public function edit(Request $request)
    {
        $cek = TagLabel3::where('id', $request->id)->count();
        if($cek > 0){
            $row = TagLabel3::where('id', $request->id)->first();
            return response()->json([
                'success'           => true,
                'id'                => $row->id,
                'part_name'         => $row->part_name,
                'part_no'           => $row->part_no,
                'job_no'            => $row->job_no,
                'model_id'          => $row->model_id,
                'spek'              => $row->spek,
                'minimal'           => $row->minimal,
                'actual_kg'         => $row->actual_kg,
                'actual_sheet'      => $row->actual_sheet,
                'no_rak'            => $row->no_rak,
                'bq_id'             => $row->bq_id,
                'keterangan'        => $row->keterangan,
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Data Not found.'
            ]);
        }
    }

    public function generateMultipleQrCodes(Request $request)
    {
        // Validasi data input
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:tag_label3s,id',
        ]);

        $data_to_print = [];

        foreach ($request->ids as $id) {
            $tag_label3s = TagLabel3::findOrFail($id);

            // Data yang akan diencode di QR
            // $data_to_encode = $tag_label3s->part_no . '||' . $tag_label3s->spek . '||' . $tag_label3s->supplier . '||' . $tag_label3s->uniqNo . '||' . $tag_label3s->part_no2 . '||' . $tag_label3s->actual_sheet . '||' . $tag_label3s->uniqNo .'||'. $tag_label3s->id;

                    $data_to_encode = $tag_label3s->part_no .'||'. $tag_label3s->spec . '||'. $tag_label3s->line_id . '||'.$tag_label3s->uniqNo .'||'. $tag_label3s->part_no2 .'||'. $tag_label3s->id .'||'. $tag_label3s->kode_material. '||'. $tag_label3s->qty_act ;
            $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data_to_encode));

            $data_to_print[] = [
                'qrcode'       => $qrcode,
                'part_no'      => $tag_label3s->part_no,
                'part_no2'      => $tag_label3s->part_no2,
                'kode_material'=> $tag_label3s->kode_material ?? '-', // default kalau null
                'createdby'    => $tag_label3s->createdby,
                'created_at'   => $tag_label3s->created_at?->format('d-m-Y H:i') ?? $tag_label3s->tanggal,
                'line_id'      => $tag_label3s->line_id ?? '-',
                'part_name'    => $tag_label3s->part_name ?? '-',
                'uniqNo'       => $tag_label3s->uniqNo,
                'job_no'       => $tag_label3s->job_no,
                'part_no2'     => $tag_label3s->part_no2,
                'model_id'     => $tag_label3s->model_id,
                'spek'         => $tag_label3s->spek,
                'actual_sheet'      => $tag_label3s->actual_sheet,
                'supplier'      => $tag_label3s->supplier,
            ];
        }

        // Define custom paper size
        $customPaper = [0, 0, 283.465, 425.1975]; // 100mm x 150mm

        // Generate PDF
        $pdf = PDF::loadView('blank.label2', ['data' => $data_to_print])
                  ->setPaper($customPaper, 'portrait');

        return $pdf->stream('LabelSharingOpsional' . date('d_M_Y') . '.pdf', [
            'Content-Disposition' => 'inline; filename="LabelSharingOpsional_' . date('d_M_Y') . '.pdf"',
        ]);
    }



public function destroyline(Request $request)
{
    $query = TagLabel3::where('id', $request->id)->delete();
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
}
