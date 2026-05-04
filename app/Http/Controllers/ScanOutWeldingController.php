<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmDnIncoming;
use App\Models\ScanOutWelding;
use App\Models\RmStok;
use App\Models\DnInput;
use App\Models\RmInMaterial;
use App\Models\ScanOutStmp;
use App\Models\ScanInLineStore;
use App\Models\PcStoreDirect;

use Illuminate\Support\Facades\DB;

class ScanOutWeldingController extends Controller
{
    public function index(){
        $title = 'Scan label';
       return view('scanner2.scanoutwelding',compact('title'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'part_no'   => 'required|string',
            'job_no'    => 'required|string',
            'qty_act'   => 'required|integer',
            'count'     => 'required|integer',
            'id_data'   => 'required|string',
        ]);
    
        DB::beginTransaction();
    
        try {
            // Simpan data scan out welding
            $ScanOutWelding = new ScanOutWelding();
            $ScanOutWelding->part_no   = $request->part_no;
            $ScanOutWelding->job_no    = $request->job_no;
            $ScanOutWelding->qty_act   = $request->qty_act; // ✅ diperbaiki
            $ScanOutWelding->count     = $request->count;
            $ScanOutWelding->id_data   = $request->id_data;
            $ScanOutWelding->createdby = auth()->id();
            $ScanOutWelding->sts       = 1;
            // $ScanOutWelding->updatedby = auth()->id();
            $ScanOutWelding->save();
    
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
