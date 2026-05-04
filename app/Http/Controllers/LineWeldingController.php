<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataWelding;
use App\Imports\WeldingImport;
use DataTables;
use Maatwebsite\Excel\Facades\Excel; // ini penting
use App\Exports\FormatDataWeldingExport;
use App\Exports\DataWeldingExport;


class LineWeldingController extends Controller
{
    public function index()
    {
        $title = 'Line Welding';
        return view('line.weldline', compact('title'));
    }

    public function list()
    {
        $query = DataWelding::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $weld               = new DataWelding;
        $weld->name         = $request->nama;
        $weld->description  = $request->description;
        $weld->createdby    = auth()->user()->id;
        $query              = $weld->save();
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
        $cek = DataWelding::where('id', $request->id)->count();
        if($cek > 0){
            $row = DataWelding::where('id', $request->id)->first();
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
        $data['updateby']      = auth()->user()->id;
        $query = DataWelding::where('id', $request->id)->update($data);
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
        $query = DataWelding::where('id', $request->id)->delete();
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
        Excel::import(new WeldingImport, $request->file('file')->store('temp'));

        return back()->with('success', 'Data berhasil diimport!');
    }

    public function export()
    {

        return Excel::download(new FormatDataWeldingExport, 'Format Data Welding.xlsx');
    }
    public function export2()
    {

        return Excel::download(new DataWeldingExport, 'DataWeldingExport.xlsx');
    }
}
