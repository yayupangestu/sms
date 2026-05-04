<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScanOutStmp;
use Carbon\Carbon;

class Dashboard1LsController extends Controller
{
    public function index()
    {
        $title = 'Dashboard LS';
        return view('linestore.dashboard1', compact('title'));
    }

    // public function getScanOutData()
    // {
    //     // Ambil data dari scan_out_stmps yang belum masuk (scan_in_ls masih null)
    //     $data = ScanOutStmp::whereNull('scan_in_ls')
    //         ->where('status', '!=', 4) // ⬅️ Filter: jangan tampilkan status = 4
    //         ->orderBy('created_at', 'desc')
    //         ->get([
    //             'part_no2',
    //             'job_no',
    //             'line_proses',
    //             'created_at',
    //             'date_scan',
    //             'date_plan',
    //             'status'
    //         ]);

    //     return response()->json($data);
    // }


     public function getScanOutData()
    {
        // Ambil data dari scan_out_stmps yang belum masuk (scan_in_ls masih null)
        $data = ScanOutStmp::whereIn('status', [1, 3])
        ->where(function($query){
            $query->whereNull('status_ls')
                  ->orWhere('status_ls', '=!',1);

        })
        ->orderBy('created_at', 'desc')
            ->get([
                'part_no2',
                'job_no',
                'line_proses',
                'created_at',
                'date_scan',
                'date_plan',
                'status'
            ]);

        return response()->json($data);
    }

}
