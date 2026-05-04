<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanningLineB3;
use App\Models\ScanInLabel;
use App\Models\TraceAbility;
use App\Models\RmStok;
use App\Models\RmReturnMaterial;
use App\Models\ScanOutRm;
use DB;
use DataTables;
use Carbon\Carbon;
use App\Models\TabelTransitMaterial;

class DashboardPlanningA12 extends Controller
{
    public function index()
{
    $title = 'Dashboard A1 A2';

    $scan_in_labels = ScanInLabel::all();
    $trace_abilities = TraceAbility::all();
    $rm_stoks = RmStok::all();
    $rm_return_materials = RmReturnMaterial::all();
    $scan_out_rms = ScanOutRm::all();

    $planningData = DB::table('planning_line_b3_s as a')
        ->select('a.id', 'a.product_id', 'a.job_no', 'a.part_no', 'a.qty_plan', 'a.name_material')
        ->get();

    // Cek jika ada sts = 1
    if (RmReturnMaterial::where('sts', 1)->exists()) {
        session()->flash('rm_warning', 'Ada material sisa yang belum diterima. Cek box Info RM.');
    }

    return view('dashboard2.dashboarda', compact(
        'title', 'planningData', 'scan_in_labels', 'trace_abilities','rm_stoks', 'rm_return_materials', 'scan_out_rms'
    ));
}



    public function getIncomingMaterials(Request $request)
    {
        $mesin = $request->query('mesin');

        if (!$mesin) {
            return response()->json(['error' => 'mesin parameter is required'], 400);
        }

        $materials = DB::table('planning_line_b3_s')
            ->where('mesin', $mesin)
            ->orderBy('position', 'asc') // Tambahkan fungsi orderBy di sini
            ->get();

        if ($materials->isEmpty()) {
            return response()->json(['error' => 'No data found for mesin ' . $mesin], 404);
        }

        return response()->json($materials);
    }



    public function getLatestRmReturnMaterials(Request $request)
    {
        $today = now()->format('Y-m-d');

        $materials = ScanOutRm::whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($materials);
    }

    public function getRMInfo(Request $request)
    {
        $lineId = $request->query('line_id'); // Ambil line_id dari URL

        $query = RMReturnMaterial::select('part_no', 'spec', 'qty_awal', 'qty_return', 'line_id','sts', 'id','time');

        if ($lineId) {
            $query->where('line_id', $lineId);
        }

        $data = $query->get();

        return response()->json($data);
    }

    public function updateSts(Request $request)
    {
        $partNo = $request->input('part_no');
        // $uniqNo = $request->input('uniqNo');  // line_id sent from the client-side

        // Adjust the column name to match your table's schema
        $updated = DB::table('scan_out_rms')
                    ->where('part_no', $partNo)
                    // ->where('uniqNo', $uniqNo) // Updated column name
                    ->update(['sts' => 1]);

        if ($updated) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }


