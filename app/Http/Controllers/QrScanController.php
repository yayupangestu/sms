<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QrScan;

class QrScanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'scanned_data' => 'required|string',
        ]);

        QrScan::create([
            'scanned_data' => $request->scanned_data,
        ]);

        return response()->json(['success' => true]);
    }
}
