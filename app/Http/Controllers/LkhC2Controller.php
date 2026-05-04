<?php

namespace App\Http\Controllers;
// use App\Exports\Reportc2Export;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LineStmp;
use App\Models\TabelC2;
use App\Models\DataPartName;
use App\Models\PlanningLineC2;
use App\Models\DataModel;
use App\Models\RmMaterial;
use Illuminate\Http\Request;
use DataTables;
use Alert;
use PDF;
use DB;

class Lkhc2Controller extends Controller
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
        return view('planningline.lkhc2', compact('title','line_stmps','data_part_names','rm_materials','tabel_c2_s'));
    }

    public function list(Request $request)
    {
        $query = DB::table('planning_line_c2_s as a')
                ->select('a.id','e.part_name','e.job_no','d.spek', 'a.qty_plan','a.qty_act','a.qty_ng','a.qty_gsph','a.qty_mesin','a.qty_dandori','a.ket_remark','a.qty_dies','f.name')
                ->join('line_stmps as b', 'b.id', '=', 'a.line_id', 'left')
                ->join('tabel_c2_s as c', 'c.id', '=', 'a.product_id', 'left')
                ->join('rm_materials as d', 'd.id', '=', 'c.spec_id', 'left')
                ->join('data_part_names as e', 'e.id', '=', 'c.job_no', 'left')
                ->join('users as f', 'f.id', '=', 'a.createdby', 'left')
                ->where('a.date_plan', $request->date_plan)
                ->where('a.line_id', $request->line_id)
                ->get();
        return response()->json([
            'data'  => $query
        ]);
            

    }

    public function update(Request $request)
    {
        if($request->button == "update"){
            $jml = count($request->idline);
            $jml = count($request->idng);
            $jml = count($request->idgsph);
            $jml = count($request->idmesin);
            $jml = count($request->iddies);
            $jml = count($request->iddandori);
            $jml = count($request->idremark);
            for ($i=1; $i < $jml+1; $i++) { 
                $data['qty_act']      = $request->qty[$i];
                $data['qty_ng']       = $request->ng[$i];
                $data['qty_gsph']     = $request->gsph[$i];
                $data['qty_mesin']    = $request->mesin[$i];
                $data['qty_dies']     = $request->dies[$i];
                $data['qty_dandori']  = $request->dandori[$i];
                $data['ket_remark']   = $request->remark[$i];
                $data['updatedby']    = auth()->user()->id;
                // $data['material_id'] = $request->rm[$i];
                
                PlanningLinec2::where('id', $request->idline[$i])->where('id', $request->idng[$i])->where('id', $request->idgsph[$i])->where('id', $request->idmesin[$i])->where('id', $request->iddies[$i])->where('id', $request->iddandori[$i])->where('id', $request->idremark[$i])->update($data);
            }
            alert()->success('Success','Update data success');
            return back();

        }else{
            $pdf = PDF::loadview('lkh.print');
            $pdf->setPaper('A4', 'Landscape');
    	    return $pdf->download('lkhc2.pdf');
        }
    }

    public function destroy(Request $request)
    {
        $query = Lkhc2::where('date_plan', $request->date_plan)->where('line_id', $request->idline)->delete();
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
