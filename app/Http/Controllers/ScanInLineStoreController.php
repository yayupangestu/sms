<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmDnIncoming;
use App\Models\ScanInLabel;
use App\Models\RmStok;
use App\Models\DnInput;
use App\Models\RmInMaterial;
use App\Models\ScanOutStmp;
use App\Models\ScanInLineStore;
use App\Models\LineStoreStok;

use Illuminate\Support\Facades\DB;

class ScanInLineStoreController extends Controller
{
    public function index()
    {
        $title = 'Scan In Part';
        return view('linestore.scanin2', compact('title'));
    }

    public function checkRepair(Request $request)
    {
        $uniqNo = $request->uniqNo;

        $existsInRepair = ScanOutStmp::where('uniqNo', $uniqNo)
            ->where('status', 2) // 2 = Repair
            ->exists();

        return response()->json([
            'inRepair' => $existsInRepair
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_no2' => 'required|string',
            'part_no' => 'required|string',
            'job_no' => 'required|string',
            'model' => 'required|string',
            'qty' => 'required|string', // ✅ pastikan ini number
            'date_plan' => 'required|string',
            'uniqNo' => 'required|string',
            'KodeMaterial' => 'required|string',
            'uniqNo' => 'required|string',
            'id_data' => 'required|numeric',
        ]);

        // 🔒 Cek apakah sudah pernah discan
        $existingScan = ScanInLineStore::where('uniqNo', $request->uniqNo)
            ->where('part_no', $request->part_no)
            ->first();

        if ($existingScan) {
            return response()->json([
                'success' => false,
                'message' => 'Data dengan uniqNo dan part_no ini sudah pernah discan.'
            ], 400);
        }

        DB::beginTransaction();

        try {
            // Simpan data scan in
            $ScanInLineStore = new ScanInLineStore();
            $ScanInLineStore->uniqNo = $request->uniqNo;
            $ScanInLineStore->job_no = $request->job_no;
            $ScanInLineStore->part_no = $request->part_no;
            $ScanInLineStore->part_no2 = $request->part_no2;
            $ScanInLineStore->qty_act = $request->qty;
            $ScanInLineStore->model = $request->model;
            $ScanInLineStore->kode_material = $request->KodeMaterial;
            $ScanInLineStore->date = $request->date_plan;
            $ScanInLineStore->id_data = $request->id_data;
            $ScanInLineStore->qty_ng = $request->qty_ng;
            $ScanInLineStore->createdby = auth()->user()->id;
            $ScanInLineStore->updatedby = auth()->user()->id;
            $ScanInLineStore->save();

            // Update stok
            $lineStoreItems = LineStoreStok::where('part_no2', $request->part_no)->get();
            if ($lineStoreItems->isNotEmpty()) {
                foreach ($lineStoreItems as $item) {
                    $item->qty_actual += $request->qty; // ✅ Pastikan qty yang digunakan sesuai
                    $item->save();
                }
            }
            $ScanOutStmpItems = ScanOutStmp::where('part_no2', $request->part_no)
                ->where('uniqNo', $request->uniqNo)
                ->get();
            if ($ScanOutStmpItems->isNotEmpty()) {
                foreach ($ScanOutStmpItems as $item) {
                    $item->scan_in_ls = now();
                    $item->status_ls = 1;
                    $item->status = 3;
                    $item->save();
                }
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan dan kuantitas diupdate.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage()
            ], 500);
        }
    }
}
