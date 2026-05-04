<?php

namespace App\Http\Controllers;

use App\Models\TraceAbility;
use Illuminate\Http\Request;
use App\Models\RmStok;
use App\Models\ScanOutRm;
use App\Models\User;
use App\Models\RmInMaterial;
use App\Models\ScanInLabel;
use App\Models\PlanningLineB3;
use App\Models\RmReturnMaterial;
use Carbon\Carbon;
use App\Models\TabelTransitMaterial;
use DB;

class ScanOutRmController extends Controller
{
    public function index()
    {
        $title = 'Scan Out RM';
        return view('scanner2.scanoutrm', compact('title'));
    }

    public function checkIfExists(Request $request)
    {
        $exists = ScanOutRm::where('uniqNo', $request->input('uniqNo'))->where('part_no', $request->input('part_no'))->exists();

        return response()->json(['exists' => $exists]);
    }

    public function checkPartInLine(Request $request)
    {
        $partNo = $request->input('part_no');

        // Cek apakah ada part_no dengan sts = 1 atau NULL
        $exists = DB::table('tabel_transit_materials')
            ->where('part_no', $partNo)
            ->where(function ($query) {
                $query->where('sts', 1)
                      ->orWhereNull('sts');
            })
            ->exists();

        if ($exists) {
            return response()->json([
                'exists' => true,
                'message' => 'Part tersedia di tabel transit (sts = 1 atau null).',
            ]);
        } else {
            return response()->json([
                'exists' => false,
                'message' => 'Part tidak ditemukan di tabel transit.',
            ]);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); // Mulai transaksi

        try {
            $request->validate([
                'part_no' => 'required|string',
                'spec' => 'required|string',
                'supplier' => 'required|string',
                'uniqNo' => 'required|string|nullable',
                'id_data' => 'required|string',
                'id' => 'required|string',
                'qty_out_kg' => 'required|numeric',
                'qty_out_sheet' => 'required|numeric',
            ]);

            $uniqNo = $request->input('uniqNo');

            // ✅ Validasi bahwa uniqNo harus ada di tabel scan_in_labels
            $scanInExists = ScanInLabel::where('uniqNo', $uniqNo)
            ->where('part_no', $request->input('part_no'))
            ->exists();

            if (!$scanInExists) {
                return response()->json([
                    'success' => false,
                    'icon' => 'info', // Atau 'warning', tergantung jenis pesan
                    'message' => 'Belum Melakuakn ScanIN'
                ]); // ← Tidak pakai , 400

            }

            $partNo = $request->input('part_no');
            $mesinPlanning = PlanningLineB3::where('part_no', $partNo)
            ->whereNotNull('mesin')
            ->orderByDesc('created_at')
            ->value('mesin');

            $planningLine = PlanningLineB3::where('part_no', $partNo)
            // ->whereDate('date_plan', now()->toDateString())
            ->first();

        $RmStok = RmStok::where('part_no', $partNo)->first();

        $qty_out_sheet = $request->input('qty_out_sheet');

        // Hitung jumlah part_no yang sama pada tanggal plan yang sama (hari ini)
        $existingCountSameDate = PlanningLineB3::where('part_no', $partNo)
            ->whereDate('date_plan', now()->toDateString())
            ->count();

        // Kalikan 2 hanya jika part_no muncul lebih dari 1 kali pada tanggal yang sama
        $qty_final = $existingCountSameDate > 1 ? $qty_out_sheet * 2 : $qty_out_sheet;


            $forceNew = $request->input('forceNew', false);
            if ($forceNew) {
                $scanOutRm = new ScanOutRm();
                $scanOutRm->part_no = $partNo;
                $scanOutRm->spec = $request->input('spec');
                $scanOutRm->uniqNo = $request->input('uniqNo');
                $scanOutRm->supplier = $request->input('supplier');
                $scanOutRm->id_data = $request->input('id_data');
                $scanOutRm->qty_out_kg = $request->input('qty_out_kg');
                $scanOutRm->qty_out_sheet = $qty_out_sheet;
                $scanOutRm->qty_stamping = $qty_final;
                $scanOutRm->createdby = auth()->user()->username;
                $scanOutRm->updatedby = auth()->user()->username;
                $scanOutRm->sts = 1;
                $scanOutRm->sts_proses = 1;
                $scanOutRm->created_at = now();
                $scanOutRm->save();
            } else {
                $scanOutRm = ScanOutRm::where('uniqNo', $request->input('uniqNo'))
                    ->where('part_no', $partNo)
                    ->whereDate('created_at', now()->toDateString())
                    ->first();

                if (!$scanOutRm) {
                    $scanOutRm = new ScanOutRm();
                    $scanOutRm->part_no = $partNo;
                    $scanOutRm->spec = $request->input('spec');
                    $scanOutRm->uniqNo = $request->input('uniqNo');
                    $scanOutRm->supplier = $request->input('supplier');
                    $scanOutRm->id_data = $request->input('id_data');
                    $scanOutRm->qty_out_kg = $request->input('qty_out_kg');
                    $scanOutRm->qty_out_sheet = $qty_out_sheet;
                    $scanOutRm->qty_stamping = $qty_final;
                    $scanOutRm->sts = 1;
                    $scanOutRm->sts_proses = 1;
                    $scanOutRm->createdby = auth()->user()->username;
                    $scanOutRm->updatedby = auth()->user()->username;
                    $scanOutRm->created_at = now();
                } else {
                    $scanOutRm->qty_out_sheet += $qty_out_sheet;
                    $scanOutRm->qty_out_kg += $request->input('qty_out_kg');
                    $scanOutRm->updatedby = auth()->user()->username;
                }

                $scanOutRm->save();
            }

            // $forceNew = $request->input('forceNew', false);
            if ($forceNew) {
                $TabelTransitMaterial = new TabelTransitMaterial();
                $TabelTransitMaterial->part_no = $partNo;
                $TabelTransitMaterial->spec = $request->input('spec');
                $TabelTransitMaterial->uniqNo = $request->input('uniqNo');
                $TabelTransitMaterial->supplier = $request->input('supplier');
                $TabelTransitMaterial->id_data = $request->input('id_data');
                $TabelTransitMaterial->qty_out_kg = $request->input('qty_out_kg');
                $TabelTransitMaterial->qty_out_sheet = $qty_out_sheet;
                $TabelTransitMaterial->qty_stamping = $qty_final;
                $TabelTransitMaterial->createdby = auth()->user()->username;
                $TabelTransitMaterial->updatedby = auth()->user()->username;
                $TabelTransitMaterial->mesin = $mesinPlanning;
                $TabelTransitMaterial->sts = 1;
                $TabelTransitMaterial->sts_proses = 1;
                $TabelTransitMaterial->created_at = now();
                $TabelTransitMaterial->save();
            } else {
                $TabelTransitMaterial = TabelTransitMaterial::where('uniqNo', $request->input('uniqNo'))
                    ->where('part_no', $partNo)
                    ->whereDate('created_at', now()->toDateString())
                    ->first();

                if (!$TabelTransitMaterial) {
                    $TabelTransitMaterial = new TabelTransitMaterial();
                    $TabelTransitMaterial->part_no = $partNo;
                    $TabelTransitMaterial->spec = $request->input('spec');
                    $TabelTransitMaterial->uniqNo = $request->input('uniqNo');
                    $TabelTransitMaterial->supplier = $request->input('supplier');
                    $TabelTransitMaterial->id_data = $request->input('id_data');
                    $TabelTransitMaterial->qty_out_kg = $request->input('qty_out_kg');
                    $TabelTransitMaterial->qty_out_sheet = $qty_out_sheet;
                    $TabelTransitMaterial->qty_stamping = $qty_final;
                    $TabelTransitMaterial->mesin = $mesinPlanning;
                    $TabelTransitMaterial->sts = 1;
                    $TabelTransitMaterial->sts_proses = 1;
                    $TabelTransitMaterial->createdby = auth()->user()->username;
                    $TabelTransitMaterial->updatedby = auth()->user()->username;
                    $TabelTransitMaterial->created_at = now();
                } else {
                    $TabelTransitMaterial->qty_out_sheet += $qty_out_sheet;
                    $TabelTransitMaterial->qty_out_kg += $request->input('qty_out_kg');
                    $TabelTransitMaterial->updatedby = auth()->user()->username;
                }

                $TabelTransitMaterial->save();
            }


            $inMaterial = RmInMaterial::where('part_no', $partNo)->first();
            if ($inMaterial) {
                $inMaterial->sts_scan = 1;
                $inMaterial->save();
            }

            $RmStokList = RmStok::where('part_no', $partNo)->get();
            if ($RmStokList->count() > 0) {
                $remainingQty = $qty_out_sheet;
                foreach ($RmStokList as $stok) {
                    // Bagi rata ke semua stok jika memungkinkan
                    $stokToDeduct = floor($qty_out_sheet / $RmStokList->count());

                    // Sesuaikan jumlah yang akan dikurangkan jika sisa tidak cukup
                    if ($remainingQty < $stokToDeduct) {
                        $stokToDeduct = $remainingQty;
                    }

                    // Hitung actual_sheet baru dan pastikan tidak negatif
                    $stok->actual_sheet = max(0, $stok->actual_sheet - $stokToDeduct);
                    $stok->save();

                    $remainingQty -= $stokToDeduct;

                    if ($remainingQty <= 0) break;
                }
            }

            $scanInLabel = ScanInLabel::where('uniqNo', $request->input('uniqNo'))
                ->where('part_no', $partNo)
                ->first();

            if ($scanInLabel) {
                $scanInLabel->status = 1;
                $scanInLabel->out_user = auth()->user()->username;
                $scanInLabel->time_out = now();
                $scanInLabel->save();
            }

            DB::table('tabel_transit_materials')
            ->where('uniqNo', $request->input('uniqNo'))
            ->update(['rm_out' => auth()->user()->username]);



            /////Batas

            $partNo = $request->input('part_no');
            $shiftTarget = $request->input('shift_target');
            $qty_out_sheet = $request->input('qty_out_sheet');

            // Hitung range waktu shift
            $now = Carbon::now();
            if ($now->hour < 7) {
                $startTime = Carbon::yesterday()->setHour(7)->setMinute(0)->setSecond(0);
                $endTime   = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
            } else {
                $startTime = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
                $endTime   = Carbon::tomorrow()->setHour(7)->setMinute(0)->setSecond(0);
            }
        // Ambil semua baris part_no sesuai shift dan tanggal
                $allLines = PlanningLineB3::where('part_no', $partNo)
                ->where('shift', $shiftTarget)
                ->whereBetween('created_at', [$startTime, $endTime])
                ->where(function ($query) {
                    $query->whereNull('status_proses')
                        ->orWhere('status_proses', '!=', 3);
                })
                ->get();

                // Default target = kosong
                $lineTargets = [];

                // Cek ada mesin_category 1 dan 2
                $hasLine1 = $allLines->contains('mesin_category', 1);
                $hasLine2 = $allLines->contains('mesin_category', 2);

                if ($hasLine1 && $hasLine2) {
                // Kalau ada keduanya, pilih 1 dan 2
                $lineTargets = [1, 2];
                } elseif ($hasLine1) {
                $lineTargets = [1];
                } elseif ($hasLine2) {
                $lineTargets = [2];
                }

                // Filter lagi sesuai mesin_category target (bisa lebih dari satu)
                $planningLines = $allLines->whereIn('mesin_category', $lineTargets);

                if ($planningLines->isEmpty()) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Data has been saved, but not recorded in planning_line_b3s because part_no was not found'
                ]);
                }


            // Proses update slot RM
            foreach ($planningLines as $PlanningLineB3) {
                $PlanningLineB3->qty_out_material += $qty_out_sheet;

                if ($PlanningLineB3->qty_out_material > 0) {

                    if (!($PlanningLineB3->status == 2 && $PlanningLineB3->status_proses == 2)){
                        $PlanningLineB3->status = 1;
                        $PlanningLineB3->status_proses = 1;
                    }
                }


            if (empty($PlanningLineB3->rm_qty) && empty($PlanningLineB3->rm_partNo) && empty($PlanningLineB3->rm_spek)) {
                $PlanningLineB3->rm_qty = $qty_out_sheet;
                $PlanningLineB3->rm_qty_kode = $qty_out_sheet;
                $PlanningLineB3->rm_partNo = $partNo;
                $PlanningLineB3->rm_spek = $request->input('spec');
                $PlanningLineB3->rm_supplier = $request->input('supplier');
                $PlanningLineB3->rm_uniqNo = $request->input('uniqNo');
                $PlanningLineB3->rm_user = auth()->user()->username;
                $PlanningLineB3->rm_time = now();
            } else if (empty($PlanningLineB3->rm_qty2) && empty($PlanningLineB3->rm_partNo2) && empty($PlanningLineB3->rm_spek2)) {
                $PlanningLineB3->rm_qty2 = $qty_out_sheet;
                $PlanningLineB3->rm_qty_kode2 = $qty_out_sheet;
                $PlanningLineB3->rm_partNo2 = $partNo;
                $PlanningLineB3->rm_spek2 = $request->input('spec');
                $PlanningLineB3->rm_supplier2 = $request->input('supplier');
                $PlanningLineB3->rm_uniqNo2 = $request->input('uniqNo');
                $PlanningLineB3->rm_user2 = auth()->user()->username;
                $PlanningLineB3->rm_time2 = now();
            } else if (empty($PlanningLineB3->rm_qty3) && empty($PlanningLineB3->rm_partNo3) && empty($PlanningLineB3->rm_spek3)) {
                $PlanningLineB3->rm_qty3 = $qty_out_sheet;
                $PlanningLineB3->rm_qty_kode3 = $qty_out_sheet;
                $PlanningLineB3->rm_partNo3 = $partNo;
                $PlanningLineB3->rm_spek3 = $request->input('spec');
                $PlanningLineB3->rm_supplier3 = $request->input('supplier');
                $PlanningLineB3->rm_uniqNo3 = $request->input('uniqNo');
                $PlanningLineB3->rm_user3 = auth()->user()->username;
                $PlanningLineB3->rm_time3 = now();
            } else if (empty($PlanningLineB3->rm_qty4) && empty($PlanningLineB3->rm_partNo4) && empty($PlanningLineB3->rm_spek4)) {
                $PlanningLineB3->rm_qty4 = $qty_out_sheet;
                $PlanningLineB3->rm_qty_kode4 = $qty_out_sheet;
                $PlanningLineB3->rm_partNo4 = $partNo;
                $PlanningLineB3->rm_spek4 = $request->input('spec');
                $PlanningLineB3->rm_supplier4 = $request->input('supplier');
                $PlanningLineB3->rm_uniqNo4 = $request->input('uniqNo');
                $PlanningLineB3->rm_user4 = auth()->user()->username;
                $PlanningLineB3->rm_time4 = now();
            } else if (empty($PlanningLineB3->rm_qty5) && empty($PlanningLineB3->rm_partNo5) && empty($PlanningLineB3->rm_spek5)) {
                $PlanningLineB3->rm_qty5 = $qty_out_sheet;
                $PlanningLineB3->rm_qty_kode5 = $qty_out_sheet;
                $PlanningLineB3->rm_partNo5 = $partNo;
                $PlanningLineB3->rm_spek5 = $request->input('spec');
                $PlanningLineB3->rm_supplier5 = $request->input('supplier');
                $PlanningLineB3->rm_uniqNo5 = $request->input('uniqNo');
                $PlanningLineB3->rm_user5 = auth()->user()->username;
                $PlanningLineB3->rm_time5 = now();
            }
            else {
                continue;
            }

            $PlanningLineB3->save();
        }

        DB::commit();
        return response()->json(['success' => true, 'message' => 'Data has been saved and quantity updated successfully']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
  }

}
