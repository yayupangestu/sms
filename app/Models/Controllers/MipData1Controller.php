<?php

namespace App\Http\Controllers;
use App\Models\MipData1;
use Illuminate\Http\Request;
use DataTables;

class MipData1Controller extends Controller
{
    public function index()
    {
        $title = 'Data';
        return view('mip.data1', compact('title'));
    }

    public function list()
    {
        $query = MipData1::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $data               = new MipData1;
        $data->name         = $request->nama;
        $data->description  = $request->description;
        $data->createdby    = auth()->user()->id;
        $query              = $data->save();
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
        $cek = MipData1::where('id', $request->id)->count();
        if($cek > 0){
            $row = MipData1::where('id', $request->id)->first();
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
        $data['updatedby']         = auth()->user()->id;
        $query = data::where('id', $request->id)->update($data);
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
        $query = MipData1::where('id', $request->id)->delete();
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
