<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RmInNut;
use App\Models\RmStandartNut;
use App\Models\RmSupplierNut;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DataTables;
use PDFMerger;
use DB;

class RmInNutController extends Controller
{
    public function index()
{
    $title = 'Item IN';
    // $rm_suppliers = RmSupplier::all();
    $rm_supplier_nuts = RmSupplierNut::all();
    $rm_standart_nuts = RmStandartNut::all();
    $master = RmInNut::first(); // Ganti dengan logika yang sesuai
    // $rm_standart_nutss = DB::table('rm_standart_nutss as a')
    //                 ->select('a.name_material','a.spek','a.id','b.name as model')
    //                 ->join('data_models as b', 'b.id', '=', 'a.model', 'left')
    //                 ->get();
    return view('rmmaterial.innut', compact('title','rm_standart_nuts', 'master','rm_supplier_nuts'));
}


    public function list()
    {
        $query = DB::table('rm_in_nuts as a')
                // ->select('a.date_plan','a.doc_no','b.name_suplai as suplai',DB::raw('CONCAT(a.date_plan, b.id)as mix_id'))
                ->select('a.date_plan', 'a.doc_no', 'b.name_suplai as suplai', DB::raw('CONCAT(a.date_plan, a.doc_no, b.id) as mix_id'))
                ->join('rm_supplier_nuts as b', 'b.id', '=', 'a.suplai_id', 'left')
                ->groupBy('a.doc_no','a.date_plan', 'a.suplai_id', 'b.id')
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        // Fetch the data along with the material count from the database
        $query = DB::table('rm_in_nuts as a')
            ->select('a.id','a.keterangan','a.qty_plan','e.pt as suplai_id','a.category_id','b.part_nut as material_id','a.date_plan','a.createdby','a.no','a.qty_in','a.date_delivery')
            ->join('rm_supplier_nuts as e', 'e.id', '=', 'a.suplai_id', 'left')
            ->join('rm_standart_nuts as b', 'b.id', '=', 'a.material_id', 'left')
            // ->join('data_models as f', 'f.id', '=', 'c.model')
            ->where('a.doc_no', $request->doc_no)
            ->get();
    
        return DataTables::of($query)->make(true);
    }
    
    public function store(Request $request)
    {
        // Validate your request data here

        // Find the last material count for the same material_id
        $lastCount = DB::table('rm_in_nuts')
            ->where('material_id', $request->material_id)
            ->orderBy('id', 'desc')
            ->value('no');

        $newCount = $lastCount ? $lastCount + 1 : 1;

        // Insert the new record with the calculated no
        $query = DB::table('rm_in_nuts')->insert([
            'doc_no'                => $request->doc_no,
            'qty_in'                => $request->qty_in,
            'material_id'           => $request->material_id,
            'qty_plan'              => $request->qty_plan,
            'date_plan'             => $request->date_plan,
            'suplai_id'             => $request->suplai_id,
            'category_id'           => $request->category_id,
            'no'                    => $request->no,
            'keterangan'            => $request->keterangan,
            'date_delivery'         => $request->date_delivery,
            'createdby'             => $request->createdby,
            'no'                    => $newCount,
            'created_at'            => now(),
            'updated_at'            => now(),
        ]);

        if($query){
            return response()->json([
                'success' => true,
                'msg' => 'Insert success.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Insert failed.'
            ]);
        }
    }

