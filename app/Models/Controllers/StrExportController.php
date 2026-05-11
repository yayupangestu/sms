<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ItemsOut3Export;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Exports\StrAllExport;
use App\Exports\StrWeldingExport;
use App\Exports\StrProd2Export;
use App\Models\StrBarang;
use App\Models\StrUom;
use App\Models\User;
use App\Models\StrOut2;
use App\Models\StrOut3;
use App\Models\StrOut4;
use App\Models\StrOut5;
use App\Models\StrOut6;
use App\Models\StrOut7;
use DataTables;


class StrExportController extends Controller
{
    public function index(){
        $title = 'Export data Excell';
        $str_out2s = StrOut2::all();
        $str_out3s = StrOut3::all();
        $str_out4s = StrOut4::all();
        $str_out5s = StrOut5::all();

        return view('store.exportexcel', compact('title','str_out2s'));
    }




    public function export(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(new StrAllExport($startDate, $endDate), 'Penggunaan Item LINE STAMPING.xlsx');
    }

    public function export2(Request $request)
    {
        $validated = $request->validate([
            'start_date2' => 'required|date',
            'end_date2' => 'required|date',
        ]);

        $startDate = $request->input('start_date2');
        $endDate = $request->input('end_date2');

        return Excel::download(new StrWeldingExport($startDate, $endDate), 'Penggunaan Item LINE WELDING.xlsx');
    }

      public function export3(Request $request)
    {
        $validated = $request->validate([
            'start_date3' => 'required|date',
            'end_date3' => 'required|date',
        ]);

        $startDate = $request->input('start_date3');
        $endDate = $request->input('end_date3');

        return Excel::download(new StrProd2Export($startDate, $endDate), 'Penggunaan Item LINE PRODUCTION 2.xlsx');
    }
}