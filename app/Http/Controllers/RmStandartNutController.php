<?php

namespace App\Http\Controllers;
use App\Models\RmStandartNut;
use Illuminate\Http\Request;
use DataTables;
use DB;

class RmStandartNutController extends Controller
{
    public function index()
    {
        $title = 'Material';
        return view('rmmaterial.nut', compact('title'));
    }

    public function list()
    {
        $query = DB::table('rm_standart_nuts as a')
                ->select('a.part_nut','a.name_nut','a.id as id','a.supplier_id','a.packing_box','a.packing_kantong','a.line')
                ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $material                    = new RmStandartNut;
        $material->part_nut          = $request->part_nut;
        $material->name_nut          = $request->name_nut;
        $material->supplier_id       = $request->supplier_id;
        $material->packing_box       = $request->packing_box;
        $material->packing_kantong   = $request->packing_kantong;
        $material->line           =$request->line;
        $material->createdby         = auth()->user()->id;
        $query                       = $material->save();
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
        $cek = RmStandartNut::where('id', $request->id)->count();
        if($cek > 0){
            $row = RmStandartNut::where('id', $request->id)->first();
            return response()->json([
                'success'         => true,
                'id'              => $row->id,
                'part_nut'        => $row->part_nut,
                'name_nut'        => $row->name_nut,
                'supplier_id'     => $row->supplier_id,
                'packing_box'     => $row->packing_box,
                'packing_kantong' => $row->packing_box,
                'line'            => $row->line
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
        $data['part_nut']               = $request->part_nut;
        $data['name_nut']               = $request->name_nut;
        $data['supplier_id']            = $request->supplier_id;
        $data['packing_box']            = $request->packing_box;
        $data['packing_kantong']        = $request->packing_kantong;
        $data['line']                   = $request->line;
        $data['updatedby']              = auth()->user()->id;
        $query = RmStandartNut::where('id', $request->id)->update($data);
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Update success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Update failed.'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $query = RmStandartNut::where('id', $request->id)->delete();
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
