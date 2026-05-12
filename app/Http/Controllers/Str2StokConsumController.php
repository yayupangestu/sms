<?php

namespace App\Http\Controllers;
use App\Models\Departement;
use App\Models\MasterListStr;
use App\Models\Str2StokConsum;
use App\Models\StrCategory;
use App\Models\StrUom;
use App\Models\User;
use App\Exports\Consum2Export;
// use App\Models\Str2StokConsum;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use DataTables;
use DB;

class Str2StokConsumController extends Controller
{
    public function index()
    {
        $title = 'STOK';
        $str_uoms = StrUom::all();
        $str_categories = StrCategory::all();
        // $master_list_strs = StrBarang::all();
        $master_list_strs = DB::table('master_list_strs as a')
            ->select('a.id', 'a.name', 'b.name as category')
            ->join('str_categories as b', 'b.id', '=', 'a.category', 'left')
            //    ->join('master_list_strs as d', '.id', '=', 'a.category','left')
            ->get();
        return view('store2.stokconsum', compact('title', 'str_uoms', 'master_list_strs'));
    }




    public function list()
    {
        $query = DB::table('str2_stok_consums as a')
            ->select('a.minimal', 'a.actual', 'a.category', 'b.name as item_id', 'a.id as id', 'c.name as satuan')
            ->join('master_list_strs as b', 'b.id', '=', 'a.item_id', 'left')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan', 'left')
            // ->join('materials as c', 'c.id', '=', 'a.actual', 'left')
            ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $stok = new Str2StokConsum;
        $stok->item_id = $request->item_id;
        $stok->category = $request->category;
        $stok->minimal = $request->minimal;
        $stok->actual = $request->actual;
        $stok->satuan = $request->satuan;
        $stok->createdby = auth()->user()->id;
        $query = $stok->save();
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

    public function edit(Request $request)
    {
        $cek = Str2StokConsum::where('id', $request->id)->count();
        if ($cek > 0) {
            $row = Str2StokConsum::where('id', $request->id)->first();
            return response()->json([
                'success' => true,
                'id' => $row->id,
                'item_id' => $row->item_id,
                'category' => $row->category,
                'minimal' => $row->minimal,
                'actual' => $row->actual,
                'satuan' => $row->satuan,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Data Not found.'
            ]);
        }
    }

    public function update(Request $request)
    {
        $data['item_id'] = $request->item_id;
        $data['category'] = $request->category;
        $data['minimal'] = $request->minimal;
        $data['actual'] = $request->actual;
        $data['satuan'] = $request->satuan;
        $data['updatedby'] = auth()->user()->id;
        $query = Str2StokConsum::where('id', $request->id)->update($data);
        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Update success.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Update failed.'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $query = Str2StokConsum::where('id', $request->id)->delete();
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

    public function export()
    {

        return Excel::download(new Consum2Export, 'ConsumExport.xlsx');
    }
}

