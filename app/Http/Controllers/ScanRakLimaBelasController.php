<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ScanOutNut;
use DB;

class ScanRakLimaBelasController extends Controller
{
    public function index(){
        $title = 'Scan Rak 1';
        return view('scanner2.scanrak15', compact('title'));
    }

    public function storeScanOutNut(Request $request)
{
    $request->validate([
        'qr_code' => 'required|string|max:255',
    ]);

    DB::table('scan_out_nut')->insert([
        'qr_code' => $request->qr_code,
        'scanned_at' => now()
    ]);

    return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan']);
}

    public function activateRelay()
    {
        try {
            $response = Http::withoutVerifying()->get('http://20.20.17.176/relay1/on');

            if ($response->successful()) {
                return response()->json(['message' => 'Relay activated successfully!']);
            } else {
                return response()->json(['message' => 'Failed to activate relay'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
     }
    }

    public function deactivateRelay()
    {
        try {
            $response = Http::withoutVerifying()->get('http://20.20.17.176/relay1/off');

            if ($response->successful()) {
                return response()->json(['message' => 'Relay activated successfully!']);
            } else {
                return response()->json(['message' => 'Failed to activate relay 2'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
     }
    }

    public function deactivateRelayDua()
    {
        try {
            $response = Http::withoutVerifying()->get('http://20.20.17.176/relay2/off');

            if ($response->successful()) {
                return response()->json(['message' => 'Relay activated successfully!']);
            } else {
                return response()->json(['message' => 'Failed to activate relay 2'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
     }
    }

    public function activateRelayDua()
    {
        try {
            $response = Http::withoutVerifying()->get('http://20.20.17.176/relay2/on');

            if ($response->successful()) {
                return response()->json(['message' => 'Relay 2 activated successfully!']);
            } else {
                return response()->json(['message' => 'Failed to activate Relay 2'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function deactivateRelayTiga()
    {
        try {
            $response = Http::withoutVerifying()->get('http://20.20.17.176/relay3/off');

            if ($response->successful()) {
                return response()->json(['message' => 'Relay 3 activated successfully!']);
            } else {
                return response()->json(['message' => 'Failed 3 to activate relay'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
     }
    }

    public function activateRelayTiga()
    {
        try {
            $response = Http::withoutVerifying()->get('http://20.20.17.176/relay3/on');

            if ($response->successful()) {
                return response()->json(['message' => 'Relay 3 activated successfully!']);
            } else {
                return response()->json(['message' => 'Failed to activate Relay 3'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function deactivateRelayEmpat()
    {
        try {
            $response = Http::withoutVerifying()->get('http://20.20.17.176/relay4/off');

            if ($response->successful()) {
                return response()->json(['message' => 'Relay 3 activated successfully!']);
            } else {
                return response()->json(['message' => 'Failed to activate relay 3'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
     }
    }

    public function activateRelayEmpat()
    {
        try {
            $response = Http::withoutVerifying()->get('http://20.20.17.176/relay4/on');

            if ($response->successful()) {
                return response()->json(['message' => 'Relay 4 activated successfully!']);
            } else {
                return response()->json(['message' => 'Failed to activate Relay 2'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }


    public function deactivateRelayLima()
    {
        try {
            $response = Http::withoutVerifying()->get('http://20.20.17.176/relay5/off');

            if ($response->successful()) {
                return response()->json(['message' => 'Relay 5 activated successfully!']);
            } else {
                return response()->json(['message' => 'Failed 5 to activate relay'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
     }
    }

    public function activateRelayLima()
    {
        try {
            $response = Http::withoutVerifying()->get('http://20.20.17.176/relay5/on');

            if ($response->successful()) {
                return response()->json(['message' => 'Relay 6 activated successfully!']);
            } else {
                return response()->json(['message' => 'Failed to activate Relay '], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

}