    public function edit(Request $request)
    {
        $cek = RmInNut::where('id', $request->id)->count();
        if($cek > 0){
            $data = RmInNut::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'doc_no'         => $data->doc_no,
                'id'             => $data->id,
                'date_plan'      => $data->date_plan,
                'suplai_id'      => $data->suplai_id,
                'qty_in'         => $data->qty_in,
                'material_id'    => $data->material_id,
                'qty_plan'       => $data->qty_plan,
                'category_id'    => $data->category_id,
                'keterangan'     => $data->keterangan,
                'date_delivery'   => $data->date_delivery

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
        $data['date_plan']        = $request->date_plan;
        $data['qty_in']           = $request->qty_in;
        $data['material_id']      = $request->material_id;
        $data['qty_plan']         = $request->qty_plan;
        $data['category_id']      = $request->category_id;
        $data['keterangan']       = $request->keterangan;
        $data['date_delivery']    = $request->date_delivery;
        $data['updateby']         = auth()->user()->id;
        $query = RmInNut::where('id', $request->id)->update($data);
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
        $query = RmInNut::where('id', $request->id)->delete();
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
        $cek = RmInNut::select(DB::raw('COUNT(doc_no) as jml'))->whereMonth('created_at', date('m'))->groupBy('doc_no')->count();
        if($cek > 0){
            $array = array();
            $rows = RmInNut::select('doc_no')->whereMonth('created_at', date('m'))->groupBy('doc_no')->get();
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
        // Retrieve all records with the given doc_no and delete them
        $deletedCount = RmInNut::where('doc_no', $request->doc_no)->delete();
        
        if ($deletedCount > 0) {
            return response()->json([
                'success'   => true,
                'msg'       => 'Delete success.'
            ]);
        } else {
            return response()->json([
                'success'   => false,
                'msg'       => 'Data not found.'
            ]);
        }
    }
    


    public function submit(Request $request)
    {
        $cek = RmInNut::where('doc_no', $request->doc_no)->count();
        if($cek > 0){
            $data['sts'] = 1;
            $query = RmInNut::where('doc_no', $request->doc_no)->update($data);
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
        $query = RmInNut::where('doc_no', $request->doc_no)->delete();
        return back();
    }

    public function cetak($id)
    {
        // Find the master record by ID
        $master = RmInNut::findOrFail($id);
        $rm_standart_nuts = RmStandartNut::findOrFail($master->material_id);
        $rm_supplier_nuts = RmSupplierNut::findOrFail($master->suplai_id);
    
        // Include the description from rm_supplier_nuts in the data to encode
        $uniqNo = 'SP' . date('y') . '/' . date('dm') . $master->no;
        $data_to_encode = $rm_standart_nuts->part_nut . '||' . $rm_supplier_nuts->name_suplai . '||' . $master->qty_plan . '||' . $uniqNo;
    
        $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($data_to_encode));
    
        // Generate unique number
        $uniqNo = 'SP' . date('y') . '/' . date('dm') . $master->no;
    
        // Data to be displayed in the PDF
        $data = [
            'UniqNo'            => $uniqNo, // Using the combined value
            'rm_in_nuts'        => $master,
            'qrcode'            => $qrcode,
            'no'                => $master->no,
            'part_nut'          => $rm_standart_nuts->part_nut,
            'spek'              => $rm_standart_nuts->spek,
            'qty_in'            => $master->qty_in,
            'supplier_name'     => $rm_supplier_nuts->name_suplai,
        ];
    

        $pdf = Pdf::loadView('rmmaterial.cetaknut', $data)
        ->setPaper([0, 0, 75.73, 65.04], 'portrait')
        ->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
    
    return $pdf->stream('label.pdf');
        


    }
    
    public function printPdf($doc_no)
{
    // Manipulasi doc_no
    $doc_no_formatted = str_replace('-', '/', $doc_no);

    // Ambil semua data berdasarkan doc_no menggunakan Eloquent dan join
    $data = DB::table('rm_in_nuts as a')
            ->select('a.id','a.keterangan','a.qty_plan','e.pt as suplai_id','a.category_id','b.part_nut as material_id','a.date_plan','a.createdby','a.no','a.qty_in','a.doc_no','a.date_delivery')
            ->join('rm_supplier_nuts as e', 'e.id', '=', 'a.suplai_id', 'left')
            ->join('rm_standart_nuts as b', 'b.id', '=', 'a.material_id', 'left')
            ->where('a.doc_no', $doc_no)
            ->get();

    // Cek apakah data ditemukan
    if ($data->isEmpty()) {
        return redirect()->back()->with('error', 'Data not found.');
    }

    // Hanya ambil doc_no untuk QR Code98
    $qrCodeData = $doc_no;
    $qrCode = base64_encode(QrCode::format('svg')->size(200)->generate($qrCodeData));

    // Load view untuk PDF dan kirimkan data dan QR code dengan orientasi landscape
    $pdf = PDF::loadView('rmmaterial.dncetaknut', compact('data', 'doc_no_formatted', 'qrCode'))
              ->setPaper('a4', 'landscape');

    // Tampilkan PDF di browser
    return $pdf->stream('rmmaterial.dncetaknut' . $doc_no . '.pdf');
}


public function getMaterialsByDocNo(Request $request)
{
    $doc_no = $request->input('doc_no');
    
    // Mengambil semua data berdasarkan doc_no
    $query = DB::table('rm_in_nuts as a')
    ->select('a.id','a.keterangan','a.qty_plan','e.pt as suplai_id','a.category_id','b.part_nut as material_id','a.date_plan','a.createdby','a.no','a.qty_in','a.date_delivery','a.doc_no')
    ->join('rm_supplier_nuts as e', 'e.id', '=', 'a.suplai_id', 'left')
    ->join('rm_standart_nuts as b', 'b.id', '=', 'a.material_id', 'left')
    // ->join('data_models as f', 'f.id', '=', 'c.model')
    ->where('a.doc_no', $request->doc_no)
    ->get();
    
    return response()->json($query);
}

public function updateQtyIn(Request $request)
{
    $updates = $request->input('updates');

    foreach ($updates as $update) {
        // Update qty_in in rm_in_nuts
        DB::table('rm_in_nuts')
            ->where('id', $update['id'])
            ->update(['qty_in' => $update['qty_in']]);

        // Get the part_nut associated with this rm_in_nuts record
        $partNut = DB::table('rm_in_nuts')
            ->where('id', $update['id'])
            ->value('material_id');

        if ($partNut) {
            // Check if part_nut exists in rm_stok_nuts
            $stokNut = DB::table('rm_stok_nuts')
                ->where('part_nut', $partNut)
                ->first();

            if ($stokNut) {
                // If exists, update the quantity (add qty_in to the existing quantity)
                DB::table('rm_stok_nuts')
                    ->where('part_nut', $partNut)
                    ->update(['actual' => $stokNut->actual + $update['qty_in']]);
            } else {
                // If not exists, insert a new record
                DB::table('rm_stok_nuts')->insert([
                    'part_nut' => $partNut,
                    'actual' => $update['qty_in']
                ]);
            }
        }
    }

    return response()->json(['success' => true]);
}


public function printMultiple(Request $request)
{
    $ids = $request->input('ids'); // Ambil daftar ID dari request

    // Ambil data berdasarkan ID
    $items = RmInNut::whereIn('id', $ids)->get();

    // Buat instance PDFMerger
    $pdfMerger = new PDFMerger();

    foreach ($items as $item) {
        $data = [
            'data' => $item,
            'supplier_name' => $item->supplier_name, // Pastikan ini sesuai dengan struktur model
            'no'            => $item->no,
            'qty_in'        => $item->qty_in,
            'part_nut'      => $item->part_nut,
            'qrcode'        => $item->qrcode,
        ];
        
        // Buat PDF dari view
        $pdf = PDF::loadView('rmmaterial.cetaknut', $data);
        $pdfMerger->addPDF($pdf->output(), 'all'); // Menambahkan PDF
    }

    // Simpan file PDF gabungan
    $outputFile = 'merged.pdf'; // Nama file keluaran
    $pdfMerger->merge('file', storage_path('app/public/pdf/' . $outputFile)); // Simpan ke storage

    return response()->json([
        'pdf_url' => route('download.file', ['filename' => $outputFile])
    ]);
}




}
