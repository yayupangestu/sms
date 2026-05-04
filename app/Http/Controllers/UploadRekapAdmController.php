<?php


namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\UploadRekapOrderAdm;
use App\Models\RmMaterial;
use App\Models\RmMonthly;
use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\RmDnIncomingImport; // Pastikan namespace ini benar
use App\Exports\PoExport;
use DataTables;
use DB;
use Illuminate\Support\Facades\Log;
use App\Imports\UploadOrderAdmImport; // Pastikan namespace ini benar


class UploadRekapAdmController extends Controller
{
    public function index(){
        $title = 'Rekap Order';
        return view('ppic.uploadrekapadm', compact('title'));

    }

    public function list(Request $request)
    {
        $query = DB::table('upload_rekap_order_adms as a')
                ->select(
                    'a.created_at',
                    DB::raw('CONCAT(a.created_at) as id'),
                    DB::raw("GROUP_CONCAT(DISTINCT CASE WHEN a.cycle_arrival IS NOT NULL THEN a.cycle_arrival ELSE NULL END ORDER BY a.cycle_arrival ASC SEPARATOR '|') as arrivals")
                );

        if ($request->has('cycle_arrival_date') && !empty($request->cycle_arrival_date)) {
            $query->whereDate('a.cycle_arrival', $request->cycle_arrival_date);
        }

        $query = $query->groupBy('a.created_at')->get();

        return DataTables::of($query)
            ->addColumn('arrival1', function($row) {
                if (!$row->arrivals) return '-';
                $arrivals = array_filter(explode('|', $row->arrivals));
                $arrivals = array_values($arrivals);
                return $arrivals[0] ?? '-';
            })
            ->addColumn('arrival2', function($row) {
                if (!$row->arrivals) return '-';
                $arrivals = array_filter(explode('|', $row->arrivals));
                $arrivals = array_values($arrivals);
                return $arrivals[1] ?? '-';
            })
            ->make(true);
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('upload_rekap_order_adms as a')
                ->select(
                    'a.id',
                    'a.part_no',
                    'a.job_no',
                    'a.part_name',
                    'a.cycle',
                    'a.doc_dn',
                    'a.qty_order',
                    'a.qty_kanban',
                    'a.createdby',
                    'a.type_pallet',
                    DB::raw("CASE WHEN TRIM(a.cycle) = '1' OR a.cycle = 1 THEN a.qty_order ELSE 0 END as cycle1"),
                    DB::raw("CASE WHEN TRIM(a.cycle) = '2' OR a.cycle = 2 THEN a.qty_order ELSE 0 END as cycle2"),
                    DB::raw("CASE WHEN TRIM(a.cycle) = '3' OR a.cycle = 3 THEN a.qty_order ELSE 0 END as cycle3"),
                    DB::raw("CASE WHEN TRIM(a.cycle) = '4' OR a.cycle = 4 THEN a.qty_order ELSE 0 END as cycle4"),
                    DB::raw("CASE WHEN TRIM(a.cycle) = '5' OR a.cycle = 5 THEN a.qty_order ELSE 0 END as cycle5"),
                    DB::raw("CASE WHEN TRIM(a.cycle) = '6' OR a.cycle = 6 THEN a.qty_order ELSE 0 END as cycle6"),
                    DB::raw("CASE WHEN TRIM(a.cycle) = '7' OR a.cycle = 7 THEN a.qty_order ELSE 0 END as cycle7"),
                    DB::raw("CASE WHEN TRIM(a.cycle) = '8' OR a.cycle = 8 THEN a.qty_order ELSE 0 END as cycle8"),
                    DB::raw("CASE WHEN TRIM(a.cycle) = '9' OR a.cycle = 9 THEN a.qty_order ELSE 0 END as cycle9")
                )
                ->where('a.created_at', $request->created_at)
                ->get();

        return DataTables::of($query)->make();
    }

