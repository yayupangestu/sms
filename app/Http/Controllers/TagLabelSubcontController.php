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
use App\Models\TabelStokSbc;
use App\Models\User;
use App\Models\TagLabelSubcont;
use App\Imports\TabelStokSbcImport; // Pastikan namespace ini benar
use DataTables;
use DB;


class TagLabelSubcontController extends Controller
{

    public function index()
    {
        $title = 'TAG LABEL SUBCONT';


        return view('linestore.taglabelsubcont', compact('title'));
    }

    public function list()
    {
        $query = DB::table('tabel_stok_sbcs as a')
            ->select(
                'a.id',
                'a.part_name',
                'a.part_no',
                'a.part_no2',
                'a.job_no',
                'a.model',
                'a.supplier'

                // 'a.keterangan',
            );

            return DataTables::of($query)
            ->addColumn('part_count', function ($row) {
                $count = DB::table('tag_label_subconts')
                    ->where('job_no', $row->job_no)
                    ->count();

                return $count;
            })
            ->make(true);


    }


    public function listdetail(Request $request)
{
    $jobNo = $request->job_no;

    $query = DB::table('tag_label_subconts as a')
        ->select(
            'a.id',
            'a.part_no',
            'a.part_no2',
            'a.part_name',
            'a.model',
            'a.job_no',
            'a.sts',
            'a.qty_act',
            'a.tanggal'
        )
        ->where('a.job_no', $jobNo)
        ->orderByRaw('CASE WHEN a.sts IS NULL THEN 0 ELSE 1 END') // Prioritaskan null dulu
        ->orderBy('a.id', 'desc'); // lalu urutkan id desc

    return DataTables::of($query)->make(true);
}



    // TagLabelSubcontController.php

