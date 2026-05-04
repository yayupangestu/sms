<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScanPartBps;
use App\Models\ScanOutStmp;
use App\Models\LineStoreStok;
use App\Models\TagLabelSubcont;
use App\Models\TabelStokSbc;
class ScanBpsPartController extends Controller
{
    public function index()
    {
        $title = 'Scan Welding Part Ambil';

        return view('linestore.scanpart', compact('title'));
    }

    public function storeBatch(Request $request)
    {
        $datas = $request->input('data');

        if (!$datas || !is_array($datas)) {
            return response()->json(['success' => false, 'message' => 'Invalid data format']);
        }

        foreach ($datas as $data) {
            if (!isset($data['uniqNo'], $data['job_no'], $data['part_no'], $data['model'], $data['qty'], $data['additional_qty'])) {
                continue; // Skip if data is incomplete
            }

            // Insert new record
            ScanPartBps::create([
                'uniqNo' => $data['uniqNo'],
                'job_no' => $data['job_no'],
                'part_no2' => $data['part_no'],
                'model' => $data['model'],
                'qty' => $data['qty'],
                'additional_qty' => $data['additional_qty'],
                'date_scan' => now(),
            ]);

            // Update line_store_stoks
            // Update line_store_stoks pakai part_no dari hasil scan
            $lineStoreStoks = LineStoreStok::where('job_no', $data['job_no'])->get();

            if ($lineStoreStoks->isNotEmpty()) {
                foreach ($lineStoreStoks as $stok) {
                    $stok->qty_actual -= (int) $data['additional_qty'];
                    $stok->save();
                }
            }
            $TabelStokSbc = TabelStokSbc::where('job_no', $data['job_no'])->get();

            if ($TabelStokSbc->isNotEmpty()) {
                foreach ($TabelStokSbc as $stok) {
                    $stok->qty_act_ls -= (int) $data['additional_qty'];
                    $stok->save();
                }
            }

            $ScanOutStmp = ScanOutStmp::where('part_no2', $data['part_no'])
                ->where('uniqNo', $data['uniqNo'])
                ->get();

            if ($ScanOutStmp->isNotEmpty()) {
                foreach ($ScanOutStmp as $stok) {
                    $stok->qty_act -= (int) $data['additional_qty'];
                    $stok->save();
                }
            }

            $TagLabelSbc = TagLabelSubcont::where('job_no', $data['job_no'])
                ->where('uniqNo', $data['uniqNo'])
                ->get();
            if ($TagLabelSbc->isNotEmpty()) {
                foreach ($TagLabelSbc as $stok) {
                    $stok->qty_act -= (int) $data['additional_qty'];
                    $stok->sts = 2;
                    $stok->save();
                }
            }


        }

        return response()->json(['success' => true]);
    }

    // app/Http/Controllers/YourController.php
// app/Http/Controllers/YourController.php
    public function getQtyActStmp(Request $request)
    {
        $uniqNo = $request->uniqNo;
        $partNo = $request->part_no;

        // =============================================
        // 🔹 Cek di tabel ScanOutStmp (format QR 10 data)
        // =============================================
        $scanOut = ScanOutStmp::where('uniqNo', $uniqNo)
            ->where('part_no2', $partNo)
            ->first();

        if ($scanOut) {

            // 🔍 Validasi sts_ls = 1 (HANYA untuk ScanOutStmp)
            if ($scanOut->status_ls != 1) {
                return response()->json([
                    'success' => false,
                    'source' => 'ScanOutStmp',
                    'message' => 'Status LS tidak valid. sts_ls harus bernilai 1.'
                ]);
            }

            return response()->json([
                'success' => true,
                'source' => 'ScanOutStmp',
                'qty_act' => $scanOut->qty_act
            ]);
        }

        // =============================================
        // 🔹 Jika tidak ditemukan, cek di TagLabelSubcont
        //    (TIDAK ADA VALIDASI sts_ls)
        // =============================================
        $tagLabel = TagLabelSubcont::where('uniqNo', $uniqNo)
            ->where('part_no2', $partNo)
            ->first();

        if ($tagLabel) {
            return response()->json([
                'success' => true,
                'source' => 'TagLabelSubcont',
                'qty_act' => $tagLabel->qty_act
            ]);
        }

        // =============================================
        // 🔹 Jika dua tabel tidak ditemukan
        // =============================================
        return response()->json([
            'success' => false,
            'message' => 'Data not found in both tables'
        ]);
    }







}
