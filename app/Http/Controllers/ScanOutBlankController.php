<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TabelStokBlank;
use App\Models\ScanOutBlank;
use App\Models\ScanInBlank;
use App\Models\ScanOutRm;
use App\Models\PlanningLineB3;
use Illuminate\Support\Carbon;
use App\Models\TagLabelBlank;
use App\Models\TabelTransitMaterial;
use Illuminate\Support\Str;   // <-- tambahkan ini
// use Carbon\Carbon;

use DB;

class ScanOutBlankController extends Controller
{
    public function index()
    {
        $title = 'Scan In Blank';
        return view('blank.scanout', compact('title'));
    }

    public function getAvailableLines(Request $request)
    {
        $partNo = $request->input('part_no');

        $start = Carbon::today()->setTime(7, 0, 0);
        $end = Carbon::tomorrow()->setTime(7, 30, 0);

        $lines = DB::table('planning_line_b3_s')
            ->where('part_no2', $partNo)
            ->where('mesin_category', 1) // filter mesin_category = 1
            ->whereBetween('created_at', [$start, $end])
            ->pluck('mesin')
            ->unique()
            ->values();

        return response()->json($lines);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validasi input
            $request->validate([
                'part_no' => 'required|string',
                'spec' => 'required|string',
                'line_id' => 'required|string',
                'uniqNo' => 'required|string',
                'part_no2' => 'required|string',
                'qty_act' => 'required|numeric',
                'kode_material' => 'required|string',
                'id_data' => 'required|string',
                'line_selected' => 'required|string',
            ]);

            $uniqNo = $request->input('uniqNo');
            $partNo = $request->input('part_no');

            // Cek apakah uniqNo sudah ada di ScanOutBlank hari ini
            $existingScanOut = ScanOutBlank::where('uniqNo', $uniqNo)
                ->where('part_no', $partNo)
                ->whereDate('created_at', now()->toDateString())
                ->exists();

            if ($existingScanOut) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data with this uniqNo already exists today.',
                ], 409);
            }


            // Simpan data ke ScanOutBlank
            $scanOutBlank = new ScanOutBlank();
            $scanOutBlank->part_no = $partNo;
            $scanOutBlank->part_no2 = $request->input('part_no2');
            $scanOutBlank->spec = $request->input('spec');
            $scanOutBlank->uniqNo = $uniqNo;
            $scanOutBlank->line_id = $request->input('line_id');
            $scanOutBlank->kode_material = $request->input('kode_material');
            $scanOutBlank->qty_act = $request->input('qty_act');
            $scanOutBlank->qty_stamping = $request->input('qty_act');
            $scanOutBlank->id_data = $request->input('id_data');
            $scanOutBlank->createdby = auth()->user()->username;
            $scanOutBlank->save();

            // Simpan data transit
            $TabelTransitMaterial = new TabelTransitMaterial();
            $TabelTransitMaterial->part_no = $request->input('part_no');
            $TabelTransitMaterial->spec = $request->input('spec');
            $TabelTransitMaterial->uniqNo = $request->input('uniqNo');
            $TabelTransitMaterial->supplier = $request->input('line_id');
            $TabelTransitMaterial->id_data = $request->input('id_data');
            $TabelTransitMaterial->qty_out_sheet = $request->input('qty_act');
            $TabelTransitMaterial->qty_stamping = $request->input('qty_act');
            $TabelTransitMaterial->createdby = auth()->user()->username;
            $TabelTransitMaterial->updatedby = auth()->user()->username;
            $TabelTransitMaterial->mesin = $request->input('line_selected');
            $TabelTransitMaterial->sts = 1;
            $TabelTransitMaterial->sts_proses = 1;
            $TabelTransitMaterial->created_at = now();
            $TabelTransitMaterial->save();

            // Update stok blank
            $blankStok = TabelStokBlank::where('part_no2', $request->input('part_no'))->first();
            if (!$blankStok) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Part Number not found in stock',
                ], 404);
            }

            $blankStok->qty_actual -= $request->input('qty_act');
            $blankStok->save();
