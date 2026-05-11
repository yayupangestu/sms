<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Departement;
use DataTables;

class DepartementController extends Controller
{
    public function index()
    {
      $title =' Data Departement';
      return view('storeroom.dept', compact('title'));
    }

    public function list()
    {
        $query = Departement::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $dept               = new Departement;
        $dept->name_dept    = $request->name_dept;
        $dept->head         = $request->head;
        $dept->code         = $request->code;
        $dept->description  = $request->description;
        $dept->createdby    = auth()->user()->id;
        $query              = $dept->save();
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
        $cek = Departement::where('id', $request->id)->count();
        if($cek > 0){
            $row = Departement::where('id', $request->id)->first();
            return response()->json([
                'success'       => true,
                'id'            => $row->id,
                'name_dept'          => $row->name_dept,
                'head'          => $row->head,
                'code'          => $row->code,
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
        $data['name_dept']      = $request->name_dept;
        $data['head']           = $request->head;
        $data['code']           = $request->code;
        $data['description']    = $request->description;
        $data['updateby']       = auth()->user()->id;
        $query = Departement::where('id', $request->id)->update($data);
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
        $query = Departement::where('id', $request->id)->delete();
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
