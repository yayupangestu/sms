<?php

namespace App\Http\Controllers;
use App\Models\DataModel;
use App\Models\DataCostumer;
use App\Models\DataPartName;
use Illuminate\Http\Request;
use App\Exports\PartNameExport;
use App\Imports\DataPartNameImport; // Pastikan namespace ini benar
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;

class DataPartNameController extends Controller
{
    public function index()
    {
        $title = 'Part Name';
        // $data_models = DataModel::all();
        $data_costumers = DataCostumer::all();
        return view('line.datapartname', compact('title','data_costumers'));
    }

   public function list(Request $request)
{
    // Ambil nilai home_line dari request
    $homeLines = $request->input('home_line');

    // Query dengan filter home_line jika tersedia
    $query = DB::table('data_part_names as a')
        ->select('a.job_no', 'a.part_name', 'a.part_no', 'a.model', 'a.home_line','a.customer','a.id as id','b.username as createdby','a.created_at','a.suplier','a.no_rak','a.name_material','a.spec_t','a.spec_p','a.spec_l','a.spec_bq','a.variant','a.spec_kg','a.pcs','a.qty_palet','a.qty_min','a.lead_time')
        ->join('users as b', 'b.id', '=', 'a.createdby', 'left');
        // ->join('data_costumers as c', 'c.id', '=', 'a.customer', 'left');

    // Jika filter home_line diberikan sebagai array, gunakan whereIn
    if (!empty($homeLines)) {
        // Jika hanya satu line diberikan, array tidak diperlukan
        if (is_array($homeLines)) {
            $query->whereIn('a.home_line', $homeLines);
        } else {
            $query->where('a.home_line', $homeLines);
        }
    }

    $result = $query->get();

    return DataTables::of($result)->make();
}

    public function edit(Request $request)
    {
        $cek = DataPartName::where('id', $request->id)->count();
        if($cek > 0){
            $row = DataPartName::where('id', $request->id)->first();
            return response()->json([
                'success'           => true,
                'id'                => $row->id,
                'part_name'         => $row->part_name,
                'part_no'           => $row->part_no,
                'job_no'            => $row->job_no,
                'model'             => $row->model,
                'variant'           => $row->variant,
                'name_material'      => $row->name_material,
                'spec_t'           => $row->spec_t,
                'spec_p'           => $row->spec_p,
                'spec_l'           => $row->spec_l,
                'spec_bq'           => $row->spec_bq,
                'spec_kg'           => $row->spec_kg,
                'pcs'               => $row->pcs,
                'qty_palet'         => $row->qty_palet,
                'qty_min'           => $row->qty_min,
                'lead_time'           => $row->lead_time,
                'home_line'         => $row->home_line,
                'customer'          => $row->customer,
          
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
        $data['part_name']          = $request->part_name;
        $data['part_no']            = $request->part_no;
        $data['job_no']             = $request->job_no;
        $data['model']              = $request->model;
        $data['variant']            = $request->variant;
        $data['name_material']      = $request->name_material;
        $data['spec_t']             = $request->spec_t;
        $data['spec_p']             = $request->spec_p;
        $data['spec_l']             = $request->spec_l;
        $data['spec_bq']            = $request->spec_bq;
        $data['spec_kg']            = $request->spec_kg;
        $data['pcs']                = $request->pcs;
        $data['qty_palet']          = $request->qty_palet;
        $data['qty_min']            = $request->qty_min;
        $data['lead_time']          = $request->lead_time;
        $data['home_line']          = $request->home_line;
        $data['customer']           = $request->customer;
        $data['updatedby']          = auth()->user()->id;
        $query = DataPartName::where('id', $request->id)->update($data);
        if($query){
            return response()->json([
                'success'   => true,
                'msg'       => 'Update success.'
            ]);
        }else{
            return response()->json([
                'success'   => false,
                'msg'       => 'Update failed.'
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $query = DataPartName::where('id', $request->id)->delete();
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

    public function importDp(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
    
        // Import data menggunakan class DataPartNameImport
        Excel::import(new DataPartNameImport, $request->file('file')->store('temp'));
    
        return back()->with('success', 'Data DN berhasil diimport!');
    }
    

    public function export(Request $request) 
    {
        // Ambil filter dari request
        $lineFilter = $request->input('line', 'A1,A2'); // Default ke 'A1,A2'
    
        return Excel::download(new PartNameExport($lineFilter), 'PartName.xlsx');
    }
    
}

