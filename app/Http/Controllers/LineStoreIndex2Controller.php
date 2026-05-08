<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LineStoreStok;
use Illuminate\Support\Facades\DB;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StokLineStoreExport;
use App\Models\ScanPartBps;
// use DB;
use App\Models\ScanOutStmp;


class LineStoreIndex2Controller extends Controller
{
    public function index () {
        $title = 'Line Store Index';
        $line_store_stoks = LineStoreStok::all();
        return view('linestore.index2', compact('title','line_store_stoks'));
    }

    public function detail(Request $request)
    {
        // Dapatkan nilai 'model' dari request
        $home_line = $request->input('home_line');
    
        // Query untuk mengambil data dan memfilter berdasarkan 'model'
        $materials = DB::table('line_store_stoks as a')
        ->select('a.id','a.part_name','a.part_no','a.job_no','a.home_line','a.customer','a.qty_min','a.qty_actual','a.qty_kanban','a.category','a.line_proses')
            ->where('a.home_line', $home_line) // Filter berdasarkan kolom 'model'
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'part_name'     => $item->part_name,
                    'part_no'   => $item->part_no,
                    'job_no'        => $item->job_no,
                    'home_line'         => $item->home_line,
                    'qty_min'          => $item->qty_min,
                    'qty_actual'   => $item->qty_actual,
                    'qty_kanban'        => $item->qty_kanban,
                    'category'        => $item->category,
                    'line_proses'        => $item->line_proses,
                    'customer'      => $item->customer,
                ];
            });
    
        // Mengembalikan data dalam format JSON
        return response()->json($materials);
    }

    // public function getTcf2Data()
    // {
    //     $data = DB::table('line_store_stoks')
    //         ->where('customer', 'TCF-2') // Filter berdasarkan customer "TCF-2"
    //         ->select('job_no','part_name', 'part_no','model','customer','qty_min','qty_actual','qty_kanban','home_line','category') // Hapus koma terakhir di 'part_no'
    //         ->get();
    
    //     return response()->json($data);
    // }

    public function export(Request $request)
{
    $filter = $request->input('supplierFilter'); // Ambil nilai filter dari form
    return Excel::download(new StokLineStoreExport($filter), 'Informasi Stok Line Store.xlsx');
}

// app/Http/Controllers/ScanOutStmpsController.php
public function getScanOutStmps(Request $request)
{
    $partNo2 = $request->input('part_no2');

    // Periksa apakah part_no2 diterima dengan benar
    if (!$partNo2) {
        return response()->json(['data' => [], 'message' => 'No part_no2 provided']);
    }

    // Ambil data berdasarkan part_no2 dan tampilkan kolom uniqNo
    $data = ScanOutStmp::where('part_no2', $partNo2)
        ->select('uniqNo', 'job_no', 'part_no2', 'model', 'qty_act','qty_ng','createdby', 'date_plan', 'kode_material','date_scan','status','status_2','ng_repair','scan_in_ls')
        ->orderBy('date_plan', 'desc')
        ->orderBy('date_scan', 'desc')
        ->get();

    // Return data
    return response()->json(['data' => $data]);
}


public function getScanPartBps(Request $request)
{
    $part_no2 = $request->input('part_no2');
    $uniqNo = $request->input('uniqNo');

    $data = ScanPartBps::where('part_no2', $part_no2)
                ->where('uniqNo', $uniqNo)
                ->orderBy('date_plan', 'desc')
                ->get();

    return response()->json(['data' => $data]);
}





