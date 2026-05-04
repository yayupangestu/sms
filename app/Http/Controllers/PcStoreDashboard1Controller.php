<?php
namespace App\Http\Controllers;
use App\Models\LineStmp;
use App\Models\DataModel;
use App\Models\DataCostumer;
use App\Models\DataPartName;
use App\Models\RmMaterial;
use App\Models\TabelB3;
use App\Models\PcStoreDirect;
use Illuminate\Http\Request;
use App\Models\ScanOutStmp;
use DataTables;
use Carbon\Carbon;
use DB;

class PcStoreDashboard1Controller extends Controller
{
    public function index()
    {
        $title = 'Dashboard1';

        // Get customer list (unique)
        $customer = PcStoreDirect::distinct()
                        ->orderBy('customer')
                        ->pluck('customer')
                        ->toArray();

        // Existing data
        $pc_store_directs = DB::table('pc_store_directs as a')
            ->select(
                'part_name',
                'part_no',
                'part_no2',
                'job_no',
                'monthly_volume',
                'daily_volume',
                'qty_kanban',
                'qty_act',
                'strength',
                'model',
                'daily_volume',
                'status',
                'updateby',
                'customer',
            )
            ->get();

        return view('pcstore.dashboard1', compact('title', 'pc_store_directs', 'customer'));
    }


    public function refreshData()
{
    $pc_store_directs = PcStoreDirect::all(); // Ambil data terbaru
    return response()->json($pc_store_directs);
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
            ->whereDate('created_at', Carbon::today()) // hanya data hari ini
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

        // Set status hanya jika ada data hari ini
        if ($entries->isNotEmpty()) {
            if ($shouldBlinkRed) {
                $response["line_{$key}_status"] = 4;
            } elseif ($shouldBlinkGreen) {
                $response["line_{$key}_status"] = 2;
            } else {
                $response["line_{$key}_status"] = 3;
            }
        } else {
            // Jika tidak ada data hari ini, tidak blinking sama sekali
            $response["line_{$key}_status"] = 0;
        }
    }

    return response()->json($response);
}



public function getMachineDetail(Request $request)
{
    $mesin = $request->query('mesin');

    $records = DB::table('planning_line_b3_s')
        ->select('part_no2', 'job_no', 'status_proses','created_at')
        ->where('mesin', $mesin)
        ->whereIn('status_proses', [2, 4, 5, 6])
        ->whereDate('created_at', Carbon::today()) // Tambahkan filter tanggal
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


public function getMinimalOverActual(Request $request)
{
    // Ambil data dengan strength >= 1.0 (SAFE)
    $data = PcStoreDirect::whereRaw('CAST(strength AS FLOAT) >= 1.0')
        ->get([
            'part_name',
            'part_no',
            'part_no2',
            'job_no',
            'monthly_volume',
            'daily_volume',
            'qty_kanban',
            'qty_act',
            'strength',
            'model',
            'status',
            'updateby',
            'customer',
        ]);

    return response()->json($data);
}


public function getWarning()
{
    // Ambil data dengan 0.5 <= strength < 1.0
    $data = PcStoreDirect::whereRaw('CAST(strength AS FLOAT) >= 0.5 AND CAST(strength AS FLOAT) < 1.0')
        ->get([
            'part_name',
            'part_no',
            'part_no2',
            'job_no',
            'monthly_volume',
            'daily_volume',
            'qty_kanban',
            'qty_act',
            'strength',
            'model',
            'status',
            'updateby',
            'customer',
        ]);

    return response()->json($data);
}


public function getDanger()
{
    // Ambil data dengan strength < 0.5
    $data = PcStoreDirect::whereRaw('CAST(strength AS FLOAT) < 0.5')
        ->get([
            'part_name',
            'part_no',
            'part_no2',
            'job_no',
            'monthly_volume',
            'daily_volume',
            'qty_kanban',
            'qty_act',
            'strength',
            'model',
            'status',
            'updateby',
            'customer',
        ]);

    return response()->json($data);
}


public function totalPart()
{
    $data = PcStoreDirect::get(); // hanya D26 ADM

    $total = $data->count(); // hitung total data

    return response()->json([
        'total' => $total,
        'data' => $data
    ]);
}

public function totalPart2()
{
    $data = PcStoreDirect::get(); // hanya D26 ADM

    $total = $data->count(); // hitung total data

    return response()->json([
        'total' => $total,
        'data' => $data
    ]);
}

public function getStockChartData(Request $request)
{
    $customer = $request->customer;

    $query = PcStoreDirect::select('job_no', 'qty_act', 'monthly_volume', 'customer');

    if ($customer) {
        $query->where('customer', $customer);
    }

    return response()->json($query->get());
}



public function outStampingData()
{
    try {
        // ambil data status 4
        $data = ScanOutStmp::where('status', 4)
                ->select('part_no2', 'job_no', 'qty_act', 'created_at','line_proses','sts_pcstore')
                ->get();

        return response()->json($data);
    } catch (\Exception $e) {
        // debug error
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}


