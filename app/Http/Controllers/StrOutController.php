<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\StrBarang;
use App\Models\StrOut;
use App\Models\StrCategory;
use App\Models\StrUom;
use App\Models\User;
use App\Exports\ItemsOutExport;
use App\Models\StrStokAtk;
use App\Models\StrStokRtk;
use App\Models\StrStokConsum;
use App\Models\StrStokCuptip;
use App\Models\StrStokTi;
use App\Models\StrStokGas;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;


class StrOutController extends Controller
{
    public function index()
    {
        $title = 'Item Out Store Room';
        $departements = Departement::all();
        $str_uoms = StrUom::all();
        $master_list_strs = DB::table('master_list_strs as a')
            ->select('a.id', 'a.name', 'b.name as category')
            ->join('str_categories as b', 'b.id', '=', 'a.category', 'left')
            ->get();
        return view('store.out', compact('title', 'departements', 'str_uoms', 'master_list_strs'));
    }

    public function list()
    {
        $query = DB::table('str_outs as a')
            ->select('a.date_plan', 'b.name_dept as line', DB::raw('CONCAT(a.date_plan, b.id)as mix_id'))
            ->join('departements as b', 'b.id', '=', 'a.line_id', 'left')
            ->groupBy('a.date_plan')
            ->groupBy('a.line_id')
            ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('str_outs as a')
            ->select('a.id', 'c.name', 'a.qty_request', 'a.qty_out', 'a.keterangan', 'd.name as satuan', 'e.description as line_id')
            // ->join('depts as b', 'b.id', '=', 'a.line_id', 'left')
            ->join('master_list_strs as c', 'c.id', '=', 'a.item_id', 'left')
            ->join('str_uoms as d', 'd.id', '=', 'a.satuan', 'left')
            ->join('departements as e', 'e.id', '=', 'a.line_id', 'left')
            ->where('a.date_plan', $request->date_plan)
            ->where('a.line_id', $request->line_id)
            ->get();
        return DataTables::of($query)->make();
    }

    public function store(Request $request)
    {
        // Ambil harga (price) dari tabel master_list_strs berdasarkan item_id
        $barang = DB::table('master_list_strs')->where('id', $request->item_id)->first();

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

        $out = new StrOut();
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
        $strOut = StrOut::find($request->id);

        if ($strOut) {
            // Ambil nilai qty_out dan item_id dari record yang akan dihapus
            $qtyOut = $strOut->qty_out;
            $itemId = $strOut->item_id;

            // Mulai transaksi untuk memastikan semua operasi berhasil atau tidak sama sekali
            DB::beginTransaction();

            try {
                // Temukan record yang sesuai di tabel str_stok_atks berdasarkan item_id
                $strStokAtk = StrStokAtk::where('item_id', $itemId)->first();
                if ($strStokAtk) {
                    $strStokAtk->actual += $qtyOut;
                    $strStokAtk->save();
                }

                // Temukan record yang sesuai di tabel str_stok_rtks berdasarkan item_id
                $strStokRtk = StrStokRtk::where('item_id', $itemId)->first();
                if ($strStokRtk) {
                    $strStokRtk->actual += $qtyOut;
                    $strStokRtk->save();
                }

                // Temukan record yang sesuai di tabel str_stok_consums berdasarkan item_id
                $strStokConsum = StrStokConsum::where('item_id', $itemId)->first();
                if ($strStokConsum) {
                    $strStokConsum->actual += $qtyOut;
                    $strStokConsum->save();
                }

                // Temukan record yang sesuai di tabel str_stok_ciptips berdasarkan item_id
                $strStokCuptip = strStokCuptip::where('item_id', $itemId)->first();
                if ($strStokCuptip) {
                    $strStokCuptip->actual += $qtyOut;
                    $strStokCuptip->save();
                }

                //tabel str_stok_ti 
                $strStokTi = strStokTi::where('item_id', $itemId)->first();
                if ($strStokTi) {
                    $strStokTi->actual += $qtyOut;
                    $strStokTi->save();
                }

                //tabel str_stok_gas
                $strStokGas = strStokGas::where('item_id', $itemId)->first();
                if ($strStokGas) {
                    $strStokGas->actual += $qtyOut;
                    $strStokGas->save();
                }

                // Hapus record dari tabel str_outs
                $strOut->delete();

                // Commit transaksi jika semua operasi berhasil
                DB::commit();

                // Respons berhasil
                return response()->json([
                    'success' => true,
                    'msg' => 'Delete success and stock updated.'
                ]);
            } catch (\Exception $e) {
                // Rollback transaksi jika terjadi kesalahan
                DB::rollBack();

                // Respons gagal
                return response()->json([
                    'success' => false,
                    'msg' => 'Delete failed. ' . $e->getMessage()
                ]);
            }
        } else {
            // Respons gagal jika record tidak ditemukan
            return response()->json([
                'success' => false,
                'msg' => 'Record not found.'
            ]);
        }
    }

