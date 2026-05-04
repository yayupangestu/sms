<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmScannedNut;
use App\Models\RmStandartNut;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ScanNutOutController extends Controller
{
    public function saveScanOutResult(Request $request)
{
    // Validasi data permintaan yang masuk
    $request->validate([
        'part_nut_out' => 'nullable|string',
        'suplaier_out' => 'nullable|string',
        'qty_plan_out' => 'nullable|integer',
        'uniq_no_out'  => 'required|string',
    ]);

    // Temukan baris yang ada berdasarkan uniq_no_out dan part_nut_out
    $scannedNut = RmScannedNut::where('uniq_no', $request->input('uniq_no_out'))
                              ->where('part_nut', $request->input('part_nut_out'))
                              ->first();

    if ($scannedNut) {
        // Jika baris sudah ada, perbarui kolom dengan data baru
        $scannedNut->part_nut_out = $request->input('part_nut_out', $scannedNut->part_nut_out);
        $scannedNut->suplaier_out = $request->input('suplaier_out', $scannedNut->suplaier_out);
        $scannedNut->qty_plan_out = $request->input('qty_plan_out', $scannedNut->qty_plan_out);
        
        // Set plc column to 0 if part_nut_out exists
        if ($request->input('part_nut_out')) {
            $scannedNut->plc_open = 0;
        }

        // Update updatedby field for existing record
        $scannedNut->updatedby = auth()->user()->id;
    } else {
        // Jika baris tidak ada, buat baris baru
        $scannedNut = new RmScannedNut();
        $scannedNut->part_nut_out = $request->input('part_nut_out');
        $scannedNut->suplaier_out = $request->input('suplaier_out');
        $scannedNut->qty_plan_out = $request->input('qty_plan_out');
        $scannedNut->uniq_no = $request->input('uniq_no_out');
        
        // Set plc column to 0 if part_nut_out exists
        if ($request->input('part_nut_out')) {
            $scannedNut->plc_open = 0;
        }

        // Save the current user's ID as the creator of this record
        $scannedNut->createdby = auth()->user()->id;
        $scannedNut->updatedby = auth()->user()->id;
    }

    // Simpan perubahan
    $scannedNut->save();

    return response()->json(['success' => true, 'message' => 'Scan out result saved successfully!']);
}


    
}

