<?php

namespace App\Http\Controllers;
// use App\Exports\ReportB3Export;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\LineStmp;
use App\Models\TraceProses2;
use App\Models\DataPartName;
use App\Models\PlanningLineB3;
use App\Models\DataModel;
use App\Models\RmMaterial;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use DB;

class TraceProses2Controller extends Controller
{
    public function index()
    {
        $title = 'Trace Proses Produksi';
        $line_stmps = LineStmp::all();
        $data_part_names = DataPartName::all();
        $rm_materials = RmMaterial::all();
        $trace_proses2s = TraceProses2::all();
        $planning_line_b3_s = PlanningLineB3::all();
        $users = User::all();

        return view('stepproses.proses2', compact('title','line_stmps','data_part_names','trace_proses2s','users','planning_line_b3_s'));
    }

    public function list(Request $request)
    {
        $query = DB::table('planning_line_b3_s as a')
            ->select(
                'a.id', 'a.uniqNo', 'a.date_plan', 'a.mesin', 'a.job_no','a.part_no', 'a.part_no2','a.model_id', 'a.qty_plan', 'a.spek', 'a.shift', 'a.createdby','a.created_at', 'a.updatedby', 'a.updated_at',
                'a.rm_uniqNo', 'a.rm_partNo', 'a.rm_spek', 'a.rm_supplier','a.rm_qty', 'a.rm_user', 'a.rm_time','a.rm_uniqNo2', 'a.rm_partNo2', 'a.rm_spek2', 'a.rm_supplier2', 'a.rm_qty2', 'a.rm_user2', 'a.rm_time2',
                'a.rm_uniqNo3', 'a.rm_partNo3', 'a.rm_spek3', 'a.rm_supplier3','a.rm_qty3', 'a.rm_user3', 'a.rm_time3','a.rm_uniqNo4', 'a.rm_partNo4', 'a.rm_spek4', 'a.rm_supplier4','a.rm_qty4', 'a.rm_user4', 'a.rm_time4',
                'a.blank_uniqNo','a.blank_partNo','a.blank_spek','a.blank_supplier','a.blank_qty','a.blank_kode','a.blank_time','a.blank_user','a.blank_uniqNo2','a.blank_partNo2','a.blank_spek2','a.blank_supplier2','a.blank_qty2','a.blank_kode2','a.blank_time2','a.blank_user2',
                'a.rm_uniqNo5', 'a.rm_partNo5', 'a.rm_spek5', 'a.rm_supplier5','a.rm_qty5', 'a.rm_user5', 'a.rm_time5','a.stmp_in_uniqNo', 'a.stmp_in_user', 'a.stmp_in_time','a.stmp_in_partNo', 'a.stmp_in_spek', 'a.stmp_in_qty', 'a.stmp_in_supplier','a.stmp_in_leader_line','a.stmp_in_leader_line2','a.stmp_in_leader_line3','a.stmp_in_leader_line4',
                'a.stmp_in_uniqNo2', 'a.stmp_in_user2', 'a.stmp_in_time2','a.stmp_in_partNo2', 'a.stmp_in_spek2', 'a.stmp_in_qty2', 'a.stmp_in_supplier2', 'a.stmp_in_uniqNo3', 'a.stmp_in_user3', 'a.stmp_in_time3','a.stmp_in_partNo3', 'a.stmp_in_spek3', 'a.stmp_in_qty3', 'a.stmp_in_supplier3',
                'a.stmp_in_uniqNo4', 'a.stmp_in_user4', 'a.stmp_in_time4','a.stmp_in_partNo4', 'a.stmp_in_spek4', 'a.stmp_in_qty4', 'a.stmp_in_supplier4', 'a.stmp_in_uniqNo5', 'a.stmp_in_user5', 'a.stmp_in_time5','a.stmp_in_partNo5', 'a.stmp_in_spek5', 'a.stmp_in_qty5', 'a.stmp_in_supplier5',
                'a.stmp_out_uniqNo', 'a.stmp_out_jobNo', 'a.stmp_out_partNo','a.stmp_out_model', 'a.stmp_out_qty', 'a.stmp_out_date', 'a.stmp_out_start','a.stmp_out_end','a.stmp_out_user','a.stmp_out_leader_line','a.stmp_out_time','a.stmp_out_kodematerial','a.stmp_out_uniqNo2', 'a.stmp_out_jobNo2', 'a.stmp_out_partNo2','a.stmp_out_model2', 'a.stmp_out_qty2', 'a.stmp_out_date2', 'a.stmp_out_start2','a.stmp_out_end2','a.stmp_out_user2','a.stmp_out_leader_line2','a.stmp_out_time2','a.stmp_out_kodematerial2',
                'a.stmp_out_uniqNo3', 'a.stmp_out_jobNo3', 'a.stmp_out_partNo3','a.stmp_out_model3', 'a.stmp_out_qty3', 'a.stmp_out_date3', 'a.stmp_out_start3','a.stmp_out_end3','a.stmp_out_user3','a.stmp_out_time3','a.stmp_out_leader_line3','a.stmp_out_kodematerial3','a.stmp_out_uniqNo4', 'a.stmp_out_jobNo4', 'a.stmp_out_partNo4','a.stmp_out_model4', 'a.stmp_out_qty4', 'a.stmp_out_date4', 'a.stmp_out_start4','a.stmp_out_end4','a.stmp_out_user4','a.stmp_out_time4','a.stmp_out_leader_line4','a.stmp_out_kodematerial4',
                'a.stmp_out_uniqNo5', 'a.stmp_out_jobNo5', 'a.stmp_out_partNo5','a.stmp_out_model5', 'a.stmp_out_qty5', 'a.stmp_out_date5', 'a.stmp_out_start5','a.stmp_out_end5','a.stmp_out_user5','a.stmp_out_time5','a.stmp_out_leader_line5','a.stmp_out_kodematerial5'
            )
            ->leftJoin('users as b', 'b.id', '=', 'a.createdby')
            ->leftJoin('users as c', 'c.id', '=', 'a.updatedby')
            ->leftJoin('trace_proses2s as d', function ($join) use ($request) {
                $join
                     ->on('d.date_plan', '=', 'a.date_plan')
                     ->on('d.stmp_in_partNo', '=', 'a.part_no2');
            })
            ->where('a.date_plan', $request->date_plan)
            // ->where('a.uniqNo', $request->uniqNo)
            ->where('a.part_no2', $request->part_no2)
            ->get();

        return response()->json([
            'data' => $query
        ]);
    }


}

