<?php

namespace App\Http\Controllers;
// use App\Exports\ReportB3Export;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LineStmp;
use App\Models\TabelC2;
use App\Models\DataPartName;
use App\Models\PlanningLineC2;
use App\Models\DataModel;
use App\Models\RmMaterial;
use Illuminate\Http\Request;
use DataTables;
use DB;

class PlanningLineC2Controller extends Controller
{
    public function index()
    {
        $title = 'Planning Line';
        $line_stmps = LineStmp::all();
        $data_part_names = DataPartName::all();
        $rm_materials = RmMaterial::all();
        $data_models = DataModel::all();
        $tabel_c2_s = DB::table('tabel_c2_s as a')
                ->select('a.type_id','b.job_no as job_no','b.part_name as part_no','d.name as model_id','c.spek as spec_id','a.id as id')
                ->join('data_part_names as b', 'b.id', '=', 'a.job_no', 'left')
                ->join('rm_materials as c', 'c.id', '=', 'a.spec_id', 'left')
                ->join('data_models as d', 'd.id', '=', 'a.model_id', 'left')
                ->get();
        return view('planningline.planningc2', compact('title','line_stmps','data_part_names','rm_materials','tabel_c2_s'));
    }

    public function list()
    {
        $query = DB::table('planning_line_c2_s as a')
                ->select('a.date_plan','b.name as line',DB::raw('CONCAT(a.date_plan, b.id)as mix_id'))
                ->join('line_stmps as b', 'b.id', '=', 'a.line_id', 'left')
                ->groupBy('a.date_plan')
                ->groupBy('a.line_id')
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('planning_line_c2_s as a')
                ->select('a.id','e.part_name', 'a.qty_plan','d.spek','e.job_no','e.model')
                ->join('line_stmps as b', 'b.id', '=', 'a.line_id', 'left')
                ->join('tabel_c2_s as c', 'c.id', '=', 'a.product_id', 'left')
                ->join('rm_materials as d', 'd.id', '=', 'c.spec_id', 'left')
                ->join('data_part_names as e', 'e.id', '=', 'c.job_no', 'left')
                ->where('a.date_plan', $request->date_plan)
                ->where('a.line_id', $request->line_id)
                ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $plan               = new PlanningLineC2;
        $plan->date_plan    = $request->date_plan;
        $plan->line_id      = $request->line_id;
        $plan->product_id   = $request->product_id;
        $plan->qty_plan     = $request->qty_plan;
        // $plan->material_id  = $request->material_id;
        $plan->createdby    = auth()->user()->id;
        $query              = $plan->save();
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
        $cek = PlanningLineC2::where('id', $request->id)->count();
        if($cek > 0){
            $row = PlanningLineC2::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'product_id'    => $row->product_id,
                'qty_plan'       => $row->qty_plan,
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
        $data['product_id']      = $request->product_id;
        $data['qty_plan']        = $request->qty_plan;
        $data['updatedby']       = auth()->user()->id;
        $query = PlanningLineC2::where('id', $request->id)->update($data);
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Edit success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Edit failed.'
            ]);
        }
    }

    public function destroyline(Request $request)
    {
        $query = PlanningLineC2::where('id', $request->id)->delete();
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

    public function destroy(Request $request)
    {
        $query = PlanningLineC2::where('date_plan', $request->date_plan)->where('line_id', $request->idline)->delete();
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

    public function export() 

    {
         return Excel::download(new ReportB3Export, 'report.xlsx');
    }

}
