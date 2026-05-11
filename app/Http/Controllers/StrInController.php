<?php

namespace App\Http\Controllers;
use App\Models\Departement;
use App\Models\StrBarang;
use App\Models\StrIn;
use App\Models\StrCategory;
use App\Models\StrUom;
use App\Models\StrSuplaier;
use Illuminate\Http\Request;
use App\Exports\ItemsInExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;

class StrInController extends Controller
{
    public function index()
    {
        $title = 'Item IN';
        $str_categories = StrCategory::all();
        $str_suplaiers = StrSuplaier::all();
        $str_uoms = StrUom::all();
        $master_list_strs = DB::table('master_list_strs as a')
            ->select('a.id', 'a.name', 'b.name as category')
            ->join('str_categories as b', 'b.id', '=', 'a.category', 'left')
            ->get();
        return view('store.StrIn', compact('title', 'str_uoms', 'master_list_strs', 'str_categories', 'str_suplaiers'));
    }

    public function list()
    {
        $query = DB::table('str_ins as a')
            ->select('a.date_plan', 'b.name as category', DB::raw('CONCAT(a.date_plan, b.id)as mix_id'))
            ->join('str_categories as b', 'b.id', '=', 'a.category_id', 'left')
            ->groupBy('a.date_plan')
            ->groupBy('a.category_id')
            ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('str_ins as a')
            ->select('a.id', 'a.keterangan', 'c.name as item_id', 'a.qty_in', 'd.name as satuan', 'e.pt as suplai_id', 'f.name as category_id')
            // ->join('depts as b', 'b.id', '=', 'a.line_id', 'left')
            ->join('master_list_strs as c', 'c.id', '=', 'a.item_id', 'left')
            ->join('str_uoms as d', 'd.id', '=', 'a.satuan', 'left')
            ->join('str_suplaiers as e', 'e.id', '=', 'a.suplai_id', 'left')
            ->join('str_categories as f', 'f.id', '=', 'a.category_id')
            ->where('a.date_plan', $request->date_plan)
            ->where('a.category_id', $request->category_id)
            ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $in = new StrIn;
        $in->date_plan = $request->date_plan;
        $in->category_id = $request->category_id;
        $in->item_id = $request->item_id;
        $in->suplai_id = $request->suplai_id;
        $in->qty_in = $request->qty_in;
        $in->keterangan = $request->keterangan;
        $in->satuan = $request->satuan;
        $in->createdby = auth()->user()->id;
        $query = $in->save();
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
        $query = StrIn::where('id', $request->id)->delete();
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
        $query = StrIn::where('date_plan', $request->date_plan)->where('category_id', $request->idcategory)->delete();
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
    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(new ItemsInExport($startDate, $endDate), 'items_in.xlsx');
    }
}

