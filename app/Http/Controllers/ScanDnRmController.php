<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanDnRmController extends Controller
{
    public function index(){
        $title = 'Scan1';
        return view('scanner2.scandnrm', compact('title'));
    }
}
