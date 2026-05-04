<?php

namespace App\Http\Controllers;

use App\Models\TraceAbility; 
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use App\Models\RmInMaterial;
use App\Models\DataModel;
use Illuminate\Http\Request;
use DB;

class TraceAbilityController extends Controller
{
    public function index()
    {
        $title = 'Item IN';
        $rm_suppliers = RmSupplier::all();
        $data_models = DataModel::all();
        $rm_in_materials = RmInMaterial::all();
        $rm_materials = DB::table('rm_materials as a')
            ->select('a.name_material', 'a.spek', 'a.id', 'b.name as model', 'a.spek_l', 'a.spek_t', 'a.spek_p')
            ->join('data_models as b', 'b.id', '=', 'a.model', 'left')
            ->get();

        return view('rmmaterial.traceability', compact('title', 'rm_suppliers', 'rm_materials', 'rm_in_materials', 'data_models'));
    }

    // Fungsi untuk menyimpan data traceability
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'uniqNo' => 'required|string',
            'name_material' => 'required|string',
            'spek' => 'required|string',
            'suplier' => 'required|string',
            'qty_out' => 'required|string',
        ]);

        // Simpan data ke database
        $traceAbility = new TraceAbility();
        $traceAbility->uniqNo = $request->input('uniqNo');
        $traceAbility->name_material = $request->input('name_material');
        $traceAbility->spek = $request->input('spek');
        $traceAbility->suplier = $request->input('suplier');
        $traceAbility->qty_out = $request->input('qty_out');
        $traceAbility->save();

        return response()->json(['success' => true, 'message' => 'Data saved successfully']);
    }

    public function store2(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'uniqNo2' => 'required|string',
            'name_material2' => 'required|string',
            'spek2' => 'required|string',
            'suplier' => 'required|string',
            'qty_out' => 'required|string',       // Uncomment if required
        ]);
    
        // Store the validated data in the database
        $traceAbility = new TraceAbility();
        $traceAbility->uniqNo2= $request->input('uniqNo2');
        $traceAbility->name_material2 = $request->input('name_material2');  // Uncomment if required
        $traceAbility->spek2= $request->input('spek2');                    // Uncomment if required
        $traceAbility->suplier2 = $request->input('suplier2');              // Uncomment if required
        $traceAbility->qty_out2 = $request->input('qty_out2');              // Uncomment if required
        $traceAbility->save();
    
        return response()->json(['success' => true, 'message' => 'Data saved successfully']);
    }
    
    public function getAbilityData($uniqNo)
    {
        $ability = TraceAbility::where('uniqNo', $uniqNo)->first();
    
        if ($ability) {
            return response()->json(['ability' => $ability]);
        } else {
            return response()->json(['error' => 'Data not found'], 404);
        }
    }

    public function getDetails($uniqNo)
{
    $ability = Ability::where('uniqNo', $uniqNo)->first();

    if ($ability) {
        return view('abilities.details', compact('ability')); // Return view partial atau HTML
    } else {
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }
}

}
