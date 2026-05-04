<?php

namespace App\Http\Controllers;
// use App\Exports\ReportB3Export;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LineStmp;
use App\Models\TabelB3;
use App\Models\DataPartName;
use App\Models\PlanningLineB3;
use App\Models\DataModel;
use App\Models\RmMaterial;
use Illuminate\Http\Request;
use DataTables;
use Alert;
use PDF;
use DB;

class Proses1Controller extends Controller
{
    public function index()
    {
        $title = 'Information';
        $line_stmps = LineStmp::all();
        $data_part_names = DataPartName::all();
        $rm_materials = RmMaterial::all();
        $data_models = DataModel::all();
        $tabel_b3_s = DB::table('tabel_b3_s as a')
                ->select('a.type_id','b.job_no as job_no','b.part_name as part_no','d.name as model_id','c.name_material as spec_id','a.id as id')
                ->join('data_part_names as b', 'b.id', '=', 'a.job_no', 'left')
                ->join('rm_materials as c', 'c.id', '=', 'a.spec_id', 'left')
                ->join('data_models as d', 'd.id', '=', 'a.model_id', 'left')
                ->get();
        return view('stepproses.proses1', compact('title','line_stmps','data_part_names','rm_materials','tabel_b3_s'));
    }
    public function list(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        // $lineId = $request->input('line_id');
        $part_kbn_1 = $request->input('part_kbn_1');
    
        $query = DB::table('trace_abilities')
                    ->whereBetween('date_id', [$startDate, $endDate])
                    ->where('part_kbn_1', $part_kbn_1);
    
        if ($part_kbn_1) {
            $query->where('part_kbn_1', $part_kbn_1);  // Adjust 'spek_column' to your actual column name
        }
    
        $data = $query->get();
    
        return response()->json(['data' => $data]);
    }
    
    
    
    public function destroy(Request $request)
    {
        $query = Proses1::where('date_id', $request->date_id)->where('line_id', $request->idline)->delete();
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

