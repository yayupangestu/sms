<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LineStmp;
use App\Models\TabelB3;
use App\Models\DataPartName;
use App\Models\StmpTagKanbanB1;
use App\Models\PlanningLineB3;
use App\Models\DataFgStamping;
use App\Models\RmMaterial;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
// use App\Models\StmpTagKanban;
use Illuminate\Http\Request;
use DataTables;
use DB;
use Carbon\Carbon;

class StmpKanbanB1Controller extends Controller
{
    public function index()
    {
        $title = 'Tag Kanban B1';
        $line_stmps          = LineStmp::all();
        $data_part_names     = DataPartName::all();
        $rm_materials        = RmMaterial::all();
        $master              = StmpTagKanbanB1::all();

       // Ambil data planning hari ini saja
       $now = Carbon::now();

       // Rentang waktu shift produksi: 07:00 hari ini s.d. 07:00 besok
       if ($now->hour < 7) {
           $startTime = Carbon::yesterday()->setHour(7)->setMinute(0)->setSecond(0);
           $endTime   = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
       } else {
           $startTime = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
           $endTime   = Carbon::tomorrow()->setHour(7)->setMinute(0)->setSecond(0);
       }

       $data_fg_stampings = PlanningLineB3::whereBetween('created_at', [$startTime, $endTime])
           ->where('mesin', 'LINE B1')
           ->get();

        return view('stamping.tagkanbanb1', compact('title','line_stmps','data_part_names','rm_materials','master','data_fg_stampings'));
    }

    public function list()
    {
        $query = DB::table('stmp_tag_kanban_b1_s as a')
                ->select('a.date_plan','b.name as line',DB::raw('CONCAT(a.date_plan, b.id)as mix_id'))
                ->join('line_stmps as b', 'b.id', '=', 'a.line_id', 'left')
                ->groupBy('a.date_plan', 'a.line_id', 'b.id')
                ->get();
        return DataTables::of($query)->make();
    }

    public function listdetail(Request $request)
    {
        $query = DB::table('stmp_tag_kanban_b1_s as a')
        ->select('a.part_name','a.id','a.line_id', 'b.id as item_id','a.item_id','a.qty_ok','a.qty_ng','a.time_start','a.time_end','a.shift','a.uniqNo','a.job_no','a.part_no','a.model','a.name_material','a.tujuan','a.kode_material','a.keterangan','a.sts','a.sts_scan')
                ->join('data_part_names as b', 'b.id', '=', 'a.item_id', 'left')
                ->where('a.date_plan', $request->date_plan)
                ->get();

        return DataTables::of($query)->make();
    }

    public function getUniqNosByMachine(Request $request)
    {
        // Validasi parameter mesin
        $request->validate([
            'mesin' => 'required|string',
        ]);

        // Ambil data rm_uniqNo dan rm_uniqNo2 berdasarkan mesin (LINE C1) dan urutkan berdasarkan created_at
        $uniqNos = DB::table('planning_line_b3_s')
        ->where('mesin', $request->input('mesin'))  // Filter berdasarkan mesin (LINE C1)
        ->orderBy('created_at', 'desc') // Urutkan berdasarkan created_at terbaru
        ->get(['rm_uniqNo', 'rm_uniqNo2']); // Ambil rm_uniqNo dan rm_uniqNo2


        return response()->json([
            'success' => true,
            'data' => $uniqNos
        ]);
    }


