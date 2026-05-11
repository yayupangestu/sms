<?php

namespace App\Http\Controllers;
use App\Models\Departement;
use App\Models\StrBarang;
use App\Models\StrOut;
use App\Models\StrCategory;
use App\Models\StrUom;
use Illuminate\Http\Request;
use DataTables;
use DB;

class StrSpbB3Controller extends Controller
{
    public function index()
    {
        $title = 'SPB B3';
        $departements = Departement::all();
        $str_uoms = StrUom::all();
        $str_barangs = StrBarang::all();
        // $data_models = DataModel::all();
        // $tabel_b3_s = DB::table('tabel_b3_s as a')
        //         ->select('a.type_id','b.job_no as job_no','b.part_name as part_no','d.name as model_id','c.spek as spec_id','a.id as id')
        //         ->join('data_part_names as b', 'b.id', '=', 'a.job_no', 'left')
        //         ->join('rm_materials as c', 'c.id', '=', 'a.spec_id', 'left')
        //         ->join('data_models as d', 'd.id', '=', 'a.model_id', 'left')
        //         ->get();
        return view('storeroom.spbb3', compact('title','departements','str_uoms','str_barangs'));
    }

    public function list(Request $request)
    {
        $query = DB::table('str_outs as a')
                ->select('a.id','b.name_dept as line_id','c.name as item_id','a.qty_act','a.ket_remark','a.qty_return','a.qty_request')
                ->join('departements as b', 'b.id', '=', 'a.line_id', 'left')
                ->join('str_barangs as c', 'c.id', '=', 'a.item_id', 'left')
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
            // $jml = count($request->idng);
            // $jml = count($request->idgsph);
            // $jml = count($request->idmesin);
            // $jml = count($request->iddies);
            // $jml = count($request->iddandori);
            // $jml = count($request->idremark);
            for ($i=1; $i < $jml+1; $i++) { 
                $data['qty_act']      = $request->qty[$i];
                // $data['qty_ng']       = $request->ng[$i];
                // $data['qty_gsph']     = $request->gsph[$i];
                // $data['qty_mesin']    = $request->mesin[$i];
                // $data['qty_dies']     = $request->dies[$i];
                // $data['qty_dandori']  = $request->dandori[$i];
                // $data['ket_remark']   = $request->remark[$i];
                $data['updatedby']    = auth()->user()->id;
                // $data['material_id'] = $request->rm[$i];
                
                StrOut::where('id', $request->idline[$i])->update($data);
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
        $query = Lkhb3::where('date_plan', $request->date_plan)->where('line_id', $request->idline)->delete();
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
