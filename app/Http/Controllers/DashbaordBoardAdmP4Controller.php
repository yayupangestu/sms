<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadRekapOrderAdmP4;

class DashbaordBoardAdmP4Controller extends Controller
{
    public function index()
    {
        $title = 'BOARD D26';

        $pressData = UploadRekapOrderAdmP4::where('proses', 'PRESS')
            ->whereBetween('cycle', [1, 10])
            ->where('route2', '-C')
            ->orderBy('type_pallet')
            ->get();

        $subAssy = UploadRekapOrderAdmP4::where('proses', 'SUB ASSY')
            ->whereBetween('cycle', [1, 10])
            ->where('route2', '-C')
            ->orderBy('type_pallet')
            ->get();

        $nutData = UploadRekapOrderAdmP4::where('proses', 'NUT')
            ->whereBetween('cycle', [1, 10])
            ->where('route2', '-C')
            ->orderBy('type_pallet')
            ->get();

        return view('ppic.boardadmp4', compact('title', 'pressData', 'subAssy', 'nutData'));
    }

    public function getPressDataAdm()
    {
        try {
            $pressData = UploadRekapOrderAdmP4::where('proses', 'PRESS')
                ->whereBetween('cycle', [1, 10])
                ->where('qty_order', '>', 0)
                ->where('route2', '-C')
                ->leftJoin('pc_store_directs', 'upload_rekap_order_adm_p4_s.uniqNo', '=', 'pc_store_directs.job_no')
                    ->select(
                'upload_rekap_order_adm_p4_s.*',
                'pc_store_directs.strength',
                'pc_store_directs.qty_act' // 🟢 ambil qty_act
            )
                ->orderBy('type_pallet')
                ->get();

            return response()->json($pressData, 200, [], JSON_INVALID_UTF8_SUBSTITUTE);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getSubassyDataAdm()
    {
        try {
            $subAssyData = UploadRekapOrderAdmP4::where('proses', 'SUB ASSY')
                ->whereBetween('cycle', [1, 10])
                ->where('qty_order', '>', 0)
                ->where('route2', '-C')
                ->leftJoin('pc_store_directs', 'upload_rekap_order_adm_p4_s.uniqNo', '=', 'pc_store_directs.job_no')
                    ->select(
                'upload_rekap_order_adm_p4_s.*',
                'pc_store_directs.strength',
                'pc_store_directs.qty_act' // 🟢 ambil qty_act
            )
                ->orderBy('type_pallet')
                ->get();

            return response()->json($subAssyData, 200, [], JSON_INVALID_UTF8_SUBSTITUTE);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getNutDataAdm()
    {
        try {
            $nutData = UploadRekapOrderAdmP4::whereIn('proses', ['NUT', 'FOAMING']) // ✅ Tambahkan FOAMING
                ->whereBetween('cycle', [1, 10])
                ->where('qty_order', '>', 0)
                ->where('route2', '-C')
                ->leftJoin('pc_store_directs', 'upload_rekap_order_adm_p4_s.uniqNo', '=', 'pc_store_directs.job_no')
                 ->select(
                'upload_rekap_order_adm_p4_s.*',
                'pc_store_directs.strength',
                'pc_store_directs.qty_act' // 🟢 ambil qty_act
            )
                ->orderBy('type_pallet')
                ->get();

            return response()->json($nutData, 200, [], JSON_INVALID_UTF8_SUBSTITUTE);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}


// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\UploadRekapOrderAdmP4;

// class DashbaordBoardAdmP4Controller extends Controller
// {
//     public function index()
//     {
//         $title = 'BOARD D26';

//         $pressData = UploadRekapOrderAdmP4::where('proses', 'PRESS')
//             ->whereBetween('cycle', [1, 10])
//             ->where('route2', '-C')
//             ->orderBy('type_pallet')
//             ->get();

//         $subAssy = UploadRekapOrderAdmP4::where('proses', 'SUB ASSY')
//             ->whereBetween('cycle', [1, 10])
//             ->where('route2', '-C')
//             ->orderBy('type_pallet')
//             ->get();

//         $nutData = UploadRekapOrderAdmP4::where('proses', 'NUT')
//             ->whereBetween('cycle', [1, 10])
//             ->where('route2', '-C')
//             ->orderBy('type_pallet')
//             ->get();

//         return view('ppic.boardadmp4', compact('title', 'pressData', 'subAssy', 'nutData'));
//     }

//     public function getPressDataAdm()
// {
//     try {
//         $today = now()->toDateString(); // 🗓️ Tanggal hari ini

//         $pressData = UploadRekapOrderAdmP4::where('proses', 'PRESS')
//             ->whereBetween('cycle', [1, 10])
//             ->where('qty_order', '>', 0)
//             ->where('route2', '-C')

//             ->whereDate('del_date', $today)  // ✅ Filter berdasarkan tanggal hari ini
//             ->leftJoin('pc_store_directs', 'upload_rekap_order_adm_p4_s.uniqNo', '=', 'pc_store_directs.job_no')
//             ->select(
//                 'upload_rekap_order_adm_p4_s.*',
//                 'pc_store_directs.strength as pc_strength',
//                 'pc_store_directs.qty_act as pc_qty_act'
//             )
//             ->orderBy('type_pallet')
//             ->get();

//         return response()->json($pressData, 200, [], JSON_INVALID_UTF8_SUBSTITUTE);
//     } catch (\Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }

// public function getSubassyDataAdm()
// {
//     try {
//         $today = now()->toDateString();

//         $subAssyData = UploadRekapOrderAdmP4::where('proses', 'SUB ASSY')
//             ->whereBetween('cycle', [1, 10])
//             ->where('qty_order', '>', 0)
//            ->where('route2', '-C')
//             ->whereDate('del_date', $today)
//             ->leftJoin('pc_store_directs', 'upload_rekap_order_adm_p4_s.uniqNo', '=', 'pc_store_directs.job_no')
//             ->select(
//                 'upload_rekap_order_adm_p4_s.*',
//                 'pc_store_directs.strength as pc_strength',
//                 'pc_store_directs.qty_act as pc_qty_act'
//             )
//             ->orderBy('type_pallet')
//             ->get();

//         return response()->json($subAssyData, 200, [], JSON_INVALID_UTF8_SUBSTITUTE);
//     } catch (\Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }

// public function getNutDataAdm()
// {
//     try {
//         $today = now()->toDateString();

//         $nutData = UploadRekapOrderAdmP4::whereIn('proses', ['NUT', 'FOAMING'])
//             ->whereBetween('cycle', [1, 10])
//             ->where('qty_order', '>', 0)
//            ->where('route2', '-C')
//             ->whereDate('del_date', $today)
//             ->leftJoin('pc_store_directs', 'upload_rekap_order_adm_p4_s.uniqNo', '=', 'pc_store_directs.job_no')
//             ->select(
//                 'upload_rekap_order_adm_p4_s.*',
//                 'pc_store_directs.strength as pc_strength',
//                 'pc_store_directs.qty_act as pc_qty_act'
//             )
//             ->orderBy('type_pallet')
//             ->get();

//         return response()->json($nutData, 200, [], JSON_INVALID_UTF8_SUBSTITUTE);
//     } catch (\Exception $e) {
//         return response()->json(['error' => $e->getMessage()], 500);
//     }
// }

// }
