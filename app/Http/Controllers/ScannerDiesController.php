<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiesTransaction;

class ScannerDiesController extends Controller
{
    public function index()
    {
        $title = 'SCAN Dies';
        return view('diemtc.scannerdies', compact('title'));
    }

    public function store(Request $request)
    {
        DiesTransaction::create([
            'dies_qr' => $request->dies_qr,
            'transaction_type' => $request->transaction_type,
            'destination_address' => $request->destination_address,
            'destination_lat' => $request->destination_lat,
            'destination_lng' => $request->destination_lng,
            'status' => $request->transaction_type == "SCAN_OUT" ? "OUT" : "ACC"
        ]);

        return response()->json(['success' => true]);
    }

}
