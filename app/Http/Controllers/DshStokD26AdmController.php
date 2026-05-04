<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PcStoreDirect;
use App\Models\TagLabelWelding;
use App\Models\ScanOutStmp;
use DB;


class DshStokD26AdmController extends Controller
{
    public function index()
{
    $title = 'Stok D26';

    // Hitung jumlah data strength > 1.0 (Stok Aman)
    $totalPcStoreSafe = DB::table('pc_store_directs')
        ->where('strength', '>', 1.0)
        ->count();

    // Hitung jumlah data strength antara 0.5 sampai < 1.0 (Stok Minim)
    $totalPcStoreMin = DB::table('pc_store_directs')
        ->where('strength', '>=', 0.5)
        ->where('strength', '<', 1.0)
        ->count();

    $totalPcStoreOrder = DB::table('pc_store_directs')
        ->where('strength', '>=', 0.1)
        ->where('strength', '<', 0.5)
        ->count();

      // Hitung jumlah data strength > 1.0 (Stok Aman)
    $totalPcStoreEmpty = DB::table('pc_store_directs')
    ->where('strength', '=', 0.0)
        ->count();


    // Kirim data ke view
    return view('dashboard2.stokd26adm', compact('title', 'totalPcStoreSafe', 'totalPcStoreMin','totalPcStoreOrder','totalPcStoreEmpty'));
}



    // // Data utama PcStoreDirect
    // public function getData()
    // {
    //     $data = PcStoreDirect::where('model', 'D26 TMMIN')
    //                 ->latest()
    //                 ->take(50)
    //                 ->get();

    //     return response()->json($data);
    // }

    // Data utama PcStoreDirect
    public function getDataAdm()
    {
        $data = PcStoreDirect::whereIn('customer', ['ADM PLANT 5'])
                    ->where('monthly_volume','>', 0)
                    ->latest()
                    // ->take(100)
                    ->get();

        return response()->json($data);
    }
// ('model', ['D26 ADM', 'D55', 'D30','D14','D74','D88','D40'])

//    // Data untuk sidebar Transit (ScanOutWelding)
//    public function getDataAdm2()
//    {
//        // Ambil semua uniqNo dari tabel_transit_pc_stores yang memiliki sts = 1
//        $uniqNosTerpakai = \DB::table('tabel_transit_pc_stores')
//            ->where('sts', 1)
//            ->pluck('uniqNo')
//            ->toArray();

//        // Ambil data dari tag_label_weldings di mana sts = NULL
//        // dan uniqNo belum ada di tabel_transit_pc_stores (sts = 1)
//        $data = \App\Models\TagLabelWelding::whereNull('sts')
//            ->whereNotIn('uniqNo', $uniqNosTerpakai)
//            ->latest()
//            ->get()
//            ->map(function ($item) {
//                return [
//                    'job_no'     => $item->job_no,
//                    'part_no'    => $item->part_no,
//                    'qty_act'    => $item->qty_act,
//                    'uniqNo'     => $item->uniqNo,
//                    'created_at' => $item->created_at,
//                ];
//            });

//        return response()->json($data);
//    }

public function getDataAdm2()
{
    // === 1️⃣ Ambil uniqNo yang sudah dipakai di PC Store (sts = 1) ===
    $uniqNosTerpakai = \DB::table('tabel_transit_pc_stores')
        ->where('sts', 1)
        ->pluck('uniqNo')
        ->toArray();

    // === 2️⃣ Ambil data dari TagLabelWelding (sts null & sts_pcstore null) ===
    $dataWelding = \App\Models\TagLabelWelding::whereNull('sts')
        ->whereNull('sts_pcstore')
        ->whereNotIn('uniqNo', $uniqNosTerpakai)
        ->latest()
        ->get()
        ->map(function ($item) {
            return [
                'source'     => 'welding',
                'job_no'     => $item->job_no,
                'part_no'    => $item->part_no,
                'qty_act'    => $item->qty_act,
                'uniqNo'     => $item->uniqNo,
                'created_at' => $item->created_at,
            ];
        });

    // === 3️⃣ Ambil data dari ScanOutStmp (status = 4 & sts_pcstore null) ===
    $dataStamping = \App\Models\ScanOutStmp::where('status', 4)
        ->whereNull('sts_pcstore')
        ->whereNotIn('uniqNo', $uniqNosTerpakai)
        ->latest()
        ->get()
        ->map(function ($item) {
            return [
                'source'     => 'stamping',
                'job_no'     => $item->job_no,
                'part_no2'   => $item->part_no2,
                'qty_act'    => $item->qty_act,
                'uniqNo'     => $item->uniqNo,
                'created_at' => $item->created_at,
            ];
        });

    // === 4️⃣ Gabungkan dua sumber data ===
    $dataGabung = $dataWelding
        ->concat($dataStamping)
        ->sortByDesc(fn($item) => \Carbon\Carbon::parse($item['created_at']))
        ->values();

    // === 5️⃣ Kembalikan hasil JSON ===
    return response()->json($dataGabung);
}



}
