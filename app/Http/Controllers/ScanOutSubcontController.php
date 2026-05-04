<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmDnIncoming;
use App\Models\ScanOutSubcont;
use App\Models\RmStok;
use App\Models\DnInput;
use App\Models\LineStoreUpload;
use App\Models\ScanInLabel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ScanOutSubcontController extends Controller
{
    public function index()
    {
        $title = 'Scan label';
        return view('scanner2.ScanOutSubcont', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_no'       => 'required|string',
            'spec'          => 'required|string',
            'supplier'      => 'required|string',
            'uniqNo'        => 'required|string|nullable',
            'qty_out_kg'    => 'required|numeric',
            'qty_out_sheet' => 'required|numeric',
            'id_data'       => 'nullable|integer', // tambahan agar tidak error saat assign
        ]);

        DB::beginTransaction();

        try {
            $partNo = $request->input('part_no');

            // Simpan data scan out
            $scanOutSubcont = new ScanOutSubcont();
            $scanOutSubcont->part_no = $partNo;
            $scanOutSubcont->spec = $request->input('spec');
            $scanOutSubcont->uniqNo = $request->input('uniqNo');
            $scanOutSubcont->supplier = $request->input('supplier');
            $scanOutSubcont->id_data = $request->input('id_data');
            $scanOutSubcont->qty_out_sheet = $request->input('qty_out_sheet');
            $scanOutSubcont->qty_out_kg = $request->input('qty_out_kg');
            $scanOutSubcont->createdby = auth()->user()->username;
            $scanOutSubcont->save();

            // Update stok pada RmStok
            $rmStoks = RmStok::where('part_no', $partNo)->get();
            if ($rmStoks->isNotEmpty()) {
                foreach ($rmStoks as $rmStok) {
                    $rmStok->actual_sheet = max(0, $rmStok->actual_sheet - $request->qty_out_sheet);
                    $rmStok->actual_kg = max(0, $rmStok->actual_kg - $request->qty_out_kg);
                    $rmStok->save();
                }
            }

            // Update status ScanInLabel jika ada
            $scanInLabel = ScanInLabel::where('uniqNo', $request->input('uniqNo'))
                ->where('part_no', $partNo)
                ->first();

            if ($scanInLabel) {
                $scanInLabel->status = 2;
                $scanInLabel->out_user = auth()->user()->username;
                $scanInLabel->time_out = now();
                $scanInLabel->save();
            }

            // Update material_out pada LineStoreUpload berdasarkan bulan & tahun sekarang
            $lineStoreUpload = LineStoreUpload::where('part_no', $partNo)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->first();

            if ($lineStoreUpload) {
                $lineStoreUpload->material_out += $request->qty_out_sheet;
                $lineStoreUpload->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan dan kuantitas diupdate.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            // Opsional: bisa log error $e->getMessage() untuk debugging
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
