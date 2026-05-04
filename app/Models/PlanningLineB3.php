<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningLineB3 extends Model
{

    use HasFactory;

    protected $fillable = [
        'rm_uniqNo',
        'rm_partNo',
        'rm_spek',
        'rm_supplier',
        'rm_qty',
        'rm_user',
        'rm_time',
        'rm_uniqNo2',
        'rm_partNo2',
        'rm_spek2',
        'rm_supplier2',
        'rm_qty2',
        'rm_user2',
        'rm_time2',
        'rm_uniqNo3',
        'rm_partNo3',
        'rm_spek3',
        'rm_supplier3',
        'rm_qty3',
        'rm_user3',
        'rm_time3',
        'rm_uniqNo4',
        'rm_partNo4',
        'rm_spek4',
        'rm_supplier4',
        'rm_qty4',
        'rm_user4',
        'rm_time4',
        'qty_sisi',
        'proses',
        'category',
        'tanggal',
        'qty_out_material'

      
    ];

    // // Define the relationships
    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }

    // public function line()
    // {
    //     return $this->belongsTo(LineStmp::class, 'line_id');
    // }

    // public function spec()
    // {
    //     return $this->belongsTo(RmMaterial::class, 'spec_id');
    // }

    // public function partName()
    // {
    //     return $this->belongsTo(PartName::class, 'job_no');
    // }

    // public function model()
    // {
    //     return $this->belongsTo(DataModel::class, 'model_id');
    // }
}


   // public function alldata(){
        //     return DB::('planningline')->get();
        // }
