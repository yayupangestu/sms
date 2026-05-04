<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class Dashboard2Controller extends Controller
{
        public function index()
        {
            $title = 'Dashboard';
           return view('dashboard.ppic2', compact('title'));
        }

    public function lineb3()
    {
        $row = DB::table('data_line_b3_s as a')
                ->select('a.model', 'b.part_no')
                ->join('data_model_b3_s as b', 'b.code', '=', 'a.model', 'left')
                ->orderBy('a.id', 'desc')
                ->first();
        $count = DB::table('data_line_b3_s')
                ->select(DB::raw('MAX(counter) as jml'), DB::raw('MAX(breakdown) as jml2'))
                ->first();

        if($row->model == 1){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_1) as jml'))
                    ->where('model', 1)
                    ->first();
        }else if($row->model == 2){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_2) as jml'))
                    ->where('model', 2)
                    ->first();
        }else if($row->model == 3){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_3) as jml'))
                    ->where('model', 3)
                    ->first();
        }else if($row->model == 4){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_4) as jml'))
                    ->where('model', 4)
                    ->first();
        }else if($row->model == 5){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_5) as jml'))
                    ->where('model', 5)
                    ->first();
        }else if($row->model == 6){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_6) as jml'))
                    ->where('model', 6)
                    ->first();
        }else if($row->model == 7){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_7) as jml'))
                    ->where('model', 7)
                    ->first();
        }else if($row->model == 8){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_8) as jml'))
                    ->where('model', 8)
                    ->first();
        }else if($row->model == 9){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_9) as jml'))
                    ->where('model', 9)
                    ->first();
        }else if($row->model == 10){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_10) as jml'))
                    ->where('model', 10)
                    ->first();
        }else if($row->model == 11){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_11) as jml'))
                    ->where('model', 11)
                    ->first();
        }else if($row->model == 12){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_12) as jml'))
                    ->where('model', 12)
                    ->first();
        }else if($row->model == 13){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_13) as jml'))
                    ->where('model', 13)
                    ->first();
        }else if($row->model == 14){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_14) as jml'))
                    ->where('model', 14)
                    ->first();
        }else if($row->model == 15){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_15) as jml'))
                    ->where('model', 15)
                    ->first();
        }else if($row->model == 16){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_16) as jml'))
                    ->where('model', 16)
                    ->first();
        }else if($row->model == 17){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_17) as jml'))
                    ->where('model', 17)
                    ->first();
        }else if($row->model == 18){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_18) as jml'))
                    ->where('model', 18)
                    ->first();
        }else if($row->model == 19){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_19) as jml'))
                    ->where('model', 19)
                    ->first();
        }else if($row->model == 20){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_20) as jml'))
                    ->where('model', 20)
                    ->first();
        }else if($row->model == 21){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_21) as jml'))
                    ->where('model', 21)
                    ->first();
        }else if($row->model == 22){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_22) as jml'))
                    ->where('model', 22)
                    ->first();
        }else if($row->model == 23){
            $row2 = DB::table('data_line_b3_s')
                    ->select(DB::raw('MAX(variant_23) as jml'))
                    ->where('model', 23)
                    ->first();
        }

        return response()->json([
            'strokeb3'      => $count->jml,
            'model'         => $row->part_no,
            'variant'       => $row2->jml,
            'breakdownb3'   => $count->jml2,
        ]);
    }

}
