<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use App\Models\DataFgStamping;
use App\Models\RmInMaterial;
use App\Models\RmStok;
use App\Models\User;
use App\Models\TagLabel2;
use App\Imports\RmStokImport; // Pastikan namespace ini benar
use Yajra\DataTables\Facades\DataTables;
use DB;


class TagLabel2Controller extends Controller
{

    public function index()
    {
        $title = 'TAG LABEL MATERIAL';
        $data_fg_stampings = DataFgStamping::all();
        // $rm_materials = DB::table('rm_materials as a')
        //                 ->select('a.id as id','a.name_material','a.spek')
        //                 // ->join('data_fg_stampings as b', 'b.id', '=', 'a.model', 'left')
        //                 ->get();

        return view('blank.taglabel2', compact('title'));
    }

    // public function list() {
    //     $data = DB::table('rm_stoks as a')
    //             ->select('a.id','a.part_no','a.part_no2','a.part_name','a.model_id','a.spek')
    //             ->get();

    //     return DataTables::of($data)->make();
    // }

    // public function list()
    // {
    //     $query = DB::table('rm_stoks as a')
    //         ->select('a.id','a.part_name','a.part_no', 'a.model_id','a.spek','a.spek_t','a.spek_w','a.spek_l')
    //         ->groupBy('a.id','a.part_name','a.part_no', 'a.model_id','a.spek','a.spek_t','a.spek_w','a.spek_l');

    //     return DataTables::of($query)->make(true);
    // }

    public function list()
    {
        $query = DB::table('rm_stoks as a')
            ->select(
                'a.id',
                'a.part_name',
                'a.part_no',
                'a.part_no2',
                'a.job_no',
                'a.model_id',
                'a.category_id',
                'a.spek',
                'a.spek_t',
                'a.spek_w',
                'a.spek_l',
                'a.spek_kg',
                'a.spek_bq',
                'a.minimal',
                'a.actual_sheet',
                'a.actual_kg',
                'a.no_rak',
                'a.bq_id',
                'a.keterangan',


            );

        return DataTables::of($query)
            ->addColumn('part_count', function ($row) {
                $count1 = DB::table('tag_label2s')
                    ->where('part_no', $row->part_no)
                    ->where('category', 1)
                    ->count();

                $count2 = DB::table('tag_label2s')
                    ->where('part_no', $row->part_no)
                    ->where('category', 2)
                    ->count();

                return [
                    'count1' => $count1,
                    'count2' => $count2
                ];
            })
            ->with([
                'rundoutTotal' => DB::table('rm_stoks')->where('keterangan', 2)->count(),
            ])
            ->make(true);

    }


    public function listdetail(Request $request)
    {
        $partNo = $request->part_no;

        $query = DB::table('tag_label2s as a')
            ->select('a.id', 'a.part_no', 'a.part_name', 'a.model_id', 'a.job_no', 'a.spek', 'a.spek_w', 'a.actual_sheet', 'a.tanggal', 'a.category', 'a.doc_po', 'a.actual_kg', 'a.sts')
            ->where('a.part_no', $partNo);

        return DataTables::of($query)->make(true);
    }


    // TagLabel2Controller.php

