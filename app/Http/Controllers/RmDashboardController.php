<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Exports\DnIncomingExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use App\Models\DataModel;
use App\Models\RmInMaterial;
use App\Models\RmStok;
use App\Models\ScanInLabel;
use App\Models\RmDnIncoming;
use App\Models\DnInput;
use App\Models\User;
use DataTables;
use Carbon\Carbon;
use DB;

class RmDashboardController extends Controller
{
    public function index(){
        $title = 'Dashboard RM';
        $dn_inputs = DnInput::all();
        $users = User::all();
        $scan_in_labels = ScanInLabel::all();
        $rm_dn_incomings = RmDnIncoming::all();
        $rm_stoks = DB::table('rm_stoks as a')
                ->select('a.id','a.part_name','a.model_id','a.category_id','a.minimal','a.actual_sheet','b.name_material as material_id','a.updated_at')
                ->join('rm_materials as b', 'b.id', '=', 'a.material_id', 'left')
                ->get();
        return view('dashboard.rmmaterial', compact('title','rm_stoks','scan_in_labels','rm_dn_incomings','users'));
    }

   public function detail(Request $request)
    {
        $supplier = $request->input('supplier');

        // Ambil awal bulan ini dan akhir bulan depan
        $startOfThisMonth = now()->startOfMonth();
        $endOfNextMonth = now()->copy()->addMonth()->endOfMonth();

        // Filter berdasarkan supplier dan rentang waktu created_at
        $materials = RmDnIncoming::where('supplier', $supplier)
            ->whereBetween('created_at', [$startOfThisMonth, $endOfNextMonth])
            ->orderBy('created_at') // Urutkan berdasarkan tanggal
            ->get()
            ->map(function ($item) use ($startOfThisMonth) {
                $item->bg_color = $item->balance_sheet === 'close' ? '#a3eca3' : '#eca3a3';

                // Tambahkan label bulan
                $item->month_label = $item->created_at->month === $startOfThisMonth->month
                    ? 'Bulan Ini'
                    : 'Bulan Depan';

                return $item;
            });

        return response()->json($materials);
    }

    public function fetchPartNo()
    {
        $partNos = DB::table('rm_dn_incomings')->pluck('part_no');
        return response()->json($partNos);
    }

