<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;
use App\Models\RmMonthly;
use App\Models\RmMaterial;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RmMonthlyImport; // Pastikan namespace ini benar
use DataTables;
use DB;

class RmUploadMonthlyController extends Controller
{
    public function index(){
        $title = 'DN';
        $rm_monthlies = RmMonthly::all();
        return view('rmmaterial.monthlyupload', compact('title','rm_monthlies'));
    } 

    public function list()
    {
        $query = DB::table('rm_monthlies as a')
                ->select('a.month','a.year', DB::raw('CONCAT(a.month, a.year) as id'))
                ->groupBy('a.month')
                ->groupBy('a.year')
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    { 
        $query = DB::table('rm_monthlies as a')
                ->select('a.id','a.po_no', 'a.part_no', 'a.month','a.year', 'a.kanban', 'a.spec','a.spec_t','a.spec_w', 'a.spec_l', 'a.po_sheet', 'a.po_kg','a.tgl_1','a.tgl_2')
                ->where('a.month', $request->month)
                // ->where('a.year', $request->year)
                ->get();
    
        return DataTables::of($query)->make();
    }
    

    public function importMonthly(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        // Import data menggunakan class RmMonthlyImport
        Excel::import(new RmMonthlyImport, $request->file('file'));

        return back()->with('success', 'Data DN berhasil diimport!');
    }

    
    
}