    public function resetCycle(Request $request)
    {
        try {
            // Update qty_order to 0 based on filtered cycle and created_at
            $affected = DB::table('upload_rekap_order_adms')
                ->where('created_at', $request->created_at)
                ->where(function($query) use ($request) {
                    $query->where('cycle', $request->cycle)
                          ->orWhere(DB::raw('TRIM(cycle)'), $request->cycle)
                          ->orWhere('cycle', (int)$request->cycle);
                })
                ->update(['qty_order' => 0]);

            return response()->json([
                'success' => true,
                'msg' => "Successfully reset {$affected} records for Cycle {$request->cycle}."
            ]);

        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'msg' => 'Error resetting data: ' . $e->getMessage()
            ]);
        }
    }

    public function destroyline(Request $request)
    {
        $query = UploadRekapOrderAdm::where('created_at', $request->created_at)->delete();
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
        $query = UploadRekapOrderAdm::where('created_at', $request->created_at)->delete();
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

    public function importRekapadm(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $file = $request->file('file');

            // langsung import, ga perlu $path
            Excel::import(new UploadOrderAdmImport, $file);

            return back()->with('success', 'Data DN berhasil diimport!');
        } catch (\Exception $e) {
            \Log::error('Import DN Gagal: ' . $e->getMessage());

            // tampilkan pesan asli (misalnya: "No DN 12345 bukan K1 atau K2, cek lagi!")
            return back()->with('error', $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        $created_at = $request->created_at;

        if (!$created_at) {
            return back()->with('error', 'Tanggal DN tidak ditemukan.');
        }

        $data = DB::table('upload_rekap_order_adms as a')
            ->select(
                'a.part_no',
                'a.job_no',
                'a.part_name',
                'a.cycle',
                'a.doc_dn',
                'a.cycle_arrival',
                'a.qty_order',
                'a.qty_kanban',
                'a.createdby',
                'a.type_pallet',
                DB::raw("CASE WHEN TRIM(a.cycle) = '1' OR a.cycle = 1 THEN a.qty_order ELSE 0 END as cycle1"),
                DB::raw("CASE WHEN TRIM(a.cycle) = '2' OR a.cycle = 2 THEN a.qty_order ELSE 0 END as cycle2"),
                DB::raw("CASE WHEN TRIM(a.cycle) = '3' OR a.cycle = 3 THEN a.qty_order ELSE 0 END as cycle3"),
                DB::raw("CASE WHEN TRIM(a.cycle) = '4' OR a.cycle = 4 THEN a.qty_order ELSE 0 END as cycle4"),
                DB::raw("CASE WHEN TRIM(a.cycle) = '5' OR a.cycle = 5 THEN a.qty_order ELSE 0 END as cycle5"),
                DB::raw("CASE WHEN TRIM(a.cycle) = '6' OR a.cycle = 6 THEN a.qty_order ELSE 0 END as cycle6"),
                DB::raw("CASE WHEN TRIM(a.cycle) = '7' OR a.cycle = 7 THEN a.qty_order ELSE 0 END as cycle7"),
                DB::raw("CASE WHEN TRIM(a.cycle) = '8' OR a.cycle = 8 THEN a.qty_order ELSE 0 END as cycle8"),
                DB::raw("CASE WHEN TRIM(a.cycle) = '9' OR a.cycle = 9 THEN a.qty_order ELSE 0 END as cycle9")
            )
            ->where('a.created_at', $created_at)
            ->get();

        if ($data->isEmpty()) {
            return back()->with('error', 'Data tidak ditemukan untuk tanggal tersebut.');
        }

        $pdf = Pdf::loadView('ppic.pdf_rekap_adm', compact('data', 'created_at'))
            ->setPaper('a4', 'landscape');

        $filename = 'Rekap_Order_ADM_' . str_replace([':', ' '], '_', $created_at) . '.pdf';

        if ($request->has('download')) {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    public function getSummary(Request $request)
    {
        $created_at = $request->created_at;

        if (!$created_at) {
            return response()->json([
                'success' => false,
                'msg' => 'Invalid timestamp'
            ]);
        }

        $summary = DB::table('upload_rekap_order_adms')
            ->where('created_at', $created_at)
            ->select(
                DB::raw('COUNT(*) as total_data'),
                DB::raw('SUM(CASE WHEN qty_order = 0 THEN 1 ELSE 0 END) as zero_qty_count')
            )
            ->first();

        return response()->json([
            'success' => true,
            'total_data' => $summary->total_data ?? 0,
            'zero_qty_count' => $summary->zero_qty_count ?? 0
        ]);
    }

    public function getChartData(Request $request) {
        $cycleArrivalDate = $request->cycle_arrival_date;

        $query = DB::table('upload_rekap_order_adms');

        if ($cycleArrivalDate && !empty($cycleArrivalDate)) {
            $query->whereDate('cycle_arrival', $cycleArrivalDate);
        }

        // Get count per cycle (1-9)
        $data = $query->select('cycle', DB::raw('count(*) as count'))
            ->whereIn('cycle', [1, 2, 3, 4, 5, 6, 7, 8, 9])
            ->groupBy('cycle')
            ->orderBy('cycle')
            ->get();

        // Calculate total works (total items) based on filter
        $totalWorks = DB::table('upload_rekap_order_adms');
        if ($cycleArrivalDate && !empty($cycleArrivalDate)) {
            $totalWorks->whereDate('cycle_arrival', $cycleArrivalDate);
        }
        $totalCount = $totalWorks->count();

        // Calculate approved (qty_order = 0 AND createdby IS NOT NULL)
        $approvedWorks = DB::table('upload_rekap_order_adms')
            ->where('qty_order', 0)
            ->whereNotNull('createdby')
            ->where('createdby', '!=', '');
        if ($cycleArrivalDate && !empty($cycleArrivalDate)) {
            $approvedWorks->whereDate('cycle_arrival', $cycleArrivalDate);
        }
        $approvedCount = $approvedWorks->count();

        // Calculate not scanned (qty_order = 0 AND createdby IS NULL)
        $notScannedWorks = DB::table('upload_rekap_order_adms')
            ->where('qty_order', 0)
            ->where(function($q) {
                $q->whereNull('createdby')
                  ->orWhere('createdby', '');
            });
        if ($cycleArrivalDate && !empty($cycleArrivalDate)) {
            $notScannedWorks->whereDate('cycle_arrival', $cycleArrivalDate);
        }
        $notScannedCount = $notScannedWorks->count();

        // Calculate estimated/pending (Total - (Approved + Not Scanned))
        $pendingCount = $totalCount - ($approvedCount + $notScannedCount);


        // Format for Progress Chart (Progress vs Remaining)
        $completedCount = $approvedCount + $notScannedCount;
        $completionPercentage = $totalCount > 0 ? round(($completedCount / $totalCount) * 100, 1) : 0;

        // If Estimated Kanban is 0, make it 100%
        if ($pendingCount == 0 && $totalCount > 0) {
            $completionPercentage = 100;
        }

        // Team Workload Counts (Filtered by cycle_arrival)
        $team = ['Slamet', 'Priono', 'Eman', 'Hilman123'];
        $teamCounts = [];
        foreach ($team as $member) {
            $mQuery = DB::table('upload_rekap_order_adms')
                ->where('createdby', 'like', $member . '%');
            if ($cycleArrivalDate && !empty($cycleArrivalDate)) {
                $mQuery->whereDate('cycle_arrival', $cycleArrivalDate);
            }
            $teamCounts[$member] = $mQuery->count();
        }

        return response()->json([
            'success' => true,
            'labels' => ['Completed', 'Remaining'],
            'data' => [$completedCount, $pendingCount],
            'colors' => ['#10b981', '#e2e8f0'], // Green for completed, Gray for remaining
            'percentage' => $completionPercentage,
            'total_works' => $totalCount,
            'approved_works' => $approvedCount,
            'pending_works' => $pendingCount,
            'not_scanned_count' => $notScannedCount,
            'team_counts' => $teamCounts
        ]);
    }
}
