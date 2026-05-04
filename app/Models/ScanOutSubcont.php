<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanOutSubcont extends Model
{
    use HasFactory;
    protected $fillable = [
        'uniqNo',
        'spec',
        'part_no',
        'qty_out_sheet',
        'qty_kg_sheet',
        'supplier',
        'created_at',
        // 'updatedby',
        // 'date_plan',
        // 'qty_stamping',
        // 'qty_column1',
        // 'qty_column2',
        // 'qty_return',
    ];
}
