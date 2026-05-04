<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\UploadRekapOrder;
use App\Models\RmMaterial;
use App\Models\RmMonthly;
use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\RmDnIncomingImport; // Pastikan namespace ini benar
use App\Exports\PoExport;
use DataTables;
use DB;
use Illuminate\Support\Facades\Log;
use App\Imports\UploadRekapImport; // Pastikan namespace ini benar



class Listrekapd26Controller extends Controller
{
    public function index () {
        $title = 'List Rekap';
        return view('ppic.prepared26', compact('title'));
    }

    public function list()
    {
        $query = DB::table('upload_rekap_orders as a')
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

    public function checkSts(Request $request)
{
    $manifest = $request->input('manifest');
    $partNo = $request->input('part_no');

    $order = \DB::table('upload_rekap_orders')
        ->where('manifest', $manifest)
        ->where('part_no', $partNo)
        ->first();

    if (!$order) {
        return response()->json(['sts' => null, 'message' => 'Data tidak ditemukan'], 404);
    }

    return response()->json(['sts' => $order->sts]);
}

public function checkLabelWelding2(Request $request)
{
    $label = $request->input('no_label_welding');

    $record = \DB::table('tag_label_weldings')
        ->where('uniqNo', $label)
        ->select('uniqNo', 'status_prepare')
        ->first();

    if ($record) {
        if ($record->status_prepare == 1) {
            return response()->json([
                'exists' => true,
                'message' => 'Label sudah digunakan'
            ]);
        } else {
            return response()->json([
                'exists' => false,
                'message' => 'Label tersedia'
            ]);
        }
    }

    return response()->json([
        'exists' => true, // ❌ anggap sama seperti sudah dipakai kalau tidak ketemu
        'message' => 'Label tidak ditemukan di database'
    ]);
}



    public function getQtyRekap(Request $request)
    {
        $docdn = $request->docdn;

        $counts = DB::table('upload_rekap_orders')
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

        $query = DB::table('upload_rekap_orders')
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
        $scanFirst = trim($request->input('scan_first'));          // part_no
        $manifestExtract = trim($request->input('manifest_extract'));
        $scanSecond = trim($request->input('scan_second'));        // full scan kedua

        if (!$scanFirst || !$manifestExtract || !$scanSecond) {
            return response()->json([
                'status' => 'error',
                'message' => 'Parameter scan_first, manifest_extract dan scan_second harus diisi.'
            ], 400);
        }

        $parts = explode('.', $scanSecond);
        if (count($parts) < 5) {
            return response()->json([
                'status' => 'error',
                'message' => 'Format scan_second tidak valid, minimal harus ada 5 segmen dipisah titik.'
            ], 400);
        }

        // qty ambil dari segmen ke-3 (index 2)
        $qtyToSubtract = intval($parts[2]);
        if ($qtyToSubtract <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Nilai qty yang dikurangkan tidak valid.'
            ], 400);
        }

        // ambil no_label_welding dari segmen ke-5 (index 4)
        $noLabelWelding = $parts[4];

        // Cari data sesuai part_no dan manifest
        $order = \DB::table('upload_rekap_orders')
            ->where('part_no', $scanFirst)
            ->where('manifest', $manifestExtract)
            ->first();

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data dengan part_no dan manifest yang sesuai tidak ditemukan.'
            ], 404);
        }

        $newQtyOrder = max(0, $order->qty_order - $qtyToSubtract);
        $sts = ($newQtyOrder == 0) ? 1 : 0;

        // Update di upload_rekap_orders (tidak lagi simpan no_label_welding)
        \DB::table('upload_rekap_orders')
            ->where('part_no', $scanFirst)
            ->where('manifest', $manifestExtract)
            ->update([
                'qty_order'   => $newQtyOrder,
                'sts'         => $sts,
                'createdby'   => auth()->user()->username,
                'upload_date' => now()
            ]);

        // Update di pc_store_directs
        \DB::table('pc_store_directs')
            ->where('part_no2', $scanFirst)
            ->update([
                'qty_act'  => \DB::raw("GREATEST(qty_act - $qtyToSubtract, 0)"),
                'strength' => \DB::raw("IF(daily_volume > 0, ROUND(GREATEST(qty_act - $qtyToSubtract, 0) / daily_volume, 1), 0)")
            ]);

        // ✅ Update status_prepare di tabel tag_label_weldings
        \DB::table('tag_label_weldings')
            ->where('uniqNo', $noLabelWelding)
            ->update([
                'status_prepare' => 1,
                'updated_at'     => now()
            ]);

        return response()->json([
            'status'          => 'success',
            'message'         => 'Qty order & qty_act berhasil dikurangi, status_prepare diperbarui.',
            'part_no'         => $scanFirst,
            'manifest'        => $manifestExtract,
            'qty_order_old'   => $order->qty_order,
            'qty_subtracted'  => $qtyToSubtract,
            'qty_order_new'   => $newQtyOrder,
            'sts_new'         => $sts,
            // 'no_label_welding'=> $noLabelWelding,
            'status_prepare'  => 1,
            'createdby'       => auth()->user()->username,
            'upload_date'     => now()->toDateTimeString()
        ]);
    }


}
