<?php

namespace App\Http\Controllers;
// use App\Exports\ReportB3Export;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LineStmp;
use App\Models\TabelB3;
use App\Models\DataPartName;
use App\Models\PlanningLineB3;
use App\Models\TabelStokBlank;
use App\Models\DataFgStamping;
use App\Models\RmMaterial;
use App\Models\LineStoreStok;
use Illuminate\Http\Request;
use App\Models\RmStok;
use App\Models\DataBlank;
use Carbon\Carbon;
use App\Models\TabelTransitMaterial;


use DataTables;
use DB;

class PlanningLineB3Controller extends Controller
{
    public function index()
    {
        $title = 'Planning Line';
        $line_stmps = LineStmp::all();
        $data_part_names = DataPartName::all();
        $rm_materials = RmMaterial::all();
        $data_models = DataFgStamping::all();
        $tabel_stok_blanks = TabelStokBlank::all();
        $rm_stoks   = RmStok::all();
        return view('planningline.planningb3', compact('title','line_stmps','rm_stoks','rm_materials','data_part_names','tabel_stok_blanks'));
    }

    public function getProductsByLine(Request $request)
{
    $lineId = $request->input('line_id');

    if ($lineId == 2) {
        $filteredProducts = DataBlank::all();
        return response()->json($filteredProducts);
    }

    return response()->json([]);
}

// Ambil stok dari TabelStokBlank berdasarkan part_no (bukan part_no2)
    public function getQtyBlank(Request $request)
    {
        $partNo = $request->part_no;

        $stok = TabelStokBlank::where('part_no', $partNo)->first();

        return response()->json([
            'qty_actual' => $stok ? $stok->qty_actual : 0,
            'qty_min' => $stok ? $stok->qty_min : 0,
        ]);
    }

// Ambil stok dari LineStoreStok berdasarkan part_no2
    public function getStock(Request $request)
    {
        $partNo2 = $request->part_no2;

        $stok = LineStoreStok::where('part_no2', $partNo2)->first();

        return response()->json([
            'qty_actual' => $stok ? $stok->qty_actual : 0,
            'qty_min' => $stok ? $stok->qty_min : 0,
        ]);
    }

// Ambil stok dari Raw Material berdasarkan part_no2
    public function getRawMaterial(Request $request)
    {
        $partNo = $request->part_no;

        $stok = RmStok::where('part_no', $partNo)->first();

        return response()->json([
            'actual_sheet' => $stok ? $stok->actual_sheet : 0,
            // 'qty_min' => $stok ? $stok->qty_min : 0,
        ]);
    }

    public function getQtyStamping(Request $request)
    {
        $partNo = $request->input('part_no');
    
        $qtyStamping = DB::table('tabel_transit_materials')
            ->where('part_no', $partNo)
            ->sum('qty_stamping');
    
        return response()->json([
            'qty_stamping' => $qtyStamping
        ]);
    }

    public function getQtyKanban(Request $request)
{
    $partNo = $request->input('part_no');

    $qtyKanban = DB::table('tabel_stok_blanks')
        ->where('part_no', $partNo)
        ->sum('qty_kanban');

    return response()->json([
        'qty_kanban' => $qtyKanban
    ]);
}


    public function list(Request $request)
    {
        $line_id = $request->input('line_id');

        $query = DB::table('planning_line_b3_s as a')
            ->select('a.date_plan', 'b.name as line', DB::raw('CONCAT(a.date_plan, b.id) as mix_id'))
            ->join('line_stmps as b', 'b.id', '=', 'a.line_id', 'left')
            ->when($line_id, function ($q) use ($line_id) {
                return $q->where('a.line_id', $line_id);
            })
            ->groupBy('a.date_plan', 'a.line_id', 'b.name', 'b.id');

        return DataTables::of($query)->make();
    }


    public function listdetail(Request $request)
    {
        $query = DB::table('planning_line_b3_s as a')
                ->select('a.id','b.part_name as product_id ', 'a.qty_plan','a.job_no','a.part_no','a.part_no2','a.model_id','a.spek','a.shift','a.mesin','a.position','a.position','a.order_position','a.status_proses')
                ->join('data_part_names as b', 'b.id', '=', 'a.product_id', 'left')
                ->where('a.date_plan', $request->date_plan)
                ->where('a.line_id', $request->line_id)
                ->orderBy('position', 'asc') // Pastikan mengambil data sesuai urutan terbaru
    ->get();
        return DataTables::of($query)->make();
    }

