<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\DataCostumer;
use DataTables;

class DataCostumerController extends Controller
{
    public function index()
    {
        $title = 'Model';
        return view('line.DataCostumer', compact('title'));
    }

    public function list()
    {
        $query = DataCostumer::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $costumer               = new DataCostumer;
        $costumer->name         = $request->nama;
        $costumer->description  = $request->description;
        $costumer->createdby    = auth()->user()->id;
        $query              = $costumer->save();
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
        $cek = DataCostumer::where('id', $request->id)->count();
        if($cek > 0){
            $row = DataCostumer::where('id', $request->id)->first();
            return response()->json([
                'success'       => true,
                'id'            => $row->id,
                'name'          => $row->name,
                'description'   => $row->description,
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
        $data['updatedby']      = auth()->user()->id;
        $query = DataCostumer::where('id', $request->id)->update($data);
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
        $query = DataCostumer::where('id', $request->id)->delete();
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
