<?php

namespace App\Http\Controllers;
use App\Models\Departement;
use App\Models\StrBarang;
use App\Models\Str2Out;
use App\Models\StrCategory;
use App\Models\StrUom;
use App\Models\Str2StokAtk;
use App\Models\Str2StokConsum;
use App\Models\Str2StokCuptip;
use App\Models\Str2StokGas;
use App\Models\Str2StokRtk;
use App\Models\Str2StokTi;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\ItemsOutExportStr2;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;


class Str2OutController extends Controller
{
    public function index()
    {
        $title = 'Item Out Store Room 2';
        $departements = Departement::all();
        $str_uoms = StrUom::all();
        $str_barangs = DB::table('str_barangs as a')
        ->select('a.id', 'a.name', 'b.name as category')
        ->join('str_categories as b', 'b.id', '=', 'a.category','left')
        ->get();
        return view('storeroom2.out', compact('title','departements','str_uoms','str_barangs'));
    }

    public function list()
    {
        $query = DB::table('str2_outs as a')
                ->select('a.date_plan','b.name_dept as line',DB::raw('CONCAT(a.date_plan, b.id)as mix_id'))
                ->join('departements as b', 'b.id', '=', 'a.line_id', 'left')
                ->groupBy('a.date_plan')
                ->groupBy('a.line_id')
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('str2_outs as a')
                ->select('a.id','c.name', 'a.qty_request','a.qty_out','a.keterangan','d.name as satuan','e.description as line_id')
                // ->join('depts as b', 'b.id', '=', 'a.line_id', 'left')
                ->join('str_barangs as c', 'c.id', '=', 'a.item_id', 'left')
                ->join('str_uoms as d', 'd.id', '=', 'a.satuan', 'left')
                ->join('departements as e', 'e.id', '=', 'a.line_id', 'left')
                ->where('a.date_plan', $request->date_plan)
                ->where('a.line_id', $request->line_id)
                ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        // Ambil harga (price) dari tabel str_barangs berdasarkan item_id
        $barang = DB::table('str_barangs')->where('id', $request->item_id)->first();
    
        if (!$barang) {
            return response()->json([
                'success' => false,
                'msg' => 'Item not found.',
            ]);
        }
    
        // Konversi harga menjadi angka
        $price = floatval($barang->price);
    
        // Pastikan qty_out adalah angka
        $qtyOut = floatval($request->qty_out);
    
        // Hitung price_item
        $priceItem = $qtyOut * $price;
    
        $out = new Str2Out();
        $out->line_id = $request->line_id;
        $out->item_id = $request->item_id;
        $out->qty_request = $request->qty_request;
        $out->qty_out = $qtyOut;
        $out->date_plan = $request->date_plan;
        $out->satuan = $request->satuan;
        $out->price_item = $priceItem; // Simpan hasil ke kolom price_item
        $out->keterangan = $request->keterangan;
        $out->createdby = auth()->user()->id;
    
        if ($out->save()) {
            return response()->json([
                'success' => true,
                'msg' => 'Insert success.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Insert failed.',
            ]);
        }
    }