    public function getLatestPlanningData(Request $request)
{
    $start = now()->startOfDay(); // Hari ini pukul 00:00
    $end = now()->endOfDay(); // Hari ini pukul 23:59

    $shift = $request->input('shift');

    $query = DB::table('planning_line_b3_s')
        ->whereBetween('created_at', [$start, $end]) // Filter hanya hari ini
        ->whereIn('mesin', ['LINE A1', 'LINE A2'])
        ->orderBy('position', 'asc'); // Urutkan berdasarkan position

    // Jika shift tidak kosong, tambahkan filter shift
    if (!empty($shift)) {
        $query->where('shift', $shift);
    }

    $planningData = $query->orderBy('created_at', 'desc')->get()->map(function ($item) {
        $item->line = $item->line ?? $item->mesin;
        return $item;
    });

    return response()->json($planningData->groupBy('line'));
}



public function cancelProduction(Request $request)
{
    $request->validate([
        'part_no' => 'required|string',
        'date_plan' => 'required|date',
        'shift' => 'required|string',
        'status_proses' => 'required|integer',
    ]);

    $dataToUpdate = [
        'status_proses' => $request->status_proses,
    ];

    // Jika proses manual
    if ($request->has('qty_out_material') && $request->qty_out_material !== null) {
        $dataToUpdate['qty_out_material'] = $request->qty_out_material;
        $dataToUpdate['time_startProses'] = now();
    }

    $updated = 0;

    // ✅ Khusus untuk Proses Manual / Proses Kembali (status 2)
    if ((int)$request->status_proses === 2) {
        // Utamakan mesin LINE A1
        $queryA1 = PlanningLineB3::where('part_no', $request->part_no)
            ->where('date_plan', $request->date_plan)
            ->where('shift', $request->shift)
            ->where('mesin', 'LINE A1')
            ->where('status_proses', '!=', 3);

        $updatedA1 = $queryA1->update($dataToUpdate);
        $updated += $updatedA1;

        // Kalau tidak ada di LINE A1
        if ($updatedA1 === 0) {
            $queryA2 = PlanningLineB3::where('part_no', $request->part_no)
                ->where('date_plan', $request->date_plan)
                ->where('shift', $request->shift)
                ->where('mesin', 'LINE A2')
                ->where('status_proses', '!=', 3);

            $updatedA2 = $queryA2->update($dataToUpdate);
            $updated += $updatedA2;
        }
    } else {
        // ✅ Script awal tetap dipakai untuk kondisi lain (misal Cancel Produksi status = 5)
        $query = PlanningLineB3::where('part_no', $request->part_no)
            ->where('date_plan', $request->date_plan)
            ->where('shift', $request->shift)
            ->where(function ($q) {
                $q->where('line_id', 1)      // default
                  ->orWhereIn('mesin', ['LINE A1','LINE A2']); // tambahan fleksibel
            });

        if ((int)$request->status_proses === 5) {
            $query->whereNull('actual_production');
        }

        if ((int)$request->status_proses === 2) {
            $query->where('status_proses', '!=', 3);
        }

        $updated = $query->update($dataToUpdate);
    }

    return response()->json([
        'success' => $updated > 0,
        'updated_rows' => $updated
    ]);
}


public function updateDescription(Request $request)
{
    $request->validate([
        'part_no2'     => 'required|string',
        'date_plan'    => 'required|date',
        'shift'        => 'required|string',
        'description'  => 'required|string'
    ]);

    $updated = DB::table('planning_line_b3_s')
        ->where('part_no2', $request->part_no2)
        ->where('date_plan', $request->date_plan)
        ->where('shift', $request->shift)
        ->where('mesin_category', 1) // 🔥 filter tambahan
        ->update([
            'description' => $request->description,
            'updated_at'  => now()
        ]);

    if ($updated) {
        return response()->json([
            'success' => true,
            'message' => 'Description berhasil diupdate.'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan atau tidak ada perubahan.'
        ]);
    }
}





// Controller
public function cekProsesMesin(Request $request)
{
    $mesin = $request->input('mesin');

    $ada =PlanningLineB3::where('mesin', $mesin)
        ->where('status', 2)
        ->where('status_proses', 2)
        ->exists();

    return response()->json(['adaProsesAktif' => $ada]);
}


