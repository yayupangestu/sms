<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StrBarang;
use App\Models\StrUom;
use DataTables;
use DB;

class StrKanban2Controller extends Controller
{
    public function index()
    {
        $title = 'Kanban 1';
        $users = User::all();
        $str_barangs = StrBarang::all();
        $str_uoms = StrUom::all();
        $str_out2s = DB::table('str_out2s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out2s = [
            'status1' => $str_out2s->where('status', 1),
            'status2' => $str_out2s->where('status', 2)
        ];

        $str_out3s = DB::table('str_out3s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out3s = [
            'status3' => $str_out3s->where('status', 1),
            'status4' => $str_out3s->where('status', 2)
        ];

        $str_out4s = DB::table('str_out4s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out4s = [
            'status5' => $str_out4s->where('status', 1),
            'status6' => $str_out4s->where('status', 2)
        ];

        $str_out5s = DB::table('str_out5s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out5s = [
            'status7' => $str_out5s->where('status', 1),
            'status8' => $str_out5s->where('status', 2)
        ];

        $str_out6s = DB::table('str_out6s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out6s = [
            'status9' => $str_out6s->where('status', 1),
            'status10' => $str_out6s->where('status', 2)
        ];

        $str_out7s = DB::table('str_out7s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out7s = [
            'status11' => $str_out7s->where('status', 1),
            'status12' => $str_out7s->where('status', 2)
        ];

        $str_out8s = DB::table('str_out8s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out8s = [
            'status13' => $str_out8s->where('status', 1),
            'status14' => $str_out8s->where('status', 2)
        ];

        $str_out9s = DB::table('str_out9s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out9s = [
            'status15' => $str_out9s->where('status', 1),
            'status16' => $str_out9s->where('status', 2)
        ];

        $str_out11s = DB::table('str_out11s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out11s = [
            'status17' => $str_out11s->where('status', 1),
            'status18' => $str_out11s->where('status', 2)
        ];

        $str_out10s = DB::table('str_out10s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out10s = [
            'status19' => $str_out10s->where('status', 1),
            'status20' => $str_out10s->where('status', 2)
        ];

        $str_out12s = DB::table('str_out12s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out12s = [
            'status21' => $str_out12s->where('status', 1),
            'status22' => $str_out12s->where('status', 2)
        ];

        $str_out13s = DB::table('str_out13s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out13s = [
            'status23' => $str_out13s->where('status', 1),
            'status24' => $str_out13s->where('status', 2)
        ];

        $str_out14s = DB::table('str_out14s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out14s = [
            'status25' => $str_out14s->where('status', 1),
            'status26' => $str_out14s->where('status', 2)
        ];


        $str_out15s = DB::table('str_out15s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out15s = [
            'status27' => $str_out15s->where('status', 1),
            'status28' => $str_out15s->where('status', 2)
        ];

        $str_out16s = DB::table('str_out16s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out16s = [
            'status29' => $str_out16s->where('status', 1),
            'status30' => $str_out16s->where('status', 2)
        ];

        $str_out17s = DB::table('str_out17s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
            ->get();
        $str_out17s = [
            'status31' => $str_out17s->where('status', 1),
            'status32' => $str_out17s->where('status', 2)
        ];


        return view('storedashboard.kanban2', compact('title', 'str_out2s', 'users', 'str_uoms', 'str_out3s', 'str_out4s', 'str_out5s', 'str_out6s', 'str_out7s', 'str_out8s', 'str_out9s', 'str_out11s', 'str_out10s', 'str_out12s', 'str_out13s', 'str_out14s', 'str_out15s', 'str_out16s', 'str_out17s'));
    }

    // Controller
    public function getDetails(Request $request)
    {
        $docNo = $request->input('doc_no');

        $query1 = DB::table('str_out2s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query2 = DB::table('str_out3s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query3 = DB::table('str_out4s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query4 = DB::table('str_out5s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query5 = DB::table('str_out6s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query6 = DB::table('str_out7s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query7 = DB::table('str_out8s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query8 = DB::table('str_out9s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query9 = DB::table('str_out11s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query10 = DB::table('str_out10s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query11 = DB::table('str_out12s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query12 = DB::table('str_out13s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query13 = DB::table('str_out14s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);


        $query14 = DB::table('str_out15s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query15 = DB::table('str_out16s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        $query16 = DB::table('str_out17s as a')
            ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
            ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
            ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
            ->where('doc_no', $docNo);

        // Gabungkan hasil query
        $docDetails = $query1->union($query2)->union($query3)->union($query4)->union($query5)->union($query6)->union($query7)->union($query8)->union($query9)->union($query10)->union($query11)->union($query12)->union($query13)->union($query14)->union($query15)->union($query15)->get();

        return response()->json($docDetails);
    }


    public function getNewData()
    {
        // Fetch data from str_out2s
        $str_out2s = DB::table('str_out2s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out2s data into status groups
        $str_out2s = [
            'status1' => $str_out2s->where('status', 1)->values(),
            'status2' => $str_out2s->where('status', 2)->values(),
        ];

        // Fetch data from str_out3s
        $str_out3s = DB::table('str_out3s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out3s = [
            'status3' => $str_out3s->where('status', 1)->values(),
            'status4' => $str_out3s->where('status', 2)->values(),
        ];

        // Fetch data from str_out3s
        $str_out4s = DB::table('str_out4s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out4s = [
            'status5' => $str_out4s->where('status', 1)->values(),
            'status6' => $str_out4s->where('status', 2)->values(),
        ];

        // Fetch data from str_out3s
        $str_out5s = DB::table('str_out5s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out5s = [
            'status7' => $str_out5s->where('status', 1)->values(),
            'status8' => $str_out5s->where('status', 2)->values(),
        ];

        // Fetch data from str_out3s
        $str_out6s = DB::table('str_out6s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out6s = [
            'status9' => $str_out6s->where('status', 1)->values(),
            'status10' => $str_out6s->where('status', 2)->values(),
        ];

        // Fetch data from str_out3s
        $str_out7s = DB::table('str_out7s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out7s = [
            'status11' => $str_out7s->where('status', 1)->values(),
            'status12' => $str_out7s->where('status', 2)->values(),
        ];

        // Fetch data from str_out3s
        $str_out8s = DB::table('str_out8s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out8s = [
            'status13' => $str_out8s->where('status', 1)->values(),
            'status14' => $str_out8s->where('status', 2)->values(),
        ];

        $str_out9s = DB::table('str_out9s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out9s = [
            'status15' => $str_out9s->where('status', 1)->values(),
            'status16' => $str_out9s->where('status', 2)->values(),
        ];


        $str_out11s = DB::table('str_out11s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out11s = [
            'status17' => $str_out11s->where('status', 1)->values(),
            'status18' => $str_out11s->where('status', 2)->values(),
        ];

        $str_out10s = DB::table('str_out10s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out10s = [
            'status19' => $str_out10s->where('status', 1)->values(),
            'status20' => $str_out10s->where('status', 2)->values(),
        ];



        $str_out12s = DB::table('str_out12s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out12s = [
            'status21' => $str_out12s->where('status', 1)->values(),
            'status22' => $str_out12s->where('status', 2)->values(),
        ];

        $str_out13s = DB::table('str_out13s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out13s = [
            'status23' => $str_out13s->where('status', 1)->values(),
            'status24' => $str_out13s->where('status', 2)->values(),
        ];

        $str_out14s = DB::table('str_out14s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out14s = [
            'status25' => $str_out14s->where('status', 1)->values(),
            'status26' => $str_out14s->where('status', 2)->values(),
        ];

        $str_out15s = DB::table('str_out15s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out15s = [
            'status27' => $str_out15s->where('status', 1)->values(),
            'status28' => $str_out15s->where('status', 2)->values(),
        ];

        $str_out16s = DB::table('str_out16s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out16s = [
            'status29' => $str_out16s->where('status', 1)->values(),
            'status30' => $str_out16s->where('status', 2)->values(),
        ];

        $str_out17s = DB::table('str_out17s as a')
            ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
            ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
            ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
            ->get();

        // Organize str_out3s data into status groups
        $str_out17s = [
            'status31' => $str_out17s->where('status', 1)->values(),
            'status32' => $str_out17s->where('status', 2)->values(),
        ];

        // Combine both datasets into one response
        return response()->json([
            'str_out2s' => $str_out2s,
            'str_out3s' => $str_out3s,
            'str_out4s' => $str_out4s,
            'str_out5s' => $str_out5s,
            'str_out6s' => $str_out6s,
            'str_out7s' => $str_out7s,
            'str_out8s' => $str_out8s,
            'str_out9s' => $str_out9s,
            'str_out11s' => $str_out11s,
            'str_out10s' => $str_out10s,
            'str_out12s' => $str_out12s,
            'str_out13s' => $str_out13s,
            'str_out14s' => $str_out14s,
            'str_out15s' => $str_out15s,
            'str_out16s' => $str_out16s,
            'str_out17s' => $str_out17s,
        ]);
    }


    public function fetchLatestData()
    {
        $latestData = DB::table('str_out2s')->orderBy('created_at', 'desc')->first();
        return response()->json($latestData);
    }


    public function listdetail(Request $request)
    {
        $query = DB::table('str_out2s as a')
            ->select('a.id', 'c.name', 'a.qty_return', 'a.qty_standing', 'a.qty_request', 'a.keterangan', 'd.name as satuan', 'e.description as line_id', 's.username as createdby')
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

}
