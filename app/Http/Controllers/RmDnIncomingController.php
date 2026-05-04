<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\RmDnIncoming;
use App\Models\RmMaterial;
use App\Models\RmMonthly;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RmDnIncomingImport; // Pastikan namespace ini benar
use App\Exports\PoExport;
use DataTables;
use DB;
use Illuminate\Support\Facades\Log;

class RmDnIncomingController extends Controller
{
    public function index(){
        $title = 'DN Upload';
        $rm_dn_incomings = RmDnIncoming::all();
        $rm_monthlies = RmMonthly::all();
        return view('rmmaterial.indexdn', compact('title','rm_dn_incomings'));
    }

    public function list()
    {
        $query = DB::table('rm_dn_incomings as a')
                ->select('a.created_at', DB::raw('CONCAT(a.created_at) as id'))
                ->groupBy('a.created_at')
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('rm_dn_incomings as a')
                ->select('a.id', 'a.part_no', 'a.kanban', 'a.model', 'a.spec', 'a.spec_t', 'a.spec_w', 'a.spec_l','a.doc_dn','a.actual_sheet','a.actual_kg','a.order_sheet','a.spec_kg','a.order_kg','a.no_dn','a.supplier','a.delivery')
                ->where('a.created_at', $request->created_at)
                ->get();

        return DataTables::of($query)->make();
    }


    public function edit(Request $request)
    {
        // $title = 'DN';
        // return view('rmmaterial.editdn', compact('title'));
        $cek = RmDnIncoming::where('id', $request->id)->count();
        if($cek > 0){
            $row = RmDnIncoming::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'part_no'        => $row->part_no,
                'kanban'         => $row->kanban,
                'model'          => $row->model,
                'spec'           => $row->spec,
                'spec_t'         => $row->spec_t,
                'spec_w'         => $row->spec_w,
                'spec_l'         => $row->spec_l,
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
            $rm_dn_incoming = RmDnIncoming::find($row['id']);

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
        $query = RmDnIncoming::where('created_at', $request->created_at)->delete();
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
        $query = RmDnIncoming::where('created_at', $request->created_at)->delete();
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
        $data = RmDnIncoming::whereYear('created_at', $year)
                            ->whereMonth('created_at', $month)
                            ->get();

        // Ekspor data menggunakan Excel
        return Excel::download(new PoExport($data), 'po.xlsx');
    }

    public function templateDn()
    {
        return Excel::download(new \App\Exports\TemplateDnExport, 'Template_DN.xlsx');
    }


    public function importDn(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            Excel::import(new RmDnIncomingImport, $request->file('file'));
            return back()->with('success', 'Data DN berhasil diimport!');
        } catch (\Exception $e) {
            Log::error('Import DN Gagal: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data DN!');
        }
    }

