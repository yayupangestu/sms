<?php

namespace App\Http\Controllers;
use App\Models\LineStmp;
use App\Models\DataModel;
use App\Models\DataCostumer;
use App\Models\DataPartName;
use App\Models\RmMaterial;
use App\Models\TabelB3;
use App\Models\PcStoreDirect;
use Illuminate\Http\Request;
use App\Imports\DataPcsNameImport; // Pastikan namespace ini benar
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;
use App\Exports\PcstoreExport;

class PcStoreStok1Controller extends Controller
{
    public function index()
    {
        $title = 'PC STORE';
        $line_stmps = LineStmp::all();
        $data_part_names = DataPartName::all();
        // $data_models = DataModel::all();
        $data_costumers = DataCostumer::all();
        $rm_materials = RmMaterial::all();
        // // $tabel_b3_s = DB::table('tabel_b3_s as a')
        // // ->select('a.type_id','b.job_no as job_no','b.part_name as part_no','d.name as model_id','c.name_material as spec_id','a.id as id','e.name as home_line')
        // // ->join('data_part_names as b', 'b.id', '=', 'a.job_no', 'left')
        // // ->join('rm_materials as c', 'c.id', '=', 'a.spec_id', 'left')
        // // // ->join('data_models as d', 'd.id', '=', 'a.model_id', 'left')
        // // ->join('line_stmps as e', 'e.id', '=', 'a.home_line', 'left')
        // ->get();
        return view('pcstore.tabeldirect', compact('title','data_part_names','data_costumers','rm_materials','line_stmps'));
    }


    public function list()
    {
        $query = DB::table('pc_store_directs as a')
                ->select('a.id','a.part_name','a.part_no','a.part_no2','a.job_no','a.model','a.qty_kanban','a.customer')
                // ->join('line_stmps as b', 'b.id', '=', 'a.home_line', 'left')
                // ->join('data_part_names as c', 'c.id', '=', 'a.part_no', 'left')
                // ->join('data_models as d', 'd.id', '=', 'a.model_id', 'left')
                ->get();
        return DataTables::of($query)->make();
    }

 public function store(Request $request)
    {
        $pctabel                    = new PcStoreDirect;
        $pctabel->home_line           = $request->home_line;
        $pctabel->part_name         = $request->part_name;
        $pctabel->part_no           = $request->part_no;
        $pctabel->part_no2          = $request->part_no2;
        $pctabel->job_no            = $request->job_no;
        $pctabel->monthly_volume    = $request->monthly_volume;
        $pctabel->daily_volume      = $request->daily_volume;
        $pctabel->qty_kanban           = $request->qty_kanban;
        $pctabel->actual           = $request->actual;
        $pctabel->strenght            = $request->strenght;
        $pctabel->pallet          = $request->pallet;
        $pctabel->createdby         = auth()->user()->id;
        $query                      = $pctabel->save();
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
        $cek = PcStoreDirect::where('id', $request->id)->count();
        if($cek > 0){
            $row = PcStoreDirect::where('id', $request->id)->first();
            return response()->json([
                'success'               => true,
                'id'                    => $row->id,
                'home_line'               => $row->home_line,
                'part_name'             => $row->part_name,
                'part_no'               => $row->part_no,
                'part_no2'              => $row->part_no2,
                'job_no'                => $row->job_no,
                'monthly_volume'        => $row->monthly_volume,
                'daily_volume'          => $row->daily_volume,
                'qty_kanban'            => $row->qty_kanban,
                'actual'                => $row->actual,
                'strenght'              => $row->strenght,
                'pallet'                => $row->pallet,

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
        // Ambil nilai actual dan daily_volume dari request
        $actual = (float) $request->actual;
        $daily_volume = (float) $request->daily_volume;

        // Hitung strenght
        if ($actual > 0 && $daily_volume > 0) {
            $strenght = number_format($actual / $daily_volume, 1, ',', ''); // Format koma Indonesia
        } else {
            $strenght = '0,0';
        }

        // Konversi koma ke titik untuk perbandingan angka
        $numericStrenght = floatval(str_replace(',', '.', $strenght));

     // Tentukan status
if ($numericStrenght <= 0.5) {
    $status = 'DANGER';
} elseif ($numericStrenght > 0.5 && $numericStrenght <= 1) {
    $status = 'WARNING';
} else {
    $status = 'SAFE';
}



        // Simpan data
        $data = [
            'home_line'        => $request->home_line,
            'part_name'        => $request->part_name,
            'part_no'          => $request->part_no,
            'part_no2'         => $request->part_no2,
            'job_no'           => $request->job_no,
            'monthly_volume'   => $request->monthly_volume,
            'daily_volume'     => $request->daily_volume,
            'qty_kanban'       => $request->qty_kanban,
            'actual'           => $request->actual,
            'strenght'         => $strenght,
            'status'           => $status,
            'pallet'           => $request->pallet,
            'time_update'             => now(),
            'updateby'         => auth()->user()->username,
        ];

        $query = PcStoreDirect::where('id', $request->id)->update($data);

        if ($query) {
            return response()->json([
                'success' => true,
                'msg'     => 'Update success.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg'     => 'Update failed.'
            ]);
        }
    }


    public function destroy(Request $request)
    {
        $query = PcStoreDirect::where('id', $request->id)->delete();
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


    public function importData(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        // Import data menggunakan class DataPartNameImport
        Excel::import(new DataPcsNameImport, $request->file('file')->store('temp'));

        return back()->with('success', 'Data DN berhasil diimport!');
    }

    public function export()
    {
        return Excel::download(new PcstoreExport, 'PC Store Stok.xlsx');
    }
}



















