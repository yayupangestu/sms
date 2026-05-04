<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class ScanRak15OutController extends Controller
{
    public function index() {
        $title = 'Scan Out';
        return view('scanner2.scanrak15out', compact('title'));
    }


public function activateRelayOut()
{
    try {
        $response = Http::withoutVerifying()->get('http://20.20.18.249/relay1/on');

        if ($response->successful()) {
            return response()->json(['message' => 'Relay activated successfully!']);
        } else {
            return response()->json(['message' => 'Failed to activate relay'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}

public function deactivateRelayOut()
{
    try {
        $response = Http::withoutVerifying()->get('http://20.20.18.249/relay1/off');

        if ($response->successful()) {
            return response()->json(['message' => 'Relay deactivated successfully!']);
        } else {
            return response()->json(['message' => 'Failed to deactivate relay'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}

public function activateRelayOut2()
{
    try {
        $response = Http::withoutVerifying()->get('http://20.20.18.249/relay1/on');

        if ($response->successful()) {
            return response()->json(['message' => 'Relay activated successfully!']);
        } else {
            return response()->json(['message' => 'Failed to activate relay'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}

public function deactivateRelayOut2()
{
    try {
        $response = Http::withoutVerifying()->get('http://20.20.18.249/relay1/off');

        if ($response->successful()) {
            return response()->json(['message' => 'Relay deactivated successfully!']);
        } else {
            return response()->json(['message' => 'Failed to deactivate relay'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}

public function activateRelayOut3()
{
    try {
        $response = Http::withoutVerifying()->get('http://20.20.18.249/relay1/on');

        if ($response->successful()) {
            return response()->json(['message' => 'Relay activated successfully!']);
        } else {
            return response()->json(['message' => 'Failed to activate relay'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}

public function deactivateRelayOut3()
{
    try {
        $response = Http::withoutVerifying()->get('http://20.20.18.249/relay1/off');

        if ($response->successful()) {
            return response()->json(['message' => 'Relay deactivated successfully!']);
        } else {
            return response()->json(['message' => 'Failed to deactivate relay'], 500);
        }
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}







}


