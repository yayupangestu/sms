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
use App\Models\StmpTagKanban;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use DB;

class ReportC2Controller extends Controller
{
    public function index()
    {
        $title = 'Report LINE c2';
        $line_stmps = LineStmp::all();
        $data_part_names = DataPartName::all();
        $stmp_tag_kanban_c2_s = StmpTagKanban::all();
        $data_models = DataModel::all();
        $users = User::all();
        
        return view('planningline.reportc2', compact('title','line_stmps','data_part_names','users','stmp_tag_kanban_c2_s'));
    }

    public function list(Request $request)
    {
        $query = DB::table('stmp_tag_kanban_c2_s as a')
                // ->select('a.id','c.part_name','c.part_no','d.spek', 'a.qty_plan','a.qty_act','a.qty_ng','a.qty_gsph','a.qty_mesin','qty_dies','a.qty_dandori','a.ket_remark','e.name','f.username')
                ->select('a.id','a.doc_no','a.job_no','a.part_name', 'a.part_no','a.model','a.qty_ok','a.qty_ng','a.date_plan','a.created_at','a.time_start','a.time_end','a.shift' ,'b.username as createdby','a.keterangan','a.line_stmp')
                ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
                ->join('stmp_tag_kanban_c2_s as c', 'c.id', '=', 'a.line_stmp', 'left')
                // ->join('users as g', 'g.id', '=', 'a.updatedby', 'left')
                ->where('a.date_plan', $request->date_plan)
                ->where('a.line_stmp', $request->line_stmp)
                ->get();
        return response()->json([
            'data'  => $query
        ]);
            

    }

    public function update(Request $request)
    {
        if($request->button == "update"){
            $jml = count($request->idremark2);
            $jml = count($request->idpengambil);
            for ($i=1; $i < $jml+1; $i++) { 
                $data['ket_pengambil'] = $request->pengambil[$i];
                $data['ket_remark2'] = $request->remark2[$i];
                
                // $data['material_id'] = $request->rm[$i];
                
                PlanningLine::where('id', $request->idremark2[$i])->where('id', $request->idpengambil)->update($data);
            }
            alert()->success('Success','Update data success');
            return back();

        }else{
            $pdf = PDF::loadview('lkh.print');
            $pdf->setPaper('A4', 'Landscape');
    	    return $pdf->download('lkhB3.pdf');
        }
    }

    public function destroy(Request $request)
    {
        $query = Lkhb3::where('date_plan', $request->date_plan)->where('line_stmp', $request->idline)->delete();
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
