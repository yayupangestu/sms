<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Scan1Controller extends Controller
{
    public function index(){
        $title = 'Scan1';
        return view('scanner.scan1', compact('title'));
    }
}
