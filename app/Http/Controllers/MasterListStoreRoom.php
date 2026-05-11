<?php

namespace App\Http\Controllers;
use App\Models\MasterListStr;
use App\Models\StrCategory;
use Illuminate\Http\Request;
use App\Exports\BarangsExport;
// use App\Models\StrStokAtk;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;

class MasterListStoreRoom extends Controller
{
    public function index()
    {
        $title = 'Data Barang';
        $str_categories = StrCategory::all();
        return view('store.masterlist', compact('title', 'str_categories'));
    }


    public function list()
    {
        $query = DB::table('master_list_strs as a')
            ->select('a.name', 'a.description', 'a.id as id', 'b.name as category', 'a.item_code', 'a.price')
            ->join('str_categories as b', 'b.id', '=', 'a.category', 'left')
            // ->join('satuan_strs as c', 'c.id', '=', 'a.satuan','left')
            // ->join('materials as c', 'c.id', '=', 'a.actual', 'left')
            ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        $barang = new MasterListStr;
        $barang->name = $request->nama;
        $barang->category = $request->category;
        $barang->description = $request->description;
        $barang->item_code = $request->item_code;
        $price = str_replace('.', '', $request->price ?? '0'); // Hapus pemisah ribuan (titik)
        $price = str_replace(',', '.', $price); // Ganti pemisah desimal (koma) jadi titik
        $barang->price = $price;
        $barang->createby = auth()->user()->id;
        $query = $barang->save();
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
        $cek = MasterListStr::where('id', $request->id)->count();
        if ($cek > 0) {
            $row = MasterListStr::where('id', $request->id)->first();
            return response()->json([
                'success' => true,
                'id' => $row->id,
                'name' => $row->name,
                'category' => $row->category,
                'description' => $row->description,
                'item_code' => $row->item_code,
                'price' => $row->price,
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
        $data['name'] = $request->nama;
        $data['category'] = $request->category;
        $data['description'] = $request->description;
        $data['item_code'] = $request->item_code;
        $price = str_replace('.', '', $request->price ?? '0'); // Hapus pemisah ribuan (titik)
        $price = str_replace(',', '.', $price); // Ganti pemisah desimal (koma) jadi titik
        $data['price'] = $price;
        $data['updatedby'] = auth()->user()->id;
        $query = MasterListStr::where('id', $request->id)->update($data);
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
        $query = MasterListStr::where('id', $request->id)->delete();
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
        return Excel::download(new BarangsExport, 'BarangsExport.xlsx');
    }
}