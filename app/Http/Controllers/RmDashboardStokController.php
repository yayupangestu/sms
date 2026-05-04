<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Exports\MaterialOutExport;
use App\Exports\StokRmExport;
use App\Exports\MaterialInExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use App\Models\DataFgStamping;
use App\Models\RmInMaterial;
use App\Models\RmStok;
use App\Models\DnInput;
use App\Models\ScanInLabel;
use App\Models\RmDnIncoming;
use App\Models\ScanOutRm;
use App\Models\ScanOutSubcont;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Carbon\Carbon;

class RmDashboardStokController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Stok';

        // Fetch all RM stocks and group by model_id
        $rm_stoks_all = DB::table('rm_stoks')->get();

        $modelStatusData = $rm_stoks_all->whereNotNull('model_id')->groupBy('model_id')->map(function ($items, $modelId) {
            $count = $items->count();
            $countMoreThanZero = $items->filter(function ($item) {
                return $item->actual_sheet > 0;
            })->count();

            $statusColor = 'red';
            if ($count > 0) {
                if ($countMoreThanZero == $count) {
                    $statusColor = 'lime';
                } elseif ($countMoreThanZero > 0) {
                    $statusColor = 'yellow';
                }
            }

            return [
                'model_id' => $modelId,
                'count' => $count,
                'statusColor' => $statusColor
            ];
        })->values();

        // Calculate top card counts
        $totalMaterialCount = $rm_stoks_all->where('category_id', 'INHOUSE')->count();
        $totalSafeCount = $rm_stoks_all->where('category_id', 'INHOUSE')
            ->filter(function ($i) {
                return $i->actual_sheet >= $i->minimal;
            })->count();
        $totalCriticalCount = $rm_stoks_all->where('category_id', 'INHOUSE')
            ->filter(function ($i) {
                return $i->actual_sheet < $i->minimal && $i->actual_sheet > 0;
            })->count();
        $totalTaCount = $rm_stoks_all->where('category_id', 'INHOUSE')
            ->filter(function ($i) {
                return ($i->actual_sheet === null || $i->actual_sheet == 0) && ($i->minimal != 0);
            })->count();
        $totalRunOutCount = $rm_stoks_all->where('keterangan', 2)->count();
        $totalSubcontCount = $rm_stoks_all->where('category_id', 'OUTHOUSE')->count();

        $totalTaGroupCount = $rm_stoks_all->filter(function ($i) {
            return (stripos($i->part_no, 'TA') !== false) || (stripos($i->part_name, 'TA') !== false);
        })->count();

        $allInhouseIds = $rm_stoks_all->where('category_id', 'INHOUSE')->pluck('id')->implode(',');

        $rm_materials = RmMaterial::all();
        $data_fg_stampings = DataFgStamping::all();
        $rm_stoks = RmStok::all();
        $today = Carbon::today();
        $dn_inputs = DNInput::whereDate('created_at', $today)->get();
        $scan_out_rms = ScanOutRM::whereDate('created_at', $today)->get();
        $scan_out_subconts = ScanOutSubcont::whereDate('created_at', $today)->get();

        return view('dashboard.dashboardrmstok', compact(
            'title',
            'rm_materials',
            'rm_stoks',
            'dn_inputs',
            'scan_out_rms',
            'scan_out_subconts',
            'modelStatusData',
            'totalMaterialCount',
            'totalSafeCount',
            'totalCriticalCount',
            'totalTaCount',
            'totalRunOutCount',
            'totalSubcontCount',
            'totalTaGroupCount',
            'allInhouseIds'
        ));
    }

    public function detail(Request $request)
    {
        $query = DB::table('rm_stoks as a')
            ->select(
                'a.id',
                'a.part_name',
                'a.part_no',
                'a.job_no',
                'a.model_id',
                'a.category_id',
                'a.spek',
                'a.spek_t',
                'a.spek_w',
                'a.spek_l',
                'a.minimal',
                'a.actual_sheet',
                'a.actual_kg',
                'a.supplier',
                'a.no_rak',
                'a.part_no2',
                'a.keterangan'
            );

        $filter = $request->input('filter');
        $model_id = $request->input('model_id');

        if ($filter == 'safe') {
            $query->where('a.category_id', 'INHOUSE')
                ->whereColumn('a.actual_sheet', '>=', 'a.minimal');
        } elseif ($filter == 'critical') {
            $query->where('a.category_id', 'INHOUSE')
                ->whereColumn('a.actual_sheet', '<', 'a.minimal')
                ->where('a.actual_sheet', '>', 0);
        } elseif ($filter == 'ta') {
            $query->where('a.category_id', 'INHOUSE')
                ->where(function ($q) {
                    $q->whereNull('a.actual_sheet')->orWhere('a.actual_sheet', '=', 0);
                })
                ->where('a.minimal', '!=', 0);
        } elseif ($filter == 'runout') {
            $query->where('a.keterangan', 2);
        } elseif ($filter == 'subcont') {
            $query->where('a.category_id', 'OUTHOUSE');
        } elseif ($filter == 'ta_group') {
            $query->where(function ($q) {
                $q->where('a.part_no', 'like', '%TA%')
                    ->orWhere('a.part_name', 'like', '%TA%');
            });
        } elseif ($filter == 'all_inhouse') {
            $query->where('a.category_id', 'INHOUSE');
        }

        if (!empty($model_id)) {
            $query->where('a.model_id', $model_id);
        }

        return DataTables::of($query)
            ->addColumn('action', function ($item) use ($filter) {
                $btn = '<button class="btn btn-navy btn-xs" style="background: var(--deep-navy); color: white;" onclick="showDetails(\'' . $item->part_no . '\')">Detail</button>';

                $count = $item->doc_po_count ?? 0;
                $badgeStyle = 'margin-left: 5px; cursor: pointer; padding: 4px 8px; border-radius: 4px; font-weight: 700;';
                if ($count > 0) {
                    $badgeStyle .= ' background: #ffc107; color: #000; box-shadow: 0 2px 4px rgba(0,0,0,0.1);';
                } else {
                    $badgeStyle .= ' background: #e2e8f0; color: #64748b;';
                }
                $btn .= ' <span class="badge" style="' . $badgeStyle . '" onclick="showDocPo(\'' . $item->part_no . '\')">' . $count . '</span>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function detail2(Request $request)
    {
        $ids = explode(',', $request->input('id')); // bisa kirim banyak ID

        $materials = DB::table('rm_stoks as a')
            ->select(
                'a.id',
                'a.part_name',
                'a.part_no',
                'a.job_no',
                'a.model_id',
                'a.category_id',
                'a.spek',
                'a.spek_t',
                'a.spek_w',
                'a.spek_l',
                'a.minimal',
                'a.actual_sheet',
                'a.actual_kg',
                'a.supplier',
                'a.no_rak',
                'a.part_no2'
            )
            ->whereIn('a.id', $ids)
            ->where('a.category_id', 'INHOUSE') // ✅ Filter berdasarkan category_id
            // ->where('a.keterangan', '!=', 2)    // ✅ Filter tambahan
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'part_name' => $item->part_name,
                    'part_no' => $item->part_no,
                    'job_no' => $item->job_no,
                    'model_id' => $item->model_id,
                    'spek' => $item->spek,
                    'category_id' => $item->category_id,
                    'spek_t' => $item->spek_t,
                    'spek_w' => $item->spek_w,
                    'spek_l' => $item->spek_l,
                    'supplier' => $item->supplier,
                    'no_rak' => $item->no_rak,
                    'actual_sheet' => $item->actual_sheet,
                    'actual_kg' => $item->actual_kg,
                    'minimal' => $item->minimal,
                ];
            });

        return response()->json($materials);
    }


    public function getSafeData(Request $request)
    {
        $id = $request->input('id'); // Ambil id dari request

        // Hitung jumlah baris dengan kondisi actual_sheet >= minimal dan category_id = 'INHOUSE' dan keterangan != 2
        $row = DB::table('rm_stoks')
            ->where(function ($query) {
                $query->whereColumn('actual_sheet', '>=', 'minimal');
            })
            ->where('category_id', 'INHOUSE') // ✅ Tambahkan filter INHOUSE
            // ->where('keterangan', '!=', 2)
            ->when($id, function ($query, $id) {
                return $query->where('id', $id);
            })
            ->count();

        // Ambil data dengan kondisi yang sama
        $safeData = DB::table('rm_stoks')
            ->select(
                'id',
                'part_name',
                'part_no',
                'part_no2',
                'job_no',
                'model_id',
                'category_id',
                'spek',
                'spek_t',
                'spek_w',
                'spek_l',
                'minimal',
                'actual_sheet',
                'actual_kg',
                'supplier',
                'no_rak'
            )
            ->where(function ($query) {
                $query->whereColumn('actual_sheet', '>=', DB::raw('minimal'));
            })
            ->where('category_id', 'INHOUSE') // ✅ Tambahkan filter INHOUSE
            // ->where('keterangan', '!=', 2)
            ->when($id, function ($query, $id) {
                return $query->where('id', $id);
            })
            ->get();

        return response()->json([
            'count' => $row,
            'data' => $safeData
        ]);
    }


    public function getCritcalData(Request $request)
    {
        $id = $request->input('id'); // Ambil id dari request

        $criticalData = DB::table('rm_stoks as a') // Gunakan alias untuk tabel
            ->select(
                'a.id',
                'a.part_name',
                'a.part_no',
                'a.part_no2',
                'a.job_no',
                'a.model_id',
                'a.category_id',
                'a.spek',
                'a.spek_t',
                'a.spek_w',
                'a.spek_l',
                'a.minimal',
                'a.actual_sheet',
                'a.actual_kg',
                'a.supplier',
                'a.no_rak'
            )
            ->leftJoin('rm_materials as b', 'b.id', '=', 'a.material_id') // Gunakan leftJoin jika diperlukan data tambahan
            ->where('a.category_id', 'INHOUSE') // Hanya data INHOUSE
            ->whereColumn('a.actual_sheet', '<', 'a.minimal')
            ->where('a.actual_sheet', '>', 0) // Hanya yang positif
            // ->where(function ($query) {
            //     $query->whereNull('a.keterangan')
            //           ->orWhere('a.keterangan', '=', 1); // Hide keterangan = 2
            // })
            ->when($id, function ($query, $id) {
                return $query->where('a.id', $id); // Jika ada ID dikirim
            })
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'part_name' => $item->part_name,
                    'part_no' => $item->part_no,
                    'job_no' => $item->job_no,
                    'model_id' => $item->model_id,
                    'spek' => $item->spek,
                    'category_id' => $item->category_id,
                    'spek_t' => $item->spek_t < 0 ? null : $item->spek_t,
                    'spek_w' => $item->spek_w < 0 ? null : $item->spek_w,
                    'spek_l' => $item->spek_l < 0 ? null : $item->spek_l,
                    'supplier' => $item->supplier,
                    'no_rak' => $item->no_rak,
                    'actual_sheet' => $item->actual_sheet < 0 ? null : $item->actual_sheet,
                    'actual_kg' => $item->actual_kg < 0 ? null : $item->actual_kg,
                    'minimal' => $item->minimal < 0 ? null : $item->minimal,
                ];
            });

        return response()->json($criticalData);
    }


    public function getPartTa(Request $request)
    {
        $id = $request->input('id');

        $safeData = DB::table('rm_stoks as a')
            ->select(
                'a.id',
                'a.part_name',
                'a.part_no',
                'a.job_no',
                'a.model_id',
                'a.category_id',
                'a.spek',
                'a.spek_t',
                'a.spek_w',
                'a.spek_l',
                'a.part_no2',
                'a.minimal',
                'a.actual_sheet',
                'a.actual_kg',
                'a.supplier',
                'a.no_rak',
                DB::raw("(
                SELECT COUNT(*)
                FROM rm_dn_incomings
                WHERE rm_dn_incomings.part_no COLLATE utf8mb4_unicode_ci = a.part_no
            ) as doc_po_count")
            )
            ->where('a.category_id', 'INHOUSE')
            ->where(function ($query) {
                $query
                    ->where(function ($q) {
                        $q->whereNull('a.actual_sheet')->orWhere('a.actual_sheet', '=', 0);
                    })
                    ->where('a.minimal', '!=', 0);
            })
            // ->where(function ($query) {
            //     $query->whereNull('a.keterangan')->orWhere('a.keterangan', '=', 1);
            // })
            ->when($id, function ($query, $id) {
                return $query->where('a.id', $id);
            })
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'part_name' => $item->part_name,
                    'part_no' => $item->part_no,
                    'part_no2' => $item->part_no2,
                    'job_no' => $item->job_no,
                    'model_id' => $item->model_id,
                    'spek' => $item->spek,
                    'category_id' => $item->category_id,
                    'spek_t' => $item->spek_t,
                    'spek_w' => $item->spek_w,
                    'spek_l' => $item->spek_l,
                    'supplier' => $item->supplier,
                    'no_rak' => $item->no_rak,
                    'actual_sheet' => $item->actual_sheet,
                    'actual_kg' => $item->actual_kg,
                    'minimal' => $item->minimal,
                    'doc_po_count' => $item->doc_po_count,
                ];
            });

        return response()->json($safeData);
    }


    public function getDocPo(Request $request)
    {
        $partNo = $request->input('part_no');
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $query = DB::table('rm_dn_incomings')
            ->select('part_no', 'doc_po', 'order_sheet', 'supplier', 'delivery', 'created_at', 'status', 'actual_sheet', 'balance_sheet')
            ->where('part_no', $partNo);

        // Get counts for the header
        $counts = (clone $query)->select(
            DB::raw('COUNT(CASE WHEN status IS NULL THEN 1 END) as count_open'),
            DB::raw('COUNT(CASE WHEN status = "Close" THEN 1 END) as count_close')
        )->first();

        return DataTables::of($query)
            ->filter(function ($q) use ($request) {
                if ($request->has('status')) {
                    $status = $request->get('status');
                    if ($status === 'open') {
                        $q->whereNull('status');
                    } elseif ($status === 'close') {
                        $q->where('status', 'Close');
                    }
                }
            })
            ->with([
                'count_open' => $counts->count_open ?? 0,
                'count_close' => $counts->count_close ?? 0
            ])
            ->make(true);
    }

    public function getRunOut(Request $request)
    {
        // Dapatkan nilai 'id' dari request
        $id = $request->input('id');

        // Query untuk mengambil data dengan atau tanpa ID
        $query = DB::table('rm_stoks as a')
            ->select('a.id', 'a.part_name', 'a.part_no', 'a.job_no', 'a.model_id', 'a.category_id', 'a.spek', 'a.spek_t', 'a.spek_w', 'a.spek_l', 'a.minimal', 'a.actual_sheet', 'a.actual_kg', 'a.supplier', 'a.no_rak', 'a.keterangan', 'a.part_no2')
            ->where('a.keterangan', 2); // Filter berdasarkan keterangan bernilai 2

        if (!empty($id)) {
            $query->where('a.id', $id); // Hanya filter berdasarkan ID jika diberikan
        }

        $materials = $query->get();

        return response()->json($materials);
    }

    public function export(Request $request)
    {
        $filter = $request->input('supplierFilter'); // Ambil nilai filter dari form
        return Excel::download(new StokRmExport($filter), 'Informasi_Stok_NPC.xlsx');
    }

    public function export2(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(new MaterialInExport($startDate, $endDate), 'Informasi IN Material NPC.xlsx');
    }

    public function export3(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(new MaterialOutExport($startDate, $endDate), 'Informasi Out Material NPC.xlsx');
    }
    public function getDnInputs()
    {
        $today = Carbon::today();
        $dn_inputs = DnInput::whereDate('created_at', $today)->latest()->get();
        return response()->json($dn_inputs);
    }

    public function getScanOutRms()
    {
        $today = Carbon::today();
        $scan_out_rms = ScanOutRm::whereDate('created_at', $today)->latest()->get();
        return response()->json($scan_out_rms);
    }

    public function getScanOutSubcont()
    {
        $today = Carbon::today();
        $scan_out_subconts = ScanOutSubcont::whereDate('created_at', $today)->latest()->get();
        return response()->json($scan_out_subconts);
    }


    public function getPartDetails(Request $request)
    {
        $partNo = $request->input('part_no');

        $query = DB::table('scan_in_labels as a')
            ->select(
                'a.id',
                'a.part_no',
                'a.spec',
                'a.supplier',
                'a.qty_in',
                'a.qty_kg',
                'a.status',
                'b.username as createdby',
                'a.created_at',
                'a.time_out',
                'a.out_user',
                'a.uniqNo'
            )
            ->leftJoin('users as b', 'b.id', '=', 'a.createdby')
            ->where('a.part_no', $partNo);

        // For counts, we still need to get the counts but maybe more efficiently or just separate them
        // However, Yajra can also handle this if we return them in the meta data or just separate AJAX calls.
        // For simplicity and to follow the current logic, we'll return counts in the DataTables response.

        $allData = (clone $query)->get();
        $count_null = $allData->whereNull('status')->count() + $allData->where('status', '')->count();
        $count_1 = $allData->where('status', 1)->count();
        $count_2 = $allData->where('status', 2)->count();

        return DataTables::of($query)
            ->editColumn('status', function ($item) {
                if (is_null($item->status) || $item->status === '') {
                    return '<span class="badge badge-success">Material READY</span>';
                } elseif ($item->status == 1) {
                    return '<span class="badge badge-warning">Material OUT</span>';
                } elseif ($item->status == 2) {
                    return '<span class="badge badge-info">Material OUT Subcont</span>';
                }
                return '<span class="badge badge-secondary">Unknown</span>';
            })
            ->addColumn('action', function ($item) {
                return '<a href="#" id="btn_pdf" title="Generate QR" data-uniq="' . $item->uniqNo . '" class="btn btn-primary btn-xs"><i class="ph ph-qr-code"></i></a>';
            })
            ->with([
                'count_null' => $count_null,
                'count_1' => $count_1,
                'count_2' => $count_2
            ])
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function cetak($uniqNo)
    {
        $dn_inputs = DnInput::where('uniq_no', $uniqNo)->firstOrFail();

        $data_to_encode = $dn_inputs->part_no . '||' . $dn_inputs->spec . '||' . $dn_inputs->supplier . '||' . $dn_inputs->uniq_no . '||' . $dn_inputs->detail_id . '||' . $dn_inputs->id . '||' . $dn_inputs->kg_sheet . '||' . $dn_inputs->actual;

        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data_to_encode));

        $data = [
            'qrcode' => $qrcode,
            'uniq_no' => $dn_inputs->uniq_no,
            'part_no' => $dn_inputs->part_no,
            'doc_dn' => $dn_inputs->doc_dn,
            'model' => $dn_inputs->model,
            'createdby' => $dn_inputs->createdby,
            'doc_po' => $dn_inputs->doc_po,
            'spec_t' => $dn_inputs->spec_t,
            'spec_w' => $dn_inputs->spec_w,
            'spec_l' => $dn_inputs->spec_l,
            'kg_sheet' => $dn_inputs->kg_sheet,
            'created_at' => $dn_inputs->created_at,
            'supplier' => $dn_inputs->supplier,
            'actual' => $dn_inputs->actual,
            'spec' => $dn_inputs->spec,
            'no_rak' => $dn_inputs->no_rak,
        ];

        $customPaper = [0, 0, 283.465, 425.1975];

        $pdf = PDF::loadView('rmmaterial.cetak2', $data)
            ->setPaper($customPaper, 'portrait');

        return $pdf->stream(date('d_M_Y') . '_' . $dn_inputs->uniq_no . '_qrcode.pdf');
    }

}
