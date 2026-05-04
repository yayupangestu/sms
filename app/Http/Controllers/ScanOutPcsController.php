<?php

namespace App\Http\Controllers; // Pastikan namespace diatur dengan benar

use Illuminate\Http\Request;
use App\Models\TraceAbility; 
use App\Models\RmSupplier;
use App\Models\RmMaterial;
use App\Models\RmInMaterial;
use App\Models\DataModel;
use App\Models\ScanOutPcs;
use App\Models\PcStoreDirect;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; // Tambahkan ini

class ScanOutPcsController extends Controller // Pastikan kelas mengextends Controller
{
    public function index(){
        $title = 'Scan Out PC-STORE';
        return view('scanner2.scanoutpcs', compact('title'));
    }
    

    public function store(Request $request)
    {
        $scannedData = $request->input('scannedData'); // Ambil data yang dikirimkan
    
        foreach ($scannedData as $data) {
            // Cek apakah record dengan UniqNo sudah ada di database
            $existingRecord = TraceAbility::where('uniqNo', $data['uniq_no_outpcs1'])->first();
    
            if ($existingRecord) {
                // Update record jika sudah ada
                $existingRecord->job_no_outpcs1 = $data['job_no_outpcs1'];
                $existingRecord->part_no_outpcs1 = $data['part_no_outpcs1'];
                $existingRecord->qty_outpcs1 = $data['qty_outpcs1'];
                $existingRecord->cycle_outpcs1 = $data['cycle_outpcs1'];
                $existingRecord->area_outpcs1 = $data['area_outpcs1'];
                $existingRecord->save();
            } else {
                // Buat record baru jika belum ada
                TraceAbility::create([
                    'uniq_no_outpcs1' => $data['uniq_no_outpcs1'],
                    'job_no_outpcs1' => $data['job_no_outpcs1'],
                    'part_no_outpcs1' => $data['part_no_outpcs1'],
                    'qty_outpcs1' => $data['qty_outpcs1'],
                    'cycle_outpcs1' => $data['cycle_outpcs1'],
                    'area_outpcs1' => $data['area_outpcs1']
                ]);
            }
    
            // Mengurangi nilai actual di pc_store_directs berdasarkan part_no_outpcs1
            $pcStoreDirect = PcStoreDirect::where('part_no', $data['part_no_outpcs1'])->first();
    
            if ($pcStoreDirect) {
                $pcStoreDirect->actual -= $data['qty_outpcs1']; // Kurangkan nilai actual dengan qty_outpcs1
                $pcStoreDirect->save(); // Simpan perubahan
            }
        }
    
        // Kembalikan response JSON
        return response()->json(['success' => 'Data successfully submitted and updated!']);
    }
    


    
}

