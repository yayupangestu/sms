<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use App\Models\RmInMaterial;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DataTables;
use DB;

class RmInMaterialController extends Controller
{
    public function index()
{
    $title = 'Item IN';
    $rm_suppliers = RmSupplier::all();
    $rm_materials = RmMaterial::all();
    $master = RmInMaterial::first(); // Ganti dengan logika yang sesuai
    return view('rmmaterial.inmaterial', compact('title','rm_suppliers','rm_materials', 'master'));
}


    public function list()
    {
        $query = DB::table('rm_in_materials as a')
                ->select('a.date_plan','b.name_suplai as suplai',DB::raw('CONCAT(a.date_plan, b.id)as mix_id'))
                ->join('rm_suppliers as b', 'b.id', '=', 'a.suplai_id', 'left')
                ->groupBy('a.date_plan', 'a.suplai_id')
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('rm_in_materials as a')
                ->select('a.id','a.keterangan','c.name_material as material_id', 'a.qty_in','e.name_suplai as suplai_id','a.category_id')
                ->join('rm_materials as c', 'c.id', '=', 'a.material_id', 'left')
                ->join('rm_suppliers as e', 'e.id', '=' , 'a.suplai_id', 'left')
                ->where('a.date_plan', $request->date_plan)
                ->where('a.suplai_id', $request->suplai_id)
                ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $in = new RmInMaterial;
        $in->date_plan = $request->date_plan;
        $in->category_id = $request->category_id;
        $in->material_id = $request->material_id;
        $in->suplai_id = $request->suplai_id;
        $in->qty_in = $request->qty_in;
        $in->keterangan = $request->keterangan;
        $in->createdby = auth()->user()->id;
        $query = $in->save();
        if($query){
            return response()->json([
                'success' => true,
                'msg' => 'Insert success.'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'msg' => 'Insert failed.'
            ]);
        }
    }

    public function destroyline(Request $request)
    {
        $query = RmInMaterial::where('id', $request->id)->delete();
        if($query){
            return response()->json([
                'success' => true,
                'msg' => 'Delete success.'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'msg' => 'Delete failed.'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $query = RmInMaterial::where('date_plan', $request->date_plan)->where('suplai_id', $request->suplai_id)->delete();
        if($query){
            return response()->json([
                'success' => true,
                'msg' => 'Delete success.'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'msg' => 'Delete failed.'
            ]);
        }
    }

    public function cetak($id)
{
    $master = RmInMaterial::findOrFail($id);

    // Mengambil name_material berdasarkan material_id dari master
    $material = RmMaterial::find($master->material_id);
    $name_material = $material->name_material;
    $category_id = $master->category_id;

    $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($name_material));

    $rm_in_materials = DB::table('rm_in_materials as a')
                ->select('a.category_id', 'b.name_suplai as suplai_id', 'c.name_material as material_id', 'a.id', 'a.qty_in')
                ->join('rm_suppliers as b', 'b.id', '=', 'a.suplai_id', 'left')
                ->join('rm_materials as c', 'c.id', '=', 'a.material_id', 'left')
                ->where('a.id', $id)
                ->first();

    $data = [
        'title' => 'MATERIAL MASUK',
        'date' => date('m/d/Y H:i:s'),
        'rm_in_materials' => $rm_in_materials,
        'qrcode' => $qrcode
    ];

    $customPaper = array(0, 0, 283.00, 283.80);
    $pdf = PDF::loadView('rmmaterial.cetak', $data)->setPaper($customPaper, 'portrait');
    return $pdf->stream(date('d_M_Y') . '_' . $master->category_id . '_qrcode.pdf');
}

}

// ($master->material_id));