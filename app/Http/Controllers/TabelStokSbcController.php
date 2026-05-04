<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabelStokSbc;
use App\Imports\SubcontImport;
use DataTables;
use Maatwebsite\Excel\Facades\Excel; // ini penting
use App\Exports\FormatTabelStokSbcExport;
use App\Exports\TabelStokSbcExport;


class TabelStokSbcController extends Controller
{
    public function index()
    {
        $title = 'Tabel Stok SUBCONT';
        return view('linestore.tabelstoksbc', compact('title'));
    }

    public function list()
    {
        $query = TabelStokSbc::all();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $sbc               = new TabelStokSbc;
        $sbc->name         = $request->nama;
        $sbc->description  = $request->description;
        $sbc->createdby    = auth()->user()->id;
        $query              = $sbc->save();
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
        $cek = TabelStokSbc::where('id', $request->id)->count();
        if($cek > 0){
            $row = TabelStokSbc::where('id', $request->id)->first();
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
        $query = TabelStokSbc::where('id', $request->id)->update($data);
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
        $query = TabelStokSbc::where('id', $request->id)->delete();
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

    public function importSbc(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        // Import data menggunakan class DataPartNameImport
        Excel::import(new SubcontImport, $request->file('file')->store('temp'));

        return back()->with('success', 'Data berhasil diimport!');
    }

    public function formatsbc()
    {

        return Excel::download(new FormatTabelStokSbcExport, 'Format Data Upload Subcont.xlsx');
    }
    public function export2()
    {

        return Excel::download(new TabelStokSbcExport, 'TabelStokSbcExport.xlsx');
    }
}
