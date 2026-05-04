<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TraceAbility;
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use App\Models\RmInMaterial;
use App\Models\DataModel;
use App\Models\RmStok;
use App\Models\PlanningLineB3;
use App\Models\RmReturnMaterial;
use App\Models\TraceProses2;
use App\Models\ScanInLabel;
use App\Models\ScanOutRm;
use App\Models\TabelTransitMaterial;
use Carbon\Carbon;
use DB;

class ScanInStmpController extends Controller
{
    public function index()
    {
        $title = 'Scan1';
        return view('scanner2.scaninstmp', compact('title'));
    }

    public function checkPartNoPlanning(Request $request)
    {
        $partNo = $request->part_no;
        $today = now()->toDateString();

        $data = \App\Models\PlanningLineB3::where('part_no', $partNo)
            ->whereDate('date_plan', $today)
            ->whereIn('status_proses', [1, 2])
            ->get(['part_no2', 'date_plan', 'mesin', 'status_proses']);

        return response()->json([
            'exists' => $data->isNotEmpty(),
            'data' => $data
        ]);
    }

    public function getQtyStamping(Request $request)
    {
        $uniqNo = $request->uniqNo;

        $dataTransit = TabelTransitMaterial::where('uniqNo', $uniqNo)->first();

        if (!$dataTransit) {
            return response()->json([
                'success' => false,
                'qty_stamping' => null,
                'partNo2List' => [],
                'message' => 'Data tidak ditemukan di tabel transit.',
            ], 404);
        }

        $partNo = $dataTransit->part_no ?? null;

        $partNo2List = PlanningLineB3::select('part_no2', 'mesin')
            ->where('part_no', $partNo)
            ->whereDate('date_plan', now())
            ->whereIn('status_proses', [1, 2])
            ->whereNotNull('part_no2')
            ->get();

        return response()->json([
            'success' => true,
            'qty_stamping' => $dataTransit->qty_stamping,
            'partNo2List' => $partNo2List,
        ]);
    }

