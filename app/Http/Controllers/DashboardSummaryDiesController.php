<?php

namespace App\Http\Controllers;

use App\Models\LkhDiesMtc;
use Illuminate\Http\Request;

class DashboardSummaryDiesController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Summary DIE MTC';
        $currentMonthYear = date('Y-m');
        $currentDate = date('Y-m-d');

        return view('diemtc.index2', compact('title', 'currentMonthYear', 'currentDate'));
    }

    public function data(Request $request)
    {
        $type = $request->type; // repair, downtime, pm, table
        $date = $request->date ?: date('Y-m-d');

        if ($type == 'table') {
            // Filter by specific day
            $tableData = LkhDiesMtc::whereDate('date_plan', $date)
                ->orderBy('id', 'desc')
                ->get(['date_plan', 'category', 'id', 'part_no', 'line_id', 'problem', 'dt_total']);
            return response()->json($tableData);
        }

        // Monthly logic for charts
        $year = date('Y', strtotime($date));
        $month = date('m', strtotime($date));

        $query = LkhDiesMtc::whereYear('date_plan', $year)
                           ->whereMonth('date_plan', $month);

        if ($type == 'repair') {
            $dataRaw = (clone $query)->selectRaw('DAY(date_plan) as day, SUM(dt_total) as total')
                ->where('category', 'CORRECTIVE')
                ->where('line_id', 'AREA')
                ->groupBy('day')
                ->pluck('total', 'day');
        } elseif ($type == 'downtime') {
            $dataRaw = (clone $query)->selectRaw('DAY(date_plan) as day, SUM(dt_total) as total')
                ->where('category', 'CORRECTIVE')
                ->where('line_id', '!=', 'AREA')
                ->groupBy('day')
                ->pluck('total', 'day');
        } elseif ($type == 'pm') {
            $dataRaw = (clone $query)->selectRaw('DAY(date_plan) as day, COUNT(*) as total')
                ->where('category', 'PREVENTIVE')
                ->groupBy('day')
                ->pluck('total', 'day');
        } else {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        $formattedData = [];
        for ($i = 1; $i <= 31; $i++) {
            $formattedData[] = $dataRaw[$i] ?? 0;
        }

        return response()->json($formattedData);
    }
}
