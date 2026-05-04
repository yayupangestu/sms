<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PcStoreDirect;
use App\Models\TagLabelWelding;

class DshStokD26AdmController extends Controller
{
    public function index()
    {
        $title = 'Stok D26';
        return view('dashboard2.stokd26adm', compact('title'));
    }

    // // Data utama PcStoreDirect
    // public function getData()
    // {
    //     $data = PcStoreDirect::where('model', 'D26 TMMIN')
    //                 ->latest()
    //                 ->take(50)
    //                 ->get();

    //     return response()->json($data);
    // }

    // Data utama PcStoreDirect
    public function getDataAdm()
    {
        $data = PcStoreDirect::whereIn('model', ['D26 ADM', 'D55', 'D30', 'D26 ADM', 'D74', 'D40',])
                    ->where('monthly_volume','>', 0)
                    ->latest()
                    // ->take(100)
                    ->get();

        return response()->json($data);
    }


   // Data untuk sidebar Transit (ScanOutWelding)
public function getDataAdm2()
{
    // Ambil data dari tag_label_weldings dengan filter sts NULL atau 0
    $data = TagLabelWelding::where(function ($q) {
            $q->whereNull('sts')
              ->orWhere('sts', 0);
        })
        ->latest()
        ->take(50)
        ->get()
        ->map(function ($item) {
            return [
                'job_no'  => $item->job_no,
                'part_no' => $item->part_no,
                'qty_act' => $item->qty_act,
                'uniqNo' => $item->uniqNo,
                 'created_at' => $item->created_at,
            ];
        });

    return response()->json($data);
}

}
