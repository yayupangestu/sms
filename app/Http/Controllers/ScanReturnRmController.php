<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScanOutRm;
use App\Models\RmReturnMaterial;
use App\Models\PlanningLineB3;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class ScanReturnRmController extends Controller
{
    public function index()
    {
        $title = 'Scan Return';
        return view('scanner2.scanreturnrm', compact('title'));
    }
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'part_no'     => 'required|string',
            'spec'        => 'required|string',
            'supplier'    => 'required|string',
            'uniqNo'      => 'required|string',
            'qty_awal'    => 'required|numeric|min:0',
            'qty_return'  => 'required|numeric|min:0',
            'line_id'     => 'required|string'
        ]);
    
        // Periksa jika hasil scan memiliki error
        if ($this->isScanError($request->input('uniqNo'))) {
            return response()->json([
                'success' => false,
                'message' => 'Scan Error! Data tidak dikirim.'
            ], 400);
        }
    
        // Cek apakah uniqNo sudah pernah dipakai di kolom uniqNo2
        $alreadyScanned = RmReturnMaterial::where('uniqNo2', $request->input('uniqNo'))->first();
    
        if ($alreadyScanned) {
            return response()->json([
                'success' => false,
                'icon'    => 'info',
                'message' => 'Data sudah di-scan!'
            ]);
                    
        }
    
        // Tambahkan prefix (S) di depan uniqNo untuk disimpan
        $uniqNo = '(S)' . $request->input('uniqNo');
    
        DB::beginTransaction();
    
        try {
            // Cek apakah data sudah ada
            $existingMaterial = RmReturnMaterial::where('uniqNo', $uniqNo)->first();
    
            if ($existingMaterial) {
                // Update data jika sudah ada
                $existingMaterial->update([
                    'spec'       => $request->input('spec'),
                    'part_no'    => $request->input('part_no'),
                    'supplier'   => $request->input('supplier'),
                    'qty_awal'   => $request->input('qty_awal'),
                    'qty_return' => $request->input('qty_return'),
                    'line_id'    => $request->input('line_id'),
                    'uniqNo2'    => $request->input('uniqNo'),
                    'scan_by'    => Auth::user()->username,
                ]);
            } else {
                // Insert baru
                RmReturnMaterial::create([
                    'uniqNo'     => $uniqNo,
                    'spec'       => $request->input('spec'),
                    'part_no'    => $request->input('part_no'),
                    'supplier'   => $request->input('supplier'),
                    'qty_awal'   => $request->input('qty_awal'),
                    'qty_return' => $request->input('qty_return'),
                    'line_id'    => $request->input('line_id'),
                    'scan_by'    => Auth::user()->username,
                ]);
            }
    
            // Update ScanOutRm
            $ScanOutRm = ScanOutRm::where('part_no', $request->input('part_no'))
                ->where('uniqNo', $request->input('uniqNo'))
                ->whereDate('created_at', now()->toDateString())
                ->first();
    
            if ($ScanOutRm) {
                $ScanOutRm->qty_sisa += $request->input('qty_return');
                $ScanOutRm->qty_stamping -= $request->input('qty_return');
    
                if ($ScanOutRm->qty_stamping < 0) {
                    $ScanOutRm->qty_stamping = 0;
                }
    
                $ScanOutRm->save();
            }
    
            // Update PlanningLineB3
            $PlanningLineB3 = PlanningLineB3::where('part_no', $request->input('part_no'))
                ->whereDate('created_at', now()->toDateString())
                ->first();
    
            if ($PlanningLineB3) {
                $PlanningLineB3->qty_sisa_material += $request->input('qty_return');
                $PlanningLineB3->save();
            }
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Good Job!!'
            ], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function getQtyStamping(Request $request)
    {
        $request->validate([
            'uniqNo' => 'required|string'
        ]);
    
        $uniqNo = $request->input('uniqNo');
    
        $qty = DB::table('scan_out_rms')
            ->where('uniqNo', $uniqNo)
            ->value('qty_stamping');
    
        if ($qty !== null) {
            return response()->json([
                'success'   => true,
                'qty_awal'  => $qty
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Unique No tidak ditemukan atau tidak memiliki qty'
        ]);
    }
    


    /**
     * Cek apakah hasil scan mengalami error.
     */
    private function isScanError($uniqNo)
    {
        // Tambahkan logika deteksi error di sini
        return empty($uniqNo) || !preg_match('/^[A-Za-z0-9\-]+$/', $uniqNo);
    }
}
