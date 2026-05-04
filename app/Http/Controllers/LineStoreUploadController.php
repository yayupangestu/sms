<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\LineStoreUpload;
use App\Models\LineStoreLabelSubcont;
use App\Models\RmMaterial;
use App\Models\RmMonthly;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LsDnIncomingImport; // Pastikan namespace ini benar
use App\Exports\PoExport;
use DataTables;
use DB;

class LineStoreUploadController extends Controller
{
    public function index(){
        $title = 'DN Upload';
        $line_store_label_subconts = LineStoreLabelSubcont::all(); 
        $line_store_uploads = LineStoreUpload::all();
        $rm_monthlies = RmMonthly::all();
        return view('linestore.upload', compact('title','line_store_uploads'));
    }

    public function list()
    {
        $query = DB::table('line_store_uploads as a')
                ->select('a.no_dn', 'a.supplier', DB::raw('CONCAT(a.no_dn, a.supplier) as id'))
                ->groupBy('a.no_dn', 'a.supplier')
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    { 
        $query = DB::table('line_store_uploads as a')
                ->select('a.id', 'a.part_no', 'a.job_no', 'a.part_name', 'a.order_part', 'a.balance_order', 'a.no_dn', 'a.no_po','a.tgl_delivery','a.supplier')
                ->where('a.no_dn', $request->no_dn)
                // ->where('part_no', $request->part_no)
                ->get();
    
        return DataTables::of($query)->make();
    }

    public function listdetail2(Request $request)
    {
        $query = DB::table('line_store_label_subconts as a')
            ->select('a.id', 'a.part_no', 'a.job_no', 'a.no_dn', 'a.qty_act', 'a.supplier')
            // ->where('a.no_dn', $request->no_dn)
            ->where('a.part_no', $request->part_no)
            ->get();
    
        return DataTables::of($query)->make(true);
    }
    
    

    public function store(Request $request)
{
    $plan               = new LineStoreLabelSubcont;
    $plan->id_data      = $request->id;
    $plan->no_dn        = $request->no_dn;
    $plan->part_no      = $request->part_no;
    $plan->job_no       = $request->job_no;
    $plan->qty_act      = $request->qty_act;
    $plan->supplier     = $request->supplier;
    $plan->createdby    = auth()->user()->username;

    // Tambahkan logika alamat jika supplier adalah TCF
    if (strtoupper($request->supplier) === 'ASI-2') {
        $plan->alamat = 'Jl.Mitra Raya Sel. II No.6 41363 Kutamekar Jawa Barat';
    }

    $query = $plan->save();

    if ($query) {
        return response()->json([
            'success' => true,
            'msg'     => 'Insert success.'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'msg'     => 'Insert failed.'
        ]);
    }
}

    

    public function edit(Request $request)
    {
        // $title = 'DN';
        // return view('rmmaterial.editdn', compact('title'));
        $cek = LineStoreLabelSubcont::where('part_no', $request->part_no)->count();
        if($cek > 0){
            $row = LineStoreLabelSubcont::where('part_no', $request->part_no)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'no_dn'         => $row->no_dn,
                'supplier'         => $row->supplier,
                'job_no'         => $row->job_no,
                'part_no'        => $row->part_no,
                'qty_act'        => $row->qty_act,
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
        $data = $request->input('data'); // Assuming 'data' contains the input rows (array of rows)
        
        foreach ($data as $row) {
            // Find the record by ID
            $rm_dn_incoming = LineStoreUpload::find($row['id']);
            
            // Check if record exists
            if ($rm_dn_incoming) {
                // Update only the actual_sheet and updatedby columns
                $rm_dn_incoming->actual_sheet = $row['actual_sheet'];
                $rm_dn_incoming->updatedby = auth()->user()->username; // Set the updated by username
                $rm_dn_incoming->save(); // Save the updated record
            }
        }
    
        return response()->json(['success' => true]); // Return success response
    }
    
    


    public function destroyline(Request $request)
    {
        $query = LineStoreLabelSubcont::where('id', $request->id)->delete();
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
        $query = LineStoreUpload::where('no_dn', $request->no_dn)->delete();
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

    public function exportDn(Request $request)
    {
        // Validasi input tahun dan bulan
        $request->validate([
            'year' => 'required|integer',
            'month' => 'required|integer|min:1|max:12',
        ]);
    
        // Ambil tahun dan bulan dari request
        $year = $request->input('year');
        $month = $request->input('month');
    
        // Query data berdasarkan tahun dan bulan
        $data = LineStoreUpload::whereYear('no_dn', $year)
                            ->whereMonth('no_dn', $month)
                            ->get();
    
        // Ekspor data menggunakan Excel
        return Excel::download(new PoExport($data), 'po.xlsx');
    }
    

    public function importDnLs(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        // Import data menggunakan class LineStoreUploadImport
        Excel::import(new LsDnIncomingImport, $request->file('file'));

        return back()->with('success', 'Data DN berhasil diimport!');
    }

    public function generateMultipleQrCodes(Request $request)
    {
        // Validasi data input
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:line_store_label_subconts,id',
        ]);
        

        $data_to_print = [];

        foreach ($request->ids as $id) {

            $line_store_label_subconts = LineStoreLabelSubcont::findOrFail($id);

            // $uniqNo = date('dm') . $line_store_label_subconts->urutan . date('s', strtotime($line_store_label_subconts->updated_at));       

            $data_to_encode = $line_store_label_subconts->no_dn . '.' . $line_store_label_subconts->part_no. '.' . $line_store_label_subconts->id_data. '.' .$line_store_label_subconts->supplier. '.' .$line_store_label_subconts->qty_act;

            $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data_to_encode));

            $data_to_print[] = [
                'qrcode'        => $qrcode,
                // 'uniqNo'        => $uniqNo,
                'no_dn'       => $line_store_label_subconts->no_dn,
                'part_no'         => $line_store_label_subconts->part_no,
                'qty_act'         => $line_store_label_subconts->qty_act,
                'supplier'         => $line_store_label_subconts->supplier,
                'createdby'        => $line_store_label_subconts->createdby,
                'created_at'        => $line_store_label_subconts->created_at,
                'alamat'        => $line_store_label_subconts->alamat,
            ];
        }

        // 8cm x 10cm = 226.77 x 283.46 pt
        $customPaper = [0, 0, 310, 315]; // 100mm x 150mm

        // Generate PDF
        $pdf = PDF::loadView('linestore.labelsubcont', ['data' => $data_to_print])
                  ->setPaper($customPaper, 'potrait');

        // Return the PDF to the browser
        return $pdf->stream('qrcodes_' . date('d_M_Y') . '.pdf');



}
    

    
    
}

