<?php

namespace App\Http\Controllers;
use App\Models\TabelStokBlank;
use App\Models\ScanOutRm;
use App\Models\PlanningLineB3;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RmReturnExport;
// use DataTables;
use DB;

class DashboardBlank2Controller extends Controller
{
    public function index()
    {
        $title = 'RM RETURN';

        // Hitung jumlah data di rm_return_materials dengan sts NULL atau 1
        $totalAsi1 = TabelStokBlank::whereNull('home_line')
        ->orWhere('home_line', 'ASI-1')
        ->count();
    

        $totalAsi2 = TabelStokBlank::whereNull('home_line')
        ->orWhere('home_line', 'ASI-2')
        ->count();

        // // Hitung jumlah data dengan sts = 3
        // $returnOrders = TabelStokBlank::where('sts', 1)->count();


        $totalAll = TabelStokBlank::whereIn('home_line', ['ASI-1', 'ASI-2'])->count();






        return view('rmmaterial.retrunmaterial', compact('title', 'totalAsi1', 'totalAsi2','totalAll'));
    }


    public function list(Request $request)
    {
        if ($request->ajax()) {
            $query = TabelStokBlank::select(['id', 'part_no']);

            if ($request->filled('sts')) {
                if ($request->sts === 'null') {
                    $query->whereNull('sts');
                } elseif ($request->sts === 'all') {
                    // Tampilkan semua: null, 1, dan 2
                    $query->where(function ($q) {
                        $q->whereNull('sts')
                          ->orWhereIn('sts', [1, 2]);
                    });
                } else {
                    $query->where('sts', $request->sts);
                }
            } else {
                // Default: tampilkan null dan 1
                $query->where(function($q) {
                    $q->whereNull('sts')
                      ->orWhere('sts', 1);
                });
            }


            // Filter line_id (bisa multi)
            if ($request->filled('line_id')) {
                $lineIds = explode(',', $request->line_id);
                $query->whereIn('line_id', $lineIds);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->make(true);
        }

    }

public function getPartNoOptions(Request $request)
{
    $id = $request->id;

    // Cari RM Return Material berdasarkan ID
    $rmReturn = RmReturnMaterial::find($id);
    if (!$rmReturn) {
        return response()->json(['success' => false, 'message' => 'Item tidak ditemukan.']);
    }

    // Tentukan waktu shift: 07:00 hari ini sampai 07:00 besok
    $now = Carbon::now();
    if ($now->hour < 7) {
        $startTime = Carbon::yesterday()->setHour(7)->startOfHour();
        $endTime = Carbon::today()->setHour(7)->startOfHour();
    } else {
        $startTime = Carbon::today()->setHour(7)->startOfHour();
        $endTime = Carbon::tomorrow()->setHour(7)->startOfHour();
    }

    // Cari part_no, shift, mesin dari PlanningLineB3 dalam range shift
    $partNos = PlanningLineB3::where('part_no', $rmReturn->part_no)
        ->whereBetween('created_at', [$startTime, $endTime])
        ->select('part_no', 'shift', 'mesin')
        ->get();

    if ($partNos->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Tidak ada Part No yang tersedia dalam shift produksi saat ini.'
        ]);
    }

    return response()->json([
        'success' => true,
        'data' => $partNos
    ]);
}






public function export() {
    return Excel::download(new RmReturnExport,'Material Return.xlsx');
}

public function total(Request $request)
{
    $materials = DB::table('tabel_stok_blanks')
        ->select(
            'id',
            'part_name',
            'part_no',
            'home_line',
            'job_no',
            'qty_min',
            'qty_kanban'
        )
        ->where('home_line', 'ASI-1')
        ->get()
        ->map(function ($item) {
            return [
                'id'            => $item->id,
                'part_name'     => $item->part_name,
                'part_no'       => $item->part_no,
                'home_line'     => $item->home_line,
                'job_no'        => $item->job_no,
                'qty_min'       => $item->qty_min,
                'qty_kanban'    => $item->qty_kanban,
            ];
        });

    return response()->json(['data' => $materials]);
}

public function total2(Request $request)
{
    $materials = DB::table('tabel_stok_blanks')
        ->select(
            'id',
            'part_name',
            'part_no',
            'home_line',
            'job_no',
            'qty_min',
            'qty_kanban'
        )
        ->where('home_line', 'ASI-2')
        ->get()
        ->map(function ($item) {
            return [
                'id'            => $item->id,
                'part_name'     => $item->part_name,
                'part_no'       => $item->part_no,
                'home_line'     => $item->home_line,
                'job_no'        => $item->job_no,
                'qty_min'       => $item->qty_min,
                'qty_kanban'    => $item->qty_kanban,
            ];
        });

    return response()->json(['data' => $materials]);
}




public function getSafeData(Request $request)
{
    $id = $request->input('id'); // Ambil id dari request

    // Hitung jumlah baris dengan kondisi qty_kanban >= qty_min dan home_line = 'ASI-1' dan keterangan != 2
    $row = DB::table('tabel_stok_blanks')
        ->where(function ($query) {
            $query->whereColumn('qty_kanban', '>=', 'qty_min');
        })
        ->where('home_line', 'ASI-1') // ✅ Tambahkan filter ASI-1
        // ->where('keterangan', '!=', 2)
        ->when($id, function ($query, $id) {
            return $query->where('id', $id);
        })
        ->count();

    // Ambil data dengan kondisi yang sama
    $safeData = DB::table('tabel_stok_blanks')
    ->select(
        'id',
        'part_name',
        'part_no',
        'home_line',
        'job_no',
        'qty_min',
        'qty_kanban',
    
    )
    ->where(function ($query) {
        $query->whereColumn('qty_kanban', '>', 'qty_min');
    })
    ->where('home_line', 'ASI-1')
    ->when($id, function ($query, $id) {
        return $query->where('id', $id);
    })
    ->get();


    return response()->json([
        'count' => $row,
        'data'  => $safeData
    ]);
}

