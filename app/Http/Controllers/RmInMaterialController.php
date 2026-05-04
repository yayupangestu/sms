<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use App\Models\RmInMaterial;
use App\Models\DataModel;
use App\Models\RmStok;
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
    // $data_models = DataModel::all();
    $rm_stoks    = RmStok::all();
    $master = RmInMaterial::first(); // Ganti dengan logika yang sesuai
    $rm_materials = DB::table('rm_materials as a')
                    ->select('a.name_material','a.spek','a.id','a.spek_l','a.spek_t','a.spek_p')
                    // ->join('data_models as b', 'b.id', '=', 'a.model', 'left')
                    ->get();
    return view('rmmaterial.inmaterial', compact('title','rm_suppliers','rm_materials', 'master','rm_stoks'));
}


    public function list()
    {
        $query = DB::table('rm_in_materials as a')
            ->select('a.date_plan', 'a.line_id', DB::raw('CONCAT(a.date_plan, a.line_id) as mix_id'))
            ->groupBy('a.line_id', 'a.date_plan')
            ->get();
            return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        // Fetch the data along with the material count from the database
        $query = DB::table('rm_in_materials as a')
        ->select('a.id','a.part_no','a.date_plan','a.line_id','a.product_id' ,'a.qty_act' ,'a.uniqNo' ,'a.createdby' ,'a.updateby','a.model_id','a.spek','a.spek_t','a.spek_w','a.spek_l','a.sts_scan')

        ->where('a.line_id', $request->line_id)
        ->get();
        return DataTables::of($query)->make(true);
    }



    public function store(Request $request)
    {
        $plan               = new RmInMaterial;
        $plan->date_plan    = $request->date_plan;
        $plan->line_id      = $request->line_id;
        $plan->product_id   = $request->product_id;
        $plan->part_no      = $request->part_no;
        $plan->model_id      = $request->model_id;
        $plan->spek         = $request->spek;
        $plan->spek_t       = $request->spek_t;
        $plan->spek_w       = $request->spek_w;
        $plan->spek_l       = $request->spek_l;
        $plan->qty_act      = $request->qty_act;
        $plan->uniqNo       = $request->uniqNo;
        $plan->kg_sheet     = '0';
        // $plan->material_id  = $request->material_id;
        $plan->createdby    = auth()->user()->username;
        $plan->updateby    = auth()->user()->username;

        if (!$request->uniqNo) {
            $currentTimestamp = now();
            $uniqNo = 'STO' . date('dis', strtotime($currentTimestamp)); // Format: ddmmyyHHmmss
            $plan->uniqNo = $uniqNo;
        } else {
            $plan->uniqNo = $request->uniqNo;
        }
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


    public function edit(Request $request)
    {
        $cek = RmInMaterial::where('id', $request->id)->count();
        if($cek > 0){
            $data = RmInMaterial::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'doc_no'        => $data->doc_no,
                'id'             => $data->id,
                'date_plan'      => $data->date_plan,
                'suplai_id'      => $data->suplai_id,
                'material_id'    => $data->material_id,
                'qty_plan'       => $request->qty_plan,
                'qty_in'         => $data->qty_in,
                'category_id'    => $data->category_id,
                'keterangan'     => $request->keterangan,

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
        $data['date_plan']          = $request->date_plan;
        $data['material_id']        = $request->material_id;
        $data['qty_in']             = $request->qty_in;
        $data['qty_plan']           = $request->qty_plan;
        $data['category_id']        = $request->category_id;
        $data['keterangan']         = $request->keterangan;
        $data['updateby']           = auth()->user()->id;
        $query = RmInMaterial::where('id', $request->id)->update($data);
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Edit success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Edit failed.'
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


    public function getdoc()
    {
        $cek = RmInMaterial::select(DB::raw('COUNT(doc_no) as jml'))->whereMonth('created_at', date('m'))->groupBy('doc_no')->count();
        if($cek > 0){
            $array = array();
            $rows = RmInMaterial::select('doc_no')->whereMonth('created_at', date('m'))->groupBy('doc_no')->get();
            foreach ($rows as $key => $value) {
                $array[] = $value->doc_no;
            }
            $arr_doc = count($array);
            return response()->json([
                'jml'   => $arr_doc + 1
            ]);
        }else{
            return response()->json([
                'jml'   => 1
            ]);
        }
    }


    public function destroy(Request $request)
    {
        $query = RmInMaterial::where('doc_no', $request->doc_no)->delete();
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


    public function submit(Request $request)
    {
        $cek = RmInMaterial::where('doc_no', $request->doc_no)->count();
        if($cek > 0){
            $data['sts'] = 1;
            $query = RmInMaterial::where('doc_no', $request->doc_no)->update($data);
            if($query){
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Submit success.'
                ]);
            }else{
                return response()->json([
                    'success'   => false,
                    'msg'       => 'Submit failed.'
                ]);
            }
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Submit failed. doc no not found'
            ]);
        }

    }

    public function delete_draft(Request $request)
    {
        $query = RmInMaterial::where('doc_no', $request->doc_no)->delete();
        return back();
    }

    public function cetak($id)
    {
        // Find the master record by ID
        $rm_in_materials = RmInMaterial::findOrFail($id);
    
        $uniqNo = date('dm') . $rm_in_materials->urutan . date('s', strtotime($rm_in_materials->updated_at));
    
        $data_to_encode = $rm_in_materials->part_no . '||' . $rm_in_materials->line_id;
        $data_to_encode = $rm_in_materials->part_no. '||' . $rm_in_materials->spek .'||'. $rm_in_materials->line_id .'||'. $rm_in_materials->uniqNo .'||'. $rm_in_materials->id.'||'. $rm_in_materials->id .'||'. $rm_in_materials->kg_sheet .'||'. $rm_in_materials->qty_act;

        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data_to_encode));
    
        $data = [
            'qrcode'            => $qrcode,
            // 'uniqNo'         => $uniqNo,
            'date_plan'         => $rm_in_materials->date_plan,
            'uniqNo'            => $rm_in_materials->uniqNo,
            'part_no'           => $rm_in_materials->part_no,
            'model_id'          => $rm_in_materials->model_id,
            'line_id'           => $rm_in_materials->line_id,
            'spek'              => $rm_in_materials->spek,
            'spek_t'            => $rm_in_materials->spek_l,
            'spek_l'            => $rm_in_materials->spek_l,  // Format dynamically without rounding
            'spek_w'            => $rm_in_materials->spek_w,
            'qty_act'           => $rm_in_materials->qty_act,
            'createdby'         => $rm_in_materials->createdby,
            // 'kg_sheet'       => $rm_in_materials->kg_sheet,
            'created_at'        => $rm_in_materials->created_at,
            // 'supplier'       => $rm_in_materials->supplier,
            // 'actual'         => $rm_in_materials->actual,
            'no_rak'            => $rm_in_materials->no_rak,
            // 'uniq_no'        => $rm_in_materials->uniq_no,
        ];
    
        // Define custom paper size (100mm x 150mm in points)
        $customPaper = array(0, 0, 283.465, 425.1975);
    
        // Load PDF view with data and set custom paper size
        $pdf = PDF::loadView('rmmaterial.sto', $data)
                  ->setPaper($customPaper, 'portrait');  // 'portrait' for normal orientation
    
        // Stream the generated PDF with a filename that includes the date and unique ID
        return $pdf->stream(date('d_M_Y') . '_' . $rm_in_materials->id . '_qrcode.pdf');
    }


    public function generateMultipleQrCodes(Request $request)
{
    // Validasi data input
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:rm_in_materials,id',
    ]);

    $data_to_print = [];

    foreach ($request->ids as $id) {
        $rm_in_materials = RmInMaterial::findOrFail($id);

        $data_to_encode = $rm_in_materials->part_no. '||' . $rm_in_materials->spek .'||'. $rm_in_materials->line_id .'||'. $rm_in_materials->uniqNo .'||'. $rm_in_materials->id.'||'. $rm_in_materials->id .'||'. $rm_in_materials->kg_sheet .'||'. $rm_in_materials->qty_act;

        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data_to_encode));

        $data_to_print[] = [
            'qrcode'       => $qrcode,
            'date_plan'    => $rm_in_materials->date_plan,
            'uniqNo'       => $rm_in_materials->uniqNo,
            'part_no'      => $rm_in_materials->part_no,
            'model_id'     => $rm_in_materials->model_id,
            'line_id'      => $rm_in_materials->line_id,
            'spek'         => $rm_in_materials->spek,
            'spek_t'       => $rm_in_materials->spek_l,
            'spek_l'       => $rm_in_materials->spek_l,
            'spek_w'       => $rm_in_materials->spek_w,
            'qty_act'      => $rm_in_materials->qty_act,
            'createdby'    => $rm_in_materials->createdby,
            'created_at'   => $rm_in_materials->created_at,
            'no_rak'       => $rm_in_materials->no_rak,
            'supplier'     => $rm_in_materials->supplier,
        ];
    }

    // Jika tidak ada data, hentikan proses
    if (empty($data_to_print)) {
        return response()->json(['error' => 'Tidak ada data yang dipilih.'], 400);
    }

    // Tentukan ukuran kertas
    $customPaper = [0, 0, 283.465, 425.1975]; // 100mm x 150mm

    // Generate PDF dengan semua data
    $pdf = PDF::loadView('rmmaterial.sto_multiple', ['data' => $data_to_print])
              ->setPaper($customPaper, 'portrait');

    // Nama file PDF
    $filename = 'Label_STO_' . date('d_M_Y') . '_' . str_replace(' ', '_', $data_to_print[0]['supplier']) . '.pdf';

    return $pdf->stream($filename);
}

    public function getDataPart() 
    {
        $parts = DB::table('scan_in_blanks')
                    ->select('part_no')
                    ->whereDate('created_at', now()) // Filter berdasarkan tanggal hari ini
                    ->distinct()
                    ->orderBy('part_no')
                    ->get();
    
        return response()->json($parts);
    }



    public function getMaterialsByDocNodn(Request $request)
{
    $doc_no = $request->input('doc_no');

    // Mengambil semua data berdasarkan doc_no
    $query = DB::table('rm_in_materials as a')
    ->select('a.id', 'a.keterangan', 'c.name_material as material_id', 'a.qty_in', 'e.pt as suplai_id', 'a.category_id', 'a.no', 'f.name as model', 'a.date_plan', 'c.spek_l as spek_l', 'c.spek_t as spek_t', 'c.spek_p as spek_p', 'c.spek as spek', 'a.qty_plan','a.doc_no')
    ->join('rm_materials as c', 'c.id', '=', 'a.material_id', 'left')
    ->join('rm_suppliers as e', 'e.id', '=', 'a.suplai_id', 'left')
    ->join('data_models as f', 'f.id', '=', 'c.model')
    ->where('a.doc_no', $request->doc_no)
    ->get();

    return response()->json($query);
}

