<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StrOut3;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StrDashbaordInfoController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Info';
        $str_out3s = StrOut3::all();
    
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
    
        // Gabungkan semua tabel str_out* dan ambil total qty_request dengan category = 3 dan bulan ini
        $totalQtyConsum = DB::table('str_out2s')
            ->select('item_id', 'qty_request', 'date_plan')
            ->whereMonth('date_plan', $currentMonth)
            ->whereYear('date_plan', $currentYear)
            ->unionAll(
                DB::table('str_out3s')
                    ->select('item_id', 'qty_request', 'date_plan')
                    ->whereMonth('date_plan', $currentMonth)
                    ->whereYear('date_plan', $currentYear)
            )
            ->unionAll(
                DB::table('str_out4s')
                    ->select('item_id', 'qty_request', 'date_plan')
                    ->whereMonth('date_plan', $currentMonth)
                    ->whereYear('date_plan', $currentYear)
            )
            ->unionAll(
                DB::table('str_out5s')
                    ->select('item_id', 'qty_request', 'date_plan')
                    ->whereMonth('date_plan', $currentMonth)
                    ->whereYear('date_plan', $currentYear)
            )
            ->unionAll(
                DB::table('str_out6s')
                    ->select('item_id', 'qty_request', 'date_plan')
                    ->whereMonth('date_plan', $currentMonth)
                    ->whereYear('date_plan', $currentYear)
            )
            ->join('str_barangs', 'item_id', '=', 'str_barangs.id')
            ->where('str_barangs.category', 3)
            ->sum('qty_request');

        $totalQtyAtk = DB::table('str_out2s')
            ->select('item_id', 'qty_request', 'date_plan')
            ->whereMonth('date_plan', $currentMonth)
            ->whereYear('date_plan', $currentYear)
            ->unionAll(
                DB::table('str_out3s')
                    ->select('item_id', 'qty_request', 'date_plan')
                    ->whereMonth('date_plan', $currentMonth)
                    ->whereYear('date_plan', $currentYear)
            )
            ->unionAll(
                DB::table('str_out4s')
                    ->select('item_id', 'qty_request', 'date_plan')
                    ->whereMonth('date_plan', $currentMonth)
                    ->whereYear('date_plan', $currentYear)
            )
            ->unionAll(
                DB::table('str_out5s')
                    ->select('item_id', 'qty_request', 'date_plan')
                    ->whereMonth('date_plan', $currentMonth)
                    ->whereYear('date_plan', $currentYear)
            )
            ->unionAll(
                DB::table('str_out6s')
                    ->select('item_id', 'qty_request', 'date_plan')
                    ->whereMonth('date_plan', $currentMonth)
                    ->whereYear('date_plan', $currentYear)
            )
            ->join('str_barangs', 'item_id', '=', 'str_barangs.id')
            ->where('str_barangs.category', 1)
            ->sum('qty_request');

            
        
            return view('dashboard.info', compact('title', 'str_out3s', 'totalQtyConsum','totalQtyAtk'));
        }

    public function getDataByCategory(Request $request)
{
    $category = $request->input('category');
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    // Ambil data berdasarkan kategori yang dipilih
    $data = DB::table('str_out2s')
        ->select('item_id', 'qty_request', 'date_plan', 'line_id', 'price_item', 'createdby', 'str_barangs.category', 'str_barangs.name')
        ->whereMonth('date_plan', $currentMonth)
        ->whereYear('date_plan', $currentYear)
        ->join('str_barangs', 'str_out2s.item_id', '=', 'str_barangs.id')
        ->where('str_barangs.category', $category)
        ->unionAll(
            DB::table('str_out3s')
                ->select('item_id', 'qty_request', 'date_plan', 'line_id', 'price_item', 'createdby', 'str_barangs.category', 'str_barangs.name')
                ->whereMonth('date_plan', $currentMonth)
                ->whereYear('date_plan', $currentYear)
                ->join('str_barangs', 'str_out3s.item_id', '=', 'str_barangs.id')
                ->where('str_barangs.category', $category)
        )
        ->unionAll(
            DB::table('str_out4s')
                ->select('item_id', 'qty_request', 'date_plan', 'line_id', 'price_item', 'createdby','str_barangs.category', 'str_barangs.name')
                ->whereMonth('date_plan', $currentMonth)
                ->whereYear('date_plan', $currentYear)
                ->join('str_barangs', 'str_out4s.item_id', '=', 'str_barangs.id')
                ->where('str_barangs.category', $category)
        )
        ->unionAll(
            DB::table('str_out5s')
                ->select('item_id', 'qty_request', 'date_plan', 'line_id', 'price_item', 'createdby', 'str_barangs.category', 'str_barangs.name')
                ->whereMonth('date_plan', $currentMonth)
                ->whereYear('date_plan', $currentYear)
                ->join('str_barangs', 'str_out5s.item_id', '=', 'str_barangs.id')
                ->where('str_barangs.category', $category)
        )
        ->unionAll(
            DB::table('str_out6s')
                ->select('item_id', 'qty_request', 'date_plan', 'line_id', 'price_item', 'createdby', 'str_barangs.category', 'str_barangs.name')
                ->whereMonth('date_plan', $currentMonth)
                ->whereYear('date_plan', $currentYear)
                ->join('str_barangs', 'str_out6s.item_id', '=', 'str_barangs.id')
                ->where('str_barangs.category', $category)
        )
        ->get();

    return response()->json(['data' => $data]);
}
}