    public function checkUniqNoUsed(Request $request)
{
    $uniqNo = $request->uniqNo;

    $exists = \App\Models\PlanningLineB3::where(function ($q) use ($uniqNo) {
        $q->where('stmp_in_uniqNo', $uniqNo)
          ->orWhere('stmp_in_uniqNo2', $uniqNo)
          ->orWhere('stmp_in_uniqNo3', $uniqNo)
          ->orWhere('stmp_in_uniqNo4', $uniqNo)
          ->orWhere('stmp_in_uniqNo5', $uniqNo);
    })->exists();

    return response()->json(['exists' => $exists]);
}

public function store2(Request $request)
{
    $request->validate([
        'part_no' => 'required|string',
        'spec' => 'required|string',
        'supplier' => 'required|string',
        'uniqNo' => 'required|string',
        'id_data' => 'required|string',
        'qty_out_kg' => 'required|string',
        'qty_out_sheet' => 'required|numeric',
    ]);

    $partNo  = $request->input('part_no');
    $uniqNo  = $request->input('uniqNo');

    // ✅ tambahan: part_no2 hasil pilihan popup
    $selectedPartNo2 = $request->input('selected_part_no2'); // array | null
    $isSprating = is_array($selectedPartNo2) && in_array('SPRATING', $selectedPartNo2);


    if (!empty($selectedPartNo2) && !is_array($selectedPartNo2)) {
        return response()->json([
            'success' => false,
            'message' => 'Format selected_part_no2 tidak valid'
        ]);
    }

    // ✅ Cari part di kedua kolom (part_no atau part_no2)
    $scannedPart = PlanningLineB3::where(function ($query) use ($partNo) {
        $query->where('part_no', $partNo)
              ->orWhere('part_no2', $partNo);
    })->first();

    if (!$scannedPart) {
        return response()->json([
            'success' => false,
            'icon' => 'error',
            'message' => "Data part tidak ditemukan di kolom part_no maupun part_no2 untuk: {$partNo}",
        ]);
    }

    $mesinPart = $scannedPart->mesin;
    $mesins = ['LINE B3', 'LINE C1', 'LINE C2'];

    $activeProcess = PlanningLineB3::where('status_proses', 2)
        ->whereDate('date_plan', now()->toDateString())
        ->whereIn('mesin', $mesins)
        ->first();

    if ($activeProcess && $activeProcess->mesin === $mesinPart && $activeProcess->part_no !== $partNo) {
        return response()->json([
            'success' => false,
            'icon' => 'info',
            'message' => 'Sedang proses part: ' . $activeProcess->part_no . ' di ' . $activeProcess->mesin . '. Selesaikan terlebih dahulu.',
        ]);
    }

    DB::beginTransaction();
    try {

        // ✅ Update waktu scan stamping
        $ScanOutRm = ScanOutRm::where('uniqNo', $uniqNo)->first();
        if ($ScanOutRm) {
            $ScanOutRm->scan_stmp_time = now();
            $ScanOutRm->scan_stmp_user = auth()->user()->username;
            $ScanOutRm->save();
        }

        // ✅ Cek data di tabel transit
        $scanOutCheck = TabelTransitMaterial::where('uniqNo', $uniqNo)->first();

        if (!$scanOutCheck) {
            return response()->json([
                'success' => false,
                'icon' => 'warning',
                'message' => 'Material Belum di Scan Out',
            ]);
        }

        if ($scanOutCheck->sts == 2) {
            return response()->json([
                'success' => false,
                'icon' => 'info',
                'message' => 'RM ini sudah di-scan in stamping.',
            ]);
        }

        if ($scanOutCheck->sts != 1) {
            return response()->json([
                'success' => false,
                'icon' => 'warning',
                'message' => 'RM belum melakukan ScanOut.',
            ]);
        }

        // ✅ Tentukan shift
        $now = Carbon::now();
        $shiftNow = ($now->between($now->copy()->setTime(7, 0), $now->copy()->setTime(20, 0))) ? 1 : 2;

        // ✅ Ambil tanggal planning terakhir
        $latestDate = PlanningLineB3::where(function ($q) use ($partNo) {
            $q->where('part_no', $partNo)
              ->orWhere('part_no2', $partNo);
        })->max('created_at');

        // ✅ Ambil planning sesuai pilihan part_no2 (INI YANG DIPERBAIKI)
        $planningLines = PlanningLineB3::where(function ($q) use ($partNo) {
                $q->where('part_no', $partNo)
                  ->orWhere('part_no2', $partNo);
            })
            ->when(!$isSprating && !empty($selectedPartNo2), function ($q) use ($selectedPartNo2) {
                $q->whereIn('part_no2', $selectedPartNo2);
            })

            ->where('shift', $shiftNow)
            ->whereDate('created_at', Carbon::parse($latestDate)->toDateString())
            ->get();

        if ($planningLines->isEmpty()) {
            return response()->json([
                'success' => false,
                'icon' => 'warning',
                'message' => "Data Planning tidak ditemukan untuk part_no {$partNo}.",
            ]);
        }

        $scanOutData = $scanOutCheck;
        $countTarget = $planningLines->count();
        $qtyOut = str_starts_with($scanOutData->uniqNo, 'BP')
            ? intval($scanOutData->qty_stamping)
            : ($countTarget == 2 ? intval($scanOutData->qty_stamping / 2) : intval($scanOutData->qty_stamping));

        // ================= RM KE SLOT & STAMPING IN =================
        foreach ($planningLines as $planningLine) {
            // --- RM KE SLOT MATERIAL ---
            if ($planningLine->mesin_category == 1) {
                if (!in_array($scanOutData->uniqNo, [
                    $planningLine->rm_uniqNo,
                    $planningLine->rm_uniqNo2,
                    $planningLine->rm_uniqNo3,
                    $planningLine->rm_uniqNo4
                ])) {
                    if (is_null($planningLine->rm_uniqNo)) {
                        $planningLine->rm_uniqNo = $scanOutData->uniqNo;
                        $planningLine->rm_partNo = $scanOutData->part_no;
                        $planningLine->rm_spek = $scanOutData->spec;
                        $planningLine->rm_supplier = $scanOutData->supplier;
                        $planningLine->rm_qty = $scanOutData->qty_stamping;
                        $planningLine->rm_user = $scanOutData->createdby;
                        $planningLine->rm_time = $scanOutData->created_at;
                    } elseif (is_null($planningLine->rm_uniqNo2)) {
                        $planningLine->rm_uniqNo2 = $scanOutData->uniqNo;
                        $planningLine->rm_partNo2 = $scanOutData->part_no;
                        $planningLine->rm_spek2 = $scanOutData->spec;
                        $planningLine->rm_supplier2 = $scanOutData->supplier;
                        $planningLine->rm_qty2 = $scanOutData->qty_stamping;
                        $planningLine->rm_user2 = $scanOutData->createdby;
                        $planningLine->rm_time2 = $scanOutData->created_at;
                    }
                }
            }

            // --- STAMPING IN ---
            // ================= SLOT 1 =================
            if (is_null($planningLine->stmp_in_qty)) {
                $planningLine->stmp_in_qty = $request->qty_out_sheet;
                $planningLine->stmp_in_partNo = $planningLine->part_no;
                $planningLine->stmp_in_spek = $request->spec;
                $planningLine->stmp_in_supplier = $request->supplier;
                $planningLine->stmp_in_uniqNo = $uniqNo;
                $planningLine->stmp_in_user = auth()->user()->username;
                $planningLine->stmp_in_time = now();

            // ================= SLOT 2 =================
            } elseif (is_null($planningLine->stmp_in_qty2)) {
                $planningLine->stmp_in_qty2 = $request->qty_out_sheet;
                $planningLine->stmp_in_partNo2 = $isSprating ? $planningLine->part_no : $planningLine->part_no2;
                $planningLine->stmp_in_spek2 = $request->spec;
                $planningLine->stmp_in_supplier2 = $request->supplier;
                $planningLine->stmp_in_uniqNo2 = $uniqNo;
                $planningLine->stmp_in_user2 = auth()->user()->username;
                $planningLine->stmp_in_time2 = now();

            // ================= SLOT 3 =================
            } elseif (is_null($planningLine->stmp_in_qty3)) {
                $planningLine->stmp_in_qty3 = $request->qty_out_sheet;
                $planningLine->stmp_in_partNo3 = $isSprating ? $planningLine->part_no : $planningLine->part_no3;
                $planningLine->stmp_in_spek3 = $request->spec;
                $planningLine->stmp_in_supplier3 = $request->supplier;
                $planningLine->stmp_in_uniqNo3 = $uniqNo;
                $planningLine->stmp_in_user3 = auth()->user()->username;
                $planningLine->stmp_in_time3 = now();

            // ================= SLOT 4 =================
            } elseif (is_null($planningLine->stmp_in_qty4)) {
                $planningLine->stmp_in_qty4 = $request->qty_out_sheet;
                $planningLine->stmp_in_partNo4 = $isSprating ? $planningLine->part_no : $planningLine->part_no4;
                $planningLine->stmp_in_spek4 = $request->spec;
                $planningLine->stmp_in_supplier4 = $request->supplier;
                $planningLine->stmp_in_uniqNo4 = $uniqNo;
                $planningLine->stmp_in_user4 = auth()->user()->username;
                $planningLine->stmp_in_time4 = now();

            // ================= SLOT 5 =================
            } elseif (is_null($planningLine->stmp_in_qty5)) {
                $planningLine->stmp_in_qty5 = $request->qty_out_sheet;
                $planningLine->stmp_in_partNo5 = $isSprating ? $planningLine->part_no : $planningLine->part_no5;
                $planningLine->stmp_in_spek5 = $request->spec;
                $planningLine->stmp_in_supplier5 = $request->supplier;
                $planningLine->stmp_in_uniqNo5 = $uniqNo;
                $planningLine->stmp_in_user5 = auth()->user()->username;
                $planningLine->stmp_in_time5 = now();
            } else {
                throw new \Exception('Slot material sudah penuh (maksimal 5)');
            }

            // Update Qty and Status
            $planningLine->qty_in_material = ($planningLine->qty_in_material ?? 0) + $request->qty_out_sheet;
            $planningLine->qty_out_material = ($planningLine->qty_out_material ?? 0) + $qtyOut;
            $planningLine->status = 2;
            $planningLine->status_proses = 2;
            $planningLine->save();

            // Jika bukan SPRATING, hanya update baris pertama yang ditemukan
            if (!$isSprating) {
                break;
            }
        }

        // ✅ Update status transit
        TabelTransitMaterial::where('uniqNo', $uniqNo)->update(['sts_proses' => 2]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => $isSprating
                ? 'Scan berhasil (SPRATING) '
                : 'Scan berhasil',
        ]);


    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 400);
    }
}



}