public function updateQtyIndn(Request $request)
{
    $updates = $request->input('updates');
    $userId = auth()->user()->id; // Get the ID of the logged-in user
    $currentTime = now(); // Get the current timestamp

    foreach ($updates as $update) {
        // Update qty_in in rm_in_materials along with updateby and in_time
        DB::table('rm_in_materials')
            ->where('id', $update['id'])
            ->update([
                'qty_in' => $update['qty_in'],
                'updateby' => $userId, // Record the user who performed the update
                'in_time' => $currentTime, // Record the time of the update
            ]);

        // Get the material_id and category_id associated with this rm_in_materials record
        $materialDetails = DB::table('rm_in_materials')
            ->where('id', $update['id'])
            ->select('material_id', 'category_id') // Retrieve both material_id and category_id
            ->first();

        if ($materialDetails) {
            $materialId = $materialDetails->material_id;
            $categoryId = $materialDetails->category_id; // Get category_id

            // Sum the qty_in for the given material_id from rm_in_materials
            $totalQtyIn = DB::table('rm_in_materials')
                ->where('material_id', $materialId)
                ->sum('qty_in'); // Sum the qty_in for this material_id

            // Check if material_id exists in rm_stoks
            $rmStok = DB::table('rm_stoks')
                ->where('material_id', $materialId)
                ->first();

            if ($rmStok) {
                // Update the actual value in rm_stoks to reflect the summed qty_in
                DB::table('rm_stoks')
                    ->where('material_id', $materialId)
                    ->update([
                        'actual' => $totalQtyIn, // Set the actual to the summed qty_in
                    ]);
            } else {
                // If not exists, insert a new record with the summed qty_in value and category_id
                DB::table('rm_stoks')->insert([
                    'material_id' => $materialId,
                    'actual' => $totalQtyIn, // Set actual to the summed qty_in
                    'category_id' => $categoryId, // Include category_id here
                ]);
            }
        }
    }

    return response()->json(['success' => true]);
}




}
