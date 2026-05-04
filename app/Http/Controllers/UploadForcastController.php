<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // ini penting
use App\Exports\FormatUploadForcast;
use App\Exports\FormatUploadForcast2;
use App\Imports\ForcastImport;
use App\Imports\ForcastImport2;
use App\Models\UploadForcast;
use DataTables;
use DB;

class UploadForcastController extends Controller
{
    public function index()
    {
        $title = 'Upload Forcast';
        return view('ppic.uploadforcast', compact('title'));
    }

    public function list()
    {
        $query = DB::table('upload_forcasts as a')->select('a.tahun', DB::raw('CONCAT(a.tahun)as mix_id'))->groupBy('a.tahun')->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $tahun = $request->tahun;
    
        // 1️⃣ Ambil seluruh data untuk DataTables
        $query = DB::table('upload_forcasts')
            ->where('tahun', $tahun)
            ->get();
    
        // 🔥 Helper untuk menghitung total per customer
        $sumCustomer = function($customer) use ($tahun) {
            return DB::table('upload_forcasts')
                ->where('tahun', $tahun)
                ->where('customer', $customer)
                ->selectRaw("
                    SUM(
                        COALESCE(jan,0)+COALESCE(feb,0)+COALESCE(mar,0)+
                        COALESCE(apr,0)+COALESCE(may,0)+COALESCE(jun,0)+
                        COALESCE(jul,0)+COALESCE(aug,0)+COALESCE(sep,0)+
                        COALESCE(oct,0)+COALESCE(nov,0)+COALESCE(`dec`,0)
                    ) AS total_sum
                ")
                ->value('total_sum');
        };
    
        return response()->json([
            "data" => DataTables::of($query)->make(true)->getData(),
            "sum_adm1"          => $sumCustomer('ADM PLANT 1'),
            "sum_adm4"          => $sumCustomer('ADM PLANT 4'),
            "sum_adm5"          => $sumCustomer('ADM PLANT 5'),
            "sum_tmmin"         => $sumCustomer('TMMIN'),
            "sum_gayamotor"     => $sumCustomer('GAYA MOTOR'),
            "sum_fti"           => $sumCustomer('FTI'),
            "sum_hmmi"          => $sumCustomer('HMMI'),
            "sum_hpm"           => $sumCustomer('HPM'),
            "sum_ippi"          => $sumCustomer('IPPI'),
            "sum_maj"           => $sumCustomer('MAJ'),
            "sum_mes"           => $sumCustomer('MES'),
            "sum_mkm"           => $sumCustomer('MKM'),
            "sum_pindad"        => $sumCustomer('PINDAD'),
        ]);
    }
    
    
    public function importFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);
    
        Excel::import(new DataImport, $request->file('file'));
    
        return response()->json([
            'message' => 'Import file berhasil!'
        ]);
    }
    
    

    public function export2()
    {
        return Excel::download(new FormatUploadForcast(), 'Format Upload Forcast.xlsx');
    }

    public function export3()
    {
        return Excel::download(new FormatUploadForcast2(), 'Format Upload Forcast.xlsx');
    }

    public function importDp(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        // Import data menggunakan class DataPartNameImport
        Excel::import(new ForcastImport(), $request->file('file')->store('temp'));

        return back()->with('success', 'Data berhasil diimport!');
    }

    public function importforcast2(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx',
        ]);

        // Import data menggunakan class DataPartNameImport
        Excel::import(new ForcastImport2(), $request->file('file')->store('temp'));

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diimport!'
        ]);
        
    }
}
