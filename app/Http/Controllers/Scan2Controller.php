<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Scan2Controller extends Controller
{
    public function index(){
        $title = 'Scan IN';
        return view('scanner.scan2', compact('title'));
    }
}