// Update data di PlanningLineB3
$today = Carbon::today()->toDateString();

$planningLine = PlanningLineB3::where('part_no2', $request->input('part_no'))
    ->where('mesin_category', 2)
    ->whereDate('date_plan', $today)
    ->first();

if ($planningLine) {

    $usedUniqNos = [
        $planningLine->stmp_in_uniqNo,
        $planningLine->stmp_in_uniqNo2,
        $planningLine->stmp_in_uniqNo3,
        $planningLine->stmp_in_uniqNo4
    ];

    if (in_array($uniqNo, $usedUniqNos)) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Data with this uniqNo already exists in PlanningLineB3.',
        ], 409);
    }

    // ============================================================
    //  ✅ Tambahkan qty_act ke actual_production (selalu bertambah)
    // ============================================================
    $qtyAct = $request->input('qty_act');

    $planningLine->actual_production = ($planningLine->actual_production ?? 0) + $qtyAct;
    $planningLine->qty_out_blank    = ($planningLine->qty_out_blank ?? 0) + $qtyAct;
   // CEK STATUS PROSES
    if ($planningLine->actual_production >= $planningLine->qty_plan) {
        $planningLine->status_proses = 3;
        $planningLine->status2       = 3;

        if(empty($planningLine->time_endProses)){
            $planningLine->time_endProses = now();
        }
    } else {
        $planningLine->status_proses = 2;
        $planningLine->status2       = 2;
    }


    // =====================
    //  ISI SLOT KOSONG
    // =====================
    if (empty($planningLine->blank_qty)) {

        $planningLine->blank_uniqNo   = $uniqNo;
        $planningLine->blank_qty      = $qtyAct;
        $planningLine->blank_partNo   = $request->input('part_no2');
        $planningLine->blank_spek     = $request->input('spec');
        $planningLine->blank_supplier = $request->input('line_id');
        $planningLine->blank_user     = auth()->user()->username;
        $planningLine->blank_time     = now();

    } elseif (empty($planningLine->blank_qty2)) {

        $planningLine->blank_uniqNo2   = $uniqNo;
        $planningLine->blank_qty2      = $qtyAct;
        $planningLine->blank_partNo2   = $request->input('part_no2');
        $planningLine->blank_spek2     = $request->input('spec');
        $planningLine->blank_supplier2 = $request->input('line_id');
        $planningLine->blank_user2     = auth()->user()->username;
        $planningLine->blank_time2     = now();

    } elseif (empty($planningLine->blank_qty3)) {

        $planningLine->blank_uniqNo3   = $uniqNo;
        $planningLine->blank_qty3      = $qtyAct;
        $planningLine->blank_partNo3   = $request->input('part_no2');
        $planningLine->blank_spek3     = $request->input('spec');
        $planningLine->blank_supplier3 = $request->input('line_id');
        $planningLine->blank_user3     = auth()->user()->username;
        $planningLine->blank_time3     = now();

    } elseif (empty($planningLine->blank_qty4)) {

        $planningLine->blank_uniqNo4   = $uniqNo;
        $planningLine->blank_qty4      = $qtyAct;
        $planningLine->blank_partNo4   = $request->input('part_no2');
        $planningLine->blank_spek4     = $request->input('spec');
        $planningLine->blank_supplier4 = $request->input('line_id');
        $planningLine->blank_user4     = auth()->user()->username;
        $planningLine->blank_time4     = now();

    } else {
        throw new \Exception('All slots are full for this part.');
    }

    // Set status proses
    $planningLine->status_proses  = 3;
    $planningLine->status2        = 3;

    // Update TagLabelBlank
    $TagLabelBlank = TagLabelBlank::where('uniqNo', $uniqNo)->first();
    if ($TagLabelBlank) {
        $TagLabelBlank->sts_scan = 1;
        $TagLabelBlank->save();
    }

    $planningLine->save();
}

DB::commit();

return response()->json([
    'success' => true,
    'message' => 'Data updated successfully',
]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'detail' => $e->getMessage(),
            ], 500);
        }
    }
}
