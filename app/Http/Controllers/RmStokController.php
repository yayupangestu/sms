<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use  App\Models\DataFgStamping;
use App\Models\RmInMaterial;
use App\Models\RmStok;
use App\Models\User;
use App\Imports\RmStokImport; // Pastikan namespace ini benar
use DataTables;
use DB;

class RmStokController extends Controller
{
    public function index()
    {
        $title = 'STOK MATERIAL';
        $data_fg_stampings = DataFgStamping::all();
        $rm_materials = DB::table('rm_materials as a')
                        ->select('a.id as id','a.name_material','a.spek')
                        // ->join('data_fg_stampings as b', 'b.id', '=', 'a.model', 'left')
                        ->get();

        return view('rmmaterial.stok', compact('title','rm_materials','data_fg_stampings'));
    }

    public function list()
    {
        $query = DB::table('rm_stoks as a')
                        ->select('a.id','a.part_name','a.part_no','a.part_no2','a.job_no','a.model_id','a.category_id','a.spek','a.spek_t','a.spek_w','a.spek_l','a.spek_kg','a.spek_bq','a.minimal','a.actual_sheet','a.actual_kg','a.supplier','a.no_rak','a.bq_id','a.keterangan')
                        ->join('rm_materials as c', 'c.id', '=', 'a.material_id','left')
                        ->join('rm_materials as e', 'e.id', '=', 'a.material_id','left')
                        // ->join('data_fg_stampings as f', 'f.id', '=', 'a.model_id','left')
                // ->join('materials as c', 'c.id', '=', 'a.actual', 'left')
                ->get();
        return DataTables::of($query)->make();
    }

