<?php

namespace App\Http\Controllers;
use App\Models\MipData1;
use App\Models\MipCompresor;
use App\Models\MipManPower;
use App\Models\MipChek1;
use Illuminate\Http\Request;
use DataTables;
use DB;


class MipReport1Controller extends Controller
{
   
    public function index()
    {
        $title = 'Report CheckSheet';
        $mip_data1s = MipData1::all();
        $mip_compresors = MipCompresor::all();
        $mip_man_powers = MipManpower::all();
        return view('mip.reportchek1', compact('title','mip_data1s','mip_compresors','mip_man_powers'));
    }
    
    public function list(Request $request)
    {
        $query = DB::table('mip_chek1s as a')
                // ->select('a.id','c.part_name','c.part_no','d.spek', 'a.qty_plan','a.qty_act','a.qty_ng','a.qty_gsph','a.qty_mesin','qty_dies','a.qty_dandori','a.ket_remark','e.name','f.username')
                // ->select('a.id','e.part_name','e.part_no','d.spek', 'a.hours','a.unload','a.load','a.oil','a.t1','a.t2','a.koil','a.kmesin' ,'f.name',)
                ->select('a.id','d.name as compresor','e.name as manpower','a.unload','a.load','a.hours','a.oil','a.t1','a.t2','a.koil','a.kmesin')
                ->join('mip_data1s as b', 'b.id', '=', 'a.line_id', 'left')
                ->join('mip_compresors as d', 'd.id', '=', 'a.compresor', 'left')
                ->join('mip_man_powers as e', 'e.id', '=', 'a.manpower', 'left')
                ->where('a.date_plan', $request->date_plan)
                ->where('a.line_id', $request->line_id)
                ->get();
        return response()->json([
            'data'  => $query
        ]);
            
    }

    public function list2(Request $request)
    {
        $query = DB::table('mip_comp_p_s as a')
                // ->select('a.id','c.part_name','c.part_no','d.spek', 'a.qty_plan','a.qty_act','a.qty_ng','a.qty_gsph','a.qty_mesin','qty_dies','a.qty_dandori','a.ket_remark','e.name','f.username')
                // ->select('a.id','e.part_name','e.part_no','d.spek', 'a.hours','a.unload','a.load','a.oil','a.t1','a.t2','a.koil','a.kmesin' ,'f.name',)
                ->select('a.id','d.name as compresor','a.teknis','a.filter','a.air','a.separators','a.lubrication','a.radiator','a.hm')
                ->join('mip_data1s as b', 'b.id', '=', 'a.line_id', 'left')
                ->join('mip_compresors as d', 'd.id', '=', 'a.compresor', 'left')
                // ->join('mip_man_powers as e', 'e.id', '=', 'a.manpower', 'left')
                ->where('a.date_plan', $request->date_plan)
                ->where('a.line_id', $request->line_id)
                ->get();
        return response()->json([
            'data'  => $query
        ]);
            

    }
  

    // public function listdetail(Request $request)
    // {
    //     $query = DB::table('mip_chek1s as a')
    //             // ->select('a.id','c.part_name','c.part_no','d.spek', 'a.qty_plan','a.qty_act','a.qty_ng','a.qty_gsph','a.qty_mesin','qty_dies','a.qty_dandori','a.ket_remark','e.name','f.username')
    //             // ->select('a.id','e.part_name','e.part_no','d.spek', 'a.hours','a.unload','a.load','a.oil','a.t1','a.t2','a.koil','a.kmesin' ,'f.name',)
    //             ->select('a.id','d.name as compresor','e.name as manpower','a.unload','a.load','a.hours','a.oil','a.t1','a.t2','a.koil','a.kmesin')
    //             ->join('mip_data1s as b', 'b.id', '=', 'a.line_id', 'left')
    //             ->join('mip_compresors as d', 'd.id', '=', 'a.compresor', 'left')
    //             ->join('mip_man_powers as e', 'e.id', '=', 'a.manpower', 'left')
    //             ->where('a.date_plan', $request->date_plan)
    //             ->where('a.line_id', $request->line_id)
    //             ->get();
    //     return response()->json([
    //         'data'  => $query
    //     ]);
            

    // }

    // public function update(Request $request)
    // {
    //     if($request->button == "update"){
    //         $jml = count($request->idremark2);
    //         $jml = count($request->idpengambil);
    //         for ($i=1; $i < $jml+1; $i++) { 
    //             $data['ket_pengambil'] = $request->pengambil[$i];
    //             $data['ket_remark2'] = $request->remark2[$i];
                
    //             // $data['material_id'] = $request->rm[$i];
                
    //             PlanningLine::where('id', $request->idremark2[$i])->where('id', $request->idpengambil)->update($data);
    //         }
    //         alert()->success('Success','Update data success');
    //         return back();

    //     }else{
    //         $pdf = PDF::loadview('lkh.print');
    //         $pdf->setPaper('A4', 'Landscape');
    // 	    return $pdf->download('lkhB3.pdf');
    //     }
    // }

}
