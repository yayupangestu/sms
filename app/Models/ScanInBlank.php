<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanInBlank extends Model
{
    use HasFactory;
    protected $fillable = [
       'uniqNo',
        'spec',
        'part_no',
        'qty_out_sheet',
        'qty_kg_sheet',
        'supplier',
        'createdby',
        'updatedby',
        'date_plan',
        'qty_stamping',
        'qty_column1',
        'qty_column2',
        'qty_return',
    ];
}
