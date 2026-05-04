<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RbtTmmin;
use Illuminate\Support\Facades\DB;

class DashboardWelding1Controller extends Controller
{
    // halaman utama dashboard
    public function index()
    {
        $title = 'Dashboard Welding';
    
        // Ambil semua data dari DB, termasuk kolom sts
        $robotsData = RbtTmmin::select('job_no', 'qty_proses', 'sts', 'part_no')->get();
    
        return view('welding.dashboard1', compact('title', 'robotsData'));
    }

    // endpoint untuk AJAX / auto-refresh
    public function getData()
    {
        // ambil data terbaru dari tabel rbt_tmmins
        $data = DB::table('rbt_tmmins')
            ->select('job_no', 'qty_proses', 'sts')
            ->get();

        return response()->json($data);
    }
}