    public function update(Request $request)
    {
        // Ambil harga (price) dari tabel master_list_strs berdasarkan item_id
        $barang = DB::table('master_list_strs')->where('id', $request->item_id)->first();

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

        $query = StrOut::where('id', $request->id)->update($data);

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
        // 1. Perbaiki harga di master_list_strs
        $barangs = DB::table('master_list_strs')->get();
        foreach ($barangs as $b) {
            $rawPrice = $b->price;
            
            // Hilangkan semua titik (asumsi ribuan)
            $cleanPrice = str_replace('.', '', $rawPrice);
            // Ganti koma jadi titik (untuk desimal)
            $cleanPrice = str_replace(',', '.', $cleanPrice);
            
            $numPrice = (float)$cleanPrice;

            // Jika nilai masih di bawah 1000, kemungkinan besar itu ribuan yang terpotong 
            // (misal "43.000" jadi 43.0 atau "147,48" jadi 147.48)
            if ($numPrice > 0 && $numPrice < 1000) {
                $numPrice = $numPrice * 1000;
            }

            DB::table('master_list_strs')->where('id', $b->id)->update(['price' => $numPrice]);
        }

        // 2. Update price_item di str_outs berdasarkan harga yang sudah diperbaiki
        $outItems = StrOut::all();
        foreach ($outItems as $item) {
            $barang = DB::table('master_list_strs')->where('id', $item->item_id)->first();

            if ($barang) {
                $priceItem = $item->qty_out * (float)$barang->price;
                $item->update(['price_item' => $priceItem]);
            }
        }

        return response()->json([
            'success' => true,
            'msg' => 'Price items and master prices updated successfully with thousands correction.',
        ]);
    }

    public function edit(Request $request)
    {
        $cek = StrOut::where('id', $request->id)->count();
        if ($cek > 0) {
            $row = StrOut::where('id', $request->id)->first();
            return response()->json([
                'success' => true,
                'id' => $row->id,
                'item_id' => $row->item_id,
                'qty_request' => $row->qty_request,
                'qty_out' => $row->qty_out,
                'keterangan' => $row->keterangan,
                'satuan' => $row->satuan,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Data Not found.'
            ]);
        }
    }


    public function destroy(Request $request)
    {
        $query = StrOut::where('date_plan', $request->date_plan)->where('line_id', $request->idline)->delete();
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
        $barangId = $request->input('barang_id'); // Ambil item_id dari request

        // Cek apakah item_id ada atau kosong
        if ($barangId) {
            // Jika item_id ada, filter berdasarkan tanggal dan item_id
            return Excel::download(new ItemsOutExport($startDate, $endDate, $barangId), 'Item Out ASI-1.xlsx');
        } else {
            // Jika item_id tidak ada, filter hanya berdasarkan tanggal
            return Excel::download(new ItemsOutExport($startDate, $endDate, null), 'Item Out ASI-1.xlsx');
        }
    }
}
