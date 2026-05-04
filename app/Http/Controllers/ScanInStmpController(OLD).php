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

        $partNo = $request->input('part_no');

        // Ambil data part yang sedang discan
        $scannedPart = PlanningLineB3::where('part_no', $partNo)
            // ->whereDate('date_plan', now()->toDateString())
            ->first();

        if (!$scannedPart) {
            return response()->json([
                'success' => false,
                'icon' => 'error',
                'message' => 'Data part tidak ditemukan pada tanggal hari ini.',
            ]);
        }

        $mesinPart = $scannedPart->mesin;
        $mesinPart = $scannedPart->mesin;

        // Daftar mesin yang perlu divalidasi
        $mesins = ['LINE B3', 'LINE C1', 'LINE C2'];

        // Cek apakah sedang ada proses aktif (status_proses = 2) di salah satu mesin
        $activeProcess = PlanningLineB3::where('status_proses', 2)
            ->whereDate('date_plan', now()->toDateString())
            ->whereIn('mesin', $mesins)
            ->first();

        if ($activeProcess) {
            // Jika mesin sama
            if ($activeProcess->mesin === $mesinPart) {
                // Jika part_no juga sama → scan lanjutan → diterima
                if ($activeProcess->part_no === $partNo) {
                    // lanjut proses scan lanjutan
                } else {
                    // mesin sama tapi part_no beda → tolak
                    return response()->json([
                        'success' => false,
                        'icon' => 'info',
                        'message' => 'Sedang proses part: ' . $activeProcess->part_no . ' di ' . $activeProcess->mesin . '. Selesaikan terlebih dahulu.',
                    ]);
                }
            }
        }
        DB::beginTransaction();

        try {
            $ScanOutRm = ScanOutRm::where('uniqNo', $request->input('uniqNo'))->first();
            if ($ScanOutRm) {
                $ScanOutRm->scan_stmp_time = now();
                $ScanOutRm->scan_stmp_user = auth()->user()->username;
                $ScanOutRm->save();
            }

            $now = Carbon::now();

            // Tentukan waktu shift: 01:00 hari ini sampai 07:00 besok
            if ($now->hour < 7) {
                // Shift masih termasuk hari sebelumnya
                $startTime = Carbon::yesterday()->setHour(7)->setMinute(0)->setSecond(0);
                $endTime = Carbon::today()->setHour(7)->setMinute(30)->setSecond(0); // batas 07:30
            } else {
                // Hari produksi berjalan normal
                $startTime = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
                $endTime = Carbon::tomorrow()->setHour(7)->setMinute(30)->setSecond(0); // batas 07:30
            }

            // Cek apakah uniqNo dan part_no pernah discan sebelumnya sebelum hari ini dengan status = 1
            $previousScan = PlanningLineB3::where(function ($query) use ($request) {
                $query->where('rm_uniqNo', $request->input('uniqNo'))->orWhere('rm_uniqNo2', $request->input('uniqNo'))->orWhere('rm_uniqNo3', $request->input('uniqNo'))->orWhere('rm_uniqNo4', $request->input('uniqNo'));
            })
                ->where('part_no', $request->input('part_no'))
                ->first();

            $partNo = $request->input('part_no');
            $uniqNo = $request->input('uniqNo');

            // ✅ Cek apakah RM dengan uniqNo sudah melakukan ScanOut di tabel `scan_out_rms`
            $scanOutCheck = DB::table('tabel_transit_materials')->where('uniqNo', $uniqNo)->first();

            if (!$scanOutCheck) {
                return response()->json([
                    'success' => false,
                    'icon' => 'warning',
                    'message' => 'Material Belum di Scan Out',
                ]);
            }

            // Tambahkan pengecekan sts
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

            $partNo = $request->input('part_no');

            $now = Carbon::now();

            // 🔹 Shift logic tetap, tapi shiftDate jangan pakai subDay()
            if ($now->between($now->copy()->setTime(7, 0), $now->copy()->setTime(20, 0))) {
                // Shift 1: jam 07:00 – 20:00 → created_at hari ini
                $shiftNow = 1;
                $shiftDate = $now->toDateString();
            } else {
                // Shift 2: jam 20:00 – 07:00 → tetap created_at hari ini
                $shiftNow = 2;
                $shiftDate = $now->toDateString(); // ✅ bukan subDay()
            }

            $latestDate = PlanningLineB3::where('part_no', $partNo)->max('created_at');

            $selectedPartNo2 = $request->input('selectedPartNo2', []); // array part_no2 terpilih

            $query = PlanningLineB3::where('part_no', $partNo)
                ->where('shift', $shiftNow)
                ->whereDate('created_at', Carbon::parse($latestDate)->toDateString());

            if (!empty($selectedPartNo2)) {
                $query->whereIn('part_no2', $selectedPartNo2);
            }

            $planningLines = $query->get();

            if ($planningLines->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'icon' => 'warning',
                    'message' => 'Data Planning tidak ditemukan',
                ]);
            }

            // Ambil data scan_out berdasarkan uniqNo
            $scanOutData = TabelTransitMaterial::where('uniqNo', $uniqNo)
                ->whereIn('sts', [1, 2])
                ->first();

            if ($scanOutData) {
                // Ambil semua PlanningLineB3 dengan part_no sama, shift sama, mesin_category = 1, dan rm_uniqNo* masih null
                $targetRows = PlanningLineB3::where('part_no', $scanOutData->part_no)
                    ->where('shift', $shiftNow)
                    ->where('mesin_category', 1)
                    ->where(function ($query) {
                        $query->whereNull('rm_uniqNo')->orWhereNull('rm_uniqNo2')->orWhereNull('rm_uniqNo3')->orWhereNull('rm_uniqNo4');
                    })
                    ->get();

                $isStsProses2Null = is_null($scanOutData->sts_proses2);
                $countTarget = $targetRows->count();

                // Tentukan qty yang keluar, jika uniqNo diawali B maka jangan dibagi 2
                $qtyOut = str_starts_with($scanOutData->uniqNo, 'B') || !($countTarget == 2 && $isStsProses2Null) ? intval($scanOutData->qty_stamping) : intval($scanOutData->qty_stamping / 2);

                foreach ($targetRows as $targetRow) {
                    // Cek jika uniqNo sudah masuk
                    if (in_array($scanOutData->uniqNo, [$targetRow->rm_uniqNo, $targetRow->rm_uniqNo2, $targetRow->rm_uniqNo3, $targetRow->rm_uniqNo4])) {
                        continue;
                    }

                    // Masukkan uniqNo ke slot kosong pertama
                    if (is_null($targetRow->rm_uniqNo)) {
                        $targetRow->rm_uniqNo = $scanOutData->uniqNo;
                        $targetRow->rm_partNo = $scanOutData->part_no;
                        $targetRow->rm_spek = $scanOutData->spec;
                        $targetRow->rm_supplier = $scanOutData->supplier;
                        $targetRow->rm_qty = $scanOutData->qty_stamping;
                        $targetRow->rm_qty_kode = $scanOutData->qty_stamping;
                        $targetRow->rm_user = $scanOutData->createdby;
                        $targetRow->rm_time = $scanOutData->created_at;
                    } elseif (is_null($targetRow->rm_uniqNo2)) {
                        $targetRow->rm_uniqNo2 = $scanOutData->uniqNo;
                        $targetRow->rm_partNo2 = $scanOutData->part_no;
                        $targetRow->rm_spek2 = $scanOutData->spec;
                        $targetRow->rm_supplier2 = $scanOutData->supplier;
                        $targetRow->rm_qty2 = $scanOutData->qty_stamping;
                        $targetRow->rm_qty_kode2 = $scanOutData->qty_stamping;
                        $targetRow->rm_user2 = $scanOutData->createdby;
                        $targetRow->rm_time2 = $scanOutData->created_at;
                    } elseif (is_null($targetRow->rm_uniqNo3)) {
                        $targetRow->rm_uniqNo3 = $scanOutData->uniqNo;
                        $targetRow->rm_partNo3 = $scanOutData->part_no;
                        $targetRow->rm_spek3 = $scanOutData->spec;
                        $targetRow->rm_supplier3 = $scanOutData->supplier;
                        $targetRow->rm_qty3 = $scanOutData->qty_stamping;
                        $targetRow->rm_qty_kode3 = $scanOutData->qty_stamping;
                        $targetRow->rm_user3 = $scanOutData->createdby;
                        $targetRow->rm_time3 = $scanOutData->created_at;
                    } elseif (is_null($targetRow->rm_uniqNo4)) {
                        $targetRow->rm_uniqNo4 = $scanOutData->uniqNo;
                        $targetRow->rm_partNo4 = $scanOutData->part_no;
                        $targetRow->rm_spek4 = $scanOutData->spec;
                        $targetRow->rm_supplier4 = $scanOutData->supplier;
                        $targetRow->rm_qty4 = $scanOutData->qty_stamping;
                        $targetRow->rm_qty_kode4 = $scanOutData->qty_stamping;
                        $targetRow->rm_user4 = $scanOutData->createdby;
                        $targetRow->rm_time4 = $scanOutData->created_at;
                    } else {
                        continue;
                    }

                    // Update qty_out_material & status hanya jika uniqNo bukan diawali B
                    if (!str_starts_with($scanOutData->uniqNo, 'B')) {
                        $targetRow->qty_out_material = ($targetRow->qty_out_material ?? 0) + $qtyOut;
                        $targetRow->status = 2;
                        $targetRow->status_proses = 2;
                    }

                    $targetRow->save();
                }

                // Update status proses scan_out
                TabelTransitMaterial::where('uniqNo', $uniqNo)->update([
                    'sts_proses' => 2,
                ]);
            }

                    // Ambil tanggal terbaru untuk part_no yang discan
            $latestDate = PlanningLineB3::where('part_no', $request->part_no)
            ->max('created_at');

            // Cek apakah uniqNo sudah pernah dipakai untuk part_no yang sama
            $existingScan = PlanningLineB3::where(function ($query) use ($uniqNo) {
                $query->where('stmp_in_uniqNo', $uniqNo)
                    ->orWhere('stmp_in_uniqNo2', $uniqNo)
                    ->orWhere('stmp_in_uniqNo3', $uniqNo)
                    ->orWhere('stmp_in_uniqNo4', $uniqNo);
            })
            ->where('part_no', $request->part_no) // ✅ cek hanya di part_no sama
            ->whereDate('created_at', Carbon::parse($latestDate)->toDateString())
            ->first();

            if ($existingScan) {
            throw new \Exception('Material dengan uniqNo ini sudah pernah discan pada part_no yang sama. Tidak dapat scan ulang.');
            }

            // ✅ Kalau sampai sini berarti uniqNo belum pernah dipakai untuk part_no sama → lanjut proses


            $latestDate = PlanningLineB3::where('part_no', $scanOutData->part_no)->max('created_at');

            $planningLines = PlanningLineB3::where('mesin_category', 1)
                ->where('shift', $shiftNow)
                ->where('part_no', $scanOutData->part_no)
                ->whereDate('created_at', Carbon::parse($latestDate)->toDateString()) // pakai latest date, bukan hari ini
                ->get();



            foreach ($planningLines as $planningLine) {

                if($planningLine->status_proses == 3) {
                    continue;
                }


                $lineName = $planningLine->mesin;

                $hasSamePartInOtherLine = false;
                $otherLine = null;

                if ($lineName === 'LINE C1') {
                    $otherLine = 'LINE C2';
                } elseif ($lineName === 'LINE C2') {
                    $otherLine = 'LINE C1';
                }

                if ($otherLine) {
                    $hasSamePartInOtherLine = PlanningLineB3::where('part_no', $planningLine->part_no)
                        ->where('mesin', $otherLine)
                        ->where('shift', $shiftNow)
                        ->whereDate('created_at', $planningLine->created_at->toDateString())
                        ->where('mesin_category', 1)
                        ->exists();
                }

                // Hitung jumlah part_no (masih oke karena ada where part_no)
                $countPartNo = PlanningLineB3::where('part_no', $planningLine->part_no)
                    ->where('shift', $shiftNow)
                    ->whereDate('created_at', $planningLine->created_at->toDateString())
                    ->where('mesin_category', 1)
                    ->count();

                // Tentukan qtyIn
                $qtyIn = str_starts_with($scanOutData->uniqNo, 'B') ? intval($scanOutData->qty_stamping) : ($countPartNo == 2 ? intval($scanOutData->qty_stamping / 2) : intval($scanOutData->qty_stamping));

                $planningLine->qty_in_material += $qtyIn;

                if ($lineName === 'LINE C1') {
                    $planningLine->status = 2;
                    $planningLine->status_proses = 2;
                } elseif ($lineName === 'LINE C2' && $hasSamePartInOtherLine) {
                    $planningLine->status_proses = 7;
                } else {
                    $planningLine->status = 2;
                    $planningLine->status_proses = 2;
                }

                if (is_null($planningLine->time_startProses)) {
                    $planningLine->time_startProses = now();
                }

                if ($planningLine->qty_in_material >= $planningLine->qty_plan) {
                    $planningLine->status2 = $planningLine->qty_in_material == $planningLine->qty_plan ? 3 : 4;
                }

                // Handle pengisian kolom stmp_in_* secara berurutan
                if (empty($planningLine->stmp_in_qty)) {
                    $planningLine->stmp_in_qty = $request->input('qty_out_sheet');
                    $planningLine->stmp_in_partNo = $request->input('part_no');
                    $planningLine->stmp_in_spek = $request->input('spec');
                    $planningLine->stmp_in_supplier = $request->input('supplier');
                    $planningLine->stmp_in_uniqNo = $request->input('uniqNo');
                    $planningLine->stmp_in_user = auth()->user()->username;
                    $planningLine->stmp_in_leader_line = auth()->user()->line_id;
                    $planningLine->stmp_in_time = now();
                } elseif (empty($planningLine->stmp_in_qty2)) {
                    $planningLine->stmp_in_qty2 = $request->input('qty_out_sheet');
                    $planningLine->stmp_in_partNo2 = $request->input('part_no');
                    $planningLine->stmp_in_spek2 = $request->input('spec');
                    $planningLine->stmp_in_supplier2 = $request->input('supplier');
                    $planningLine->stmp_in_uniqNo2 = $request->input('uniqNo');
                    $planningLine->stmp_in_user2 = auth()->user()->username;
                    $planningLine->stmp_in_leader_line2 = auth()->user()->line_id;
                    $planningLine->stmp_in_time2 = now();
                } elseif (empty($planningLine->stmp_in_qty3)) {
                    $planningLine->stmp_in_qty3 = $request->input('qty_out_sheet');
                    $planningLine->stmp_in_partNo3 = $request->input('part_no');
                    $planningLine->stmp_in_spek3 = $request->input('spec');
                    $planningLine->stmp_in_supplier3 = $request->input('supplier');
                    $planningLine->stmp_in_uniqNo3 = $request->input('uniqNo');
                    $planningLine->stmp_in_user3 = auth()->user()->username;
                    $planningLine->stmp_in_leader_line3 = auth()->user()->line_id;
                    $planningLine->stmp_in_time3 = now();
                } elseif (empty($planningLine->stmp_in_qty4)) {
                    $planningLine->stmp_in_qty4 = $request->input('qty_out_sheet');
                    $planningLine->stmp_in_partNo4 = $request->input('part_no');
                    $planningLine->stmp_in_spek4 = $request->input('spec');
                    $planningLine->stmp_in_supplier4 = $request->input('supplier');
                    $planningLine->stmp_in_uniqNo4 = $request->input('uniqNo');
                    $planningLine->stmp_in_user4 = auth()->user()->username;
                    $planningLine->stmp_in_leader_line4 = auth()->user()->line_id;
                    $planningLine->stmp_in_time4 = now();
                } elseif (empty($planningLine->stmp_in_qty5)) {
                    $planningLine->stmp_in_qty5 = $request->input('qty_out_sheet');
                    $planningLine->stmp_in_partNo5 = $request->input('part_no');
                    $planningLine->stmp_in_spek5 = $request->input('spec');
                    $planningLine->stmp_in_supplier5 = $request->input('supplier');
                    $planningLine->stmp_in_uniqNo5 = $request->input('uniqNo');
                    $planningLine->stmp_in_user5 = auth()->user()->username;
                    $planningLine->stmp_in_leader_line5 = auth()->user()->line_id;
                    $planningLine->stmp_in_time5 = now();
                } else {
                    throw new \Exception('Data dengan uniqNo ini sudah ada di semua kolom.');
                }

                // Update status di tabel scan_out_rms setelah berhasil stamping
                ScanOutRm::where('uniqNo', $request->input('uniqNo'))->update(['sts_proses' => 2]);

                $planningLine->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Scan berhasil, data tersimpan!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                400,
            );
        }
    }

