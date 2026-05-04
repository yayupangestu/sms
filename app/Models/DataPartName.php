<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPartName extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_rak',
        'customer',
        'suplier',
        'job_no',
        'part_no',
        'part_no2',
        'part_name',
        'variant',
        'model',
        'spec',
        'spec_t',
        'spec_p',
        'spec_l',
        'spec_bq',
        'spec_kg',
        'pcs',
        'qty_palet',
        'qty_min',
        'lead_time',
        'home_line',
        'sts',
        'customer',
        'createdby',
        'updatedby',
        'category'
    ];
}