    public function reorder(Request $request)
    {
        // Validasi request untuk memastikan 'order' ada dan berbentuk array
        $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|integer',
            'order.*.mesin' => 'required|string',
            'order.*.part_no' => 'required|string',
            'order.*.position' => 'required|integer'
        ]);

        try {
            foreach ($request->order as $item) {
                DB::table('planning_line_b3_s')
                    ->where('id', $item['id'])
                    ->where('mesin', $item['mesin']) // Update berdasarkan mesin
                    ->where('part_no', $item['part_no']) // Update berdasarkan part_no
                    ->update(['position' => $item['position']]);
            }

            return response()->json(['message' => 'Urutan berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan', 'error' => $e->getMessage()], 500);
        }
    }

    public function checkPartNo2(Request $request)
{

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


    // Cek part_no2 hanya dalam rentang waktu shift
    $data = PlanningLineB3::where('part_no2', $request->part_no2)
        ->whereBetween('created_at', [$startTime, $endTime])
        ->latest()
        ->first();

        if ($data) {
            return response()->json([
                'exists' => true,
                'mesin' => $data->mesin,
                'shift' => $data->shift, // tambahkan ini
                'date_plan' => $data->date_plan,
                'job_no' => $data->job_no,
            ]);
        } else {
            return response()->json(['exists' => false]);
        }
        
}