    public function destroyline(Request $request)
{
    // Validasi ID yang diterima
    $validated = $request->validate([
        'id' => 'required|integer|exists:str_outs,id',
    ]);

    // Ambil record dari tabel str_outs berdasarkan ID
    $Str2Out = Str2Out::find($request->id);

    if ($Str2Out) {
        // Ambil nilai qty_out dan item_id dari record yang akan dihapus
        $qtyOut = $Str2Out->qty_out;
        $itemId = $Str2Out->item_id;

        // Mulai transaksi untuk memastikan semua operasi berhasil atau tidak sama sekali
        DB::beginTransaction();

        try {
            // Temukan record yang sesuai di tabel str_stok_atks berdasarkan item_id
            $str2StokAtk = Str2StokAtk::where('item_id', $itemId)->first();
            if ($str2StokAtk) {
                $str2StokAtk->actual += $qtyOut;
                $str2StokAtk->save();
            }

            // Temukan record yang sesuai di tabel str_stok_rtks berdasarkan item_id
            $str2StokRtk = Str2StokRtk::where('item_id', $itemId)->first();
            if ($str2StokRtk) {
                $str2StokRtk->actual += $qtyOut;
                $str2StokRtk->save();
            }

            // Temukan record yang sesuai di tabel str_stok_consums berdasarkan item_id
            $str2StokConsum = Str2StokConsum::where('item_id', $itemId)->first();
            if ($str2StokConsum) {
                $str2StokConsum->actual += $qtyOut;
                $str2StokConsum->save();
            }

            // Temukan record yang sesuai di tabel str_stok_ciptips berdasarkan item_id
            $str2StokCuptip = Str2StokCuptip::where('item_id', $itemId)->first();
            if ($str2StokCuptip) {
                $str2StokCuptip->actual += $qtyOut;
                $str2StokCuptip->save();
            }

            //tabel str_stok_ti 
            $str2StokTi = Str2StokTi::where('item_id', $itemId)->first();
            if ($str2StokTi) {
                $str2StokTi->actual += $qtyOut;
                $str2StokTi->save();
            }

            //tabel str_stok_gas
            $str2StokGas = Str2StokGas::where('item_id', $itemId)->first();
            if ($str2StokGas) {
                $str2StokGas->actual += $qtyOut;
                $str2StokGas->save();
            }

            // Hapus record dari tabel str_outs
            $Str2Out->delete();

            // Commit transaksi jika semua operasi berhasil
            DB::commit();

            // Respons berhasil
            return response()->json([
                'success' => true,
                'msg'     => 'Delete success and stock updated.'
            ]);
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Respons gagal
            return response()->json([
                'success' => false,
                'msg'     => 'Delete failed. ' . $e->getMessage()
            ]);
        }
    } else {
        // Respons gagal jika record tidak ditemukan
        return response()->json([
            'success' => false,
            'msg'     => 'Record not found.'
        ]);
    }
}
    
public function update(Request $request)
{
    // Ambil harga (price) dari tabel str_barangs berdasarkan item_id
    $barang = DB::table('str_barangs')->where('id', $request->item_id)->first();

    if (!$barang) {
        return response()->json([
            'success' => false,
            'msg' => 'Item not found.',
        ]);
    }

    $priceItem = $request->qty_out * $barang->price; // Hitung price_item

    $data = [
        'item_id' => $request->item_id,
        'qty_out' => $request->qty_out,
        'qty_return' => $request->qty_return,
        'satuan' => $request->satuan,
        'price_item' => $priceItem, // Update kolom price_item
        'updateby' => auth()->user()->id,
    ];

    $query = Str2Out::where('id', $request->id)->update($data);

    if ($query) {
        return response()->json([
            'success' => true,
            'msg' => 'Edit success.',
        ]);
    } else {
        return response()->json([
            'success' => false,
            'msg' => 'Edit failed.',
        ]);
    }
}

public function updatePriceItems()
{
$outItems = Str2Out::all();

foreach ($outItems as $item) {
    $barang = DB::table('str_barangs')->where('id', $item->item_id)->first();

    if ($barang) {
        $priceItem = $item->qty_out * $barang->price;
        $item->update(['price_item' => $priceItem]);
    }
}

return response()->json([
'success' => true,
'msg' => 'Price items updated successfully.',
]);
}

    public function edit(Request $request)
    {
        $cek = Str2Out::where('id', $request->id)->count();
        if($cek > 0){
            $row = Str2Out::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'item_id'        => $row->item_id,
                'qty_request'    => $row->qty_request,
                'qty_out'        => $row->qty_out,
                'keterangan'     => $row->keterangan,
                'satuan'         => $row->satuan,
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Data Not found.'
            ]);
        }
    }


    public function destroy(Request $request)
    {
        $query = Str2Out::where('date_plan', $request->date_plan)->where('line_id', $request->idline)->delete();
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Delete success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Delete failed.'
            ]);
        }
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $barangId = $request->input('barang_id'); // Ambil item_id dari request
    
        // Cek apakah item_id ada atau kosong
        if ($barangId) {
            // Jika item_id ada, filter berdasarkan tanggal dan item_id
            return Excel::download(new ItemsOutExportStr2($startDate, $endDate, $barangId), 'Item Out ASI-2.xlsx');
        } else {
            // Jika item_id tidak ada, filter hanya berdasarkan tanggal
            return Excel::download(new ItemsOutExportStr2($startDate, $endDate, null), 'Item Out ASI-2.xlsx');
        }
    }
}