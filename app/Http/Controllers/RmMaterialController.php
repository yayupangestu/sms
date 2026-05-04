<?php

namespace App\Http\Controllers;
use App\Models\RmMaterial;
use App\Models\DataModel;
use Illuminate\Http\Request;
use DataTables;
use DB;

class RmMaterialController extends Controller
{
    public function index()
    {
        $title = 'Material';
        $data_models = DataModel::all();
        return view('rmmaterial.material', compact('title', 'data_models'));
    }

    public function list()
    {
        $query = DB::table('rm_materials as a')
                ->select('a.name_material','a.spek','a.id as id','b.name as model','a.supplier', 'a.spek_t', 'a.spek_p', 'a.spek_l','a.no_rak')
                ->join('data_models as b', 'b.id', '=', 'a.model', 'left')
                // ->join('satuan_strs as c', 'c.id', '=', 'a.satuan','left')
                // ->join('materials as c', 'c.id', '=', 'a.actual', 'left')
                ->get();
        return DataTables::of($query)->make();
    }


    public function store(Request $request)
    {
        // Validate the necessary input fields
        $request->validate([
            'name_material' => 'required',
            'spek' => 'required',
            
        ]);
    
        // Check if a record with the same name_material and spek exists
        $existingMaterial = RmMaterial::where('name_material', $request->name_material)
                                      ->where('spek', $request->spek)
                                      ->first();
    
        // If a matching record exists, return an error response
        if ($existingMaterial) {
            return response()->json([
                'status' => 'error',
                'message' => 'The material with the same name and specification already exists.'
            ]);
        }
    
        // If no matching record exists, save the new material
        RmMaterial::create([
            'name_material' => $request->name_material,
            'spek' => $request->spek,
            'spek_t' => $request->spek_t,
            'spek_p' => $request->spek_p,
            'spek_l' => $request->spek_l,
            'model' => $request->model,
            'supplier' => $request->supplier,
            'no_rak'    => $request->no_rak,
        ]);
    
        return response()->json([
            'status' => 'success',
            'message' => 'Material added successfully.'
        ]);
    }
    

    public function edit(Request $request)
    {
        $cek = RmMaterial::where('id', $request->id)->count();
        if($cek > 0){
            $row = RmMaterial::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'name_material'  => $row->name_material,
                'spek'           => $row->spek,
                'spek_t'         => $row->spek_t,
                'spek_p'         => $row->spek_p,
                'spek_l'         => $row->spek_l,
                'model'          => $row->model,
                'supplier'       => $row->supplier,
                'no_rak'         => $row->no_rak,
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
        $data['name_material']      = $request->name_material;
        $data['spek']               = $request->spek;
        $data['spek_t']             = $request->spek_t;
        $data['spek_p']             = $request->spek_p;
        $data['spek_l']             = $request->spek_l;
        $data['model']              = $request->model;
        $data['supplier']           = $request->supplier;
        $data['no_rak']             = $request->no_rak;
        $data['updatedby']          = auth()->user()->id;
        $query = RmMaterial::where('id', $request->id)->update($data);
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
        $query = RmMaterial::where('id', $request->id)->delete();
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
    
  public function getMaterials(Request $request)
{
    $lineId = $request->query('line_id');

    // Query the data with INNER JOIN for data_models
    $materials = RmMaterial::join('data_models', 'data_models.id', '=', 'rm_materials.model_id') // Join with data_models table
                ->where('rm_materials.line_id', $lineId)
                ->select(
                    'rm_materials.*', 
                    'data_models.name as model' // Select model name from data_models table
                )
                ->get();

    // Return the data as JSON for DataTables to consume
    return response()->json($materials);
}

    

    
}
