<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LineStoreStok;
use App\Models\LineStoreUpload;
use App\Models\LineStoreIncomingPart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use DataTables;
use Carbon\Carbon;
// use DB;

class LineStoreIndex3Controller extends Controller
{
    public function index () {
        $title = 'Line Store Index';
        $line_store_stoks = LineStoreStok::all();
        return view('linestore.index3', compact('title','line_store_stoks'));
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
                        'part_name'         => $item->part_name,
                        'part_no'           => $item->part_no,
                        'job_no'            => $item->job_no,
                        'home_line'         => $item->home_line,
                        'qty_min'           => $item->qty_min,
                        'qty_actual'        => $item->qty_actual,
                        'qty_kanban'        => $item->qty_kanban,
                        'category'          => $item->category,
                        'line_proses'        => $item->line_proses,
                        'customer'          => $item->customer,
                    ];
                });
    
        // Mengembalikan data dalam format JSON
        return response()->json($materials);
    }
    
   // Method to get supplier data
   public function getSupplierData(Request $request)
   {
       $status = $request->status;
       $supplier = $request->supplier;
   
       $query = DB::table('line_store_uploads');
   
       if ($status === 'NULL') {
           $query->whereNull('status');
       } else {
           $query->where('status', $status);
       }
   
       if (!empty($supplier)) {
           $query->where('supplier', $supplier);
       }
   
       $data = $query->select('part_no', 'order_part', 'actual_order', 'material_out','no_dn','created_at','no_dn','balance_order','supplier')->get(); // ✅ pastikan kolom ini ada
   
       return response()->json($data);
   }
   


public function getSupplierData2(Request $request)
{
    // Retrieve the parameters passed in the AJAX request
    $partNo = $request->input('part_no');
    $noPo = $request->input('no_po');
    $noDn = $request->input('no_dn');
    $supplier = $request->input('supplier');

    // Query the database for data based on the filters
    $query = LineStoreUpload::query();

    if ($partNo) {
        $query->where('part_no', $partNo);
    }
    if ($noPo) {
        $query->where('no_po', $noPo);
    }
    if ($noDn) {
        $query->where('no_dn', $noDn);
    }
    if ($supplier) {
        $query->where('supplier', $supplier);
    }

    // Fetch the filtered data
    $partsData = $query->get(); // This will return an array of parts matching the filters

    // Return the data as a JSON response
    return response()->json($partsData);
}



    public function getLineStoreUploads(Request $request)
    {
        $supplier = $request->input('supplier');
        $status = $request->input('status'); // Ambil status dari request
        $today = Carbon::today()->toDateString(); // Ambil tanggal hari ini
    
        $query = LineStoreUpload::whereDate('tgl_delivery', $today);
    
        if ($supplier) {
            $query->where('supplier', $supplier);
        }
    
        if ($status === 'NULL') {
            $query->whereNull('status'); // Filter hanya yang status-nya NULL
        } elseif ($status) {
            $query->where('status', $status);
        }
    
        $data = $query->get();
    
        return response()->json($data);
    }


    
    public function getIncomingParts(Request $request)
{
    $noPo = $request->no_po;
    $noDn = $request->no_dn;
    $partNo = $request->part_no;

    // Ambil data dari tabel line_store_incoming_parts
    $incomingParts = DB::table('line_store_incoming_parts')
        ->where('no_po', $noPo)
        ->where('no_dn', $noDn)
        ->where('part_no', $partNo)
        ->get();

    return response()->json($incomingParts);
}

    
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'actual_order' => 'required|numeric',
            'part_no' => 'required|string',
            'supplier' => 'required|string',
            'no_po' => 'required|string',
            'no_dn' => 'required|string',
        ]);
    
        // Insert data baru ke dalam tabel line_store_incoming_part
        $lineStorePart = new LineStoreIncomingPart();
        $lineStorePart->part_no = $request->part_no;
        $lineStorePart->actual_order = $request->actual_order;
        $lineStorePart->supplier = $request->supplier;
        $lineStorePart->no_po = $request->no_po;
        $lineStorePart->no_dn = $request->no_dn;
        $lineStorePart->created_by = auth()->user()->username;
        $lineStorePart->save();
    
        // Ambil data yang baru saja dimasukkan
        $newPart = LineStoreIncomingPart::find($lineStorePart->id);
    
        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan', 'newPart' => $newPart]);
    }


    
}