    public function updateStatusProses(Request $request)
{
    $mesin = $request->input('mesin');
    $newStatus = $request->input('new_status');

    // Pastikan mesin valid
    if (!$mesin) {
        return response()->json(['success' => false, 'message' => 'Mesin tidak valid.'], 400);
    }

    if ($newStatus == 2) {
        // Hanya update jika status_proses saat ini adalah 2, 3, atau 4
        $updated = DB::table('planning_line_b3_s')
            ->where('mesin', $mesin)
            ->whereIn('status_proses', [2, 4, 5,]) // Kondisi tambahan
            ->update(['status_proses' => $newStatus]);
    } else {
        // Update hanya jika status_proses bernilai 2 untuk status lainnya
        $updated = DB::table('planning_line_b3_s')
            ->where('mesin', $mesin)
            ->where('status_proses', 2)
            ->update(['status_proses' => $newStatus]);
    }

    if ($updated) {
        return response()->json(['success' => true, 'message' => 'Status diperbarui.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Tidak ada data yang diperbarui. Cek kondisi status_proses.']);
    }
}

public function getPartNoOptions3(Request $request)
{
    $id = $request->id;

    // Cari RM Return Material berdasarkan ID
    $rmReturn = RmReturnMaterial::find($id);
    if (!$rmReturn) {
        return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.']);
    }

    // Pastikan `part_no` ada pada objek $rmReturn
    if (!$rmReturn->part_no) {
        return response()->json(['success' => false, 'message' => 'Part No tidak tersedia.']);
    }

    // Cari part_no, shift, status_proses, dan mesin dari PlanningLineB3 untuk hari ini
    $partNos = PlanningLineB3::where('part_no', $rmReturn->part_no)
        ->whereDate('created_at', now()->toDateString())
        ->select('part_no', 'shift', 'status_proses', 'mesin') // Tambahkan 'mesin'
        ->get();

    if ($partNos->isEmpty()) {
        return response()->json(['success' => false, 'message' => 'Tidak ada Part No yang tersedia untuk hari ini.']);
    }

    return response()->json([
        'success' => true,
        'data' => $partNos
    ]);
}


// use Carbon\Carbon;

public function accepted2(Request $request)
{
    $id = $request->id;
    $selectedPartNo = $request->part_no;
    $selectedShift = $request->shift;

    // Hitung rentang waktu shift: 07:00 hari ini - 07:00 besok
    $now = Carbon::now();
    if ($now->hour < 7) {
        $startTime = Carbon::yesterday()->setHour(7)->startOfHour();
        $endTime = Carbon::today()->setHour(7)->startOfHour();
    } else {
        $startTime = Carbon::today()->setHour(7)->startOfHour();
        $endTime = Carbon::tomorrow()->setHour(7)->startOfHour();
    }

    $rmReturn = RmReturnMaterial::find($id);
    if (!$rmReturn) {
        return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.']);
    }

    $planningLineB3List = PlanningLineB3::where('part_no', $selectedPartNo)
        ->where('shift', $selectedShift)
        ->whereBetween('created_at', [$startTime, $endTime])
        ->get();

    if ($planningLineB3List->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Material tidak ditemukan pada shift ini. Cek kembali tabel Planning.'
        ], 400);
    }

    $existingCountSameDate = PlanningLineB3::where('part_no', $selectedPartNo)
        ->whereBetween('date_plan', [$startTime, $endTime])
        ->count();

    try {
        \DB::beginTransaction();

        foreach ($planningLineB3List as $planningLineB3S) {
            $planningLineB3S->qty_in_material += $rmReturn->qty_return;
            $planningLineB3S->status = 2;
            $planningLineB3S->status_proses = 2;

            // Masukkan ke kolom kosong
            if (empty($planningLineB3S->stmp_in_qty)) {
                $planningLineB3S->stmp_in_qty = $rmReturn->qty_return;
                $planningLineB3S->stmp_in_partNo = $rmReturn->part_no;
                $planningLineB3S->stmp_in_spek = $rmReturn->spec;
                $planningLineB3S->stmp_in_uniqNo = $rmReturn->uniqNo;
                $planningLineB3S->stmp_in_supplier = $rmReturn->supplier;
                $planningLineB3S->stmp_in_user = auth()->user()->username;
                $planningLineB3S->stmp_in_leader_line = auth()->user()->line_id;
                $planningLineB3S->stmp_in_time = now();
            } elseif (empty($planningLineB3S->stmp_in_qty2)) {
                $planningLineB3S->stmp_in_qty2 = $rmReturn->qty_return;
                $planningLineB3S->stmp_in_partNo2 = $rmReturn->part_no;
                $planningLineB3S->stmp_in_spek2 = $rmReturn->spec;
                $planningLineB3S->stmp_in_uniqNo2 = $rmReturn->uniqNo;
                $planningLineB3S->stmp_in_supplier2 = $rmReturn->supplier;
                $planningLineB3S->stmp_in_user2 = auth()->user()->username;
                $planningLineB3S->stmp_in_leader_line2 = auth()->user()->line_id;
                $planningLineB3S->stmp_in_time2 = now();
            } elseif (empty($planningLineB3S->stmp_in_qty3)) {
                $planningLineB3S->stmp_in_qty3 = $rmReturn->qty_return;
                $planningLineB3S->stmp_in_partNo3 = $rmReturn->part_no;
                $planningLineB3S->stmp_in_spek3 = $rmReturn->spec;
                $planningLineB3S->stmp_in_uniqNo3 = $rmReturn->uniqNo;
                $planningLineB3S->stmp_in_supplier3 = $rmReturn->supplier;
                $planningLineB3S->stmp_in_user3 = auth()->user()->username;
                $planningLineB3S->stmp_in_leader_line3 = auth()->user()->line_id;
                $planningLineB3S->stmp_in_time3 = now();
            } elseif (empty($planningLineB3S->stmp_in_qty4)) {
                $planningLineB3S->stmp_in_qty4 = $rmReturn->qty_return;
                $planningLineB3S->stmp_in_partNo4 = $rmReturn->part_no;
                $planningLineB3S->stmp_in_spek4 = $rmReturn->spec;
                $planningLineB3S->stmp_in_uniqNo4 = $rmReturn->uniqNo;
                $planningLineB3S->stmp_in_supplier4 = $rmReturn->supplier;
                $planningLineB3S->stmp_in_user4 = auth()->user()->username;
                $planningLineB3S->stmp_in_leader_line4 = auth()->user()->line_id;
                $planningLineB3S->stmp_in_time4 = now();
            } elseif (empty($planningLineB3S->stmp_in_qty5)) {
                $planningLineB3S->stmp_in_qty5 = $rmReturn->qty_return;
                $planningLineB3S->stmp_in_partNo5 = $rmReturn->part_no;
                $planningLineB3S->stmp_in_spek5 = $rmReturn->spec;
                $planningLineB3S->stmp_in_uniqNo5 = $rmReturn->uniqNo;
                $planningLineB3S->stmp_in_supplier5 = $rmReturn->supplier;
                $planningLineB3S->stmp_in_user5 = auth()->user()->username;
                $planningLineB3S->stmp_in_leader_line5 = auth()->user()->line_id;
                $planningLineB3S->stmp_in_time5 = now();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Semua kolom RM sudah terisi di salah satu data. Cek kembali!',
                ]);
            }

            $planningLineB3S->updated_at = now();
            $planningLineB3S->save();
        }

        // Simpan ke scan_out_rms
        $scanOutRm = new ScanOutRm();
        $scanOutRm->uniqNo = $rmReturn->uniqNo;
        $scanOutRm->spec = $rmReturn->spec;
        $scanOutRm->part_no = $rmReturn->part_no;
        $scanOutRm->qty_out_sheet = $rmReturn->qty_return;
        $scanOutRm->supplier = $rmReturn->supplier;
        $scanOutRm->createdby = auth()->user()->username;
        $scanOutRm->created_at = now();
        $scanOutRm->updated_at = now();
        $scanOutRm->save();

        // Update status RM Return
        $rmReturn->sts = 2;
        $rmReturn->time_out = now();
        $rmReturn->updatedby = auth()->user()->username;
        $rmReturn->save();

        \DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Item Material berhasil dikeluarkan untuk Shift ' . $selectedShift
        ]);
    } catch (\Exception $e) {
        \DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage()
        ], 500);
    }
}



    public function accepted1(Request $request)
    {
        $id = $request->id;
    $selectedPartNo = $request->part_no;
    $selectedShift = $request->shift;

    // Cari RM Return Material berdasarkan ID
    $rmReturn = RmReturnMaterial::find($id);
    if (!$rmReturn) {
        return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.']);
    }

    // Cari PlanningLineB3 berdasarkan part_no & shift yang dipilih
    $planningLineB3S = PlanningLineB3::where('part_no', $selectedPartNo)
        ->where('shift', $selectedShift)
        ->whereDate('created_at', now()->toDateString())
        ->first();

    if (!$planningLineB3S) {
        return response()->json([
            'success' => false,
            'message' => 'Material tidak ditemukan pada shift ini. Cek kembali tabel Planning.'
        ], 400);
    }

        try {
            // **Pastikan semua operasi sukses sebelum memperbarui kolom `sts`**
            \DB::beginTransaction();

            // Update PlanningLineB3
            $planningLineB3S->qty_in_material += $rmReturn->qty_return;
            $planningLineB3S->status = 2;
            $planningLineB3S->status_proses = 2;

            if (empty($planningLineB3S->stmp_in_qty)) {
                $planningLineB3S->stmp_in_qty = $rmReturn->qty_return;
                $planningLineB3S->stmp_in_partNo = $rmReturn->part_no;
                $planningLineB3S->stmp_in_spek = $rmReturn->spec;
                $planningLineB3S->stmp_in_uniqNo = $rmReturn->uniqNo;
                $planningLineB3S->stmp_in_supplier = $rmReturn->supplier;
                $planningLineB3S->stmp_in_user = auth()->user()->username;
                $planningLineB3S->stmp_in_leader_line = auth()->user()->line_id;
                $planningLineB3S->stmp_in_time = now();
            } elseif (empty($planningLineB3S->stmp_in_qty2)) {
                $planningLineB3S->stmp_in_qty2 = $rmReturn->qty_return;
                $planningLineB3S->stmp_in_partNo2 = $rmReturn->part_no;
                $planningLineB3S->stmp_in_spek2 = $rmReturn->spec;
                $planningLineB3S->stmp_in_uniqNo2 = $rmReturn->uniqNo;
                $planningLineB3S->stmp_in_supplier2 = $rmReturn->supplier;
                $planningLineB3S->stmp_in_user2 = auth()->user()->username;
                $planningLineB3S->stmp_in_leader_line2 = auth()->user()->line_id;
                $planningLineB3S->stmp_in_time2 = now();
            } elseif (empty($planningLineB3S->stmp_in_qty3)) {
                $planningLineB3S->stmp_in_qty3 = $rmReturn->qty_return;
                $planningLineB3S->stmp_in_partNo3 = $rmReturn->part_no;
                $planningLineB3S->stmp_in_spek3 = $rmReturn->spec;
                $planningLineB3S->stmp_in_uniqNo3 = $rmReturn->uniqNo;
                $planningLineB3S->stmp_in_supplier3 = $rmReturn->supplier;
                $planningLineB3S->stmp_in_user3 = auth()->user()->username;
                $planningLineB3S->stmp_in_leader_line3 = auth()->user()->line_id;
                $planningLineB3S->stmp_in_time3 = now();
            } elseif (empty($planningLineB3S->stmp_in_qty4)) {
                $planningLineB3S->stmp_in_qty4 = $rmReturn->qty_return;
                $planningLineB3S->stmp_in_partNo4 = $rmReturn->part_no;
                $planningLineB3S->stmp_in_spek4 = $rmReturn->spec;
                $planningLineB3S->stmp_in_uniqNo4 = $rmReturn->uniqNo;
                $planningLineB3S->stmp_in_supplier4 = $rmReturn->supplier;
                $planningLineB3S->stmp_in_user4 = auth()->user()->username;
                $planningLineB3S->stmp_in_leader_line4 = auth()->user()->line_id;
                $planningLineB3S->stmp_in_time4 = now();
            } elseif (empty($planningLineB3S->stmp_in_qty5)) {
                $planningLineB3S->stmp_in_qty5 = $rmReturn->qty_return;
                $planningLineB3S->stmp_in_partNo5 = $rmReturn->part_no;
                $planningLineB3S->stmp_in_spek5 = $rmReturn->spec;
                $planningLineB3S->stmp_in_uniqNo5 = $rmReturn->uniqNo;
                $planningLineB3S->stmp_in_supplier5 = $rmReturn->supplier;
                $planningLineB3S->stmp_in_user5 = auth()->user()->username;
                $planningLineB3S->stmp_in_leader_line5 = auth()->user()->line_id;
                $planningLineB3S->stmp_in_time5 = now();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Semua Kolom Telah terisi semua tolong cek kembali.',
                ]);
            }

            $planningLineB3S->updated_at = now();
             $planningLineB3S->save();

                // Cek status2 berdasarkan qty_in_material dan qty_plan
            if ($planningLineB3S->qty_in_material >= $planningLineB3S->qty_plan) {
                if ($planningLineB3S->qty_in_material == $planningLineB3S->qty_plan) {
                    $planningLineB3S->status2 = 3; // Sama dengan qty_plan
                } else {
                    $planningLineB3S->status2 = 4; // Lebih besar dari qty_plan
                }
            }

        // Simpan perubahan pada status2
        $planningLineB3S->save();


        // **Jika semua proses berhasil, baru perbarui kolom `sts`**
        $rmReturn->sts = 2;
        $rmReturn->time_out = now();
        $rmReturn->time_in_stmp = now();
        $rmReturn->user_in_stmp = auth()->user()->username;
        $rmReturn->line_in_stmp = auth()->user()->line_id;
        $rmReturn->updatedby = auth()->user()->username;
        $rmReturn->save();

            // Commit transaksi jika semua berjalan sukses
            \DB::commit();

            return response()->json(['success' => true, 'message' => 'Item Material sisa berhasil di Keluarkan.']);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            \DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


    public function lineA1Data()
    {
        try {
            $start = Carbon::today()->addHours(7);
            $end = Carbon::tomorrow()->addHours(7)->addMinutes(30);

            $data_transit = TabelTransitMaterial::where('mesin', 'LINE A1')
    ->where(function ($query) {
        $query->where(function ($q) {
            $q->where('sts', 1)
              ->where('sts_proses', 2);
        })->orWhere(function ($q) {
            $q->where('sts', 1)
              ->where('sts_proses', 1);
        });
    })
    ->where('qty_stamping', '>', 0) // 👈 PENTING: filter pasti

    ->where(function ($query) {
        $query->where('sts_proses', '!=', 2)
              ->orWhere(function ($sub) {
                  $sub->where('sts_proses2', '!=', 3)
                       ->orWhere('qty_stamping', '>', 0);
              });
    })
    ->where(function ($q) {
        $q->whereNull('sts_proses2')
          ->orWhere('sts_proses2', '!=', 1)
          ->orWhere(function ($sub) {
              $sub->where('sts_proses2', 3)
                  ->where('qty_stamping', '>', 0);
          });
    })
    ->orderByDesc('updated_at')
    ->get()
    ->map(function ($item) use ($start, $end) {
        $countPartNo = PlanningLineB3::where('part_no', $item->part_no)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $qtyPallet = $countPartNo == 2 ? $item->qty_stamping / 2 : $item->qty_stamping;

        return [
            'uniqNo' => $item->uniqNo,
            'part_no' => $item->part_no,
            'job_no' => $item->job_no,
            'qty_out_sheet' => $item->qty_out_sheet,
            'qty_stamping' => $item->qty_stamping,
            'qty_pallet' => $qtyPallet,
            'created_at' => $item->updated_at,
            'mesin'     => $item->mesin,
            'sts_proses2' => $item->sts_proses,
        ];
    });


            return response()->json($data_transit);
        } catch (\Exception $e) {
            \Log::error('Gagal ambil data LINE A1: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan server.'], 500);
        }
    }

    public function lineA2Data()
    {
        try {
            $start = Carbon::today()->addHours(7);
            $end = Carbon::tomorrow()->addHours(7)->addMinutes(30);

            $data_transit = TabelTransitMaterial::where('mesin', 'LINE A2')
    ->where(function ($query) {
        $query->where(function ($q) {
            $q->where('sts', 1)
              ->where('sts_proses', 2);
        })->orWhere(function ($q) {
            $q->where('sts', 1)
              ->where('sts_proses', 1);
        });
    })
    ->where('qty_stamping', '>', 0) // 👈 PENTING: filter pasti

    ->where(function ($query) {
        $query->where('sts_proses', '!=', 2)
              ->orWhere(function ($sub) {
                  $sub->where('sts_proses2', '!=', 3)
                       ->orWhere('qty_stamping', '>', 0);
              });
    })
    ->where(function ($q) {
        $q->whereNull('sts_proses2')
          ->orWhere('sts_proses2', '!=', 1)
          ->orWhere(function ($sub) {
              $sub->where('sts_proses2', 3)
                  ->where('qty_stamping', '>', 0);
          });
    })
    ->orderByDesc('updated_at')
    ->get()
    ->map(function ($item) use ($start, $end) {
        $countPartNo = PlanningLineB3::where('part_no', $item->part_no)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $qtyPallet = $countPartNo == 2 ? $item->qty_stamping / 2 : $item->qty_stamping;

        return [
            'uniqNo' => $item->uniqNo,
            'part_no' => $item->part_no,
            'job_no' => $item->job_no,
            'qty_out_sheet' => $item->qty_out_sheet,
            'qty_stamping' => $item->qty_stamping,
            'qty_pallet' => $qtyPallet,
            'created_at' => $item->updated_at,
            'mesin'     => $item->mesin,
            'sts_proses2' => $item->sts_proses,
        ];
    });


            return response()->json($data_transit);
        } catch (\Exception $e) {
            \Log::error('Gagal ambil data LINE A: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan server.'], 500);
        }
    }

    public function approveProduction(Request $request)
    {
        try {
            $id = $request->id;
            $actualQty = $request->actual_production; // Ambil qty dari frontend

            // Update kolom status dan actual_production
            $planningItem = PlanningLineB3::find($id);
            if ($planningItem) {
                $planningItem->status_proses = 3;
                $planningItem->status_proses2 = 3;
                $planningItem->status = 3;
                $planningItem->time_endProses = now();
                $planningItem->user_stamping_done = auth()->user()->username;
                $planningItem->actual_production = $actualQty; // ✅ Simpan qty di kolom ini
                $planningItem->save();

                return response()->json(['success' => true, 'message' => 'Production status updated successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Item not found.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getActualProduction($id)
    {
        $item = PlanningLineB3::find($id);

        if ($item) {
            return response()->json([
                'success' => true,
                'actual_production' => $item->actual_production
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }
    }







}


