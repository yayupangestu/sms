<?php

namespace App\Http\Controllers;
use App\Models\RmSupplierNut;
use Illuminate\Http\Request;
use App\Exports\RmSupplierExport;
// use App\Models\StrStokAtk;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class RmSupplierNutController extends Controller
{
  public function index()
  {
        $title = 'List Supplier NUT';
        return view('rmmaterial.suplaiernut', compact('title'));
  }

    public function list()
    {
        $query = RmSupplierNut::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $supplier               = new RmSupplierNut;
        $supplier->name_suplai  = $request->name_suplai;
        $supplier->alamat       = $request->alamat;
        $supplier->pt           = $request->pt;
        $supplier->hp           = $request->hp;
        $supplier->description  = $request->description;
        $supplier->pic          = $request->pic;
        $supplier->createdby    = auth()->user()->id;
        $query                  = $supplier->save();
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
        $cek = RmSupplierNut::where('id', $request->id)->count();
        if($cek > 0){
            $row = RmSupplierNut::where('id', $request->id)->first();
            return response()->json([
                'success'       => true,
                'id'            => $row->id,
                'name_suplai'   => $row->name_suplai,
                'pt'            => $row->pt,
                'alamat'        => $row->alamat,
                'hp'            => $row->hp,
                'pic'           => $row->pic,
                'description'   => $row->description
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
        $data['name_suplai']           = $request->name_suplai;
        $data['alamat']         = $request->alamat;
        $data['pt']             = $request->pt;
        $data['hp']             = $request->hp;
        $data['pic']            = $request->pic;
        $data['description']    = $request->description;
        $data['updatedby']         = auth()->user()->id;
        $query = RmSupplierNut::where('id', $request->id)->update($data);
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
        $query = RmSupplierNut::where('id', $request->id)->delete();
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
        return Excel::download(new RmSupplierNutExport, 'users.xlsx');
    }
}