<?php

namespace App\Http\Controllers;
use App\Models\LineStmp;
use App\Models\DataModel;
use App\Models\DataCostumer;
use App\Models\DataPartName;
use App\Models\RmMaterial;
use App\Models\TabelListDies;
use Illuminate\Http\Request;
use DataTables;
use Maatwebsite\Excel\Facades\Excel; // ini penting
use App\Exports\FormatListDiesExport;
use App\Exports\DataListDiesExport;
use App\Imports\ListDiesImport;
use DB;

class TabelListDiesController extends Controller
{
    public function index()
    {
        $title = 'Tabel List';
        $data_part_names = DataPartName::all();
        return view('diemtc.tabellist', compact('title','data_part_names'));
    }


    public function list()
    {
        $query = DB::table('tabel_list_dies as a')
                ->select('a.id','a.part_no','a.job_no','a.model_id','a.line_id','a.part_name','a.proses','a.std_stroke')
                ->join('data_part_names as b', 'b.id', '=', 'a.part_no', 'left')
                ->get();
        return DataTables::of($query)->make();
    }



 public function store(Request $request)
    {
        $TabelListDies                    = new TabelListDies;
        $TabelListDies->part_name         = $request->part_name;
        $TabelListDies->job_no            = $request->job_no;
        $TabelListDies->part_no           = $request->part_no;
        $TabelListDies->model_id          = $request->model_id;
        $TabelListDies->line_id           = $request->line_id;
        $TabelListDies->std_stroke        = $request->std_stroke;
        $TabelListDies->proses        = $request->proses;
        $TabelListDies->createdby         = auth()->user()->id;
        $query                            = $TabelListDies->save();
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
        $cek = TabelListDies::where('id', $request->id)->count();
        if($cek > 0){
            $row = TabelListDies::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'part_no' => $row->part_no,
                'part_name'         => $row->part_name,
                'std_stroke'         => $row->std_stroke,
                'job_no'         => $row->job_no,
                'part_no'        => $row->part_no,
                'model_id'       => $row->model_id,
                'line_id'        => $row->line_id
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
        $data = [
            'part_name' => $request->part_name,
            'proses' => $request->proses,
            'job_no'   => $request->job_no,
            'part_no'  => $request->part_no,
            'model_id' => $request->model_id,
            'line_id'  => $request->line_id,
            'std_stroke' => $request->std_stroke,
            'updateby' => auth()->user()->id,
        ];

        $query = TabelListDies::where('id', $request->id)->update($data);

        if ($query === 0) {
            return response()->json([
                'success' => false,
                'msg' => 'No data updated — ID not found or values unchanged.',
                'debug' => [
                    'id' => $request->id,
                    'data' => $data,
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'msg' => 'Update success.'
        ]);
    }


    public function destroy(Request $request)
    {
        $query = TabelListDies::where('id', $request->id)->delete();
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
        Excel::import(new ListDiesImport, $request->file('file')->store('temp'));

        return back()->with('success', 'Data berhasil diimport!');
    }

    public function export()
    {

        return Excel::download(new FormatListDiesExport, 'Format Upload List.xlsx');
    }
    public function export2()
    {

        return Excel::download(new DataListDiesExport, 'Data List Dies.xlsx');
    }
}



















