<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RmDnIncoming;
use App\Models\TabelTransitPcStore;
use App\Models\TabelStokSbc;
use App\Models\DnInput;
use App\Models\RmInMaterial;
use App\Models\ScanOutWelding;
use App\Models\PcStoreDirect;
use App\Models\TagLabelSubcont; // tambahkan model ini di atas
use Illuminate\Support\Facades\DB;

class ScanOutLsController extends Controller
{
    public function index(){
        $title = 'Scan out Label LS';
       return view('linestore.scanout',compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_no'   => 'required|string',
            'job_no'    => 'required|string',
            'qty_act'   => 'required|integer',
            'count'     => 'required|integer',
            'id_data'   => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // ✅ Cek dulu di tabel tag_label_subconts
            $tag = TagLabelSubcont::where('uniqNo', $request->id_data)->first();

            if ($tag && $tag->sts == 1) {
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
            $transit->uniqNo    = $request->id_data;
            $transit->createdby = auth()->id();
            $transit->sts       = 1;
            $transit->save();

            // ✅ Update PcStoreDirect
            $PcStoreDirects = PcStoreDirect::where('job_no', $request->job_no)->get();

            if ($PcStoreDirects->isNotEmpty()) {
                if ($PcStoreDirects->count() > 1) {
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
                    $item = $PcStoreDirects->first();
                    $item->qty_act += $request->qty_act;
                    $item->strength = $item->daily_volume > 0
                        ? round($item->qty_act / $item->daily_volume, 1)
                        : 0;
                    $item->save();
                }
            }

            // ✅ Update status di tag_label_subconts
            if ($tag) {
                $tag->sts = 1;
                $tag->save();
            }

            // // ✅ Update stok: kurangi qty_act_ls & tambahkan qty_act_prepare
            // \DB::table('tabel_stok_sbcs')
            //     ->where('job_no', $request->job_no)
            //     ->update([
            //         'qty_act_ls'      => \DB::raw("GREATEST(qty_act_ls - {$request->qty_act}, 0)"),
            //         'qty_act_prepare' => \DB::raw("qty_act_prepare + {$request->qty_act}")
            //     ]);


                 // Update stok
            $TabelStokSbc = TabelStokSbc::where('job_no', $request->job_no)->get();
            if ($TabelStokSbc->isNotEmpty()) {
                foreach ($TabelStokSbc as $item) {
                    $item->qty_act_prepare += $request->qty_act; // ✅ Pastikan qty yang digunakan sesuai
                    $item->qty_act_ls -= $request->qty_act; // ✅ Pastikan qty yang digunakan sesuai
                    $item->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan, stok & status updated.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'part_no'   => 'required|string',
    //         'job_no'    => 'required|string',
    //         'qty_act'   => 'required|integer',
    //         'count'     => 'required|integer',
    //         'id_data'   => 'required|string',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         // ✅ Cek dulu di tabel tag_label_weldings
    //         $tag = TagLabelSubcont::where('uniqNo', $request->id_data)->first();

    //         if ($tag && $tag->sts == 1) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Label sudah discan sebelumnya.'
    //             ], 400);
    //         }

    //         // Simpan data scan in welding
    //         $ScanInPsWelding = new ScanInPsWelding();
    //         $ScanInPsWelding->part_no   = $request->part_no;
    //         $ScanInPsWelding->job_no    = $request->job_no;
    //         $ScanInPsWelding->qty_act   = $request->qty_act;
    //         $ScanInPsWelding->count     = $request->count;
    //         $ScanInPsWelding->id_data   = $request->id_data;
    //         $ScanInPsWelding->createdby = auth()->id();
    //         $ScanInPsWelding->sts       = 1;
    //         $ScanInPsWelding->save();

    //         // Update PcStoreDirect
    //         $PcStoreDirects = PcStoreDirect::where('job_no', $request->job_no)->get();
    //         if ($PcStoreDirects->isNotEmpty()) {
    //             foreach ($PcStoreDirects as $item) {
    //                 $item->qty_act += $request->qty_act;
    //                 $item->strength = $item->daily_volume > 0
    //                     ? round($item->qty_act / $item->daily_volume, 1)
    //                     : 0;
    //                 $item->save();
    //             }
    //         }

    //         // Update status di tag_label_weldings
    //         if ($tag) {
    //             $tag->sts = 1;
    //             $tag->save();
    //         }

    //         DB::commit();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data berhasil disimpan, stok & status updated.'
    //         ]);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }


}
