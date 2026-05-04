<?php

namespace App\Http\Controllers;
use App\Models\RmMaterialNut;
use App\Models\DataModel;
use App\Models\DataPartName;
use App\Models\RmStandartNut;
use Illuminate\Http\Request;
use DataTables;
use DB;

class RmMaterialNutController extends Controller
{
    public function index()
    {
        $title = 'MaterialNut';
        $data_models = DataModel::all();
        $data_part_names = DataPartName::all();
        $rm_standart_nuts = RmStandartNut::all();
        $rm_material_nuts = RmMaterialNut::all();
        return view('rmmaterial.nutmaterial', compact('title', 'data_models','data_part_names','rm_material_nuts','rm_standart_nuts'));
    }

    public function list()
    {
        $query = DB::table('rm_material_nuts as a')
                ->select('a.id as id','b.part_name as part_no','a.job_no','a.model_id','a.supplier','a.type_id','a.spec_nut','a.warna_nut','d.part_nut as type_id')
                ->join('data_part_names as b', 'b.id', '=', 'a.part_no', 'left')
                ->join('data_part_names as c', 'c.id', '=', 'a.job_no', 'left')
                ->join('rm_standart_nuts as d', 'd.id', '=', 'a.type_id', 'left')
                // ->join('data_models as d', 'd.id', '=', 'a.model_id', 'left')
                // ->join('satuan_strs as c', 'c.id', '=', 'a.satuan','left')
                // ->join('materials as c', 'c.id', '=', 'a.actual', 'left')
                ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $material                      = new RmMaterialNut;
        $material->part_no             = $request->part_no;
        $material->job_no              = $request->job_no;
        $material->model_id            = $request->model_id;
        $material->spec_nut            = $request->spec_nut;
        $material->warna_nut           = $request->warna_nut;
        $material->type_id             = $request->type_id;
        $material->supplier            = $request->supplier;
        $material->createdby           = auth()->user()->id;
        $query                         = $material->save();
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
        $cek = RmMaterialNut::where('id', $request->id)->count();
        if($cek > 0){
            $row = RmMaterialNut::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'part_no'        => $row->part_no,
                'job_no'         => $row->job_no,
                'model_id'       => $row->model_id,
                'warna_nut'      => $row->warna_nut,
                'spec_nut'       => $row->spec_nut,
                'type_id'        => $row->type_id,
                'supplier'       => $row->supplier
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
        $data['part_no']            = $request->part_no;
        $data['job_no']             = $request->job_no;
        $data['model_id']           = $request->model_id;
        $data['spec_nut']           = $request->spec_nut;
        $data['warna_nut']          = $request->warna_nut;
        $data['type_id']            = $request->type_id;
        $data['supplier']           = $request->supplier;
        $data['updatedby']          = auth()->user()->id;
        $query = RmMaterialNut::where('id', $request->id)->update($data);
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
        $query = RmMaterialNut::where('id', $request->id)->delete();
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
