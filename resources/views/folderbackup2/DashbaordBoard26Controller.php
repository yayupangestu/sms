<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadRekapOrder;


class DashbaordBoard26Controller extends Controller
{
    public function index()
    {
        $title = 'BOARD D26';

        // Ambil data proses = PRESS dan cycle = 1
        $pressData = UploadRekapOrder::where('proses', 'PRESS')
        ->whereBetween('cycle', [1, 8])  // filter cycle antara 1 sampai 8
        // ->where('qty_order', '>', 0)     // hanya yang qty_order > 0
        ->orderBy('type_pallet')
        ->get();


        $subAssy = UploadRekapOrder::where('proses', 'SUB ASSY')
        ->whereBetween('cycle', [1, 8])  // filter cycle antara 1 sampai 8
        ->orderBy('type_pallet')
        ->get();

        $nutData = UploadRekapOrder::where('proses', 'NUT')
        ->whereBetween('cycle', [1, 8])  // filter cycle antara 1 sampai 8
        ->orderBy('type_pallet')
        ->get();
        return view('ppic.boardd26', compact('title', 'pressData','subAssy','nutData'));
    }

    public function getPressDataJson()
    {
        $pressData = UploadRekapOrder::where('proses', 'PRESS')
        ->whereBetween('cycle', [1, 8])
        ->where('qty_order', '>', 0)
        ->leftJoin('pc_store_directs', 'upload_rekap_orders.uniqNo', '=', 'pc_store_directs.job_no')
        ->select('upload_rekap_orders.*', 'pc_store_directs.strength')
        ->orderBy('type_pallet')
        ->get();
        return response()->json($pressData);
    }
    public function getSubassyDataJson()
    {
        $subAssy = UploadRekapOrder::where('proses', 'SUB ASSY')
        ->whereBetween('cycle', [1, 8])
        ->where('qty_order', '>', 0)
        ->leftJoin('pc_store_directs', 'upload_rekap_orders.uniqNo', '=', 'pc_store_directs.job_no')
        ->select('upload_rekap_orders.*', 'pc_store_directs.strength')
        ->orderBy('type_pallet')
        ->get();

        return response()->json($subAssy);
    }
    public function getNutDataJson()
    {
        $nutData = UploadRekapOrder::where('proses', 'NUT')
        ->whereBetween('cycle', [1, 8])
        ->where('qty_order', '>', 0)
        ->leftJoin('pc_store_directs', 'upload_rekap_orders.uniqNo', '=', 'pc_store_directs.job_no')
        ->select('upload_rekap_orders.*', 'pc_store_directs.strength')
        ->orderBy('type_pallet')
        ->get();

        return response()->json($nutData);
    }

    public function on(Request $request)
    {
        // Disini kamu taruh logika untuk ON relay
        // Misalnya panggil script Python, kirim MQTT, atau update ke DB

        return response()->json([
            'status' => 'success',
            'message' => 'Relay berhasil dinyalakan',
            'source' => $request->input('source', 'manual')
        ]);
    }


}
