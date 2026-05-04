<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmDnIncoming;
use App\Models\TabelTransitPcStore;
use App\Models\RmStok;
use App\Models\DnInput;
use App\Models\ScanOutStmp;
use App\Models\ScanOutWelding;
use App\Models\PcStoreDirect;

use Illuminate\Support\Facades\DB;

class ScanInPsDirectController extends Controller
{
    public function index(){
        $title = 'Scan In Store';
       return view('scanner2.scanindirect',compact('title'));
    }


    public function store(Request $request)
{
    $request->validate([
        'part_no2'          => 'required|string',
        'part_no'           => 'required|string',
        'job_no'            => 'required|string',
        'model'             => 'required|string',
        'qty'               => 'required|string',
        'date'              => 'required|string',
        'uniqNo'            => 'required|string',
        'kodeMaterial'      => 'required|string',
        'qty_ng'            => 'required|string',
        'id_data'           => 'required|string',
    ]);

    DB::beginTransaction();

    try {
        // ✅ Cek apakah uniqNo sudah pernah discan
        $cekUniq = TabelTransitPcStore::where('uniqNo', $request->uniqNo)->first();
        if ($cekUniq) {
            return response()->json([
                'success' => false,
                'toast'   => true, // 🚀 tanda untuk toastr
                'message' => 'Data dengan uniqNo ' . $request->uniqNo . ' sudah pernah discan!'
            ], 400);
        }


        // Simpan data scan in welding
        $PcStoreDirect = new TabelTransitPcStore();
        $PcStoreDirect->part_no2        = $request->part_no2;
        $PcStoreDirect->part_no         = $request->part_no;
        $PcStoreDirect->job_no          = $request->job_no;
        $PcStoreDirect->model           = $request->model;
        $PcStoreDirect->qty_act         = $request->qty;
        $PcStoreDirect->date            = $request->date;
        $PcStoreDirect->uniqNo          = $request->uniqNo;
        $PcStoreDirect->kodeMaterial    = $request->kodeMaterial;
        $PcStoreDirect->id_data         = $request->id_data;
        $PcStoreDirect->createdby       = auth()->id();
        $PcStoreDirect->sts             = 1;
        $PcStoreDirect->save();


         $tagLabel = ScanOutStmp::where('uniqNo', $request->uniqNo)->first();
            if ($tagLabel) {
                $tagLabel->sts = 1;
                $tagLabel->sts_pcstore = 1;
                $tagLabel->save();
            }

        // Update ke PcStoreDirect (stok)
        $PcStoreDirects = PcStoreDirect::where('part_no2', $request->part_no)->get();

        if ($PcStoreDirects->isNotEmpty()) {
            foreach ($PcStoreDirects as $item) {
                $item->qty_act += $request->qty;

                if ($item->daily_volume > 0) {
                    $item->strength = round($item->qty_act / $item->daily_volume, 1);
                } else {
                    $item->strength = 0;
                }

                $item->save();
            }
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan dan stok diupdate.'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}






}
