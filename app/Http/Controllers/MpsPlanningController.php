<?php

namespace App\Http\Controllers;
// use App\Exports\ReportB3Export;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MpsPlanning;
use App\Models\DataWelding;
use Illuminate\Http\Request;
use DataTables;
use DB;

class MpsPlanningController extends Controller
{
    public function index()
    {
        $title = 'Planning Line';
        $data_weldings = DataWelding::all();
        return view('planningline.mpsplanning', compact('title', 'data_weldings'));
    }

    public function list()
    {
        $query = DB::table('mps_plannings as a')
            ->select('a.date_plan', DB::raw('a.date_plan as mix_id'))
            ->groupBy('a.date_plan')
            ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('mps_plannings as a')
            ->select('a.id', 'a.part_name', 'a.qty_plan', 'a.model', 'a.job_no', 'a.part_no', 'a.line_id', 'a.date_plan', 'a.status')
            ->where('a.date_plan', $request->date_plan);

        // Get all data for the date to calculate totals correctly
        $allData = $query->get();

        $robotCount = $allData->where('status', 1)->count();
        $manualCount = $allData->where('status', 2)->count();
        $sswCount = $allData->where('status', 3)->count();
        $totalQty = $allData->sum('qty_plan');

        if ($request->status_filter) {
            $query->where('a.status', $request->status_filter);
        }

        $data = $query->get();

        return DataTables::of($data)
            ->with([
                'robot_count' => $robotCount,
                'manual_count' => $manualCount,
                'ssw_count' => $sswCount,
                'total_qty' => $totalQty
            ])
            ->make(true);
    }

    public function store(Request $request)
    {
        $part = DataWelding::find($request->part_no);

        $plan = new MpsPlanning;
        $plan->date_plan = $request->date_plan;
        $plan->line_id = $request->machine;
        $plan->job_no = $part->job_no ?? '';
        $plan->part_no = $part->part_no ?? '';
        $plan->part_name = $part->part_name ?? '';
        $plan->model = $part->model ?? '';
        $plan->qty_plan = $request->qty_plan;

        if ($request->status) {
            $plan->status = $request->status;
        } else {
            if (str_starts_with($request->machine, 'ROBOT')) {
                $plan->status = 1;
            } elseif (str_starts_with($request->machine, 'PSW')) {
                $plan->status = 2;
            } elseif (str_starts_with($request->machine, 'SSW')) {
                $plan->status = 3;
            } else {
                $plan->status = 0;
            }
        }

        $plan->created_by = auth()->user()->id;
        $query = $plan->save();

        if ($query) {
            return response()->json(['success' => true, 'msg' => 'Insert success.']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Insert failed.']);
        }
    }

    public function edit(Request $request)
    {
        $row = MpsPlanning::find($request->id);
        if ($row) {
            // Find product_id from DataWelding
            $part = DataWelding::where('job_no', $row->job_no)->where('part_no', $row->part_no)->first();
            return response()->json([
                'success' => true,
                'id' => $row->id,
                'part_no' => $part->id ?? '',
                'qty_plan' => $row->qty_plan,
            ]);
        } else {
            return response()->json(['success' => false, 'msg' => 'Data Not found.']);
        }
    }

    public function update(Request $request)
    {
        $part = DataWelding::find($request->part_no);

        $data = [
            'job_no' => $part->job_no ?? '',
            'part_no' => $part->part_no ?? '',
            'part_name' => $part->part_name ?? '',
            'model' => $part->model ?? '',
            'qty_plan' => $request->qty_plan,
            'updated_by' => auth()->user()->id
        ];

        if ($request->machine) {
            $data['line_id'] = $request->machine;
            if ($request->status) {
                $data['status'] = $request->status;
            } else {
                if (str_starts_with($request->machine, 'ROBOT')) {
                    $data['status'] = 1;
                } elseif (str_starts_with($request->machine, 'PSW')) {
                    $data['status'] = 2;
                } elseif (str_starts_with($request->machine, 'SSW')) {
                    $data['status'] = 3;
                }
            }
        }

        $query = MpsPlanning::where('id', $request->id)->update($data);
        if ($query) {
            return response()->json(['success' => true, 'msg' => 'Edit success.']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Edit failed.']);
        }
    }

    public function destroyline(Request $request)
    {
        $query = MpsPlanning::where('id', $request->id)->delete();
        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Delete success.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Delete failed.'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $query = MpsPlanning::where('date_plan', $request->date_plan)->where('line_id', $request->idline)->delete();
        if ($query) {
            return response()->json(['success' => true, 'msg' => 'Delete success.']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Delete failed.']);
        }
    }

    public function export()
    {
        return Excel::download(new ReportB3Export, 'report.xlsx');
    }

}
