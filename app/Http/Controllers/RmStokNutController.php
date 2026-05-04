<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RmInNut;
use App\Models\RmStandartNut;
use App\Models\RmSupplierNut;
use App\Models\RmStokNut;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DataTables;
use DB;

class RmStokNutController extends Controller
{
    public function index()
    {
        $title = 'STOK SP NUT';
        $rm_standart_nuts = RmStandartNut::all();
        $rm_supplier_nuts = RmSupplierNut ::all();
        // $str_barangs = StrBarang::all();
        // $str_barangs = DB::table('str_barangs as a')
        //                    ->select('a.id','a.name','b.name as category')
        //                    ->join('str_categories as b', 'b.id', '=', 'a.category','left')
        //                 //    ->join('str_barangs as d', '.id', '=', 'a.category','left')
        //                    ->get();
        return view('rmmaterial.stoknut', compact('title','rm_standart_nuts','rm_supplier_nuts'));
    }


    

    public function list()
    {
        $query = DB::table('rm_stok_nuts as a')
                        ->select('a.minimal','a.actual','a.category','b.part_nut as part_nut','a.id as id',)
                        ->join('rm_standart_nuts as b', 'b.id', '=', 'a.part_nut', 'left')
                        // ->join('str_uoms as c', 'c.id', '=', 'a.satuan','left')
                // ->join('materials as c', 'c.id', '=', 'a.actual', 'left')
                ->get();
        return DataTables::of($query)->make();
    }

 public function store(Request $request)
    {
        $stok                    = new RmStokNut;
        $stok->part_nut          = $request->part_nut;
        $stok->category          = $request->category;
        $stok->minimal           = $request->minimal;
        $stok->actual            = $request->actual;
        $stok->createdby         = auth()->user()->id;
        $query                   = $stok->save();
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
        $cek = RmStokNut::where('id', $request->id)->count();
        if($cek > 0){
            $row = RmStokNut::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'part_nut'    => $row->part_nut,
                'category'       => $row->category,
                'minimal'        => $row->minimal,
                'actual'         => $row->actual,
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
        $data['part_nut']           = $request->part_nut;
        $data['category']           = $request->category;
        $data['minimal']            = $request->minimal;
        $data['actual']             = $request->actual;
        $data['updatedby']           = auth()->user()->id;
        $query = RmStokNut::where('id', $request->id)->update($data);
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
        $query = RmStokNut::where('id', $request->id)->delete();
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

}

