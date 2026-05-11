<?php

namespace App\Http\Controllers;
use App\Models\MipData1;
use App\Models\MipCompresor;
use App\Models\MipCompP;
use Illuminate\Http\Request;
use DataTables;
use DB;

class MipCompPController extends Controller
{
    public function index()
    {
        $title = 'Preventive';
        $mip_data1s = MipData1::all();
        $mip_compresors = MipCompresor::all();
        return view('mip.comppre', compact('title','mip_data1s','mip_compresors'));
    }

    public function list()
    {
        $query = DB::table('mip_comp_p_s as a')
                ->select('a.date_plan','b.name as line',DB::raw('CONCAT(a.date_plan, b.id)as mix_id'))
                ->join('mip_data1s as b', 'b.id', '=', 'a.line_id', 'left')
                ->groupBy('a.date_plan')
                ->groupBy('a.line_id')
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('mip_comp_p_s as a')
                ->select('a.id','d.name as compresor','a.teknis','a.filter','a.air','a.separators','a.lubrication','a.radiator','a.hm')
                ->join('mip_data1s as b', 'b.id', '=', 'a.line_id', 'left')
                ->join('mip_compresors as d', 'd.id', '=', 'a.compresor', 'left')
                ->where('a.date_plan', $request->date_plan)
                ->where('a.line_id', $request->line_id)
                ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $comp               = new MipCompP;
        $comp->date_plan    = $request->date_plan;
        $comp->line_id      = $request->line_id;
        $comp->compresor    = $request->compresor;
        $comp->hm           = $request->hm;
        $comp->teknis       = $request->teknis;
        $comp->filter       = $request->filter;
        $comp->air          = $request->air;
        $comp->separators   = $request->separators;
        $comp->lubrication  = $request->lubrication;
        $comp->radiator     = $request->radiator;
        // $comp->material_id  = $request->material_id;
        $comp->createdby    = auth()->user()->id;
        $query              = $comp->save();
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
        $query = MipCompP::where('id', $request->id)->delete();
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
        $query = MipCompP::where('date_plan', $request->date_plan)->where('line_id', $request->idline)->delete();
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
