<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StrBarang;
use App\Models\StrUom;
use DataTables;
use DB;

class Str2KanbanController extends Controller
{
    public function index()
    {
        $title = 'Kanban ASI 2 ';
        $users = User::all();
        $str_barangs = StrBarang::all();
        $str_uoms = StrUom::all();
        $str2_out2s = DB::table('str2_out2s as a')
                    ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
                    ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
                    ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
                    ->get();
        $str2_out2s = [
            'status1' => $str2_out2s->where('status', 1),
            'status2' => $str2_out2s->where('status', 2)
        ];

        $str2_out3s = DB::table('str2_out3s as a')
                    ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
                    ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
                    ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
                    ->get();
        $str2_out3s = [
            'status3' => $str2_out3s->where('status', 1),
            'status4' => $str2_out3s->where('status', 2)
        ];

        $str2_out8s = DB::table('str2_out8s as a')
                    ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
                    ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
                    ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
                    ->get();
        $str2_out8s = [
        'status5' => $str2_out8s->where('status', 1),
        'status6' => $str2_out8s->where('status', 2)
        ];

        $str2_out9s = DB::table('str2_out9s as a')
                    ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
                    ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
                    ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
                    ->get();
        $str2_out9s = [
        'status7' => $str2_out9s->where('status', 1),
        'status8' => $str2_out9s->where('status', 2)
        ];       
        
        $str2_out10s = DB::table('str2_out10s as a')
                    ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
                    ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
                    ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
                    ->get();
        $str2_out10s = [
        'status9' => $str2_out10s->where('status', 1),
        'status10' => $str2_out10s->where('status', 2)
        ];       

        $str2_out11s = DB::table('str2_out11s as a')
                    ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
                    ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
                    ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
                    ->get();
        $str2_out11s = [
        'status11' => $str2_out11s->where('status', 1),
        'status12' => $str2_out11s->where('status', 2)
        ];       

         $str2_out12s = DB::table('str2_out12s as a')
                    ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
                    ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
                    ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
                    ->get();
        $str2_out12s = [
        'status13' => $str2_out12s->where('status', 1),
        'status14' => $str2_out12s->where('status', 2)
        ];       

         $str2_out13s = DB::table('str2_out13s as a')
                    ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
                    ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
                    ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
                    ->get();
        $str2_out13s = [
        'status15' => $str2_out13s->where('status', 1),
        'status16' => $str2_out13s->where('status', 2)
        ];    
        
        $str2_out14s = DB::table('str2_out14s as a')
                    ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
                    ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
                    ->whereIn('status', [1, 2]) // Filter data dengan status 1 dan 2 saja
                    ->get();
        $str2_out14s = [
        'status17' => $str2_out14s->where('status', 1),
        'status18' => $str2_out14s->where('status', 2)
        ];    
        return view('dashboard.kanbanasi2', compact('title', 'users', 'str_uoms','str2_out2s','str2_out3s','str2_out8s','str2_out9s','str2_out10s','str2_out11s','str2_out12s','str2_out13s','str2_out14s'));
    }

