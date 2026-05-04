<?php

namespace App\Http\Controllers;
use App\Models\LineStoreStok;
use Illuminate\Http\Request;
use App\Exports\PartNameExport;
use App\Imports\LineStoreStokImport; // Pastikan namespace ini benar
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;

class LineStoreStokController extends Controller
{
    public function index()
    {
        $title = 'Part Name';
        return view('linestore.tabelstok', compact('title'));
    }

   public function list(Request $request)
{
    // Ambil nilai home_line dari request
    $homeLines = $request->input('home_line');

    // Query dengan filter home_line jika tersedia
    $query = DB::table('line_store_stoks as a')
        ->select('a.category','a.job_no', 'a.part_name', 'a.part_no', 'a.model', 'a.home_line','a.customer','a.id as id','b.username as createdby','a.created_at','qty_kanban','a.qty_min','a.qty_actual')
        ->join('users as b', 'b.id', '=', 'a.createdby', 'left');
        // ->join('data_costumers as c', 'c.id', '=', 'a.customer', 'left');

    // Jika filter home_line diberikan sebagai array, gunakan whereIn
    if (!empty($homeLines)) {
        // Jika hanya satu line diberikan, array tidak diperlukan
        if (is_array($homeLines)) {
            $query->whereIn('a.home_line', $homeLines);
        } else {
            $query->where('a.home_line', $homeLines);
        }
    }

    $result = $query->get();

    return DataTables::of($result)->make();
}


public function store(Request $request)
{
    $store                      = new LineStoreStok;
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
        $cek = LineStoreStok::where('id', $request->id)->count();
        if($cek > 0){
            $row = LineStoreStok::where('id', $request->id)->first();
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
        $query = LineStoreStok::where('id', $request->id)->update($data);
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
        $query = LineStoreStok::where('id', $request->id)->delete();
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

    public function importLs(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
    
        // Import data menggunakan class LineStoreStokImport
        Excel::import(new LineStoreStokImport, $request->file('file')->store('temp'));
    
        return back()->with('success', 'Data Line Store berhasil diimport!');
    }
    

    public function export(Request $request) 
    {
        // Ambil filter dari request
        $lineFilter = $request->input('line', 'A1,A2'); // Default ke 'A1,A2'
    
        return Excel::download(new PartNameExport($lineFilter), 'PartName.xlsx');
    }
    
}