    public function getDropdownData()
    {

        $now = Carbon::now();

        if ($now->hour < 7) {
            // Shift masih termasuk hari sebelumnya
            $startOfToday = Carbon::yesterday()->setHour(7)->setMinute(0)->setSecond(0);
            $endOfTomorrow   = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
        } else {
            // Hari produksi berjalan normal
            $startOfToday = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
            $endOfTomorrow   = Carbon::tomorrow()->setHour(7)->setMinute(0)->setSecond(0);
        }

        $data = DB::table('planning_line_b3_s')
            ->whereBetween('created_at', [$startOfToday, $endOfTomorrow]) // Filter waktu
            ->where('mesin', 'LINE B1') // Filter mesin
            ->where('status', 2) // Hanya ambil data dengan status = 2
            ->where('status_proses', '!=', 4) // Kecualikan status_proses = 3
            ->select('part_no', 'rm_uniqNo', 'rm_uniqNo2', 'rm_uniqNo3', 'rm_uniqNo4', 'rm_uniqNo5')
            ->get();

        // Gabungkan semua kolom menjadi satu array tanpa duplikasi, sertakan part_no
        $mergedData = collect($data)
            ->flatMap(function ($item) {
                return [
                    ['part_no' => $item->part_no, 'rm_uniqNo' => $item->rm_uniqNo],
                    ['part_no' => $item->part_no, 'rm_uniqNo' => $item->rm_uniqNo2],
                    ['part_no' => $item->part_no, 'rm_uniqNo' => $item->rm_uniqNo3],
                    ['part_no' => $item->part_no, 'rm_uniqNo' => $item->rm_uniqNo4],
                    ['part_no' => $item->part_no, 'rm_uniqNo' => $item->rm_uniqNo5]
                ];
            })
            ->unique()
            ->filter(function ($item) {
                return !empty($item['rm_uniqNo']); // Hapus nilai null atau kosong
            })
            ->values();

        return response()->json($mergedData);
    }


    public function getPartNos()
{
    $now = Carbon::now();

    if ($now->hour < 7) {
        $startTime = Carbon::yesterday()->setHour(7)->startOfMinute();
        $endTime   = Carbon::today()->setHour(7)->startOfMinute();
    } else {
        $startTime = Carbon::today()->setHour(7)->startOfMinute();
        $endTime   = Carbon::tomorrow()->setHour(7)->startOfMinute();
    }

    // Ambil data lengkap untuk kebutuhan dropdown
    $data = DB::table('planning_line_b3_s')
        ->select('part_no', 'status_proses', 'shift')
        ->where('mesin', 'LINE B1')
        ->whereBetween('created_at', [$startTime, $endTime])
        ->distinct()
        ->get();

    return response()->json($data);
}




public function getDropdownData2(Request $request)
{
    $now = Carbon::now();

    // Rentang waktu shift produksi: 07:00 hari ini s.d. 07:00 besok
    if ($now->hour < 7) {
        $startTime = Carbon::yesterday()->setHour(7)->setMinute(0)->setSecond(0);
        $endTime   = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
    } else {
        $startTime = Carbon::today()->setHour(7)->setMinute(0)->setSecond(0);
        $endTime   = Carbon::tomorrow()->setHour(7)->setMinute(0)->setSecond(0);
    }

    $partNo = $request->input('part_no');

    // Ambil data planning_line_b3_s berdasarkan waktu dan part_no
    $data = DB::table('planning_line_b3_s')
        ->whereBetween('created_at', [$startTime, $endTime])
        ->where('mesin', 'LINE B1')
        ->where('part_no', $partNo)
        ->get();

    // Gabungkan uniqNo dari rm_uniqNo sampai rm_uniqNo5
    $uniqNos = collect($data)
        ->flatMap(function ($item) {
            return [
                $item->rm_uniqNo,
                $item->rm_uniqNo2,
                $item->rm_uniqNo3,
                $item->rm_uniqNo4,
                $item->rm_uniqNo5
            ];
        })
        ->filter()
        ->unique()
        ->values();

    // Cek apakah ada uniqNo yang diawali B
    $hasB = $uniqNos->contains(function ($uniqNo) {
        return str_starts_with($uniqNo, 'B');
    });

    // Ambil qty_stamping dari tabel_transit_materials
    $results = $uniqNos->map(function ($uniqNo) use ($data, $partNo, $hasB) {

        // Jika ada B, tampilkan hanya uniqNo yang diawali B
        if ($hasB && !str_starts_with($uniqNo, 'B')) {
            return null;
        }

        $qty = DB::table('tabel_transit_materials')
            ->where('uniqNo', $uniqNo)
            ->sum('qty_stamping');

        if ($qty <= 0) {
            return null;
        }

        // Cari part_no dari data awal
        $matchedPartNo = optional($data->first(function ($item) use ($uniqNo) {
            return in_array($uniqNo, [
                $item->rm_uniqNo,
                $item->rm_uniqNo2,
                $item->rm_uniqNo3,
                $item->rm_uniqNo4,
                $item->rm_uniqNo5
            ]);
        }))->part_no;

        return [
            'uniqNo' => $uniqNo,
            'qty_stamping' => $qty,
            'part_no' => $matchedPartNo ?? $partNo
        ];
    })->filter()->values(); // Buang yang null

    return response()->json($results);
}


public function getQtyStamping(Request $request)
{
    $uniqNo = $request->input('uniqNo'); // Ambil uniqNo dari request

    // Cari di tabel scan_out_rms
    $dataRm = DB::table('tabel_transit_materials')
        ->where('uniqNo', $uniqNo)
        // ->where('status_proses', '!=', 3)
        ->select('qty_stamping')
        ->first();

    // Jika tidak ditemukan, coba cari di tabel scan_out_blanks
    if (!$dataRm) {
        $dataBlank = DB::table('scan_out_blanks')
            ->where('uniqNo', $uniqNo)
            ->select('qty_stamping')
            ->first();

        if ($dataBlank) {
            return response()->json(['qty_stamping' => $dataBlank->qty_stamping]);
        } else {
            return response()->json(['qty_stamping' => null], 404); // Data tidak ditemukan di kedua tabel
        }
    }

    return response()->json(['qty_stamping' => $dataRm->qty_stamping]);
}


