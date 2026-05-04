<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmStok;
use App\Models\RmDnIncoming;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
{
    $title = 'Home';
    $rm_stoks = RmStok::all();

    $now = Carbon::now();

    $countDocPO = RmDnIncoming::whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year)
                    ->whereNotNull('doc_po')
                    ->count('doc_po');

    $countCloseStatus = RmDnIncoming::where('status', 'Close')
                        ->whereMonth('created_at', $now->month)
                        ->whereYear('created_at', $now->year)
                        ->count();

    $countStatusNull = RmDnIncoming::whereNull('status')
                        ->whereMonth('created_at', $now->month)
                        ->whereYear('created_at', $now->year)
                        ->count();
// Cegah pembagian dengan 0
$percentage = 0;
if ($countDocPO > 0) {
    $percentage = ($countCloseStatus / $countDocPO) * 100;
}

// Bulatkan ke 2 desimal
$percentage = round($percentage, 2);

return view('home.index', compact('title', 'rm_stoks', 'countDocPO', 'countCloseStatus', 'percentage','countStatusNull'));
}


public function getData()
{
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    // Hitung total stok rm_stoks
    $total = DB::table('rm_stoks')->count();

    // Hitung stok "safe"
    $safe = DB::table('rm_stoks')
        ->where(function ($query) {
            $query->whereColumn('actual_sheet', '>', 'minimal')
                  ->orWhereColumn('actual_sheet', '=', 'minimal');
        })
        ->count();

    // Hitung stok "critical"
    $critical = DB::table('rm_stoks')
        ->where(function ($query) {
            $query->whereColumn('actual_sheet', '<', 'minimal')
                  ->orWhere('actual_sheet', '<', 0);
        })
        ->where('actual_sheet', '!=', 0)
        ->count();

    // PO counts hanya bulan ini berdasarkan created_at
    $countDocPO = DB::table('rm_dn_incomings')
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count();

    $countCloseStatus = DB::table('rm_dn_incomings')
        ->where('status', 'Close')
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count();

    $countStatusNull = DB::table('rm_dn_incomings')
        ->where(function ($query) {
            $query->whereNull('status')->orWhere('status', 'open');
        })
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->count();

    $percentage = $countDocPO > 0
        ? round(($countCloseStatus / $countDocPO) * 100, 2)
        : 0;

    return response()->json([
        'total' => $total,
        'safe' => $safe,
        'critical' => $critical,
        'countDocPO' => $countDocPO,
        'countCloseStatus' => $countCloseStatus,
        'countStatusNull' => $countStatusNull,
        'percentage' => $percentage,
    ]);
}

public function checkLineStatuses()
{
    $lines = [
        'LINE A1' => 'a1', 'LINE A2' => 'a2',
        'LINE B1' => 'b1', 'LINE B2' => 'b2', 'LINE B3' => 'b3',
        'LINE C1' => 'c1', 'LINE C2' => 'c2'
    ];

    $response = [];

    foreach ($lines as $lineName => $key) {
        $entries = DB::table('planning_line_b3_s')
            ->where('mesin', $lineName)
            ->whereDate('created_at', Carbon::today()) // filter berdasarkan tanggal hari ini
            ->orderByDesc('id')
            ->get();

        $grouped = $entries->groupBy('part_no');

        $shouldBlinkGreen = false;
        $shouldBlinkRed = false;

        foreach ($grouped as $partNo => $items) {
            $statuses = $items->pluck('status_proses')->unique()->values();

            // Apakah semua status bernilai 3?
            $allStatusAre3 = $statuses->every(fn($val) => $val == 3);

            if ($statuses->contains(2) && !$allStatusAre3) {
                $shouldBlinkGreen = true;
            }

            if ($statuses->contains(fn($val) => in_array($val, [4, 5, 6]))) {
                $shouldBlinkRed = true;
            }
        }

        if ($shouldBlinkRed) {
            $response["line_{$key}_status"] = 4;
        } elseif ($shouldBlinkGreen) {
            $response["line_{$key}_status"] = 2;
        } else {
            $response["line_{$key}_status"] = 3;
        }
    }

    return response()->json($response);
}



public function getMachineDetail(Request $request)
{
    $mesin = $request->query('mesin');

    $records = DB::table('planning_line_b3_s')
        ->select('part_no2', 'job_no', 'status_proses') 
        ->where('mesin', $mesin)
        ->whereIn('status_proses', [2, 4, 5, 6])
        ->orderByDesc('created_at')
        ->get();

    if ($records->isEmpty()) {
        return response()->json(['status' => 'empty']);
    }

    return response()->json([
        'status' => 'success',
        'data' => $records,
    ]);
}


public function getMinimalOverActual()
{
    $data = PcStoreDirect::where('status', 'SAFE')->get([
        'part_no', 
        'part_no2', 
        'job_no', 
        'model_id', 
        'daily_volume', 
        'status'
    ]);

    return response()->json($data);
}

public function getWarning()
{
    $data = PcStoreDirect::where('status', 'WARNING')->get([
        'part_no', 
        'part_no2', 
        'job_no', 
        'model_id', 
        'daily_volume', 
        'status'
    ]);

    return response()->json($data);
}

public function getDanger()
{
    $data = PcStoreDirect::where('status', 'DANGER')->get([
        'part_no', 
        'part_no2', 
        'job_no', 
        'model_id', 
        'daily_volume', 
        'status'
    ]);

    return response()->json($data);
}


}

    

