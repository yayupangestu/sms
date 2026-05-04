<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\DataFgStamping;
use App\Exports\TabelDataFgExport;
use App\Imports\ImportFgStamping; // Pastikan namespace ini benar
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class DataFgStampingController extends Controller
{
    public function index()
    {
        $title = 'Model';
        return view('line.datafgstamping', compact('title'));
    }

    public function list()
    {
        $query = DataFgStamping::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $model               = new DataFgStamping;
        $model->name         = $request->nama;
        $model->description  = $request->description;
        $model->createdby    = auth()->user()->id;
        $query              = $model->save();
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
        $cek = DataFgStamping::where('id', $request->id)->count();
        if($cek > 0){
            $row = DataFgStamping::where('id', $request->id)->first();
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
        $query = DataFgStamping::where('id', $request->id)->update($data);
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
        $query = DataFgStamping::where('id', $request->id)->delete();
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


    public function importDp(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        // Import data menggunakan class DataPartNameImport
        Excel::import(new ImportFgStamping, $request->file('file')->store('temp'));

        return back()->with('success', 'Data DN berhasil diimport!');
    }

     public function export()
    {

        return Excel::download(new TabelDataFgExport, 'TabelDataFgExport.xlsx');
    }

}
