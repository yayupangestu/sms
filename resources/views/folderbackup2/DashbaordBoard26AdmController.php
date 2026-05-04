<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadRekapOrderAdm;


class DashbaordBoard26AdmController extends Controller
{
    public function index()
    {
        $title = 'BOARD D26';
    
        $pressData = UploadRekapOrderAdm::where('proses', 'PRESS')
            ->whereBetween('cycle', [1, 9])
            ->where('route2', 'K1') // 🔑 filter route2
            ->orderBy('type_pallet')
            ->get();
    
        $subAssy = UploadRekapOrderAdm::where('proses', 'SUB ASSY')
            ->whereBetween('cycle', [1, 9])
            ->where('route2', 'K1') // 🔑 filter route2
            ->orderBy('type_pallet')
            ->get();

        $nutData = UploadRekapOrderAdm::where('proses', 'NUT')
            ->whereBetween('cycle', [1, 9])
            ->where('route2', 'K1') // 🔑 filter route2
            ->orderBy('type_pallet')
            ->get();

        return view('ppic.boardd26adm', compact('title', 'pressData','subAssy','nutData'));
    }

    public function getPressDataAdm()
    {
        $pressData = UploadRekapOrderAdm::where('proses', 'PRESS')
            ->whereBetween('cycle', [1, 9])
            ->where('qty_order', '>', 0)
            ->where('route2', 'K1') // 🔑 filter route2
            ->leftJoin('pc_store_directs', 'upload_rekap_order_adms.uniqNo', '=', 'pc_store_directs.job_no')
            ->select('upload_rekap_order_adms.*', 'pc_store_directs.strength')
            ->orderBy('type_pallet')
            ->get();   

        return response()->json($pressData);
    }

    public function getSubassyDataAdm()
    {
        $subAssy = UploadRekapOrderAdm::where('proses', 'SUB ASSY')
            ->whereBetween('cycle', [1, 9])
            ->where('qty_order', '>', 0)
            ->where('route2', 'K1') // 🔑 filter route2
            ->leftJoin('pc_store_directs', 'upload_rekap_order_adms.uniqNo', '=', 'pc_store_directs.job_no')
            ->select('upload_rekap_order_adms.*', 'pc_store_directs.strength')
            ->orderBy('type_pallet')
            ->get();    

        return response()->json($subAssy);
    }

    public function getNutDataAdm()
    {
        $nutData = UploadRekapOrderAdm::where('proses', 'NUT')
            ->whereBetween('cycle', [1, 9])
            ->where('qty_order', '>', 0)
            ->where('route2', 'K1') // 🔑 filter route2
            ->leftJoin('pc_store_directs', 'upload_rekap_order_adms.uniqNo', '=', 'pc_store_directs.job_no')
            ->select('upload_rekap_order_adms.*', 'pc_store_directs.strength')
            ->orderBy('type_pallet')
            ->get();    

        return response()->json($nutData);
    }
}
  
