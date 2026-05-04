<?php



namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\UploadRekapOrderAdmP4;
use App\Models\RmMaterial;
use App\Models\RmMonthly;
use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\RmDnIncomingImport; // Pastikan namespace ini benar
use App\Exports\PoExport;
use DataTables;
use DB;
use Illuminate\Support\Facades\Log;
use App\Imports\UploadOrderAdmP4Import; // Pastikan namespace ini benar


class UploadRekapAdmP4Controller extends Controller
{
    public function index(){
        $title = 'Rekap Order PLANT 4';
        return view('ppic.uploadrekapadmp4', compact('title'));

    }

    public function list(Request $request)
    {
        $query = DB::table('upload_rekap_order_adm_p4_s as a')
                ->select(
                    'a.del_date',
                    DB::raw('CONCAT(a.del_date) as id'),
                    DB::raw("GROUP_CONCAT(DISTINCT a.created_at ORDER BY a.created_at DESC SEPARATOR '|') as upload_batches")
                );

        // Group by del_date as requested ("kolom arrival diambil dari del_date")
        $query = $query->groupBy('a.del_date');

        return DataTables::of($query)
            ->addColumn('arrival1', function($row) {
                // Since we group by del_date, arrival is the del_date itself
                return $row->del_date ?? '-';
            })
            ->addColumn('arrival2', function($row) {
                // We can show the most recent upload batch date here for info
                if (!$row->upload_batches) return '-';
                $batches = explode('|', $row->upload_batches);
                return $batches[0] ?? '-';
            })
            ->make(true);
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('upload_rekap_order_adm_p4_s as a')
                ->select(
                    'a.id',
                    'a.del_date',
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
                    DB::raw("CASE WHEN TRIM(a.cycle) = '9' OR a.cycle = 9 THEN a.qty_order ELSE 0 END as cycle9"),
                    DB::raw("CASE WHEN TRIM(a.cycle) = '10' OR a.cycle = 10 THEN a.qty_order ELSE 0 END as cycle10")
                )
                ->where('a.del_date', $request->created_at); // identifying by del_date now

        // removed del_date filter from listdetail to show ALL data for the upload batch
        return DataTables::of($query)->make(true);
    }

    public function resetCycle(Request $request)
    {
        try {
            $affected = DB::table('upload_rekap_order_adm_p4_s')
                ->where('del_date', $request->created_at) // ID is del_date now
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
        $query = UploadRekapOrderAdmP4::where('id', $request->id)->delete();
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
        $query = UploadRekapOrderAdmP4::where('del_date', $request->created_at)->delete();
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

    public function importRekapadmp4(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            $file = $request->file('file');

            // langsung import, ga perlu $path
            Excel::import(new UploadOrderAdmP4Import, $file);

            return back()->with('success', 'Data DN berhasil diimport!');
        } catch (\Exception $e) {
            \Log::error('Import DN Gagal: ' . $e->getMessage());

            // tampilkan pesan asli (misalnya: "No DN 12345 bukan K1 atau K2, cek lagi!")
            return back()->with('error', $e->getMessage());
        }
    }



    public function exportPdf(Request $request)
    {
        $del_date = $request->created_at; // It passes as created_at from JS
        if (!$del_date) {
            return redirect()->back()->with('error', 'Tanggal tidak ditemukan.');
        }

        $data = DB::table('upload_rekap_order_adm_p4_s as a')
            ->select(
                'a.doc_dn',
                'a.part_name',
                'a.part_no',
                'a.job_no',
                'a.qty_order',
                'a.qty_kanban',
                'a.createdby',
                'a.type_pallet',
                'a.cycle',
                'a.created_at',
                'a.del_date'
            )
            ->where('a.del_date', $del_date)
            ->orderBy('a.doc_dn')
            ->orderBy('a.part_no')
            ->get();

        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $pdf = Pdf::loadView('ppic.pdf_rekap_admp4', compact('data', 'del_date'))
                  ->setPaper('a4', 'landscape');

        $filename = 'Rekap_Order_Plant4_' . str_replace([':', ' '], ['-', '_'], $del_date) . '.pdf';

        if ($request->download == 1) {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    public function getSummary(Request $request)
    {
        $del_date = $request->created_at;

        if (!$del_date) {
            return response()->json([
                'success' => false,
                'msg' => 'Invalid date'
            ]);
        }

        $summary = DB::table('upload_rekap_order_adm_p4_s')
            ->where('del_date', $del_date)
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
        $cycleArrivalDate = $request->cycle_arrival_date ?: date('Y-m-d');

        $query = DB::table('upload_rekap_order_adm_p4_s');

        // Always filter by del_date, matching the provided or default (today) date
        $query->whereDate('del_date', $cycleArrivalDate);

        // Calculate counts based on this specific filter
        $totalCount = (clone $query)->count();

        // Calculate approved (qty_order = 0 AND createdby IS NOT NULL)
        $approvedCount = (clone $query)
            ->where('qty_order', 0)
            ->whereNotNull('createdby')
            ->where('createdby', '!=', '')
            ->count();

        // Calculate not scanned (qty_order = 0 AND (createdby IS NULL OR createdby = ''))
        $notScannedCount = (clone $query)
            ->where('qty_order', 0)
            ->where(function($q) {
                $q->whereNull('createdby')
                  ->orWhere('createdby', '');
            })
            ->count();

        // Calculate estimated/pending (Total - (Approved + Not Scanned))
        $pendingCount = $totalCount - ($approvedCount + $notScannedCount);

        // Format for Progress Chart (Progress vs Remaining)
        $completedCount = $approvedCount + $notScannedCount;
        $completionPercentage = $totalCount > 0 ? round(($completedCount / $totalCount) * 100, 1) : 0;

        // If everything is done, make it 100%
        if ($pendingCount == 0 && $totalCount > 0) {
            $completionPercentage = 100;
        }

        // Team Workload Counts (Filtered by del_date)
        $team = ['Iswadi', 'Asep', 'Abi', 'Fikri'];
        $teamCounts = [];
        foreach ($team as $member) {
            $mQuery = (clone $query)->where('createdby', 'like', $member . '%');
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
