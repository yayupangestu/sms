<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmDnIncoming;
use App\Models\ScanInLabel;
use App\Models\RmStok;
use App\Models\DnInput;
use App\Models\RmInMaterial;
use App\Models\TagLabel2;

use Illuminate\Support\Facades\DB;

class ScanInLabel2Controller extends Controller
{
    public function index(){
        $title = 'Scan label';
        return view('scanner2.scaninlabel2', compact('title'));
    }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'part_no'  => 'required|string',
    //         'spec'     => 'required|string',
    //         'supplier' => 'required|string',
    //         'uniqNo'   => 'required|string',
    //         // 'id_data'  => 'required|string',
    //         'id'       => 'required|string',
    //         'qty_kg'   => 'required|string',
    //         'qty_in'   => 'required|string',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         $scanInLabel = new ScanInLabel();
    //         $scanInLabel->part_no = $request->part_no;
    //         $scanInLabel->spec = $request->spec;
    //         $scanInLabel->supplier = $request->supplier;
    //         $scanInLabel->uniqNo = $request->uniqNo;
    //         // $scanInLabel->id_data = $request->id_data;
    //         $scanInLabel->id = $request->id;
    //         $scanInLabel->qty_kg = $request->qty_kg;
    //         $scanInLabel->qty_in = $request->qty_in;
    //         $scanInLabel->createdby = auth()->user()->id;
    //         $scanInLabel->updatedby = auth()->user()->id;
    //         $scanInLabel->save(); // kalau gagal di sini, semua update dibatalkan

    //         $rmStoks = RmStok::where('part_no', $request->part_no)
    //         ->where('keterangan', 2)
    //         ->get();

    //         $rmStoks = RmStok::where('part_no', $request->part_no)->get();

    //         if ($rmStoks->isNotEmpty()) {
    //             foreach ($rmStoks as $rmStok) {
    //                 $rmStok->actual_sheet += $request->qty_in;
    //                 $rmStok->actual_kg += $request->qty_kg;

    //                 // Tambahan: ubah nilai keterangan jika == 2
    //                 if ($rmStok->keterangan == 2) {
    //                     $rmStok->keterangan = 1;
    //                 }

    //                 $rmStok->save();
    //             }
    //         }

    //         DB::commit(); // Semua OK, simpan

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data berhasil disimpan dan kuantitas diupdate.'
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Periksa Tabel Data Sudah ada.'
    //         ], 500);
    //     }
    // }

    public function store(Request $request)
{
    $request->validate([
        'part_no'           => 'required|string',
        'spek'              => 'required|string',
        'supplier'          => 'required|string',
        'uniqNo'            => 'required|string',
        'id'                => 'required|string',
        'doc_po'            => 'required|string',
        'actual_kg'         => 'required|string',
        'actual_sheet'      => 'required|string',
        'category'          => 'required|string',
    ]);

    $validasi = TagLabel2::where('uniqNo', $request->uniqNo)
                ->where('sts', 1)
                ->first();

    if ($validasi) {
        return response()->json([
            'success' => false,
            'message' => 'Label Sudah Di Scan'
        ], 400);
    }

    DB::beginTransaction();

    try {
        // Simpan ke ScanInLabel
        $scanInLabel = new ScanInLabel();
        $scanInLabel->part_no = $request->part_no;
        $scanInLabel->spec = $request->spek;
        $scanInLabel->supplier = $request->supplier;
        $scanInLabel->uniqNo = $request->uniqNo;
        // $scanInLabel->id_data = $request->id;
        $scanInLabel->qty_kg = $request->actual_sheet;
        $scanInLabel->qty_in = $request->actual_kg;
        $scanInLabel->createdby = auth()->user()->username;
        $scanInLabel->updatedby = auth()->user()->username;
        $scanInLabel->save();

        $dnInput = new DnInput();
        // $dnInput->doc_po = $request->category;
        // if ($request->category == 1) {
        //     $dnInput->doc_po = 'PO/OPSIONAL/RM/2025';
        // } elseif ($request->category == 2) {
        //     $dnInput->doc_po = 'PO/OPSIONAL/BLANK/2025';
        // } else {
        //     $dnInput->doc_po = '-';
        // }
        $dnInput->doc_po = $request->doc_po;
        $dnInput->part_no = $request->part_no;
        $dnInput->spec = $request->spek;
        $dnInput->supplier = $request->supplier;
        // $dnInput->uniqNo = $request->uniqNo;
        $dnInput->actual = $request->actual_sheet;
        $dnInput->kg_sheet = $request->actual_kg;
        $dnInput->sts_scan = 1;
        $dnInput->createdby = auth()->user()->username;
        $dnInput->updatedby = auth()->user()->username;

        $dnInput->save();

        // Update rm_stoks
        $rmStoks = RmStok::where('part_no', $request->part_no)->get();

        if ($rmStoks->isNotEmpty()) {
            foreach ($rmStoks as $rmStok) {
                $rmStok->actual_sheet += $request->actual_sheet;
                $rmStok->actual_kg += $request->actual_kg;

                if ($rmStok->keterangan == 2) {
                    $rmStok->keterangan = 1;
                }

                $rmStok->save();
            }
        }
          // Update DnInput
          $TagLabel2 = TagLabel2::where('id', $request->id)->first();
          if ($TagLabel2) {
              $TagLabel2->sts = 1;
              $TagLabel2->save();
          }


        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan ke semua tabel.'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Gagal menyimpan data: ' . $e->getMessage()
        ], 500);
    }
}



}
