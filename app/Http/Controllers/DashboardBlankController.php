<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardBlankController extends Controller
{
    public function index(){
        $title = 'Dashbaord Blank';

        return view('blank.dashboard', compact('title'));
    }
}
