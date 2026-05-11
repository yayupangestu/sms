<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardStoreRoomController extends Controller
{
   public function index()
   {
       $title = 'Dashbaord';
        return view('dashboard.store', compact('title'));
   }
}
