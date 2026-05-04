<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScanOutPcs;

class DashboardDuckingController extends Controller
{
    public function index(){
        $title = 'Dashboard Ducking';
        $scan_out_pcs = ScanOutPcs::all();
        return view('pcstore.dashboardducking',compact('title','scan_out_pcs'));
    }
}
