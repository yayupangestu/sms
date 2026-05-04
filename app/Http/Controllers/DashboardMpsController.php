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
use App\Models\TabelTransitMaterial;
use DataTables;
use Carbon\Carbon;

class DashboardMpsController extends Controller
{
    public function index()
    {
        $title = 'Dashboard MPS RM';

        $scan_in_labels = ScanInLabel::all();
        $trace_abilities = TraceAbility::all();
        $rm_stoks = RmStok::all();
        $rm_return_materials = RmReturnMaterial::all();
        $scan_out_rms = ScanOutRm::all();

        // Fetch data using raw SQL query with DB facade
     // Fetch data using raw SQL query with DB facade
     $planningData = DB::table('planning_line_b3_s as a')
     ->select('a.id','a.product_id','a.job_no','a.part_no','a.qty_plan','a.name_material', )
     ->get();

    

 return view('pcstore.dashboardmps', compact('title', 'planningData','scan_in_labels','trace_abilities','rm_stoks','rm_return_materials','scan_out_rms'));
}


// public function getIncomingMaterials(Request $request)
// {
//     $mesin = $request->query('mesin');

//     if (!$mesin) {
//         return response()->json(['error' => 'mesin parameter is required'], 400);
//     }

//     // Ambil data planning_line_b3_s sesuai mesin
//     $planningLines = DB::table('planning_line_b3_s')
//         ->where('mesin', $mesin)
//         ->get();

//     if ($planningLines->isEmpty()) {
//         return response()->json(['error' => 'No data found for mesin ' . $mesin], 404);
//     }

//     // Range waktu: hari ini jam 07:00 sampai besok jam 07:30
//     $start = Carbon::today()->addHours(7);
//     $end = Carbon::tomorrow()->addHours(7)->addMinutes(30);

//     // Ambil semua part_no unik yang ada di mesin tersebut
//     $partNos = $planningLines->pluck('part_no')->unique();

//     $results = [];

//     foreach ($partNos as $partNo) {
//         // Hitung jumlah baris part_no ini di tabel planning dalam range waktu
//         $countPartNo = DB::table('planning_line_b3_s')
//             ->where('part_no', $partNo)
//             ->whereBetween('created_at', [$start, $end])
//             ->count();

//         // Ambil total qty_stamping dari tabel_transit_materials dengan sts = 1
//         $totalStamping = DB::table('tabel_transit_materials')
//             ->where('part_no', $partNo)
//             ->where('sts', 1)
//             ->sum('qty_stamping');

//         // Cek apakah perlu dibagi 2 atau tidak
//         $finalStamping = $countPartNo === 2 ? floor($totalStamping / 2) : $totalStamping;

//         // Ambil semua baris planning dengan part_no ini dan mesin yang cocok
//         $matchingRows = $planningLines->where('part_no', $partNo);

//         foreach ($matchingRows as $row) {
//             $row->qty_stamping = $finalStamping;
//             $results[] = $row;
//         }
//     }

//     return response()->json($results);
// }

public function getIncomingMaterials(Request $request)
{
    $mesin = $request->query('mesin');
    if (!$mesin) {
        return response()->json(['error' => 'mesin parameter is required'], 400);
    }

    $planningLines = DB::table('planning_line_b3_s')
        ->where('mesin', $mesin)
        ->get();

    if ($planningLines->isEmpty()) {
        return response()->json(['error' => 'No data found for mesin ' . $mesin], 404);
    }

    $start = Carbon::today()->addHours(7);
    $end = Carbon::tomorrow()->addHours(7)->addMinutes(30);

    // Hitung total qty_stamping per part_no sekali saja
    $totalStampings = DB::table('tabel_transit_materials')
        ->select('part_no', DB::raw('SUM(qty_stamping) as total'))
        ->where('sts', 1)
        ->groupBy('part_no')
        ->pluck('total', 'part_no');

    // Hitung jumlah baris shift per part_no + shift
    $shiftCounts = DB::table('planning_line_b3_s')
        ->select('part_no', 'shift', DB::raw('COUNT(*) as count'))
        ->where('mesin', $mesin)
        ->whereBetween('created_at', [$start, $end])
        ->groupBy('part_no', 'shift')
        ->get()
        ->mapWithKeys(fn($item) => [ $item->part_no . '_' . $item->shift => $item->count ]);

    $results = [];

    foreach ($planningLines as $row) {
        $partNo = $row->part_no;
        $shiftKey = $partNo . '_' . $row->shift;

        $countSameShift = $shiftCounts[$shiftKey] ?? 1;
        $totalStamping = $totalStampings[$partNo] ?? 0;

        $row->qty_stamping = $countSameShift === 2 ? floor($totalStamping / 2) : $totalStamping;
        $results[] = $row;
    }

    return response()->json($results);
}




public function getLatestRmReturnMaterials(Request $request)
{
    $today = now()->format('Y-m-d');

    $materials = ScanOutRm::whereDate('created_at', $today)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($materials);
}

public function getQtyPlan(Request $request)
{
    $now = Carbon::now();

    // Tentukan waktu shift: 01:00 hari ini sampai 07:00 besok
    if ($now->hour < 1) {
        // Sebelum jam 01:00 dini hari, masih masuk shift kemarin
        $startTime = Carbon::yesterday()->setHour(1)->setMinute(0)->setSecond(0);
        $endTime   = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
    } else {
        // Setelah jam 01:00 dini hari, shift hari ini berjalan normal
        $startTime = Carbon::today()->setHour(1)->setMinute(0)->setSecond(0);
        $endTime   = Carbon::tomorrow()->setHour(7)->setMinute(0)->setSecond(0);
    }


    $data = DB::table('planning_line_b3_s')
        ->whereBetween('created_at', [$startTime, $endTime])
        ->groupBy('mesin')
        ->selectRaw('
            mesin,
            -- QTY PLAN PER SHIFT
            SUM(CASE WHEN shift = 1 THEN qty_plan ELSE 0 END) as qty_plan_shift_1,
            SUM(CASE WHEN shift = 2 THEN qty_plan ELSE 0 END) as qty_plan_shift_2,
            SUM(CASE WHEN shift = 3 THEN qty_plan ELSE 0 END) as qty_plan_shift_3,

            -- QTY OUT MATERIAL PER SHIFT
            SUM(CASE WHEN shift = 1 THEN qty_out_material ELSE 0 END) as qty_out_shift_1,
            SUM(CASE WHEN shift = 2 THEN qty_out_material ELSE 0 END) as qty_out_shift_2,
            SUM(CASE WHEN shift = 3 THEN qty_out_material ELSE 0 END) as qty_out_shift_3,

            -- TOTAL
            SUM(qty_plan) as totalQty,
            SUM(qty_out_material) as totalOutMaterial,
            SUM(qty_sisa_material) as totalSisaMaterial,

            -- GROUP CONCATS
            GROUP_CONCAT(DISTINCT part_no SEPARATOR ", ") as partNos,
            GROUP_CONCAT(CONCAT(part_no, ":", qty_plan) SEPARATOR ", ") as partNoQtyPlan,
            GROUP_CONCAT(CONCAT(part_no, ":", qty_out_material) SEPARATOR ", ") as partNoQtyOutMaterial,
            GROUP_CONCAT(CONCAT(part_no, ":", qty_sisa_material) SEPARATOR ", ") as partNoSisaQty
        ')
        ->get();

    return response()->json($data);
}

public function materialTa(Request $request)
    {
        try {
            $id = $request->id;

            // Update kolom `sts_produksi` dengan nilai 1
            $planningItem = PlanningLineB3::find($id);
            if ($planningItem) {
                $planningItem->qty_out_material = 0;
                $planningItem->status_proses = 6; //
                $planningItem->status = 6; //
                $planningItem->user_stamping_done = auth()->user()->username;
                $planningItem->save();

                return response()->json(['success' => true, 'message' => 'Production status updated successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Item not found.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


public function getPlanningData()
{
    $data = DB::table('planning_line_b3_s')
        ->select('mesin', DB::raw('SUM(qty_plan) as total_qty'))
        ->groupBy('mesin')
        ->get();

    return response()->json($data);
}


public function getTransitData()
{
    $start = Carbon::today()->addHours(7); // 07:00 hari ini
    $end = Carbon::tomorrow()->addHours(7)->addMinutes(30); // 07:30 besok

    $data_transit = TabelTransitMaterial::where(function ($query) {
        $query->where(function ($q) {
            $q->where('sts', 1)
              ->where('sts_proses', 2)
              ->where('qty_stamping', '>', 0);
        })->orWhere(function ($q) {
            $q->where('sts', 1)
              ->where('sts_proses', 1);
        });
    })
    ->whereIn('mesin', ['LINE B3', 'LINE C1'])

    // Tambahan untuk benar-benar mengecualikan data qty_stamping = 0
    ->where('qty_stamping', '>', 0)

    // Filter untuk sts_proses2 (opsional)
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
        // Cek apakah part_no mengandung karakter "/"
        $containsSlash = strpos($item->part_no, '/') !== false;

        // Hitung jumlah part_no yang sama dalam rentang waktu
        $countPartNo = \App\Models\PlanningLineB3::where('part_no', $item->part_no)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        // Lakukan pembagian hanya jika ada 2 dan part_no mengandung "/"
        $qtyPallet = ($containsSlash && $countPartNo == 2)
            ? $item->qty_stamping / 2
            : $item->qty_stamping;

        return [
            'uniqNo' => $item->uniqNo,
            'part_no' => $item->part_no,
            'qty_stamping' => $item->qty_stamping,
            'qty_pallet' => $qtyPallet,
            'updated_at' => $item->updated_at->format('d-m-Y H:i:s'),
            'sts' => $item->sts,
            'sts_proses' => $item->sts_proses,
            'sts_proses2' => $item->sts_proses2,
            'mesin' => $item->mesin,
        ];
    });

    return response()->json($data_transit);
}











}


