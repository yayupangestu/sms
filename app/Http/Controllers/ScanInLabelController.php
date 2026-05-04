<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmDnIncoming;
use App\Models\ScanInLabel;
use App\Models\RmStok;
use App\Models\DnInput;
use App\Models\RmInMaterial;

use Illuminate\Support\Facades\DB;

class ScanInLabelController extends Controller
{
    public function index(){
        $title = 'Scan label';
        return view('scanner2.scaninlabel', compact('title'));
    }


 public function store(Request $request)
{
    $request->validate([
        'part_no'  => 'required|string',
        'spec'     => 'required|string',
        'supplier' => 'required|string',
        'uniqNo'   => 'required|string',
        'id_data'  => 'required|string',
        'id'       => 'required|string',
        'qty_kg'   => 'required|string',
        'qty_in'   => 'required|string',
    ]);

    // 🔒 Cek apakah sudah pernah discan
    $existingScan = ScanInLabel::where('uniqNo', $request->uniqNo)
        ->where('part_no', $request->part_no)
        ->first();

    if ($existingScan) {
        return response()->json([
            'success' => false,
            'message' => 'Untuk Label ini sudah Dican Unique dan Part No nya sudah ada.'
        ], 400);
    }

    DB::beginTransaction();

    try {
        $scanInLabel = new ScanInLabel();
        $scanInLabel->part_no = $request->part_no;
        $scanInLabel->spec = $request->spec;
        $scanInLabel->supplier = $request->supplier;
        $scanInLabel->uniqNo = $request->uniqNo;
        $scanInLabel->id_data = $request->id_data;
        // $scanInLabel->id = $request->id;
        $scanInLabel->qty_kg = $request->qty_kg;
        $scanInLabel->qty_in = $request->qty_in;
        $scanInLabel->createdby = auth()->user()->id;
        $scanInLabel->updatedby = auth()->user()->id;
        $scanInLabel->save();

        $rmStoks = RmStok::where('part_no', $request->part_no)->get();
        if ($rmStoks->isNotEmpty()) {
            foreach ($rmStoks as $rmStok) {
                $rmStok->actual_sheet += $request->qty_in;
                $rmStok->actual_kg += $request->qty_kg;
                if ($rmStok->keterangan == 2) {
                    $rmStok->keterangan = 1;
                }
                $rmStok->save();
            }
        }

        $RmDn = RmDnIncoming::where('id', $request->id_data)->first();
        if ($RmDn) {
            $RmDn->balance_sheet += $request->qty_in;
            $RmDn->actual_kg += $request->qty_kg;
            $RmDn->actual_sheet += $request->qty_in;
            if ($RmDn->balance_sheet >= 0) {
                $RmDn->status = 'Close';
            }
            $RmDn->save();
        }

        $dnInput = DnInput::where('id', $request->id)->first();
        if ($dnInput) {
            $dnInput->sts_scan = 1;
            $dnInput->save();
        }

        $inMaterial = RmInMaterial::where('uniqNo', $request->uniqNo)->first();
        if ($inMaterial) {
            $inMaterial->sts_scan = 1;
            $inMaterial->save();
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
            'message' => 'Periksa Tabel Data Sudah ada.'
        ], 500);
    }
}


}
