<?php

namespace App\Http\Controllers;
use App\Models\TabelStokBlank;
use Illuminate\Http\Request;
use App\Imports\TabelStokBlankImport; // Pastikan namespace ini benar
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BlankExport;
use App\Models\ScanInBlank;
use App\Models\ScanOutBlank;
use App\Models\TagLabelBlank;
use DataTables;
use DB;

class TabelStokBlankController extends Controller
{
    public function index()
    {
        $title = 'Master Blank';
        return view('blank.datablank', compact('title'));
    }

    public function list(Request $request)
    {
        $homeLines = $request->input('home_line');
    
        $query = DB::table('tabel_stok_blanks as a')
            ->select(
                'a.category', 'a.job_no', 'a.part_name', 'a.part_no','a.part_no2', 'a.model_id',
                'a.home_line', 'a.id as id',
                'b.username as createdby', 'a.created_at', 'qty_kanban',
                'a.qty_min', 'a.qty_actual'
            )
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left');
    
        if (!empty($homeLines)) {
            $homeLinesArray = is_array($homeLines) ? $homeLines : explode(',', $homeLines);
            $includeNull = in_array('null', $homeLinesArray);
            $filteredLines = array_filter($homeLinesArray, fn($line) => $line !== 'null');
    
            $query->where(function ($q) use ($filteredLines, $includeNull) {
                if (!empty($filteredLines)) {
                    $q->whereIn('a.home_line', $filteredLines);
                }
    
                if ($includeNull) {
                    $q->orWhereNull('a.home_line');
                }
            });
        }
    
        $result = $query->get();
    
        return DataTables::of($result)->make();
    }
    

public function store(Request $request)
{
    $store                      = new TabelStokBlank;
    $store->category            = $request->category;
    $store->job_no              = $request->job_no;
    $store->part_name           = $request->part_name;
    $store->part_no             = $request->part_no;
    $store->customer            = $request->customer;
    $store->model               = $request->model;
    $store->qty_min             = $request->qty_min;
    $store->qty_actual          = $request->qty_actual;
    $store->qty_kanban          = $request->qty_kanban;
    $store->home_line           = $request->home_line;
    $store->createdby    = auth()->user()->id;
    $query              = $store->save();
    if($query){
        return response()->json([
            'success'   => true,
            'msg'       => 'Insert success.'
        ]);
    }else{
        return response()->json([
            'success'   => false,
            'msg'       => 'Insert failed.'
        ]);
    }
}
    public function edit(Request $request)
    {
        $cek = TabelStokBlank::where('id', $request->id)->count();
        if($cek > 0){
            $row = TabelStokBlank::where('id', $request->id)->first();
            return response()->json([
                'success'           => true,
                'id'                => $row->id,
                'category'          => $row->category,
                'job_no'            => $row->job_no,
                'part_name'         => $row->part_name,
                'part_no'           => $row->part_no,
                'customer'          => $row->customer,
                'model'             => $row->model,
                'qty_min'           => $row->qty_min,
                'qty_actual'        => $row->qty_actual,
                'qty_kanban'        => $row->qty_kanban,
                'home_line'         => $row->home_line,
          
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Data Not found.'
            ]);
        }
    }

    public function update(Request $request)
    {
        $data['category']               = $request->category;
        $data['job_no']                 = $request->job_no;
        $data['part_name']              = $request->part_name;
        $data['part_no']                = $request->part_no;
        $data['customer']               = $request->customer;
        $data['model']                  = $request->model;
        $data['qty_min']                = $request->qty_min;
        $data['qty_actual']             = $request->qty_actual;
        $data['qty_kanban']             = $request->qty_kanban;
        $data['home_line']              = $request->home_line;
        // $data['updateby']               = auth()->user()->id;
        $query = TabelStokBlank::where('id', $request->id)->update($data);
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Update success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Update failed.'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $query = TabelStokBlank::where('id', $request->id)->delete();
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Delete success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Delete failed.'
            ]);
        }
    }

    public function importBlank(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
    
        // Import data menggunakan class TabelStokBlankImport
        Excel::import(new TabelStokBlankImport, $request->file('file')->store('temp'));
    
        return back()->with('success', 'Data Line Store berhasil diimport!');
    }
    

    public function export(Request $request) 
    
    {
        return Excel::download(new BlankExport, 'PartName.xlsx');
    }

    public function detail(Request $request)
    {
        // Ambil semua data yang memiliki part_no yang sama
        $data = ScanInBlank::where('part_no', $request->part_no)->get();
    
        if ($data->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Data not found.'
            ]);
        }
    }
    
    public function detailOut(Request $request)
    {
        // Step 1: Cari kode_material dari tag_label_blanks berdasarkan uniqNo
        $kodeMaterial = DB::table('scan_in_blanks')
                          ->where('uniqNo', $request->uniqNo)
                          ->value('uniqNo');
    
        if (!$kodeMaterial) {
            return response()->json([
                'success' => false,
                'msg' => 'kode_material not found for this uniqNo.'
            ]);
        }
    
        // Step 2: Ambil data dari scan_in_blanks berdasarkan kode_material
        $data = TagLabelBlank::where('kode_material', $kodeMaterial)->get();
    
        if ($data->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'No data found in scan_in_blanks for this kode_material.'
            ]);
        }
    }
    
    
}

