<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanOutBlank extends Model
{
    use HasFactory;
    protected $fillable = [
        'part_no',
        'uniqNo',
        'spec',
        'kode_material',
        'qty_act',
        'line_id',
        'qty_out_material',
     
    ];
}
