<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScannedResult;
use App\Models\RmMaterial;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Scan2Controller extends Controller
{
    public function index()
    {
        $title = 'History';
        $rm_materials = RmMaterial::all();
        // Mengambil hasil scan terbaru terlebih dahulu
        $scanned_results = DB::table('scanned_results as a')
        ->select('a.id', 'a.result_text', 'a.created_at', 'a.status', 'b.name as created_by_name','c.name_material as material_id')
        ->join('users as b', 'b.id', '=', 'a.createdby')
        ->join('rm_materials as c', 'c.id', '=', 'a.material_id')
        ->orderBy('created_at', 'desc')
        ->get();
        $users = User::all();

      
        return view('rmmaterial.history', compact('title', 'scanned_results','rm_materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'result' => 'required|string',
            
        ]);

        // Simpan hasil scan ke dalam database
        $result = new ScannedResult();
        $result->result_text = $request->result;
        $result->status      = 'NOT-APPROVED';
        $result->material_id = $request->result;
        $result->createdby   = auth()->user()->id;
        $result->save();
        $scanned_results = ScannedResult::orderBy('created_at', 'desc')->get();

        // Kirim response
        return response()->json(['success' => true]);
    }

    public function approve(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:scanned_results,id', // Sesuaikan dengan nama tabel dan primary key Anda
            'material_id' => 'required|string|max:255',
            'qty_out' => 'required|integer|min:1', // Validasi quantity out
            'no' => 'required|integer|min:1', // Validasi quantity out
        ]);

        $item = ScannedResult::find($request->id);
        $item->status = 'APPROVED';
        $item->material_id = $request->material_id;
        $item->qty_out =    $request->qty_out;
        $item->no =    $request->no;
        $item->updated_by   = auth()->user()->id;
        // $item->updated_time   = auth()->user()->id;
        $item->save();

        return response()->json(['success' => true]);
    }

    public function detail($id)
    {
        // Query untuk mendapatkan detail item berdasarkan ID dengan join ke tabel users
        $item = DB::table('scanned_results as a')
            ->select('a.id', 'a.result_text', 'a.created_at', 'a.status','a.qty_out','a.material_id','b.name as createdby', 'a.updated_at', 'c.name as updated_by','f.name_material as material_id','a.no')
            ->join('users as b', 'b.id', '=', 'a.createdby')
            ->join('rm_materials as f', 'f.id', '=', 'a.material_id')
            ->leftJoin('users as c', 'c.id', '=', 'a.updated_by')
            ->where('a.id', $id)
            ->first(); // Menggunakan first() untuk mendapatkan satu hasil
    
        if ($item) {
            return response()->json($item);
        }
        return response()->json(['error' => 'Item not found'], 404);
    }
    
    
}

