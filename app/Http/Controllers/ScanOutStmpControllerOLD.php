<?php

namespace App\Http\Controllers;

use App\Models\ScanOutStmp;
use Illuminate\Http\Request;
use App\Models\RmReturnMaterial;
use App\Models\PlanningLineB3;
use App\Models\ScanOutRm;
use App\Models\StmpTagKanban;
use App\Models\StmpTagKanbanC1;
use App\Models\StmpTagKanbanC2;
// use App\Models\LineStoreStok;
use App\Models\TabelTransitMaterial;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;


class ScanOutStmpController extends Controller
{
    public function index()
    {
        $title = 'Scan Out STMP';
        return view('scanner2.scanoutstmp', compact('title'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'uniqNo'        => 'required|string',
            'job_no'        => 'required|string',
            'part_no'       => 'required|string',
            'model'         => 'required|string',
            'qty'           => 'required|string',
            'date'          => 'required|string',
            'kodeMaterial'  => 'required|string',
            // 'part_no_rm'    => 'required|string',
            'qty_ng'        => 'required|string',
            // 'store'         => 'required|string|in:Line Store,Repair',
        ]);
    
        DB::beginTransaction();
    
        try {
          
            $now = Carbon::now();

            if ($now->hour < 7) {
                $startTime = Carbon::yesterday()->setHour(7)->setMinute(0)->setSecond(0);
                $endTime   = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
            } else {
                $startTime = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
                $endTime   = Carbon::tomorrow()->setHour(7)->setMinute(0)->setSecond(0);
            }
            
            
            $PlanningLineB3 = PlanningLineB3::where('part_no2', $request->input('part_no'))
            ->whereBetween('created_at', [$startTime, $endTime])
            ->where('status_proses', 2)
            ->first();
        
    
            if (!$PlanningLineB3) {
                return response()->json([
                    'success' => false,
                    'message' => 'Part number not found in PlanningLineB3 for today.',
                ], 404);
            }
    
            // Cek existing scan agar tidak duplikat
            $existingScan = PlanningLineB3::where('part_no2', $request->input('part_no'))
                ->where(function ($query) use ($request) {
                    $query->where('stmp_out_uniqNo', $request->input('uniqNo'))
                        ->orWhere('stmp_out_uniqNo2', $request->input('uniqNo'))
                        ->orWhere('stmp_out_uniqNo3', $request->input('uniqNo'))
                        ->orWhere('stmp_out_uniqNo4', $request->input('uniqNo'))
                        ->orWhere('stmp_out_uniqNo5', $request->input('uniqNo'))
                        ->orWhere('stmp_out_uniqNo6', $request->input('uniqNo'))
                        ->orWhere('stmp_out_uniqNo7', $request->input('uniqNo'));
                        // ->orWhere('stmp_out_uniqNo8', $request->input('uniqNo'))
                        // ->orWhere('stmp_out_uniqNo9', $request->input('uniqNo'));
                })
                ->first();
    
            if ($existingScan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat melakukan scan ulang. Karena Kanban Telah di Scan',
                ]);
            }
    
            // Update StmpTagKanban B3
            $StmpTagKanban = StmpTagKanban::where('uniqNo', $request->input('uniqNo'))
            // ->orWhere('part_no', $request->input('part_no_rm'))
            ->get(); // Ambil semua data yang cocok
        
        if ($StmpTagKanban->isNotEmpty()) {
            foreach ($StmpTagKanban as $item) {
                $item->sts_time = now();
                $item->sts_user = auth()->user()->username;
                $item->sts_scan = 1;
                $item->save();
            }
        }

            $StmpTagKanbanC1 = StmpTagKanbanC1::where('uniqNo', $request->input('uniqNo'))
            // ->orWhere('part_no', $request->input('part_no_rm'))
            ->get(); // Ambil semua data yang cocok
        
        if ($StmpTagKanbanC1->isNotEmpty()) {
            foreach ($StmpTagKanbanC1 as $item) {
                $item->sts_time = now();
                $item->sts_user = auth()->user()->username;
                $item->sts_scan = 1;
                $item->save();
            }
        }
        
             // Update StmpTagKanban B3
             $StmpTagKanbanC2 = StmpTagKanbanC2::where('uniqNo', $request->input('uniqNo'))
            //  ->orWhere('part_no', $request->input('part_no_rm'))
             ->get(); // Ambil semua data yang cocok
         
