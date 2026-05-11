<?php

namespace App\Http\Controllers;
use App\Models\MipData1;
use App\Models\MipCompresor;
use App\Models\MipManPower;
use App\Models\MipChek1;
use Illuminate\Http\Request;
use DataTables;
use DB;

class MipChek1Controller extends Controller
{
    public function index()
    {
        $title = 'ChekSheet Compresor';
        $mip_data1s = MipData1::all();
        $mip_compresors = MipCompresor::all();
        $mip_man_powers = MipManpower::all();
        return view('mip.cheksheet1', compact('title','mip_data1s','mip_compresors','mip_man_powers'));
    }

    public function list()
    {
        $query = DB::table('mip_chek1s as a')
                ->select('a.date_plan','b.name as line',DB::raw('CONCAT(a.date_plan, b.id)as mix_id'))
                ->join('mip_data1s as b', 'b.id', '=', 'a.line_id', 'left')
                ->groupBy('a.date_plan')
                ->groupBy('a.line_id')
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('mip_chek1s as a')
                ->select('a.id','d.name as compresor','e.name as manpower','a.unload','a.load','a.hours','a.oil','a.t1','a.t2','a.koil','a.kmesin')
                ->join('mip_data1s as b', 'b.id', '=', 'a.line_id', 'left')
                ->join('mip_compresors as d', 'd.id', '=', 'a.compresor', 'left')
                ->join('mip_man_powers as e', 'e.id', '=', 'a.manpower', 'left')
                ->where('a.date_plan', $request->date_plan)
                ->where('a.line_id', $request->line_id)
                ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $plan               = new MipChek1;
        $plan->date_plan    = $request->date_plan;
        $plan->line_id      = $request->line_id;
        $plan->compresor    = $request->compresor;
        $plan->manpower     = $request->manpower;
        $plan->hours        = $request->hours;
        $plan->unload     = $request->unload;
        $plan->load        = $request->load;
        $plan->oil          = $request->oil;
        $plan->t1        = $request->t1;
        $plan->t2        = $request->t2;
        $plan->koil        = $request->koil;
        $plan->kmesin        = $request->kmesin;
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

    public function destroyline(Request $request)
    {
        $query = MipChek1::where('id', $request->id)->delete();
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
        $query = MipChek1::where('date_plan', $request->date_plan)->where('line_id', $request->idline)->delete();
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