public function getPlanningLineB3(Request $request)
{
    $partNo2 = $request->input('part_no2');
    $datePlan = $request->input('date_plan');
    
    // Fetch only the required columns
    $data = DB::table('planning_line_b3_s')
        ->select('mesin', 'model_id', 'qty_plan', 'rm_spek', 'part_no2', 'date_plan','createdby','created_at')
        ->where('part_no2', $partNo2)
        ->where('date_plan', $datePlan)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json(['data' => $data]);
}

    public function getTotalPartInhouse(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'INHOUSE') // Filter berdasarkan customer "TCF-2"
                ->select('job_no', 'part_name', 'part_no', 'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); 
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getTotalPartOuthouse(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'OUTHOUSE') // Filter berdasarkan customer "TCF-2"
                ->select('job_no', 'part_name', 'part_no', 'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); 
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getSafePartInhouse(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
            ->where(function($query) {
                $query->whereColumn('qty_actual', '>', 'qty_min')
                    ;
            })
            ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
            ->orderBy('updated_at', 'desc')
            ->get();

            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getSafePartOuthouse(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'OUTHOUSE')
            ->where(function($query) {
                $query->whereColumn('qty_actual', '>', 'qty_min')
                    ;
            })
            ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
            ->orderBy('updated_at', 'desc')
            ->get();

            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getCrticalPartInhouse(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'INHOUSE')
                ->whereColumn('qty_actual', '<=', 'qty_min') // qty_actual <= qty_min
                ->where('qty_actual', '!=', 0) // Exclude qty_actual = 0
                ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function getCrticalOuthouse(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'OUTHOUSE')
                ->whereColumn('qty_actual', '<=', 'qty_min') // qty_actual <= qty_min
                ->where('qty_actual', '!=', 0) // Exclude qty_actual = 0
                ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function getTaPartInhouse(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'INHOUSE') // Filter berdasarkan customer "TCF-2"
                ->where(function ($query) {
                    $query->where('qty_actual', 0)
                          ->orWhereNull('qty_actual');
                })
                ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getTaPartOuthouse(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'OUTHOUSE') // Filter berdasarkan customer "TCF-2"
                ->where(function ($query) {
                    $query->where('qty_actual', 0)
                          ->orWhereNull('qty_actual');
                })
                ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getModelD12(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'INHOUSE')
                ->whereIn('model', ['D14N','D14N/D12L']) // Pastikan bisa membaca variasi nama
                ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function get2ModelD12(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
            ->whereIn('model', ['D14N','D14N/D12L']) // Pastikan bisa membaca variasi nama
                ->whereColumn('qty_actual', '>=', 'qty_min') // Hanya data dengan qty_actual >= qty_min
                ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }
    public function get3ModelD12(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
            ->whereIn('model', ['D14N','D14N/D12L']) // Pastikan bisa membaca variasi nama
                ->where('qty_min', '>=', 0) // Pastikan qty_min lebih dari atau sama dengan 0
                ->whereColumn('qty_actual', '<', 'qty_min') // Hanya data dengan qty_actual lebih kecil dari qty_min
                ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }
    
    public function getModelD26(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'INHOUSE')
                ->whereIn('model', ['D26A','D26A/D55L/D03B','D55L/D26A/D74A/D03B UPB','D55L/D26A/D74A']) // Pastikan bisa membaca variasi nama
                ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function get2ModelD26(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
            ->whereIn('model', ['D26A','D26A/D55L/D03B','D55L/D26A/D74A/D03B UPB','D55L/D26A/D74A']) // Pastikan bisa membaca variasi nama
                ->whereColumn('qty_actual', '>=', 'qty_min') // Hanya data dengan qty_actual >= qty_min
                ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }
    public function get3ModelD26(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
            ->whereIn('model', ['D26A', 'D26A/D55L/D03B','D55L/D26A/D74A']) // Pastikan bisa membaca variasi nama
                ->where('qty_min', '>=', 0) // Pastikan qty_min lebih dari atau sama dengan 0
                ->whereColumn('qty_actual', '<', 'qty_min') // Hanya data dengan qty_actual lebih kecil dari qty_min
                ->select('job_no', 'part_name', 'part_no',  'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getModelD40(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'INHOUSE')
                ->whereIn('model', ['D40G','D40L' ,'D40G/DCWA','D40G/D40L/D72A','D40G/D40L']) // Pastikan bisa membaca variasi nama
                ->select('job_no', 'part_name', 'part_no','part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function get2ModelD40(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
              ->whereIn('model', ['D40G','D40L', 'D40G/DCWA', 'D40G/D40L/D72A', 'D40G/D40L']) // Pastikan bisa membaca variasi nama
                ->whereColumn('qty_actual', '>=', 'qty_min') // Hanya data dengan qty_actual >= qty_min
                ->select('job_no', 'part_name', 'part_no', 'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }
    
    public function get3ModelD40(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
              ->whereIn('model', ['D40G','D40L' ,'D40G/DCWA','D40G/D40L/D72A','D40G/D40L']) // Pastikan bisa membaca variasi nama
                ->where('qty_min', '>=', 0) // Pastikan qty_min lebih dari atau sama dengan 0
                ->whereColumn('qty_actual', '<', 'qty_min') // Hanya data dengan qty_actual lebih kecil dari qty_min
                ->select('job_no', 'part_name', 'part_no', 'part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getModelD30(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'INHOUSE')
                ->whereIn('model', ['D30D','D30']) // Pastikan bisa membaca variasi nama
                ->select('job_no', 'part_name', 'part_no','part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function get2ModelD30(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
             ->whereIn('model', ['D30D','D30']) // Pastikan bisa membaca variasi nama
                ->whereColumn('qty_actual', '>=', 'qty_min') // Hanya data dengan qty_actual >= qty_min
                ->select('job_no', 'part_name', 'part_no','part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }
    public function get3ModelD30(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
             ->whereIn('model', ['D30D','D30']) // Pastikan bisa membaca variasi nama
                ->where('qty_min', '>=', 0) // Pastikan qty_min lebih dari atau sama dengan 0
                ->whereColumn('qty_actual', '<', 'qty_min') // Hanya data dengan qty_actual lebih kecil dari qty_min
                ->select('job_no', 'part_name', 'part_no','part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    
    public function getModelD03(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'INHOUSE')
                ->whereIn('model', ['D03B UNB','D03B UPB','D55L/D26A/D74A/D03B UPB','D26A/D55L/D03B']) // Pastikan bisa membaca variasi nama
                ->select('job_no', 'part_name', 'part_no','part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function get2ModelD03(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
             ->whereIn('model', ['D03B UNB','D03B UPB','D55L/D26A/D74A/D03B UPB','D26A/D55L/D03B']) // Pastikan bisa membaca variasi nama
                ->whereColumn('qty_actual', '>=', 'qty_min') // Hanya data dengan qty_actual >= qty_min
                ->select('job_no', 'part_name', 'part_no','part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }
    public function get3ModelD03(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
             ->whereIn('model', ['D03B UNB','D03B UPB','D55L/D26A/D74A/D03B UPB','D26A/D55L/D03B']) // Pastikan bisa membaca variasi nama
                ->where('qty_min', '>=', 0) // Pastikan qty_min lebih dari atau sama dengan 0
                ->whereColumn('qty_actual', '<', 'qty_min') // Hanya data dengan qty_actual lebih kecil dari qty_min
                ->select('job_no', 'part_name', 'part_no','part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getModelKS(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
                ->where('home_line', 'INHOUSE')
                ->whereIn('model', ['KS']) // Pastikan bisa membaca variasi nama
                ->select('job_no', 'part_name', 'part_no','part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get();
    
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function get2ModelKS(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
             ->whereIn('model', ['KS']) // Pastikan bisa membaca variasi nama
                ->whereColumn('qty_actual', '>=', 'qty_min') // Hanya data dengan qty_actual >= qty_min
                ->select('job_no', 'part_name', 'part_no','part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->orderBy('updated_at', 'desc')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }
    public function get3ModelKS(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('line_store_stoks')
            ->where('home_line', 'INHOUSE')
             ->whereIn('model', ['KS']) // Pastikan bisa membaca variasi nama
                ->where('qty_min', '>=', 0) // Pastikan qty_min lebih dari atau sama dengan 0
                ->whereColumn('qty_actual', '<', 'qty_min') // Hanya data dengan qty_actual lebih kecil dari qty_min
                ->select('job_no', 'part_name', 'part_no','part_no2', 'model', 'customer', 'qty_min', 'qty_actual', 'qty_kanban', 'home_line', 'category')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    

}

