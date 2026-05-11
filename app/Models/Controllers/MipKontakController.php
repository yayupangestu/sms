<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MipKontakController extends Controller
{
    public function index()
    {
        $title = 'kontak';
        return view('mip.kontak', compact('title'));
    }
}