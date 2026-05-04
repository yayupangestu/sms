<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanInLabel extends Model
{
    use HasFactory;
    protected $fillable = [
        'uniqNo',
        'spec',
        'part_no',
        'qty_in',
        'qty_kg',
        'supplier',
        'createdby',
        'updatedby',
        'sts_scan',
        'status',
        'out_user',
        'out_time',
        'actual_sheet',
        'actual_kg',
        'spek'
    ];
}

