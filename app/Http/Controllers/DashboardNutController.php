<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardNutController extends Controller
{
    public function index () {
        $title = 'Dashboard Nut';

        return view('dashboard.dashboardnut', compact('title'));
    }
}