    // Mengambil uniqNo dengan qty_stamping > 0
    public function getData(Request $request)
    {
        $partNo = $request->part_no;

        // Filter uniqNo dengan qty_stamping > 0
        $data = DB::table('scan_out_rms')
            ->where('part_no', $partNo)
            ->where('qty_stamping', '>', 0)
            ->pluck('uniqNo');

        return response()->json($data);
    }


    public function sumQty(Request $request)
    {
        $request->validate([
            'uniqNo1' => 'required|string',
            'uniqNo2' => 'required|string',
        ]);

        // Ambil kedua data
        $data1 = DB::table('tabel_transit_materials')->where('uniqNo', $request->uniqNo1)->first();
        $data2 = DB::table('tabel_transit_materials')->where('uniqNo', $request->uniqNo2)->first();

        if ($data1 && $data2) {
            // Hitung total qty
            $totalQty = $data1->qty_stamping + $data2->qty_stamping;

            // Tentukan mana yang lebih baru → akan menjadi target update totalQty
            $upper = $data1;
            $lower = $data2;

            if (isset($data1->created_at) && isset($data2->created_at)) {
                if ($data1->created_at > $data2->created_at) {
                    $lower = $data1;
                    $upper = $data2;
                }
            } elseif (isset($data1->id) && isset($data2->id)) {
                if ($data1->id > $data2->id) {
                    $lower = $data1;
                    $upper = $data2;
                }
            }

            // Buat sum_uniqNo
            $newSumUniqNo = collect([$data1->uniqNo, $data2->uniqNo])
                ->sort()
                ->join('/');

            // ✅ Update uniqNo yang lebih bawah (lebih baru)
            DB::table('tabel_transit_materials')
                ->where('uniqNo', $lower->uniqNo)
                ->update([
                    'qty_stamping' => $totalQty,
                    'total_qty'    => $totalQty,
                    'sum_uniqNo'   => $newSumUniqNo
                ]);

            // ✅ Set uniqNo yang lebih atas jadi 0
            DB::table('tabel_transit_materials')
                ->where('uniqNo', $upper->uniqNo)
                ->update([
                    'qty_stamping' => 0,
                    'total_qty'    => $totalQty,
                    'sum_uniqNo'   => $newSumUniqNo
                ]);

            // Juga update tabel_transit_materials
            DB::table('tabel_transit_materials')
                ->where('uniqNo', $lower->uniqNo)
                ->update([
                    'qty_stamping' => $totalQty,
                    'sum_uniqNo'   => $newSumUniqNo
                ]);

            DB::table('tabel_transit_materials')
                ->where('uniqNo', $upper->uniqNo)
                ->update([
                    'qty_stamping' => 0,
                    'sum_uniqNo'   => $newSumUniqNo
                ]);

            return response()->json([
                'success'        => true,
                'total_qty'      => $totalQty,
                'sum_uniqNo'     => $newSumUniqNo,
                'updated_to'     => $lower->uniqNo
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid UniqNo1 or UniqNo2.'
        ]);
    }

//    public function store(Request $request)
// {
//     // Fetch the part_no from tabel_b3_s based on the item_id
//     $part = DB::table('tabel_b3_s')
//                 ->select('part_no')
//                 ->where('id', $request->item_id)
//                 ->first();

//     // Check if part exists
//     if (!$part) {
//         return response()->json([
//             'success' => false,
//             'msg' => 'Item not found in tabel_b3_s.'
//         ]);
//     }

//     // Create new entry in stmp_tag_kanban_c1_s
//     $plan               = new StmpTagKanban;
//     $plan->doc_no       = $request->doc_no;
//     $plan->date_plan    = $request->date_plan;
//     $plan->line_id      = $request->line_id;
//     $plan->item_id      = $request->item_id;
//     $plan->qty_ok       = $request->qty_ok;
//     $plan->qty_ng       = $request->qty_ng;
//     $plan->shift        = $request->shift;
//     $plan->uniqNo       = $request->uniqNo;
//     $plan->time_start   = $request->time_start;
//     $plan->time_end     = $request->time_end;
//     $plan->part_no      = $part->part_no; // Assign the fetched part_no
//     $plan->createdby    = auth()->user()->id;

//     // Save the record
//     $query = $plan->save();

//     // Return the appropriate response based on the result
//     if ($query) {
//         return response()->json([
//             'success' => true,
//             'msg' => 'Insert success.'
//         ]);
//     } else {
//         return response()->json([
//             'success' => false,
//             'msg' => 'Insert failed.'
//         ]);
//     }
// }

public function store(Request $request)
{
    try {
        // Validasi input
        $request->validate([
            'date_plan'      => 'required|date',
            'line_id'        => 'required|integer',
            'item_id'        => 'required|integer',
            'part_name'      => 'required|string|max:255',
            'job_no'         => 'nullable|string|max:255',
            'part_no'        => 'required|string|max:255',
            'model'          => 'required|string|max:255',
            'name_material'  => 'nullable|string|max:255',
            'qty_ok'         => 'required|integer',
            'qty_ng'         => 'nullable|integer',
            'shift'          => 'required|string|max:255',
            'uniqNo'         => 'nullable|string|max:255',
            'tujuan'         => 'nullable|string|max:255',
            'kode_material'  => 'nullable|string|max:255',
            'keterangan'     => 'nullable|string|max:255',
            'part_no_rm'     => 'nullable|string|max:255',
        ]);

        // Buat instance baru
        $plan = new StmpTagKanbanB1();

        // Assign data dari request
        $plan->date_plan = $request->date_plan;
        $plan->line_id = $request->line_id;
        $plan->item_id = $request->item_id;
        $plan->part_name = $request->part_name;
        $plan->job_no = $request->job_no;
        $plan->part_no = $request->part_no;
        $plan->model = $request->model;
        $plan->name_material = $request->name_material;
        $plan->qty_ok = $request->qty_ok;
        $plan->qty_ng = $request->qty_ng;
        $plan->shift = $request->shift;
        $plan->kode_material = $request->kode_material;
        $plan->keterangan = $request->keterangan;
        $plan->part_no_rm = $request->part_no_rm;
        $plan->line_stmp = 'LINE B1';

        // Generate part_no2 dari part_no
        $plan->part_no2 = str_replace('-', '', $request->part_no) . '00';

        // Generate uniqNo jika tidak disediakan
        if (!$request->uniqNo) {
            $currentTimestamp = now();
            $plan->uniqNo = 'S' . date('dis', strtotime($currentTimestamp)); // Format: ddmmyyHHmmss
        } else {
            $plan->uniqNo = $request->uniqNo;
        }

        $plan->tujuan = $request->tujuan;
        $plan->createdby = auth()->user()->id;
        $plan->line = auth()->user()->line_id;

        // Simpan data
        $query = $plan->save();

        // Berikan respons sukses atau gagal
        if ($query) {
            return response()->json([
                'success' => true,
                'msg' => 'Insert success.',
                'uniqNo' => $plan->uniqNo,
                'part_no2' => $plan->part_no2
            ]);
        } else {
            return response()->json([
                'success' => false,
                'msg' => 'Insert failed.'
            ]);
        }

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'msg' => $e->getMessage()
        ]);
    }
}


    public function edit(Request $request)
    {
        $cek = StmpTagKanbanB1::where('id', $request->id)->count();
        if($cek > 0){
            $row = StmpTagKanbanB1::where('id', $request->id)->first();
            return response()->json([
                'success'        => true,
                'id'             => $row->id,
                'date_plan'      => $row->date_plan,
                'line_id'        => $row->line_id,
                'item_id'        => $row->item_id,
                'qty_ok'         => $row->qty_ok,
                'qty_ng'         => $row->qty_ng,
                'shift'          => $row->shift,
                'uniqNo'         => $row->uniqNo,
                'time_start'     => $row->time_start,
                'time_end'       => $row->time_end,
                'tujuan'         => $row->tujuan,
                'kode_material'  => $row->kode_material,
                'keterangan'     => $row->keterangan,
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
        $data['date_plan']      = $request->date_plan;
        $data['item_id']        = $request->item_id;
        $data['qty_ok']         = $request->qty_ok;
        $data['qty_ng']         = $request->qty_ng;
        $data['shift']         = $request->shift;
        $data['uniqNo']         = $request->uniqNo;
        $data['time_start']     = $request->time_start;
        $data['time_end']       = $request->time_end;
        $data['tujuan']         = $request->tujuan;
        $data['kode_material']  = $request->kode_material;
        $data['keterangan']     = $request->keterangan;
        $data['updateby']       = auth()->user()->id;
        $query = StmpTagKanbanB1::where('id', $request->id)->update($data);
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
        $query = StmpTagKanbanB1::where('id', $request->id)->delete();
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
        $query = StmpTagKanbanB1::where('date_plan', $request->date_plan)->delete();
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

    // public function getdoc()
    // {
    //     $cek = StmpTagKanbanB1::select(DB::raw('COUNT(doc_no) as jml'))->whereMonth('created_at', date('m'))->groupBy('doc_no')->count();
    //     if($cek > 0){
    //         $array = array();
    //         $rows = StmpTagKanbanB1::select('doc_no')->whereMonth('created_at', date('m'))->groupBy('doc_no')->get();
    //         foreach ($rows as $key => $value) {
    //             $array[] = $value->doc_no;
    //         }
    //         $arr_doc = count($array);
    //         return response()->json([
    //             'jml'   => $arr_doc + 1
    //         ]);
    //     }else{
    //         return response()->json([
    //             'jml'   => 1
    //         ]);
    //     }
    // }


    public function submit(Request $request)
    {
        $cek = StmpTagKanbanB1::where('date_plan', $request->date_plan)->count();
        if($cek > 0){
            $data['sts'] = 1;
            $query = StmpTagKanbanB1::where('date_plan', $request->date_plan)->update($data);
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

    public function delete_draft(Request $request)
    {
        $query = StmpTagKanbanB1::where('date_plan', $request->date_plan)->delete();
        return back();
    }

    public function export()

    {
         return Excel::download(new ReportB3Export, 'report.xlsx');
    }


    public function cetak($id)
    {
        // Find the master record by ID
        $master = StmpTagKanbanB1::findOrFail($id);
        $line_stmps = LineStmp::findOrFail($master->line_id);

        // Generate a unique number for the document
        $uniqNo = 'stmp' . date('y') . '/' . date('dm') . $master->no;

        // Query the listdetail data
        $query = DB::table('stmp_tag_kanban_b1_s as a')
                ->select('a.id', 'a.part_name','a.part_no','a.part_no2','a.job_no','a.model','a.name_material', 'a.qty_ok', 'a.qty_ng','a.model', 'a.time_start', 'a.time_end', 'a.shift', 'a.uniqNo','g.username as createdby','a.shift','a.date_plan','a.tujuan','b.name as line_id','a.line','a.kode_material','a.part_no_rm','a.created_at')
                ->join('line_stmps as b', 'b.id', '=', 'a.line_id', 'left')
                // ->join('tabel_b3_s as c', 'c.id', '=', 'a.item_id', 'left')
                // ->join('rm_materials as d', 'd.id', '=', 'c.spec_id', 'left')
                // ->join('data_part_names as e', 'e.id', '=', 'c.job_no', 'left')
                // ->join('data_models as f', 'f.id', '=', 'c.model_id', 'left')
                ->join('users as g', 'g.id', '=', 'a.createdby', 'left')
                ->where('a.id', $id)
                ->get();

        // Check if the query result is not empty
        if ($query->isEmpty()) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        // Take the first item from the query result (since you are using get() it returns a collection)
        $detail = $query->first();

        // Prepare the data to encode into the QR code
         $data_to_encode = "{$detail->part_no2}.{$detail->job_no}.{$detail->qty_ok}.{$detail->id}.{$detail->uniqNo}.{$detail->model}.{$detail->part_no}.{$detail->date_plan}.{$detail->kode_material}.{$detail->qty_ng}";

        // Generate QR code with the encoded data from listdetail
        $qrcode = base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($data_to_encode));

          // load image OK.png -> convert ke base64
          $okPath = public_path('dist/img/ok.png');
          $inspectorPath = public_path('dist/img/inspector2.png');
          $okImage = 'data:image/png;base64,' . base64_encode(file_get_contents($okPath));
          $extraImage = 'data:image/png;base64,' . base64_encode(file_get_contents($inspectorPath));

        // Data to be displayed in the PDF
        $data = [
            'UniqNo'     => $uniqNo,
            'line_stmps' => $master,
            'qrcode'     => $qrcode,
            'part_no'     => $master->part_no,
            'okImage'    => $okImage,
            'extraImage' => $extraImage,
            'no'         => $master->no,
            'part_no_rm' => $master->part_no_rm,
            'line'       => $master->line,
            'line_id'    => $master->line_id,
            'created_at'    => $master->created_at,

            'qty_ok'     => $master->qty_ok,
            'createdby'     => $master->createdby,
            'listdetail' => $query,
        ];

        // Define custom paper size (80mm x 150mm)
        $customPaper = array(0,0,227,425); // 80mm x 150mm dalam pt

        // Load view and generate PDF in landscape
        $pdf = PDF::loadView('formatkanban.kanbanstmpb1', $data)->setPaper($customPaper, 'potrait');

        return $pdf->stream(date('d_M_Y') . '_' . '_qrcode.pdf');

    }

}