    public function getByPart(Request $request)
    {
        $job_no = $request->job_no;

        $data = DB::table('tabel_stok_sbcs')->where('job_no', $job_no)->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'id' => $data->id,
                'part_name' => $data->part_name,
                'part_no' => $data->part_no,
                'part_no2' => $data->part_no2,
                'model' => $data->model,
                'job_no' => $data->job_no,
                'qty_kanban' => $data->qty_kanban, // <--- pastikan kolom ini ada di DB
            ]);
        }
         else {
            return response()->json([
                'success' => false,
                'msg' => 'Data tidak ditemukan.'
            ]);
        }
    }


    public function store(Request $request)
    {
        $label                  = new TagLabelSubcont;
        $label->part_no         = $request->part_no;
        $label->part_no2        = $request->part_no2;
        $label->model           = $request->model;
        $label->job_no          = $request->job_no;
        $label->line            = $request->line;
        $label->part_name       = $request->part_name;
        $label->qty_act         = $request->qty_act;

        // Generate uniqNo jika kosong
        if (!$request->uniqNo) {
            $jobNo = $request->job_no;
            $last3JobNo = substr($jobNo, -3);

            $bulan = now()->format('m');
            $tahun = now()->format('y');

            $currentMonth = now()->format('Y-m');
            $lastCount = TagLabelSubcont::where('tanggal', 'like', $currentMonth . '%')
                        ->max('count');
            $count = $lastCount ? $lastCount + 1 : 1;

            $uniqNo = 'L' . $last3JobNo . $bulan . $tahun . str_pad($count, 2, '0', STR_PAD_LEFT);
            $label->uniqNo = $uniqNo;
        } else {
            $label->uniqNo = $request->uniqNo;
        }

        $label->createdby = auth()->user()->username;
        $label->tanggal   = now();

        // ---- LOGIKA COUNT ----
        $currentMonth = now()->format('Y-m');
        $lastCount = TagLabelSubcont::where('tanggal', 'like', $currentMonth . '%')
                    ->max('count');

        $label->count = $lastCount ? $lastCount + 1 : 1;
        // ----------------------

        $query = $label->save();

        if ($query) {
            // update ke tabel_stok_sbcs sesuai job_no
            \DB::table('tabel_stok_sbcs')
                ->where('job_no', $request->job_no)
                ->update([
                    'qty_act_ls' => \DB::raw("COALESCE(qty_act_ls,0) + {$request->qty_act}")
                ]);

            return response()->json([
                'success' => true,
                'msg'     => 'Insert success & stok updated.',
                'count'   => $label->count
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg'     => 'Insert failed.'
            ]);
        }
    }


    public function edit(Request $request)
    {
        $cek = TabelStokSbc::where('id', $request->id)->count();
        if($cek > 0){
            $row = TabelStokSbc::where('id', $request->id)->first();
            return response()->json([
                'success'           => true,
                'id'                => $row->id,
                'part_name'         => $row->part_name,
                'part_no'           => $row->part_no,
                'job_no'            => $row->job_no,
                'model'          => $row->model,
                'spek'              => $row->spek,
                'minimal'           => $row->minimal,
                'actual_kg'         => $row->actual_kg,
                'qty_act'      => $row->qty_act,
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
            'ids.*' => 'exists:tag_label_subconts,id',
        ]);

        $data_to_print = [];

        foreach ($request->ids as $id) {
            $tag_label_subconts = TagLabelSubcont::findOrFail($id);

            $data_to_encode = $tag_label_subconts->part_no2 . '.' .
                              $tag_label_subconts->job_no . '.' .
                              $tag_label_subconts->qty_act . '.' .
                              $tag_label_subconts->count . '.' .
                              $tag_label_subconts->uniqNo;

            $qrcode = base64_encode(
                QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data_to_encode)
            );

            // load image OK.png -> convert ke base64
            $okPath = public_path('dist/img/ok.png');
            $inspectorPath = public_path('dist/img/inspector2.png');
            $okImage = 'data:image/png;base64,' . base64_encode(file_get_contents($okPath));
            $extraImage = 'data:image/png;base64,' . base64_encode(file_get_contents($inspectorPath));

            $data_to_print[] = [
                'qrcode'    => $qrcode,
                'okImage'   => $okImage, // tambahkan ini
                'extraImage'   => $extraImage, // tambahkan ini
                'no_dn'     => $tag_label_subconts->no_dn,
                'part_no'   => $tag_label_subconts->part_no,
                'qty_act'   => $tag_label_subconts->qty_act,
                'createdby' => $tag_label_subconts->createdby,
                'tanggal'   => $tag_label_subconts->tanggal,
                'model'     => $tag_label_subconts->model,
                'uniqNo'    => $tag_label_subconts->uniqNo,
                'line'      => $tag_label_subconts->line,
                'job_no'    => $tag_label_subconts->job_no,
                'category'  => $tag_label_subconts->category,
                'part_name' => $tag_label_subconts->part_name,
            ];
        }

        // Define custom paper size (80mm x 150mm)
        $customPaper = array(0,0,227,425); // 80mm x 150mm dalam pt

        $pdf = PDF::loadView('linestore.labelsubcont', ['data' => $data_to_print])
                ->setPaper($customPaper, 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'Arial',
                ]);
//  labelsubcont.blade
        return $pdf->stream('LabelSubcont_' . date('d_M_Y') . '.pdf');
    }



    public function destroyline(Request $request)
    {
        // Ambil data sebelum dihapus
        $label = TagLabelSubcont::find($request->id);

        if (!$label) {
            return response()->json([
                'success' => false,
                'msg'     => 'Data not found.'
            ]);
        }

        $jobNo   = $label->job_no;
        $qtyAct  = $label->qty_act;

        // Hapus data
        $query = $label->delete();

        if ($query) {
            // Kurangkan qty_act_ls di tabel_stok_sbcs sesuai job_no
            \DB::table('tabel_stok_sbcs')
                ->where('job_no', $jobNo)
                ->decrement('qty_act_ls', $qtyAct);

            return response()->json([
                'success' => true,
                'msg'     => 'Delete success & stok updated.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg'     => 'Delete failed.'
            ]);
        }
    }

}