    public function cetak($id)
    {
        // Find the master record by ID
        $dn_inputs = DnInput::findOrFail($id);

        // $uniqNo = date('dm') . $dn_inputs->urutan . date('s', strtotime($dn_inputs->updated_at));

        $data_to_encode = $dn_inputs->part_no . '||' . $dn_inputs->spec . '||' . $dn_inputs->supplier . '||' . $dn_inputs->uniq_no . '||' . $dn_inputs->detail_id . '||' . $dn_inputs->id . '||' . $dn_inputs->kg_sheet . '||' . $dn_inputs->actual;

        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data_to_encode));

        $data = [
            'qrcode'        => $qrcode,
            // 'uniqNo'        => $uniqNo,
            'uniq_no'       => $dn_inputs->uniq_no,
            'part_no'       => $dn_inputs->part_no,
            'doc_dn'        => $dn_inputs->doc_dn,
            'model'         => $dn_inputs->model,
            'createdby'     => $dn_inputs->createdby,
            'doc_po'        => $dn_inputs->doc_po,
            'spec_t'        => $dn_inputs->spec_t,  // Format dynamically without rounding
            'spec_w'        => $dn_inputs->spec_w,
            'spec_l'        => $dn_inputs->spec_l,
            'kg_sheet'      => $dn_inputs->kg_sheet,
            'created_at'    => $dn_inputs->created_at,
            'supplier'      => $dn_inputs->supplier,
            'actual'        => $dn_inputs->actual,
            'spec'          => $dn_inputs->spec,
            'no_rak'        => $dn_inputs->no_rak,
            'uniq_no'       => $dn_inputs->uniq_no,
        ];

        // Define custom paper size (100mm x 150mm in points)
        $customPaper = array(0, 0, 283.465, 425.1975);

        // Load PDF view with data and set custom paper size
        $pdf = PDF::loadView('rmmaterial.cetak2', $data)
                  ->setPaper($customPaper, 'portrait');  // 'portrait' for normal orientation

        // Stream the generated PDF with a filename that includes the date and unique ID
        return $pdf->stream(date('d_M_Y') . '_' . $dn_inputs->id . '_qrcode.pdf');
    }

    public function generateMultipleQrCodes(Request $request)
    {
        // Validasi data input
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:dn_inputs,id',
        ]);

        $data_to_print = [];

        foreach ($request->ids as $id) {

            $dn_inputs = DnInput::findOrFail($id);

            $uniqNo = date('dm') . $dn_inputs->urutan . date('s', strtotime($dn_inputs->updated_at));

            $data_to_encode = $dn_inputs->part_no . '||' . $dn_inputs->spec . '||' . $dn_inputs->supplier . '||' . $dn_inputs->uniq_no . '||' . $dn_inputs->detail_id . '||' . $dn_inputs->id . '||' . $dn_inputs->kg_sheet . '||' . $dn_inputs->actual;

            $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data_to_encode));

            $data_to_print[] = [
                'qrcode'        => $qrcode,
                'uniqNo'        => $uniqNo,
                'part_no'       => $dn_inputs->part_no,
                'doc_dn'        => $dn_inputs->doc_dn,
                'model'         => $dn_inputs->model,
                'createdby'     => $dn_inputs->createdby,
                'doc_po'        => $dn_inputs->doc_po,
                'spec_t'        => $dn_inputs->spec_t,
                'spec_w'        => $dn_inputs->spec_w,
                'spec_l'        => $dn_inputs->spec_l,
                'kg_sheet'      => $dn_inputs->kg_sheet,
                'created_at'    => $dn_inputs->created_at,
                'supplier'      => $dn_inputs->supplier,
                'actual'        => $dn_inputs->actual,
                'spec'          => $dn_inputs->spec,
                'no_rak'        => $dn_inputs->no_rak,
                'uniq_no'       => $dn_inputs->uniq_no,
            ];
        }

        // Define custom paper size
        $customPaper = [0, 0, 283.465, 425.1975]; // 100mm x 150mm

        // Generate PDF
        $pdf = PDF::loadView('rmmaterial.cetak2_multiple', ['data' => $data_to_print])
                  ->setPaper($customPaper, 'portrait');

        // Return the PDF to the browser
        return $pdf->stream('qrcodes_' . date('d_M_Y') . '.pdf');
    }

    public function count()
    {
        $currentYear = date('Y'); // Mendapatkan tahun saat ini
        $currentMonth = date('m'); // Mendapatkan bulan saat ini

        // Count for status 'Close' based on specified suppliers and current month and year
        $closeCounts = DB::table('rm_dn_incomings')
                    ->select('supplier', DB::raw('count(*) as total'))
                    ->where('status', 'Close')
                    ->whereIn('supplier', ['POSCO-1', 'TTMI','SSK','POSCO-2', 'SCI', 'HTI','SAI','JSSI','USC']) // Limit to specified suppliers
                    ->whereYear('created_at', $currentYear) // Filter by current year
                    ->whereMonth('created_at', $currentMonth) // Filter by current month
                    ->groupBy('supplier')
                    ->get();

        // Count for status NULL based on specified suppliers and current month and year
        $openCounts = DB::table('rm_dn_incomings')
                    ->select('supplier', DB::raw('count(*) as total'))
                    ->whereNull('status')
                    ->whereIn('supplier', ['POSCO-1', 'TTMI','SSK','POSCO-2', 'SCI', 'HTI','SAI','JSSI','USC']) // Limit to specified suppliers
                    ->whereYear('created_at', $currentYear) // Filter by current year
                    ->whereMonth('created_at', $currentMonth) // Filter by current month
                    ->groupBy('supplier')
                    ->get();

        // Total count for specified suppliers and current month and year
        $totalCounts = DB::table('rm_dn_incomings')
                    ->select('supplier', DB::raw('count(*) as total'))
                    ->whereIn('supplier', ['POSCO-1', 'TTMI','SSK','POSCO-2', 'SCI', 'HTI','SAI','JSSI','USC']) // Limit to specified suppliers
                    ->whereYear('created_at', $currentYear) // Filter by current year
                    ->whereMonth('created_at', $currentMonth) // Filter by current month
                    ->groupBy('supplier')
                    ->get();

        // Combine the results into a single response
        return response()->json([
            'close' => $closeCounts,
            'open' => $openCounts,
            'total' => $totalCounts
        ]);
    }

    public function close()
    {
        $closeMaterials = RmDnIncoming::where('status', 'Close')->get();
        return response()->json($closeMaterials);
    }

    public function getSupplierData(Request $request)
    {
        $supplier = $request->input('supplier');
        $status = $request->input('status');

        $query = DB::table('rm_dn_incomings')
            ->where('supplier', $supplier)
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->orderBy('created_at', 'desc'); // Urutkan dari yang terbaru

        if ($status === 'NULL') {
            $query->whereNull('status');
        } else {
            $query->where('status', $status);
        }

        $data = $query->get();

        return response()->json($data);
    }


    public function getSupplierData2(Request $request)
    {
        // Ambil parameter created_at, year, dan month dari request
        $createdAt = $request->input('created_at', null);
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        // Query untuk mengambil data dengan filter tahun, bulan, dan/atau created_at jika diberikan
        $query = DB::table('rm_dn_incomings')
            ->select('supplier', 'delivery',
                DB::raw('SUM(order_kg) as total_order_kg'),
                DB::raw('SUM(actual_kg) as total_actual_kg'))
            ->groupBy('supplier', 'delivery'); // Grupkan berdasarkan supplier dan delivery

        // Jika parameter created_at diberikan, filter berdasarkan tanggal tersebut
        if ($createdAt) {
            $query->whereDate('created_at', $createdAt); // Filter berdasarkan tanggal created_at
        } else {
            // Filter berdasarkan tahun dan bulan jika created_at tidak diberikan
            $query->whereYear('created_at', $year) // Filter berdasarkan tahun
                  ->whereMonth('created_at', $month); // Filter berdasarkan bulan
        }

        // Ambil data hasil query
        $data = $query->get();

        // Mengembalikan data sebagai JSON
        return response()->json($data);
    }


    public function getSupplierData3(Request $request)
    {
        $month = $request->input('month', now()->month);  // Default to the current month
        $year = $request->input('year', now()->year);    // Default to the current year
        $createdAt = $request->input('created_at', null); // Get created_at from the query parameters

        \Log::info('Received created_at filter: ', ['created_at' => $createdAt]); // Log the received created_at filter

        $query = DB::table('rm_dn_incomings')
            ->select('supplier', 'delivery', 'status',
                    DB::raw('SUM(order_kg) as total_order_kg'),
                    DB::raw('SUM(actual_kg) as total_actual_kg'))
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month);

        if ($createdAt) {
            // Log the filtered query to check if it matches the expected date
            \Log::info('Applying created_at filter', ['created_at' => $createdAt]);
            $query->whereDate('created_at', $createdAt);
        }

        $data = $query->groupBy('supplier', 'delivery', 'status')
                      ->get();

        \Log::info('Data retrieved from database: ', ['data' => $data]); // Log the data returned

        return response()->json($data);
    }

    public function export(Request $request)
    {
        // Get the supplier and docPo filters from the request
        $supplierFilter = $request->input('supplierFilter', '');
        $docPoFilter = $request->input('docPoFilter', '');
        $periodeFilter = $request->input('periodeFilter', '');

        // If supplierFilter is 'ALL', don't apply any supplier filtering
        if ($supplierFilter === 'ALL') {
            $supplierFilter = '';  // Or handle it to include all suppliers in your query logic.
        }

        // Export logic
        return Excel::download(new DnIncomingExport($supplierFilter, $docPoFilter, $periodeFilter), 'DN-INCOMING.xlsx');
    }

    public function detail2(Request $request)
    {
        // Ambil data material
        $material = RmDnIncoming::find($request->id);

        if (!$material) {
            return response()->json(['error' => 'Material not found'], 404);
        }

        // Ambil data dn_inputs berdasarkan part_no material
        $dnInputs = DnInput::where('part_no', $material->part_no)->where('doc_po', $material->doc_po)->where('delivery', $material->delivery)->get();

        // Gabungkan data material dan dn_inputs dalam response
        return response()->json([
            'material' => $material,
            'dn_inputs' => $dnInputs
        ]);
    }