//     public function store2(Request $request)
// {
//     $request->validate([
//         'part_no' => 'required|string',
//         'spec' => 'required|string',
//         'supplier' => 'required|string',
//         'uniqNo' => 'required|string',
//         'id_data' => 'required|string',
//         'qty_out_kg' => 'required|string',
//         'qty_out_sheet' => 'required|numeric',
//     ]);

//     $partNo = $request->input('part_no');
//     $uniqNo = $request->input('uniqNo');

//     // ✅ Cari part di kedua kolom (part_no atau part_no2)
//     $scannedPart = PlanningLineB3::where(function ($query) use ($partNo) {
//         $query->where('part_no', $partNo)
//               ->orWhere('part_no2', $partNo);
//     })->first();

//     if (!$scannedPart) {
//         return response()->json([
//             'success' => false,
//             'icon' => 'error',
//             'message' => "Data part tidak ditemukan di kolom part_no maupun part_no2 untuk: {$partNo}",
//         ]);
//     }

//     $mesinPart = $scannedPart->mesin;
//     $mesins = ['LINE B3', 'LINE C1', 'LINE C2'];

//     $activeProcess = PlanningLineB3::where('status_proses', 2)
//         ->whereDate('date_plan', now()->toDateString())
//         ->whereIn('mesin', $mesins)
//         ->first();

