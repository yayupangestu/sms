<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanOutPcs extends Model
{
    use HasFactory;
    protected $fillable = [
        'uniq_no_outpcs1',
        'job_no_outpcs1',
        'part_no_outpcs1',
        'qty_outpcs1',
        'cycle_outpcs1',
        'area_outpcs1',
    ];
}
