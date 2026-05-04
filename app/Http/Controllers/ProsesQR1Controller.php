<?php

namespace App\Http\Controllers;
// use App\Exports\ReportB3Export;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LineStmp;
use App\Models\TabelB3;
use App\Models\DataPartName;
use App\Models\PlanningLineB3;
use App\Models\DataModel;
use App\Models\RmMaterial;
use Illuminate\Http\Request;
use DataTables;
use Alert;
use PDF;
use DB;

class ProsesQR1Controller extends Controller
{
    public function index(){
        $title = 'Scan1';
        return view('stepproses.prosesqr1', compact('title'));
    }


  public function getTraceByUniqNo($uniqNo)
{
    // Ganti ini dengan query yang sesuai untuk mengambil data dari database
    $trace = TraceAbility::where('uniqNo', $uniqNo)->first();

    if ($trace) {
        return response()->json([
            'material_name' => $trace->material_name,
            'qty_out' => $trace->qty_out,
            'uniqNo' => $trace->uniqNo
        ]);
    }

    return response()->json(['error' => 'Data not found'], 404);
}

    
}
