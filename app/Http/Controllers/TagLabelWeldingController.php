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
use App\Models\DataWelding;
use App\Models\User;
use App\Models\TagLabelWelding;
use App\Imports\DataWeldingImport; // Pastikan namespace ini benar
use DataTables;
use DB;


class TagLabelWeldingController extends Controller
{

    public function index()
    {
        $title = 'TAG LABEL WELDING';


        return view('welding.taglabel', compact('title'));
    }

    public function list()
    {
        $query = DB::table('data_weldings as a')
            ->select(
                'a.id',
                'a.part_name',
                'a.part_no',
                'a.part_no2',
                'a.job_no',
                'a.model',
                'a.customer'

                // 'a.keterangan',
            );

            return DataTables::of($query)
            ->addColumn('part_count', function ($row) {
                $count = DB::table('tag_label_weldings')
                    ->where('job_no', $row->job_no)
                    ->count();

                return $count;
            })
            ->make(true);


    }

     public function listdetail(Request $request)
    {
        $jobNo = $request->job_no;

        $query = DB::table('tag_label_weldings as a')
            ->select('a.id', 'a.part_no', 'a.part_no2', 'a.part_name', 'a.model', 'a.job_no', 'a.sts', 'a.qty_act', 'a.tanggal')
            ->where('a.job_no', $jobNo)
            ->where(function ($q) {
                $q->whereNull('a.sts')    // tampilkan yang belum diisi
                  ->orWhere('a.sts', '!=', 1); // tampilkan jika sts bukan 1
            })
            ->orderByRaw('CASE WHEN a.sts IS NULL THEN 0 ELSE 1 END')
            ->orderBy('a.id', 'desc');

        return DataTables::of($query)->make(true);
    }

    // public function listdetail(Request $request)
    // {
    //     $jobNo = $request->job_no;

    //     $query = DB::table('tag_label_weldings as a')
    //     ->select('a.id', 'a.part_no', 'a.part_no2', 'a.part_name', 'a.model', 'a.job_no', 'a.sts', 'a.qty_act','tanggal')
    //         ->where('a.job_no', $jobNo)
    //         ->orderByRaw('CASE WHEN a.sts IS NULL THEN 0 ELSE 1 END')
    //         ->orderBy('a.id', 'desc');

    //     return DataTables::of($query)->make(true);
    // }


    // TagLabelWeldingController.php

    public function getByPart(Request $request)
    {
        $job_no = $request->job_no;

        $data = DB::table('data_weldings')->where('job_no', $job_no)->first();

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
    $label                  = new TagLabelWelding;
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
    $last3JobNo = substr($jobNo, -3); // ambil 3 angka terakhir job_no

    $bulan = now()->format('m');      // MM
    $tahun = now()->format('y');      // YY

    // Ambil count terakhir untuk bulan ini
    $currentMonth = now()->format('Y-m');
    $lastCount = TagLabelWelding::where('tanggal', 'like', $currentMonth . '%')
                ->max('count');
    $count = $lastCount ? $lastCount + 1 : 1;

    $uniqNo = 'W' . $last3JobNo . $bulan . $tahun . str_pad($count, 2, '0', STR_PAD_LEFT);
    $label->uniqNo = $uniqNo;
} else {
    $label->uniqNo = $request->uniqNo;
}


    // Set createdby dan tanggal
    $label->createdby = auth()->user()->username;
    $label->tanggal   = now();

    // ---- LOGIKA COUNT ----
    $currentMonth = now()->format('Y-m'); // misal 2025-08
    // Ambil count terakhir untuk bulan ini
    $lastCount = TagLabelWelding::where('tanggal', 'like', $currentMonth . '%')
                ->max('count');

    $label->count = $lastCount ? $lastCount + 1 : 1;
    // ----------------------

    $query = $label->save();

    if ($query) {
        return response()->json([
            'success' => true,
            'msg'     => 'Insert success.',
            'count'   => $label->count // optional, return count
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
        $cek = DataWelding::where('id', $request->id)->count();
        if($cek > 0){
            $row = DataWelding::where('id', $request->id)->first();
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
            'ids.*' => 'exists:tag_label_weldings,id',
        ]);

        $data_to_print = [];

        foreach ($request->ids as $id) {
            $tag_label_weldings = TagLabelWelding::findOrFail($id);

            $data_to_encode = $tag_label_weldings->part_no2 . '.' .
                              $tag_label_weldings->job_no . '.' .
                              $tag_label_weldings->qty_act . '.' .
                              $tag_label_weldings->count . '.' .
                              $tag_label_weldings->uniqNo;

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
                'no_dn'     => $tag_label_weldings->no_dn,
                'part_no'   => $tag_label_weldings->part_no,
                'qty_act'   => $tag_label_weldings->qty_act,
                'createdby' => $tag_label_weldings->createdby,
                'tanggal'   => $tag_label_weldings->tanggal,
                'model'     => $tag_label_weldings->model,
                'uniqNo'    => $tag_label_weldings->uniqNo,
                'line'      => $tag_label_weldings->line,
                'job_no'    => $tag_label_weldings->job_no,
                'category'  => $tag_label_weldings->category,
                'part_name' => $tag_label_weldings->part_name,
            ];
        }

        // Define custom paper size (80mm x 150mm)
        $customPaper = array(0,0,227,425); // 80mm x 150mm dalam pt

        $pdf = PDF::loadView('welding.label', ['data' => $data_to_print])
                ->setPaper($customPaper, 'portrait')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'defaultFont' => 'Arial',
                ]);

        return $pdf->stream('LabelWelding_' . date('d_M_Y') . '.pdf');
    }



public function destroyline(Request $request)
{
    $query = TagLabelWelding::where('id', $request->id)->delete();
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