    public function cetak($id)
    {
        // Find the master record by ID
        $rm_dn_incomings = RmDnIncoming::findOrFail($id);

        // Perform an inner join to get the supplier from rm_materials based on the spec field
        // $rm_material = RmMaterial::where('spec', $rm_dn_incomings->spec)->firstOrFail();

        // Create a unique number by combining date and 'urutan' value
        $uniqNo = date('dm') . $rm_dn_incomings->urutan . date('s', strtotime($rm_dn_incomings->updated_at));


        // Prepare data for the QR code (combine fields)
        $data_to_encode = $uniqNo . '||' . $rm_dn_incomings->spec . '||'. $rm_dn_incomings->part_no. '||'. $rm_dn_incomings->actual_sheet . '||'. $rm_dn_incomings->supplier. '||'. $rm_dn_incomings->id;

        // Generate QR code with the concatenated data
        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data_to_encode));

        // Data to be displayed in the PDF
        $data = [
            'qrcode'        => $qrcode,
            'uniqNo'        => $uniqNo,
            'doc_dn'        => $rm_dn_incomings->doc_dn,
            'supplier'      => $rm_dn_incomings->supplier,
            'model'         => $rm_dn_incomings->model,
            'spec_t'        => $rm_dn_incomings->spec_t,
            'part_no'       => $rm_dn_incomings->part_no,
            'spec_w'        => $rm_dn_incomings->spec_w,
            'spec_l'        => $rm_dn_incomings->spec_l,
            'actual_sheet'  => $rm_dn_incomings->actual_sheet,
            'createdby'     => 'John Doe', // Replace with actual data for 'createdby'
            'spec'          => $rm_dn_incomings->spec, // Replace 'spec' with actual column if different4
            'no_rak'        => $rm_dn_incomings->no_rak,
            'updatedby'     => $rm_dn_incomings->updatedby,
            'updated_at'    => $rm_dn_incomings->updated_at,
        ];

        // Define custom paper size (100mm x 150mm in points)
        $customPaper = array(0, 0, 283.465, 425.1975);

        // Load PDF view with data and set custom paper size
        $pdf = PDF::loadView('rmmaterial.cetak2', $data)
                  ->setPaper($customPaper, 'portrait');  // 'portrait' for normal orientation

        // Stream the generated PDF with a filename that includes the date and unique ID
        return $pdf->stream(date('d_M_Y') . '_' . $rm_dn_incomings->id . '_qrcode.pdf');
    }

    public function getChartData(Request $request)
{
    // Ambil filter dari request
    $month = $request->input('month');

    // Ambil data dan jumlahkan nilai kolom berdasarkan 'month' dan 'year'
    $data = DB::table('rm_monthlies')
        ->select(
            DB::raw('ROUND(SUM(tgl_1), 2) as total_tgl_1'),
            DB::raw('ROUND(SUM(tgl_2), 2) as total_tgl_2'),
            DB::raw('ROUND(SUM(tgl_3), 2) as total_tgl_3'),
            DB::raw('ROUND(SUM(tgl_4), 2) as total_tgl_4'),
            DB::raw('ROUND(SUM(tgl_5), 2) as total_tgl_5'),
            DB::raw('ROUND(SUM(tgl_6), 2) as total_tgl_6'),
            DB::raw('ROUND(SUM(tgl_7), 2) as total_tgl_7'),
            DB::raw('ROUND(SUM(tgl_8), 2) as total_tgl_8'),
            DB::raw('ROUND(SUM(tgl_9), 2) as total_tgl_9'),
            DB::raw('ROUND(SUM(tgl_10), 2) as total_tgl_10'),
            DB::raw('ROUND(SUM(tgl_11), 2) as total_tgl_11'),
            DB::raw('ROUND(SUM(tgl_12), 2) as total_tgl_12'),
            DB::raw('ROUND(SUM(tgl_13), 2) as total_tgl_13'),
            DB::raw('ROUND(SUM(tgl_14), 2) as total_tgl_14'),
            DB::raw('ROUND(SUM(tgl_15), 2) as total_tgl_15'),
            DB::raw('ROUND(SUM(tgl_16), 2) as total_tgl_16'),
            DB::raw('ROUND(SUM(tgl_17), 2) as total_tgl_17'),
            DB::raw('ROUND(SUM(tgl_18), 2) as total_tgl_18'),
            DB::raw('ROUND(SUM(tgl_19), 2) as total_tgl_19'),
            DB::raw('ROUND(SUM(tgl_20), 2) as total_tgl_20'),
            DB::raw('ROUND(SUM(tgl_21), 2) as total_tgl_21'),
            DB::raw('ROUND(SUM(tgl_22), 2) as total_tgl_22'),
            DB::raw('ROUND(SUM(tgl_23), 2) as total_tgl_23'),
            DB::raw('ROUND(SUM(tgl_24), 2) as total_tgl_24'),
            DB::raw('ROUND(SUM(tgl_25), 2) as total_tgl_25'),
            DB::raw('ROUND(SUM(tgl_26), 2) as total_tgl_26'),
            DB::raw('ROUND(SUM(tgl_27), 2) as total_tgl_27'),
            DB::raw('ROUND(SUM(tgl_28), 2) as total_tgl_28'),
            DB::raw('ROUND(SUM(tgl_29), 2) as total_tgl_29'),
            DB::raw('ROUND(SUM(tgl_30), 2) as total_tgl_30'),
            DB::raw('ROUND(SUM(tgl_31), 2) as total_tgl_31'),

            // actual

            DB::raw('ROUND(SUM(actual_1), 2) as actual_1'),
            DB::raw('ROUND(SUM(actual_2), 2) as actual_2'),
            DB::raw('ROUND(SUM(actual_3), 2) as actual_3'),
            DB::raw('ROUND(SUM(actual_4), 2) as actual_4'),
            DB::raw('ROUND(SUM(actual_5), 2) as actual_5'),
            DB::raw('ROUND(SUM(actual_6), 2) as actual_6'),
            DB::raw('ROUND(SUM(actual_7), 2) as actual_7'),
            DB::raw('ROUND(SUM(actual_8), 2) as actual_8'),
            DB::raw('ROUND(SUM(actual_9), 2) as actual_9'),
            DB::raw('ROUND(SUM(actual_10), 2) as actual_10'),

        )
        ->when($month, function ($query) use ($month) {
            return $query->where('month', $month);
        })
        ->first();

    if (!$data) {
        return response()->json(['error' => 'No data found'], 404);
    }

    $response = [
        'labels' => ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
        'datasets' => [
            'AccumulationPlan' => [
                round($data->total_tgl_1 ?? 0, 2),
                round($data->total_tgl_2 ?? 0, 2),
                round($data->total_tgl_3 ?? 0, 2),
                round($data->total_tgl_4 ?? 0, 2),
                round($data->total_tgl_5 ?? 0, 2),
                round($data->total_tgl_6 ?? 0, 2),
                round($data->total_tgl_7 ?? 0, 2),
                round($data->total_tgl_8 ?? 0, 2),
                round($data->total_tgl_9 ?? 0, 2),
                round($data->total_tgl_10 ?? 0, 2),
                round($data->total_tgl_11 ?? 0, 2),
                round($data->total_tgl_12 ?? 0, 2),
                round($data->total_tgl_13 ?? 0, 2),
                round($data->total_tgl_14 ?? 0, 2),
                round($data->total_tgl_15 ?? 0, 2),
                round($data->total_tgl_16 ?? 0, 2),
                round($data->total_tgl_17 ?? 0, 2),
                round($data->total_tgl_18 ?? 0, 2),
                round($data->total_tgl_19 ?? 0, 2),
                round($data->total_tgl_20 ?? 0, 2),
                round($data->total_tgl_21 ?? 0, 2),
                round($data->total_tgl_22 ?? 0, 2),
                round($data->total_tgl_23 ?? 0, 2),
                round($data->total_tgl_24 ?? 0, 2),
                round($data->total_tgl_25 ?? 0, 2),
                round($data->total_tgl_26 ?? 0, 2),
                round($data->total_tgl_27 ?? 0, 2),
                round($data->total_tgl_28 ?? 0, 2),
                round($data->total_tgl_29 ?? 0, 2),
                round($data->total_tgl_30 ?? 0, 2),
                round($data->total_tgl_31 ?? 0, 2),
            ],
            'AccumulationActual' => [
                round($data->actual_1 ?? 0, 2),
                round($data->actual_2 ?? 0, 2),
                round($data->actual_3 ?? 0, 2),
                round($data->actual_4 ?? 0, 2),
                round($data->actual_5 ?? 0, 2),
                round($data->actual_6 ?? 0, 2),
                round($data->actual_7 ?? 0, 2),
                round($data->actual_8 ?? 0, 2),
                round($data->actual_9 ?? 0, 2),
                round($data->actual_10 ?? 0, 2),

                // round($data->total_actual_4 ?? 0, 2),
            ]
        ]
    ];


    return response()->json($response);
}





}
