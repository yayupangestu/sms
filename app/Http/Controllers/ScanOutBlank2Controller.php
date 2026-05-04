<?php

namespace App\Http\Controllers;

use App\Models\TraceAbility;
use Illuminate\Http\Request;
use App\Models\RmStok;
use App\Models\ScanOutRm;
use App\Models\User;
use App\Models\RmInMaterial;
use App\Models\ScanInLabel;
use App\Models\PlanningLineB3;
use App\Models\RmReturnMaterial;
use Carbon\Carbon;
use App\Models\TabelTransitMaterial;
use App\Models\TabelStokBlank;
use DB;
use App\Models\TagLabel3;

class ScanOutBlank2Controller extends Controller
{
    public function index()
    {
        $title = 'Scan Out RM';
        return view('blank.scanout2', compact('title'));
    }
    
    public function checkPartInLine(Request $request)
    {
        $partNo = $request->input('part_no');
    
        // Cek apakah ada part_no dengan sts = 1 atau NULL
        $exists = DB::table('tabel_transit_materials')
            ->where('part_no', $partNo)
            ->where(function ($query) {
                $query->where('sts', 1)
                      ->orWhereNull('sts');
            })
            ->exists();
    
        if ($exists) {
            return response()->json([
                'exists' => true,
                'message' => 'Part tersedia di tabel transit (sts = 1 atau null).',
            ]);
        } else {
            return response()->json([
                'exists' => false,
                'message' => 'Part tidak ditemukan di tabel transit.',
            ]);
        }
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction(); // Mulai transaksi
    
        try {
            $request->validate([
                'part_no' => 'required|string',
                'spec' => 'required|string',
                'supplier' => 'required|string',
                'uniqNo' => 'required|string|nullable',
                'id_data' => 'required|string',
                'id' => 'required|string',
                'qty_out_kg' => 'required|numeric',
                'qty_out_sheet' => 'required|numeric',
            ]);


            $existingTag = TagLabel3::where('uniqNo', $request->input('uniqNo'))->first();
            if ($existingTag && $existingTag->sts == 1) {
                return response()->json([
                    'success' => false, // tetap false agar frontend tahu tidak lanjut
                    'type' => 'info',   // tambahkan jenis alert
                    'message' => 'Scan ditolak: Material ini sudah discan sebelumnya.'
                ], 200); // gunakan 200 OK
            }
            

            $uniqNo = $request->input('uniqNo');


            $partNo = $request->input('part_no');
            $mesinPlanning = PlanningLineB3::where('part_no', $partNo)
            ->whereNotNull('mesin')
            ->orderByDesc('created_at')
            ->value('mesin');

            $planningLine = PlanningLineB3::where('part_no', $partNo)
            // ->whereDate('date_plan', now()->toDateString())
            ->first();
        
        $qty_out_sheet = $request->input('qty_out_sheet');
        
       
    
            
            $forceNew = $request->input('forceNew', false);
            if ($forceNew) {
                $TabelTransitMaterial = new TabelTransitMaterial();
                $TabelTransitMaterial->part_no = $partNo;
                $TabelTransitMaterial->spec = $request->input('spec');
                $TabelTransitMaterial->uniqNo = $request->input('uniqNo');
                $TabelTransitMaterial->supplier = $request->input('supplier');
                $TabelTransitMaterial->id_data = $request->input('id_data');
                $TabelTransitMaterial->qty_out_kg = $request->input('qty_out_kg');
                $TabelTransitMaterial->qty_out_sheet = $qty_out_sheet;
                $TabelTransitMaterial->qty_stamping = $qty_out_sheet;
                $TabelTransitMaterial->createdby = auth()->user()->username;
                $TabelTransitMaterial->updatedby = auth()->user()->username;
                $TabelTransitMaterial->mesin = $mesinPlanning;
                $TabelTransitMaterial->sts = 1;
                $TabelTransitMaterial->sts_proses = 1;
                $TabelTransitMaterial->created_at = now();
                $TabelTransitMaterial->save();
            } else {
                $TabelTransitMaterial = TabelTransitMaterial::where('uniqNo', $request->input('uniqNo'))
                    ->where('part_no', $partNo)
                    ->whereDate('created_at', now()->toDateString())
                    ->first();
    
                if (!$TabelTransitMaterial) {
                    $TabelTransitMaterial = new TabelTransitMaterial();
                    $TabelTransitMaterial->part_no = $partNo;
                    $TabelTransitMaterial->spec = $request->input('spec');
                    $TabelTransitMaterial->uniqNo = $request->input('uniqNo');
                    $TabelTransitMaterial->supplier = $request->input('supplier');
                    $TabelTransitMaterial->id_data = $request->input('id_data');
                    $TabelTransitMaterial->qty_out_kg = $request->input('qty_out_kg');
                    $TabelTransitMaterial->qty_out_sheet = $qty_out_sheet;
                    $TabelTransitMaterial->qty_stamping = $qty_out_sheet;
                    $TabelTransitMaterial->mesin = $mesinPlanning;
                    $TabelTransitMaterial->sts = 1;
                    $TabelTransitMaterial->sts_proses = 1;
                    $TabelTransitMaterial->createdby = auth()->user()->username;
                    $TabelTransitMaterial->updatedby = auth()->user()->username;
                    $TabelTransitMaterial->created_at = now();
                } else {
                    $TabelTransitMaterial->qty_out_sheet += $qty_out_sheet;
                    $TabelTransitMaterial->qty_out_kg += $request->input('qty_out_kg');
                    $TabelTransitMaterial->updatedby = auth()->user()->username;
                }
    
                $TabelTransitMaterial->save();
            }
    

            // Update rm_stoks
            $TabelStokBlank = TabelStokBlank::where('part_no', $request->part_no)->get();

            if ($TabelStokBlank->isNotEmpty()) {
                foreach ($TabelStokBlank as $stok) {
                    // kurangi jumlah qyt_kanban , tapi jangan sampe minus
                    $stok->qty_kanban = max(0, $stok->qty_kanban - $request->qty_out_sheet);

                    // man nak update yang laen dari sini be
                    // $stok->actual_kg += $request->actual_kg;

                    $stok->save();
                }
            }

            
            $TagLabel3 = TagLabel3::where('uniqNo', $request->input('uniqNo'))->first();
            if ($TagLabel3) {
                 $TagLabel3->sts = 1;
                 $TagLabel3->save();
     }

    
    
            DB::table('tabel_transit_materials')
            ->where('uniqNo', $request->input('uniqNo'))
            ->update(['rm_out' => auth()->user()->username]);

            $now = Carbon::now();

            if ($now->hour < 7) {
                // Shift masih termasuk hari sebelumnya
                $startTime = Carbon::yesterday()->setHour(7)->setMinute(0)->setSecond(0);
                $endTime   = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
            } else {
                // Hari produksi berjalan normal
                $startTime = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
                $endTime   = Carbon::tomorrow()->setHour(7)->setMinute(0)->setSecond(0);
            }
            
                        $planningLines = PlanningLineB3::where('part_no', $partNo)
                ->whereBetween('created_at', [$startTime, $endTime])
                ->where(function ($query) {
                    $query->whereNull('status_proses')
                        ->orWhere('status_proses', '!=', 3);
                })                
                ->latest('created_at')
                ->get();
    
        
            if ($planningLines->isEmpty()) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Data has been saved, but not recorded in planning_line_b3s because part_no was not found'
                ]);
            }
            

        foreach ($planningLines as $PlanningLineB3) {
            $PlanningLineB3->qty_out_material += $qty_out_sheet;

            if ($PlanningLineB3->qty_out_material > 0) {
                $PlanningLineB3->status = 1;
                $PlanningLineB3->status_proses = 1;
            }
            

            if (empty($PlanningLineB3->rm_qty) && empty($PlanningLineB3->rm_partNo) && empty($PlanningLineB3->rm_spek)) {
                $PlanningLineB3->rm_qty = $qty_out_sheet;
                $PlanningLineB3->rm_qty_kode = $qty_out_sheet;
                $PlanningLineB3->rm_partNo = $partNo;
                $PlanningLineB3->rm_spek = $request->input('spec');
                $PlanningLineB3->rm_supplier = $request->input('supplier');
                $PlanningLineB3->rm_uniqNo = $request->input('uniqNo');
                $PlanningLineB3->rm_user = auth()->user()->username;
                $PlanningLineB3->rm_time = now();
            } else if (empty($PlanningLineB3->rm_qty2) && empty($PlanningLineB3->rm_partNo2) && empty($PlanningLineB3->rm_spek2)) {
                $PlanningLineB3->rm_qty2 = $qty_out_sheet;
                $PlanningLineB3->rm_qty_kode2 = $qty_out_sheet;
                $PlanningLineB3->rm_partNo2 = $partNo;
                $PlanningLineB3->rm_spek2 = $request->input('spec');
                $PlanningLineB3->rm_supplier2 = $request->input('supplier');
                $PlanningLineB3->rm_uniqNo2 = $request->input('uniqNo');
                $PlanningLineB3->rm_user2 = auth()->user()->username;
                $PlanningLineB3->rm_time2 = now();
            } else if (empty($PlanningLineB3->rm_qty3) && empty($PlanningLineB3->rm_partNo3) && empty($PlanningLineB3->rm_spek3)) {
                $PlanningLineB3->rm_qty3 = $qty_out_sheet;
                $PlanningLineB3->rm_qty_kode3 = $qty_out_sheet;
                $PlanningLineB3->rm_partNo3 = $partNo;
                $PlanningLineB3->rm_spek3 = $request->input('spec');
                $PlanningLineB3->rm_supplier3 = $request->input('supplier');
                $PlanningLineB3->rm_uniqNo3 = $request->input('uniqNo');
                $PlanningLineB3->rm_user3 = auth()->user()->username;
                $PlanningLineB3->rm_time3 = now();
            } else if (empty($PlanningLineB3->rm_qty4) && empty($PlanningLineB3->rm_partNo4) && empty($PlanningLineB3->rm_spek4)) {
                $PlanningLineB3->rm_qty4 = $qty_out_sheet;
                $PlanningLineB3->rm_qty_kode4 = $qty_out_sheet;
                $PlanningLineB3->rm_partNo4 = $partNo;
                $PlanningLineB3->rm_spek4 = $request->input('spec');
                $PlanningLineB3->rm_supplier4 = $request->input('supplier');
                $PlanningLineB3->rm_uniqNo4 = $request->input('uniqNo');
                $PlanningLineB3->rm_user4 = auth()->user()->username;
                $PlanningLineB3->rm_time4 = now();
            } else if (empty($PlanningLineB3->rm_qty5) && empty($PlanningLineB3->rm_partNo5) && empty($PlanningLineB3->rm_spek5)) {
                $PlanningLineB3->rm_qty5 = $qty_out_sheet;
                $PlanningLineB3->rm_qty_kode5 = $qty_out_sheet;
                $PlanningLineB3->rm_partNo5 = $partNo;
                $PlanningLineB3->rm_spek5 = $request->input('spec');
                $PlanningLineB3->rm_supplier5 = $request->input('supplier');
                $PlanningLineB3->rm_uniqNo5 = $request->input('uniqNo');
                $PlanningLineB3->rm_user5 = auth()->user()->username;
                $PlanningLineB3->rm_time5 = now();
            } 
            else {
                continue;
            }



            $PlanningLineB3->save();
        }

        DB::commit();
        return response()->json(['success' => true, 'message' => 'Data has been saved and quantity updated successfully']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
    }
  }
    
}