 public function store(Request $request)
    {
        $stok                    = new RmStok;
        $stok->part_name         = $request->part_name;
        $stok->part_no           = $request->part_no;
        $stok->job_no            = $request->job_no;
        $stok->spek              = $request->spek;
        $stok->model_id          = $request->model_id;
        $stok->actual_sheet      = $request->actual_sheet;
        $stok->minimal           = $request->minimal;
        $stok->actual_kg         = $request->actual_kg;
        $stok->no_rak            = $request->no_rak;
        $stok->bq_id             = $request->bq_id;
        $stok->keterangan            = $request->keterangan;
        $stok->createdby         = auth()->user()->id;
        $query                   = $stok->save();
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
        $cek = RmStok::where('id', $request->id)->count();
        if($cek > 0){
            $row = RmStok::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'part_name'      => $row->part_name,
                'part_no'        => $row->part_no,
                'job_no'         => $row->job_no,
                'model_id'       => $row->model_id,
                'spek'           => $row->spek,
                'minimal'        => $row->minimal,
                'actual_kg'    => $row->actual_kg,
                'actual_sheet'         => $row->actual_sheet,
                'no_rak'        => $row->no_rak,
                'bq_id'        => $row->bq_id,
                'keterangan'        => $row->keterangan,
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
        $data['part_name']              = $request->part_name;
        $data['part_no']                = $request->part_no;
        $data['job_no']                 = $request->job_no;
        $data['model_id']               = $request->model_id;
        $data['spek']                   = $request->spek;
        $data['minimal']                = $request->minimal;
        $data['actual_kg']              = $request->actual_kg;
        $data['actual_sheet']           = $request->actual_sheet;
        $data['no_rak']                 = $request->no_rak;
        $data['no_rak']                 = $request->no_rak;
        $data['bq_id']                  = $request->bq_id;
        $data['keterangan']                  = $request->keterangan;
        $data['updatedby']              = auth()->user()->id;
        $query = RmStok::where('id', $request->id)->update($data);
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
        $query = RmStok::where('id', $request->id)->delete();
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


    public function getDetail(Request $request)
    {


        $id = $request->id; 
        $material = DB::table('rm_stoks as a')
        ->select('a.id', 'b.name as model', 'a.actual', 'a.minimal','f.name_material as name_material')
        ->join('rm_materials as f', 'f.id', '=', 'a.name_material')
        ->join('data_fg_stampings as f', 'f.id', '=', 'a.model')
        // ->leftJoin('users as c', 'c.id', '=', 'a.updated_by')
        ->where('a.id', $id)
        ->first(); // Menggunakan first() untuk mendapatkan satu hasil

        
        if ($material) {
            return response()->json([
                'success' => true,
                'data' => [
                    'name_material' => $material->name_material,
                    'category' => $material->category_id,
                    'minimal' => $material->minimal,
                    'actual' => $material->actual,
                    // 'material_name' => $material->material_name
                ]
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Material not found'
            ]);
        }
    }
    
 
    public function getMaterialDetails(Request $request)
{
    $material_id = $request->get('id');

    // Retrieve data from rm_in_materials and join with rm_materials and rm_suppliers
    $material = DB::table('rm_in_materials as a')
                ->select('a.id', 'a.category_id', 'a.qty_in', 'b.pt as suplai_id', 'a.created_at', 'a.no', 'd.name_material as material_id', 'z.username as createdby', 'a.status', 'a.user_out','a.qty_return')
                ->leftJoin('users as z', 'z.id', '=', 'a.createdby')
                ->leftJoin('rm_materials as d', 'd.id', '=', 'a.material_id')
                ->leftJoin('rm_suppliers as b', 'b.id', '=', 'a.suplai_id')
                ->where('a.material_id', $material_id)
                ->distinct() // Avoid duplicates
                ->get();

                // Process material data to update status and sts_2 based on conditions
                foreach ($material as $item) {
                    // Handle null values by replacing them with empty strings or a default value
                    $item->id = $item->id ?? '';
                    $item->category_id = $item->category_id ?? '';
                    $item->qty_in = $item->qty_in ?? '';
                    $item->suplai_id = $item->suplai_id ?? '';
                    $item->created_at = $item->created_at ?? '';
                    $item->no = $item->no ?? '';
                    $item->material_id = $item->material_id ?? '';
                    $item->createdby = $item->createdby ?? '';
                    $item->user_out = $item->user_out ?? ''; // Handling user_out null
                
                    // Check if qty_return has a value, if so, set sts_2 to RETURN
                    if (!empty($item->qty_return)) {
                        $item->status = '<span class="badge bg-red">MATERIAL OUT</span>';
                        $item->sts_2 = '<span class="badge bg-yellow">RETURN</span>';
                        $item->no = '<span class="badge bg-red">' . $item->no . '</span>'; // Add yellow badge to 'no'
                    } else {
                        // Status for material out
                        if ($item->status == 1) {
                            $item->status = '<span class="badge bg-red">MATERIAL OUT</span>';
                            $item->sts_2 = '<span class="badge bg-red">OUT</span>';
                            $item->no = '<span class="badge bg-red">' . $item->no . '</span>'; // Add red badge to 'no'
                        } else {
                            // Default status when material is ready
                            $item->status = '<span class="badge bg-green">MATERIAL READY</span>';
                            $item->sts_2 = '<span class="badge bg-green">Not OUT</span>';
                            $item->no = '<span class="badge bg-green">' . $item->no . '</span>'; // Add green badge to 'no'
                        }
                    }
                }

            // Return response based on whether data is found
            if ($material->isNotEmpty()) {
                return response()->json([
                    'success' => true,
                    'data' => $material,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'msg' => 'Material not found',
                ]);
            }
        } 
        
        public function importStok(Request $request)
        {
            $request->validate([
                'file' => 'required|mimes:xls,xlsx'
            ]);
        
            try {
                Excel::import(new RmStokImport, $request->file('file'));
        
                return back()->with('success', 'Data stok berhasil diimport!');
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengimport data: ' . $e->getMessage());
            }
        }
        

    
}
    
    

