<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Scan4Controller extends Controller
{
    public function index(){
        $title = 'Scan Kedatangan';
        return view('scanner.scan4', compact('title'));
    }
    
}
