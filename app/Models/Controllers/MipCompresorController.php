<?php

namespace App\Http\Controllers;
use App\Models\MipCompresor;
use Illuminate\Http\Request;
use DataTables;

class MipCompresorController extends Controller
{
    public function index()
    {
        $title = 'Data Compresor';
        return view('mip.compresor', compact('title'));
    }

    public function list()
    {
        $query = MipCompresor::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $compresor               = new MipCompresor;
        $compresor->name         = $request->nama;
        $compresor->model       = $request->model;
        $compresor->serial       = $request->serial;
        $compresor->bom          = $request->bom;
        $compresor->psig         = $request->psig;
        $compresor->bar          = $request->bar;
        $compresor->lokasi       = $request->lokasi;
        $compresor->description  = $request->description;
        $compresor->createdby    = auth()->user()->id;
        $query              = $compresor->save();
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
        $cek = MipCompresor::where('id', $request->id)->count();
        if($cek > 0){
            $row = MipCompresor::where('id', $request->id)->first();
            return response()->json([
                'success'       => true,
                'id'            => $row->id,
                'name'          => $row->name,
                'model'          => $row->model,
                'serial'        => $row->serial,
                'bom'           => $row->bom,
                'psig'          => $row->psig,
                'bar'           => $row->bar,
                'lokasi'        => $row->lokasi,
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
        $data['name']               = $request->nama;
        $data['model']             = $request->model;
        $data['serial']             = $request->serial;
        $data['bom']                = $request->bom;
        $data['psig']               = $request->psig;
        $data['bar']                = $request->bar;
        $data['lokasi']             = $request->lokasi;
        $data['description']        = $request->description;
        $data['updatedby']          = auth()->user()->id;
        $query = MipCompresor::where('id', $request->id)->update($data);
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
        $query = MipCompresor::where('id', $request->id)->delete();
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