//     if ($activeProcess && $activeProcess->mesin === $mesinPart && $activeProcess->part_no !== $partNo) {
//         return response()->json([
//             'success' => false,
//             'icon' => 'info',
//             'message' => 'Sedang proses part: ' . $activeProcess->part_no . ' di ' . $activeProcess->mesin . '. Selesaikan terlebih dahulu.',
//         ]);
//     }

//     DB::beginTransaction();
//     try {
//         // ✅ Update waktu scan stamping
//         $ScanOutRm = ScanOutRm::where('uniqNo', $uniqNo)->first();
//         if ($ScanOutRm) {
//             $ScanOutRm->scan_stmp_time = now();
//             $ScanOutRm->scan_stmp_user = auth()->user()->username;
//             $ScanOutRm->save();
//         }

//         // ✅ Cek data di tabel transit
//         $scanOutCheck = TabelTransitMaterial::where('uniqNo', $uniqNo)->first();

//         if (!$scanOutCheck) {
//             return response()->json([
//                 'success' => false,
//                 'icon' => 'warning',
//                 'message' => 'Material Belum di Scan Out',
//             ]);
//         }

//         if ($scanOutCheck->sts == 2) {
//             return response()->json([
//                 'success' => false,
//                 'icon' => 'info',
//                 'message' => 'RM ini sudah di-scan in stamping.',
//             ]);
//         }

