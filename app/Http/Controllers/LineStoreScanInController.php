<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TraceAbility; 
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use App\Models\RmInMaterial;
use App\Models\DataModel;
use App\Models\LineStoreStok;
use App\Models\ScanOutStmp;
// use App\Models\PcStoreDirect;
use App\Models\ScanInLineStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class LineStoreScanInController extends Controller
{
    public function index(){
        $title = 'Scan IN Repair';
        return view('linestore.scanin',compact('title'));
    }

    // ScanOutStmpController.php
        public function check(Request $request)
        {
            $uniqNo = $request->uniqNo;

            $data = \DB::table('scan_out_stmps')->where('uniqNo', $uniqNo)->first();

            if ($data && $data->status != 2) {
                return response()->json(['status_valid' => false]);
            }

            return response()->json(['status_valid' => true]);
        }


        public function store(Request $request)
        {
            DB::beginTransaction();
        
            try {
                $validatedData = $request->validate([
                    'part_no2'      => 'required|string',
                    'part_no'       => 'required|string',
                    'job_no'        => 'required|string',
                    'model'         => 'required|string',
                    'qty'           => 'required|numeric', 
                    'date'          => 'required|string',
                    'uniqNo'        => 'required|string',
                    'kodeMaterial'  => 'required|string',
                    'id_data'       => 'required|numeric',
                    'qty_ng'        => 'nullable|numeric|min:0',
                    'ng_repair'     => 'nullable|numeric|min:0'
                ]);
        
                // 🚫 Cek data ganda
                if (ScanInLineStore::where('uniqNo', $request->uniqNo)->exists()) {
                    return response()->json([
                        'success'   => false,
                        'message'   => 'Data untuk kanban ini sudah ada',
                        'alertType' => 'info'
                    ]);
                }
        
                // ✅ Simpan ke ScanInLineStore
                $scanInLs = new ScanInLineStore();
                $scanInLs->uniqNo        = $request->input('uniqNo');
                $scanInLs->job_no        = $request->input('job_no');
                $scanInLs->part_no       = $request->input('part_no');
                $scanInLs->part_no2      = $request->input('part_no2');
                $scanInLs->qty_act       = $request->input('qty');
                $scanInLs->model         = $request->input('model');
                $scanInLs->kode_material = $request->input('kodeMaterial');
                $scanInLs->date          = $request->input('date');
                $scanInLs->id_data       = $request->input('id_data');
                $scanInLs->qty_ng        = $request->input('qty_ng');
                $scanInLs->ng_repair     = $request->input('ng_repair', 0); // ← masukin ng_repair juga
                $scanInLs->createdby     = auth()->user()->id;
                $scanInLs->updatedby     = auth()->user()->id;
                $scanInLs->save();
        
                // 🔄 Update ScanOutStmp
                $ScanOutStmp = ScanOutStmp::where('uniqNo', $request->uniqNo)->first();
                if ($ScanOutStmp) {
                    $inputQty = $request->input('qty');
                    $qtyAwal  = $ScanOutStmp->qty;
        
                    if ($ScanOutStmp->status == 1) {
                        DB::rollBack();
                        return response()->json([
                            'success'   => false,
                            'message'   => 'Label Tidak Melalui Repair',
                            'alertType' => 'error',
                        ]);
                    }
        
                    $ScanOutStmp->status     = 1;
                    $ScanOutStmp->qty_Act    = $inputQty;
                    $ScanOutStmp->ng_repair  = $request->input('ng_repair', max($qtyAwal - $inputQty, 0));
                    $ScanOutStmp->save();
                }
        
                // 📦 Update stok line_store_stoks
                $lineStoreItems = LineStoreStok::where('part_no2', $request->part_no)->get();
                if ($lineStoreItems->isNotEmpty()) {
                    foreach ($lineStoreItems as $item) {
                        $item->qty_actual += $request->qty; 
                        $item->save();
                    }
                }
        
                DB::commit();
        
                return response()->json([
                    'success'   => true, 
                    'message'   => 'Data has been saved successfully',
                    'alertType' => 'success'
                ]);
        
            } catch (ValidationException $e) {
                DB::rollBack();
        
                $message = collect($e->errors())->flatten()->first();
        
                return response()->json([
                    'success'   => false,
                    'message'   => 'Validation failed: ' . $message,
                    'alertType' => 'error'
                ], 422);
        
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success'   => false,
                    'message'   => 'An unexpected error occurred: ' . $e->getMessage(),
                    'alertType' => 'error'
                ], 500);
            }
        }
        
     
    
}
