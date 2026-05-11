<?php

namespace App\Http\Controllers;
use App\Models\StrUom;
use Illuminate\Http\Request;
use DataTables;

class StrUoMController extends Controller
{
    public function index()
    {
        $title = 'Data Satuan Barang';
        return view('storeroom.uom', compact('title'));
    }

    public function list()
    {
        $query = StrUom::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $uom               = new StrUom;
        $uom->name         = $request->nama;
        $uom->description  = $request->description;
        $uom->createdby    = auth()->user()->id;
        $query              = $uom->save();
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
        $cek = StrUom::where('id', $request->id)->count();
        if($cek > 0){
            $row = StrUom::where('id', $request->id)->first();
            return response()->json([
                'success'       => true,
                'id'            => $row->id,
                'name'          => $row->name,
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
        $data['name']           = $request->nama;
        $data['description']    = $request->description;
        $data['updateby']         = auth()->user()->id;
        $query = StrUom::where('id', $request->id)->update($data);
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
        $query = StrUom::where('id', $request->id)->delete();
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