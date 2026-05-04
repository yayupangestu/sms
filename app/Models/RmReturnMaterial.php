<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RmReturnMaterial extends Model
{
    use HasFactory;
    // App/Models/RmReturnMaterial.php
    protected $fillable = [
        'uniqNo', 
        'uniqNo2',
        'part_no', 
        'supplier',
        'spec',
        'sts',
        'qty_awal',
        'qty_return',
        'scan_by',
        'line_id',
    ];

}