//     public function insertPartNo(Request $request)
// {
//     try {
//         // Validation
//         $request->validate([
//             'id'        => 'nullable|integer',
//             'part_no'   => 'required|string|max:255',
//             'actual'    => 'required|integer',
//             'doc_po'    => 'nullable|string|max:255',
//             'doc_dn'    => 'nullable|string|max:255',
//             'spec'      => 'nullable|string|max:255',
//             'kg_sheet'  => 'required|numeric',
//             'spec_t'    => 'required|string',
//             'spec_w'    => 'required|string',
//             'spec_l'    => 'required|string',
//             'supplier'  => 'required|string',
//             'delivery'  => 'required|string',
//             'no_rak'    => 'required|string',
//             'model'     => 'required|string',
//             'detail_id' => 'required|string',
//         ]);

//         // Insert or update data
//         $data = new DnInput();
//         if ($request->id) {
//             $data = DnInput::find($request->id);
//             if (!$data) {
//                 return response()->json(['success' => false, 'message' => 'Data not found.']);
//             }
//         } else {
//             // Generate uniq_no for new entries only
//             $currentTimestamp = now();
//             $uniqNo = date('dis', strtotime($currentTimestamp)); // Format: ddmmyyHHmmss
//             $data->uniq_no = $uniqNo;
//         }