//         if ($scanOutCheck->sts != 1) {
//             return response()->json([
//                 'success' => false,
//                 'icon' => 'warning',
//                 'message' => 'RM belum melakukan ScanOut.',
//             ]);
//         }

//         // ✅ Tentukan shift dan tanggal
//         $now = Carbon::now();
//         $shiftNow = ($now->between($now->copy()->setTime(7, 0), $now->copy()->setTime(20, 0))) ? 1 : 2;

//         // ✅ Ambil tanggal terbaru berdasarkan part_no atau part_no2
//         $latestDate = PlanningLineB3::where(function ($q) use ($partNo) {
//             $q->where('part_no', $partNo)
//               ->orWhere('part_no2', $partNo);
//         })->max('created_at');

//         // ✅ Ambil data planning hari ini yang cocok
//         $planningLines = PlanningLineB3::where(function ($q) use ($partNo) {
//                 $q->where('part_no', $partNo)
//                   ->orWhere('part_no2', $partNo);
//             })
//             ->where('shift', $shiftNow)
//             ->whereDate('created_at', Carbon::parse($latestDate)->toDateString())
//             ->get();

//         if ($planningLines->isEmpty()) {
//             return response()->json([
//                 'success' => false,
//                 'icon' => 'warning',
//                 'message' => "Data Planning tidak ditemukan untuk part_no {$partNo} (baik di kolom part_no maupun part_no2).",
//             ]);
//         }

