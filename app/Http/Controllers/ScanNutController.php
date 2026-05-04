<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmScannedNut;
use App\Models\RmStandartNut;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ScanNutController extends Controller
{
    public function saveScanResult(Request $request)
{
    // Validasi data permintaan yang masuk
    $request->validate([
        'part_nut' => 'nullable|string',
        'suplaier' => 'nullable|string',
        'qty_plan' => 'nullable|integer',
        'uniq_no'  => 'required|string',
    ]);

    // Temukan baris yang ada berdasarkan uniq_no
    $existingNut = RmScannedNut::where('uniq_no', $request->input('uniq_no'))->first();

    if ($existingNut) {
        // Jika baris sudah ada, periksa apakah part_nut berbeda
        if ($request->input('part_nut') !== $existingNut->part_nut) {
            // Jika part_nut berbeda, buat baris baru
            $newNut = new RmScannedNut();
            $newNut->part_nut = $request->input('part_nut');
            $newNut->suplaier = $request->input('suplaier');
            $newNut->qty_plan = $request->input('qty_plan');
            $newNut->uniq_no = $request->input('uniq_no');
            
            // Set plc column to 1 if part_nut exists
            if ($request->input('part_nut')) {
                $newNut->plc = 1;
            }
            
            // Save the current user's ID as the creator of this record
            $newNut->createdby = auth()->user()->id;

            // Simpan perubahan
            $newNut->save();
        } else {
            // Jika part_nut sama, perbarui kolom dengan data baru
            $existingNut->suplaier = $request->input('suplaier', $existingNut->suplaier);
            $existingNut->qty_plan = $request->input('qty_plan', $existingNut->qty_plan);
            
            // Set plc column to 1 if part_nut exists
            if ($request->input('part_nut')) {
                $existingNut->plc = 1;
            }

            // Simpan perubahan
            $existingNut->save();
        }
    } else {
        // Jika baris tidak ada, buat baris baru
        $newNut = new RmScannedNut();
        $newNut->part_nut = $request->input('part_nut');
        $newNut->suplaier = $request->input('suplaier');
        $newNut->qty_plan = $request->input('qty_plan');
        $newNut->uniq_no = $request->input('uniq_no');
        
        // Set plc column to 1 if part_nut exists
        if ($request->input('part_nut')) {
            $newNut->plc = 1;
        }
        
        // Save the current user's ID as the creator of this record
        $newNut->createdby = auth()->user()->id;

        // Simpan perubahan
        $newNut->save();
    }

    return response()->json(['success' => true, 'message' => 'Scan result saved successfully!']);
}

    
}

