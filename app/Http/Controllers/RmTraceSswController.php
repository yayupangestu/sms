<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmScannedNut;
use App\Models\RmStandartNut;
use App\Models\RmMaterialNut;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RmTraceSswController extends Controller
{
    public function index()
    {
        $title = 'Trace Prosses SSW ';
        $rm_standart_nuts = RmStandartNut::all();
        $rm_material_nuts = RmMaterialNut::all();
        $users = User::all();
        return view('rmmaterial.tracenut', compact('title','rm_material_nuts','rm_standart_nuts','users'));
    }

    public function list(Request $request)
    {
        $uniq_no = $request->input('uniq_no');
        $part_nut = $request->input('part_nut');
    
        $data = DB::table('rm_scanned_nuts as a')
        ->select('a.id','a.uniq_no','a.part_nut','a.qty_plan','a.suplaier','b.name as createdby','a.uniq_no_out','a.part_nut_out','a.created_at','a.suplaier_out','a.qty_plan_out','a.updated_at','c.name as updatedby')
        ->join('users as b', 'b.id', '=', 'a.createdby', 'left')   
        ->join('users as c', 'c.id', '=', 'a.updatedby', 'left')   
        ->where('uniq_no', $uniq_no)
            ->where('part_nut', $part_nut)
            ->get();
    
        return response()->json(['data' => $data]);
    }
    

}

// ->join('users as f', 'f.id', '=', 'a.updatedby', 'left')