//         // Update the fields
//         $data->doc_dn = $request->doc_dn;
//         $data->doc_po = $request->doc_po;
//         $data->part_no = $request->part_no;
//         $data->actual = $request->actual;
//         $data->kg_sheet = $request->kg_sheet;
//         $data->spec = $request->spec;
//         $data->spec_t = $request->spec_t;
//         $data->spec_w = $request->spec_w;
//         $data->spec_l = $request->spec_l;
//         $data->supplier = $request->supplier;
//         $data->delivery = $request->delivery;
//         $data->no_rak = $request->no_rak;
//         $data->model = $request->model;
//         $data->detail_id = $request->detail_id;
//         $data->sts_scan = $request->sts_scan;

//         // Added createdby
//         $data->createdby = auth()->user()->username;

//         // Set update_time to current timestamp
//         $data->update_time = now();

//         // Save data
//         $data->save();

//         // Return success response with the update_time
//         return response()->json([
//             'success' => true,
//             'id' => $data->id,
//             'uniq_no' => $data->uniq_no, // Include uniq_no in the response
//             'update_time' => $data->update_time->format('Y-m-d H:i:s'),
//             'message' => 'Data successfully saved.'
//         ]);
//     } catch (\Exception $e) {
//         return response()->json(['success' => false, 'message' => $e->getMessage()]);
//     }
// }