//         $scanOutData = $scanOutCheck;
//         $targetRows = PlanningLineB3::where(function ($q) use ($scanOutData) {
//                 $q->where('part_no', $scanOutData->part_no)
//                   ->orWhere('part_no2', $scanOutData->part_no);
//             })
//             ->where('shift', $shiftNow)
//             ->where('mesin_category', 1)
//             ->where(function ($query) {
//                 $query->whereNull('rm_uniqNo')
//                       ->orWhereNull('rm_uniqNo2')
//                       ->orWhereNull('rm_uniqNo3')
//                       ->orWhereNull('rm_uniqNo4');
//             })
//             ->get();

//         $countTarget = $targetRows->count();
//         $qtyOut = str_starts_with($scanOutData->uniqNo, 'BP')
//             ? intval($scanOutData->qty_stamping)
//             : ($countTarget == 2 ? intval($scanOutData->qty_stamping / 2) : intval($scanOutData->qty_stamping));

//         // ✅ Update slot kosong (rm_uniqNo, rm_uniqNo2, dst)
//         foreach ($targetRows as $targetRow) {
//             if (in_array($scanOutData->uniqNo, [
//                 $targetRow->rm_uniqNo,
//                 $targetRow->rm_uniqNo2,
//                 $targetRow->rm_uniqNo3,
//                 $targetRow->rm_uniqNo4
//             ])) {
//                 continue;
//             }