    public function getByPart(Request $request)
    {
        $part_no = $request->part_no;

        $data = DB::table('rm_stoks')->where('part_no', $part_no)->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'id' => $data->id,
                'part_name' => $data->part_name,
                'part_no' => $data->part_no,
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
        $label = new TagLabel2;
        $label->part_no = $request->part_no;
        $label->model_id = $request->model_id;
        $label->job_no = $request->job_no;
        $label->part_name = $request->part_name;
        $label->spek = $request->spek;
        $label->spek_t = $request->spek_t;
        $label->spek_w = $request->spek_w;
        $label->spek_l = $request->spek_l;
        $label->actual_sheet = $request->actual_sheet;
        $label->supplier = $request->supplier;
        $label->category = $request->category;
        $label->doc_po = $request->doc_po;
        if (!$request->doc_po) {
            $time = now();

            // Hitung jumlah entri sebelumnya berdasarkan part_no dan category
            $count = TagLabel2::where('part_no', $request->part_no)
                ->where('category', $request->category)
                ->count() + 1;

            // Tentukan prefix berdasarkan category
            if ($request->category == 1) {
                $prefix = 'PO/OPSIONAL/RM';
            } elseif ($request->category == 2) {
                $prefix = 'PO/OPSIONAL/BLANK';
            } else {
                $prefix = 'PO/OPSIONAL/UNKNOWN'; // fallback jika category tidak 1 atau 2
            }

            // Format akhir: PREFIX/mmdd/ss/count
            $label->doc_po = $prefix . '/' . $time->format('md') . '/' . $time->format('s') . '/' . $count;
        } else {
            $label->doc_po = $request->doc_po;
        }

        $spek_kg = floatval($request->spek_kg); // Sudah bertitik, aman
        $actual_sheet = floatval($request->actual_sheet);

        $label->actual_kg = round($actual_sheet * $spek_kg, 3); // ambil 1 angka desimal

        if (!$request->uniqNo) {
            $currentTimestamp = now();
            $uniqNo = 'L' . date('ydis', strtotime($currentTimestamp)); // Format: ddmmyyHHmmss
            $label->uniqNo = $uniqNo;
        } else {
            $label->uniqNo = $request->uniqNo;
        }

        $label->createdby = auth()->user()->username;
        $label->tanggal = now();
        $query = $label->save();
        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Insert success.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Insert failed.'
            ]);
        }
    }


    public function edit(Request $request)
    {
        $cek = RmStok::where('id', $request->id)->count();
        if ($cek > 0) {
            $row = RmStok::where('id', $request->id)->first();
            return response()->json([
                'success' => true,
                'id' => $row->id,
                'part_name' => $row->part_name,
                'part_no' => $row->part_no,
                'job_no' => $row->job_no,
                'model_id' => $row->model_id,
                'spek' => $row->spek,
                'minimal' => $row->minimal,
                'actual_kg' => $row->actual_kg,
                'actual_sheet' => $row->actual_sheet,
                'no_rak' => $row->no_rak,
                'bq_id' => $row->bq_id,
                'keterangan' => $row->keterangan,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Data Not found.'
            ]);
        }
    }

    public function generateMultipleQrCodes(Request $request)
    {
        // Validasi data input
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:tag_label2s,id',
        ]);


        $data_to_print = [];

        foreach ($request->ids as $id) {

            $tag_label2s = TagLabel2::findOrFail($id);

            // $uniqNo = date('dm') . $tag_label2s->urutan . date('s', strtotime($tag_label2s->updated_at));

            // $data_to_encode = $tag_label2s->part_no . '.' . $tag_label2s->spek. '.' .$tag_label2s->actual_sheet;

            $data_to_encode = $tag_label2s->part_no . '||' . $tag_label2s->spek . '||' . $tag_label2s->supplier . '||' . $tag_label2s->uniqNo . '||' . $tag_label2s->id . '||' . $tag_label2s->doc_po . '||' . $tag_label2s->actual_kg . '||' . $tag_label2s->actual_sheet . '||' . $tag_label2s->category;

            // $data_to_encode = $dn_inputs->part_no . '||' . $dn_inputs->spec . '||' . $dn_inputs->supplier . '||' . $dn_inputs->uniq_no . '||' . $dn_inputs->detail_id . '||' . $dn_inputs->id . '||' . $dn_inputs->kg_sheet . '||' . $dn_inputs->actual;

            $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data_to_encode));

            $data_to_print[] = [
                'qrcode' => $qrcode,
                'no_dn' => $tag_label2s->no_dn,
                'part_no2' => $tag_label2s->part_no,
                'part_name' => $tag_label2s->part_name,
                'part_no' => $tag_label2s->part_no,
                'job_no' => $tag_label2s->job_no,
                'supplier' => $tag_label2s->supplier,
                'actual_sheet' => $tag_label2s->actual_sheet,
                'spek' => $tag_label2s->spek,
                'spek_t' => $tag_label2s->spek_t,
                'spek_w' => $tag_label2s->spek_w,
                'spek_l' => $tag_label2s->spek_l,
                'createdby' => $tag_label2s->createdby,
                'tanggal' => $tag_label2s->tanggal,
                'model_id' => $tag_label2s->model_id,
                'uniqNo' => $tag_label2s->uniqNo,
                'supplier' => $tag_label2s->supplier,
                'actual_kg' => $tag_label2s->actual_kg,
                'category' => $tag_label2s->category,
                'doc_po' => $tag_label2s->doc_po,
                'created_at' => $tag_label2s->created_at,
                // // Tambahan: teks label berdasarkan kategori
                // 'category_label'  => $tag_label2s->category == 1
                //                       ? 'PO/OPSIONAL/RM/2025'
                //                       : ($tag_label2s->category == 2
                //                           ? 'PO/OPSIONAL/BLANK/2025'
                //                           : ''),
            ];

        }

        // Define custom paper size
        $customPaper = [0, 0, 283.465, 425.1975]; // 100mm x 150mm
        // Generate PDF
        $pdf = Pdf::loadView('blank.labelrm', ['data' => $data_to_print])
            ->setPaper($customPaper, 'portrait');

        return $pdf->stream('labelOpsional_' . date('d_M_Y') . '.pdf', [
            'Content-Disposition' => 'inline; filename="labelOpsional_' . date('d_M_Y') . '.pdf"',
        ]);

    }


    public function destroyline(Request $request)
    {
        $query = TagLabel2::where('id', $request->id)->delete();
        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Delete success.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Delete failed.'
            ]);
        }
    }
}