  // Controller
  public function getDetails(Request $request)
  {
      $docNo = $request->input('doc_no');
      
        $query1 = DB::table('str2_out2s as a')
                  ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
                  ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
                  ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
                  ->where('doc_no', $docNo);
  
        $query2 = DB::table('str2_out3s as a')
                  ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
                  ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
                  ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
                  ->where('doc_no', $docNo);
      
        $query3 = DB::table('str2_out8s as a')
                  ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
                  ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
                  ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
                  ->where('doc_no', $docNo);
    
        $query4 = DB::table('str2_out9s as a')
                  ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
                  ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
                  ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
                  ->where('doc_no', $docNo);

        $query5 = DB::table('str2_out10s as a')
                  ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
                  ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
                  ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
                  ->where('doc_no', $docNo);

         $query6 = DB::table('str2_out11s as a')
                  ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
                  ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
                  ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
                  ->where('doc_no', $docNo);

         $query7 = DB::table('str2_out12s as a')
                  ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
                  ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
                  ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
                  ->where('doc_no', $docNo);
        
         $query8 = DB::table('str2_out13s as a')
                  ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
                  ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
                  ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
                  ->where('doc_no', $docNo);

         $query9 = DB::table('str2_out14s as a')
                  ->select('b.name as item_id', 'a.w_diberi', 'a.qty_request', 'c.name as satuan')
                  ->join('str_barangs as b', 'b.id', '=', 'a.item_id')
                  ->join('str_uoms as c', 'c.id', '=', 'a.satuan')
                  ->where('doc_no', $docNo);
      
      // Gabungkan hasil query
      $docDetails = $query1->union($query2)->union($query3)->union($query4)->union($query5)->union($query6)->union($query7)->union($query8)->union($query9)->get();
      
      return response()->json($docDetails);
  }


public function getNewData()
{
    // Fetch data from str_out2s
    $str2_out2s = DB::table('str2_out2s as a')
        ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
        ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
        ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
        ->get();

    // Organize str2_out2s data into status groups
    $str2_out2s = [
        'status1' => $str2_out2s->where('status', 1)->values(),
        'status2' => $str2_out2s->where('status', 2)->values(),
    ];

    // Fetch data from str_out3s
    $str2_out3s = DB::table('str2_out3s as a')
        ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
        ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
        ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
        ->get();

    // Organize str2_out3s data into status groups
    $str2_out3s = [
        'status3' => $str2_out3s->where('status', 1)->values(),
        'status4' => $str2_out3s->where('status', 2)->values(),
    ];

    // Fetch data from str_out3s
    $str2_out8s = DB::table('str2_out8s as a')
        ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
        ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
        ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
        ->get();

    // Organize str_out3s data into status groups
    $str2_out8s = [
        'status5' => $str2_out8s->where('status', 1)->values(),
        'status6' => $str2_out8s->where('status', 2)->values(),
    ];

       // Fetch data from str_out3s
    $str2_out9s = DB::table('str2_out9s as a')
       ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
       ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
       ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
       ->get();

   // Organize str_out3s data into status groups
   $str2_out9s = [
       'status7' => $str2_out9s->where('status', 1)->values(),
       'status8' => $str2_out9s->where('status', 2)->values(),
   ];

        // Fetch data from str_out3s
    $str2_out10s = DB::table('str2_out10s as a')
       ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
       ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
       ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
       ->get();

   // Organize str_out3s data into status groups
   $str2_out10s = [
       'status9' => $str2_out10s->where('status', 1)->values(),
       'status10' => $str2_out10s->where('status', 2)->values(),
   ];

    // Fetch data from str_out3s
    $str2_out11s = DB::table('str2_out11s as a')
       ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
       ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
       ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
       ->get();

   // Organize str_out3s data into status groups
   $str2_out11s = [
       'status11' => $str2_out11s->where('status', 1)->values(),
       'status12' => $str2_out11s->where('status', 2)->values(),
   ];

    // Fetch data from str_out3s
    $str2_out12s = DB::table('str2_out12s as a')
       ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
       ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
       ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
       ->get();

   // Organize str_out3s data into status groups
   $str2_out12s = [
       'status13' => $str2_out12s->where('status', 1)->values(),
       'status14' => $str2_out12s->where('status', 2)->values(),
   ];

    // Fetch data from str_out3s
    $str2_out13s = DB::table('str2_out13s as a')
       ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
       ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
       ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
       ->get();

   // Organize str_out3s data into status groups
   $str2_out13s = [
       'status15' => $str2_out13s->where('status', 1)->values(),
       'status16' => $str2_out13s->where('status', 2)->values(),
   ];

    // Fetch data from str_out3s
    $str2_out14s = DB::table('str2_out14s as a')
       ->select('a.doc_no', 'a.status', 'a.w_diberi', 'b.name as createdby')
       ->join('users as b', 'b.id', '=', 'a.createdby', 'left')
       ->whereIn('status', [1, 2]) // Filter data with status 1 and 2
       ->get();

   // Organize str_out3s data into status groups
   $str2_out14s = [
       'status17' => $str2_out14s->where('status', 1)->values(),
       'status18' => $str2_out14s->where('status', 2)->values(),
   ];
   

    
    // Combine both datasets into one response
    return response()->json([
        'str2_out2s' => $str2_out2s,
        'str2_out3s' => $str2_out3s,
        'str2_out8s' => $str2_out8s,
        'str2_out9s' => $str2_out9s,
        'str2_out10s' => $str2_out10s,
        'str2_out11s' => $str2_out11s,
        'str2_out12s' => $str2_out12s,
        'str2_out13s' => $str2_out13s,
        'str2_out14s' => $str2_out14s,
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

}
