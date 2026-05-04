<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmDnIncoming;
use App\Models\TabelTransitPcStore;
use App\Models\RmStok;
use App\Models\DnInput;
use App\Models\RmInMaterial;
use App\Models\ScanOutWelding;
use App\Models\PcStoreDirect;
use App\Models\TagLabelWelding; // tambahkan model ini di atas
use Illuminate\Support\Facades\DB;

class ScanInPsWeldingController extends Controller
{
    public function index(){
        $title = 'Scan label';
       return view('scanner2.scaninpswelding',compact('title'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'part_no'   => 'required|string',
            'job_no'    => 'required|string',
            'qty_act'   => 'required|integer',
            'count'     => 'required|string',
            'uniqNo'    => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // ✅ Cek apakah uniqNo sudah ada di tabel_transit_pc_stores
            $existingTransit = TabelTransitPcStore::where('uniqNo', $request->uniqNo)->first();
            if ($existingTransit && $existingTransit->sts == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Label sudah discan sebelumnya.'
                ], 400);
            }

            // ✅ Simpan data ke tabel_transit_pc_stores
            $transit = new TabelTransitPcStore();
            $transit->part_no   = $request->part_no;
            $transit->job_no    = $request->job_no;
            $transit->qty_act   = $request->qty_act;
            $transit->count     = $request->count;
            $transit->uniqNo    = $request->uniqNo;
            $transit->createdby = auth()->id();
            $transit->sts       = 1;
            $transit->save();

            // ✅ Update TagLabelWelding yang sesuai uniqNo
            $tagLabel = TagLabelWelding::where('uniqNo', $request->uniqNo)->first();
            if ($tagLabel) {
                $tagLabel->sts = 1;
                $tagLabel->sts_pcstore = 1;
                $tagLabel->save();
            }

            // ✅ Update PcStoreDirect (update qty_act & strength)
            $pcStoreDirects = PcStoreDirect::where('job_no', $request->job_no)->get();
            if ($pcStoreDirects->isNotEmpty()) {
                if ($pcStoreDirects->count() > 1) {
                    $items = PcStoreDirect::where('job_no', $request->job_no)
                        ->where('part_no2', $request->part_no)
                        ->get();

                    foreach ($items as $item) {
                        $item->qty_act += $request->qty_act;
                        $item->strength = $item->daily_volume > 0
                            ? round($item->qty_act / $item->daily_volume, 1)
                            : 0;
                        $item->save();
                    }
                } else {
                    $item = $pcStoreDirects->first();
                    $item->qty_act += $request->qty_act;
                    $item->strength = $item->daily_volume > 0
                        ? round($item->qty_act / $item->daily_volume, 1)
                        : 0;
                    $item->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan dan status berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }


}


// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\RmDnIncoming;
// use App\Models\TabelTransitPcStore;
// use App\Models\RmStok;
// use App\Models\DnInput;
// use App\Models\RmInMaterial;
// use App\Models\ScanOutWelding;
// use App\Models\PcStoreDirect;
// use App\Models\TagLabelWelding; // tambahkan model ini di atas
// use Illuminate\Support\Facades\DB;

// class ScanInPsWeldingController extends Controller
// {
//     public function index(){
//         $title = 'Scan label';
//        return view('scanner2.scaninpswelding',compact('title'));
//     }

//     public function store(Request $request)
//     {
//         $request->validate([
//             'part_no'   => 'required|string',
//             'job_no'    => 'required|string',
//             'qty_act'   => 'required|integer',
//             'count'     => 'required|integer',
//             'uniqNo'   => 'required|string',
//         ]);

//         DB::beginTransaction();

//         try {
//             // ✅ Cek dulu di tabel tag_label_weldings
//             $tag = TagLabelWelding::where('uniqNo', $request->uniqNo)->first();

//             if ($tag && $tag->sts == 1) {
//                 return response()->json([
//                     'success' => false,
//                     'message' => 'Label sudah discan sebelumnya.'
//                 ], 400);
//             }

//             // Simpan data scan in welding
//             $TabelTransitPcStore = new TabelTransitPcStore();
//             $TabelTransitPcStore->part_no   = $request->part_no;
//             $TabelTransitPcStore->job_no    = $request->job_no;
//             $TabelTransitPcStore->qty_act   = $request->qty_act;
//             $TabelTransitPcStore->count     = $request->count;
//             $TabelTransitPcStore->uniqNo   = $request->uniqNo;
//             $TabelTransitPcStore->createdby = auth()->id();
//             $TabelTransitPcStore->sts       = 1;
//             $TabelTransitPcStore->save();

//             // ✅ Update PcStoreDirect
//             $PcStoreDirects = PcStoreDirect::where('job_no', $request->job_no)->get();

//             if ($PcStoreDirects->isNotEmpty()) {
//                 if ($PcStoreDirects->count() > 1) {
//                     // 🔄 Kalau lebih dari 1 baris → update SEMUA yang part_no sama
//                     $items = PcStoreDirect::where('job_no', $request->job_no)
//                         ->where('part_no2', $request->part_no)
//                         ->get();

//                     foreach ($items as $item) {
//                         $item->qty_act += $request->qty_act;
//                         $item->strength = $item->daily_volume > 0
//                             ? round($item->qty_act / $item->daily_volume, 1)
//                             : 0;
//                         $item->save();
//                     }
//                 } else {
//                     // ✅ Kalau hanya 1 baris → update biasa
//                     $item = $PcStoreDirects->first();
//                     $item->qty_act += $request->qty_act;
//                     $item->strength = $item->daily_volume > 0
//                         ? round($item->qty_act / $item->daily_volume, 1)
//                         : 0;
//                     $item->save();
//                 }
//             }

//             // ✅ Update status di tag_label_weldings
//             if ($tag) {
//                 $tag->sts = 1;
//                 $tag->save();
//             }

//             DB::commit();

//             return response()->json([
//                 'success' => true,
//                 'message' => 'Data berhasil disimpan, stok & status updated.'
//             ]);
//         } catch (\Exception $e) {
//             DB::rollBack();
//             return response()->json([
//                 'success' => false,
//                 'message' => 'Terjadi kesalahan: ' . $e->getMessage()
//             ], 500);
//         }
//     }


// }