public function store(Request $request)
{
    $count = PlanningLineB3::where('mesin', $request->mesin)->count();

    $lastEntry = PlanningLineB3::where('mesin', $request->mesin)
        ->orderBy('position', 'desc')
        ->first();

    $newPosition = ($lastEntry && $lastEntry->mesin == $request->mesin) ? $lastEntry->position + 1 : 1;

    $plan = new PlanningLineB3;
    $plan->date_plan = $request->date_plan;
    $plan->line_id = $request->line_id;
    $plan->spek = $request->spek;
    $plan->product_id = $request->product_id;
    $plan->mesin = $request->mesin;
    $plan->part_no = $request->part_no;
    $plan->part_no2 = $request->part_no2;
    $plan->job_no = $request->job_no;
    $plan->spec_bq = $request->spec_bq;
    $plan->qty_plan2 = $request->qty_plan;
    $plan->qty_plan = $request->qty_plan;
    $plan->model_id = $request->model_id;
    $plan->shift = $request->shift;
    $plan->part_name = $request->part_name;
    $plan->step_proses = $request->step_proses;
    $plan->description = $request->description;
    $plan->position = $newPosition;
    $plan->createdby = auth()->user()->name;

    // Tambah logika mesin_category
    $mesinStamping = ['LINE A1', 'LINE A2', 'LINE B1', 'LINE B2', 'LINE B3', 'LINE C1', 'LINE C2'];
    $mesinBlank = ['TRANSFRES', 'KOMATSU', 'FUKUI', 'AMINO'];

    if (in_array($request->mesin, $mesinStamping)) {
        $plan->mesin_category = '1';
    } elseif (in_array($request->mesin, $mesinBlank)) {
        $plan->mesin_category = '2';
    } else {
        $plan->mesin_category = null;
    }

    // Shift time
    if ($request->shift == 1) {
        $plan->shift_1_awal = $request->date_plan . ' 07:30:00';
        $plan->shift_1_akhir = $request->date_plan . ' 20:00:00';
    } elseif ($request->shift == 2) {
        $tanggalEsok = date('Y-m-d', strtotime($request->date_plan . ' +1 day'));
        $plan->shift_2_awal = $request->date_plan . ' 20:00:00';
        $plan->shift_2_akhir = $tanggalEsok . ' 07:30:00';
    }

    // Step 1: Hitung total qty_stamping dari tabel_transit_materials
    $totalStamping = TabelTransitMaterial::where('part_no', $request->part_no)
        ->where(function($query) {
            $query->where('sts_proses', 2)
                  ->orWhereNull('sts_proses2');
        })
        ->sum('qty_stamping');

    // Step 2: Ambil actual_sheet dari tabel rm_stoks berdasarkan part_no
    $rmStok = RmStok::where('part_no', $request->part_no)->first();
    $actualSheet = $rmStok ? $rmStok->actual_sheet : null;

    if ($request->qty_plan <= $totalStamping && $totalStamping > 0) {
        // Kondisi READY
        $plan->status = 1;
        $plan->status_proses = 1;
    } elseif ($request->qty_plan > $totalStamping) {
        // Qty lebih besar dari qty_stamping = NULL
        $plan->status = null;
        $plan->status_proses = null;
    } elseif ($request->qty_plan >= $totalStamping && ($actualSheet === null || $actualSheet == 0)) {
        // Jika qty sama besar tapi actualSheet tidak ada = RMTA
        $plan->status = 6;
        $plan->status_proses = 6;
    }

    // Tanggal input manual
    $planDateTime = Carbon::parse($request->date_plan)->setTime(7, 10, 0);
    $plan->created_at = $planDateTime;

    $query = $plan->save();

    return response()->json([
        'success' => $query,
        'msg' => $query ? 'Insert success.' : 'Insert failed.',
        'position' => $plan->position
    ]);
}





    public function edit(Request $request)
    {
        $cek = PlanningLineB3::where('id', $request->id)->count();
        if($cek > 0){
            $row = PlanningLineB3::where('id', $request->id)->first();
            return response()->json([
                'success'               => true,
                'id'                    => $row->id,
                'product_id'            => $row->product_id,
                'mesin'                 => $row->mesin,
                'spek'                  => $row->spek,
                'job_no'                => $row->job_no,
                'part_no'               => $row->part_no,
                'part_no2'              => $row->part_no2,
                'model_id'              => $row->model_id,
                'qty_plan'          => $row->qty_plan,
                'qty_plan2'         => $row->qty_plan2,
                'shift'             => $row->shift,
                'part_name'         => $row->part_name,
                'position'          => $row->position,
                'description'       => $row->description,
                'step_proses'       => $row->step_proses,
                'spec_bq'       => $row->spec_bq,
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Data Not found.'
            ]);
        }
    }

    public function update(Request $request)
    {
        $data['product_id']         = $request->product_id;
        $data['job_no']             = $request->job_no;
        $data['part_no']            = $request->part_no;
        $data['part_no2']           = $request->part_no2;
        $data['mesin']              = $request->mesin;
        $data['model_id']           = $request->model_id;
        $data['qty_plan']           = $request->qty_plan;
        $data['qty_plan2']           = $request->qty_plan;
        $data['shift']              = $request->shift;
        $data['part_name']          = $request->part_name;
        $data['spek']               = $request->spek;
        $data['spec_bq']               = $request->spec_bq;
        $data['position']           = $request->position;
        $data['description']        = $request->description;
        $data['step_proses']        = $request->step_proses;
        $data['updatedby']          = auth()->user()->name;
        $query = PlanningLineB3::where('id', $request->id)->update($data);
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Edit success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Edit failed.'
            ]);
        }
    }

    public function destroyline(Request $request)
    {
        $query = PlanningLineB3::where('id', $request->id)->delete();
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Delete success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Delete failed.'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $query = PlanningLineB3::where('date_plan', $request->date_plan)->where('line_id', $request->idline)->delete();
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Delete success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Delete failed.'
            ]);
        }
    }

    public function export()

    {
         return Excel::download(new ReportB3Export, 'report.xlsx');
    }

    public function submit(Request $request)
    {
        $cek = PlanningLineB3::where('date_plan', $request->date_plan)->count();
        if($cek > 0){
            $data['sts'] = 1;
            $query = PlanningLineB3::where('date_plan', $request->date_plan)->update($data);
            if($query){
                return response()->json([
                    'success'   => true,
                    'msg'       => 'Submit success.'
                ]);
            }else{
                return response()->json([
                    'success'   => false,
                    'msg'       => 'Submit failed.'
                ]);
            }
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Submit failed. doc no not found'
            ]);
        }
    }

    public function updateStatusQty()
    {
        // Mengambil semua data dari tabel planning_line_b3_s
        $planningLines = DB::table('planning_line_b3_s')->get();

        foreach ($planningLines as $line) {
            // Membandingkan qty_plan dan qty_in_material
            if ($line->qty_plan == $line->qty_in_material) {
                // Update status menjadi 1 jika qty_plan == qty_in_material
                DB::table('planning_line_b3_s')
                    ->where('id', $line->id)
                    ->update(['status' => 1]);
            } elseif ($line->qty_in_material > $line->qty_plan) {
                // Update status menjadi 2 jika qty_in_material > qty_plan
                DB::table('planning_line_b3_s')
                    ->where('id', $line->id)
                    ->update(['status' => 2]);
            }
        }

        return response()->json([
            'success' => true,
            'msg' => 'Status updated successfully.'
        ]);
    }

    public function approveProduction(Request $request)
    {
        try {
            $id = $request->id;
            $actualQty = $request->actual_production; // Ambil qty dari frontend

            // Update kolom status dan actual_production
            $planningItem = PlanningLineB3::find($id);
            if ($planningItem) {
                $planningItem->status_proses = 3;
                $planningItem->status = 3;
                $planningItem->time_endProses = now();
                $planningItem->user_stamping_done = auth()->user()->username;
                $planningItem->actual_production = $actualQty; // ✅ Simpan qty di kolom ini
                $planningItem->save();

                return response()->json(['success' => true, 'message' => 'Production status updated successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Item not found.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getActualProduction($id)
    {
        $item = PlanningLineB3::find($id);

        if ($item) {
            return response()->json([
                'success' => true,
                'actual_production' => $item->actual_production
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }
    }






}