//             if (is_null($targetRow->rm_uniqNo)) {
//                 $targetRow->rm_uniqNo = $scanOutData->uniqNo;
//                 $targetRow->rm_partNo = $scanOutData->part_no;
//                 $targetRow->rm_spek = $scanOutData->spec;
//                 $targetRow->rm_supplier = $scanOutData->supplier;
//                 $targetRow->rm_qty = $scanOutData->qty_stamping;
//                 $targetRow->rm_user = $scanOutData->createdby;
//                 $targetRow->rm_time = $scanOutData->created_at;
//             } elseif (is_null($targetRow->rm_uniqNo2)) {
//                 $targetRow->rm_uniqNo2 = $scanOutData->uniqNo;
//                 $targetRow->rm_partNo2 = $scanOutData->part_no;
//                 $targetRow->rm_spek2 = $scanOutData->spec;
//                 $targetRow->rm_supplier2 = $scanOutData->supplier;
//                 $targetRow->rm_qty2 = $scanOutData->qty_stamping;
//                 $targetRow->rm_user2 = $scanOutData->createdby;
//                 $targetRow->rm_time2 = $scanOutData->created_at;
//             } elseif (is_null($targetRow->rm_uniqNo3)) {
//                 $targetRow->rm_uniqNo3 = $scanOutData->uniqNo;
//                 $targetRow->rm_partNo3 = $scanOutData->part_no;
//                 $targetRow->rm_spek3 = $scanOutData->spec;
//                 $targetRow->rm_supplier3 = $scanOutData->supplier;
//                 $targetRow->rm_qty3 = $scanOutData->qty_stamping;
//                 $targetRow->rm_user3 = $scanOutData->createdby;
//                 $targetRow->rm_time3 = $scanOutData->created_at;
//             } elseif (is_null($targetRow->rm_uniqNo4)) {
//                 $targetRow->rm_uniqNo4 = $scanOutData->uniqNo;
//                 $targetRow->rm_partNo4 = $scanOutData->part_no;
//                 $targetRow->rm_spek4 = $scanOutData->spec;
//                 $targetRow->rm_supplier4 = $scanOutData->supplier;
//                 $targetRow->rm_qty4 = $scanOutData->qty_stamping;
//                 $targetRow->rm_user4 = $scanOutData->createdby;
//                 $targetRow->rm_time4 = $scanOutData->created_at;
//             } else {
//                 continue;
//             }

