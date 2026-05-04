<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabelStokSbc;
use Illuminate\Support\Facades\DB;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StokLineStoreExport2;
// use DB;

class LineStoreIndexController extends Controller
{
    public function index () {
        $title = 'Line Store SBC';
        $tabel_stok_sbcs = TabelStokSbc::all();
        return view('linestore.index', compact('title','tabel_stok_sbcs'));
    }

    public function detail(Request $request)
    {
        // Dapatkan nilai 'model' dari request
        $home_line = $request->input('home_line');
    
        // Query untuk mengambil data dan memfilter berdasarkan 'model'
        $materials = DB::table('tabel_stok_sbcs as a')
        ->select('a.id','a.part_name','a.part_no','a.job_no','a.home_line','a.customer','a.qty_min','a.qty','a.qty_kanban','a.category','a.line_proses')
            ->where('a.home_line', $home_line) // Filter berdasarkan kolom 'model'
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'part_name'     => $item->part_name,
                    'part_no'       => $item->part_no,
                    'job_no'        => $item->job_no,
                    'home_line'     => $item->home_line,
                    'qty_min'       => $item->qty_min,
                    'qty_act_ls'    => $item->qty_act_ls,
                    'qty_kanban'    => $item->qty_kanban,
                    'line_proses'   => $item->line_proses,
                    'customer'      => $item->customer,
                ];
            });
    
        // Mengembalikan data dalam format JSON
        return response()->json($materials);
    }

    // public function getTcf2Data()
    // {
    //     $data = DB::table('tabel_stok_sbcs')
    //         ->where('customer', 'TCF-2') // Filter berdasarkan customer "TCF-2"
    //         ->select('job_no','part_name', 'part_no','model','customer','qty_min','qty_act_ls','qty_kanban','home_line) // Hapus koma terakhir di 'part_no'
    //         ->get();
    
    //     return response()->json($data);
    // }

    public function export(Request $request)
    {
        $filter = $request->input('supplierFilter'); // Ambil nilai filter dari form
        return Excel::download(new StokLineStoreExport2($filter), 'Informasi Stok Line Store.xlsx');
    }
    

    public function getTcf2Data(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('supplier', 'TCF-2') // Filter berdasarkan customer "TCF-2"
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line','strength')
                ->get(); // ✅ Tambahkan ini untuk mengambil data
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getGehoData(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('supplier', 'GEHO') // Filter berdasarkan customer "GEHO"
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line','strength')
                ->get(); // ✅ Tambahkan ini untuk mengambil data
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }


    public function getSwtData(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('supplier', 'SWT') // Filter berdasarkan customer "GEHO"
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line','strength')
                ->get(); // ✅ Tambahkan ini untuk mengambil data
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getTcf2Data2(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('supplier', 'TCF-2') // Filter berdasarkan customer "TCF-2"
                ->whereColumn('qty_act_ls', '>=', 'qty_min') // Hanya data dengan qty_act_ls >= qty_min
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line')
                ->get(); // Mengambil data setelah filter diterapkan
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getGehoData2(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('supplier', 'GEHO') // Filter berdasarkan customer "TCF-2"
                ->whereColumn('qty_act_ls', '>=', 'qty_min') // Hanya data dengan qty_act_ls >= qty_min
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line')
                ->get(); // Mengambil data setelah filter diterapkan
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getSwtData2(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('supplier', 'SWT') // Filter berdasarkan customer "TCF-2"
                ->whereColumn('qty_act_ls', '>=', 'qty_min') // Hanya data dengan qty_act_ls >= qty_min
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line')
                ->get(); // Mengambil data setelah filter diterapkan
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getTcf2Data3(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('supplier', 'TCF-2') // Filter berdasarkan customer "TCF-2"
                ->where('qty_min', '>=', 0) // Pastikan qty_min lebih dari atau sama dengan 0
                ->whereColumn('qty_act_ls', '<', 'qty_min') // Hanya data dengan qty_act_ls lebih kecil dari qty_min
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getGehoData3(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('supplier', 'GEHO') // Filter berdasarkan customer "TCF-2"
                ->where('qty_min', '>=', 0) // Pastikan qty_min lebih dari atau sama dengan 0
                ->whereColumn('qty_act_ls', '<', 'qty_min') // Hanya data dengan qty_act_ls lebih kecil dari qty_min
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getSwtData3(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('supplier', 'SWT') // Filter berdasarkan customer "TCF-2"
                ->where('qty_min', '>=', 0) // Pastikan qty_min lebih dari atau sama dengan 0
                ->whereColumn('qty_act_ls', '<', 'qty_min') // Hanya data dengan qty_act_ls lebih kecil dari qty_min
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }


    public function getTotalPart(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('home_line', 'OUTHOUSE') // Filter berdasarkan customer "TCF-2"
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line')
                ->get(); 
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }
    
    public function getSafePart(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
            ->where('home_line', 'OUTHOUSE')
            ->where(function($query) {
                $query->whereColumn('qty_act_ls', '>', 'qty_min')
                    ->orWhereColumn('qty_act_ls', '=', 'qty_min');
            })
            ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line')
            ->get();

            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getCrticalPart(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('home_line', 'OUTHOUSE') // Filter berdasarkan customer "TCF-2"
                // ->where('qty_min', '>=', ) // Pastikan qty_min lebih dari atau sama dengan 0
                ->whereColumn('qty_act_ls', '<', 'qty_min') // Hanya data dengan qty_act_ls lebih kecil dari qty_min
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }

    public function getTaPart(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tabel_stok_sbcs')
                ->where('home_line', 'OUTHOUSE') // Filter berdasarkan customer "TCF-2"
                ->where('qty_act_ls', '=', 0) // Pastikan qty_min lebih dari atau sama dengan 0
                // ->whereColumn('qty_act_ls', '<', 'qty_min') // Hanya data dengan qty_act_ls lebih kecil dari qty_min
                ->select('job_no', 'part_name', 'part_no', 'model', 'customer', 'qty_min', 'qty_act_ls', 'qty_kanban', 'home_line')
                ->get(); // Mengambil data setelah filter diterapkan
    
            return DataTables::of($data)
                ->addIndexColumn() // Tambahkan nomor index
                ->make(true);
        }
    }
    
}

