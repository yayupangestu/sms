<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DataTables;
use App\Models\TabelBom;
use DB;
use App\Exports\DataBomExport;
use App\Exports\FormatDataBomExport;
use App\Imports\DataBomImport;
use Maatwebsite\Excel\Facades\Excel;

class TabelDataBomController extends Controller
{
    public function index()
    {
        $title = "Tabel Data Bom";
        $customers = DB::table('tabel_boms')->select('customer')->whereNotNull('customer')->groupBy('customer')->get();
        return view('line.databom', compact('title', 'customers'));
    }

    public function list(Request $request)
    {
        $query = DB::table('tabel_boms as a')
            ->select(
                'a.part_no', 
                'a.job_no', 
                'a.part_name', 
                'a.model_id', 
                'a.category_id', 
                'a.customer',
                DB::raw('MAX(a.uniqNo) as uniqNo'), 
                DB::raw('MAX(a.vendor) as vendor'), 
                DB::raw('CONCAT(a.part_no, "|", a.job_no, "|", IFNULL(a.customer, "")) as mix_id')
            );

        if ($request->customer) {
            $query->where('a.customer', $request->customer);
        }

        $data = $query->groupBy('a.part_no')
            ->groupBy('a.job_no')
            ->groupBy('a.part_name')
            ->groupBy('a.model_id')
            ->groupBy('a.category_id')
            ->groupBy('a.customer')
            ->get();

        $count1 = $data->where('category_id', 1)->count();
        $count2 = $data->where('category_id', 2)->count();

        return DataTables::of($data)
            ->with([
                'count1' => $count1,
                'count2' => $count2,
            ])
            ->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('tabel_boms as a')
            ->select('a.id', 'a.part_no', 'a.part_name', 'a.part_no2', 'a.part_name2', 'a.job_no', 'a.model_id', 'a.category_id', 'a.uniqNo', 'a.vendor', 'a.customer')
            ->where('a.part_no', $request->part_no)
            ->where('a.job_no', $request->job_no)
            ->where('a.customer', $request->customer)
            ->where(function ($q) {
                $q->whereColumn('a.part_no2', '!=', 'a.job_no')
                    ->orWhere('a.category_id', 2);
            })
            ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $plan = new TabelBom;
        $plan->part_name = $request->part_name;
        $plan->part_name2 = $request->part_name2;
        $plan->job_no = $request->job_no;
        $plan->part_no = $request->part_no;
        $plan->part_no2 = $request->part_no2;
        $plan->model_id = $request->model_id;
        $plan->category_id = $request->category_id;
        $plan->uniqNo = $request->uniqNo;
        $plan->vendor = $request->vendor;
        $plan->customer = $request->customer;
        $plan->createdby = auth()->user()->id;
        $query = $plan->save();
        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Insert success.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Insert failed.'
            ]);
        }
    }

    public function destroyline(Request $request)
    {
        $query = TabelBom::where('id', $request->id)->delete();
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
        $query = TabelBom::where('part_no', $request->part_no)
            ->where('job_no', $request->job_no)
            ->where('customer', $request->customer)
            ->delete();
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

    public function update(Request $request)
    {
        $query = TabelBom::where('part_no', $request->part_no)
            ->where('job_no', $request->job_no)
            ->where('customer', $request->customer)
            ->update([
                'part_name' => $request->part_name,
                'model_id' => $request->model_id,
                'category_id' => $request->category_id,
                'uniqNo' => $request->uniqNo,
                'vendor' => $request->vendor,
                'customer' => $request->customer,
                'updateby' => auth()->user()->id
            ]);

        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Update success.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Update failed or no changes made.'
            ]);
        }
    }

    public function export()
    {
        return Excel::download(new DataBomExport, 'Data_BOM_' . date('Y-m-d_His') . '.xlsx');
    }

    public function exportTemplate()
    {
        return Excel::download(new FormatDataBomExport, 'Template_BOM.xlsx');
    }

    public function importDp(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new DataBomImport, $request->file('file'));
            return response()->json([
                'success' => true,
                'msg' => 'Import success.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'msg' => 'Import failed: ' . $e->getMessage()
            ]);
        }
    }
}
