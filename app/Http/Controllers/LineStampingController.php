<?php

namespace App\Http\Controllers;
use App\Models\LineStmp;
use Illuminate\Http\Request;
use DataTables;

class LineStampingController extends Controller
{
    public function index()
    {
        $title = 'Line Stamping';
        return view('line.stmpline', compact('title'));
    }

    public function list()
    {
        $query = LineStmp::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $line               = new LineStmp;
        $line->name         = $request->nama;
        $line->description  = $request->description;
        $line->machine      = $request->machine;
        $line->createdby    = auth()->user()->id;
        $query              = $line->save();
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
        $cek = LineStmp::where('id', $request->id)->count();
        if($cek > 0){
            $row = LineStmp::where('id', $request->id)->first();
            return response()->json([
                'success'       => true,
                'id'            => $row->id,
                'name'          => $row->name,
                'description'   => $row->description,
                'machine'       => $row->machine,
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
        $data['machine']        = $request->machine;
        $data['updatedby']      = auth()->user()->id;
        $query = LineStmp::where('id', $request->id)->update($data);
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
        $query = LineStmp::where('id', $request->id)->delete();
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
