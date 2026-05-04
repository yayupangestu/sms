<?php

namespace App\Http\Controllers;
use App\Models\LineStmp;
use App\Models\DataModel;
use App\Models\DataCostumer;
use App\Models\DataPartName;
use App\Models\RmMaterial;
use App\Models\TabelC1;
use Illuminate\Http\Request;
use DataTables;
use DB;

class TabelC1Controller extends Controller
{
    public function index()
    {
        $title = 'Plan b3';
        $data_part_names = DataPartName::all();
        $data_models = DataModel::all();
        $data_costumers = DataCostumer::all();
        $rm_materials = RmMaterial::all();
        return view('tabel.tabelc1', compact('title','data_part_names','data_models','data_costumers','rm_materials'));
    }


    public function list()
    {
        $query = DB::table('tabel_c1_s as a')
                ->select('a.type_id','b.job_no as job_no','b.part_name as part_no','c.name as model_id',
                'a.id as id','e.name as shop_id','d.name_material as spec_id')
                ->join('data_part_names as b', 'b.id', '=', 'a.job_no', 'left')
                ->join('data_models as c', 'c.id', '=', 'a.model_id', 'left')
                ->join('data_costumers as e', 'e.id', '=', 'a.shop_id', 'left')
                ->join('rm_materials as d', 'd.id', '=', 'a.spec_id', 'left')
                ->get();
        return DataTables::of($query)->make();
    }

 public function store(Request $request)
    {
        $tabelc1                    = new TabelC1;
        $tabelc1->job_no            = $request->job_no;
        $tabelc1->part_no           = $request->part_no;
        $tabelc1->model_id          = $request->model_id;
        $tabelc1->spec_id           = $request->spec_id;
        $tabelc1->type_id           = $request->type_id;
        $tabelc1->shop_id           = $request->shop_id;
        $tabelc1->createdby         = auth()->user()->id;
        $query                      = $tabelc1->save();
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
        $cek = TabelC1::where('id', $request->id)->count();
        if($cek > 0){
            $row = TabelC1::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'job_no'         => $row->job_no,
                'part_no'        => $row->part_no,
                'model_id'       => $row->model_id,
                'spec_id'        => $row->spec_id,
                'type_id'        => $row->type_id,
                'shop_id'        => $row->shop_id
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
        $data['job_no']            = $request->job_no;
        $data['part_no']           = $request->part_no;
        $data['model_id']          = $request->model_id;
        $data['spec_id']           = $request->spec_id;
        $data['type_id']           = $request->type_id;
        $data['shop_id']           = $request->shop_id;
        $data['updateby']          = auth()->user()->id;
        $query = TabelC1::where('id', $request->id)->update($data);
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
        $query = TabelC1::where('id', $request->id)->delete();
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



















    