public function getSafeData2(Request $request)
{
    $id = $request->input('id'); // Ambil id dari request

    // Hitung jumlah baris dengan kondisi qty_kanban >= qty_min dan home_line = 'ASI-1' dan keterangan != 2
    $row = DB::table('tabel_stok_blanks')
        ->where(function ($query) {
            $query->whereColumn('qty_kanban', '>=', 'qty_min');
        })
        ->where('home_line', 'ASI-2') // ✅ Tambahkan filter ASI-2
        // ->where('keterangan', '!=', 2)
        ->when($id, function ($query, $id) {
            return $query->where('id', $id);
        })
        ->count();

    // Ambil data dengan kondisi yang sama
    $safeData = DB::table('tabel_stok_blanks')
    ->select(
        'id',
        'part_name',
        'part_no',
        'home_line',
        'job_no',
        'qty_min',
        'qty_kanban',
    
    )
    ->where(function ($query) {
        $query->whereColumn('qty_kanban', '>', 'qty_min');
    })
    ->where('home_line', 'ASI-2')
    ->when($id, function ($query, $id) {
        return $query->where('id', $id);
    })
    ->get();


    return response()->json([
        'count' => $row,
        'data'  => $safeData
    ]);
}

public function getCritcalData(Request $request)
{
    $id = $request->input('id');

    $criticalData = DB::table('tabel_stok_blanks as a')
        ->select(
           'id',
            'part_name',
            'part_no',
            'home_line',
            'job_no',
            'qty_min',
            'qty_kanban',
           
        )
      
        ->where('a.home_line', 'ASI-1')
        ->where(function ($query) {
            $query->whereColumn('a.qty_kanban', '<', 'a.qty_min');
                //   ->orWhereNull('a.qty_kanban')
                //   ->orWhere('a.qty_kanban', 0);
        })
        ->when($id, function ($query, $id) {
            return $query->where('a.id', $id);
        })
        ->get()
        ->map(function ($item) {
            return [
                'part_name'     => $item->part_name,
                'part_no'       => $item->part_no,
                'job_no'        => $item->job_no,
                'home_line'      => $item->home_line,
                'qty_kanban'        => $item->qty_kanban,
                'qty_min'      => $item->qty_min,
                
            ];
        });

    return response()->json($criticalData);
}

public function getCritcalData2(Request $request)
{
    $id = $request->input('id');

    $criticalData = DB::table('tabel_stok_blanks as a')
        ->select(
           'id',
            'part_name',
            'part_no',
            'home_line',
            'job_no',
            'qty_min',
            'qty_kanban',
           
        )
      
        ->where('a.home_line', 'ASI-2')
        ->where(function ($query) {
            $query->whereColumn('a.qty_kanban', '<', 'a.qty_min');
                //   ->orWhereNull('a.qty_kanban')
                //   ->orWhere('a.qty_kanban', 0);
        })
        ->when($id, function ($query, $id) {
            return $query->where('a.id', $id);
        })
        ->get()
        ->map(function ($item) {
            return [
                'part_name'     => $item->part_name,
                'part_no'       => $item->part_no,
                'job_no'        => $item->job_no,
                'home_line'      => $item->home_line,
                'qty_kanban'        => $item->qty_kanban,
                'qty_min'      => $item->qty_min,
                
            ];
        });

    return response()->json($criticalData);
}

public function getPartTa(Request $request)
{
    $id = $request->input('id');

    $safeData = DB::table('tabel_stok_blanks as a')
        ->select(
            'a.id',
            'a.part_name',
            'a.part_no',
            'a.home_line',
            'a.job_no',
            'a.qty_min',
            'a.qty_kanban'
        )
        ->where('a.home_line', 'ASI-1')
        ->where('a.qty_kanban', 0) // hanya qty_kanban = 0
        // ->where('a.qty_min', '!=', 0) // qty_min tidak 0
        ->when($id, function ($query, $id) {
            return $query->where('a.id', $id);
        })
        ->get()
        ->map(function ($item) {
            return [
                'id'            => $item->id,
                'part_name'     => $item->part_name,
                'part_no'       => $item->part_no,
                'home_line'     => $item->home_line,
                'job_no'        => $item->job_no,
                'qty_min'       => $item->qty_min,
                'qty_kanban'    => $item->qty_kanban,
            ];
        });

    return response()->json($safeData);
}

public function getPartTa2(Request $request)
{
    $id = $request->input('id');

    $safeData = DB::table('tabel_stok_blanks as a')
        ->select(
            'a.id',
            'a.part_name',
            'a.part_no',
            'a.home_line',
            'a.job_no',
            'a.qty_min',
            'a.qty_kanban'
        )
        ->where('a.home_line', 'ASI-2')
        ->where('a.qty_kanban', 0) // hanya qty_kanban = 0
        // ->where('a.qty_min', '!=', 0) // qty_min tidak 0
        ->when($id, function ($query, $id) {
            return $query->where('a.id', $id);
        })
        ->get()
        ->map(function ($item) {
            return [
                'id'            => $item->id,
                'part_name'     => $item->part_name,
                'part_no'       => $item->part_no,
                'home_line'     => $item->home_line,
                'job_no'        => $item->job_no,
                'qty_min'       => $item->qty_min,
                'qty_kanban'    => $item->qty_kanban,
            ];
        });

    return response()->json($safeData);
}



}

