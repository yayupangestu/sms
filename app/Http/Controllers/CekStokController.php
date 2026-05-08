<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\StrStokAtk;
use App\Models\StrStokRtk;
use App\Models\StrStokConsum;
use App\Models\StrStokGas;
use App\Models\StrStokTI;
use App\Models\StrBarang;
use App\Models\StrUom;
use App\Models\Str2StokAtk;
use App\Models\Str2StokRtk;
use App\Models\Str2StokConsum;
use DataTables;
use DB;


class CekStokController extends Controller
{
    public function checkStock()
    {


        $str_stok_atks = DB::table('master_list_strs as a')
            ->select('a.name')
            ->join('str_stok_atks as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();

        if ($str_stok_atks->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str_stok_atks
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Semua item memiliki stok Tersedia'
            ]);
        }
    }

    public function checkStock2()
    {


        $str_stok_rtks = DB::table('master_list_strs as a')
            ->select('a.name')
            ->join('str_stok_rtks as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();

        if ($str_stok_rtks->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str_stok_rtks
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Semua item memiliki stok Tersedia'
            ]);
        }
    }

    public function checkStock3()
    {
        $str_stok_consums = DB::table('master_list_strs as a')
            ->select('a.name')
            ->join('str_stok_consums as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();

        if ($str_stok_consums->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str_stok_consums
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Semua item memiliki stok Tersedia'
            ]);
        }
    }

    public function checkStock4()
    {
        $str_stok_gases = DB::table('master_list_strs as a')
            ->select('a.name')
            ->join('str_stok_gases as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();

        if ($str_stok_gases->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str_stok_gases
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Semua item memiliki stok Tersedia'
            ]);
        }
    }

    public function checkStock5()
    {
        $str_stok_tis = DB::table('master_list_strs as a')
            ->select('a.name')
            ->join('str_stok_tis as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();

        if ($str_stok_tis->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str_stok_tis
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Semua item memiliki stok Tersedia'
            ]);
        }
    }


    public function checkStock6()
    {
        $str_stok_cuptips = DB::table('master_list_strs as a')
            ->select('a.name')
            ->join('str_stok_cuptips as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();

        if ($str_stok_cuptips->count() > 0) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str_stok_cuptips
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Semua item memiliki stok Tersedia'
            ]);
        }
    }

    public function checkStock7()
    {
        $str2_stok_atks = DB::table('master_list_strs as a')
            ->select('a.name')
            ->join('str2_stok_atks as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();

        if ($str2_stok_atks) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str2_stok_atks
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Semua item memiliki stok Tersedia'
            ]);
        }
    }

    public function checkStock8()
    {
        $str2_stok_rtks = DB::table('master_list_strs as a')
            ->select('a.name')
            ->join('str2_stok_rtks as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();

        if ($str2_stok_rtks) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str2_stok_rtks
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Semua item memiliki stok Tersedia'
            ]);
        }
    }


    public function checkStock9()
    {
        $str2_stok_consums = DB::table('master_list_strs as a')
            ->select('a.name')
            ->join('str2_stok_consums as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();
        if ($str2_stok_consums) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str2_stok_consums
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'messange' => 'Semua item tersedia'
            ]);
        }
    }

    public function checkStock10()
    {
        $str2_stok_gases = DB::table('master_list_strs as a')
            ->select('a.name')
            ->join('str2_stok_gases as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();
        if ($str2_stok_gases) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str2_stok_gases
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'itemm ad'
            ]);
        }
    }

    public function checkStock11()
    {
        $str2_stok_tis = DB::table('master_list_strs as a')
            ->select('a.name')
            ->join('str2_stok_tis as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();
        if ($str2_stok_tis) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str2_stok_tis
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'itemm ad'
            ]);
        }
    }

    public function checkStockBecak()
    {
        $str_stok_becaks = DB::table('str_stok_becaks as a')
            ->select('a.name')
            ->join('str_stok_becaks as b', 'b.item_id', '=', 'a.id', 'left')
            ->where('b.actual', 0)
            ->get();
        if ($str_stok_becaks) {
            return response()->json([
                'status' => 'error',
                'message' => '',
                'items' => $str_stok_becaks
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'itemm ad'
            ]);
        }
    }



    public function alert1()
    {
        $posts = Post::latest()->paginate();

        return view('welcome', compact('posts'));
    }

    public function alert2(Request $request)
    {
        Post::create($request->all());
        Alert::success('Hore!', 'Post Created Successfully');
        return redirect()->back();
    }
}