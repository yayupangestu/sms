<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\UploadRekapOrderAdm;
use App\Models\RmMaterial;
use App\Models\RmMonthly;
use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\RmDnIncomingImport; // Pastikan namespace ini benar
use App\Exports\PoExport;
use DataTables;
use DB;
use Illuminate\Support\Facades\Log;
use App\Imports\UploadRekapImport; // Pastikan namespace ini benar



class Listrekapd26AdmController extends Controller
{
    public function index () {
        $title = 'List Rekap';
        return view('ppic.prepared26adm', compact('title'));
    }

    public function list()
    {
        $query = DB::table('upload_rekap_order_adms as a')
            ->select(
                'a.created_at',
                DB::raw('COUNT(*) as total_data'),
                DB::raw('SUM(CASE WHEN qty_order = 0 THEN 1 ELSE 0 END) as total_qty2'),
                DB::raw('SUM(CASE WHEN qty_order > 0 THEN 1 ELSE 0 END) as total_qty_gt0')
            )
            ->groupBy('a.created_at')
            ->orderBy('a.created_at', 'desc');
    
        return DataTables::of($query)->make(true);
    }

    public function checkStsAdm(Request $request)
    {
        $manifest = $request->input('manifest');
        $jobNo = $request->input('job_no'); // ganti dari part_no
    
        $order = \DB::table('upload_rekap_order_adms')
            ->where('manifest', $manifest)
            ->where('job_no', $jobNo) // ganti dari part_no
            ->first();
    
        if (!$order) {
            return response()->json(['sts' => null, 'message' => 'Data tidak ditemukan'], 404);
        }
    
        return response()->json(['sts' => $order->sts]);
    }
    

    
    public function getQtyRekap(Request $request)
    {
        $docdn = $request->docdn;
    
        $counts = DB::table('upload_rekap_order_adms')
            ->select(
                'cycle',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN qty_order = 0 THEN 1 ELSE 0 END) as total_qty2'),
                DB::raw('SUM(CASE WHEN qty_order > 0 THEN 1 ELSE 0 END) as total_gt0')
            )
            ->whereDate('created_at', $docdn) // atau ->where('docdn', $docdn)
            ->groupBy('cycle')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->cycle => [
                        'total'      => $item->total,
                        'total_gt0'  => $item->total_gt0,
                        'total_qty2' => $item->total_qty2
                    ]
                ];
            });
    
        return response()->json($counts);
    }
    
    
    
    
    public function listdetail(Request $request)
    {
        $selectedCycle = $request->cycle;
        $createdAt = $request->created_at;  // ambil param created_at dari request
    
        $query = DB::table('upload_rekap_order_adms')
            ->select('id', 'job_no', 'part_no', 'cycle', 'jml_kanban', 'qty_kanban', 'qty_order', 'uniqNo', 'manifest','sts');
    
        if ($createdAt) {
            $query->where('created_at', $createdAt);
        }
    
        if (!empty($selectedCycle)) {
            $query->where('cycle', $selectedCycle);
        }
    
        return DataTables::of($query)->make(true);
    }
    



    
    public function updateQtyOrder(Request $request)
{
    // Ambil data dari request
    $jobNo = trim($request->input('scan_first'));          // hasil JS extractedScan1 (job_no)
    $manifestExtract = trim($request->input('manifest_extract')); // hasil JS manifest_extract
    $scanSecond = trim($request->input('scan_second'));        // hasil scan kedua

    \Log::info('updateQtyOrder called');
    \Log::info('job_no: [' . $jobNo . ']');
    \Log::info('manifest_extract: [' . $manifestExtract . ']');
    \Log::info('scan_second: [' . $scanSecond . ']');

    if (!$jobNo || !$manifestExtract || !$scanSecond) {
        return response()->json([
            'status' => 'error',
            'message' => 'Parameter scan_first (job_no), manifest_extract dan scan_second harus diisi.'
        ], 400);
    }

    $parts = explode('.', $scanSecond);
    if (count($parts) < 3) {
        return response()->json([
            'status' => 'error',
            'message' => 'Format scan_second tidak valid, kurang dari 2 titik.'
        ], 400);
    }

    $qtyToSubtract = intval($parts[2]);
    if ($qtyToSubtract <= 0) {
        return response()->json([
            'status' => 'error',
            'message' => 'Nilai qty yang dikurangkan tidak valid.'
        ], 400);
    }

    // Cari data sesuai job_no dan manifest
    $order = \DB::table('upload_rekap_order_adms')
        ->where('job_no', $jobNo)  // ganti dari part_no
        ->where('manifest', $manifestExtract)
        ->first();

    if (!$order) {
        return response()->json([
            'status' => 'error',
            'message' => 'Data dengan job_no dan manifest yang sesuai tidak ditemukan.'
        ], 404);
    }

    $newQtyOrder = max(0, $order->qty_order - $qtyToSubtract);

    // Tentukan nilai sts: 1 jika qty_order sudah 0, selain itu biarkan 0
    $sts = ($newQtyOrder == 0) ? 1 : 0;

    // Update di upload_rekap_order_adms
    \DB::table('upload_rekap_order_adms')
        ->where('job_no', $jobNo)  // ganti dari part_no
        ->where('manifest', $manifestExtract)
        ->update([
            'qty_order'   => $newQtyOrder,
            'sts'         => $sts,
            'createdby'   => auth()->user()->username,
            'upload_date' => now()
        ]);

    // Update di pc_store_directs berdasarkan job_no2
    \DB::table('pc_store_directs')
        ->where('job_no', $jobNo)  // ganti dari part_no2
        ->update([
            'qty_act'  => \DB::raw("GREATEST(qty_act - $qtyToSubtract, 0)"),
            'strength' => \DB::raw("IF(daily_volume > 0, ROUND(GREATEST(qty_act - $qtyToSubtract, 0) / daily_volume, 1), 0)")
        ]);

    return response()->json([
        'status'         => 'success',
        'message'        => 'Qty order & qty_act berhasil dikurangi, status + createdby + upload_date diperbarui.',
        'job_no'         => $jobNo,
        'manifest'       => $manifestExtract,
        'qty_order_old'  => $order->qty_order,
        'qty_subtracted' => $qtyToSubtract,
        'qty_order_new'  => $newQtyOrder,
        'sts_new'        => $sts,
        'createdby'      => auth()->user()->id,
        'upload_date'    => now()->toDateTimeString()
    ]);
}

    
}
