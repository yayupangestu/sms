<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TabelTransitPcStore;
use App\Models\TagLabelWelding;
use App\Models\PcStoreDirect;

class ScanInPsWelding2Controller extends Controller
{
    public function index()
    {
        $title = 'SCANNER 2';
        // Ambil data yang belum di-scan (sts is null)
        // Filter: Hanya tampilkan data dari HARI INI dan KEMARIN
        // Gunakan startOfDay agar mencakup seluruh hari kemarin
        $items = TagLabelWelding::whereNull('sts')
                    ->where('created_at', '>=', \Carbon\Carbon::yesterday()->startOfDay())
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Ambil data history scan HARI INI
        $todaysScans = TabelTransitPcStore::whereDate('created_at', \Carbon\Carbon::today())
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('scanner2.pcstorein2scan', [
            'title' => $title,
            'waitingItems' => $items,
            'todaysScans' => $todaysScans
        ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        DB::beginTransaction();

        try {
            // 🔹 Bersihkan hasil scan
            $raw = trim(str_replace(["\r", "\n"], '', $request->code));

            // 🔹 Pecah berdasarkan titik
            $parts = explode('.', $raw);

            if (count($parts) !== 5) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format barcode tidak valid.'
                ], 422);
            }

            [$part_no, $job_no, $qty_act, $count, $uniqNo] = $parts;

            // 🔹 Validasi manual hasil parsing
            if (!$part_no || !$job_no || !$qty_act || !$count || !$uniqNo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data barcode tidak lengkap.'
                ], 422);
            }

            // ✅ Cek apakah uniqNo sudah discan sebelumnya
            $existingTransit = TabelTransitPcStore::where('uniqNo', $uniqNo)->first();
            if ($existingTransit && $existingTransit->sts == 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Label sudah discan sebelumnya.'
                ], 400);
            }

            // ✅ Simpan data ke tabel_transit_pc_stores
            $transit = new TabelTransitPcStore();
            $transit->part_no   = $part_no;
            $transit->job_no    = $job_no;
            $transit->qty_act   = (int) $qty_act;
            $transit->count     = $count;
            $transit->uniqNo    = $uniqNo;
            $transit->createdby = auth()->id();
            $transit->sts       = 1;
            $transit->save();

            // ✅ Update TagLabelWelding (kalau ada)
            $tagLabel = TagLabelWelding::where('uniqNo', $uniqNo)->first();
            if ($tagLabel) {
                $tagLabel->sts = 1;
                $tagLabel->sts_pcstore = 1;
                $tagLabel->save();
            }

            // ✅ Update PcStoreDirect
            // Optimization: Cek jumlah data dulu tanpa load semua ke memory
            $countJob = PcStoreDirect::where('job_no', $job_no)->count();

            if ($countJob > 0) {
                // Jika data > 1, filter strict pakai part_no2. Jika cuma 1, ambil itu saja.
                $items = ($countJob > 1)
                    ? PcStoreDirect::where('job_no', $job_no)->where('part_no2', $part_no)->get()
                    : PcStoreDirect::where('job_no', $job_no)->get();

                foreach ($items as $item) {
                    $item->qty_act += (int) $qty_act;
                    $item->strength = $item->daily_volume > 0
                        ? round($item->qty_act / $item->daily_volume, 1)
                        : 0;
                    $item->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Scan berhasil disimpan.',
                'data' => [
                    'part_no' => $part_no,
                    'job_no'  => $job_no,
                    'qty_act' => $qty_act,
                    'count'   => $count,
                    'uniqNo'  => $uniqNo,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPendingItems()
    {
        $items = TagLabelWelding::whereNull('sts')
                    ->where('created_at', '>=', \Carbon\Carbon::yesterday()->startOfDay())
                    ->orderBy('created_at', 'desc')
                    ->get();

        $html = '';
        if ($items->count() > 0) {
            foreach ($items as $item) {
                $html .= '<tr id="row-' . $item->uniqNo . '">
                    <td><span class="font-weight-bold text-dark">' . $item->part_no . '</span></td>
                    <td>' . $item->job_no . '</td>
                    <td>' . $item->qty_act . '</td>
                    <td><small class="text-muted">' . $item->uniqNo . '</small></td>
                    <td><small>' . $item->created_at->format('d M Y H:i') . '</small></td>
                </tr>';
            }
        } else {
             $html .= '<tr>
                <td colspan="5" class="text-center py-5 text-muted">
                    <i class="fas fa-check-circle fa-2x mb-3 text-success"></i><br>
                    No pending items found.
                </td>
            </tr>';
        }

        return response()->json(['html' => $html, 'count' => $items->count()]);
    }
}
