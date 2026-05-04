<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TraceAbility; 
use App\Models\TrackingProses;
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use App\Models\RmInMaterial;
use App\Models\DataModel;
use DB;

class TrackingProsesController extends Controller
{
    // Method untuk menampilkan halaman utama tracking
    public function index()
    {
        $title = 'Tracking Proses';
        $abilities = TraceAbility::all(); // Ambil semua data dari trace_abilities

        return view('tracking.tracking', compact('title','abilities'));
    }

    public function getUpdatedAbilities()
    {
        $abilities = TraceAbility::all(); // Atau query sesuai kebutuhan
        return response()->json($abilities);
    }

}