public function insertPartNo(Request $request)
{
    try {
        // === 1️⃣ VALIDATION ===
        $request->validate([
            'id'        => 'nullable|integer',
            'part_no'   => 'required|string|max:255',
            'actual'    => 'required|integer',
            'doc_po'    => 'nullable|string|max:255',
            'doc_dn'    => 'nullable|string|max:255',
            'spec'      => 'nullable|string|max:255',
            'kg_sheet'  => 'required|numeric',
            'spec_t'    => 'required|string',
            'spec_w'    => 'required|string',
            'spec_l'    => 'required|string',
            'supplier'  => 'required|string',
            'delivery'  => 'required|string',
            'no_rak'    => 'required|string',
            'model'     => 'required|string',
            'detail_id' => 'required|string',
        ]);

        // === 2️⃣ CARI ATAU BUAT BARU ===
        if ($request->id) {
            $data = DnInput::find($request->id);
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data not found.'
                ]);
            }
        } else {
            $data = new DnInput();

            // --- 🔹 Generate uniq_no ---
            $prefix  = strtoupper(substr($request->spec ?? 'XXX', 0, 3)); // 3 huruf pertama dari spec
            $now     = now();
            $tanggal = $now->format('d'); // contoh: 17
            $bulan   = $now->format('m'); // contoh: 10
            $bulanChar = substr($bulan, -1); // ambil 1 karakter terakhir dari bulan
            $tahun   = $now->format('y'); // 2 digit terakhir tahun (misal 25)

            // Hitung urutan (count) berdasarkan part_no dan bulan berjalan
            $count = DnInput::where('part_no', $request->part_no)
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->count() + 1;

            $countFormatted = str_pad($count, 3, '0', STR_PAD_LEFT); // selalu 3 digit (001, 002, dst.)

            // Format akhir: SPEC + DD + M + YY + COUNT
            $uniqNo = "{$prefix}{$tanggal}{$bulanChar}{$tahun}{$countFormatted}";

            // --- 🔸 Pastikan uniq_no tidak duplikat ---
            while (DnInput::where('uniq_no', $uniqNo)->exists()) {
                $count++;
                $countFormatted = str_pad($count, 3, '0', STR_PAD_LEFT);
                $uniqNo = "{$prefix}{$tanggal}{$bulanChar}{$tahun}{$countFormatted}";
            }

            $data->uniq_no = $uniqNo;
        }

        // === 3️⃣ UPDATE FIELD ===
        $data->doc_dn     = $request->doc_dn;
        $data->doc_po     = $request->doc_po;
        $data->part_no    = $request->part_no;
        $data->actual     = $request->actual;
        $data->kg_sheet   = $request->kg_sheet;
        $data->spec       = $request->spec;
        $data->spec_t     = $request->spec_t;
        $data->spec_w     = $request->spec_w;
        $data->spec_l     = $request->spec_l;
        $data->supplier   = $request->supplier;
        $data->delivery   = $request->delivery;
        $data->no_rak     = $request->no_rak;
        $data->model      = $request->model;
        $data->detail_id  = $request->detail_id;
        $data->sts_scan   = $request->sts_scan;
        $data->createdby  = auth()->user()->username ?? 'system';
        $data->update_time = now();

        // === 4️⃣ SAVE DATA ===
        $data->save();

        // === 5️⃣ RESPONSE ===
        return response()->json([
            'success' => true,
            'id' => $data->id,
            'uniq_no' => $data->uniq_no,
            'update_time' => $data->update_time->format('Y-m-d H:i:s'),
            'message' => 'Data successfully saved.'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

public function getDashboardData()
{
    // Ambil bulan dan tahun saat ini
    $month = now()->month; // Bulan saat ini
    $year = now()->year;   // Tahun saat ini

    // Menghitung total PO (totalItems) berdasarkan bulan dan tahun saat ini
    $totalItems = DB::table('rm_dn_incomings')
        ->whereYear('created_at', $year)  // Filter berdasarkan tahun
        ->whereMonth('created_at', $month) // Filter berdasarkan bulan
        ->count();

    // Menghitung PO dengan status null atau kosong (nullStatusCount) berdasarkan bulan dan tahun saat ini
    $nullStatusCount = DB::table('rm_dn_incomings')
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->whereNull('status')
        ->orWhere('status', '')
        ->count();

    // Menghitung PO dengan status CLOSE (poCloseDifference) berdasarkan bulan dan tahun saat ini
    $poCloseDifference = $totalItems - $nullStatusCount;

    return response()->json([
        'totalItems' => $totalItems,
        'poCloseDifference' => $poCloseDifference,
        'nullStatusCount' => $nullStatusCount,
    ]);
}

    public function destroyline(Request $request)
    {
        $query = DnInput::where('id', $request->id)->delete();
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


    public function getChartData(Request $request)
    {
        $month = now()->format('m'); // Ambil bulan saat ini
        $year = now()->format('Y');  // Ambil tahun saat ini

        $data = DB::table('scan_in_labels')
            ->select(
                DB::raw('DAY(created_at) as day'),
                DB::raw('SUM(qty_in) as total_qty'),
                DB::raw('SUM(qty_kg) as total_kg') // Menambahkan kolom qty_kg
            )
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return response()->json($data);
    }


public function getScanData(Request $request)
{
    $date = $request->input('date');

    // Ambil data dari tabel scan_in_labels berdasarkan created_at
    $data = DB::table('scan_in_labels')
              ->whereDate('created_at', $date)
              ->select('part_no','created_at','supplier','uniqNo','spec','qty_in','createdby','qty_kg')
              ->orderBy('created_at', 'asc')
              ->get();

    return response()->json($data);
}


}



