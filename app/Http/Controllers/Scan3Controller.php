<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Scan3Controller extends Controller
{
    public function index(){
        $title = 'Scan Out';
        return view('scanner.scan3', compact('title'));
    }
}
