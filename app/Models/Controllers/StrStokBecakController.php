<?php

namespace App\Http\Controllers;
use App\Models\Departement;
use App\Models\StrBarang;
use App\Models\StrStokBecak;
use App\Models\StrCategory;
use App\Models\StrUom;
use App\Models\User;
use App\Exports\BecakExport;
// use App\Models\StrStokBecak;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use DataTables;
use DB;

class StrStokBecakController extends Controller
{
    public function index()
    {
        $title = 'STO BecakK';
        $str_uoms = StrUom::all();
        $str_categories = StrCategory ::all();
        // $str_barangs = StrBarang::all();
        $str_barangs = DB::table('str_barangs as a')
                           ->select('a.id','a.name','b.name as category')
                          ->leftJoin('str_categories as b', 'b.id', '=', 'a.category')
            ->where('a.category', '=', 12)
                           ->get();
        return view('storeroom.stokbecak', compact('title','str_uoms','str_barangs','str_uoms'));
    }


    

    public function list()
    {
        $query = DB::table('str_stok_becaks as a')
                        ->select('a.minimal','a.actual','a.category','b.name as item_id','a.id as id','c.name as satuan')
                        ->join('str_barangs as b', 'b.id', '=', 'a.item_id', 'left')
                        ->join('str_uoms as c', 'c.id', '=', 'a.satuan','left')
                // ->join('materials as c', 'c.id', '=', 'a.actual', 'left')
                ->get();
        return DataTables::of($query)->make();
    }

 public function store(Request $request)
    {
        $stok                    = new StrStokBecak;
        $stok->item_id           = $request->item_id;
        $stok->category          = $request->category;
        $stok->minimal           = $request->minimal;
        $stok->actual            = $request->actual;
        $stok->satuan            = $request->satuan;
        $stok->createdby         = auth()->user()->id;
        $query                      = $stok->save();
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
        $cek = StrStokBecak::where('id', $request->id)->count();
        if($cek > 0){
            $row = StrStokBecak::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'item_id'    => $row->item_id,
                'category'       => $row->category,
                'minimal'        => $row->minimal,
                'actual'         => $row->actual,
                'satuan'         => $row->satuan,
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
        $data['item_id']        = $request->item_id;
        $data['category']           = $request->category;
        $data['minimal']            = $request->minimal;
        $data['actual']             = $request->actual;
        $data['satuan']             = $request->satuan;
        $data['updatedby']           = auth()->user()->id;
        $query = StrStokBecak::where('id', $request->id)->update($data);
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
        $query = StrStokBecak::where('id', $request->id)->delete();
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

    public function export() 
    {
  
        return Excel::download(new BecakExport, 'BecakExport.xlsx');
    }
}