//             // ✅ Update qty
//             $targetRow->qty_in_material = ($targetRow->qty_in_material ?? 0) + $request->qty_out_sheet;
//             $targetRow->qty_out_material = ($targetRow->qty_out_material ?? 0) + $qtyOut;
//             $targetRow->status = 2;
//             $targetRow->status_proses = 2;
//             $targetRow->save();
//         }

//         // ✅ Update status proses di tabel transit
//         TabelTransitMaterial::where('uniqNo', $uniqNo)->update(['sts_proses' => 2]);

//         // ✅ Update kolom stamping masuk
//         foreach ($planningLines as $planningLine) {
//             if (empty($planningLine->stmp_in_qty)) {
//                 $planningLine->stmp_in_qty = $request->qty_out_sheet;
//                 $planningLine->qty_in_material = $request->qty_out_sheet;
//                 $planningLine->stmp_in_partNo = $partNo;
//                 $planningLine->stmp_in_spek = $request->spec;
//                 $planningLine->stmp_in_supplier = $request->supplier;
//                 $planningLine->stmp_in_uniqNo = $uniqNo;
//                 $planningLine->stmp_in_user = auth()->user()->username;
//                 $planningLine->stmp_in_time = now();
//             } elseif (empty($planningLine->stmp_in_qty2)) {
//                 $planningLine->stmp_in_qty2 = $request->qty_out_sheet;
//                 $planningLine->qty_in_material = $request->qty_out_sheet;
//                 $planningLine->stmp_in_partNo2 = $partNo;
//                 $planningLine->stmp_in_spek2 = $request->spec;
//                 $planningLine->stmp_in_supplier2 = $request->supplier;
//                 $planningLine->stmp_in_uniqNo2 = $uniqNo;
//                 $planningLine->stmp_in_user2 = auth()->user()->username;
//                 $planningLine->stmp_in_time2 = now();
//             }
//             $planningLine->save();
//         }

//         DB::commit();

//         return response()->json([
//             'success' => true,
//             'message' => 'Scan berhasil, qty_out_sheet telah masuk ke kolom qty_in!',
//         ]);
//     } catch (\Exception $e) {
//         DB::rollBack();
//         return response()->json([
//             'success' => false,
//             'message' => $e->getMessage(),
//         ], 400);
//     }
// }


}
