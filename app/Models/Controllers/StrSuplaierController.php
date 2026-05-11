<?php

namespace App\Http\Controllers;
use App\Models\StrSuplaier;
use Illuminate\Http\Request;
use DataTables;

class StrSuplaierController extends Controller
{
    public function index()
    {
        $title = 'List Supplier ';
        return view('storeroom.supplaier', compact('title'));
    }

    public function list()
    {
        $query = StrSuplaier::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $supplier               = new StrSuplaier;
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
        $cek = StrSuplaier::where('id', $request->id)->count();
        if($cek > 0){
            $row = StrSuplaier::where('id', $request->id)->first();
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
        $query = StrSuplaier::where('id', $request->id)->update($data);
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
        $query = StrSuplaier::where('id', $request->id)->delete();
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