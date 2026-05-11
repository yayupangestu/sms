<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Str2StokAtk;
use App\Models\Str2StokRtk;
use App\Models\Str2StokConsum;
use App\Models\Str2StokCuptip;
use App\Models\Str2StokGas;
use App\Models\Str2StokTi;
use App\Models\Departement;
use App\Models\StrBarang;
use App\Models\Str2Out11;
use App\Models\StrCategory;
use App\Models\StrUom;
use App\Models\User;
use App\Exports\ItemsOut11ExportStr2;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Str2Out11Controller extends Controller
{
    public function index()
    {
        $title = 'E-SPB SSW SU2ID';
        $departements = Departement::all();
        $users = User::all();
        $str_uoms = StrUom::all();
    
        // Menampilkan hanya barang dengan item_code yang mengandung "STMP"
        $str_barangs = DB::table('str_barangs as a')
            ->select('a.id', 'a.name', 'b.name as category', 'a.item_code')
            ->join('str_categories as b', 'b.id', '=', 'a.category', 'left')
            ->where('a.item_code', 'like', 'STMP%') // Filter berdasarkan item_code "STMP"
            ->get();
    
        Alert::info('NOTE:', 'Penukaran Barang Harap Membawa Bekasnya',);
    
        return view('storeroom2.out11', compact('title', 'departements', 'str_uoms', 'str_barangs', 'users'));
    }

    public function list()
    {
        $query = DB::table('str2_out11s as a')
            ->select('a.date_plan', 'a.doc_no', 'a.line_id', 'c.name as createdby', DB::raw('GROUP_CONCAT(a.status) as status'), DB::raw('MAX(a.created_at) as created_at'))
            ->join('users as c', 'c.id', '=', 'a.createdby', 'left')
            ->where('a.sts', 1)
            ->groupBy('a.doc_no', 'a.date_plan', 'a.line_id', 'a.createdby')
            ->orderBy('created_at', 'desc')
            ->get();
    
        return DataTables::of($query)->make();
    }
    
    public function update(Request $request)
    {
        if($request->button == "update"){
            $jml = count($request->idline);
            $jml = count($request->idket);

            for ($i=1; $i < $jml+1; $i++) { 
                $data['qty_out']      = $request->qty[$i];
                $data['keterangan']       = $request->ket[$i];
                // $data['qty_gsph']     = $request->gsph[$i];
                // $data['qty_mesin']    = $request->mesin[$i];
                // $data['qty_dies']     = $request->dies[$i];
                // $data['qty_dandori']  = $request->dandori[$i];
                // $data['ket_remark']   = $request->remark[$i];
                $data['updateby']    = auth()->user()->id;
                // $data['material_id'] = $request->rm[$i];
                
                Str2Out11::where('id', $request->idline[$i])->where('id', $request->idket[$i])->update($data);
            }
            alert()->success('Success','Update data success');
            return back();

        }
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('str2_out11s as a')
                ->select('a.id','c.name','a.qty_return', 'a.qty_standing','a.qty_request','a.keterangan','d.name as satuan','e.description as line_id','s.username as createdby')
                // ->join('depts as b', 'b.id', '=', 'a.line_id', 'left')
                ->join('str_barangs as c', 'c.id', '=', 'a.item_id', 'left')
                ->join('str_uoms as d', 'd.id', '=', 'a.satuan', 'left')
                ->join('departements as e', 'e.id', '=', 'a.line_id', 'left')
                ->join('users as s', 's.id', '=', 'a.createdby', )
                ->where('a.doc_no', $request->doc_no)
                ->where('a.date_plan', $request->date_plan)
                ->where('a.line_id', $request->line_id)
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail2(Request $request)
    {
        $query = DB::table('str2_out11s as a')
                ->select('a.id','c.name','a.qty_return','a.qty_standing','a.qty_request','a.keterangan','d.name as satuan','e.description as line_id','a.qty_out','a.keterangan','a.w_dibuat','f.username as createdby','a.line_id','a.date_plan')
                // ->join('depts as b', 'b.id', '=', 'a.line_id', 'left')
                ->join('str_barangs as c', 'c.id', '=', 'a.item_id', 'left')
                ->join('str_uoms as d', 'd.id', '=', 'a.satuan', 'left')
                ->join('departements as e', 'e.id', '=', 'a.line_id', 'left')
                ->join('users as f', 'f.id', '=', 'a.createdby')
                ->where('a.doc_no', $request->doc_no)
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail3(Request $request)
    {
        $query = DB::table('str2_out11s as a')
            ->select(
                'a.id',
                'a.date_plan',
                'c.name',
                'a.qty_return',
                'a.qty_standing',
                'a.qty_request',
                'a.keterangan',
                'd.name as satuan',
                'a.line_id',
                'a.qty_out',
                'a.keterangan',
                'a.w_dibuat',
                'a.status_checklist',
                'a.update_checklist',
                'f.username as createdby'
            )
            ->join('str_barangs as c', 'c.id', '=', 'a.item_id', 'left')
            ->join('str_uoms as d', 'd.id', '=', 'a.satuan', 'left')
            ->join('departements as e', 'e.id', '=', 'a.line_id', 'left')
            ->join('users as f', 'f.id', '=', 'a.createdby')
            ->where('a.doc_no', $request->doc_no)
            ->get();

        return response()->json($query); // Return the query as JSON response
    }

    public function getdoc()
    {
        $cek = Str2Out11::select(DB::raw('COUNT(doc_no) as jml'))->whereMonth('created_at', date('m'))->groupBy('doc_no')->count();
        if($cek > 0){
            $array = array();
            $rows = Str2Out11::select('doc_no')->whereMonth('created_at', date('m'))->groupBy('doc_no')->get();
            foreach ($rows as $key => $value) {
                $array[] = $value->doc_no;
            }
            $arr_doc = count($array);
            return response()->json([
                'jml'   => $arr_doc + 1
            ]);
        }else{
            return response()->json([
                'jml'   => 1
            ]);
        }
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
    
        $priceItem = $request->qty_request * $barang->price; // Hitung price_item
    
        $out = new Str2Out11();
        $out->doc_no = $request->doc_no;
        $out->date_plan = $request->date_plan;
        $out->line_id = $request->line_id;
        $out->item_id = $request->item_id;
        $out->qty_return = $request->qty_return;
        $out->qty_standing = $request->qty_standing;
        $out->qty_request = $request->qty_request;
        $out->price_item = $priceItem; // Simpan hasil ke kolom price_item
        $out->keterangan = $request->keterangan;
        $out->satuan = $request->satuan;
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

    public function update2(Request $request)
    {
        // Ambil harga (price) dari tabel str_barangs berdasarkan item_id
        $barang = DB::table('str_barangs')->where('id', $request->item_id)->first();
    
        if (!$barang) {
            return response()->json([
                'success' => false,
                'msg' => 'Item not found.',
            ]);
        }
    
        $priceItem = $request->qty_request * $barang->price; // Hitung price_item
    
        $data = [
            'item_id' => $request->item_id,
            'qty_request' => $request->qty_request,
            'qty_return' => $request->qty_return,
            'satuan' => $request->satuan,
            'price_item' => $priceItem, // Update kolom price_item
            'updateby' => auth()->user()->id,
        ];
    
        $query = Str2Out11::where('id', $request->id)->update($data);
    
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
        $outItems = Str2Out11::all();

        foreach ($outItems as $item) {
            $barang = DB::table('str_barangs')->where('id', $item->item_id)->first();

            if ($barang) {
                $priceItem = $item->qty_request * $barang->price;
                $item->update(['price_item' => $priceItem]);
            }
        }

        return response()->json([
            'success' => true,
            'msg' => 'Price items updated successfully.',
        ]);
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(new ItemsOut11ExportStr2($startDate, $endDate), 'Penggunaan Barang SSW SU2ID ASI-2.xlsx');
    }

    public function destroyline(Request $request)
    {
        $query = Str2Out11::where('id', $request->id)->delete();
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

    public function edit2(Request $request)
    {
        $cek = Str2Out11::where('id', $request->id)->count();
        if($cek > 0){
            $row = Str2Out11::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'item_id'        => $row->item_id,
                'qty_request'    => $row->qty_request,
                'qty_return'     => $row->qty_return,
                'satuan'         => $row->satuan
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
        $query = Str2Out11::where('doc_no', $request->doc_no)->delete();
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

    public function submit(Request $request)
    {
        $cek = Str2Out11::where('doc_no', $request->doc_no)->count();
        if($cek > 0){
            $data['sts'] = 1;
            $query = Str2Out11::where('doc_no', $request->doc_no)->update($data);
            if($query){
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Submit success.'
                ]);
            }else{
                return response()->json([
                    'success'   => false,
                    'msg'       => 'Submit failed.'
                ]);
            }
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Submit failed. doc no not found'
            ]);
        }
    }

    public function delete_draft(Request $request)
    {
        $query = Str2Out11::where('doc_no', $request->doc_no)->delete();
        return back();
    }

    public function edit(Request $request)
    {
        $row = Str2Out11::select('date_plan','line_id')
                ->where('doc_no', $request->doc_no)
                ->first();
             return response()->json([
                    'date_plan' => $row->date_plan,
                    'idline' => $row->line_id
        ]);
    }


    public function approve(Request $request)
    {

        DB::beginTransaction();

        try {
            $doc_no = $request->input('doc_no');

            // Fetch all str_out3s records with the given doc_no
            $out11Items = Str2Out11::where('doc_no', $doc_no)->get();
            if ($out11Items->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Records not found']);
            }

            foreach ($out11Items as $out11) {
                $item_id = $out11->item_id;
                $qty_request = $out11->qty_request;

                Log::info("Approving doc_no: $doc_no, item_id: $item_id, qty_request: $qty_request");

                // Update str_stok_atks and str_stok_rtks using the helper function
                $this->updateStock(Str2StokAtk::class, $item_id, $qty_request);
                $this->updateStock(Str2StokRtk::class, $item_id, $qty_request);
                $this->updateStock(Str2StokConsum::class, $item_id, $qty_request);
                $this->updateStock(Str2StokCuptip::class, $item_id, $qty_request);
                $this->updateStock(Str2StokGas::class, $item_id, $qty_request);
                $this->updateStock(Str2StokTi::class, $item_id, $qty_request);
            }

            // Update the status of one str_out2 record with the given doc_no to 1
            $firstOut11 = Str2Out11::where('doc_no', $doc_no)->first();
            if ($firstOut11) {
                $firstOut11->status = 1; // Example status update
                $firstOut11->save();
            }

            DB::commit();
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to approve items: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to approve items.']);
        }
    }

    private function updateStock($modelClass, $item_id, $qty_request)
    {
        $stock = $modelClass::where('item_id', $item_id)->first();
        if ($stock) {
            $stock->actual -= $qty_request;
            $stock->save();
        } else {
            Log::warning("Item ID $item_id not found in $modelClass");
        }
    }


    public function approve2(Request $request)
    {
        $doc_no = $request->input('doc_no');
        $strOut11 = Str2Out11::where('doc_no', $doc_no)->first();
        if ($strOut11) {
            $strOut11->status = 2;
            $strOut11->save();

            return response()->json(['success' => true, 'msg' => 'Transaction APPROVED', 'status' => 'APPROVED']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Transaction not found']);
        }
    }

    public function approve3(Request $request)
    {
        $doc_no = $request->input('doc_no');
        $strOut11 = Str2Out11::where('doc_no', $doc_no)->first();
        if ($strOut11) {
            $strOut11->status = 4;
            $strOut11->save();

            return response()->json(['success' => true, 'msg' => 'Transaction APPROVED', 'status' => 'APPROVED']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Transaction not found']);
        }
    }

    public function getActual(Request $request)
    {
    $itemId = $request->input('item_id');

    // Validasi item_id jika perlu
    if (!$itemId) {
        return response()->json(['success' => false, 'message' => 'Item ID tidak valid.']);
    }
    $stock = DB::table('str2_stok_atks')->where('item_id', $itemId)->select('actual')->first();

    if (!$stock) {
        $stock = DB::table('str2_stok_rtks')->where('item_id', $itemId)->select('actual')->first();
    }

    if (!$stock) {
        $stock = DB::table('str2_stok_consums')->where('item_id', $itemId)->select('actual')->first();
    }

    if (!$stock) {
        $stock = DB::table('str2_stok_cuptips')->where('item_id', $itemId)->select('actual')->first();
    }

    if (!$stock) {
        $stock = DB::table('str2_stok_gases')->where('item_id', $itemId)->select('actual')->first();
    }

    if (!$stock) {
        $stock = DB::table('str2_stok_tis')->where('item_id', $itemId)->select('actual')->first();
    }
    if ($stock) {
        return response()->json(['success' => true, 'data' => $stock]);
    } else {
        return response()->json(['success' => false, 'message' => 'Stok Kosong.']);
    }
    }

    public function saveChecked(Request $request)
    {
        // Ambil data hasil centangan dari permintaan
        $items = $request->input('items'); // Mengambil array item dari AJAX
    
        if (!empty($items)) {
            // Lakukan logika penyimpanan data di sini
            $updatedDocNo = null; // Variable to hold doc_no for the first updated item
    
            foreach ($items as $itemId) {
                // Misalnya, lakukan update status atau simpan di database
                $item = Str2Out11::find($itemId); // Ganti dengan model yang sesuai
                if ($item) {
                    // Contoh update field
                    $item->status_checklist = '1'; // Ubah sesuai kebutuhan
                    $item->update_checklist = auth()->user()->username;
                    $item->save();
    
                    // Set updatedDocNo only for the first item
                    if ($updatedDocNo === null) {
                        $updatedDocNo = $item->doc_no; // Get the doc_no of the first updated item
                    }
                }
            }
    
            // Update status to 3 based on the doc_no of the first updated item
            if ($updatedDocNo) {
                $itemToUpdate = Str2Out11::where('doc_no', $updatedDocNo)->first();
                if ($itemToUpdate) {
                    $itemToUpdate->status = 3; // Set status to 3
                    $itemToUpdate->save();
                }
            }
    
            return response()->json(['success' => true, 'message' => 'Data berhasil disimpan.']);
        }
    
        return response()->json(['success' => false, 'message' => 'Tidak ada item yang dipilih.']);
    }   
    
}