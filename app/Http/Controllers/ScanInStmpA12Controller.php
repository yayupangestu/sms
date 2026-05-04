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

class ScanInStmpA12Controller extends Controller
{
    public function index()
    {
        $title = 'SCAN IN A1 A2';
        return view('scanner2.scaninstmpa12', compact('title'));
    }

    public function getQtyStamping(Request $request)
    {
        $uniqNo = $request->uniqNo;

        $data = TabelTransitMaterial::where('uniqNo', $uniqNo)->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'qty_stamping' => $data->qty_stamping,
            ]);
        } else {
            return response()->json(
                [
                    'success' => false,
                    'qty_stamping' => null,
                    'message' => 'Data tidak ditemukan.',
                ],
                404,
            );
        }
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
            'qty_out_kg' => 'required|numeric',
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
        $mesins = ['LINE A1', 'LINE A2'];

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



            // ✅ tambahan: part_no2 hasil pilihan popup
            $selectedPartNo2 = $request->input('selected_part_no2'); // array | null
            $isSprating = is_array($selectedPartNo2) && in_array('SPRATING', $selectedPartNo2);

            if (!empty($selectedPartNo2) && !is_array($selectedPartNo2)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format selected_part_no2 tidak valid'
                ]);
            }

            // Cari tanggal terbaru dari data part_no tersebut
            $latestDate = PlanningLineB3::where('part_no', $partNo)->max('created_at');

            // ✅ Ambil planning sesuai pilihan part_no2
            $planningLines = PlanningLineB3::where('part_no', $partNo)
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
                    'message' => 'Data Planning tidak ditemukan',
                ]);
            }

            $scanOutData = $scanOutCheck;
            $countTarget = $planningLines->count();

            // Tentukan qty yang keluar
            $isStsProses2Null = is_null($scanOutData->sts_proses2);
            $qtyOut = str_starts_with($scanOutData->uniqNo, 'B') || !($countTarget == 2 && $isStsProses2Null)
                ? intval($scanOutData->qty_stamping)
                : intval($scanOutData->qty_stamping / 2);

            // Cek apakah uniqNo sudah pernah dipakai untuk part_no yang sama (antisipasi duplikat)
            $existingScan = PlanningLineB3::where(function ($query) use ($uniqNo) {
                $query->where('stmp_in_uniqNo', $uniqNo)
                    ->orWhere('stmp_in_uniqNo2', $uniqNo)
                    ->orWhere('stmp_in_uniqNo3', $uniqNo)
                    ->orWhere('stmp_in_uniqNo4', $uniqNo);
            })
            ->where('part_no', $partNo)
            ->whereDate('created_at', Carbon::parse($latestDate)->toDateString())
            ->first();

            if ($existingScan) {
                throw new \Exception('Material dengan uniqNo ini sudah pernah discan pada part_no yang sama.');
            }

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
                            $planningLine->rm_qty_kode = $scanOutData->qty_stamping;
                            $planningLine->rm_user = $scanOutData->createdby;
                            $planningLine->rm_time = $scanOutData->created_at;
                        } elseif (is_null($planningLine->rm_uniqNo2)) {
                            $planningLine->rm_uniqNo2 = $scanOutData->uniqNo;
                            $planningLine->rm_partNo2 = $scanOutData->part_no;
                            $planningLine->rm_spek2 = $scanOutData->spec;
                            $planningLine->rm_supplier2 = $scanOutData->supplier;
                            $planningLine->rm_qty2 = $scanOutData->qty_stamping;
                            $planningLine->rm_qty_kode2 = $scanOutData->qty_stamping;
                            $planningLine->rm_user2 = $scanOutData->createdby;
                            $planningLine->rm_time2 = $scanOutData->created_at;
                        } elseif (is_null($planningLine->rm_uniqNo3)) {
                            $planningLine->rm_uniqNo3 = $scanOutData->uniqNo;
                            $planningLine->rm_partNo3 = $scanOutData->part_no;
                            $planningLine->rm_spek3 = $scanOutData->spec;
                            $planningLine->rm_supplier3 = $scanOutData->supplier;
                            $planningLine->rm_qty3 = $scanOutData->qty_stamping;
                            $planningLine->rm_qty_kode3 = $scanOutData->qty_stamping;
                            $planningLine->rm_user3 = $scanOutData->createdby;
                            $planningLine->rm_time3 = $scanOutData->created_at;
                        } elseif (is_null($planningLine->rm_uniqNo4)) {
                            $planningLine->rm_uniqNo4 = $scanOutData->uniqNo;
                            $planningLine->rm_partNo4 = $scanOutData->part_no;
                            $planningLine->rm_spek4 = $scanOutData->spec;
                            $planningLine->rm_supplier4 = $scanOutData->supplier;
                            $planningLine->rm_qty4 = $scanOutData->qty_stamping;
                            $planningLine->rm_qty_kode4 = $scanOutData->qty_stamping;
                            $planningLine->rm_user4 = $scanOutData->createdby;
                            $planningLine->rm_time4 = $scanOutData->created_at;
                        }
                    }

                    // Update qty_out_material (hanya jika uniqNo bukan diawali B)
                    if (!str_starts_with($scanOutData->uniqNo, 'B')) {
                        $planningLine->qty_out_material = ($planningLine->qty_out_material ?? 0) + $qtyOut;
                    }
                }

                // --- STAMPING IN ---
                $qtyIn = str_starts_with($scanOutData->uniqNo, 'B') ? intval($scanOutData->qty_stamping) : ($countTarget == 2 ? intval($scanOutData->qty_stamping / 2) : intval($scanOutData->qty_stamping));
                $planningLine->qty_in_material += $qtyIn;

                if (is_null($planningLine->time_startProses)) {
                    $planningLine->time_startProses = now();
                }

                if ($planningLine->qty_in_material >= $planningLine->qty_plan) {
                    $planningLine->status2 = $planningLine->qty_in_material == $planningLine->qty_plan ? 3 : 4;
                }

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
                    $planningLine->stmp_in_spek2 = $request->spec;
                    $planningLine->stmp_in_supplier2 = $request->supplier;
                    $planningLine->stmp_in_uniqNo2 = $request->input('uniqNo');
                    $planningLine->stmp_in_user2 = auth()->user()->username;
                    $planningLine->stmp_in_leader_line2 = auth()->user()->line_id;
                    $planningLine->stmp_in_time2 = now();
                } elseif (empty($planningLine->stmp_in_qty3)) {
                    $planningLine->stmp_in_qty3 = $request->input('qty_out_sheet');
                    $planningLine->stmp_in_partNo3 = $request->input('part_no');
                    $planningLine->stmp_in_spek3 = $request->spec;
                    $planningLine->stmp_in_supplier3 = $request->supplier;
                    $planningLine->stmp_in_uniqNo3 = $request->input('uniqNo');
                    $planningLine->stmp_in_user3 = auth()->user()->username;
                    $planningLine->stmp_in_leader_line3 = auth()->user()->line_id;
                    $planningLine->stmp_in_time3 = now();
                } elseif (empty($planningLine->stmp_in_qty4)) {
                    $planningLine->stmp_in_qty4 = $request->input('qty_out_sheet');
                    $planningLine->stmp_in_partNo4 = $request->input('part_no');
                    $planningLine->stmp_in_spek4 = $request->spec;
                    $planningLine->stmp_in_supplier4 = $request->supplier;
                    $planningLine->stmp_in_uniqNo4 = $request->input('uniqNo');
                    $planningLine->stmp_in_user4 = auth()->user()->username;
                    $planningLine->stmp_in_leader_line4 = auth()->user()->line_id;
                    $planningLine->stmp_in_time4 = now();
                } elseif (empty($planningLine->stmp_in_qty5)) {
                    $planningLine->stmp_in_qty5 = $request->input('qty_out_sheet');
                    $planningLine->stmp_in_partNo5 = $request->input('part_no');
                    $planningLine->stmp_in_spek5 = $request->spec;
                    $planningLine->stmp_in_supplier5 = $request->supplier;
                    $planningLine->stmp_in_uniqNo5 = $request->input('uniqNo');
                    $planningLine->stmp_in_user5 = auth()->user()->username;
                    $planningLine->stmp_in_leader_line5 = auth()->user()->line_id;
                    $planningLine->stmp_in_time5 = now();
                } else {
                    throw new \Exception('Data dengan uniqNo ini sudah ada di semua kolom.');
                }

                $planningLine->status = 2;
                $planningLine->status_proses = 2;
                $planningLine->save();

                if (!$isSprating) {
                    break;
                }
            }

            // Update status di tabel transit (sekali saja)
            TabelTransitMaterial::where('uniqNo', $uniqNo)->update(['sts_proses' => 2]);
            // Update status di tabel scan_out_rms
            ScanOutRm::where('uniqNo', $uniqNo)->update(['sts_proses' => 2]);

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
}