         if ($StmpTagKanbanC2->isNotEmpty()) {
             foreach ($StmpTagKanbanC2 as $item) {
                 $item->sts_time = now();
                 $item->sts_user = auth()->user()->username;
                 $item->sts_scan = 1;
                 $item->save();
             }
         }

    
            // Update atau buat PlanningLineB3
            if ($PlanningLineB3) {
                $qty = $request->input('qty');
                $newActualProduction = $PlanningLineB3->actual_production + $qty;
            
                // Cek batas qty_plan
                if ($newActualProduction > $PlanningLineB3->qty_plan) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kuantitas aktual melebihi rencana produksi. Data tidak disimpan.',
                    ]);
                }
            
                $PlanningLineB3->actual_production = $newActualProduction;
                $PlanningLineB3->qty_plan2 = max(0, $PlanningLineB3->qty_plan2 - $qty);
                
                // ✅ Update tabel_transit_materials (sts = 1)
                TabelTransitMaterial::where('uniqNo', $request->input('kodeMaterial'))->update(['sts' => 1]);
                
                // Cek status_proses
                if ($PlanningLineB3->actual_production == $PlanningLineB3->qty_plan) {
                    $PlanningLineB3->user_stamping_done = auth()->user()->username;
                    $PlanningLineB3->time_endProses = now();
                    $PlanningLineB3->status_proses = 3;
                    $PlanningLineB3->status = 3;
                }
                
            
                if (is_null($PlanningLineB3->status_proses)) {
                    $PlanningLineB3->status_proses = 2;
                }
                
                if (empty($PlanningLineB3->stmp_out_qty) && empty($PlanningLineB3->stmp_out_partNo) && empty($PlanningLineB3->stmp_out_jobNo)) {
                    $PlanningLineB3->stmp_out_uniqNo = $request->input('uniqNo');
                    $PlanningLineB3->stmp_out_jobNo = $request->input('job_no');
                    $PlanningLineB3->stmp_out_partNo = $request->input('part_no');
                    $PlanningLineB3->stmp_out_model = $request->input('model');
                    $PlanningLineB3->stmp_out_qty = $request->input('qty');
                    $PlanningLineB3->stmp_out_qty_ng = $request->input('qty_ng');
                    $PlanningLineB3->stmp_out_date = $request->input('date');
                    $PlanningLineB3->stmp_out_kodematerial = $request->input('kodeMaterial');
                    // $PlanningLineB3->stmp_out_start = $request->input('part_no_rm');
                    $PlanningLineB3->stmp_out_end = $request->input('end');
                    $PlanningLineB3->stmp_out_user = auth()->user()->username;
                    $PlanningLineB3->stmp_out_leader_line = auth()->user()->line_id;
                    $PlanningLineB3->stmp_out_time = now();
                } else if (empty($PlanningLineB3->stmp_out_qty2) && empty($PlanningLineB3->stmp_out_partNo2) && empty($PlanningLineB3->stmp_out_jobNo2)) {
                    // Kolom kedua
                    $PlanningLineB3->stmp_out_uniqNo2 = $request->input('uniqNo');
                    $PlanningLineB3->stmp_out_jobNo2 = $request->input('job_no');
                    $PlanningLineB3->stmp_out_partNo2 = $request->input('part_no');
                    $PlanningLineB3->stmp_out_model2 = $request->input('model');
                    $PlanningLineB3->stmp_out_qty2 = $request->input('qty');
                    $PlanningLineB3->stmp_out_qty_ng2 = $request->input('qty_ng');
                    $PlanningLineB3->stmp_out_date2 = $request->input('date');
                    $PlanningLineB3->stmp_out_kodematerial2 = $request->input('kodeMaterial');
                    // $PlanningLineB3->stmp_out_start2 = $request->input('part_no_rm');
                    $PlanningLineB3->stmp_out_end2 = $request->input('end');
                    $PlanningLineB3->stmp_out_user2 = auth()->user()->username;
                    $PlanningLineB3->stmp_out_leader_line2 = auth()->user()->line_id;
                    $PlanningLineB3->stmp_out_time2 = now();
                } else if (empty($PlanningLineB3->stmp_out_qty3) && empty($PlanningLineB3->stmp_out_partNo3) && empty($PlanningLineB3->stmp_out_jobNo3)) {
                    $PlanningLineB3->stmp_out_uniqNo3 = $request->input('uniqNo');
                    $PlanningLineB3->stmp_out_jobNo3 = $request->input('job_no');
                    $PlanningLineB3->stmp_out_partNo3 = $request->input('part_no');
                    $PlanningLineB3->stmp_out_model3 = $request->input('model');
                    $PlanningLineB3->stmp_out_qty3 = $request->input('qty');
                    $PlanningLineB3->stmp_out_qty_ng3 = $request->input('qty_ng');
                    $PlanningLineB3->stmp_out_date3 = $request->input('date');
                    $PlanningLineB3->stmp_out_kodematerial3 = $request->input('kodeMaterial');
                    // $PlanningLineB3->stmp_out_start3 = $request->input('part_no_rm');
                    $PlanningLineB3->stmp_out_end3 = $request->input('end');
                    $PlanningLineB3->stmp_out_user3 = auth()->user()->username;
                    $PlanningLineB3->stmp_out_leader_line3 = auth()->user()->line_id;
                    $PlanningLineB3->stmp_out_time3 = now();
                } else if (empty($PlanningLineB3->stmp_out_qty4) && empty($PlanningLineB3->stmp_out_partNo4) && empty($PlanningLineB3->stmp_out_jobNo4)) {
                    $PlanningLineB3->stmp_out_uniqNo4 = $request->input('uniqNo');
                    $PlanningLineB3->stmp_out_jobNo4 = $request->input('job_no');
                    $PlanningLineB3->stmp_out_partNo4 = $request->input('part_no');
                    $PlanningLineB3->stmp_out_model4 = $request->input('model');
                    $PlanningLineB3->stmp_out_qty4 = $request->input('qty');
                    $PlanningLineB3->stmp_out_qty_ng4 = $request->input('qty_ng');
                    $PlanningLineB3->stmp_out_date4 = $request->input('date');
                    $PlanningLineB3->stmp_out_kodematerial4 = $request->input('kodeMaterial');
                    // $PlanningLineB3->stmp_out_start4 = $request->input('part_no_rm');
                    $PlanningLineB3->stmp_out_end4 = $request->input('end');
                    $PlanningLineB3->stmp_out_user4 = auth()->user()->username;
                    $PlanningLineB3->stmp_out_leader_line4 = auth()->user()->line_id;
                    $PlanningLineB3->stmp_out_time4 = now();
                } else if (empty($PlanningLineB3->stmp_out_qty5) && empty($PlanningLineB3->stmp_out_partNo5) && empty($PlanningLineB3->stmp_out_jobNo5)) {
                    $PlanningLineB3->stmp_out_uniqNo5 = $request->input('uniqNo');
                    $PlanningLineB3->stmp_out_jobNo5 = $request->input('job_no');
                    $PlanningLineB3->stmp_out_partNo5 = $request->input('part_no');
                    $PlanningLineB3->stmp_out_model5 = $request->input('model');
                    $PlanningLineB3->stmp_out_qty5 = $request->input('qty');
                    $PlanningLineB3->stmp_out_qty_ng5 = $request->input('qty_ng');
                    $PlanningLineB3->stmp_out_date5 = $request->input('date');
                    $PlanningLineB3->stmp_out_kodematerial5 = $request->input('kodeMaterial');
                    // $PlanningLineB3->stmp_out_start5 = $request->input('part_no_rm');
                    $PlanningLineB3->stmp_out_end5 = $request->input('end');
                    $PlanningLineB3->stmp_out_user5 = auth()->user()->username;
                    $PlanningLineB3->stmp_out_leader_line5 = auth()->user()->line_id;
                    $PlanningLineB3->stmp_out_time5 = now();
                } else if (empty($PlanningLineB3->stmp_out_qty6) && empty($PlanningLineB3->stmp_out_partNo6) && empty($PlanningLineB3->stmp_out_jobNo6)) {
                    $PlanningLineB3->stmp_out_uniqNo6 = $request->input('uniqNo');
                    $PlanningLineB3->stmp_out_jobNo6 = $request->input('job_no');
                    $PlanningLineB3->stmp_out_partNo6 = $request->input('part_no');
                    $PlanningLineB3->stmp_out_model6 = $request->input('model');
                    $PlanningLineB3->stmp_out_qty6 = $request->input('qty');
                    $PlanningLineB3->stmp_out_qty_ng6 = $request->input('qty_ng');
                    $PlanningLineB3->stmp_out_date6 = $request->input('date');
                    $PlanningLineB3->stmp_out_kodematerial6 = $request->input('kodeMaterial');
                    // $PlanningLineB3->stmp_out_start6 = $request->input('part_no_rm');
                    $PlanningLineB3->stmp_out_end6 = $request->input('end');
                    $PlanningLineB3->stmp_out_user6 = auth()->user()->username;
                    $PlanningLineB3->stmp_out_leader_line6 = auth()->user()->line_id;
                    $PlanningLineB3->stmp_out_time6 = now();
                } else if (empty($PlanningLineB3->stmp_out_qty7) && empty($PlanningLineB3->stmp_out_partNo7) && empty($PlanningLineB3->stmp_out_jobNo7)) {
                    $PlanningLineB3->stmp_out_uniqNo7 = $request->input('uniqNo');
                    $PlanningLineB3->stmp_out_jobNo7 = $request->input('job_no');
                    $PlanningLineB3->stmp_out_partNo7 = $request->input('part_no');
                    $PlanningLineB3->stmp_out_model7 = $request->input('model');
                    $PlanningLineB3->stmp_out_qty7 = $request->input('qty');
                    $PlanningLineB3->stmp_out_qty_ng7 = $request->input('qty_ng');
                    $PlanningLineB3->stmp_out_date7 = $request->input('date');
                    $PlanningLineB3->stmp_out_kodematerial7 = $request->input('kodeMaterial');
                    // $PlanningLineB3->stmp_out_start7 = $request->input('part_no_rm');
                    $PlanningLineB3->stmp_out_end7 = $request->input('end');
                    $PlanningLineB3->stmp_out_user7 = auth()->user()->username;
                    $PlanningLineB3->stmp_out_leader_line7 = auth()->user()->line_id;
                    $PlanningLineB3->stmp_out_time7 = now();
                }  else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Data dengan UniqNo yang sama sudah ada di semua kolom. Tidak diperbarui.',
                    ]);
                }
                $PlanningLineB3->save();
            }

            $ScanOutRm = ScanOutRm::where('uniqNo', $request->input('kodeMaterial'))->first();
                          if ($ScanOutRm) {
                               $ScanOutRm->qty_stamping -= $request->input('qty');
                               $ScanOutRm->qty_stamping -= $request->input('qty_ng');
                               $PlanningLineB3->status_proses = 1;
                               $ScanOutRm->save();
                   }
            
                   $TabelTransitMaterial = TabelTransitMaterial::where('uniqNo', $request->input('kodeMaterial'))->first();

                   if ($TabelTransitMaterial) {
                       // Total qty yang akan dikurangi
                       $totalQty = $request->input('qty') + $request->input('qty_ng');
                       
                       // Pastikan qty_stamping tidak menjadi minus
                       $TabelTransitMaterial->qty_stamping -= $totalQty;
                       
                       // Jika hasil pengurangan negatif, set menjadi 0
                       if ($TabelTransitMaterial->qty_stamping < 0) {
                           $TabelTransitMaterial->qty_stamping = 0;
                       }
                   
                       $TabelTransitMaterial->sts = 1;
                       $TabelTransitMaterial->sts_proses2 = 3;
                       $TabelTransitMaterial->save();
                }
                   
    
            // Buat ScanOutStmp baru
            $scanOutStmp = new ScanOutStmp();
            $scanOutStmp->uniqNo = $request->input('uniqNo');
            $scanOutStmp->job_no = $request->input('job_no');
            $scanOutStmp->part_no2 = $request->input('part_no');
            $scanOutStmp->model = $request->input('model');
            $scanOutStmp->qty_act = $request->input('qty');
            $scanOutStmp->qty_ng = $request->input('qty_ng');
            $scanOutStmp->date_plan = $request->input('date');
            $scanOutStmp->kode_material = $request->input('kodeMaterial');
            $scanOutStmp->createdby = auth()->user()->username;
            
            // Tentukan status berdasarkan store
            $store = $request->input('store');
            if ($store === 'Repair') {
                $scanOutStmp->status = 2;
                $scanOutStmp->status_2 = 1;
            } elseif ($store === 'PC Store') {
                $scanOutStmp->status = 4;
                $scanOutStmp->status_2 = 1;
            } else {
                $scanOutStmp->status = 1;
                $scanOutStmp->status_2 = 1;
            }
            
            $scanOutStmp->date_scan = now();
            $scanOutStmp->line_proses = $PlanningLineB3->mesin ?? null;
            $scanOutStmp->save();
            
            
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Scan berhasil, data telah dimasukkan.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal menyimpan data scan_out_stmps: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}


